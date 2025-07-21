<?php

namespace App\Http\Controllers\Workpermit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workpermit\PurchaseOrder;
use App\Models\Workpermit\WorkPermit;
use App\Http\Requests\Workpermit\WorkpermitStep;
use App\Http\Services\Workpermit\WorkpermitService;
use App\Http\Services\Workpermit\WorkpermitStepService;
use App\Http\Services\Workpermit\WorkPermitApproveService;
use App\Http\Services\Workpermit\WorkpermitPembatalanService;
use App\Http\Services\Workpermit\WorkpermitPenyelesaianService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;

class WorkPermitController extends Controller
{
    protected $workpermitService;
    protected $workpermitStepService;
    protected $workpermitApproveService;
    protected $workpermitPembatalanService;
    protected $workpermitPenyelesaianService;

    public function __construct(
        WorkpermitService $workpermitService,
        WorkpermitStepService $workpermitStepService,
        WorkPermitApproveService $workpermitApproveService,
        WorkPermitPembatalanService $workpermitPembatalanService,
        WorkPermitPenyelesaianService $workpermitPenyelesaianService
    ) {
        $this->workpermitService = $workpermitService;
        $this->workpermitStepService = $workpermitStepService;
        $this->workpermitApproveService = $workpermitApproveService;
        $this->workpermitPembatalanService = $workpermitPembatalanService;
        $this->workpermitPenyelesaianService = $workpermitPenyelesaianService;
    }

    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('workpermit.workpermit.index', ['menus' => $menus]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $statusFilter = $request->input('status');

            $query = PurchaseOrder::with('vendor', 'pembatalan', 'workPermits.workSchedules.details')
                ->leftJoin('work_permits', 'purchase_orders.id', '=', 'work_permits.purchase_order_id')
                ->select('purchase_orders.*', 'work_permits.status as wp_status');

            if ($user->vendor_id) {
                $query->where('purchase_orders.vendor_id', $user->vendor_id);
            }

            $this->workpermitService->StatusFilter($query, $statusFilter, $user);

            try {
                $purchaseOrders = $query->get();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Terjadi kesalahan saat mengambil data PO.'], 500);
            }

            if ($request->input('count_only')) {
                $counts = $this->workpermitService->getStatusCounts($user);
                return response()->json($counts);
            }

            return DataTables::of($purchaseOrders)
                ->addIndexColumn()
                ->addColumn('vendor', fn($po) => $po->vendor->vendor_name ?? '-')
                ->addColumn('jenis_pekerjaan', fn($po) => $po->jenis_pekerjaan === 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan')
                ->addColumn('tanggal_mulai', fn($po) => \Carbon\Carbon::parse($po->tanggal_mulai)->format('d-m-Y'))
                ->addColumn('tanggal_akhir', fn($po) => \Carbon\Carbon::parse($po->tanggal_akhir)->format('d-m-Y'))
                ->addColumn('status', fn($po) => $this->workpermitService->getStatusBadge($po))
                ->addColumn('action', fn($po) => $this->workpermitService->getTombolAksi($po, $user))
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return response()->json(['error' => 'Invalid request.'], 400);
    }

    public function create($id)
    {
        $user = auth()->user();
        $poId = decodeId($id);

        $purchaseOrder = PurchaseOrder::findOrFail($poId);

        if ($user->vendor_id && $purchaseOrder->vendor_id !== $user->vendor_id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses PO ini.');
        }

        $menus = request()->get('dtmenus');

        $data = $this->workpermitService->getWorkPermitData($poId);

        $workPermit = $data['workPermit'];
        $workers = $data['workers'];
        $equipments = $data['equipments'];
        $jsaRecords = $data['jsaRecords'];
        $groupedJsaRecords = $data['groupedJsaRecords'];
        $selectedClassifications = $data['selectedClassifications'];
        $uniqueApd = $data['uniqueApd'];
        $uniqueEmergencyEquipments = $data['uniqueEmergencyEquipments'];

        if (!$workPermit) {
            $workPermit = new WorkPermit([
                'purchase_order_id' => $poId,
                'status' => 'draft',
            ]);
        } else {
            if (in_array($workPermit->status, ['submitted', 'approved', 'completed'])) {
                return redirect()->route('permit.po.progres', encodeId($poId))
                    ->with('error', 'Work Permit sudah diajukan, lihat progress di sini.');
            }
        }

        return view('workpermit.workpermit.create', compact(
            'purchaseOrder',
            'workPermit',
            'workers',
            'equipments',
            'selectedClassifications',
            'uniqueApd',
            'uniqueEmergencyEquipments',
            'jsaRecords',
            'groupedJsaRecords',
            'menus'
        ));
    }

    public function storeStep1(WorkpermitStep $request)
    {
        $workPermit = $this->workpermitStepService->storeStep1($request);

        session(['work_permit_id' => $workPermit->id]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan.',
            'work_permit_id' => $workPermit->id,
        ]);
    }

    public function storeStep2(WorkpermitStep $request)
    {
        $validated = $request->validated();
        $workPermitId = $this->workpermitStepService->storeStep2($validated, $request);

        return response()->json([
            'success' => true,
            'message' => 'Data pekerja berhasil disimpan.',
            'work_permit_id' => $workPermitId,
        ]);
    }

    public function storeStep3(WorkpermitStep $request)
    {
        $validated = $request->validated();
        $workPermitId = $this->workpermitStepService->storeStep3($validated, $request);

        return response()->json([
            'success' => true,
            'message' => 'Data perlengkapan kerja berhasil disimpan.',
            'work_permit_id' => $workPermitId,
        ]);
    }

    public function storeStep4(WorkpermitStep $request)
    {
        $validated = $request->validated();
        $workPermit = WorkPermit::findOrFail($validated['work_permit_id']);

        $this->workpermitStepService->storeStep4($validated, $workPermit);

        return response()->json([
            'success' => true,
            'message' => 'Workpermit berhasil diajukan.',
            'url' => route('permit.po.index')
        ]);
    }

    public function progres($id)
    {
        $poId = decodeId($id);
        $menus = request()->get('dtmenus');

        $data = $this->workpermitService->getWorkPermitData($poId);

        if (!$data['workPermit'] || $data['workPermit']->status === 'draft') {
            return redirect()->route('permit.po.create', encodeId($poId))
                ->with('error', 'Silahkan lengkapi dulu form pengajuan Work Permit.');
        }

        $workPermit = $data['workPermit'];
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name');

        $isPembatalan = $workPermit->pembatalan && in_array($workPermit->pembatalan->status, ['diajukan', 'disetujui', 'ditolak']);
        $isPenyelesaian = $workPermit->purchaseOrder?->pengajuanPenyelesaian;
        $isPengajuan = !$isPembatalan && !$isPenyelesaian;

        if ($workPermit->status === 'selesai') {
            return redirect()->route('permit.po.create', encodeId($poId))
                ->with('error', 'Work permit ini sudah selesai.');
        }

        if ($isPembatalan) {
            $approvalData = $this->workpermitPembatalanService->getApprovalDataPembatalan($workPermit->pembatalan);
        } elseif ($isPenyelesaian) {
            $approvalData = $this->workpermitPenyelesaianService->getApprovalDataPenyelesaian($isPenyelesaian);
        } else {
            $approvalData = $this->workpermitService->getApprovalData($workPermit);
        }

        $currentUserPermission = $this->workpermitService->getCurrentUserPermission($approvalData, $userPermissions);
        $isCurrentReviewer = $this->workpermitService->isCurrentReviewer($approvalData, $currentUserPermission);

        $approvalPengajuan = $this->workpermitService->getApprovalData($workPermit);

        $approvalPenyelesaian = $isPenyelesaian
            ? $this->workpermitPenyelesaianService->getApprovalDataPenyelesaian($isPenyelesaian)
            : collect();

        $approvalPembatalan = $isPembatalan
            ? $this->workpermitPembatalanService->getApprovalDataPembatalan($workPermit->pembatalan)
            : collect();

        return view('workpermit.workpermit.detail', array_merge($data, [
            'approvalPengajuan' => $approvalPengajuan,
            'approvalPenyelesaian' => $approvalPenyelesaian,
            'approvalPembatalan' => $approvalPembatalan,
            'currentUserPermission' => $currentUserPermission,
            'isCurrentReviewer' => $isCurrentReviewer,
            'isPembatalan' => $isPembatalan,
            'isPenyelesaian' => $isPenyelesaian,
            'isPengajuan' => $isPengajuan,
            'menus' => $menus,
        ]));
    }

    public function approve($id, Request $request)
    {
        $workPermit = WorkPermit::findOrFail($id);
        $user = auth()->user();

        return $this->workpermitApproveService->approveWorkPermit($workPermit, $user, $request);
    }

    public function reject(Request $request, $id)
    {
        $workPermit = WorkPermit::findOrFail($id);
        $user = auth()->user();

        return app(WorkPermitApproveService::class)->rejectWorkPermit($workPermit, $user, $request);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->vendor_id) {
            return response()->json(['message' => 'Vendor tidak diizinkan mengajukan pembatalan.'], 403);
        }

        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'alasan' => 'required|string|max:1000',
        ]);

        return (new WorkpermitPembatalanService())->ajukanPembatalan($request, $user);
    }

    public function approvePembatalan($id, Request $request)
    {
        $user = auth()->user();

        return (new WorkpermitPembatalanService())->approvePembatalan($id, $user, $request);
    }

    public function rejectPembatalan($id, Request $request)
    {
        $user = auth()->user();

        return (new WorkpermitPembatalanService())->rejectPembatalan($id, $user, $request);
    }

    public function previewPdf($id)
    {
        $data = $this->workpermitService->getPreviewData($id);

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $html = view('workpermit.workpermit.print', $data)->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('Letter', 'potrait');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="workpermit_preview.pdf"');
    }

    public function ajukan(Request $request, $encodedId)
    {
        $poId = decodeId($encodedId);
        $result = $this->workpermitPenyelesaianService->ajukan($poId);

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function approveSelesai(Request $request, $id)
    {
        $result = $this->workpermitPenyelesaianService->approveSelesai($id, auth()->user(), $request);
        return response()->json($result);
    }

    public function printAllPeriode($encodedId)
    {
        $workPermitId = decodeId($encodedId);

        $workPermit = WorkPermit::with([
            'purchaseOrder',
            'workSchedules.details',
            'workSchedules.hseMonthlyReport'
        ])->findOrFail($workPermitId);

        $schedules = $workPermit->workSchedules;
        $hse = $schedules->first()->hseMonthlyReport ?? null;

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->setIsRemoteEnabled(true);
        $pdf = new Dompdf($options);

        $html = view('workpermit.workpermit.print_all_periode', compact('workPermit', 'schedules', 'hse'))->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan_jamkerja_hse_' . $workPermit->id . '.pdf"');
    }
}
