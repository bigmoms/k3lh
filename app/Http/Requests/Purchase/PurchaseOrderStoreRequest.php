<?php
namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id'           => 'required|string',
            'nama_pekerjaan'      => 'required|string|max:255',
            'jenis_pekerjaan'     => 'required|in:jasa_perorangan,jasa_non_perorangan',
            'area_pekerjaan'      => 'required|string|max:255',
            'lokasi_pekerjaan'    => 'required|string|max:255',
            'detail_pekerjaan'    => 'required|string',
            'tanggal_mulai'       => 'required|date',
            'tanggal_akhir'       => 'required|date|after:tanggal_mulai',
            'job_classifications' => 'required|array',
            'job_classifications.*' => 'exists:job_classifications,id',
        ];
    }

}
