<?php

namespace App\Http\Controllers\Lingkungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengukuran\Ipbr;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class IpbrController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('lingkungan.ipbr.index', compact('menus'));
    }

    public function fetch(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $user = Auth::user()->loadMissing('divisiInspeksi', 'lokasiLingkungan');
        $hasDivisi  = $user->divisiInspeksi->isNotEmpty();
        $hasLokasi  = $user->lokasiLingkungan->isNotEmpty();
        $isInternal = !$hasDivisi && !$hasLokasi;

        $query = DB::table('aktivitas_ipbr as a')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('identifikasi_penilaian_bahaya_resiko as k', 'a.id', '=', 'k.aktivitas_ipbr_id');

        if ($isInternal) {
            $query->select(
                DB::raw('MIN(k.id) as id'),
                'a.lokasi_pengukuran_id',
                'a.tahun',
                'a.urutan_input',
                DB::raw("GROUP_CONCAT(DISTINCT u.name SEPARATOR ', ') as pembuat")
            )
                ->groupBy('a.lokasi_pengukuran_id', 'a.tahun', 'a.urutan_input');
        } else {
            $query->select(
                DB::raw('MIN(k.id) as id'),
                'a.batch_id',
                'a.lokasi_pengukuran_id',
                'a.tahun',
                DB::raw("GROUP_CONCAT(DISTINCT u.name SEPARATOR ', ') as pembuat")
            )
                ->groupBy('a.batch_id', 'a.lokasi_pengukuran_id', 'a.tahun');

            if ($hasDivisi) {
                $divisiIds = $user->divisiInspeksi->pluck('id')->toArray();
                $query->whereIn('a.divisi_id', $divisiIds);
            } elseif ($hasLokasi) {
                $lokasiIds = $user->lokasiLingkungan->pluck('id')->toArray();
                $query->whereIn('a.lokasi_pengukuran_id', $lokasiIds);
            }
        }

        $query->orderByDesc(DB::raw('MIN(k.id)'));

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('lokasi', function ($q) {
                return DB::table('lokasis')->where('id', $q->lokasi_pengukuran_id)->value('nama_lokasi') ?? '-';
            })
            ->filterColumn('lokasi', function ($query, $keyword) {
                $query->whereExists(function ($sub) use ($keyword) {
                    $sub->select(DB::raw(1))
                        ->from('lokasis')
                        ->whereColumn('lokasis.id', 'a.lokasi_pengukuran_id')
                        ->where('lokasis.nama_lokasi', 'like', "%$keyword%");
                });
            })

            ->addColumn('tahun', fn($q) => $q->tahun ?? '-')
            ->filterColumn('tahun', function ($query, $keyword) {
                $query->where('a.tahun', 'like', "%$keyword%");
            })

            ->addColumn('dibuat_oleh', fn($q) => $q->pembuat ?? '-')
            ->filterColumn('dibuat_oleh', function ($query, $keyword) {
                $query->havingRaw("LOWER(GROUP_CONCAT(DISTINCT u.name)) LIKE ?", ["%" . strtolower($keyword) . "%"]);
            })

            ->addColumn('action', function ($q) {
                $encodedId = base64_encode((string) $q->id);
                return '
        <div class="dropdown text-center">
            <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v text-dark"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="' . route('lingkungan.ipbr.show', $encodedId) . '">
                        <i class="fas fa-eye me-2 text-primary"></i> Detail
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="' . route('lingkungan.ipbr.duplicate', $encodedId) . '">
                        <i class="fas fa-copy me-2 text-secondary"></i> Salin
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="' . route('lingkungan.ipbr.download', $encodedId) . '" target="_blank">
                        <i class="fas fa-file-pdf me-2 text-danger"></i> PDF
                    </a>
                </li>
            </ul>
        </div>
        ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $menus = $request->get('dtmenus');
        $user = Auth::user()->loadMissing('divisiInspeksi.lokasi');

        $divisi = $user->divisiInspeksi->first();
        $lokasi = $divisi?->lokasi;

        return view('lingkungan.ipbr.create', compact(
            'menus',
            'lokasi',
            'divisi',
        ));
    }

    // public function row(Request $request)
    // {
    //     $index = $request->get('index', 1);
    //     return view('lingkungan.ipbr.row', compact('index'));
    // }

    public function aktifitasRow(Request $request)
    {
        $index = $request->get('index');
        return view('lingkungan.ipbr.aktifitas', ['index' => $index]);
    }

    public function kegiatanRow(Request $request)
    {
        $aidx = $request->aidx;
        $kidx = $request->kidx;

        return view('lingkungan.ipbr.kegiatan', compact('aidx', 'kidx'));
    }

    public function store(Request $request)
    {
        $user = Auth::user()->loadMissing('divisiInspeksi');
        $userId = $user->id;
        $lokasiId = $request->lokasi_pengukuran_id;
        $tahun = $request->tahun;

        $divisi = $user->divisiInspeksi->first();
        $divisiId = $divisi?->id;

        if (!$divisiId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi pengguna tidak ditemukan.'
            ], 403);
        }

        $jumlahInputanDivisi = DB::table('aktivitas_ipbr')
            ->where('divisi_id', $divisiId)
            ->where('tahun', $tahun)
            ->distinct()
            ->count('batch_id');

        if ($jumlahInputanDivisi >= 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maksimal 2 data per tahun untuk divisi ini sudah tercapai.'
            ], 403);
        }

        $batchId = Str::uuid()->toString();

        $existingBatch = DB::table('aktivitas_ipbr')
            ->where('lokasi_pengukuran_id', $lokasiId)
            ->where('tahun', $tahun)
            ->select('batch_id', 'urutan_input')
            ->distinct()
            ->get();

        $grouped = $existingBatch->groupBy('urutan_input');

        $urutanDivisi = DB::table('aktivitas_ipbr')
            ->where('divisi_id', $divisiId)
            ->where('tahun', $tahun)
            ->pluck('urutan_input')
            ->toArray();

        $urutan = null;
        for ($i = 1; $i <= $grouped->count(); $i++) {
            if (!in_array($i, $urutanDivisi)) {
                $urutan = $i;
                break;
            }
        }

        if (!$urutan) {
            $urutan = $grouped->count() + 1;
        }

        DB::beginTransaction();
        try {
            foreach ($request->data as $item) {
                $aktivitasId = DB::table('aktivitas_ipbr')->insertGetId([
                    'user_id' => $userId,
                    'batch_id' => $batchId,
                    'lokasi_pengukuran_id' => $lokasiId,
                    'divisi_id' => $divisiId,
                    'aktifitas' => $item['aktifitas'] ?? '-',
                    'tahun' => $tahun,
                    'urutan_input' => $urutan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->insertIPBRKegiatan($aktivitasId, $item['kegiatan'] ?? []);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    private function insertIPBRKegiatan(int $aktivitasId, array $kegiatanList)
    {
        foreach ($kegiatanList as $row) {
            DB::table('identifikasi_penilaian_bahaya_resiko')->insert([
                'aktivitas_ipbr_id' => $aktivitasId,
                'potensi_bahaya' => $row['potensi_bahaya'] ?? null,
                'dampak_k3' => $row['dampak_k3'] ?? null,
                'resiko_k3' => $row['resiko_k3'] ?? null,
                'r_n' => $row['r_n'] ?? null,
                'no_dampak' => $row['no_dampak'] ?? null,
                'l' => $row['l'] ?? null,
                'c' => $row['c'] ?? null,
                'total' => $row['total'] ?? null,
                'tingkat_risiko' => $row['tingkat_risiko'] ?? null,
                'pengendalian_saat_ini' => $row['pengendalian_saat_ini'] ?? null,
                'l_after' => $row['l_after'] ?? null,
                'c_after' => $row['c_after'] ?? null,
                'total_after' => $row['total_after'] ?? null,
                'tingkat_risiko_after' => $row['tingkat_risiko_after'] ?? null,
                'peluang' => $row['peluang'] ?? null,
                'peraturan_perundangan' => $row['peraturan_perundangan'] ?? null,
                'pengendalian_lanjutan' => $row['pengendalian_lanjutan'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function show($id)
    {
        $decodedId = base64_decode($id);
        $item = Ipbr::with('aktivitas.lokasiPengukuran')->findOrFail($decodedId);

        $user = Auth::user()->loadMissing('divisiInspeksi', 'lokasiLingkungan');
        $isInternal = $user->divisiInspeksi->isEmpty() && $user->lokasiLingkungan->isEmpty();

        $aktivitas = $item->aktivitas;
        $lokasi = $aktivitas->lokasiPengukuran ?? null;
        $tahun = $aktivitas->tahun ?? null;
        $batchId = $aktivitas->batch_id ?? null;
        $urutanInput = $aktivitas->urutan_input ?? null;

        if ($isInternal && $lokasi && $tahun && $urutanInput) {
            $data = Ipbr::with(['aktivitas.lokasiPengukuran', 'aktivitas.user'])
                ->whereHas('aktivitas', function ($q) use ($lokasi, $tahun, $urutanInput) {
                    $q->where('lokasi_pengukuran_id', $lokasi->id)
                        ->where('tahun', $tahun)
                        ->where('urutan_input', $urutanInput);
                })
                ->get();
        } else {
            $data = Ipbr::with(['aktivitas.lokasiPengukuran', 'aktivitas.user'])
                ->whereHas('aktivitas', function ($q) use ($batchId) {
                    $q->where('batch_id', $batchId);
                })
                ->get();
        }

        if ($isInternal && !$batchId && $data->isNotEmpty()) {
            $batchId = $data->first()->aktivitas?->batch_id ?? null;
        }

        $groupedData = $data->groupBy(function ($item) {
            return $item->aktivitas->id;
        });

        $hasEmptyFields = $data->contains(fn($item) => !$item->peraturan_perundangan);
        $tampilForm = $isInternal && $hasEmptyFields;

        $dataHighRisk = $data->filter(fn($item) => $item->tingkat_risiko_after === 'H');
        $menus = request()->get('dtmenus');
        $encodedId = $id;
        return view('lingkungan.ipbr.show', compact(
            'groupedData',
            'dataHighRisk',
            'lokasi',
            'tahun',
            'menus',
            'encodedId',
            'decodedId',
            'batchId',
            'isInternal',
            'tampilForm'
        ));
    }

    public function updatePeraturan(Request $request, $id)
    {
        $user = auth()->user()->loadMissing('lokasiLingkungan');
        if ($user->lokasiLingkungan->isNotEmpty()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        foreach ($validated['data'] as $itemId => $fields) {
            $updateData = collect($fields)->only(['peraturan_perundangan', 'status'])->toArray();

            if (!empty($updateData)) {
                Ipbr::where('id', $itemId)->update($updateData);
            }
        }

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function duplicate($id)
    {
        $decodedId = base64_decode($id);

        $aktivitasId = DB::table('identifikasi_penilaian_bahaya_resiko')
            ->where('id', $decodedId)
            ->value('aktivitas_ipbr_id');

        if (!$aktivitasId) abort(404, 'Data tidak ditemukan.');

        $aktivitasPertama = DB::table('aktivitas_ipbr')
            ->where('id', $aktivitasId)
            ->first();

        if (!$aktivitasPertama) abort(404, 'Aktivitas tidak ditemukan.');

        $batchId = $aktivitasPertama->batch_id ?? null;
        if (!$batchId) abort(404, 'Batch tidak ditemukan.');

        $user = User::with('divisiInspeksi.lokasi')->find($aktivitasPertama->user_id);
        $divisi = $user?->divisiInspeksi->first();
        $lokasi = $divisi?->lokasi;

        $aktivitasList = DB::table('aktivitas_ipbr')->where('batch_id', $batchId)->get();
        $structured = [];

        $tahunSekarang = now()->year;

        foreach ($aktivitasList as $aktivitas) {
            $kegiatan = DB::table('identifikasi_penilaian_bahaya_resiko')
                ->where('aktivitas_ipbr_id', $aktivitas->id)
                ->get();

            $structured[] = [
                'aktifitas' => $aktivitas->aktifitas,
                'lokasi_pengukuran_id' => $aktivitas->lokasi_pengukuran_id,
                'tahun' => $tahunSekarang,
                'kegiatan' => $kegiatan,
            ];
        }

        return view('lingkungan.ipbr.create', [
            'menus' => request()->get('dtmenus'),
            'dataDuplikat' => $structured,
            'lokasi' => $lokasi,
            'divisi' => $divisi,
            'tahun' => $tahunSekarang,
        ]);
    }

    public function download($id)
    {
        $decodedId = base64_decode($id);
        $item = Ipbr::with('aktivitas.lokasiPengukuran')->findOrFail($decodedId);

        $user = Auth::user()->loadMissing('divisiInspeksi', 'lokasiLingkungan');
        $isInternal = $user->divisiInspeksi->isEmpty() && $user->lokasiLingkungan->isEmpty();

        $aktivitas = $item->aktivitas;
        $lokasi = $aktivitas->lokasiPengukuran ?? null;
        $tahun = $aktivitas->tahun ?? null;
        $urutanInput = $aktivitas->urutan_input ?? null;
        $batchId = $aktivitas->batch_id ?? null;

        if ($isInternal && $lokasi && $tahun && $urutanInput) {
            $data = Ipbr::with(['aktivitas.lokasiPengukuran', 'aktivitas.user'])
                ->whereHas('aktivitas', function ($q) use ($lokasi, $tahun, $urutanInput) {
                    $q->where('lokasi_pengukuran_id', $lokasi->id)
                        ->where('tahun', $tahun)
                        ->where('urutan_input', $urutanInput);
                })
                ->get();
        } else {
            $data = Ipbr::with(['aktivitas.lokasiPengukuran', 'aktivitas.user'])
                ->whereHas('aktivitas', function ($q) use ($batchId) {
                    $q->where('batch_id', $batchId);
                })
                ->get();
        }

        $groupedData = $data->groupBy(fn($item) => $item->aktivitas->id);

        $pdf = Pdf::loadView('lingkungan.ipbr.pdf', [
            'groupedData' => $groupedData,
            'lokasi' => $lokasi,
            'tahun' => $tahun,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Detail_IPBR.pdf');
    }
}
