<?php

namespace App\Http\Controllers\Inspeksi;

use App\Http\Controllers\Controller;
use App\Models\Inspeksi\HasilInspeksi;
use App\Models\Inspeksi\TindakLanjutInspeksi;
use App\Models\Inspeksi\JadwalInspeksi;
use App\Models\Inspeksi\CekMateriInspeksi;
use App\Models\Inspeksi\KategoriInspeksi;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inspeksi\VerifikasiInspeksiNotification;

class InspeksiController extends Controller
{
    public function index(Request $request)
    {
        $menus = $request->get('dtmenus');
        return view('inspeksi.hasil.index', ['menus' => $menus]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $query = HasilInspeksi::with(['jadwalInspeksi.divisiInspeksi.lokasi', 'tindakLanjut'])
                ->whereIn('hasil_inspeksi.id', function ($subquery) {
                    $subquery->selectRaw('MIN(id)')
                        ->from('hasil_inspeksi')
                        ->groupBy('jadwal_inspeksi_id');
                });

            if ($user->divisiInspeksi()->exists()) {
                $query->whereHas('jadwalInspeksi.divisiInspeksi.users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('tanggal', fn($q) => tanggalIndo($q->jadwalInspeksi->tanggal_inspeksi ?? null))
                ->filterColumn('tanggal', function ($query, $keyword) {
                    $query->whereHas('jadwalInspeksi', function ($q) use ($keyword) {
                        $q->whereRaw("DATE_FORMAT(tanggal_inspeksi, '%d-%m-%Y') LIKE ?", ["%$keyword%"]);
                    });
                })

                ->addColumn('divisi', fn($q) => $q->jadwalInspeksi->divisiInspeksi->nama_divisi ?? '-')
                ->filterColumn('divisi', function ($query, $keyword) {
                    $query->whereHas('jadwalInspeksi.divisiInspeksi', function ($q) use ($keyword) {
                        $q->where('nama_divisi', 'like', "%$keyword%");
                    });
                })

                ->addColumn('lokasi', fn($q) => $q->jadwalInspeksi->divisiInspeksi->lokasi->nama_lokasi ?? '-')
                ->filterColumn('lokasi', function ($query, $keyword) {
                    $query->whereHas('jadwalInspeksi.divisiInspeksi.lokasi', function ($q) use ($keyword) {
                        $q->where('nama_lokasi', 'like', "%$keyword%");
                    });
                })

                ->addColumn('action', function ($q) {
                    $encodedId = base64_encode((string) $q->jadwal_inspeksi_id);
                    $detailUrl = route('inspeksi.hasil.show', ['id' => $encodedId]);
                    $printUrl = route('inspeksi.previewPdf', $q->jadwal_inspeksi_id);

                    $dropdown = '
                <div class="dropdown text-center">
                    <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v text-dark"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="' . $detailUrl . '">
                                <i class="fas fa-eye me-2 text-primary"></i> Detail Hasil
                            </a>
                        </li>';

                    if ($q->jadwalInspeksi?->status_akhir === 'selesai') {
                        $dropdown .= '
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="' . $printUrl . '" target="_blank">
                                <i class="fas fa-print me-2 text-danger"></i> Print Hasil
                            </a>
                        </li>';
                    }

                    $dropdown .= '</ul></div>';

                    return $dropdown;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $menus = $request->get('dtmenus');
        $user = Auth::user();

        if ($user->divisiInspeksi()->exists()) {
            abort(403, 'Unauthorized access.');
        }
        $jadwalInspeksi = JadwalInspeksi::where('status', 'dijadwalkan')
            ->whereDoesntHave('hasilInspeksi')
            ->whereHas('divisiInspeksi')
            ->with('divisiInspeksi')
            ->get();

        $kategoriInspeksi = KategoriInspeksi::with('subKategori')->get();

        $kategoriInspeksiData = $kategoriInspeksi->map(function ($kategori) {
            return [
                'nama' => $kategori->nama_kategori,
                'subKategori' => $kategori->subKategori->map(function ($sub) {
                    return [
                        'id' => $sub->id,
                        'nama_sub_kategori' => $sub->nama_sub_kategori
                    ];
                })->toArray(),
            ];
        })->toArray();

        return view('inspeksi.hasil.create', compact('jadwalInspeksi', 'kategoriInspeksi', 'menus', 'kategoriInspeksiData'));
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();

        try {
            $request->validate([
                'jadwal_inspeksi_id' => 'required|exists:jadwal_inspeksi,id',
                'hasil_inspeksi' => 'required|array',
                'saran_perbaikan' => 'required|array',
                'target_penyelesaian' => 'required|array',
                'hasil_gambar' => 'nullable|array',
                'hasil_gambar.*' => 'mimes:jpg,jpeg,png|max:2048',
            ]);

            $cekMateri = $request->input('cek_materi', []);
            $errors = [];

            foreach ($cekMateri as $id => $data) {
                if (empty($data['status'])) {
                    $errors["cek_materi.$id.status"] = ['Status (TS/S) wajib dipilih.'];
                } elseif ($data['status'] === 'TS' && empty($data['catatan'])) {
                    $errors["cek_materi.$id.catatan"] = ['Catatan wajib diisi jika memilih TS.'];
                }
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            foreach ($request->hasil_inspeksi as $key => $hasilInspeksiText) {
                $hasilInspeksi = new HasilInspeksi();
                $hasilInspeksi->jadwal_inspeksi_id = $request->jadwal_inspeksi_id;
                $hasilInspeksi->hasil_inspeksi = $hasilInspeksiText;

                $path = null;
                if (isset($request->file('hasil_gambar')[$key])) {
                    $file = $request->file('hasil_gambar')[$key];
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/hasil_inspeksi', $filename, 'public');
                }

                $hasilInspeksi->hasil_gambar = $path;
                $hasilInspeksi->save();

                TindakLanjutInspeksi::create([
                    'hasil_inspeksi_id' => $hasilInspeksi->id,
                    'saran_perbaikan' => $request->saran_perbaikan[$key],
                    'target_penyelesaian' => $request->target_penyelesaian[$key],
                ]);
            }

            foreach ($cekMateri as $subKategoriId => $data) {
                CekMateriInspeksi::create([
                    'jadwal_inspeksi_id' => $request->jadwal_inspeksi_id,
                    'sub_kategori_id' => $subKategoriId,
                    'status' => $data['status'],
                    'catatan' => $data['catatan'] ?? null,
                ]);
            }

            \DB::commit();

            $jadwal = JadwalInspeksi::with('divisiInspeksi.users')->find($request->jadwal_inspeksi_id);
            $hasilInspeksi = HasilInspeksi::with('tindakLanjut')
                ->where('jadwal_inspeksi_id', $jadwal->id)
                ->get();

            $users = $jadwal->divisiInspeksi->users ?? collect();

            foreach ($users as $user) {
                if ($user->email) {
                    Mail::to($user->email)->send(new \App\Mail\Inspeksi\HasilInspeksiNotification($jadwal, $hasilInspeksi));
                }
            }

            return response()->json(['message' => 'Data berhasil disimpan dan email dikirim.'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error saving inspection data: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $menus = $request->get('dtmenus');
        $decodedJadwalId = decodeId($id);

        $hasilInspeksiList = HasilInspeksi::with(['jadwalInspeksi.divisiInspeksi', 'tindakLanjut'])
            ->where('jadwal_inspeksi_id', $decodedJadwalId)
            ->get();
        $jadwal = JadwalInspeksi::with(['divisiInspeksi', 'cekMateriInspeksi.subKategori.kategori'])
            ->findOrFail($decodedJadwalId);
        $semuaTindakLanjutSudahSelesai = $jadwal->hasilInspeksi
            ->flatMap(fn($hasil) => $hasil->tindakLanjut)
            ->where('status', '!=', 'selesai')
            ->count() == 0;

        return view('inspeksi.hasil.show', compact('hasilInspeksiList', 'jadwal', 'semuaTindakLanjutSudahSelesai', 'menus'));
    }

    public function updatePerbaikan(Request $request, $id)
    {
        $validated = $request->validate([
            'foto_perbaikan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan_perbaikan' => 'required|string',
        ]);

        $tindakLanjut = TindakLanjutInspeksi::findOrFail($id);
        $tindakLanjut->catatan_perbaikan = $validated['catatan_perbaikan'];
        $tindakLanjut->telah_diperbaiki = $request->has('telah_diperbaiki') ? 1 : 0;

        if ($tindakLanjut->telah_diperbaiki) {
            $tindakLanjut->status = 'selesai';
        }

        if ($request->hasFile('foto_perbaikan')) {
            $path = $request->file('foto_perbaikan')->store('perbaikan_foto', 'public');
            $tindakLanjut->foto_perbaikan = $path;
        }

        $tindakLanjut->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Perbaikan berhasil disimpan',
                'foto_perbaikan_url' => $tindakLanjut->foto_perbaikan ? asset('storage/' . $tindakLanjut->foto_perbaikan) : null,
                'status' => $tindakLanjut->status,
            ]);
        }

        return back()->with('success', 'Perbaikan berhasil disimpan');
    }

    public function selesaikanInspeksi($id)
    {
        $jadwal = JadwalInspeksi::with('divisiInspeksi.users')->findOrFail($id);

        foreach ($jadwal->hasilInspeksi as $hasil) {
            if ($hasil->tindakLanjut()->where('status', '!=', 'selesai')->exists()) {
                return back()->with('error', 'Masih ada temuan yang belum diperbaiki.');
            }
        }

        $jadwal->status = 'selesai';
        $jadwal->status_akhir = 'selesai';
        $jadwal->verifikasi_oleh = auth()->id();
        $jadwal->verifikasi_tanggal = now();
        $jadwal->save();

        foreach ($jadwal->divisiInspeksi->users as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new VerifikasiInspeksiNotification($jadwal));
            }
        }

        return back()->with('success', 'Inspeksi berhasil diselesaikan dan email verifikasi dikirim.');
    }

    public function previewPdf($id)
    {
        $jadwal = JadwalInspeksi::with(['hasilInspeksi.tindakLanjut', 'divisiInspeksi'])->findOrFail($id);

        $data = [
            'jadwal' => $jadwal,
        ];

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);

        $html = view('inspeksi.hasil.print', $data)->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="form_tindak_lanjut_inspeksi.pdf"');
    }
}
