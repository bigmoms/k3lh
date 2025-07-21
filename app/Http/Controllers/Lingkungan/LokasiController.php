<?php

namespace App\Http\Controllers\Lingkungan;

use App\Models\Pengukuran\LokasiPengukuran;
use App\Models\Pengukuran\DivisiLingkungan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('lingkungan.lokasi.index', ['menus' => $menus]);
    }

    public function fetch()
    {
        $lokasi = LokasiPengukuran::withCount('divisis')->latest();

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
                    <button class="btn btn-sm btn-primary edit-lokasi" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete-lokasi" data-id="' . $row->id . '">Hapus</button>
                    <button class="btn btn-sm btn-warning show-divisi" data-id="' . $row->id . '">Divisi</button>
                ';
            })
            ->rawColumns(['action', 'daftar_divisi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100'
        ]);

        LokasiPengukuran::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return response()->json(['message' => 'Lokasi berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100'
        ]);

        $lokasi = LokasiPengukuran::findOrFail($id);
        $lokasi->update(['nama_lokasi' => $request->nama_lokasi]);

        return response()->json(['message' => 'Lokasi berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $lokasi = LokasiPengukuran::findOrFail($id);
        $lokasi->delete();

        return response()->json(['message' => 'Lokasi berhasil dihapus']);
    }

    public function fetchDivisi($lokasiId)
    {
        $data = DivisiLingkungan::where('lokasi_id', $lokasiId)->get();
        return response()->json($data);
    }

    public function storeDivisi(Request $request, $lokasiId)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:100'
        ]);

        DivisiLingkungan::create([
            'lokasi_id' => $lokasiId,
            'nama_divisi' => $request->nama_divisi
        ]);

        return response()->json(['message' => 'Divisi berhasil ditambahkan']);
    }

    public function updateDivisi(Request $request, $lokasiId, $divisiId)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:100'
        ]);

        $divisi = DivisiLingkungan::where('lokasi_id', $lokasiId)->findOrFail($divisiId);
        $divisi->update(['nama_divisi' => $request->nama_divisi]);

        return response()->json(['message' => 'Divisi berhasil diperbarui']);
    }

    public function destroyDivisi($lokasiId, $divisiId)
    {
        $divisi = DivisiLingkungan::where('lokasi_id', $lokasiId)->findOrFail($divisiId);
        $divisi->delete();

        return response()->json(['message' => 'Divisi berhasil dihapus']);
    }

}
