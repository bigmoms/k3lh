<?php

namespace App\Http\Requests\Workpermit;
use Illuminate\Foundation\Http\FormRequest;

class WorkScheduleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
            'b' => 'nullable|array',
            'c' => 'nullable|array',
            'e' => 'nullable|array',
            'f' => 'nullable|array',
            'i' => 'nullable|array',
            'j' => 'nullable|array',
            'k' => 'nullable|array',
            'l' => 'nullable|array',
            'periode' => 'required|string',
            'work_permit_id' => 'required|exists:work_permits,id',
            'project_manager' => 'required|string|max:255',
            'lampiran_induction' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'statistik_lalu' => 'nullable|array',
            'statistik_sekarang' => 'nullable|array',
            'tim_hse' => 'nullable|array',
            'laporan' => 'nullable|array',
        ];
    }
}
