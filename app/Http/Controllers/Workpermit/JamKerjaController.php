<?php

namespace App\Http\Controllers\Workpermit;

use App\Models\Workpermit\WorkPermit;
use App\Models\Workpermit\WorkScheduleDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Services\Workpermit\JamKerjaService;
use App\Http\Requests\Workpermit\WorkScheduleStoreRequest;

class JamKerjaController extends Controller
{
    protected $jamKerjaService;

    public function __construct(JamKerjaService $jamKerjaService)
    {
        $this->jamKerjaService = $jamKerjaService;
    }

    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        $listPo = $this->jamKerjaService->getListPo();
        return view('workpermit.jamkerja.index', compact('menus', 'listPo'));
    }

    public function fetch(Request $request)
    {
        $user = auth()->user();
        $purchaseOrders = $this->jamKerjaService->getFilter($request, $user);

        $result = [];

        foreach ($purchaseOrders as $po) {
            $workPermit = $po->workPermits()->where('status', 'approved')->first();
            if (!$workPermit) continue;

            $start = Carbon::parse($po->tanggal_mulai)->startOfMonth();
            $end = Carbon::parse($po->tanggal_akhir)->endOfMonth();
            $today = Carbon::today();

            $result = array_merge($result, $this->jamKerjaService->prosesLaporan(
                $po,
                $workPermit,
                $start,
                $end,
                $today,
                $user
            ));
        }

        return DataTables::of(collect($result))
            ->addIndexColumn()
            ->rawColumns(['status', 'action', 'approval_status'])
            ->make(true);
    }

    public function create(Request $request, $id)
    {
        $user = auth()->user();
        $workPermit = WorkPermit::with('purchaseOrder')->findOrFail(decodeId($id));
        $po = $workPermit->purchaseOrder;

        if (!$user->vendor_id || $user->vendor_id !== $po->vendor_id) {
            abort(403, 'Anda tidak memiliki izin mengakses halaman ini.');
        }

        $menus = $request->get('dtmenus');

        $start = $request->start ?? $po->tanggal_mulai;
        $end = $request->end ?? $po->tanggal_akhir;

        return view('workpermit.jamkerja.create', compact('workPermit', 'start', 'end', 'menus'));
    }

    public function store(WorkScheduleStoreRequest $request)
    {
        $result = app(JamKerjaService::class)->store($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Data jam kerja dan laporan HSE berhasil disimpan.',
        ]);
    }

    public function detail(Request $request, $id, $periode)
    {
        $workPermitId = decodeId($id);
        $workPermit = WorkPermit::with('purchaseOrder')->findOrFail($workPermitId);
        $menus = $request->get('dtmenus');

        $schedule = $workPermit->workSchedules()
            ->with(['details', 'hseMonthlyReport'])
            ->where('periode_laporan', 'like', "%$periode%")
            ->first();

        if (!$schedule || !$schedule->hseMonthlyReport) {
            abort(404, 'Data tidak ditemukan');
        }

        $canApproveShe = $this->jamKerjaService->isUserApproverFor(auth()->user(), 'approval-she_officer');

        return view('workpermit.jamkerja.detail', [
            'workPermit' => $workPermit,
            'schedule' => $schedule,
            'hse' => $schedule->hseMonthlyReport,
            'menus' => $menus,
            'canApproveShe' => $canApproveShe,
        ]);
    }

    public function approveShe($id, JamKerjaService $service)
    {
        $service->approve($id);
        return response()->json(['message' => 'Disetujui oleh SHE.']);
    }

    public function rejectShe(Request $request, $id, JamKerjaService $service)
    {
        $request->validate([
            'alasan_reject' => 'required|string',
        ]);

        $service->reject($id, $request->alasan_reject);
        return response()->json(['message' => 'Ditolak oleh SHE.']);
    }

    public function previewPdf($id, $periode)
    {
        $workPermitId = decodeId($id);
        $workPermit = WorkPermit::with('purchaseOrder')->findOrFail($workPermitId);

        $schedule = $workPermit->workSchedules()
            ->with('details')
            ->where('periode_laporan', 'like', "%$periode%")
            ->firstOrFail();

        $options = new Options();
        $options->set('defaultFont', 'sans-serif');
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $html = view('workpermit.jamkerja.print', compact('workPermit', 'schedule'))->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="jamkerja_preview.pdf"');
    }

    public function getStatistikBulan(Request $request)
    {
        $workPermitId = $request->query('work_permit_id');
        $startDate = Carbon::parse($request->query('start_date'));
        $startMonth = $startDate->copy()->startOfMonth();

        $allData = WorkScheduleDetail::whereHas('workSchedule', function ($query) use ($workPermitId) {
            $query->where('work_permit_id', $workPermitId);
        })->get();

        $groupedByMonth = $allData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m');
        });

        $bulanLalu = 0;
        $bulanIni = 0;
        $jamKerjaLalu = 0;
        $jamKerjaIni = 0;
        $perBulan = [];

        foreach ($groupedByMonth as $bulan => $items) {
            $jumlahHari = $items->count();
            $jumlahJamKerja = $items->sum('jumlah_jam_kerja_real');

            $perBulan[$bulan] = [
                'hari' => $jumlahHari,
                'jam' => $jumlahJamKerja
            ];

            if ($bulan < $startMonth->format('Y-m')) {
                $bulanLalu += $jumlahHari;
                $jamKerjaLalu += $jumlahJamKerja;
            } elseif ($bulan == $startMonth->format('Y-m')) {
                $bulanIni += $jumlahHari;
                $jamKerjaIni += $jumlahJamKerja;
            }
        }

        return response()->json([
            'per_bulan' => $perBulan,
            'bulan_ini' => $bulanIni,
            'bulan_lalu' => $bulanLalu,
            'manhours_ini' => $jamKerjaIni,
            'manhours_lalu' => $jamKerjaLalu,
        ]);
    }
}
