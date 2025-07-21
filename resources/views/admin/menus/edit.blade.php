@extends('layouts.master')
@section('title', 'Data User')
@section('header', 'Data User')

@section('style')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}"> --}}
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
        {{-- <div class="col-sm-12">
            <div class="card">
                <table id="routes-table" class="table table-bordered table-responsive">
                    <thead>
                             <tr>
                                 <th>uri</th>
                                 <th>Name</th>
                                 <th>Type</th>
                                 <th>Method</th>
                             </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $route )
                            @if (str_contains($route->getName(), 'index'))
                                 <tr>
                                     <td>{{$route->uri}}</td>
                                     <td>{{$route->getName()}}</td>
                                     <td>{{$route->getPrefix()}}</td>
                                     <td>{{$route->getActionName()}}</td>
                                 </tr>
                            @endif
                        @endforeach
                     </tbody>
             </table>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                        <h3>Tambah Menu Aplikasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="disabled-container"> </div>
                            <form class="row g-3 needs-validation custom-input tooltip-valid validation-forms" method="POST" action="{{ route('menus.update',$dtmenu) }}" novalidate="" id="formTambah" >
                                @csrf
                                @method("PUT")
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="displaytext" class="form-label">Judul Menu</label>
                                        <input type="text" class="form-control" id="displaytext" name="displaytext" value="{{ old('displaytext') ?? $dtmenu->displaytext }}"  required>
                                        <span id="displaytextError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="parent_id" class="form-label">Parent Menu</label>
                                        <select class="form-control" id="parent_id" name="parent_id" required>
                                            <option value="0">Pilih Menu</option>
                                            @foreach ($parent as $mnu)

                                                <option value="{{ $mnu->id }}" {{ $dtmenu->parent_id== $mnu->id ? "selected" : ""}} >{{ ucfirst($mnu->displaytext) }}</option>
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
                                                    <option value="{{ '/'.$route->uri }}" {{ $dtmenu->linkaddress == "/".$route->uri ? "selected" : ""}}>{{ '/'.$route->uri}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span id="targetlinkError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sortid" class="form-label">Urutan</label>
                                        <input type="number" class="form-control" id="sortid" name="sortid" value="{{ old('sortid') ?? $dtmenu->sortid }}" required>
                                        <span id="sortidError" class="text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status Aktif</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" {{ $dtmenu->is_active == '1' ? "selected" : ""}}>Aktif</option>
                                            <option value="0" {{ $dtmenu->is_active == '0' ? "selected" : ""}}>Tidak Aktif</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" onclick="kembali();">Batal</button>
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

    function kembali(){
        window.location.href = "{{ route('menus.index') }}";
    }



</script>
@endsection
