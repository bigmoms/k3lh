<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin Kerja</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        h1,
        h2 {
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            background-color: #eee;
            padding: 5px;
        }

        .checkbox-container {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 12px;
            margin-top: 6px;

        }

        .checkbox-item {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            font-size: 12px;
        }

        .form-check-input {
            margin-right: 8px;
            width: 12px;
            height: 16px;
        }

        .checkbox-label {
            font-size: 11px;
        }

        .table-mid-border {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
            margin-bottom: -1px;
        }

        .table-mid-border th,
        .table-mid-border td {
            border: none;
        }

        .table-mid-border th:first-child,
        .table-mid-border td:first-child {
            border-right: 1px solid #ccc;
            width: 50%;
        }
    </style>
    <style>
        .approval-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .approval-details {
            flex: 1;
        }

        .approval-details h4 {
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .approval-details div {
            margin-bottom: 6px;
        }

        .qr-box {
            text-align: center;
            width: 100px;
            flex-shrink: 0;
        }

        .qr-box img {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .qr-status {
            font-size: 12px;
            color: red;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
        <tr>
            <td style="width: 20%;">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" width="150" style="margin-top: 15px">
                @else
                    <p><em>Logo tidak ditemukan</em></p>
                @endif
            </td>

            <td style="width: 50%; text-align: center; vertical-align: middle;">
                <h2 style="margin: 0;">SURAT IJIN KERJA</h2>
                <div>(WORK PERMIT)</div>
            </td>

            <td style="width: 30%; vertical-align: top; font-size: 13px;">
                <div style="border-bottom: 1px solid #000;">
                    <strong>No. Dok:</strong> {{ $workPermit->no_dokumen ?? '-' }}
                </div>
                <div style="border-bottom: 1px solid #000;">
                    <strong>Tgl Rilis:</strong>
                    {{ $tglRilis ? \Carbon\Carbon::parse($tglRilis)->format('d-m-Y') : '-' }}
                </div>
                <div>
                    <strong>Hal:</strong> Surat Ijin Kerja
                </div>
            </td>

        </tr>
    </table>
    <div style="border: 1px solid #000; padding: 15px; margin-top: 10px;">
        <div class="section" style="margin-top:-15px">
            <table class="table-mid-border">
                <tr>
                    <td>Nomor Pekerjaan: {{ $workPermit->purchaseOrder->no_po ?? '-' }}</td>
                    <td>
                        Jenis Pekerjaan:
                        {{ \Illuminate\Support\Str::of($workPermit->purchaseOrder->jenis_pekerjaan ?? '-')->replace('_', ' ')->title() }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- A. Klasifikasi Pekerjaan -->
        <div class="section">
            <div class="section-title">A. KLASIFIKASI PEKERJAAN</div>
            <div class="checkbox-container">
                @foreach ($klasifikasiPekerjaan as $klasifikasi)
                    <div class="checkbox-item">
                        <input class="form-check-input" type="checkbox"
                            {{ in_array($klasifikasi, $workPermit->klasifikasi_pekerjaan ?? []) ? 'checked' : '' }}
                            checked disabled>
                        <span class="checkbox-label">{{ $klasifikasi }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- B. Informasi Pekerjaan -->
        <div class="section">
            <div class="section-title">B. INFORMASI PEKERJAAN</div>
            <div style="display: table; width: 100%; margin-bottom: 10px;">
                <div style="display: table-cell; width: 50%; vertical-align: top; padding-right: 10px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="font-weight: bold; border: none;">Nama Perusahaan</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->vendor->vendor_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Pekerjaan</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->nama_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Detail Pekerjaan</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->detail_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Lokasi Pekerjaan</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->lokasi_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Area Pekerjaan</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->area_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Nama Pemohon</td>
                            <td style="border: none;">: {{ $workPermit->purchaseOrder->vendor->vendor_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Telp Pemohon</td>
                            <td style="border: none;">: {{ $workPermit->telepon_pemohon }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Nama Pengawas</td>
                            <td style="border: none;">: {{ $workPermit->pengawas }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; border: none;">Telp Pengawas</td>
                            <td style="border: none;">: {{ $workPermit->telepon_pengawas }}</td>
                        </tr>
                    </table>
                </div>
                <!-- Kolom Kanan: Daftar Pekerja -->
                <table style="width: 100%; border-collapse: collapse; padding-left: 10px;">
                    <thead>
                        <tr>
                            <th style="border: none; width: 50%; text-align: left; padding-left: 10px;">Daftar Pekerja
                            </th>
                            <th style="border: none; width: 50%; text-align: left; padding-left: 10px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $defaultWorkers = [
                                'engineer',
                                'surveyor',
                                'operator_alat_berat',
                                'rigger',
                                'teknisi_elektrik',
                                'mekanik',
                                'welder',
                                'fitter',
                                'tukang_bangunan',
                                'hekiper',
                                'helper',
                                'safety_officer',
                                'lainnya',
                            ];
                            $existingWorkers = $workPermit->workers->pluck('jabatan')->toArray();
                        @endphp

                        @foreach ($defaultWorkers as $worker)
                            <tr>
                                <td
                                    style="border: none; padding: 4px 0; vertical-align: top; text-align: left; padding-left: 10px;">
                                    {{ \Illuminate\Support\Str::of($worker)->replace('_', ' ')->title() }}
                                </td>
                                <td
                                    style="border: none; padding: 4px 0; vertical-align: top; text-align: left; padding-left: 10px;">
                                    @if (in_array($worker, $existingWorkers))
                                        {{ $workPermit->workers->where('jabatan', $worker)->first()->jumlah }} orang
                                    @else
                                        0 orang
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- C. Perlengkapan Kerja -->
        <div class="section" style="margin-top:-20px">
            <div class="section-title">C. PERLENGKAPAN KERJA</div>
            @php
                $alat = $groupedEquipments['alat'] ?? collect();
                $mesin = $groupedEquipments['mesin'] ?? collect();
                $material = $groupedEquipments['material'] ?? collect();
                $alatBerat = $groupedEquipments['alat_berat'] ?? collect();

                $maxRows = max($alat->count(), $mesin->count(), $material->count(), $alatBerat->count());
            @endphp
            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>Alat</th>
                        <th>Jml</th>
                        <th>Mesin</th>
                        <th>Jml</th>
                        <th>Material</th>
                        <th>Jml</th>
                        <th>Alat Berat</th>
                        <th>Jml</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            <td>{{ $alat[$i]->nama ?? '' }}</td>
                            <td>{{ $alat[$i]->jumlah ?? '' }}</td>
                            <td>{{ $mesin[$i]->nama ?? '' }}</td>
                            <td>{{ $mesin[$i]->jumlah ?? '' }}</td>
                            <td>{{ $material[$i]->nama ?? '' }}</td>
                            <td>{{ $material[$i]->jumlah ?? '' }}</td>
                            <td>{{ $alatBerat[$i]->nama ?? '' }}</td>
                            <td>{{ $alatBerat[$i]->jumlah ?? '' }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <small style="display: block; text-align: left; margin-top: -10px; margin-bottom:10px">*Semua perlengkapan
                kerja
                diperiksa oleh petugas K3</small>
        </div>
        <!-- D. Peralatan Keselamatan -->
        <div class="section">
            <div class="section-title">D. PERALATAN KESELAMATAN</div>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom:20px" border="1"
                cellpadding="5">
                <thead>
                    <tr>
                        <th style="width: 50%;">APD</th>
                        <th style="width: 50%;">Perlengkapan Darurat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $apdList = $uniqueApd->values();
                        $daruratList = $uniqueEmergencyEquipments->values();
                        $maxRows = max($apdList->count(), $daruratList->count());
                    @endphp

                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            <td>
                                @isset($apdList[$i])
                                    ✓ {{ $apdList[$i]->name }}
                                @endisset
                            </td>
                            <td>
                                @isset($daruratList[$i])
                                    ✓ {{ $daruratList[$i]->name }}
                                @endisset
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <small style="display: block; text-align: left; margin-top: -20px; margin-bottom:20px">*Semua peralatan yang
                diisyaratkan harus disiapkan sebelum memulai pekerjaan dan diperikan oleh petugas K3</small>
        </div>
        <!-- E. VALIDASI IZIN KERJA -->
        <div class="section">
            <div class="section-title">E. VALIDASI IZIN KERJA</div>
            <table style="width: 100%; margin-bottom: 20px; table-layout: fixed;">
                <tr>
                    <!-- KIRI: Izin Diberikan -->
                    <td
                        style=" border: none; width: 50%; vertical-align: top; padding-right: 10px; border-right: 1px dashed #ccc;">
                        <div style="margin-bottom: 10px;">
                            <div><strong>Izin Diberikan</strong></div>
                            <div>
                                <strong>Izin Berlaku mulai:</strong>
                                {{ tanggalIndo($workPermit->purchaseOrder->tanggal_mulai) }} -
                                {{ tanggalIndo($workPermit->purchaseOrder->tanggal_akhir) }}
                            </div>
                        </div>
                        @foreach ($approvalLevels as $level)
                            @continue($level->permission_name === 'approval-she_officer')
                            @php
                                $approval = $workPermit->approvals
                                    ->where('permission_name', $level->permission_name)
                                    ->first();
                                $approvalSHE = $workPermit->approvals->firstWhere(
                                    'permission_name',
                                    'approval-she_officer',
                                );
                            @endphp

                            <table style="width: 100%;">
                                <tr>
                                    <td style="vertical-align: top;">
                                        <h4>{{ $level->label }} - Diberikan</h4>
                                        <div><strong>Nama:</strong>
                                            {{ $approval?->approver?->name ?? '-' }}
                                        </div>
                                        <div><strong>Tanggal Approve:</strong>
                                            {{ $approval?->approved_at ? tanggalIndo($approval->approved_at) : '-' }}
                                        </div>
                                        <div><strong>Status:</strong>
                                            @if ($approval?->status === 'approved')
                                                Disetujui
                                            @elseif ($approval?->status === 'rejected')
                                                Ditolak
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: top; width: 100px;">
                                        @if ($approval?->status === 'approved' && $approval?->approver)
                                            <img src="data:image/png;base64,{{ $qrCodes[$level->label] ?? '' }}"
                                                width="80">
                                            <div style="font-size: 12px; margin-top: 4px;">QR Approval</div>
                                        @else
                                            <div style="font-size: 12px; color: red; margin-top: 20px;">
                                                @if ($approval?->status === 'rejected')
                                                    Ditolak
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </td>

                    <!-- KANAN: Izin Dibatalkan -->
                    <td style="border: none; width: 50%; vertical-align: top; padding-left: 10px;">
                        <div style="margin-bottom: 10px;">
                            <div><strong>Izin Dibatalkan / Ditutup</strong></div>
                            <div>
                                <strong>Tanggal:</strong>
                                @if ($purchaseOrder->status === 'cancelled' && $purchaseOrder->pembatalan)
                                    {{ tanggalIndo($purchaseOrder->pembatalan->created_at) }}
                                @elseif ($purchaseOrder->status === 'completed' && $purchaseOrder->pengajuanPenyelesaian)
                                    {{ tanggalIndo($purchaseOrder->pengajuanPenyelesaian->created_at) }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        @php
                            $approvalList = $approvalPembatalan->isNotEmpty()
                                ? $approvalPembatalan
                                : $approvalPenyelesaian;
                        @endphp

                        @foreach ($approvalList as $approval)
                            @continue($approval->permission_name === 'approval-she_officer')
                            @php
                                $role = ucwords(str_replace('_', ' ', $approval->role ?? ''));
                                $nama = $approval->approver->name ?? '-';
                                $tanggal = $approval->approved_at ? tanggalIndo($approval->approved_at) : '-';
                                $status = $approval->status;
                                $qrContent = route('permit.po.progres', base64_encode($workPermit->id));
                                $qrBase64 = base64_encode(
                                    (new \Endroid\QrCode\Writer\PngWriter())
                                        ->write(new \Endroid\QrCode\QrCode($qrContent))
                                        ->getString(),
                                );
                            @endphp
                            <table style="width: 100%;">
                                <tr>
                                    <td style="vertical-align: top;">
                                        <h4>{{ $nama }} -
                                            {{ $approvalPembatalan->isNotEmpty() ? 'Pembatalan' : 'Penyelesaian' }}
                                        </h4>
                                        <div><strong>Nama:</strong> {{ $nama }}</div>
                                        <div><strong>Tanggal Approve:</strong> {{ $tanggal }}</div>
                                        <div><strong>Status:</strong>
                                            @if ($status === 'approved')
                                                Disetujui
                                            @elseif ($status === 'rejected')
                                                Ditolak
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: top; width: 100px;">
                                        @if ($status === 'approved' && $approval->approver)
                                            <img src="data:image/png;base64,{{ $qrBase64 }}" width="80">
                                            <div style="font-size: 12px; margin-top: 4px;">QR Approval</div>
                                        @elseif ($status === 'rejected')
                                            <div style="font-size: 12px; color: red; margin-top: 20px;">Ditolak</div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </td>

                </tr>
            </table>
        </div>

        @if ($approvalSHE)
            <div class="section" style="display: flex; justify-content: space-between; gap: 20px; margin-top: -20px;">
                <div style="flex: 1; border: 1px solid; padding: 10px; border-radius: 5px;">
                    <div><strong>Catatan Safety:</strong></div>
                    <div>{{ $approvalSHE->catatan_safety ?? '-' }}</div>
                </div>
                <div style="flex: 1; border: 1px solid; padding: 10px; border-radius: 5px; margin-top: 5px">
                    <div><strong>Catatan Lain:</strong></div>
                    <div>{{ $approvalSHE->catatan_lain ?? '-' }}</div>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
