@php
    $tanggal = explode(' s/d ', $periode);
    $tanggalAwal = \Carbon\Carbon::parse($tanggal[0])->translatedFormat('d M Y');
    $tanggalAkhir = \Carbon\Carbon::parse($tanggal[1])->translatedFormat('d M Y');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Persetujuan Jam Kerja</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table align="center" width="100%" style="padding: 30px 0;">
        <tr>
            <td>
                <table width="600" align="center" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); overflow: hidden;">
                    <tr>
                        <td style="background-color: #007BFF; padding: 20px; color: #ffffff; text-align: center;">
                            <h2 style="margin: 0;">Jam Kerja Aman Disetujui</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin-bottom: 20px;">Halo <strong>{{ $vendorName }}</strong>,</p>
                            <p style="margin-bottom: 20px;">
                                Laporan Jam Kerja Aman untuk pekerjaan dan periode berikut telah <strong>disetujui</strong> oleh tim <strong>SHE</strong>.
                            </p>

                            <table width="100%" style="margin-bottom: 20px; font-size: 14px;">
                                <tr>
                                    <td width="40%"><strong>No. PO</strong></td>
                                    <td>: {{ $noPO }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Pekerjaan</strong></td>
                                    <td>: {{ $namaPekerjaan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Periode Laporan</strong></td>
                                    <td>: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Persetujuan</strong></td>
                                    <td>: {{ $tanggalPersetujuan }}</td>
                                </tr>
                            </table>

                            <p style="margin-bottom: 30px;">
                                Terima kasih atas pelaporan yang telah dilakukan. Silakan lanjutkan aktivitas sesuai ketentuan dan prosedur yang berlaku.
                            </p>

                            <p style="margin-top: 40px;">Hormat kami,<br><strong>Tim Safety & Permit</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f0f0f0; padding: 15px; font-size: 12px; text-align: center; color: #888;">
                            Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
