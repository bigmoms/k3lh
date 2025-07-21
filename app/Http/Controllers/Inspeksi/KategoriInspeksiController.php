<?php

namespace App\Http\Controllers\Inspeksi;

use App\Models\Inspeksi\KategoriInspeksi;
use App\Models\Inspeksi\SubKategoriInspeksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class KategoriInspeksiController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('inspeksi.kategori.index', ['menus' => $menus]);
    }

    public function fetch()
    {
        $kategoriInspeksi = KategoriInspeksi::withCount('subKategori')->latest();

        return DataTables::of($kategoriInspeksi)
            ->addIndexColumn()
            ->addColumn('daftar_subkategori', function ($kategori) {
                if ($kategori->subKategori->isEmpty()) {
                    return '<span class="badge bg-secondary">Belum ada</span>';
                }

                return $kategori->subKategori->map(function ($sub) {
                    return '<span class="badge bg-info text-dark me-1 mb-1">' . e($sub->nama_sub_kategori) . '</span>';
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
                <button type="button" class="dropdown-item d-flex align-items-center edit-kategori"
                    data-id="' . $row->id . '" data-nama="' . e($row->nama_kategori) . '">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center delete-kategori"
                    data-id="' . $row->id . '">
                    <i class="fas fa-trash me-2 text-danger"></i> Hapus
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center show-subkategori"
                    data-id="' . $row->id . '">
                    <i class="fas fa-list me-2 text-warning"></i> Subkategori
                </button>
            </li>
        </ul>
    </div>';
            })

            ->rawColumns(['action', 'daftar_subkategori'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100'
        ]);

        KategoriInspeksi::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100'
        ]);

        $kategori = KategoriInspeksi::findOrFail($id);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return response()->json(['message' => 'Kategori berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kategori = KategoriInspeksi::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }


    public function fetchSubkategori($kategoriId)
    {
        $data = SubKategoriInspeksi::where('kategori_id', $kategoriId)->get();
        return response()->json($data);
    }

    public function storeSubkategori(Request $request, $kategoriId)
    {
        $request->validate([
            'nama_sub_kategori' => 'required|string|max:100'
        ]);

        SubKategoriInspeksi::create([
            'kategori_id' => $kategoriId,
            'nama_sub_kategori' => $request->nama_sub_kategori
        ]);

        return response()->json(['message' => 'Subkategori berhasil ditambahkan']);
    }


    public function updateSubkategori(Request $request, $id)
    {
        $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
        ]);

        $subkategori = SubKategoriInspeksi::findOrFail($id);
        $subkategori->nama_sub_kategori = $request->nama_sub_kategori;
        $subkategori->save();

        return response()->json([
            'message' => 'Subkategori berhasil diperbarui'
        ]);
    }

    public function destroySubkategori($id)
    {
        $subkategori = SubKategoriInspeksi::findOrFail($id);
        $subkategori->delete();

        return response()->json(['message' => 'Subkategori berhasil dihapus']);
    }
}
