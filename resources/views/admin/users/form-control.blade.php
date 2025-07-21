
<div class="col-md-12">
    <label for="name">Full Name</label>
    <input id="name" type="text" class="form-control" required name="name" value="{{ old('name') ?? $user->name }}" autofocus>
    @error('name')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="col-md-12">
    <label for="email">Email</label>
    <input id="email" type="email" value="{{ old('email') ?? $user->email }}" class="form-control" required name="email">
    @error('email')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
        @enderror
</div>
<div class="col-md-12">
    <input class="form-check-input primary" id="vdrcheck" {{ $user->is_vendor=='1' ? 'checked' : '' }} name="vdrcheck" type="checkbox" value="1">
    <label class="form-check-label" for="vdrcheck">Vendor</label>
    <select id="vendor_id" name="vendor_id" class="form-control" >
    </select>
</div>
<div class="col-md-12">
    <label class="form-check-label" for="vdrcheck">Unit Kerja</label>
    <select id="divisi_id" name="divisi_id" class="form-control" >
    </select>
</div>
<div class="col-md-12">
    <label class="form-check-label" for="vdrcheck">Tanggung Jawab Lokasi</label>
    <select id="lokasi_id" name="lokasi_id" class="form-control" >
    </select>
</div>
