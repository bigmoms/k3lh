@extends('layouts.master')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2>Data User</h2>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Data User</li>
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
                            <form action="{{ route('update.user.role',$user) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" readonly name="name" id="name" value="{{ old('name') ?? $user->name }}" class="form-control" required>
                                            @error('name')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="role">Role</label>
                                            <br>
                                            <select name="role" id="role" class="form-control select2">
                                                <option value="" selected>--Select Role --</option>
                                                @foreach ($roles as $role)
                                                    <option {{ $user->roles->isEmpty() ?  '' : ($user->roles[0]->name == $role->name ? 'selected' : '') }} value="{{ $role->name }}">{{ $role->name }} </option>
                                                @endforeach
                                            </select>
                                            @error('permission')
                                                <div class="mt-2 text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" onclick="kembali();">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
    });

    function kembali(){
    window.location.href = "{{ route('user.index') }}";
}

</script>
@endsection
