<?php

namespace App\Models\Workpermit;

use App\Models\User;
use App\Models\Workpermit\JobClassification;
use App\Models\Workpermit\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'vendor_id',
        'nama_pekerjaan',
        'jenis_pekerjaan',
        'area_pekerjaan',
        'lokasi_pekerjaan',
        'detail_pekerjaan',
        'tanggal_mulai',
        'tanggal_akhir',
        'created_by',
        'status',
        'is_deleted',
        'no_po',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public static function generateNoPO()
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $bulan = $romawi[now()->month];
        $tahun = now()->year;

        $lastPo = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', now()->month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastPo ? ((int) substr($lastPo->no_po, -3)) + 1 : 1;
        return 'PO/' . $bulan . '/' . $tahun . '/' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jobClassifications()
    {
        return $this->belongsToMany(JobClassification::class, 'purchase_order_job_classification', 'purchase_order_id', 'job_classification_id');
    }

    public function workPermits()
    {
        return $this->hasMany(WorkPermit::class);
    }

    public function pembatalan()
    {
        return $this->hasOne(PengajuanPembatalan::class);
    }

    public function pengajuanPenyelesaian()
    {
        return $this->hasOne(PengajuanPenyelesaian::class);
    }
}
