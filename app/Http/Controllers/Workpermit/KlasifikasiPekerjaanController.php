<?php

namespace App\Http\Controllers\Workpermit;

use App\Http\Controllers\Controller;
use App\Models\Workpermit\JobClassification;
use App\Models\Workpermit\JobClassificationSafetyEquipment;
use App\Models\Workpermit\SafetyEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KlasifikasiPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $menus  = $request->get('dtmenus');
        return view('workpermit.klasifikasi.index', ['menus' => $menus]);
    }

    public function fetch()
    {
        $data = JobClassification::with(['apds', 'emergencyEquipments'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('apd', function ($row) {
                return $row->apds->map(function ($apd) {
                    return '<span class="badge bg-primary mb-1">' . e($apd->name) . '</span>';
                })->implode(' ');
            })
            ->addColumn('perlengkapan', function ($row) {
                return $row->emergencyEquipments->map(function ($item) {
                    return '<span class="badge bg-danger mb-1">' . e($item->name) . '</span>';
                })->implode(' ');
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.klasifikasi.edit', encodeId($row->id));
                $deleteUrl = route('admin.klasifikasi.destroy', $row->id);

                return '
    <div class="dropdown text-center">
        <button class="btn btn-sm btn-icon btn-light shadow-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="' . $editUrl . '">
                    <i class="fas fa-edit me-2 text-primary"></i> Edit
                </a>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center delete" data-id="' . $row->id . '" data-url="' . $deleteUrl . '">
                    <i class="fas fa-trash-alt me-2 text-danger"></i> Hapus
                </button>
            </li>
        </ul>
    </div>
    ';
            })

            ->rawColumns(['apd', 'perlengkapan', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $existingApds = SafetyEquipment::where('type', 'apd')->get();
        $menus  = $request->get('dtmenus');
        $existingPerlengkapans = SafetyEquipment::where('type', 'perlengkapan_darurat')->get();
        return view('workpermit.klasifikasi.create', compact('existingApds', 'menus', 'existingPerlengkapans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:job_classifications,name',
            'apds' => 'nullable|array',
            'perlengkapans' => 'nullable|array',
        ], [
            'name.unique' => 'Nama Klasifikasi Pekerjaan sudah ada'
        ]);

        $klasifikasi = JobClassification::create([
            'name' => $validatedData['name'],
        ]);

        $apdIds = collect($validatedData['apds'] ?? [])->map(function ($apdName) {
            return SafetyEquipment::firstOrCreate(['name' => $apdName, 'type' => 'apd'])->id;
        })->toArray();

        $perlengkapanIds = collect($validatedData['perlengkapans'] ?? [])->map(function ($perlengkapanName) {
            return SafetyEquipment::firstOrCreate(['name' => $perlengkapanName, 'type' => 'perlengkapan_darurat'])->id;
        })->toArray();

        $klasifikasi->safetyEquipments()->sync(array_merge($apdIds, $perlengkapanIds));

        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }

    public function edit(Request $request, $hash)
    {
        $id = decodeId($hash);
        $klasifikasi = JobClassification::with(['safetyEquipments', 'emergencyEquipments'])->findOrFail($id);
        $existingApds = SafetyEquipment::where('type', 'apd')->get();
        $existingPerlengkapans = SafetyEquipment::where('type', 'perlengkapan_darurat')->get();
        $selectedApds = $klasifikasi->safetyEquipments->pluck('id')->toArray();
        $selectedPerlengkapans = $klasifikasi->emergencyEquipments->pluck('id')->toArray();
        $menus  = $request->get('dtmenus');
        return view('workpermit.klasifikasi.edit', compact(
            'klasifikasi',
            'existingApds',
            'existingPerlengkapans',
            'selectedApds',
            'selectedPerlengkapans',
            'menus'
        ));
    }

    public function update(Request $request, $hash)
    {
        $id = decodeId($hash);
        if (!$id) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:job_classifications,name,' . $id,
            'description' => 'nullable|string',
            'apds' => 'nullable|array',
            'perlengkapans' => 'nullable|array',
        ], [
            'name.unique' => 'Nama Klasifikasi Pekerjaan sudah ada'
        ]);

        $klasifikasi = JobClassification::findOrFail($id);
        $klasifikasi->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        $apdIds = collect($validatedData['apds'] ?? [])->map(function ($apdName) {
            return SafetyEquipment::firstOrCreate(['name' => $apdName, 'type' => 'apd'])->id;
        })->toArray();

        $perlengkapanIds = collect($validatedData['perlengkapans'] ?? [])->map(function ($perlengkapanName) {
            return SafetyEquipment::firstOrCreate(['name' => $perlengkapanName, 'type' => 'perlengkapan_darurat'])->id;
        })->toArray();

        $klasifikasi->safetyEquipments()->sync(array_merge($apdIds, $perlengkapanIds));

        return response()->json(['message' => 'Data berhasil diperbarui'], 200);
    }

    public function destroy($id)
    {
        JobClassification::findOrFail($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
