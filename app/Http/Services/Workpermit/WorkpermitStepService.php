<?php

namespace App\Http\Services\Workpermit;

use App\Models\Workpermit\WorkPermit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Workpermit\WorkPermitWorker;
use App\Models\Workpermit\WorkPermitWorkerDetail;
use App\Models\Workpermit\WorkPermitEquipment;
use App\Models\Workpermit\WorkPermitJsa;
use App\Models\Workpermit\WorkPermitJsaSub;
use App\Models\Workpermit\WorkPermitApproval;
use App\Models\Workpermit\WorkPermitApprovalLevel;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;

class WorkpermitStepService
{
    public function storeStep1($request)
    {
        $workPermit = WorkPermit::firstOrNew([
            'purchase_order_id' => $request->purchase_order_id,
        ]);

        $workPermit->vendor_id = $request->vendor_id;
        $workPermit->telepon_pemohon = $request->telepon_pemohon;
        $workPermit->pengawas = $request->nama_pengawas;
        $workPermit->telepon_pengawas = $request->telepon_pengawas;

        if ($request->hasFile('lampiran_struktur')) {
            $filename = $request->file('lampiran_struktur')->store('work_permits', 'public');
            $workPermit->lampiran_struktur = $filename;
        }

        $workPermit->save();

        return $workPermit;
    }

    public function storeStep2($validated, $request)
    {
        return DB::transaction(function () use ($validated, $request) {
            $workPermitId = $validated['work_permit_id'];

            $deleteWorkerWithFiles = function ($worker) {
                if ($worker->lampiran_ktp && Storage::disk('public')->exists($worker->lampiran_ktp)) {
                    Storage::disk('public')->delete($worker->lampiran_ktp);
                }
                if ($worker->lampiran_sertifikat && Storage::disk('public')->exists($worker->lampiran_sertifikat)) {
                    Storage::disk('public')->delete($worker->lampiran_sertifikat);
                }
                $worker->delete();
            };

            if (!empty($validated['deleted_workers'])) {
                $workersToDelete = WorkPermitWorkerDetail::whereIn('id', $validated['deleted_workers'])->get();
                foreach ($workersToDelete as $worker) {
                    $deleteWorkerWithFiles($worker);
                }
            }

            foreach ($validated['nama'] as $jabatan => $namaList) {
                if (!is_array($namaList)) continue;
                $filteredNames = array_filter($namaList, fn($nama) => filled(trim($nama)));
                $workerGroup = WorkPermitWorker::firstOrCreate([
                    'work_permit_id' => $workPermitId,
                    'jabatan' => $jabatan
                ]);
                $existingWorkers = WorkPermitWorkerDetail::where('work_permit_worker_id', $workerGroup->id)
                    ->pluck('id')
                    ->toArray();

                $newWorkerIds = [];

                foreach ($filteredNames as $index => $nama) {
                    $workerId = $validated['worker_id'][$jabatan][$index] ?? null;

                    if ($workerId) {
                        $workerDetail = WorkPermitWorkerDetail::find($workerId);
                        if (!$workerDetail) {
                            $workerDetail = WorkPermitWorkerDetail::where('work_permit_worker_id', $workerGroup->id)
                                ->where('nama', $nama)
                                ->first() ?? new WorkPermitWorkerDetail();
                        }
                    } else {
                        $workerDetail = WorkPermitWorkerDetail::where('work_permit_worker_id', $workerGroup->id)
                            ->where('nama', $nama)
                            ->first() ?? new WorkPermitWorkerDetail();
                    }

                    $workerDetail->work_permit_worker_id = $workerGroup->id;
                    $workerDetail->nama = $nama;

                    if ($request->hasFile("ktp.$jabatan.$index")) {
                        if ($workerDetail->lampiran_ktp && Storage::disk('public')->exists($workerDetail->lampiran_ktp)) {
                            Storage::disk('public')->delete($workerDetail->lampiran_ktp);
                        }
                        $workerDetail->lampiran_ktp = $this->CompressFile($request->file("ktp.$jabatan.$index"), 'ktp');
                    }

                    if ($request->hasFile("sertifikat.$jabatan.$index")) {
                        if ($workerDetail->lampiran_sertifikat && Storage::disk('public')->exists($workerDetail->lampiran_sertifikat)) {
                            Storage::disk('public')->delete($workerDetail->lampiran_sertifikat);
                        }
                        $workerDetail->lampiran_sertifikat = $this->CompressFile($request->file("sertifikat.$jabatan.$index"), 'sertifikat');
                    }

                    $workerDetail->save();
                    session(['work_permit_id' => $workerDetail->id]);
                    $newWorkerIds[] = $workerDetail->id;
                }

                $workersToRemove = array_diff($existingWorkers, $newWorkerIds, $validated['deleted_workers'] ?? []);

                if (!empty($workersToRemove)) {
                    $workersToDelete = WorkPermitWorkerDetail::whereIn('id', $workersToRemove)->get();
                    foreach ($workersToDelete as $worker) {
                        $deleteWorkerWithFiles($worker);
                    }
                }

                $workerGroup->update(['jumlah' => $workerGroup->workerDetails()->count()]);

                if ($workerGroup->workerDetails()->count() === 0) {
                    $workerGroup->delete();
                }
            }

            $deletedGroups = WorkPermitWorker::where('work_permit_id', $workPermitId)
                ->doesntHave('workerDetails')
                ->get();

            foreach ($deletedGroups as $group) {
                $group->delete();
            }

            return $workPermitId;
        });
    }

    public function storeStep3(array $validated, $request)
    {
        return DB::transaction(function () use ($validated, $request) {
            $workPermitId = $validated['work_permit_id'];

            if (!empty($validated['deleted_equipment'])) {
                WorkPermitEquipment::whereIn('id', $validated['deleted_equipment'])->delete();
            }

            $newEquipmentIds = [];
            if (!empty($validated['nama'])) {
                foreach ($validated['nama'] as $index => $nama) {
                    if (!filled($nama)) continue;

                    $kategori = $validated['kategori'][$index] ?? null;
                    $jumlah = $validated['jumlah'][$index] ?? null;
                    $lampiranFoto = $request->file("lampiran_foto.$index");

                    if (!$kategori || !$jumlah) {
                        continue;
                    }

                    $equipment = WorkPermitEquipment::updateOrCreate(
                        ['work_permit_id' => $workPermitId, 'nama' => $nama],
                        ['kategori' => $kategori, 'jumlah' => $jumlah]
                    );

                    if ($lampiranFoto) {
                        if ($equipment->lampiran_foto) {
                            Storage::disk('public')->delete($equipment->lampiran_foto);
                        }
                        $equipment->lampiran_foto = $lampiranFoto->store('uploads/peralatan', 'public');
                    }

                    $equipment->save();
                    session(['work_permit_id' => $equipment->id]);
                    $newEquipmentIds[] = $equipment->id;
                }
            }

            return $workPermitId;
        });
    }

    public function storeStep4($validated, $request)
    {
        if (!isset($validated['jsa']) || !is_array($validated['jsa']) || empty($validated['jsa'])) {
            return response()->json([
                'success' => false,
                'message' => 'Data JSA tidak boleh kosong.'
            ], 422);
        }

        $workPermit = WorkPermit::with('purchaseOrder.vendor')->findOrFail($validated['work_permit_id']);
        $purchaseOrder = $workPermit->purchaseOrder;

        if (!$purchaseOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Work Permit tidak memiliki Purchase Order yang valid.'
            ], 422);
        }

        DB::transaction(function () use ($validated, $workPermit, $purchaseOrder) {
            $this->setNomorDokumen($workPermit);

            $this->hapusJSALama($validated, $workPermit);

            $this->resetApproval($workPermit);
            $this->updateStatus($workPermit, $purchaseOrder);
        });
    }

    protected function setNomorDokumen($workPermit)
    {
        $tahun = date('Y');
        $total = DB::table('work_permits')->whereYear('created_at', $tahun)->count();
        $noDokumen = str_pad($total + 1, 4, '0', STR_PAD_LEFT) . "/SHE/{$tahun}";
        $workPermit->update(['no_dokumen' => $noDokumen]);
    }

    protected function hapusJSALama($validated, $workPermit)
    {
        $jsaIds = WorkPermitJsa::where('work_permit_id', $workPermit->id)->pluck('id');

        if ($jsaIds->isNotEmpty()) {
            WorkPermitJsaSub::whereIn('jsa_id', $jsaIds)->delete();
        }

        WorkPermitJsa::where('work_permit_id', $workPermit->id)->delete();

        $jsaGroup = [];

        foreach ($validated['jsa'] as $item) {
            if (!isset($item['tahapan'], $item['sub_tahapan'])) continue;

            $tahapan = $item['tahapan'];

            $jsaGroup[$tahapan][] = [
                'sub_tahapan' => $item['sub_tahapan'],
                'identifikasi_bahaya' => $item['identifikasi_bahaya'] ?? null,
                'pengendalian_risiko' => $item['pengendalian_risiko'] ?? null,
            ];
        }

        foreach ($jsaGroup as $tahapan => $subItems) {
            $jsa = WorkPermitJsa::create([
                'work_permit_id' => $workPermit->id,
                'tahapan' => $tahapan
            ]);

            foreach ($subItems as $sub) {
                WorkPermitJsaSub::create(array_merge($sub, ['jsa_id' => $jsa->id]));
            }
        }
    }

    protected function resetApproval($workPermit)
    {
        if ($workPermit->approvals()->where('status', 'rejected')->exists()) {
            $lastRejected = $workPermit->approvals()->where('status', 'rejected')->latest('approved_at')->first();
            if ($lastRejected) {
                $workPermit->approvals()
                    ->where('approved_at', '>=', $lastRejected->approved_at)
                    ->update([
                        'status' => 'pending',
                        'approved_at' => null,
                        'keterangan' => null
                    ]);
            }
        } else {
            $this->handleApproval($workPermit);
        }
    }

    protected function handleApproval($workPermit)
    {
        $firstLevel = WorkPermitApprovalLevel::orderBy('level')->first();

        WorkPermitApproval::create([
            'work_permit_id' => $workPermit->id,
            'permission_name' => $firstLevel->permission_name,
            'level' => $firstLevel->level,
            'status' => 'pending'
        ]);
    }

    protected function updateStatus($workPermit, $purchaseOrder)
    {
        if (!in_array($workPermit->status, ['approved', 'completed'])) {
            $workPermit->update(['status' => 'submitted']);
        }

        if (!in_array($purchaseOrder->status, ['approved', 'completed'])) {
            $purchaseOrder->update(['status' => 'submitted']);
        }
    }

    protected function CompressFile($file, $folder)
    {
        $path = "uploads/{$folder}";
        $disk = 'public';

        if ($file->getClientOriginalExtension() === 'pdf') {
            return $file->store($path, $disk);
        }

        $image = Image::read($file)->resize(null, null);
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $fullPath = storage_path("app/public/{$path}/{$filename}");

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $image->save($fullPath);

        return "{$path}/{$filename}";
    }
}
