document.addEventListener('DOMContentLoaded', function () {
    let flatpickrInstance;

    function initFlatpickr(minDate = null, maxDate = null, dates = []) {
        if (flatpickrInstance) {
            flatpickrInstance.destroy();
        }

        flatpickrInstance = flatpickr("#periode", {
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: minDate,
            maxDate: maxDate,
            defaultDate: dates,
            disable: [
                function (date) {
                    if (minDate && maxDate) {
                        const min = new Date(minDate);
                        const max = new Date(maxDate);
                        return date < min || date > max;
                    }
                    return false;
                }
            ],
            locale: {
                firstDayOfWeek: 1
            }
        });
    }

    if (typeof tanggalAwal !== 'undefined' && typeof tanggalAkhir !== 'undefined') {
        initFlatpickr(tanggalAwal, tanggalAkhir);
    }

    document.getElementById('generateBtn').addEventListener('click', function () {
        const range = document.getElementById('periode').value;
        if (!range.includes(' to ')) {
            Swal.fire('Oops!', 'Pilih periode tanggal terlebih dahulu.', 'warning');
            return;
        }

        const [start, end] = range.split(' to ');
        generateRows(start, end);
    });

    document.getElementById('jamKerjaForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const periode = document.getElementById('periode').value;
        const workPermitId = document.getElementById('work_permit_id').value;

        if (!periode || !workPermitId) {
            Swal.fire('Gagal', 'Periode atau Work Permit belum dipilih.', 'warning');
            return;
        }

        const formData = new FormData(form);
        formData.append('periode', periode);
        formData.append('work_permit_id', workPermitId);

        Swal.fire({
            title: 'Simpan Data?',
            text: "Pastikan semua data sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(jamKerjaStoreUrl, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', data.message, 'success')
                                .then(() => window.location.href = jamKerjaIndexUrl);
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan saat menyimpan.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
                    });
            }
        });
    });
});
// Generate baris tabel berdasarkan tanggal
function generateRows(startDate, endDate) {
    const startOriginal = new Date(startDate);
    const endOriginal = new Date(endDate);

    let start = new Date(startDate);
    let end = new Date(endDate);
    let tbody = document.querySelector("#jamKerjaTable tbody");
    tbody.innerHTML = '';
    document.getElementById("jamKerjaTable").style.display = 'table';

    const bulanAwal = start.getMonth();
    const tahunAwal = start.getFullYear();
    let countBulanIni = 0;

    // Generate baris tanggal
    while (start <= end) {
        const dateStr = start.toISOString().slice(0, 10);

        if (start.getMonth() === bulanAwal && start.getFullYear() === tahunAwal) {
            countBulanIni++;
        }

        const row = `
        <tr>
            <td><input type="text" name="tanggal[]" class="form-control" value="${dateStr}" readonly></td>
            <td><input type="number" name="b[]" class="form-control b" onchange="calculate(this)"></td>
            <td><input type="number" name="c[]" class="form-control c" value="8" readonly></td>
            <td><input type="number" name="d[]" class="form-control d" readonly></td>
            <td><input type="number" name="e[]" class="form-control e" onchange="calculate(this)"></td>
            <td><input type="number" name="f[]" class="form-control f" onchange="calculate(this)"></td>
            <td><input type="number" name="g[]" class="form-control g" readonly></td>
            <td><input type="number" name="h[]" class="form-control h" readonly></td>
            <td><input type="number" name="i[]" class="form-control i" onchange="calculate(this)"></td>
            <td><input type="number" name="j[]" class="form-control j" onchange="calculate(this)"></td>
            <td><input type="number" name="k[]" class="form-control k" onchange="calculate(this)"></td>
            <td><input type="number" name="l[]" class="form-control l" onchange="calculate(this)"></td>
            <td><input type="number" name="m[]" class="form-control m" readonly></td>
            <td><input type="number" name="n[]" class="form-control n" readonly></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
        start.setDate(start.getDate() + 1);
    }

    const inputHariKerjaSekarang = document.querySelector('input[name="statistik_sekarang[0]"]');
    if (inputHariKerjaSekarang) {
        inputHariKerjaSekarang.value = countBulanIni;
    }

    const workPermitId = document.querySelector('input[name="work_permit_id"]')?.value;

    if (workPermitId) {
        fetch(`/permit/jam-kerja/statistik-bulan?work_permit_id=${encodeURIComponent(workPermitId)}&start_date=${encodeURIComponent(startDate)}&durasi_bulan=2`)
            .then(response => response.json())
            .then(data => {
                const statistikLaluHari = document.querySelector('input[name="statistik_lalu[0]"]');
                const statistikSekarangHari = document.querySelector('input[name="statistik_sekarang[0]"]');

                const statistikLaluJam = document.querySelector('input[name="statistik_lalu[1]"]');
                const statistikSekarangJam = document.querySelector('input[name="statistik_sekarang[1]"]');

                // Hari kerja
                if (statistikLaluHari) statistikLaluHari.value = data.bulan_lalu || 0;
                if (statistikSekarangHari) {
                    if ((data.bulan_ini || 0) > countBulanIni) {
                        statistikSekarangHari.value = data.bulan_ini;
                    } else {
                        statistikSekarangHari.value = countBulanIni;
                    }
                }

                // Manhours (Jam kerja real termasuk lembur)
                if (statistikLaluJam) statistikLaluJam.value = data.manhours_lalu || 0;
                if (statistikSekarangJam) statistikSekarangJam.value = data.manhours_ini || 0;

                hitungStatistikHSE();
            })
            .catch(err => {
                console.warn("Gagal ambil data statistik bulan, fallback ke hitung manual:", err);
                hitungHariKerjaManual(startDate, endDate);
            });

    } else {
        hitungHariKerjaManual(startDate, endDate);
    }
}

function hitungHariKerjaManual(startDateStr, endDateStr) {
    let hariKerja = 0;
    let start = new Date(startDateStr);
    let end = new Date(endDateStr);
    const bulanAwal = start.getMonth();
    const tahunAwal = start.getFullYear();

    while (start <= end) {
        if (start.getMonth() === bulanAwal && start.getFullYear() === tahunAwal) {
            hariKerja++;
        }
        start.setDate(start.getDate() + 1);
    }

    const inputLalu = document.querySelector('input[name="statistik_lalu[0]"]');
    const inputSekarang = document.querySelector('input[name="statistik_sekarang[0]"]');
    if (inputLalu) inputLalu.value = 0;
    if (inputSekarang) inputSekarang.value = hariKerja;

    hitungStatistikHSE();
}
// Kalkulasi baris
function calculate(el) {
    const row = el.closest('tr');

    const b = parseFloat(row.querySelector('.b')?.value) || 0;
    const c = parseFloat(row.querySelector('.c')?.value) || 0;
    const d = b * c;
    row.querySelector('.d').value = d;

    const e = parseFloat(row.querySelector('.e')?.value) || 0;
    const f = parseFloat(row.querySelector('.f')?.value) || 0;
    const g = e * f;
    row.querySelector('.g').value = g;

    const h = d + g;
    row.querySelector('.h').value = h;

    const i = parseFloat(row.querySelector('.i')?.value) || 0;
    const j = parseFloat(row.querySelector('.j')?.value) || 0;
    const k = parseFloat(row.querySelector('.k')?.value) || 0;
    const l = parseFloat(row.querySelector('.l')?.value) || 0;

    const m = (i + j + k + l);
    row.querySelector('.m').value = m;

    const n = h - m;
    row.querySelector('.n').value = n;

    updateTotal();
}
// Total keseluruhan
function updateTotal() {
    const selector = (cls) => Array.from(document.querySelectorAll(`#jamKerjaTable .${cls}`));
    const sum = (arr) => arr.reduce((acc, input) => acc + (parseFloat(input.value) || 0), 0);

    document.getElementById('total-d').textContent = sum(selector('d'));
    document.getElementById('total-g').textContent = sum(selector('g'));
    document.getElementById('total-h').textContent = sum(selector('h'));
    document.getElementById('total-m').textContent = sum(selector('m'));
    document.getElementById('total-n').textContent = sum(selector('n'));

    document.getElementById('total-i').textContent = sum(selector('i'));
    document.getElementById('total-j').textContent = sum(selector('j'));
    document.getElementById('total-k').textContent = sum(selector('k'));
    document.getElementById('total-l').textContent = sum(selector('l'));

    const totalManhours = sum(selector('h'));
    const inputManhourSekarang = document.querySelector('input[name="statistik_sekarang[1]"]');
    if (inputManhourSekarang) {
        inputManhourSekarang.value = totalManhours;
    }

    // Lanjut update total keseluruhan HSE
    hitungStatistikHSE();
}
const hitungStatistikHSE = () => {
    for (let i = 0; i < 2; i++) {
        const inputLalu = document.querySelector(`input[name="statistik_lalu[${i}]"]`);
        const inputSekarang = document.querySelector(`input[name="statistik_sekarang[${i}]"]`);
        const inputTotal = inputLalu.closest('tr').querySelectorAll('input')[2];

        const valLalu = parseInt(inputLalu.value) || 0;
        const valSekarang = parseInt(inputSekarang.value) || 0;
        inputTotal.value = valLalu + valSekarang;
    }

    const utama = parseInt(document.querySelector('input[name="jumlah_pekerja[utama]"]').value) || 0;
    const subkon = parseInt(document.querySelector('input[name="jumlah_pekerja[subkon]"]').value) || 0;
    const totalPekerjaInput = document.querySelector('input[name="jumlah_pekerja[total]"]');
    totalPekerjaInput.value = utama + subkon;
};

document.querySelectorAll(
    'input[name^="statistik_lalu"], input[name^="statistik_sekarang"], input[name^="jumlah_pekerja"]'
).forEach(input => {
    input.addEventListener('input', hitungStatistikHSE);
});

hitungStatistikHSE();

const sectionIndices = [17, 18, 19];

sectionIndices.forEach(index => {
    const rows = document.querySelectorAll(`input[name^="laporan[${index}][lalu]"]`);

    rows.forEach(inputLalu => {
        const row = inputLalu.closest('tr');
        const i = inputLalu.name.match(/\[(\d+)\]$/)[1];

        const inputSekarang = row.querySelector(`input[name="laporan[${index}][bulan_ini][${i}]"]`);
        const inputTotal = row.querySelector(`input[name="laporan[${index}][total][${i}]"]`);

        const updateTotal = () => {
            const valLalu = parseInt(inputLalu.value) || 0;
            const valSekarang = parseInt(inputSekarang.value) || 0;
            inputTotal.value = valLalu + valSekarang;
        };

        inputLalu.addEventListener('input', updateTotal);
        inputSekarang.addEventListener('input', updateTotal);
    });
});
