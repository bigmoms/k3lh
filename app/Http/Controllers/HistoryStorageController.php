<?php

namespace App\Http\Controllers;

use App\Models\HistoryStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HistoryStorageController extends Controller
{
    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        $title = 'History PKL';
        return view('admin.history_storage.index', compact('title', 'menus'));
    }

    public function json()
    {
        if (isRoles() == 1) {

            $data = HistoryStorage::query();
        } else {
            $data = HistoryStorage::query();
            $data->where('nip', Auth::user()->id)->get();
        }

        return  DataTables::of($data)->addIndexColumn()
            ->addColumn('path_file', function ($row) {
                if (isRoles() == 1) {
                    $url = asset('storage/' . $row->path_file);

                    return '
                    <a href="' . $url . '" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-file-pdf"></i> Preview
                    </a>
                ';
                } else {
                    if ($row->status == 1) {
                        return '
                        <span class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf"></i> No Access
                        </a>
                    ';
                    } elseif ($row->status == 2) {
                        $url = asset('storage/' . $row->path_file);

                        return '
                        <a href="' . $url . '" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-file-pdf"></i> Preview
                        </a>
                    ';
                    } else {
                        return '
                        <span class="btn btn-sm btn-danger">
                            <i class="fas fa-file-pdf"></i> No Access
                        </a>
                    ';
                    }
                }
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-warning">menunggu</span>';
                } elseif ($row->status == 2) {
                    return '<span class="badge bg-success">disetujui</span>';
                } else {
                    return '<span class="badge bg-danger">ditolak</span>';
                }
            })
            ->addColumn('action', function ($row) {
                if (isRoles() == 1) {
                    if ($row->status == 1) {
                        $btn = '
                        <div class="btn-group">
                            <button onclick="terimax(' . $row['id'] . ')" class="btn btn-sm btn-warning"><i class="fas fa-check""></i></button>
                            <button onclick="tolakx(' . $row['id'] . ')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                        </div>
                        ';
                    } else {
                        $btn = '-';
                    }
                } else {
                    $btn = '-';
                }

                return $btn;
            })
            ->rawColumns(['path_file', 'status', 'action'])
            ->make(true);
    }

    public function terima($id)
    {
        try {
            $data = HistoryStorage::where('id', $id)->first();
            $data->update([
                'status' => 2,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data berhasil diapprove.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage(),
            ]);
        }
    }

    public function tolak($id, Request $request)
    {
        try {
            $data = HistoryStorage::where('id', $id)->first();
            $data->update([
                'status' => 3,
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                "status" => true,
                "message" => "Data berhasil ditolak.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan: " . $e->getMessage(),
            ]);
        }
    }
}
