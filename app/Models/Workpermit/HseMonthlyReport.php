<?php

namespace App\Models\Workpermit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HseMonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_schedule_id',

        // Bagian 1
        'hari_kerja_bulan_lalu',
        'hari_kerja_bulan_ini',
        'hari_kerja_total',
        'manhours_lembur_bulan_lalu',
        'manhours_lembur_bulan_ini',
        'manhours_lembur_total',
        'manhours_subkon_bulan_lalu',
        'manhours_subkon_bulan_ini',
        'manhours_subkon_total',
        'total_manhours_bulan_lalu',
        'total_manhours_bulan_ini',
        'total_manhours_total',
        'pekerja_kontraktor_utama',
        'pekerja_subkon',
        'total_pekerja',

        // Bagian 2
        'hse_manager',
        'hse_coordinator',
        'hse_supervisor',
        'safety_engineer',
        'safety_officer',
        'safety_inspector',
        'safety_administration',
        'safety_man',
        'paramedis',

        // Bagian 3 & 4
        'kasus_insiden_bulan_ini',
        'kasus_insiden_total',
        'fatality_bulan_ini',
        'fatality_total',
        'disability_bulan_ini',
        'disability_total',
        'medical_bulan_ini',
        'medical_total',
        'first_aid_bulan_ini',
        'first_aid_total',
        'property_damage_bulan_ini',
        'property_damage_total',
        'traffic_accident_bulan_ini',
        'traffic_accident_total',
        'near_miss_bulan_ini',
        'near_miss_total',
        'lost_time_bulan_ini',
        'lost_time_total',

        // Bagian 5 & 6
        'kasus_penyakit_bulan_ini',
        'kasus_penyakit_total',
        'penyakit_kerja_bulan_ini',
        'penyakit_kerja_total',
        'penyakit_hubungan_kerja_bulan_ini',
        'penyakit_hubungan_kerja_total',
        'penyakit_biasa_bulan_ini',
        'penyakit_biasa_total',
        'lost_time_penyakit_bulan_ini',
        'lost_time_penyakit_total',

        // Bagian 7 & 8
        'kasus_pencemaran_bulan_ini',
        'kasus_pencemaran_total',
        'pencemaran_air_bulan_ini',
        'pencemaran_air_total',
        'pencemaran_udara_bulan_ini',
        'pencemaran_udara_total',

        // Bagian 9-11
        'bahaya_temuan_lalu',
        'bahaya_temuan_bulan_ini',
        'bahaya_temuan_total',
        'bahaya_selesai_lalu',
        'bahaya_selesai_bulan_ini',
        'bahaya_selesai_total',
        'bahaya_sisa_lalu',
        'bahaya_sisa_bulan_ini',
        'bahaya_sisa_total',

        'inspeksi_temuan_lalu',
        'inspeksi_temuan_bulan_ini',
        'inspeksi_temuan_total',
        'inspeksi_selesai_lalu',
        'inspeksi_selesai_bulan_ini',
        'inspeksi_selesai_total',
        'inspeksi_sisa_lalu',
        'inspeksi_sisa_bulan_ini',
        'inspeksi_sisa_total',

        'alat_temuan_lalu',
        'alat_temuan_bulan_ini',
        'alat_temuan_total',
        'alat_selesai_lalu',
        'alat_selesai_bulan_ini',
        'alat_selesai_total',
        'alat_sisa_lalu',
        'alat_sisa_bulan_ini',
        'alat_sisa_total',

        // Bagian 12-16 (text area)
        'kegiatan_bulan_ini',
        'pelatihan_bulan_ini',
        'induction_bulan_ini',
        'ringkasan_permasalahan',
        'daftar_lampiran',
        'rencana_bulan_depan',
    ];

    public function workSchedule()
    {
        return $this->belongsTo(WorkSchedule::class);
    }
}
