$(document).ready(function () {
    document.getElementById("lampiran_struktur").addEventListener("change", function (event) {
        let file = event.target.files[0];
        let previewContainer = document.getElementById("preview_lampiran");

        if (!file) return;

        let reader = new FileReader();
        reader.onload = function (e) {
            previewContainer.innerHTML =
                `<a href="${e.target.result}" target="_blank" class="btn btn-sm btn-secondary mt-2">Preview Lampiran Baru</a>`;
        };
        reader.readAsDataURL(file);
    });

    function getWorkPermitId() {
        return $("#work_permit_id").val() || localStorage.getItem("work_permit_id");
    }

    function setWorkPermitId(id) {
        $("#work_permit_id").val(id);
        localStorage.setItem("work_permit_id", id);
    }

    localStorage.removeItem("work_permit_id");

    function validateForm(form) {
        let isValid = true;
        $(form).find("input, select, textarea").each(function () {
            if ($(this).attr("type") !== "file" && !$(this).val()) {
                $(this).addClass("is-invalid");
                isValid = false;
            } else {
                $(this).removeClass("is-invalid");
            }
        });
        return isValid;
    }

    $("#nextStep").click(function () {
        let form = $("#step1Form")[0];
        if (!validateForm(form)) {
            Swal.fire("Error!", "Mohon isi semua data yang diperlukan!", "error");
            return;
        }
        let formData = new FormData(form);
        let purchaseOrderId = $("#purchase_order_id").val();
        if (!purchaseOrderId) {
            Swal.fire("Error!", "Purchase Order ID tidak ditemukan!", "error");
            return;
        }
        formData.append("purchase_order_id", purchaseOrderId);
        $.ajax({
            url: storeStep1Url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            beforeSend: function () {
                Swal.fire({
                    title: "Menyimpan...",
                    text: "Mohon tunggu sebentar",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success) {
                    $("#work_permit_id").val(response.work_permit_id);
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        let nextTab = new bootstrap.Tab($("#daftar-pekerja-tab"));
                        nextTab.show();
                    });
                } else {
                    Swal.fire("Peringatan!", response.message || "Data berhasil disimpan, tetapi tidak ada redirect.", "warning");
                }
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.message ||
                    "Terjadi kesalahan, coba lagi.";

                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: errorMessage
                });
            }
        });
    });

    function compressImage(file, quality = 0.7, callback) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = event => {
            const img = new Image();
            img.src = event.target.result;
            img.onload = () => {
                const canvas = document.createElement("canvas");
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0);
                canvas.toBlob(blob => {
                    callback(blob);
                }, file.type, quality);
            };
        };
    }

    $(document).ready(function () {
        let deletedWorkers = [];

        $(document).on("change", "input[type='file']", function () {
            let input = $(this);
            let file = input[0].files[0];
            let allowedTypes = ["image/png", "image/jpeg", "application/pdf"];
            let maxSizeMB = 2;
            input.removeClass("is-invalid").siblings(".invalid-feedback").remove();
            previewDiv.html("");

            if (file && allowedTypes.includes(file.type)) {
                if (file.size > maxSizeMB * 1024 * 1024) {
                    if (file.type.startsWith("image/")) {
                        // Kompres gambar
                        compressImage(file, 0.7, compressedBlob => {
                            if (compressedBlob.size > maxSizeMB * 1024 * 1024) {
                                input.addClass("is-invalid").after('<div class="invalid-feedback">Ukuran gambar terlalu besar meskipun sudah dikompres.</div>');
                                input.val("");
                            } else {
                                let newFile = new File([compressedBlob], file.name, { type: file.type });
                                let dataTransfer = new DataTransfer();
                                dataTransfer.items.add(newFile);
                                input[0].files = dataTransfer.files;

                                let reader = new FileReader();
                                reader.onload = function (e) {
                                    previewDiv.html(`<img src="${e.target.result}" class="img-thumbnail" width="100">`);
                                };
                                reader.readAsDataURL(newFile);
                            }
                        });
                    } else {
                        input.addClass("is-invalid").after('<div class="invalid-feedback">Ukuran file maksimal 2MB.</div>');
                        input.val("");
                    }
                } else {
                    if (file.type.startsWith("image/")) {
                        let reader = new FileReader();
                        reader.onload = function (e) {
                            previewDiv.html(`<img src="${e.target.result}" class="img-thumbnail" width="100">`);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewDiv.html(`<a href="#" class="btn btn-sm btn-info">Lihat File</a>`);
                    }
                }
            } else {
                input.addClass("is-invalid").after('<div class="invalid-feedback">Format harus PDF/JPG/PNG.</div>');
                input.val("");
            }
        });

        $("#nextStep2").click(function (event) {
            event.preventDefault();
            let isValid = true;
            let formData = new FormData($("#step2Form")[0]);
            let workPermitId = $("#work_permit_id").val();

            if (!workPermitId) {
                Swal.fire({ icon: "error", title: "Gagal!", text: "Work Permit ID belum tersedia. Harap isi data di Step 1 terlebih dahulu." });
                return;
            }

            formData.append("work_permit_id", workPermitId);

            $("#daftar-pekerja-body tr").each(function () {
                let row = $(this);
                let namaPekerjaInput = row.find('input[name^="nama"]');
                let namaPekerja = namaPekerjaInput.val()?.trim();
                let ktpInput = row.find('input[name^="ktp"]');
                let ktpExistingInput = row.find('input[name^="ktp_existing"]');
                let sertifikatInput = row.find('input[name^="sertifikat"]');
                let sertifikatExistingInput = row.find('input[name^="sertifikat_existing"]');
                row.find(".error-message").remove();

                if (namaPekerja) {
                    formData.append(namaPekerjaInput.attr("name"), namaPekerja);

                    // Validasi KTP
                    if (ktpExistingInput.length > 0 && ktpExistingInput.val()) {
                        formData.append("ktp_existing[]", ktpExistingInput.val());
                    } else if (ktpInput.length > 0 && ktpInput[0].files.length > 0) {
                        formData.append(ktpInput.attr("name"), ktpInput[0].files[0]);
                    } else {
                        isValid = false;
                        ktpInput.parent().append('<span class="error-message text-danger">KTP wajib diupload</span>');
                    }

                    // Validasi Sertifikat
                    if (sertifikatExistingInput.length > 0 && sertifikatExistingInput.val()) {
                        formData.append("sertifikat_existing[]", sertifikatExistingInput.val());
                    } else if (sertifikatInput.length > 0 && sertifikatInput[0].files.length > 0) {
                        formData.append(sertifikatInput.attr("name"), sertifikatInput[0].files[0]);
                    } else {
                        isValid = false;
                        sertifikatInput.parent().append('<span class="error-message text-danger">Sertifikat wajib diupload</span>');
                    }
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: "error",
                    title: "Silakan cek kembali",
                    text: "Pastikan semua field yang wajib diisi sudah benar.",
                });
                return;
            }

            deletedWorkers.forEach(workerId => {
                formData.append("deleted_workers[]", workerId);
            });

            $.ajax({
                url: storeStep2Url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                beforeSend: function () {
                    Swal.fire({
                        title: "Menyimpan...",
                        text: "Mohon tunggu sebentar",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });
                },
                success: function (response) {
                    Swal.close();
                    if (response.success) {
                        setWorkPermitId(response.work_permit_id);
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            let nextTab = new bootstrap.Tab($("#daftar-perlengkapan-tab"));
                            nextTab.show();
                        });
                    } else {
                        Swal.fire("Peringatan!", response.message || "Data berhasil disimpan, tetapi tidak ada redirect.", "warning");
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON?.message || "Terjadi kesalahan, coba lagi.";
                    Swal.fire({ icon: "error", title: "Gagal!", text: errorMessage });
                }
            });
        });

        $(document).on("click", ".tambah-pekerja", function () {
            let jabatan = $(this).data("jabatan");
            let rowHtml = `
            <tr class="jabatan-body" data-jabatan="${jabatan}">
                <td> <small><p style="color: red">Input nama pekerja</p></small>
                 <input type="text" name="nama[${jabatan}][]" class="form-control nama-pekerja" placeholder="Nama Pekerja"> </td>
                <td>
                <small><p style="color: red">Ukuran file maksimal 2MB</p></small>
                    <input type="file" name="ktp[${jabatan}][]" class="form-control ktp" accept=".pdf,.jpg,.png">
                </td>
                <td>
                <small><p style="color: red">Ukuran file maksimal 2MB</p></small>
                    <input type="file" name="sertifikat[${jabatan}][]" class="form-control sertifikat" accept=".pdf,.jpg,.png">
                </td>
                <td> <button type="button" class="btn btn-danger btn-sm hapus-pekerja">-</button> </td>
            </tr>`;
            $(`#pekerja-list-${jabatan}`).append(rowHtml);
        });

        $(document).on("click", ".hapus-pekerja", function () {
            let workerId = $(this).data("worker-id");
            let row = $(this).closest("tr");
            let namaPekerja = row.find('input[name^="nama"]').val()?.trim();

            if (workerId && namaPekerja) {
                deletedWorkers.push(workerId);
            }
            row.remove();
        });

        $("#prevStep1").click(function () {
            var previousTab = new bootstrap.Tab($("#detail-pekerjaan-tab"));
            previousTab.show();
        });
    });


    $(document).ready(function () {
        let deletedEquipment = [];

        // Menambahkan baris baru (peralatan)
        $("#tambah-peralatan").click(function () {
            let kategori = $("#kategori").val();
            if (!kategori) {
                Swal.fire({ icon: "warning", title: "Pilih Kategori!" });
                return;
            }

            let kategoriText = kategori.replace("_", " ");

            let rowHtml = `
            <tr>
                <td>
                    <input type="hidden" name="kategori[]" value="${kategori}">
                    ${kategoriText}
                </td>
                <td><input type="text" name="nama[]" class="form-control" required></td>
                <td><input type="number" name="jumlah[]" class="form-control" min="1" required></td>
                <td>
                    <input type="file" name="lampiran_foto[]" class="form-control" accept=".jpg,.png,.pdf">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapus-peralatan"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`;

            $("#daftar-peralatan-body").append(rowHtml);
        });

        // Menghapus peralatan yang sudah ada
        $(document).on("click", ".hapus-peralatan", function () {
            let row = $(this).closest("tr");
            let equipmentId = row.data("equipment-id");

            if (equipmentId) {
                deletedEquipment.push(equipmentId);
            }
            row.remove();
        });

        // Simpan Data Step 3
        $("#saveStep3").click(function (event) {
            event.preventDefault();

            let workPermitId = getWorkPermitId();
            if (!workPermitId) {
                Swal.fire({ icon: "error", title: "Gagal!", text: "Work Permit ID belum tersedia." });
                return;
            }

            if ($("#daftar-peralatan-body tr").length === 0) {
                Swal.fire({ icon: "warning", title: "Belum ada peralatan!", text: "Tambahkan setidaknya satu peralatan." });
                return;
            }

            let formData = new FormData($("#step3Form")[0]);
            formData.append("work_permit_id", workPermitId);

            if (deletedEquipment.length > 0) {
                deletedEquipment.forEach(id => formData.append("deleted_equipment[]", id));
            }

            $.ajax({
                url: storeStep3Url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                beforeSend: function () {
                    Swal.fire({
                        title: "Menyimpan...",
                        text: "Mohon tunggu sebentar",
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });
                },
                success: function (response) {
                    Swal.close();
                    if (response.success) {
                        $("#work_permit_id").val(response.work_permit_id);
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            new bootstrap.Tab(document.querySelector("#jsa-tab")).show();
                        });
                    } else {
                        Swal.fire("Peringatan!", response.message || "Data berhasil disimpan.", "warning");
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON?.message || "Terjadi kesalahan.";
                    Swal.fire({ icon: "error", title: "Gagal!", text: errorMessage });
                }
            });
        });

        $("#prevStep2").click(function () {
            new bootstrap.Tab(document.querySelector("#daftar-pekerja-tab")).show();
        });
    });

    $(document).ready(function () {
        const alphabet = 'abcdefghijklmnopqrstuvwxyz';
        let globalIndex = $("input[name^='jsa']").length;
        let tahapanCounter = {};

        // Hitung ulang tahapanCounter berdasarkan data awal
        $("[name^='jsa']").each(function () {
            let name = $(this).attr('name');
            let match = name.match(/jsa\[(\d+)\]\[tahapan\]/);
            if (match) {
                let index = match[1];
                let tahapan = $(this).val();
                if (!tahapanCounter[tahapan]) {
                    tahapanCounter[tahapan] = 0;
                }
                tahapanCounter[tahapan]++;
            }
        });

        // Tambah baris baru
        $(".add-row").click(function () {
            let tahapan = $(this).data("tahapan");

            if (!tahapanCounter[tahapan]) {
                tahapanCounter[tahapan] = 0;
            }

            let labelIndex = tahapanCounter[tahapan];
            let label = alphabet[labelIndex] ? `${alphabet[labelIndex]}.` : `${labelIndex + 1}.`;

            let newRow = `
                <tr>
                    <td class="text-center align-middle">${label}
                        <input type="hidden" name="jsa[${globalIndex}][tahapan]" value="${tahapan}">
                    </td>
                    <td><input type="text" name="jsa[${globalIndex}][sub_tahapan]" class="form-control" placeholder="Aktivitas"></td>
                    <td><textarea name="jsa[${globalIndex}][identifikasi_bahaya]" class="form-control" placeholder="Potensi Bahaya"></textarea></td>
                    <td>
                        <div class="input-group">
                            <textarea name="jsa[${globalIndex}][pengendalian_risiko]" class="form-control" placeholder="Pengendalian Risiko"></textarea>
                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;

            $(`#tbody-${tahapan}`).append(newRow);
            tahapanCounter[tahapan]++;
            globalIndex++;
        });

        // Hapus baris
        $(document).on("click", ".delete-row", function () {
            $(this).closest("tr").remove();
        });

        // Submit Step 4
        $("#step4Form").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            let workPermitId = $("#work_permit_id").val();

            if (!workPermitId) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Work Permit ID belum tersedia. Harap isi data di Step 1 terlebih dahulu."
                });
                return;
            }

            formData.append("work_permit_id", workPermitId);

            if (typeof storeStep4Url === "undefined" || !storeStep4Url) {
                Swal.fire("Error!", "URL penyimpanan tidak ditemukan.", "error");
                return;
            }

            $.ajax({
                url: storeStep4Url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $("#work_permit_id").val(response.work_permit_id);
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = response.url;
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let field in errors) {
                            errorMessage += errors[field].join(', ') + '\n';
                        }
                        Swal.fire("Validation Error", errorMessage, "error");
                    } else {
                        Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                    }
                }
            });
        });

        $("#prevStep3").click(function () {
            new bootstrap.Tab(document.querySelector("#daftar-perlengkapan-tab")).show();
        });
    });

});
