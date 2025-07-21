<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'folder_id' => 'required|exists:folders,id',
        ]);

        $folder = Folder::findOrFail($request->folder_id);
        $file = $request->file('file');
        $folderSlug = Str::slug($folder->path_hierarchy, '_');


        $path = $file->store($folderSlug, 'public');

        File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'folder_id' => $folder->id,
        ]);

        return back()->with('success', 'File berhasil diupload ke ' . $folder->path_hierarchy);
    }
}
