<div class="mb-3">
    <label class="form-label">Nama Folder</label>
    <input class="form-control" type="text" name="name" required>
</div>

<div class="mb-3">
    <label>Folder Induk</label>
    <select class="form-control select2" name="parent_id">
        <option value="">(Root)</option>
        @foreach ($folders as $folder)
            <option value="{{ $folder->id }}">{{ $folder->name_with_hierarchy }}</option>
        @endforeach
    </select>
</div>

<script>
    $(document).ready(function() {
        $(".select2").select2({
            dropdownParent: $("#modal-x")
        });
    });
</script>
