<?php
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('tanggalIndo')) {
    function tanggalIndo($tanggal, $format = 'd M Y')
    {
        if (!$tanggal) return '-';
        return Carbon::parse($tanggal)->locale('id')->translatedFormat($format);
    }
}

if (!function_exists('getApprovalStatusLabel')) {
    function getApprovalStatusLabel($status)
    {
        return match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Menunggu Persetujuan',
        };
    }
}

if (!function_exists('getApprovalStatusClass')) {
    function getApprovalStatusClass($status)
    {
        return match ($status) {
            'approved' => 'status-approved',
            'rejected' => 'status-rejected',
            default => 'status-waiting',
        };
    }
}

function getTimelineItemClass($status)
{
    return match ($status) {
        'approved' => 'approved',
        'rejected' => 'rejected',
        default => 'waiting',
    };
}

 function label(string $permission): string
    {
        return match ($permission) {
            'approval-pengawas' => 'Pengawas',
            'approval-area' => 'Pemilik Area',
            'approval-she_manager' => 'SHE Manager',
            'approval-she_officer' => 'SHE Officer',
            default => Str::title(str_replace(['approval-', '-', '_'], ['', ' ', ' '], $permission)),
        };
    }


function encodeId($id) {
    return base64_encode((string) $id);
}


function decodeId($encodedId) {
    $decoded = (int) base64_decode($encodedId);
    return $decoded > 0 ? $decoded : null;
}
