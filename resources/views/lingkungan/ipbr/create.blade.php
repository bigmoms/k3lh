@extends('layouts.master')
@section('title', 'Tambah IPBR')
@section('header', 'Tambah Identifikasi Bahaya dan Penilaian Resiko')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <style>
        .remove-row {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .form-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary,
        .btn-secondary {
            padding: 10px 24px;
            font-weight: 600;
            font-size: 14px;
        }

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

        .table thead th {
            background-color: #1C2260;
            font-weight: 600;
            color: #ffffff;
            vertical-align: middle;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-0">Tambah IPBR</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <ol class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="#"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Tambah IPBR</li>
                        </ol>
                    </div>
                </div>
            </div>

            <form method="POST" action="javascript:;" id="ipbrForm">
                @csrf
                <div class="form-section py-3 px-4 rounded shadow-sm bg-white border">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="lokasi-nama" class="form-label fw-semibold text-dark">Lokasi</label>
                            <input type="text" id="lokasi-nama" class="form-control bg-primary text-dark"
                                value="{{ $lokasi->nama_lokasi ?? '-' }}" readonly>
                            <input type="hidden" name="lokasi_pengukuran_id" value="{{ $lokasi->id ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label for="divisi-nama" class="form-label fw-semibold text-dark">Divisi</label>
                            <input type="text" id="divisi-nama" class="form-control bg-primary text-dark"
                                value="{{ $divisi->nama_divisi ?? '-' }}" readonly>
                            <input type="hidden" name="divisi_id" value="{{ $divisi->id ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label for="tahun" class="form-label fw-semibold text-dark">Tahun</label>
                            <input type="text" class="form-control bg-primary text-dark" name="tahun"
                                value="{{ now()->year }}" readonly>
                        </div>
                    </div>
                </div>


                <div class="form-section">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle" id="ipbr-table">
                            @include('lingkungan.ipbr.table-head')
                            <tbody id="ipbr-rows"></tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addAktifitas">
                            <i class="fas fa-plus me-1"></i> Tambah Aktifitas
                        </button>
                    </div>
                </div>

                <div class="text-end mt-4 mb-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('lingkungan.ipbr.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let aktifitasIndex = 1;

        function updateRowNumbers() {
            document.querySelectorAll('#ipbr-rows tr.row-item').forEach((row, i) => {
                const noCell = row.querySelector('td');
                if (noCell) noCell.textContent = i + 1;
            });
        }

        function getKategoriRisiko(total) {
            if (total > 1 && total < 5) return 'L';
            if (total >= 5 && total < 8) return 'M';
            if (total >= 8 && total < 12) return 'H';
            if (total >= 12 && total <= 25) return 'E';
            return '';
        }

        function updateTotal(input) {
            const row = input.closest('tr');
            const lAwal = row.querySelector(`[name*="[l]"]`);
            const cAwal = row.querySelector(`[name*="[c]"]`);
            const totalAwal = row.querySelector(`[name*="[total]"]`);
            const risikoAwal = row.querySelector(`[name*="[tingkat_risiko]"]`);
            const lAkhir = row.querySelector(`[name*="[l_after]"]`);
            const cAkhir = row.querySelector(`[name*="[c_after]"]`);
            const totalAkhir = row.querySelector(`[name*="[total_after]"]`);
            const risikoAkhir = row.querySelector(`[name*="[tingkat_risiko_after]"]`);

            const lAwalVal = parseInt(lAwal?.value) || 0;
            const cAwalVal = parseInt(cAwal?.value) || 0;
            const totalAwalVal = lAwalVal * cAwalVal;
            if (totalAwal) totalAwal.value = totalAwalVal;
            if (risikoAwal) risikoAwal.value = getKategoriRisiko(totalAwalVal);

            const lAkhirVal = parseInt(lAkhir?.value) || 0;
            const cAkhirVal = parseInt(cAkhir?.value) || 0;
            const totalAkhirVal = lAkhirVal * cAkhirVal;
            if (totalAkhir) totalAkhir.value = totalAkhirVal;
            if (risikoAkhir) risikoAkhir.value = getKategoriRisiko(totalAkhirVal);
        }

        function getInitials(text) {
            return text.toUpperCase().split(' ').map(kata => kata.charAt(0)).join('');
        }

        function generateNoDampak() {
            const lokasiInput = document.getElementById('lokasi-nama');
            if (!lokasiInput) return;
            const prefix = getInitials(lokasiInput.value.trim()) + ' ';
            document.querySelectorAll('.no-dampak').forEach((input, i) => {
                input.value = `${prefix}${i + 1}`;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const ipbrRows = document.getElementById('ipbr-rows');

            document.getElementById('addAktifitas').addEventListener('click', function() {
                fetch(`{{ route('lingkungan.ipbr.aktifitasRow') }}?index=${aktifitasIndex}`)
                    .then(res => res.text())
                    .then(html => {
                        ipbrRows.insertAdjacentHTML('beforeend', html);
                        aktifitasIndex++;
                        updateRowNumbers();
                        generateNoDampak();
                    });
            });

            document.addEventListener('click', function(e) {
                const target = e.target;

                if (target.classList.contains('addKegiatan')) {
                    const aidx = target.dataset.aidx;
                    const aktifitasRow = target.closest('tr');
                    const countInput = aktifitasRow.querySelector('.kegiatan-count');
                    const kidx = parseInt(target.dataset.kidx || 0);

                    fetch(`{{ route('lingkungan.ipbr.kegiatan-row') }}?aidx=${aidx}&kidx=${kidx}`)
                        .then(res => res.text())
                        .then(html => {
                            aktifitasRow.insertAdjacentHTML('afterend', html);
                            target.dataset.kidx = kidx + 1;
                            countInput.value = kidx + 1;
                            updateRowNumbers();
                            generateNoDampak();
                        });
                }

                if (target.classList.contains('remove-row')) {
                    target.closest('tr').remove();
                    updateRowNumbers();
                    generateNoDampak();
                }

                if (target.classList.contains('remove-aktifitas')) {
                    const aktifitasRow = target.closest('tr.aktifitas-row');
                    const allRows = Array.from(document.querySelectorAll('#ipbr-rows tr'));
                    const startIndex = allRows.indexOf(aktifitasRow);
                    let endIndex = allRows.length;

                    for (let i = startIndex + 1; i < allRows.length; i++) {
                        if (allRows[i].classList.contains('aktifitas-row')) {
                            endIndex = i;
                            break;
                        }
                    }

                    for (let i = endIndex - 1; i >= startIndex; i--) {
                        allRows[i].remove();
                    }

                    updateRowNumbers();
                    generateNoDampak();
                }
            });

            generateNoDampak();
        });

        document.addEventListener('input', function(e) {
            if (
                e.target.name.includes('[l]') || e.target.name.includes('[c]') ||
                e.target.name.includes('[l_after]') || e.target.name.includes('[c_after]')
            ) {
                updateTotal(e.target);
            }
        });

        document.addEventListener('click', function(e) {
            if (
                e.target?.id === 'addAktifitas' ||
                e.target?.classList.contains('addKegiatan') ||
                e.target?.classList.contains('remove-row')
            ) {
                setTimeout(generateNoDampak, 50);
            }
        });

        $('#ipbrForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('lingkungan.ipbr.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('lingkungan.ipbr.index') }}";
                    });
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;
                    if (xhr.status === 403) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: res.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    </script>
    @if (isset($dataDuplikat))
        <script>
            const duplicatedData = @json($dataDuplikat);

            $(document).ready(function() {
                const wrapper = document.getElementById('ipbr-rows');
                wrapper.innerHTML = '';
                let aidx = 0;

                function renderAktifitas(index) {
                    if (index >= duplicatedData.length) return;

                    const group = duplicatedData[index];
                    const kegiatanList = group.kegiatan || [];

                    $.get("{{ route('lingkungan.ipbr.aktifitasRow') }}", {
                        index: aidx
                    }, function(html) {
                        const temp = document.createElement('tbody');
                        temp.innerHTML = html;

                        const rows = temp.querySelectorAll('tr');
                        rows.forEach(row => wrapper.appendChild(row));

                        const aktifitasRow = wrapper.querySelector(`tr[data-aidx="${aidx}"]`);
                        if (aktifitasRow) {
                            aktifitasRow.querySelector(`[name="data[${aidx}][aktifitas]"]`).value = group
                                .aktifitas;
                        }

                        const addKegiatanBtn = aktifitasRow.querySelector('.addKegiatan');
                        const kegiatanCount = aktifitasRow.querySelector('.kegiatan-count');

                        let kidx = 0;

                        const fields = [
                            'potensi_bahaya', 'dampak_k3', 'resiko_k3',
                            'n_r', 'no_dampak', 'l', 'c', 'total',
                            'tingkat_risiko', 'pengendalian_saat_ini', 'l_after',
                            'c_after', 'total_after', 'tingkat_risiko_after',
                            'peluang', 'peraturan_perundangan', 'pengendalian_lanjutan'
                        ];

                        if (kegiatanList.length > 0) {
                            const row = kegiatanList[0];
                            fields.forEach(field => {
                                const input = aktifitasRow.querySelector(
                                    `[name="data[${aidx}][kegiatan][0][${field}]"]`
                                );
                                if (input) input.value = row[field] || '';
                            });
                            kidx = 1;
                        }

                        function renderKegiatan() {
                            if (kidx >= kegiatanList.length) {
                                kegiatanCount.value = kidx;
                                addKegiatanBtn.dataset.kidx = kidx;
                                aidx++;
                                renderAktifitas(index + 1);
                                return;
                            }

                            const row = kegiatanList[kidx];

                            $.get("{{ route('lingkungan.ipbr.kegiatan-row') }}", {
                                aidx: aidx,
                                kidx: kidx
                            }, function(html2) {
                                const temp2 = document.createElement('tbody');
                                temp2.innerHTML = html2;
                                const newRow = temp2.querySelector('tr');

                                fields.forEach(field => {
                                    const input = newRow.querySelector(
                                        `[name="data[${aidx}][kegiatan][${kidx}][${field}]"]`
                                    );
                                    if (input) input.value = row[field] || '';
                                });

                                wrapper.appendChild(newRow);
                                kidx++;
                                renderKegiatan();
                            });
                        }

                        renderKegiatan();
                    });
                }

                renderAktifitas(0);
            });
        </script>
    @endif
@endsection
