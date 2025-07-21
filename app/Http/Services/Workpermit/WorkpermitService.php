<?php

namespace App\Http\Services\Workpermit;

use App\Models\Workpermit\{PurchaseOrder, WorkPermit, WorkPermitJsa, WorkPermitWorker, WorkPermitEquipment, WorkPermitApprovalLevel, ApprovalPenyelesaian, ApprovalPembatalan, PengajuanPembatalan, PengajuanPenyelesaian};
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

class WorkpermitService
{

    protected $statusMap = [
        'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
        'approved' => '<span class="badge bg-success">Disetujui / Aktif</span>',
        'rejected' => '<span class="badge bg-danger">Ditolak</span>',
        'draft' => '<span class="badge bg-secondary">Draft</span>',
        'submitted' => '<span class="badge bg-primary">Diajukan</span>',
        'active' => '<span class="badge bg-success">Aktif</span>',
        'completed' => '<span class="badge bg-success">Selesai</span>',
    ];

    protected $buttonMap = [
        'draft' => 'Ajukan Work Permit',
        'rejected' => 'Revisi Work Permit',
        'submitted' => 'Lihat Progress',
        'approved' => 'Selesaikan Pekerjaan',
    ];

    public function getStatusCounts($user)
    {
        $baseQuery = PurchaseOrder::leftJoin('work_permits', 'purchase_orders.id', '=', 'work_permits.purchase_order_id');

        if ($user->vendor_id) {
            $baseQuery->where('purchase_orders.vendor_id', $user->vendor_id);
        }

        $statusList = ['draft', 'submitted', 'approved', 'rejected', 'cancelled', 'completed'];

        $counts = [];
        foreach ($statusList as $status) {
            $counts[$status] = tap(clone $baseQuery, function ($q) use ($status, $user) {
                $this->StatusFilter($q, $status, $user);
            })->count();
        }

        return $counts;
    }

    public function StatusFilter($query, $statusFilter)
    {
        $statusFilterMapping = [
            'approved' => fn($q) => $q->where('work_permits.status', 'approved')
                ->whereNotIn('purchase_orders.status', ['cancelled', 'completed']),
            'rejected' => fn($q) => $q->where('work_permits.status', 'rejected'),
            'cancelled' => fn($q) => $q->where('purchase_orders.status', 'cancelled'),
            'completed' => fn($q) => $q->where('purchase_orders.status', 'completed'),
        ];

        if (array_key_exists($statusFilter, $statusFilterMapping)) {
            $statusFilterMapping[$statusFilter]($query);
        } else {
            $query->where('purchase_orders.status', $statusFilter)
                ->where(function ($q) {
                    $q->whereNull('work_permits.status')
                        ->orWhere('work_permits.status', '!=', 'rejected');
                })
                ->where('purchase_orders.status', '!=', 'completed');
        }
    }

    public function getStatusBadge($po)
    {
        $statusBadge = match (true) {
            $po->status === 'cancelled' => $this->statusMap['cancelled'],
            $po->status === 'completed' => $this->statusMap['completed'],
            $po->wp_status === 'rejected' => $this->statusMap['rejected'],
            $po->wp_status === 'approved' => $this->statusMap['approved'],
            default => $this->statusMap[$po->status] ?? '<span class="badge bg-secondary">Unknown</span>',
        };

        // Badge pembatalan
        $hasPendingPembatalan = $po->pembatalan && $po->pembatalan->where('status', '!=', 'ditolak')->count() > 0;
        if ($hasPendingPembatalan && $po->status !== 'cancelled') {
            $statusBadge .= '<span class="badge bg-warning mt-1">Sedang Diajukan Pembatalan</span>';
        }

        // Badge penyelesaian
        $isPengajuanPenyelesaian = $po->pengajuanPenyelesaian && $po->pengajuanPenyelesaian->status === 'draft';
        if ($isPengajuanPenyelesaian && $po->status !== 'completed') {
            $statusBadge .= '<span class="badge bg-info mt-1">Sedang Diajukan Penyelesaian</span>';
        }

        return $statusBadge;
    }

    public function getTombolAksi($po, $user)
    {
        if ($po->status === 'cancelled' && $po->workPermits->isEmpty()) {
            return '<span class="text-muted small">PO Dibatalkan</span>';
        }

        $isVendor = $user->vendor_id !== null;
        $items = [];

        $encodedId = encodeId($po->id);
        $ajukanUrl = route('permit.po.create', $encodedId);
        $progressUrl = route('permit.po.progres', $encodedId);

        // Ajukan / Revisi
        if ($isVendor && $po->wp_status === 'rejected') {
            $items[] = '
        <li>
            <a class="dropdown-item d-flex align-items-center" href="' . $ajukanUrl . '">
                <i class="fas fa-redo me-2 text-warning"></i> Revisi Work Permit
            </a>
        </li>';
        }

        if ($isVendor && $po->status === 'draft') {
            $items[] = '
        <li>
            <a class="dropdown-item d-flex align-items-center" href="' . $ajukanUrl . '">
                <i class="fas fa-paper-plane me-2 text-primary"></i> Ajukan Work Permit
            </a>
        </li>';
        }

        // Lihat Progress
        if ($po->status !== 'draft') {
            $items[] = '
        <li>
            <a class="dropdown-item d-flex align-items-center" href="' . $progressUrl . '">
                <i class="fas fa-eye me-2 text-primary"></i> Lihat Progress
            </a>
        </li>';

            if ($isVendor) {
                $aksiSelesai = $this->getAksiSelesai($po, $user, true);
                if ($aksiSelesai) {
                    $items[] = '<li>' . $aksiSelesai . '</li>';
                }
            }

            // Lihat / Download PDF
            if ($po->workPermits->isNotEmpty()) {
                $pdfUrl = route('permit.workpermit.previewPdf', ['id' => $po->workPermits->first()->id]);
                $items[] = '
            <li>
                <a class="dropdown-item d-flex align-items-center" target="_blank" href="' . $pdfUrl . '">
                    <i class="fas fa-file-pdf me-2 text-danger"></i> Lihat / Download PDF
                </a>
            </li>';
            }
        }

        // Ajukan Pembatalan
        if (
            !$isVendor &&
            $po->wp_status === 'approved' &&
            $po->status !== 'completed' &&
            !$this->sudahAjukanPembatalan($po) &&
            !$this->sudahAjukanPenyelesaian($po) &&
            $this->isApproverLevel3($user, 'approval-she_officer')
        ) {
            $items[] = '<li>' . $this->getTombolAjukanPembatalan($po, true) . '</li>';
        }

        // Download Laporan
        if ($po->status === 'completed' && $po->workPermits->isNotEmpty()) {
            $workPermitId = encodeId($po->workPermits->first()->id);
            $items[] = '
        <li>
            <a class="dropdown-item d-flex align-items-center" target="_blank" href="' . route('workpermit.printAllPeriode', ['encodedId' => $workPermitId]) . '">
                <i class="fas fa-file-download me-2 text-success"></i> Download Laporan
            </a>
        </li>';
        }

        if (empty($items)) return '';

        return '
    <div class="dropdown text-center">
        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            ' . implode('', $items) . '
        </ul>
    </div>';
    }


    protected function isApproverLevel3($user, $permissionName): bool
    {
        return $user->can($permissionName) &&
            \DB::table('work_permit_approval_levels')
            ->where('permission_name', $permissionName)
            ->where('level', 3)
            ->exists();
    }

    protected function sudahAjukanPembatalan($po)
    {
        return $po->pembatalan && $po->pembatalan->where('status', '!=', 'ditolak')->count() > 0;
    }

    protected function getTombolAjukanPembatalan($po, $asDropdown = false)
    {
        if ($asDropdown) {
            return '
            <button
                class="dropdown-item d-flex align-items-center ajukanPembatalanBtn"
                data-id="' . $po->id . '"
                data-no_po="' . e($po->no_po) . '"
                data-nama="' . e($po->nama_pekerjaan) . '"
                data-vendor="' . e($po->vendor->vendor_name) . '"
                data-mulai="' . e($po->tanggal_mulai) . '"
                data-akhir="' . e($po->tanggal_akhir) . '"
            >
                <i class="fas fa-ban me-2 text-danger"></i> Ajukan Pembatalan
            </button>';
        }

        return '
        <button
            class="btn btn-sm btn-danger ajukanPembatalanBtn"
            data-id="' . $po->id . '"
            data-no_po="' . e($po->no_po) . '"
            data-nama="' . e($po->nama_pekerjaan) . '"
            data-vendor="' . e($po->vendor->vendor_name) . '"
            data-mulai="' . e($po->tanggal_mulai) . '"
            data-akhir="' . e($po->tanggal_akhir) . '"
        >
            Ajukan Pembatalan
        </button>';
    }

    protected function generateButton($po, $url, $label)
    {
        return "<a href=\"{$url}\" class=\"btn btn-sm btn-primary mb-1\">{$label}</a>";
    }

    public function getAksiSelesai($po, $user, $asDropdown = false)
    {
        if ($this->sudahAjukanPembatalan($po)) return '';

        $isWorkScheduleComplete = $this->isWorkScheduleComplete($po);
        $isVendor = optional($user->vendor)->id === $po->vendor_id;
        $notCancelledOrCompleted = $po->status !== 'cancelled' && $po->status !== 'completed';
        $isWpApproved = $po->wp_status === 'approved';
        $alreadySubmittedPenyelesaian = $this->sudahAjukanPenyelesaian($po);
        $allApprovalPenyelesaianOk = $po->pengajuanPenyelesaian
            ? $po->pengajuanPenyelesaian->approvals->every(fn($a) => $a->status === 'selesai')
            : true;

        $urlSelesai = route('permit.po.selesai', encodeId($po->id));

        if (
            $isWorkScheduleComplete &&
            $isVendor &&
            $notCancelledOrCompleted &&
            $isWpApproved &&
            !$alreadySubmittedPenyelesaian &&
            $allApprovalPenyelesaianOk
        ) {
            return $asDropdown
                ? '<button class="dropdown-item d-flex align-items-center btnSelesaikan" data-url="' . $urlSelesai . '">
                    <i class="fas fa-check-circle me-2 text-success"></i> Selesaikan Pekerjaan
               </button>'
                : '<button class="btn btn-sm btn-success btnSelesaikan" data-url="' . $urlSelesai . '">Selesaikan Pekerjaan</button>';
        }

        if (
            $isVendor &&
            !$alreadySubmittedPenyelesaian &&
            $notCancelledOrCompleted &&
            $isWorkScheduleComplete
        ) {
            return $asDropdown
                ? '<button class="dropdown-item d-flex align-items-center btnSelesaikan" data-url="' . $urlSelesai . '">
                    <i class="fas fa-hourglass-half me-2 text-warning"></i> Selesaikan Pekerjaan
               </button>'
                : '<button class="btn btn-sm btn-warning btnSelesaikan" data-url="' . $urlSelesai . '">Selesaikan Pekerjaan</button>';
        }

        return '';
    }

    protected function sudahAjukanPenyelesaian($po)
    {
        return $po->pengajuanPenyelesaian
            && in_array($po->pengajuanPenyelesaian->status, ['draft', 'selesai']);
    }

    protected function isWorkScheduleComplete($po)
    {
        if ($po->workPermits->isEmpty()) {
            return false;
        }

        return $po->workPermits->every(function ($workPermit) {
            if ($workPermit->workSchedules->isEmpty()) {
                return false;
            }
            return $workPermit->workSchedules->every(
                fn($schedule) =>
                $schedule->details->every(
                    fn($detail) =>
                    !is_null($detail->jam_kerja)
                )
            );
        });
    }

    public function getWorkPermitData($poId)
    {
        $purchaseOrder = PurchaseOrder::with([
            'vendor',
            'jobClassifications.safetyEquipments',
            'jobClassifications.emergencyEquipments'
        ])->findOrFail($poId);

        $workPermit = WorkPermit::with('workers.workerDetails')
            ->where('purchase_order_id', $poId)->first();

        $classificationsAndEquipments = $this->getClassificationsAndEquipments($purchaseOrder);
        $workers = $workPermit ? $workPermit->workers->load('workerDetails') : collect();
        $equipmentsAndJsa = $this->getEquipmentsAndJsa($workPermit);

        return [
            'purchaseOrder' => $purchaseOrder,
            'workPermit' => $workPermit,
            'workers' => $workers,
            'selectedClassifications' => $classificationsAndEquipments['selectedClassifications'],
            'uniqueApd' => $classificationsAndEquipments['uniqueApd'],
            'uniqueEmergencyEquipments' => $classificationsAndEquipments['uniqueEmergencyEquipments'],
            'equipments' => $equipmentsAndJsa['equipments'],
            'jsaRecords' => $equipmentsAndJsa['jsaRecords'],
            'groupedEquipments' => $equipmentsAndJsa['groupedEquipments'],
            'groupedJsaRecords' => $equipmentsAndJsa['groupedJsaRecords'],
        ];
    }

    public function getEquipmentsAndJsa($workPermit)
    {
        if (!$workPermit) {
            return [
                'equipments' => collect(),
                'jsaRecords' => collect(),
                'groupedEquipments' => collect(),
                'groupedJsaRecords' => collect(),
            ];
        }

        $equipments = WorkPermitEquipment::where('work_permit_id', $workPermit->id)->get()->groupBy('kategori');

        $jsaRecords = WorkPermitJsa::with('subTahapan')
            ->where('work_permit_id', $workPermit->id)
            ->get();

        $groupedEquipments = $equipments->mapWithKeys(function ($items, $key) {
            return [$key => $items->groupBy('sub_kategori')];
        });

        $groupedJsaRecords = $jsaRecords->groupBy('tahapan');

        return compact('equipments', 'jsaRecords', 'groupedEquipments', 'groupedJsaRecords');
    }

    public function getClassificationsAndEquipments($purchaseOrder)
    {
        $allApd = $purchaseOrder->jobClassifications->pluck('safetyEquipments')->flatten()->where('type', 'apd');
        $allEmergencyEquipments = $purchaseOrder->jobClassifications->pluck('emergencyEquipments')->flatten();
        return [
            'selectedClassifications' => $purchaseOrder->jobClassifications->pluck('name'),
            'uniqueApd' => $allApd->unique('id'),
            'uniqueEmergencyEquipments' => $allEmergencyEquipments->unique('id')
        ];
    }

    public function getWorkers($workPermit)
    {
        return WorkPermitWorker::with('workerDetails')->where('work_permit_id', $workPermit->id)->get();
    }

    public function getApprovalData($workPermit)
    {
        return WorkPermitApprovalLevel::orderBy('level')->get()->map(fn($level) => (object)[
            'permission_name' => $level->permission_name,
            'level' => $level->level,
            'approval' => $workPermit->approvals->where('permission_name', $level->permission_name)->first(),
        ]);
    }

    public function getCurrentUserPermission($approvalData, $userPermissions)
    {
        return collect($approvalData)->first(fn($lvl) => $userPermissions->contains($lvl->permission_name))->permission_name ?? null;
    }

    public function isCurrentReviewer($approvalData, $currentUserPermission)
    {
        foreach ($approvalData as $index => $step) {
            if ($step->permission_name === $currentUserPermission) {
                $prevApproved = $index === 0 || optional($approvalData[$index - 1]->approval)->status === 'approved';
                if ($prevApproved && (!$step->approval || $step->approval->status === 'pending')) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getPreviewData($workPermitId)
    {
        $workPermit = WorkPermit::with([
            'approvals',
            'purchaseOrder.vendor',
            'purchaseOrder.jobClassifications.safetyEquipments',
            'purchaseOrder.jobClassifications.emergencyEquipments',
            'equipment',
        ])->findOrFail($workPermitId);
        $purchaseOrder = $workPermit->purchaseOrder;
        $approvalLevels = $this->getApprovalData($workPermit)->map(function ($level) {
            return (object)[
                'permission_name' => $level->permission_name,
                'label' => match ($level->permission_name) {
                    'approval-pengawas' => 'Pengawas',
                    'approval-area' => 'Pemilik Area',
                    'approval-she_manager' => 'SHE Manager',
                    'approval-she_officer' => 'SHE Officer',
                    default => Str::title(str_replace(['approval-', '-'], ['', ' '], $level->permission_name)),
                },
            ];
        });

        $qrCodes = $approvalLevels->mapWithKeys(function ($level) use ($workPermit) {
            if ($level->permission_name === 'approval-she_officer') {
                return [];
            }

            $encodedId = base64_encode($workPermit->id);
            $qrContent = route("permit.po.progres", ['id' => $encodedId]);

            $qrCode = new QrCode($qrContent);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            return [$level->label => base64_encode($result->getString())];
        });

        $pengajuanPembatalan = PengajuanPembatalan::where('purchase_order_id', $workPermit->purchase_order_id)->first();
        $approvalPembatalan = collect();
        if ($pengajuanPembatalan) {
            $approvalPembatalan = ApprovalPembatalan::where('pengajuan_pembatalan_id', $pengajuanPembatalan->id)->get();
        }

        $pengajuanPenyelesaian = PengajuanPenyelesaian::where('purchase_order_id', $workPermit->purchase_order_id)->first();

        $approvalPenyelesaian = collect();
        if ($pengajuanPenyelesaian) {
            $approvalPenyelesaian = ApprovalPenyelesaian::where('pengajuan_penyelesaian_id', $pengajuanPenyelesaian->id)->get();
        }

        $klasifikasiPekerjaan = $purchaseOrder->jobClassifications->pluck('name');
        $uniqueApd = $purchaseOrder->jobClassifications->flatMap(fn($jc) => $jc->safetyEquipments->where('type', 'apd'))->unique('id');
        $uniqueEmergencyEquipments = $purchaseOrder->jobClassifications->flatMap(fn($jc) => $jc->emergencyEquipments)->unique('id');
        $groupedEquipments = WorkPermitEquipment::where('work_permit_id', $workPermit->id)->get()->groupBy('kategori');

        $logoBase64 = null;
        $logoPath = public_path('logo.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $tglRilis = $workPermit->approvals
            ->where('approved_at', '!=', null)
            ->sortByDesc('approved_at')
            ->first()
            ?->approved_at;

        return compact(
            'workPermit',
            'purchaseOrder',
            'approvalLevels',
            'qrCodes',
            'klasifikasiPekerjaan',
            'uniqueApd',
            'uniqueEmergencyEquipments',
            'groupedEquipments',
            'logoBase64',
            'tglRilis',
            'pengajuanPembatalan',
            'approvalPembatalan',
            'approvalPenyelesaian',
            'pengajuanPenyelesaian'
        );
    }
}
