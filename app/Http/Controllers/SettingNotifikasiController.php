<?php

namespace App\Http\Controllers;

use App\Models\SettingNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class SettingNotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        $title = 'Setting Notifikasi';
        return view('admin.setting_notifikasi.index', compact('title', 'menus'));
    }

    public function json()
    {
        $data = SettingNotifikasi::query();

        return  DataTables::of($data)->addIndexColumn()
            ->addColumn('link_video', function ($row) {
                $url = asset('storage/' . $row->link_video);
                return '
                <a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary">
                    <i class="fas fa-play"></i> Play Video
                </a>
            ';
            })
            ->addColumn('link_audio', function ($row) {
                $url = asset('storage/' . $row->link_audio);
                return '
                <a href="' . $url . '" target="_blank" class="btn btn-sm btn-success">
                    <i class="fas fa-play"></i> Play Audio
                </a>
            ';
            })
            ->addColumn('action', function ($row) {
                $btn = '
                    <div class="btn-group">
                        <button onclick="modal(' . $row['id'] . ')" class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></button>
                        <button onclick="push(' . $row['id'] . ')" class="btn btn-sm btn-info"><i class="fas fa-paper-plane"></i></button>
                    </div>
                    ';
                return $btn;
            })
            ->rawColumns(['link_video', 'link_audio', 'action'])
            ->make(true);
    }

    public function modal(Request $request)
    {
        $data = SettingNotifikasi::find($request->id);

        return view('admin.setting_notifikasi.modal', compact('data'));
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title" => 'required',
                "body" => 'required',
                "link_video" => 'required|mimes:mp4|max:51200',
                // "link_audio" => 'required|mimes:mp3|max:20480',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors(),
                ], 422);
            }

            // Simpan file video dan audio
            $videoPath = $request->file('link_video')->store('videos', 'public');
            // $audioPath = $request->file('link_audio')->store('audios', 'public');

            $data = SettingNotifikasi::where('id', $request->id)->first();

            if ($request->id == 0) {
                SettingNotifikasi::create([
                    'title' => $request->title,
                    'body' => $request->body,
                    'link_video' => $videoPath,
                    // 'link_audio' => $audioPath,
                ]);
            } else {
                $data->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'link_video' => $videoPath,
                    // 'link_audio' => $audioPath,
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
        $data = SettingNotifikasi::where('id', $request->id)->first();
        $data->delete();

        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }

    public function push(Request $request)
    {

        $data = SettingNotifikasi::where('id', $request->id)->first();

        $topic = 'stretching';
        $messaging = app('firebase.messaging');
        $notification = Notification::create(
            $data->title ?? '',
            $data->body ?? '',
        );

        $dataPayload = [
            'payload' => 'custom_page',
            'link_video' => $data->link_video ? asset('storage/' . $data->link_video) : '',
            'link_audio' => $data->link_audio ? asset('storage/' . $data->link_audio) : '',
        ];


        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData($dataPayload);

        try {
            $result = $messaging->send($message);
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan berhasil dikirim',
                'result' => $result,
            ]);
        } catch (MessagingException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim pesan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
