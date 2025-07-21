<?php

namespace App\Http\Controllers\Inspeksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inspeksi\JadwalInspeksi;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inspeksi\JadwalInspeksiNotification;
use App\Models\Inspeksi\HasilInspeksi;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalInspeksiController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('inspeksi.jadwal.index', ['menus' => $menus]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $statusFilter = $request->input('status', 'dijadwalkan');

            $query = JadwalInspeksi::with(['divisiInspeksi.lokasi', 'createdBy'])
                ->where('status', $statusFilter);

            if ($user->divisiInspeksi()->exists()) {
                $query->whereHas('divisiInspeksi.users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            }

            $query->latest();

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('tanggal', fn($q) => tanggalIndo($q->tanggal_inspeksi))
                ->filterColumn('tanggal', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(tanggal_inspeksi, '%d-%m-%Y') LIKE ?", ["%$keyword%"]);
                })

                ->addColumn('jam', fn($q) => \Carbon\Carbon::parse($q->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($q->jam_selesai)->format('H:i'))
                ->filterColumn('jam', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->whereRaw("TIME_FORMAT(jam_mulai, '%H:%i') LIKE ?", ["%$keyword%"])
                            ->orWhereRaw("TIME_FORMAT(jam_selesai, '%H:%i') LIKE ?", ["%$keyword%"]);
                    });
                })

                ->addColumn('divisi', fn($q) => $q->divisiInspeksi->nama_divisi ?? '-')
                ->filterColumn('divisi', function ($query, $keyword) {
                    $query->whereHas('divisiInspeksi', function ($q) use ($keyword) {
                        $q->where('nama_divisi', 'like', "%$keyword%");
                    });
                })

                ->addColumn('lokasi', fn($q) => $q->divisiInspeksi->lokasi->nama_lokasi ?? '-')
                ->filterColumn('lokasi', function ($query, $keyword) {
                    $query->whereHas('divisiInspeksi.lokasi', function ($q) use ($keyword) {
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
                    $detailUrl = route('inspeksi.jadwal.show', ['id' => $encodedId]);
                    $previewUrl = route('inspeksi.jadwal.previewNotaDinas', encodeId($q->id));

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

        $baseQuery = JadwalInspeksi::query();
        if ($user->divisiInspeksi()->exists()) {
            $baseQuery->whereHas('divisiInspeksi.users', fn($q) => $q->where('users.id', $user->id));
        }

        return response()->json([
            'dijadwalkan' => (clone $baseQuery)->where('status', 'dijadwalkan')->count(),
            'selesai' => (clone $baseQuery)->where('status', 'selesai')->count(),
        ]);
    }

    public function create(Request $request)
    {
        $menus = $request->get('dtmenus');
        $divisiInspeksi = Division::all();
        return view('inspeksi.jadwal.create', compact('divisiInspeksi', 'menus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'divisi_inspeksi_id' => 'required|exists:divisions,id',
            'tanggal_inspeksi' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            'jam_mulai' => 'required|date_format:H:i|before:jam_selesai',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'catatan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $existing = JadwalInspeksi::where('divisi_inspeksi_id', $request->divisi_inspeksi_id)
            ->whereDate('tanggal_inspeksi', Carbon::parse($request->tanggal_inspeksi)->format('Y-m-d'))
            ->exists();

        if ($existing) {
            return response()->json([
                'errors' => [
                    'divisi_inspeksi_id' => ['Divisi ini sudah memiliki jadwal inspeksi pada tanggal tersebut.']
                ]
            ], 422);
        }

        $jadwal = JadwalInspeksi::create([
            'divisi_inspeksi_id' => $request->divisi_inspeksi_id,
            'tanggal_inspeksi' => $request->tanggal_inspeksi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'catatan' => $request->catatan,
            'status' => 'dijadwalkan',
            'created_by' => Auth::id(),
        ]);

        $divisi = $jadwal->divisiInspeksi;

        if ($divisi && $divisi->users->isNotEmpty()) {
            foreach ($divisi->users as $user) {
                if ($user->email) {
                    Mail::to($user->email)->send(new JadwalInspeksiNotification($jadwal));
                }
            }
        }

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function show(Request $request, $encodedId)
    {
        $menus = $request->get('dtmenus');
        $id = (int) base64_decode($encodedId);

        if ($id <= 0) {
            abort(404);
        }

        $jadwalInspeksi = JadwalInspeksi::with(['divisiInspeksi.lokasi', 'divisiInspeksi.users'])->findOrFail($id);

        $userDivisi = $jadwalInspeksi->divisiInspeksi->users;
        return view('inspeksi.jadwal.show', compact('jadwalInspeksi', 'userDivisi', 'menus'));
    }

    public function previewNotaDinas($id)
    {
        $decodedId = decodeId($id) ?? $id;

        $jadwal = JadwalInspeksi::with('divisiInspeksi', 'divisiInspeksi.users')->findOrFail($decodedId);

        $nomorNota = 'IF.' . now()->format('m') . '/' . str_pad($jadwal->id, 3, '0', STR_PAD_LEFT) . '/' . now()->format('Y');

        $pdf = Pdf::loadView('inspeksi.jadwal.nota_dinas_pdf', [
            'jadwal' => $jadwal,
            'nomorNota' => $nomorNota,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('nota_dinas_inspeksi.pdf');
    }
}
