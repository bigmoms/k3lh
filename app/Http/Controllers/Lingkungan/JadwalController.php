<?php

namespace App\Http\Controllers\Lingkungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengukuran\JadwalPengukuran;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('lingkungan.jadwal.index', compact('menus'));
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $statusFilter = $request->input('status', 'dijadwalkan');

            $query = JadwalPengukuran::with(['lokasi', 'createdBy'])
                ->where('status', $statusFilter)
                ->latest();

            if ($user->divisiInspeksi()->exists()) {
                $lokasiIds = $user->divisiInspeksi()->pluck('lokasi_id')->toArray();

                $query->whereHas('lokasi', function ($q) use ($lokasiIds) {
                    $q->whereIn('lokasis.id', $lokasiIds);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('tanggal', fn($q) => tanggalIndo($q->tanggal_pengukuran))
                ->filterColumn('tanggal', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(tanggal_pengukuran, '%d-%m-%Y') LIKE ?", ["%$keyword%"]);
                })
                ->addColumn('jam', function ($q) {
                    $mulai = $q->jam_mulai ? \Carbon\Carbon::parse($q->jam_mulai)->format('H:i') : '-';
                    $selesai = $q->jam_selesai ? \Carbon\Carbon::parse($q->jam_selesai)->format('H:i') : '-';
                    return "{$mulai} - {$selesai}";
                })
                ->filterColumn('jam', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereRaw("TIME_FORMAT(jam_mulai, '%H:%i') LIKE ?", ["%$keyword%"])
                            ->orWhereRaw("TIME_FORMAT(jam_selesai, '%H:%i') LIKE ?", ["%$keyword%"]);
                    });
                })

                ->addColumn('lokasi', fn($q) => $q->lokasi->pluck('nama_lokasi')->implode(', '))
                ->filterColumn('lokasi', function ($query, $keyword) {
                    $query->whereHas('lokasi', function ($q) use ($keyword) {
                        $q->where('nama_lokasi', 'like', "%$keyword%");
                    });
                })

                ->addColumn('status', function ($q) {
                    $status = strtolower($q->status);
                    $badgeClass = match ($status) {
                        'dijadwalkan' => 'primary',
                        'selesai'     => 'success',
                        default       => 'secondary',
                    };
                    return '<span class="badge bg-' . $badgeClass . ' text-capitalize">' . $status . '</span>';
                })

                ->addColumn('dibuat_oleh', fn($q) => $q->createdBy->name ?? '-')
                ->filterColumn('dibuat_oleh', function ($query, $keyword) {
                    $query->whereHas('createdBy', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%$keyword%");
                    });
                })

                ->addColumn('action', function ($q) {
                    $encodedId = base64_encode((string) $q->id);
                    $detailUrl = route('lingkungan.jadwal.show', ['id' => $encodedId]);
                    $previewUrl = route('lingkungan.jadwal.previewNotaDinas', encodeId($q->id));

                    return '
                <div class="dropdown text-center">
                    <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v text-dark"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="' . $detailUrl . '">
                                <i class="fas fa-eye me-2 text-primary"></i> Detail Jadwal
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="' . $previewUrl . '" target="_blank">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Preview Nota Dinas
                            </a>
                        </li>
                    </ul>
                </div>';
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getStatusCount()
    {
        $user = Auth::user();

        $lokasiIds = $user->lokasiLingkungan()->pluck('lokasi_id');
        $baseQuery = JadwalPengukuran::query();

        if ($lokasiIds->isNotEmpty()) {
            $baseQuery->whereHas('lokasi', function ($q) use ($lokasiIds) {
                $q->whereIn('lokasis.id', $lokasiIds);
            });
        }

        $dijadwalkan = (clone $baseQuery)->where('status', 'dijadwalkan')->count();
        $selesai = (clone $baseQuery)->where('status', 'selesai')->count();

        return response()->json([
            'dijadwalkan' => $dijadwalkan,
            'selesai'     => $selesai,
        ]);
    }

    public function create(Request $request)
    {
        $menus = $request->get('dtmenus');
        $lokasiPengukuran = Lokasi::all();
        return view('lingkungan.jadwal.create', compact('lokasiPengukuran', 'menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lokasi_ids' => 'required|array',
            'lokasi_ids.*' => 'exists:lokasis,id',
            'tanggal_pengukuran' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'jam_mulai' => 'nullable|date_format:H:i|before:jam_selesai',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'catatan' => 'nullable|string|max:65535',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $tanggal = Carbon::parse($request->tanggal_pengukuran)->format('Y-m-d');
        $lokasiDuplikat = [];

        foreach ($request->lokasi_ids as $lokasiId) {
            $sudahAda = \DB::table('jadwal_lokasi')
                ->join('jadwal_pengukuran', 'jadwal_lokasi.jadwal_id', '=', 'jadwal_pengukuran.id')
                ->where('jadwal_lokasi.lokasi_id', $lokasiId)
                ->whereDate('jadwal_pengukuran.tanggal_pengukuran', $tanggal)
                ->exists();

            if ($sudahAda) {
                $nama = \DB::table('lokasis')->where('id', $lokasiId)->value('nama_lokasi');
                $lokasiDuplikat[] = $nama ?? 'ID ' . $lokasiId;
            }
        }

        if (count($lokasiDuplikat) > 0) {
            return response()->json([
                'errors' => [
                    'lokasi_ids' => ['Beberapa lokasi sudah memiliki jadwal pengukuran pada tanggal tersebut.']
                ]
            ], 422);
        }

        try {
            $jadwal = JadwalPengukuran::create([
                'tanggal_pengukuran' => $request->tanggal_pengukuran,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'catatan' => $request->catatan,
                'status' => 'dijadwalkan',
                'status_akhir' => 'menunggu_verifikasi',
                'created_by' => Auth::id(),
            ]);

            $jadwal->lokasi()->attach($request->lokasi_ids);

            $users = \App\Models\User::whereHas('lokasiLingkungan', function ($query) use ($request) {
                $query->whereIn('lokasi_id', $request->lokasi_ids);
            })->get();

            foreach ($users as $user) {
                if ($user->email) {
                    Mail::to($user->email)->send(new \App\Mail\Lingkungan\JadwalPengukuranNotification($jadwal, $user));
                }
            }

            return response()->json([
                'success' => 'Data berhasil disimpan dan email telah dikirim.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan jadwal pengukuran:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ], 500);
        }
    }

    public function show(Request $request, $encodedId)
    {
        $menus = $request->get('dtmenus');
        $id = (int) base64_decode($encodedId);

        if ($id <= 0) {
            abort(404);
        }

        $jadwal = JadwalPengukuran::with([
            'lokasi.divisis',
            'createdBy',
            'verifikator'
        ])->findOrFail($id);

        return view('lingkungan.jadwal.show', compact('jadwal', 'menus'));
    }

    public function previewNotaDinas($id)
    {
        $decodedId = decodeId($id) ?? $id;

        $jadwal = JadwalPengukuran::with('lokasi')->findOrFail($decodedId);

        $nomorNota = 'IF.' . now()->format('m') . '/' . str_pad($jadwal->id, 3, '0', STR_PAD_LEFT) . '/' . now()->format('Y');

        $pdf = Pdf::loadView('lingkungan.jadwal.nota_dinas_pdf', [
            'jadwal' => $jadwal,
            'nomorNota' => $nomorNota,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('nota_dinas_pengukuran.pdf');
    }
}
