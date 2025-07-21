<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Models\HistoryStorage;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        $title = 'Pengukuran Kualitas Lingkungan';
        $folders = Folder::with(['children', 'files'])->whereNull('parent_id')->get();

        return view('admin.folders.index', compact('folders', 'title', 'menus'));
    }

    public function modal()
    {
        $folders = Folder::all();
        return view('admin.folders.modal', compact('folders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        Folder::create($request->only('name', 'parent_id'));

        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan.",
        ]);
    }

    public function pengajuan(Request $request)
    {
        $files = File::where('id', $request->id)->first();

        HistoryStorage::create([
            "nip" => $request->user()->id,
            "nama" => $request->user()->name,
            "nama_file" => $files->name,
            "path_file" => $files->path,
            "status" => 1
        ]);

        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan.",
        ]);
    }
}
