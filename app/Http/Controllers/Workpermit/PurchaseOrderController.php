<?php

namespace App\Http\Controllers\Workpermit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workpermit\PurchaseOrder;
use App\Models\Workpermit\JobClassification;
use App\Models\Workpermit\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PurchaseOrderNotification;
use App\Http\Requests\Purchase\PurchaseOrderStoreRequest;
use App\Http\Services\NotificationService;
use App\Models\User;

class PurchaseOrderController extends Controller
{

    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        return view('workpermit.purchasing.index', ['menus' => $menus]);
    }

    // public function fetch(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $purchaseOrders = PurchaseOrder::all();
    //         // Ambil vendor dari API
    //         $vendors = $this->getVendorsFromAPI();
    //         if (!isset($vendors['data']) || !is_array($vendors['data'])) {
    //             $vendors = ['data' => []];
    //         }

    //         $vendorMap = collect($vendors['data'])->keyBy('kd_vendor');
    //         return DataTables::of($purchaseOrders)
    //             ->addIndexColumn()
    //             ->addColumn('vendor', function ($po) use ($vendorMap) {
    //                 return $vendorMap[$po->vendor_id]['vendor_name'] ?? '-';
    //             })
    //             ->addColumn('jenis_pekerjaan', function ($po) {
    //                 return $po->jenis_pekerjaan == 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan';
    //             })
    //             ->addColumn('status', function ($po) {
    //                 return '<span class="badge bg-' . ($po->status == 'active' ? 'success' : ($po->status == 'cancelled' ? 'danger' : 'secondary')) . '">'
    //                     . ucfirst($po->status) . '</span>';
    //             })
    //             ->addColumn('action', function ($po) {
    //                 $buttons = '';
    //                 if ($po->status == 'draft') {
    //                     $buttons .= '<button class="btn btn-sm btn-primary" disabled>Aktifkan</button>';
    //                 } elseif ($po->status == 'active') {
    //                     $buttons .= '<button class="btn btn-sm btn-danger" disabled>Batalkan</button>';
    //                 }
    //                 return $buttons;
    //             })
    //             ->rawColumns(['status', 'action'])
    //             ->toJson();
    //     }
    // }

    // private function getVendorsFromAPI()
    // {
    //     $response = Http::get('http://115.85.65.125:8084/vendor_management/public/api/vendor-ksp');
    //     if ($response->successful()) {
    //         return $response->json();
    //     }
    //     return ['data' => []];
    // }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $purchaseOrders = PurchaseOrder::with('vendor')
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($purchaseOrders)
                ->addIndexColumn()
                ->addColumn('vendor', function ($po) {
                    return $po->vendor->vendor_name ?? '-';
                })
                ->addColumn('jenis_pekerjaan', function ($po) {
                    return $po->jenis_pekerjaan == 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan';
                })
                ->addColumn('tanggal_mulai', function ($po) {
                    return \Carbon\Carbon::parse($po->tanggal_mulai)->format('Y-m-d');
                })
                ->addColumn('tanggal_akhir', function ($po) {
                    return \Carbon\Carbon::parse($po->tanggal_akhir)->format('Y-m-d');
                })
                ->addColumn('status', function ($po) {
                    $statusClass = match ($po->status) {
                        'draft' => 'secondary',
                        'active' => 'primary',
                        'submitted' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'light',
                    };

                    $statusText = ucfirst($po->status);

                    return '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
                })
                ->addColumn('action', function ($po) {
                    $encodedId = encodeId($po->id);
                    $detailUrl = route('purchasing.po.detail', $encodedId);
                    $editUrl = route('purchasing.po.edit', $encodedId);

                    $dropdown = '
    <div class="dropdown text-center">
        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $detailUrl . '">
                    <i class="fas fa-eye me-2 text-info"></i> Detail
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $editUrl . '">
                    <i class="fas fa-edit me-2 text-warning"></i> Edit
                </a>
            </li>';

                    if ($po->status === 'draft') {
                        $dropdown .= '
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center btn-cancel" data-id="' . $encodedId . '">
                    <i class="fas fa-times-circle me-2 text-danger"></i> Batalkan
                </button>
            </li>';
                    }

                    $dropdown .= '</ul></div>';

                    return $dropdown;
                })

                ->rawColumns(['status', 'action'])
                ->toJson();
        }
    }

    public function create(Request $request)
    {
        $no_po = PurchaseOrder::generateNoPO();
        $jobClassifications = JobClassification::all();
        $menus  = $request->get('dtmenus');
        return view('workpermit.purchasing.create', compact('jobClassifications', 'menus', 'no_po'));
    }

    public function store(PurchaseOrderStoreRequest $request)
    {
        $po = PurchaseOrder::create([
            'no_po'            => PurchaseOrder::generateNoPO(),
            'vendor_id'        => $request->vendor_id,
            'nama_pekerjaan'   => $request->nama_pekerjaan,
            'jenis_pekerjaan'  => $request->jenis_pekerjaan,
            'area_pekerjaan'   => $request->area_pekerjaan,
            'lokasi_pekerjaan' => $request->lokasi_pekerjaan,
            'detail_pekerjaan' => $request->detail_pekerjaan,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_akhir'    => $request->tanggal_akhir,
            'created_by'       => Auth::id(),
            'status'           => 'draft',
        ]);

        $po->jobClassifications()->sync($request->job_classifications);
        DB::commit();

        // Notifikasi ke user berdasarkan permission
        // NotificationService::notifyUsersByPermission(
        //     'purchase_order_created',
        //     ['no_po' => $po->no_po],
        //     'permit.po.index'
        // );

        $vendorUsers = User::where('is_vendor', 1)->get();

        foreach ($vendorUsers as $user) {
            $vendorName = $user->vendor->name ?? 'Vendor Tidak Dikenal';

            Mail::to($user->email)->send(new PurchaseOrderNotification($po, $vendorName));
        }

        return response()->json(['message' => 'Purchase Order berhasil dibuat!'], 200);
    }

    public function cancel($hash)
    {
        $id = decodeId($hash);
        $po = PurchaseOrder::find($id);
        if (!$po) {
            return response()->json(['error' => 'PO tidak ditemukan!'], 404);
        }
        $po->update(['status' => 'cancelled']);
        return response()->json(['message' => 'PO berhasil dibatalkan!'], 200);
    }

    public function show(Request $request, $hash)
    {
        $id = decodeId($hash);
        $purchaseOrder = PurchaseOrder::with([
            'vendor',
            'jobClassifications.safetyEquipments',
            'jobClassifications.emergencyEquipments'
        ])->findOrFail($id);
        $selectedClassifications = $purchaseOrder->jobClassifications->pluck('name');
        $allApd = collect();
        $allEmergencyEquipments = collect();
        foreach ($purchaseOrder->jobClassifications as $classification) {
            $allApd = $allApd->merge($classification->safetyEquipments->where('type', 'apd'));
            $allEmergencyEquipments = $allEmergencyEquipments->merge($classification->safetyEquipments->where('type', 'perlengkapan_darurat'));
        }
        $uniqueApd = $allApd->unique('id');
        $uniqueEmergencyEquipments = $allEmergencyEquipments->unique('id');
        $menus  = $request->get('dtmenus');
        return view('workpermit.purchasing.detail', compact('purchaseOrder', 'menus', 'selectedClassifications', 'uniqueApd', 'uniqueEmergencyEquipments'));
    }

    public function edit(Request $request, $hash)
    {
        $id = decodeId($hash);
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $vendors = Vendor::all();
        $jobClassifications = JobClassification::all();
        $selectedClassifications = $purchaseOrder->jobClassifications()->pluck('job_classifications.id')->toArray();
        $menus  = $request->get('dtmenus');

        return view('workpermit.purchasing.edit', compact(
            'purchaseOrder',
            'vendors',
            'jobClassifications',
            'selectedClassifications',
            'menus'
        ));
    }

    public function update(Request $request, $hash)
    {
        $id = decodeId($hash);
        $po = PurchaseOrder::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'vendor_id'       => 'required|string',
            'nama_pekerjaan'  => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|in:jasa_perorangan,jasa_non_perorangan',
            'area_pekerjaan'  => 'required|string|max:255',
            'lokasi_pekerjaan' => 'required|string|max:255',
            'detail_pekerjaan' => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir'   => 'required|date|after_or_equal:tanggal_mulai',
            'job_classifications' => 'required|array',
            'job_classifications.*' => 'exists:job_classifications,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($po, $request) {
            $po->update([
                'vendor_id' => $request->vendor_id,
                'nama_pekerjaan' => $request->nama_pekerjaan,
                'jenis_pekerjaan' => $request->jenis_pekerjaan,
                'area_pekerjaan' => $request->area_pekerjaan,
                'lokasi_pekerjaan' => $request->lokasi_pekerjaan,
                'detail_pekerjaan' => $request->detail_pekerjaan,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
            ]);

            $po->jobClassifications()->sync($request->job_classifications);
        });

        return response()->json(['message' => 'Data berhasil diperbarui!'], 200);
    }
}
