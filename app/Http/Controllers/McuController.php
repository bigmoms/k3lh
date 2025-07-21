<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Mcu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\McuRecordImport;
use App\Imports\McuImport;
use App\Models\McuRecord;
use Maatwebsite\Excel\Facades\Excel;


class McuController extends Controller
{
    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        $title = 'Data MCU';
        return view('admin.mcu.index', compact('title', 'menus'));
    }

    public function json()
    {
        $data = McuRecord::query();

        return  DataTables::of($data)->addIndexColumn()
            ->addColumn('file_mcu', function ($row) {
                $url = asset('storage/' . $row->file_mcu);
                return '
                <a href="' . $url . '" target="_blank" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf"></i> Preview
                </a>
            ';
            })
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <button onclick="modal(' . $row['id'] . ')" class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></button>
                        <button onclick="hapus(' . $row['id'] . ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </div>
                    ';
                return $btn;
            })
            ->rawColumns(['file_mcu', 'action'])
            ->make(true);
    }

    public function modal(Request $request)
    {
        $data = Mcu::find($request->id);

        return view('admin.mcu.modal', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                "keterangan" => 'required',
                "tanggal" => 'required',
                "nik" => 'required',
            ];

            if ($request->id == 0) {
                // Kalau tambah baru, file wajib
                $rules['file_mcu'] = 'required|mimes:pdf|max:51200';
            } else {
                // Kalau edit, file boleh kosong
                $rules['file_mcu'] = 'nullable|mimes:pdf|max:51200';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors(),
                ], 422);
            }

            $data = Mcu::where('id', $request->id)->first();
            $karyawan = Karyawan::where('nik', $request->nik)->first();

            // Simpan file kalau ada
            if ($request->hasFile('file_mcu')) {
                $fileMcuPath = $request->file('file_mcu')->store('mcu', 'public');
            } else {
                $fileMcuPath = $data ? $data->file_mcu : null; // Pakai file lama kalau edit
            }

            if ($request->id == 0) {
                Mcu::create([
                    'nik' => $request->nik,
                    'nama' => $karyawan->nama,
                    'keterangan' => $request->keterangan,
                    'tanggal' => $request->tanggal,
                    'file_mcu' => $fileMcuPath,
                ]);
            } else {
                $data->update([
                    'nik' => $request->nik,
                    'nama' => $karyawan->nama,
                    'keterangan' => $request->keterangan,
                    'tanggal' => $request->tanggal,
                    'file_mcu' => $fileMcuPath,
                ]);
            }

            return response()->json([
                "status" => true,
                "message" => "Data berhasil disimpan.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage(),
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $data = Mcu::where('id', $request->id)->first();
        $data->delete();

        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }


    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx']);

        Excel::import(new McuImport, $request->file('file'));

        return response()->json([
            "status" => true,
            "message" => "Import Berhasil",
        ]);
    }
}
