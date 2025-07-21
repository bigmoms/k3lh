@php
    $label = ucwords(str_replace('_', ' ', $jabatan));
    $pekerjaJabatan = $workers->where('jabatan', $jabatan);
@endphp

<tr class="jabatan-header bg-secondary text-white" style="font-weight:bolder" data-jabatan="{{ $jabatan }}">
    <td colspan="5">
        {{ $label }}
        <button type="button" class="btn btn-success btn-sm tambah-pekerja float-end" data-jabatan="{{ $jabatan }}">+</button>
    </td>
</tr>

<tr>
    <td colspan="5">
        <table class="table table-sm pekerja-table">
            <tbody id="pekerja-list-{{ $jabatan }}">
                @forelse ($pekerjaJabatan as $worker)
                    @foreach ($worker->workerDetails as $pekerja)
                        <tr>
                            <td>
                                <input type="hidden" name="worker_id[{{ $jabatan }}][]" value="{{ $pekerja->id }}">
                                <input type="text" name="nama[{{ $jabatan }}][]" class="form-control nama-pekerja" value="{{ $pekerja->nama }}">
                            </td>
                            <td>
                                <input type="hidden" name="ktp_existing[]" value="ktp_lama.pdf">
                                <input type="file" name="ktp[{{ $jabatan }}][]" class="form-control ktp" accept=".pdf,.jpg,.png">
                                @if ($pekerja->lampiran_ktp)
                                    <a href="{{ asset('storage/' . $pekerja->lampiran_ktp) }}" target="_blank">Lihat</a>
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="sertifikat_existing[]" value="sertifikat_lama.pdf">
                                <input type="file" name="sertifikat[{{ $jabatan }}][]" class="form-control sertifikat" accept=".pdf,.jpg,.png">
                                @if ($pekerja->lampiran_sertifikat)
                                    <a href="{{ asset('storage/' . $pekerja->lampiran_sertifikat) }}" target="_blank">Lihat</a>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm hapus-pekerja">-</button>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td>
                            <small><p style="color: red">Input nama pekerja</p></small>
                            <input type="text" name="nama[{{ $jabatan }}][]" class="form-control nama-pekerja" placeholder="Nama Pekerja">
                        </td>
                        <td>
                            <small><p style="color: red">Ukuran file maksimal 2MB</p></small>
                            <input type="file" name="ktp[{{ $jabatan }}][]" class="form-control ktp" accept=".pdf,.jpg,.png">
                        </td>
                        <td>
                            <small><p style="color: red">Ukuran file maksimal 2MB</p></small>
                            <input type="file" name="sertifikat[{{ $jabatan }}][]" class="form-control sertifikat" accept=".pdf,.jpg,.png">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-pekerja">-</button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </td>
</tr>
