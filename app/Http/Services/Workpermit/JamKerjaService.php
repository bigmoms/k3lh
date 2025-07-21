<?php

namespace App\Http\Services\Workpermit;

use App\Models\Workpermit\PurchaseOrder;
use App\Models\Workpermit\HseMonthlyReport;
use App\Models\Workpermit\WorkSchedule;
use App\Models\Workpermit\WorkScheduleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Workpermit\WorkScheduleStoreRequest;
use Carbon\Carbon;
use App\Mail\JamKerjaApproved;
use App\Mail\JamKerjaRejected;
use Illuminate\Support\Facades\Mail;

class JamKerjaService
{
    private function baseQuery()
    {
        return PurchaseOrder::whereHas('workPermits', function ($q) {
            $q->where('status', 'approved');
        });
    }

    public function getListPo()
    {
        $user = Auth::user();
        $query = $this->baseQuery()->select('id', 'no_po', 'tanggal_mulai', 'tanggal_akhir');

        if ($user->vendor_id) {
            return $query->where('vendor_id', $user->vendor_id)->get();
        }

        return $query->get();
    }

    public function getFilter($request, $user)
    {
        $query = $this->baseQuery()
            ->with('vendor')
            ->select('id', 'vendor_id', 'no_po', 'nama_pekerjaan', 'lokasi_pekerjaan', 'tanggal_mulai', 'tanggal_akhir', 'status')
            ->where('status', '!=', 'canceled');

        if ($request->filled('no_po')) {
            $query->where('no_po', $request->get('no_po'));
        }

        if ($user->vendor_id) {
            $query->where('vendor_id', $user->vendor_id);
        }

        return $query->get();
    }

    public function getStatusBadge($exists, $schedule, $isCancelled, $today, $end)
    {
        if (!$exists && $today->greaterThan($end)) {
            return '<span class="badge bg-danger">Terlambat</span>';
        }

        if ($isCancelled && !$exists) {
            return '<span class="badge bg-secondary">Dibatalkan</span>';
        }

        return $exists
            ? '<span class="badge bg-success">Sudah Diisi</span>'
            : '<span class="badge bg-warning">Belum Diisi</span>';
    }

    public function prosesLaporan($po, $workPermit, $start, $end, $today, $user)
    {
        $usedScheduleIds = [];
        $result = [];
        $allSchedules = $workPermit->workSchedules()->get();
        $bulanKe = 1;

        while ($start <= $end) {
            if ($start->greaterThan($today)) break;

            $isCancelled = $po->status === 'cancelled';

            $schedule = $allSchedules->first(function ($item) use ($start, &$usedScheduleIds) {
                if (in_array($item->id, $usedScheduleIds)) return false;

                $periode = explode(' s/d ', $item->periode_laporan);
                if (count($periode) !== 2) return false;

                $startPeriode = Carbon::parse($periode[0])->startOfDay();
                $endPeriode = Carbon::parse($periode[1])->endOfDay();
                $monthStart = $start->copy()->startOfMonth();
                $monthEnd = $start->copy()->endOfMonth();

                return $startPeriode->lessThanOrEqualTo($monthEnd) && $endPeriode->greaterThanOrEqualTo($monthStart);
            });

            if ($schedule) {
                $usedScheduleIds[] = $schedule->id;
            }

            $exists = $schedule ? $schedule->details()->exists() : false;
            $status = $this->getStatusBadge($exists, $schedule, $isCancelled, $today, $end);

            $btn = $this->getAksiButton($schedule, $user, $po, $workPermit, $start);

            $result[] = [
                'vendor_name'      => $po->vendor->vendor_name ?? '-',
                'no_po'            => $po->no_po,
                'nama_pekerjaan'   => $po->nama_pekerjaan,
                'lokasi_pekerjaan' => $po->lokasi_pekerjaan,
                'periode' => $schedule
                    ? $this->formatPeriode($schedule->periode_laporan)
                    : 'Bulan ' . $bulanKe,

                'status'           => $status,
                'approval_status'  => $exists
                    ? match ($schedule->status_approve_she) {
                        'approved' => '<span class="badge bg-primary">Approved</span>',
                        'rejected' => '<span class="badge bg-danger">Rejected</span>',
                        default    => '<span class="badge bg-warning">Pending</span>',
                    }
                    : '<span class="text-muted">-</span>',
                'action' => $btn,
            ];

            $start->addMonth();
            $bulanKe++;
        }

        return $result;
    }

    protected function formatPeriode($periodeString)
    {
        $periode = explode(' s/d ', $periodeString);

        if (count($periode) !== 2) {
            return $periodeString;
        }

        try {
            $start = Carbon::parse($periode[0])->translatedFormat('j M Y');
            $end = Carbon::parse($periode[1])->translatedFormat('j M Y');

            return $start . ' s/d ' . $end;
        } catch (\Exception $e) {
            return $periodeString;
        }
    }

    public function getAksiButton($schedule, $user, $po, $workPermit, $start)
    {
        $isCancelled = $po->status === 'cancelled';

        if (!$schedule) {
            if ($user->vendor_id) {
                if ($isCancelled) {
                    return '<span class="text-muted badge bg-danger">Pekerjaan telah dibatalkan</span>';
                } else {
                    $isiUrl = route('permit.jamkerja.create', [
                        'id'    => encodeId($workPermit->id),
                        'start' => $po->tanggal_mulai,
                        'end'   => $po->tanggal_akhir,
                    ]);
                    return '<a href="' . $isiUrl . '" class="btn btn-sm btn-primary">Isi</a>';
                }
            }
            return '<span class="text-muted">-</span>';
        }

        $detailUrl = route('permit.jamkerja.detail', [
            'id'      => encodeId($workPermit->id),
            'periode' => $start->format('Y-m'),
        ]);

        $periodeLaporan = substr($schedule->periode_laporan, 0, 7);
        $previewUrl = route('permit.jamkerja.preview', [
            'id' => encodeId($workPermit->id),
            'periode' => $periodeLaporan,
        ]);

        $dropdown = '
    <div class="dropdown text-center">
        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $detailUrl . '">
                    <i class="fas fa-eye me-2 text-primary"></i> Lihat Detail
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $previewUrl . '" target="_blank">
                    <i class="fas fa-file-pdf me-2 text-danger"></i> Preview PDF
                </a>
            </li>';

        if ($user->vendor_id && $schedule->status_approve_she === 'rejected') {
            $revisiUrl = route('permit.jamkerja.create', [
                'id'    => encodeId($workPermit->id),
                'start' => $po->tanggal_mulai,
                'end'   => $po->tanggal_akhir,
            ]);

            $dropdown .= '
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $revisiUrl . '">
                    <i class="fas fa-pen me-2 text-warning"></i> Revisi
                </a>
            </li>';
        }

        $dropdown .= '</ul></div>';

        return $dropdown;
    }

    public function store(WorkScheduleStoreRequest $request): WorkSchedule
    {
        $periode = explode(' to ', $request->periode);
        $periodeLaporan = $periode[0] . ' s/d ' . $periode[1];

        $existing = WorkSchedule::where('work_permit_id', $request->work_permit_id)
            ->where('periode_laporan', 'like', '%' . $periode[0] . '%')
            ->where('status_approve_she', 'rejected')
            ->first();

        if ($existing) {
            $existing->details()->delete();
            $existing->hseMonthlyReport()->delete();
            $existing->delete();
        }

        $workSchedule = WorkSchedule::create([
            'work_permit_id'  => $request->work_permit_id,
            'periode_laporan' => $periodeLaporan,
            'project_manager' => $request->project_manager,
        ]);

        if ($request->hasFile('lampiran_induction')) {
            $file = $request->file('lampiran_induction');
            $path = $file->store('lampiran_induction', 'public');
            $workSchedule->lampiran_induction = $path;
            $workSchedule->save();
        }

        $this->storeDetails($workSchedule, $request);
        $this->storeHseReport($workSchedule, $request);

        return $workSchedule;
    }

    protected function storeDetails(WorkSchedule $workSchedule, Request $request): void
    {
        foreach ($request->tanggal as $i => $tanggal) {
            $jumlah_pekerja = $request->b[$i] ?? 0;
            $jam_kerja = $request->c[$i] ?? 8;
            $jumlah_jam_kerja_nyata = $jumlah_pekerja * $jam_kerja;
            $jumlah_pekerja_lembur = $request->e[$i] ?? 0;
            $jam_lembur = $request->f[$i] ?? 0;
            $jumlah_jam_lembur = $jumlah_pekerja_lembur * $jam_lembur;
            $jumlah_jam_kerja_real = $jumlah_jam_kerja_nyata + $jumlah_jam_lembur;
            $cuti = $request->i[$i] ?? 0;
            $ijin = $request->j[$i] ?? 0;
            $sakit = $request->k[$i] ?? 0;
            $alpha = $request->l[$i] ?? 0;
            $kehilangan_jam_kerja = ($cuti + $ijin + $sakit + $alpha);
            $jumlah_total_jam_kerja_aman = $jumlah_jam_kerja_real - $kehilangan_jam_kerja;

            WorkScheduleDetail::create([
                'work_schedule_id' => $workSchedule->id,
                'tanggal' => $tanggal,
                'jumlah_pekerja' => $jumlah_pekerja,
                'jam_kerja' => $jam_kerja,
                'jumlah_jam_kerja_nyata' => $jumlah_jam_kerja_nyata,
                'jumlah_pekerja_lembur' => $jumlah_pekerja_lembur,
                'jam_lembur' => $jam_lembur,
                'jumlah_jam_lembur' => $jumlah_jam_lembur,
                'jumlah_jam_kerja_real' => $jumlah_jam_kerja_real,
                'cuti' => $cuti,
                'ijin' => $ijin,
                'sakit' => $sakit,
                'alpha' => $alpha,
                'kehilangan_jam_kerja' => $kehilangan_jam_kerja,
                'jumlah_total_jam_kerja_aman' => $jumlah_total_jam_kerja_aman,
            ]);
        }
    }

    protected function safeText($input): string
    {
        if (is_array($input)) {
            return implode("\n", array_filter($input));
        }
        return (string) $input;
    }

    protected function storeHseReport(WorkSchedule $workSchedule, Request $request): void
    {
        $hseReport = new HseMonthlyReport();
        $hseReport->work_schedule_id = $workSchedule->id;

        $lalu = $request->input('statistik_lalu', []);
        $sekarang = $request->input('statistik_sekarang', []);
        $hseReport->hari_kerja_bulan_lalu = $lalu[0] ?? 0;
        $hseReport->manhours_lembur_bulan_lalu = $lalu[1] ?? 0;
        $hseReport->hari_kerja_bulan_ini = $sekarang[0] ?? 0;
        $hseReport->manhours_lembur_bulan_ini = $sekarang[1] ?? 0;

        $hseReport->hari_kerja_total = $hseReport->hari_kerja_bulan_lalu + $hseReport->hari_kerja_bulan_ini;
        $hseReport->manhours_lembur_total = $hseReport->manhours_lembur_bulan_lalu + $hseReport->manhours_lembur_bulan_ini;

        $hseReport->pekerja_kontraktor_utama = $request->input('jumlah_pekerja.utama', 0);
        $hseReport->pekerja_subkon = $request->input('jumlah_pekerja.subkon', 0);
        $hseReport->total_pekerja = $hseReport->pekerja_kontraktor_utama + $hseReport->pekerja_subkon;

        $tim = $request->input('tim_hse', []);
        foreach (
            [
                'hse_manager',
                'hse_coordinator',
                'hse_supervisor',
                'safety_engineer',
                'safety_officer',
                'safety_inspector',
                'safety_administration',
                'safety_man',
                'paramedis'
            ] as $role
        ) {
            $hseReport->$role = $tim[$role] ?? 0;
        }

        $laporan = $request->input('laporan', []);
        $kolomLaporan = [
            1 => ['kasus_insiden_bulan_ini', 'kasus_insiden_total'],
            2 => ['fatality_bulan_ini', 'fatality_total'],
            3 => ['disability_bulan_ini', 'disability_total'],
            4 => ['medical_bulan_ini', 'medical_total'],
            5 => ['first_aid_bulan_ini', 'first_aid_total'],
            6 => ['property_damage_bulan_ini', 'property_damage_total'],
            7 => ['traffic_accident_bulan_ini', 'traffic_accident_total'],
            8 => ['near_miss_bulan_ini', 'near_miss_total'],
            9 => ['lost_time_bulan_ini', 'lost_time_total'],
            10 => ['kasus_penyakit_bulan_ini', 'kasus_penyakit_total'],
            11 => ['penyakit_kerja_bulan_ini', 'penyakit_kerja_total'],
            12 => ['penyakit_hubungan_kerja_bulan_ini', 'penyakit_hubungan_kerja_total'],
            13 => ['penyakit_biasa_bulan_ini', 'penyakit_biasa_total'],
            14 => ['lost_time_penyakit_bulan_ini', 'lost_time_penyakit_total'],
            15 => ['kasus_pencemaran_bulan_ini', 'kasus_pencemaran_total'],
            16 => ['pencemaran_air_bulan_ini', 'pencemaran_air_total'],
            17 => ['pencemaran_udara_bulan_ini', 'pencemaran_udara_total'],
        ];

        foreach ($kolomLaporan as $i => [$bulan_ini_field, $total_field]) {
            $bulan_ini = $laporan[$i]['bulan_ini'][0] ?? 0;
            $total = $laporan[$i]['total'][0] ?? 0;
            $hseReport->$bulan_ini_field = $bulan_ini;
            $hseReport->$total_field = $total;
        }

        $laporanBahayaInspeksi = [
            18 => 'bahaya',
            19 => 'inspeksi',
            20 => 'alat',
        ];
        foreach ($laporanBahayaInspeksi as $i => $prefix) {
            for ($j = 0; $j < 3; $j++) {
                $lalu = $laporan[$i]['lalu'][$j] ?? 0;
                $bulan_ini = $laporan[$i]['bulan_ini'][$j] ?? 0;
                $total = $lalu + $bulan_ini;
                $field = ['temuan', 'selesai', 'sisa'][$j] ?? 'unknown';
                $hseReport->{$prefix . '_' . $field . '_lalu'} = $lalu;
                $hseReport->{$prefix . '_' . $field . '_bulan_ini'} = $bulan_ini;
                $hseReport->{$prefix . '_' . $field . '_total'} = $total;
            }
        }

        $hseReport->kegiatan_bulan_ini = $this->safeText($request->input('kegiatan_bulan_ini', []));
        $hseReport->pelatihan_bulan_ini = implode("\n", array_map(function ($item) {
            return "Judul: {$item['judul']} | Perusahaan: {$item['perusahaan']} | Jumlah: {$item['jumlah']} | Keterangan: {$item['keterangan']}";
        }, array_filter($request->input('pelatihan', []), function ($item) {
            return array_filter($item);
        })));

        $hseReport->induction_bulan_ini = implode("\n", array_map(function ($item) {
            return "Petugas: {$item['petugas']} | Jumlah Peserta: {$item['jumlah']} | Keterangan: {$item['keterangan']}";
        }, array_filter($request->input('induksi', []), function ($item) {
            return array_filter($item);
        })));

        $hseReport->ringkasan_permasalahan = $this->safeText($request->input('ringkasan_permasalahan', []));
        $hseReport->daftar_lampiran = $this->safeText($request->input('lampiran', []));
        $hseReport->rencana_bulan_depan = $this->safeText($request->input('rencana_kegiatan', []));

        $hseReport->save();
    }

    public function isUserApproverFor($user, $permissionName): bool
    {
        if (!$user || !$user->can($permissionName)) {
            return false;
        }

        return \DB::table('work_permit_approval_levels')
            ->where('permission_name', $permissionName)
            ->where('level', 3)
            ->exists();
    }

    public function approve($encodedId): void
    {
        $workSchedule = WorkSchedule::findOrFail(decodeId($encodedId));
        $user = Auth::user();

        if (! $this->isUserApproverFor($user, 'approval-she_officer')) {
            abort(403, 'Unauthorized');
        }

        $workSchedule->update([
            'status_approve_she' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'alasan_reject' => null,
        ]);

        $this->notifyVendorApproval($workSchedule);
    }


    public function reject($encodedId, string $reason): void
    {
        $workSchedule = WorkSchedule::findOrFail(decodeId($encodedId));
        $user = Auth::user();

        if (! $this->isUserApproverFor($user, 'approval-she_officer')) {
            abort(403, 'Unauthorized');
        }

        $workSchedule->update([
            'status_approve_she' => 'rejected',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'alasan_reject' => $reason,
        ]);

        $this->notifyVendorRejection($workSchedule);
    }

    public function notifyVendorApproval($workSchedule)
    {
        $po = $workSchedule->workPermit->purchaseOrder;

        $vendorUser = User::where('vendor_id', $po->vendor_id)
            ->where('is_vendor', 1)
            ->first();

        if ($vendorUser) {
            $data = [
                'vendorName' => $vendorUser->vendor->vendor_name,
                'noPO' => $po->no_po,
                'namaPekerjaan' => $po->nama_pekerjaan,
                'periode' => $workSchedule->periode_laporan,
                'tanggalPersetujuan' => now()->format('d M Y'),
            ];

            Mail::to($vendorUser->email)->send(new JamKerjaApproved($data));
        }
    }

    public function notifyVendorRejection($workSchedule)
    {
        $po = $workSchedule->workPermit->purchaseOrder;

        $vendorUser = User::where('vendor_id', $po->vendor_id)
            ->where('is_vendor', 1)
            ->first();

        if ($vendorUser) {
            $data = [
                'vendorName' => $vendorUser->vendor->vendor_name,
                'noPO' => $po->no_po,
                'namaPekerjaan' => $po->nama_pekerjaan,
                'periode' => $workSchedule->periode_laporan,
                'alasan' => $workSchedule->alasan_reject,
            ];

            Mail::to($vendorUser->email)->send(new JamKerjaRejected($data));
        }
    }
}
