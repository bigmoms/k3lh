<?php

namespace App\Http\Controllers\Lingkungan;

use App\Http\Controllers\Controller;
use App\Models\Pengukuran\JadwalPengukuran;
use App\Models\Pengukuran\PengukuranLingkungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Dompdf\Dompdf;
use Illuminate\Support\Str;

class HasilController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('lingkungan.hasil.index', ['menus' => $menus]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $query = PengukuranLingkungan::with(['jadwal.lokasi.divisis'])
                ->whereIn('pengukuran_lingkungan.id', function ($subquery) {
                    $subquery->selectRaw('MIN(pengukuran_lingkungan.id)')
                        ->from('pengukuran_lingkungan')
                        ->groupBy('jadwal_id');
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('tanggal', fn($q) => tanggalIndo($q->jadwal->tanggal_pengukuran ?? null))
                ->addColumn('lokasi', fn($q) => $q->jadwal->lokasi->pluck('nama_lokasi')->implode(', ') ?? '-')
                ->addColumn('divisi', function ($q) {
                    return $q->jadwal->lokasi->flatMap(fn($lok) => $lok->divisis->pluck('nama_divisi'))
                        ->unique()
                        ->implode(', ');
                })
                ->addColumn('action', function ($q) {
                    $encodedId = base64_encode((string) $q->jadwal_id);
                    $detailUrl = route('lingkungan.hasil.show', ['id' => $encodedId]);
                    $printUrl = route('pengukuran.previewPdf', $q->jadwal_id);

                    return '
                    <div class="dropdown text-center">
                        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-dark"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="' . $detailUrl . '"><i class="fas fa-eye me-2 text-primary"></i> Detail Hasil</a></li>
                            <li><a class="dropdown-item" href="' . $printUrl . '" target="_blank"><i class="fas fa-print me-2 text-danger"></i> Print Hasil</a></li>
                        </ul>
                    </div>';
                })
                ->filterColumn('tanggal', function ($query, $keyword) {
                    $query->whereHas('jadwal', function ($q) use ($keyword) {
                        $q->whereRaw("DATE_FORMAT(tanggal_pengukuran, '%d-%m-%Y') LIKE ?", ["%$keyword%"]);
                    });
                })
                ->filterColumn('lokasi', function ($query, $keyword) {
                    $query->whereHas('jadwal.lokasi', function ($q) use ($keyword) {
                        $q->where('nama_lokasi', 'like', "%$keyword%");
                    });
                })
                ->filterColumn('divisi', function ($query, $keyword) {
                    $query->whereHas('jadwal.lokasi.divisis', function ($q) use ($keyword) {
                        $q->where('nama_divisi', 'like', "%$keyword%");
                    });
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $menus = $request->get('dtmenus');
        $jadwalPengukuran = JadwalPengukuran::where('status', 'dijadwalkan')
            ->with(['lokasi', 'lokasi.divisis'])
            ->whereDoesntHave('pengukuran')
            ->get();

        return view('lingkungan.hasil.create', compact('jadwalPengukuran', 'menus'));
    }

    public function getLokasiDivisi(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $jadwal = JadwalPengukuran::with('lokasi.divisis')->find($jadwalId);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json([
            'lokasi' => $jadwal->lokasi->map(function ($lokasi) {
                return [
                    'id' => $lokasi->id,
                    'nama_lokasi' => $lokasi->nama_lokasi,
                    'divisis' => $lokasi->divisis->map(function ($divisi) {
                        return [
                            'id' => $divisi->id,
                            'nama_divisi' => $divisi->nama_divisi,
                        ];
                    }),
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jadwal_id' => 'required|exists:jadwal_pengukuran,id',
            'divisi' => 'required|array',
            'divisi.*' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $jadwal = JadwalPengukuran::with(['lokasi.divisis', 'lokasi.users'])->findOrFail($request->jadwal_id);

        $lokasiList = $jadwal->lokasi;
        if ($lokasiList->isEmpty()) {
            return response()->json(['errors' => ['lokasi' => 'Tidak ada lokasi terkait dengan jadwal ini']], 400);
        }

        $divisiIdsValid = $lokasiList->flatMap(function ($lokasi) {
            return $lokasi->divisis->pluck('id');
        })->unique()->toArray();

        $dataToInsert = [];

        foreach ($request->divisi as $lokasiId => $divisis) {
            foreach ($divisis as $divisiId => $data) {
                if (!in_array($divisiId, $divisiIdsValid)) {
                    continue;
                }

                $dataToInsert[] = [
                    'jadwal_id' => $request->jadwal_id,
                    'divisi_id' => $divisiId,
                    'cahaya_1' => $data['cahaya_1'] ?? null,
                    'cahaya_2' => $data['cahaya_2'] ?? null,
                    'cahaya_3' => $data['cahaya_3'] ?? null,
                    'cahaya_rata2' => $data['cahaya_rata2'] ?? null,
                    'suhu_1' => $data['suhu_1'] ?? null,
                    'suhu_2' => $data['suhu_2'] ?? null,
                    'suhu_3' => $data['suhu_3'] ?? null,
                    'suhu_rata2' => $data['suhu_rata2'] ?? null,
                    'kelembaban_1' => $data['kelembaban_1'] ?? null,
                    'kelembaban_2' => $data['kelembaban_2'] ?? null,
                    'kelembaban_3' => $data['kelembaban_3'] ?? null,
                    'kelembaban_rata2' => $data['kelembaban_rata2'] ?? null,
                    'kebisingan_1' => $data['kebisingan_1'] ?? null,
                    'kebisingan_2' => $data['kebisingan_2'] ?? null,
                    'kebisingan_3' => $data['kebisingan_3'] ?? null,
                    'kebisingan_rata2' => $data['kebisingan_rata2'] ?? null,
                    'catatan' => $data['catatan'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($dataToInsert)) {
            PengukuranLingkungan::insert($dataToInsert);
        }

        foreach ($lokasiList as $lokasi) {
            if ($lokasi->users && $lokasi->users->count()) {
                foreach ($lokasi->users as $user) {
                    if ($user->email) {
                        Mail::to($user->email)->send(
                            new \App\Mail\Lingkungan\HasilPengukuranNotification($jadwal, $lokasi)
                        );
                    }
                }
            }
        }

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function konfirmasiPenerimaan($id, Request $request)
    {
        $jadwal = JadwalPengukuran::with('lokasi')->findOrFail($id);
        $user = Auth::user()->load('lokasiLingkungan');

        $lokasiId = $request->get('lokasi_id');

        if (!$lokasiId || !$user->lokasiLingkungan->pluck('id')->contains($lokasiId)) {
            return back()->with('error', 'Anda tidak memiliki akses ke lokasi ini.');
        }

        $konfirmasi = $jadwal->konfirmasi_lokasi ?? [];
        $konfirmasi[$lokasiId] = [
            'user_id' => $user->id,
            'nama' => $user->name,
            'tanggal' => now()->toDateTimeString(),
        ];

        $jadwal->update([
            'konfirmasi_lokasi' => $konfirmasi,
        ]);

        $lokasiJadwalIds = $jadwal->lokasi->pluck('id')->toArray();
        $sudahSemua = collect($lokasiJadwalIds)->diff(array_keys($konfirmasi))->isEmpty();

        if ($sudahSemua) {
            $jadwal->update([
                'status' => 'selesai',
                'status_akhir' => 'selesai',
                'verifikasi_oleh' => $user->id,
                'verifikasi_tanggal' => now(),
            ]);
        }

        return back()->with('success', 'Konfirmasi berhasil disimpan.');
    }

    public function show($encodedId, Request $request)
    {
        $menus = $request->get('dtmenus');
        $jadwalId = base64_decode($encodedId);

        $user = Auth::user()->load('lokasiLingkungan');
        $userLokasiIds = $user->lokasiLingkungan->pluck('id')->toArray();

        $jadwal = JadwalPengukuran::with('lokasi.divisis')->findOrFail($jadwalId);

        if (!empty($userLokasiIds)) {
            $filteredLokasi = $jadwal->lokasi->filter(function ($lok) use ($userLokasiIds) {
                return in_array($lok->id, $userLokasiIds);
            });

            $jadwal->setRelation('lokasi', $filteredLokasi->values());
        }

        $pengukurans = PengukuranLingkungan::where('jadwal_id', $jadwalId)
            ->get()
            ->groupBy('divisi_id');

        return view('lingkungan.hasil.show', [
            'menus' => $menus,
            'jadwal' => $jadwal,
            'pengukurans' => $pengukurans,
            'user' => $user,
        ]);
    }

    public function previewPdf($id)
    {
        $user = Auth::user()->load('lokasiLingkungan');
        $userLokasiIds = $user->lokasiLingkungan->pluck('id')->toArray();

        $jadwal = JadwalPengukuran::with(['lokasi.divisis'])->findOrFail($id);

        if (!empty($userLokasiIds)) {
            $filteredLokasi = $jadwal->lokasi->filter(function ($lok) use ($userLokasiIds) {
                return in_array($lok->id, $userLokasiIds);
            });

            $jadwal->setRelation('lokasi', $filteredLokasi->values());
        }

        $pengukurans = PengukuranLingkungan::where('jadwal_id', $jadwal->id)
            ->get()
            ->groupBy('divisi_id');

        $data = compact('jadwal', 'pengukurans');

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $pdf = new \Dompdf\Dompdf($options);
        $html = view('lingkungan.hasil.print', $data)->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="hasil_pengukuran_lingkungan.pdf"');
    }
}
