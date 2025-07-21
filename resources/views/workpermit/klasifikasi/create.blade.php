@extends('layouts.master')
@section('title', 'Tambah Data Klasifikasi Pekerjaan')
@section('header', 'Tambah Data Klasifikasi Pekerjaan')
@section('style')
<style>
    #apdList, #perlengkapanList {
        display: flex;
        flex-wrap: wrap;
    }

    .apd-column, .perlengkapan-column {
        display: flex;
        flex-direction: column;
        margin-right: 20px;
    }

    .apd-column div, .perlengkapan-column div {
        margin-bottom: 5px;
    }
</style>
@endsection
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Tambah Data Klasifikasi Pekerjaan</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Data Pekerjaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-body">
                                <form id="klasifikasiPekerjaanForm">
                                    @csrf
                                    <div class="form-group mb-1">
                                        <label for="name" class="form-label">Nama Klasifikasi</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                        <span id="nameError" class="text-danger"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">APD yang Dibutuhkan</label>
                                        <div id="apdList">
                                            @foreach ($existingApds as $apd)
                                                <div style="margin-right: 20px;">
                                                    <input type="checkbox" name="apds[]" value="{{ $apd->name }}">
                                                    {{ $apd->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="text" id="newApd" class="form-control"
                                            placeholder="Tambahkan APD baru">
                                        <button type="button" id="addApd" class="btn btn-sm btn-primary mt-2">Tambah
                                            APD</button>
                                        <span id="apdError" class="text-danger"></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Perlengkapan Darurat</label>
                                        <div id="perlengkapanList">
                                            @foreach ($existingPerlengkapans as $perlengkapan)
                                                <div style="margin-right: 20px;">
                                                    <input type="checkbox" name="perlengkapans[]"
                                                        value="{{ $perlengkapan->name }}">
                                                    {{ $perlengkapan->name }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="text" id="newPerlengkapan" class="form-control"
                                            placeholder="Tambahkan Perlengkapan baru">
                                        <button type="button" id="addPerlengkapan"
                                            class="btn btn-sm btn-primary mt-2">Tambah
                                            Perlengkapan</button>
                                        <span id="perlengkapanError" class="text-danger"></span>
                                    </div>

                                    <div class="mt-5">
                                        <a href="{{ route('admin.klasifikasi.index') }}" class="btn btn-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
            });
            $("#addApd").click(function() {
                let apd = $("#newApd").val().trim();
                if (apd === "") {
                    return;
                }
                let isDuplicate = false;
                $("input[name='apds[]']").each(function() {
                    if ($(this).val().toLowerCase() === apd.toLowerCase()) {
                        isDuplicate = true;
                    }
                });
                if (isDuplicate) {
                    $("#apdError").text("APD ini sudah ada dalam daftar.");
                    return;
                }
                $("#apdList").append(`
                <div style="mt-2">
                    <input type="checkbox" name="apds[]" value="${apd}" checked> ${apd}
                    <button type="button" class="remove-item btn btn-sm btn-danger">X</button>
                </div>
            `);
                $("#newApd").val("");
                $("#apdError").text("");
            });

            $("#addPerlengkapan").click(function() {
                let perlengkapan = $("#newPerlengkapan").val().trim();

                if (perlengkapan === "") {
                    return;
                }
                let isDuplicate = false;
                $("input[name='perlengkapans[]']").each(function() {
                    if ($(this).val().toLowerCase() === perlengkapan.toLowerCase()) {
                        isDuplicate = true;
                    }
                });

                if (isDuplicate) {
                    $("#perlengkapanError").text("Perlengkapan ini sudah ada dalam daftar.");
                    return;
                }
                $("#perlengkapanList").append(`
                <div style="mt-2">
                    <input type="checkbox" name="perlengkapans[]" value="${perlengkapan}" checked> ${perlengkapan}
                    <button type="button" class="remove-item btn btn-sm btn-danger">X</button>
                </div>
            `);
                $("#newPerlengkapan").val("");
                $("#perlengkapanError").text("");
            });

            $(document).on("click", ".remove-item", function() {
                $(this).parent().remove();
            });

            $("#klasifikasiPekerjaanForm").on("submit", function(e) {
                e.preventDefault();

                $(".text-danger").text("");

                let formData = {
                    _token: $("input[name=_token]").val(),
                    name: $("#name").val(),
                    apds: $("input[name='apds[]']:checked").map(function() {
                        return $(this).val();
                    }).get(),
                    perlengkapans: $("input[name='perlengkapans[]']:checked").map(function() {
                        return $(this).val();
                    }).get()
                };
                if (formData.apds.length === 0) {
                    $("#apdError").text("Minimal 1 APD harus dipilih.");
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.klasifikasi.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Sukses!",
                            text: response.message,
                        }).then(() => {
                            window.location.href =
                                "{{ route('admin.klasifikasi.index') }}";
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $("#nameError").text(errors.name[0]);
                            }
                            if (errors.apds) {
                                $("#apdError").text(errors.apds[0]);
                            }
                            if (errors.perlengkapans) {
                                $("#perlengkapanError").text(errors.perlengkapans[0]);
                            }
                        }
                    },
                });
            });
        });
    </script>

@endsection
