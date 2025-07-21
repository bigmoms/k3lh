<input type="hidden" name="id" id="id" value="{{ $data->id ?? '' }}">

<div class="mb-3">
    <label class="form-label">Karyawan</label>
    <select class="form-control select2" name="nik" id="nik">
        <option value="">--Pilih--</option>
        @foreach ($karyawan as $el)
            <option value="{{ $el->nik }}" {{ isset($data) && $data->nik == $el->nik ? 'selected' : '' }}>
                {{ $el->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ $data->tanggal ?? '' }}">
</div>

<div class="mb-3">
    <label class="form-label">File MCU (PDF)</label>
    <input type="file" class="form-control" name="file_mcu" id="file_mcu" accept="application/pdf">

    @if (!empty($data) && $data->file_mcu)
        <div class="mt-2">
            <p class="mt-2"><a href="{{ asset('storage/' . $data->file_mcu) }}" target="_blank">Lihat file MCU
                    sebelumnya</a></p>
        </div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea class="form-control" name="keterangan" id="keterangan" cols="5" rows="5">{{ $data->keterangan ?? '' }}</textarea>
</div>


<script>
    $(document).ready(function() {
        $(".select2").select2({
            dropdownParent: $("#modal-x")
        });
    });
</script>
