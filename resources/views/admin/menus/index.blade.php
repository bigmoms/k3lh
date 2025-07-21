@extends('layouts.master')
@section('title', 'Data User')
@section('header', 'Data User')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/js/jstree/themes/default/style.min.css') }}" />
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2>Menu Aplikasi   </h2>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Menu Aplikasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts  -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>Tambah Menu Aplikasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="disabled-container"> </div>
                            <form class="row g-3 needs-validation custom-input tooltip-valid validation-forms" novalidate="" id="formTambah" >
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="displaytext" class="form-label">Judul Menu</label>
                                        <input type="text" class="form-control" id="displaytext" name="displaytext" required>
                                        <span id="displaytextError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Parent Menu</label>
                                        <select class="form-control" id="parent_id" name="parent_id" required>
                                            <option value="0">Pilih Menu</option>
                                            @foreach ($parent as $mnu)
                                                <option value="{{ $mnu->id }}">{{ ucfirst($mnu->displaytext) }}</option>
                                            @endforeach
                                        </select>
                                        <span id="parent_idError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="targetlink" class="form-label">Target Link</label>
                                        <select class="form-control" id="targetlink" name="targetlink" required>
                                            <option value="#">Pilih Target</option>
                                            <option value="#">Sub Menu</option>
                                            @foreach ($routes as $route )
                                                @if (str_contains($route->getName(), 'index'))
                                                    <option value="{{ '/'.$route->uri }}">{{'/'.$route->uri}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span id="targetlinkError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sortid" class="form-label">Urutan</label>
                                        <input type="number" class="form-control" id="sortid" name="sortid" required>
                                        <span id="sortidError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status Aktif</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        {{-- <button type="button" class="btn btn-primary" >Close</button> --}}
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div id="tree-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{asset('assets/js/jstree/jstree.min.js') }}"></script>
<script src="{{asset('assets/js/tree/tree.min.js') }}"></script>


<script>
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    $('#formTambah').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('menus.store')}}",
            type: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid').next(
                        '.invalid-feedback').text(value[0]);
                });
            }
        });
    });

    $('#tree-container').jstree({
		'core' : {
			'data' : {
				"url" : "{{ route('menus.getmenus') }}",
				"dataType" : "json" // needed only if you do not supply JSON headers
			}
		}
	}).bind('loaded.jstree', function (event, data) {
        $(this).jstree('open_all');
    });

    $('#tree-container').on('activate_node.jstree', function (e, data) {
        if (data == undefined || data.node == undefined || data.node.id == undefined)
            return;
        var id = data.node.id;
        var url = '{{ route("menus.edit", ":id") }}';
            url = url.replace(':id', id);
        window.location.href =url;
    });
</script>
@endsection
