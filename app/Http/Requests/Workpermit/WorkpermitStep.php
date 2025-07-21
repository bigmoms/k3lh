<?php

namespace App\Http\Requests\Workpermit;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Workpermit\WorkPermitJsa;

class WorkpermitStep extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isStep1()) {
            return $this->rulesForStep1();
        }

        if ($this->isStep2()) {
            return $this->rulesForStep2();
        }

        if ($this->isStep3()) {
            return $this->rulesForStep3();
        }

        if ($this->isStep4()) {
            return $this->rulesForStep4();
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'lampiran_struktur.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',
            'lampiran_struktur.max' => 'Ukuran file maksimal 2MB.',
        ];
    }

    protected function isStep1(): bool
    {
        return $this->routeIs('permit.po.storeStep1');
    }

    protected function isStep2(): bool
    {
        return $this->routeIs('permit.po.storeStep2');
    }

    protected function isStep3(): bool
    {
        return $this->routeIs('permit.po.storeStep3');
    }

    protected function isStep4(): bool
    {
        return $this->routeIs('permit.po.storeStep4');
    }

    protected function rulesForStep1(): array
    {
        return [
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'telepon_pemohon' => 'required|string|max:20',
            'nama_pengawas' => 'required|string|max:100',
            'telepon_pengawas' => 'required|string|max:20',
            'lampiran_struktur' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    protected function rulesForStep2(): array
    {
        return [
            'work_permit_id' => 'required|exists:work_permits,id',
            'nama' => 'nullable|array',
            'nama.*' => 'nullable|array',
            'nama.*.*' => 'nullable|string|max:255',
            'worker_id.*.*' => 'nullable|integer|exists:work_permit_worker_details,id',
            'ktp.*.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'sertifikat.*.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'deleted_workers' => 'nullable|array',
            'deleted_workers.*' => 'nullable|integer|exists:work_permit_worker_details,id',
        ];
    }

    protected function rulesForStep3(): array
    {
        return [
            'work_permit_id' => 'required|exists:work_permits,id',

            'kategori' => 'required|array|min:1',
            'kategori.*' => 'required|in:alat,mesin,material,alat_berat',

            'nama' => 'required|array|min:1',
            'nama.*' => 'required|string',

            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',

            'lampiran_foto' => 'nullable|array',
            'lampiran_foto.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',

            'deleted_equipment' => 'sometimes|array',
            'deleted_equipment.*' => 'integer|exists:work_permit_equipment,id',
        ];
    }

    protected function rulesForStep4(): array
    {
        $existingJsa = WorkPermitJsa::where('work_permit_id', $this->work_permit_id)->exists();

        $rules = [
            'work_permit_id' => 'required|exists:work_permits,id',
            'jsa' => $existingJsa ? 'nullable|array' : 'required|array|min:1',
        ];

        foreach ($this->jsa ?? [] as $i => $item) {
            $rules["jsa.{$i}.tahapan"] = 'required|in:persiapan,mobilisasi,pelaksanaan,finishing';
            $rules["jsa.{$i}.sub_tahapan"] = 'required|string|min:3';
            $rules["jsa.{$i}.identifikasi_bahaya"] = 'required|string|min:5';
            $rules["jsa.{$i}.pengendalian_risiko"] = 'required|string|min:5';
        }

        return $rules;
    }

}
