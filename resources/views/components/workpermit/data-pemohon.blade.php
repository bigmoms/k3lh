<div class="col-12">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Data Pemohon</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label" for="telepon_pemohon">
                    Telepon Pemohon <span class="text-danger">*</span>
                </label>
                <input class="form-control" id="telepon_pemohon" type="number" name="telepon_pemohon"
                    placeholder="Masukkan telepon pemohon"
                    value="{{ old('telepon_pemohon', $workPermit->telepon_pemohon ?? '') }}" required />
                <div class="invalid-feedback">Harap isi telepon pemohon.</div>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="nama_pengawas">
                    Nama Pengawas <span class="text-danger">*</span>
                </label>
                <input class="form-control" id="nama_pengawas" type="text" name="nama_pengawas"
                    placeholder="Masukkan nama pengawas" value="{{ old('nama_pengawas', $workPermit->pengawas ?? '') }}"
                    required />
                <div class="invalid-feedback">Harap isi nama pengawas.</div>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="telepon_pengawas">
                    Telepon Pengawas <span class="text-danger">*</span>
                </label>
                <input class="form-control" id="telepon_pengawas" type="number" name="telepon_pengawas"
                    placeholder="Masukkan telepon pengawas"
                    value="{{ old('telepon_pengawas', $workPermit->telepon_pengawas ?? '') }}" required />
                <div class="invalid-feedback">Harap isi telepon pengawas.</div>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="lampiran_struktur">Lampiran Struktur</label>
                <input class="form-control" id="lampiran_struktur" type="file" name="lampiran_struktur"
                    accept=".jpg,.jpeg,.png,.pdf" />
                <div id="preview_lampiran" class="mt-2">
                    @if (!empty($workPermit->lampiran_struktur))
                        <a href="{{ asset('storage/' . $workPermit->lampiran_struktur) }}" target="_blank"
                            class="btn btn-sm btn-primary">
                            Lihat Lampiran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
