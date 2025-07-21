<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Workpermit\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $po;

    public function __construct(PurchaseOrder $po)
    {
        $this->po = $po;
    }

    public function build()
    {
        $vendorUser  = User::where('vendor_id', $this->po->vendor_id)->first();
        $vendorName  = $vendorUser?->vendor?->vendor_name ?? '-';

        return $this->subject('Pekerjaan Baru Tersedia - Silakan Isi Work Permit')
            ->view('emails.purchase_order_created')
            ->with([
                'no_po'          => $this->po->no_po,
                'namaPekerjaan'  => $this->po->nama_pekerjaan,
                'areaPekerjaan'  => $this->po->area_pekerjaan,
                'lokasiPekerjaan'=> $this->po->lokasi_pekerjaan,
                'detailPekerjaan'=> $this->po->detail_pekerjaan,
                'tanggalMulai'   => $this->po->tanggal_mulai,
                'tanggalAkhir'   => $this->po->tanggal_akhir,

                'vendorName'     => $vendorName,
                'status'         => $this->po->status,
                'catatan'        => $this->po->catatan ?? '-',

                'pekerja'        => $this->po->pekerja        ?? [],
                'perlengkapan'   => $this->po->perlengkapan   ?? [],

                'klasifikasiPekerjaan' => $this->po->jobClassifications->map(function ($klas) {
                    return [
                        'name'        => $klas->name,
                        'description' => $klas->description,
                        'alatSafety'  => optional($klas->safetyEquipments)
                                            ->pluck('name')
                                            ->toArray() ?? [],
                    ];
                }),

                'linkWorkPermit' => route(
                    'permit.po.create',
                    ['id' => encodeId($this->po->id)]
                ),
            ]);
    }
}
