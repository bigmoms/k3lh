<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workpermit\PurchaseOrder;
use App\Models\Workpermit\WorkPermit;
use App\Models\Workpermit\WorkSchedule;
use App\Models\Workpermit\WorkPermitApproval;
use App\Models\Workpermit\PengajuanPembatalan;
use App\Models\Workpermit\PengajuanPenyelesaian;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $totalPo = PurchaseOrder::where('is_deleted', 0)->count();
        $totalWorkPermit = WorkPermit::count();

        $poAktif = PurchaseOrder::where('is_deleted', 0)->where('status', 'active')->count();
        $poSelesai = PurchaseOrder::where('is_deleted', 0)->where('status', 'completed')->count();

        $jadwalBulanIni = WorkSchedule::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $chartData = WorkPermit::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('jumlah', 'bulan');

        $monthlyWorkPermit = collect(range(1, 12))->mapWithKeys(function ($month) use ($chartData) {
            return [$month => $chartData->get($month, 0)];
        });

        $poTanpaWp = PurchaseOrder::doesntHave('workPermits')
            ->where('is_deleted', 0)
            ->latest()
            ->take(5)
            ->get();

        $wpDitolak = WorkPermit::where('status', 'rejected')
            ->latest()
            ->take(5)
            ->get();

        $jadwalMenungguSHE = WorkSchedule::where('status_approve_she', 'waiting')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $approvalTerakhir = WorkPermitApproval::whereNotNull('approved_at')
            ->where('permission_name', 'like', '%she%')
            ->orderByDesc('approved_at')
            ->take(5)
            ->get();

        $pembatalan = PengajuanPembatalan::latest()->take(5)->get();
        $penyelesaian = PengajuanPenyelesaian::latest()->take(5)->get();
        $menus = $request->get('dtmenus');
        return view('admin.dashboard.index', [
            'totalPo' => $totalPo,
            'totalWorkPermit' => $totalWorkPermit,
            'poAktif' => $poAktif,
            'poSelesai' => $poSelesai,
            'jadwalBulanIni' => $jadwalBulanIni,
            'monthlyWorkPermit' => $monthlyWorkPermit,
            'poTanpaWp' => $poTanpaWp,
            'wpDitolak' => $wpDitolak,
            'jadwalMenungguSHE' => $jadwalMenungguSHE,
            'approvalTerakhir' => $approvalTerakhir,
            'pembatalan' => $pembatalan,
            'penyelesaian' => $penyelesaian,
            'menus' => $menus
        ]);
    }
}
