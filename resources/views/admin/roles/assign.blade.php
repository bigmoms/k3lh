@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('style')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}"> --}}
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6 col-12">
                        <h2>Role Assign Permission</h2>
                    </div>
                    <div class="col-sm-6 col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Role Assign Permission</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-body">
                            <form id="formTambah" action="{{ route('role.update',$role) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" readonly value="{{ old('name') ?? $role->name }}" autofocus>
                                            <input type="hidden" class="form-control" id="role_id" name="role_id" readonly value="{{ old('id') ?? $role->id }}" autofocus>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" >Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-block row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="tree-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <select  style="width:100%; height:350px"  multiple="multiple" size="10" name="listmenu[]" id="listmenu">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('admin.roles.create') --}}
@endsection

@section('scripts')
<script src="{{asset('assets/js/tree/tree.js') }}"></script>
<script>
    $(function () {
        $.ajax({
            type: "GET",
            url: "{{ route('menus.getmenus') }}",
            dataType: "json",
            success: function(response)
            {
                setmenus(response);
            }
        });

        var sites = {!! json_encode($rolemenu->toArray()) !!};
        var dtk = [];
        sites.forEach((a) => {
            if (a.id!=1){
            dtk.push(a.id);
            }
        });
        console.log(dtk);

        function setmenus(data){

            let tree=new Tree(".tree-container", {
                data: data,
                closeDepth: 3,
                loaded: function () {
                    this.values = dtk;
                    // console.log(this.selectedNodes);
                    // console.log(this.values);
                },
                onChange: function () {
                    var a = this.selectedNodes;
                    document.getElementById("listmenu").innerHTML = "";
                    var selectElement = document.getElementById('listmenu');
                    a.forEach((Employees) => {
                        option = document.createElement( 'option' );
                        option.value = Employees.id;
                        option.text = Employees.text;
                        option.selected = true;
                        selectElement.add(option);

                    });
                },
            });
        }
    });
</script>
@endsection
