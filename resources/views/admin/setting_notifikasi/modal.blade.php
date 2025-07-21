<input type="hidden" name="id" id="id" value="{{ $data->id ?? '' }}">

<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" class="form-control" name="title" id="title" value="{{ $data->title ?? '' }}">
</div>

<div class="mb-3">
    <label class="form-label">Video (MP4)</label>
    <input type="file" class="form-control" name="link_video" id="link_video" accept="video/mp4"
        value="{{ $data->link_video ?? '' }}">
</div>

<div class="mb-3">
    <label class="form-label">Body</label>
    <textarea class="form-control" name="body" id="body" cols="5" rows="5">{{ $data->body ?? '' }}</textarea>
</div>
