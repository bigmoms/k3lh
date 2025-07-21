<?php

namespace App\Http\Controllers\Workpermit;

use App\Http\Controllers\Controller;
use App\Models\Workpermit\Vendor as WorkpermitVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Workpermit\Vendor;
use GuzzleHttp\Client;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $response = Http::get('http://115.85.65.125:8084/vendor_management/public/api/vendor-ksp');
            // $vendors = $response->json()['data'] ?? [];
            $vendors = Vendor::get();

            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <button type="button" class="btn btn-sm btn-info" style="color:#ffff;" disabled>Lihat
                        </button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $menus  = $request->get('dtmenus');
        return view('workpermit.vendors.index', [
            'menus' => $menus,
        ]);
    }
    public function getData(Request $request)
    {
        $client = new Client();
        $options = [
            'verify' => false,
            'Accept' => 'application/json',
        ];
        try {
            $response = $client->request('GET', 'http://115.85.65.125:8084/vendor_management/public/api/vendor-ksp');
            $response_json = json_decode($response->getBody());
            //dd($response_json);
            // $createDivisi = $this->divisiService->storeDivisi($response_json);

            foreach ($response_json->data as $item) {
                $createDivisi = Vendor::upsert([
                    'kd_vendor' => $item->kd_vendor,
                    'vendor_name' => $item->vendor_name,
                    'address' => $item->addres,
                    'city' => $item->city,
                    'province' => $item->province,
                    'npwp' => $item->npwp,
                    'phone' => $item->phone,
                    'email' => $item->email,
                    'direksi' => $item->direksi,
                ],
                uniqueBy: ['kd_vendor'],
                update: ['vendor_name','address','city','province','npwp','phone','email','direksi']);
            }

            $menus  = $request->get('dtmenus');

            return view('workpermit.vendors.index',[
                'menus' => $menus,
            ]);
        } catch (Throwable $th) {
            // echo "Terjadi kesalahan saat memproses permintaan: " . $th;
            // return false;
            return redirect()->back()->with([
                'alert-icon' => 'error',
                'alert-type' => 'Failed!',
                'alert-message' => 'Create User Failed:',
            ]);
        }
    }

    // public function searchVendors(Request $request)
    // {
    //     $response = Http::get('http://115.85.65.125:8084/vendor_management/public/api/vendor-ksp');
    //     $vendors = $response->json()['data'] ?? [];

    //     if ($request->has('q')) {
    //         $vendors = array_filter($vendors, function ($vendor) use ($request) {
    //             return stripos($vendor['vendor_name'], $request->q) !== false;
    //         });
    //     }
    //     $result = array_map(function ($vendor) {
    //         return [
    //             'kd_vendor' => $vendor['kd_vendor'],
    //             'vendor_name' => $vendor['vendor_name'],
    //         ];
    //     }, array_slice($vendors, 0, 10));

    //     return response()->json(['data' => $result]);
    // }

    public function searchVendors(Request $request)
    {
        $query = Vendor::query();

        if ($request->has('q')) {
            $query->where('vendor_name', 'like', '%' . $request->q . '%');
        }

        $vendors = $query->limit(10)->get(['id', 'vendor_name']);

        return response()->json([
            'data' => $vendors
        ]);
    }
}
