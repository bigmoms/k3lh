@extends('layouts.master')
@section('title', 'Tambah Hasil Pengukuran Lingkungan Kerja')
@section('header', 'Tambah Hasil Pengukuran Lingkungan Kerja')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
    <style>
        .page-title h2 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: '>';
        }

        .card {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #f6f9fc;
            border-bottom: 1px solid #e1e1e1;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control-sm {
            font-size: 13px;
            padding: 4px 8px;
        }

        table.table th {
            background-color: #1C2260;
            color: #fff;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        table.table td {
            vertical-align: middle;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #1C2260;
            border-color: #1C2260;
            font-weight: 600;
            padding: 8px 20px;
        }

        .btn-primary:hover {
            background-color: #151b4d;
        }

        .btn-outline-primary {
            border-color: #1C2260;
            color: #1C2260;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background-color: #1C2260;
            color: #fff;
        }
    </style>

@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Tambah Hasil Data Pengukuran Lingkungan Kerja</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Tambah Hasil Data Pengukuran Lingkungan Kerja</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="jadwal_select" class="form-label">Pilih Jadwal / Lokasi Pengukuran</label>
                                <select id="jadwal_select" class="form-select" style="width: 300px;">
                                    <option value="" disabled selected>-- Pilih Jadwal --</option>
                                    @foreach ($jadwalPengukuran as $jadwal)
                                        <option value="{{ $jadwal->id }}">
                                            {{ $jadwal->lokasi->pluck('nama_lokasi')->join(', ') }}
                                            ({{ $jadwal->tanggal_pengukuran }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="form_pengukuran_container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#jadwal_select').select2({
                placeholder: "Cari Jadwal / Lokasi...",
                allowClear: true,
                minimumInputLength: 2
            });

            $('#jadwal_select').on('change', function() {
                const jadwalId = $(this).val();
                if (!jadwalId) {
                    $('#form_pengukuran_container').html('');
                    return;
                }

                $.ajax({
                    url: '{{ route('lingkungan.getLokasiDivisi') }}',
                    type: 'GET',
                    data: {
                        jadwal_id: jadwalId
                    },
                    success: function(response) {
                        let html = `<form id="form_pengukuran" method="POST">
                                @csrf
                                <input type="hidden" name="jadwal_id" value="${jadwalId}">`;

                        response.lokasi.forEach(lokasi => {
                            html += `
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Lokasi: ${lokasi.nama_lokasi}</h5>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Divisi</th>
                                            <th colspan="4" class="text-center">Cahaya (Lux)</th>
                                            <th colspan="4" class="text-center">Suhu (°C)</th>
                                            <th colspan="4" class="text-center">Kelembaban (%)</th>
                                            <th colspan="4" class="text-center">Kebisingan (dB)</th>
                                            <th>Catatan</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>1</th><th>2</th><th>3</th><th>Rata²</th>
                                            <th>1</th><th>2</th><th>3</th><th>Rata²</th>
                                            <th>1</th><th>2</th><th>3</th><th>Rata²</th>
                                            <th>1</th><th>2</th><th>3</th><th>Rata²</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                            lokasi.divisis.forEach(divisi => {
                                html += `<tr>
                            <td>${divisi.nama_divisi}
                                <input type="hidden" name="divisi[${lokasi.id}][${divisi.id}][divisi_id]" value="${divisi.id}">
                            </td>`;

                                ['cahaya', 'suhu', 'kelembaban', 'kebisingan']
                                .forEach(param => {
                                    for (let i = 1; i <= 3; i++) {
                                        html += `<td>
                                    <input type="number" step="0.01" class="form-control form-control-sm" style="width: 80px;"
                                    name="divisi[${lokasi.id}][${divisi.id}][${param}_${i}]" data-param="${param}" data-group="${lokasi.id}-${divisi.id}" required>
                                </td>`;
                                    }
                                    html += `<td>
                                <input type="number" step="0.01" class="form-control form-control-sm rata-rata rata-${param}" style="width: 80px;"
                                name="divisi[${lokasi.id}][${divisi.id}][${param}_rata2]" data-param="${param}" data-group="${lokasi.id}-${divisi.id}" readonly required>
                            </td>`;
                                });

                                html += `<td><input type="text" class="form-control form-control-sm" style="width: 120px;"
                            name="divisi[${lokasi.id}][${divisi.id}][catatan]"></td>`;
                                html += `</tr>`;
                            });

                            html += `</tbody></table></div></div>`;
                        });

                        html += `<div class="text-end mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div></form>`;

                        $('#form_pengukuran_container').html(html);

                        bindAverageCalculation();

                        $('#form_pengukuran').submit(function(e) {
                            e.preventDefault();

                            let formData = $(this).serialize();

                            $.ajax({
                                url: '{{ route('lingkungan.hasil.store') }}',
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data berhasil disimpan.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location.href =
                                            '{{ route('lingkungan.hasil.index') }}';
                                    });
                                },
                                error: function(xhr) {
                                    let errors = xhr.responseJSON.errors;
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi kesalahan!',
                                        text: 'Error: ' + JSON
                                            .stringify(errors),
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                            });
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengambil data lokasi dan divisi', 'error');
                    }
                });
            });

            function bindAverageCalculation() {
                $('#form_pengukuran input[type="number"]').on('input', function() {
                    const input = $(this);
                    const group = input.data('group');
                    const param = input.data('param');

                    if (!group || !param) return;

                    let total = 0;
                    let count = 0;

                    $(`#form_pengukuran input[data-group="${group}"][data-param="${param}"]:not(.rata-rata)`)
                        .each(function() {
                            let val = parseFloat($(this).val());
                            if (!isNaN(val)) {
                                total += val;
                                count++;
                            }
                        });

                    if (count > 0) {
                        let avg = (total / count).toFixed(2);
                        $(`#form_pengukuran input.rata-${param}[data-group="${group}"]`).val(avg);
                    }
                });
            }
        });
    </script>
@endsection
