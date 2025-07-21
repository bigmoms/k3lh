<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Division;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('lingkungan.lokasi.index', ['menus' => $menus]);
    }

    public function fetch()
    {
        $lokasi = Lokasi::with('divisis')->latest();

        return DataTables::of($lokasi)
            ->addIndexColumn()
            ->addColumn('daftar_divisi', function ($lokasi) {
                if ($lokasi->divisis->isEmpty()) {
                    return '<span class="badge bg-secondary">Belum ada</span>';
                }

                return $lokasi->divisis->map(function ($div) {
                    return '<span class="badge bg-info text-dark me-1 mb-1">' . e($div->nama_divisi) . '</span>';
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                return '
    <div class="dropdown text-center">
        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
                <button class="dropdown-item d-flex align-items-center edit-lokasi" data-id="' . $row->id . '">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit
                </button>
            </li>
            <li>
                <button class="dropdown-item d-flex align-items-center delete-lokasi" data-id="' . $row->id . '">
                    <i class="fas fa-trash-alt me-2 text-danger"></i> Hapus
                </button>
            </li>
            <li>
                <button class="dropdown-item d-flex align-items-center show-divisi" data-id="' . $row->id . '">
                    <i class="fas fa-building me-2 text-warning"></i> Divisi
                </button>
            </li>
        </ul>
    </div>
    ';
            })

            ->rawColumns(['action', 'daftar_divisi'])
            ->make(true);
    }
    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return response()->json($lokasi);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100'
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return response()->json(['message' => 'Lokasi berhasil ditambahkan']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100'
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update(['nama_lokasi' => $request->nama_lokasi]);

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return response()->json(['message' => 'Lokasi berhasil dihapus']);
    }

    public function fetchDivisi($lokasiId)
    {
        $lokasi   = Lokasi::findOrFail($lokasiId);
        $divisis  = Division::where('lokasi_id', $lokasiId)->get(['id', 'nama_divisi']);

        return response()->json([
            'lokasi'   => $lokasi,
            'divisis'  => $divisis
        ]);
    }

    public function storeDivisi(Request $request, $lokasiId)
    {
        $request->validate([
            'divisi_ids'   => 'array|required',
            'divisi_ids.*' => 'integer'
        ]);

        $chosen = $request->divisi_ids;

        DB::transaction(function () use ($lokasiId, $chosen) {


            Division::where('lokasi_id', $lokasiId)
                ->whereNotIn('id', $chosen)
                ->update(['lokasi_id' => 0]);
            $missing = array_diff(
                $chosen,
                Division::whereIn('id', $chosen)->pluck('id')->toArray()
            );

            if ($missing) {
                $api = Http::get('http://115.85.65.125:8084/microservices/public/api/v1/divisions');
                if ($api->successful() && $api->json('status') == 1) {
                    $apiData = collect($api->json('data'));

                    foreach ($missing as $mid) {
                        if ($row = $apiData->firstWhere('id', $mid)) {
                            Division::create([
                                'id'          => $row['id'],
                                'nama_divisi' => $row['name'],
                                'code'        => $row['code'] ?? null,
                                'lokasi_id'   => 0
                            ]);
                        }
                    }
                }
            }

            Division::whereIn('id', $chosen)
                ->update(['lokasi_id' => $lokasiId]);
        });

        return response()->json(['message' => 'Divisi berhasil diperbarui']);
    }

    public function searchLokasi(Request $request)
    {
        $query = Lokasi::query();

        if ($request->has('q')) {
            $query->where('nama_lokasi', 'like', '%' . $request->q . '%');
        }

        $lokasi = $query->limit(10)->get(['id', 'nama_lokasi']);

        return response()->json([
            'data' => $lokasi
        ]);
    }
}
