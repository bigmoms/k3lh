@php $idx = $index ?? 1; @endphp
<tr class="row-item global-row" data-idx="{{ $idx }}">
    <td class="text-center align-middle">{{ $idx }}</td>

    {{-- Aktifitas (bebas diisi karena ini baris global) --}}
    <td>
        <textarea name="data[{{ $idx }}][aktifitas]" class="form-control" rows="2"></textarea>
    </td>

    {{-- Aspek Lingkungan --}}
    <td><textarea name="data[{{ $idx }}][aspek_lingkungan]" class="form-control" rows="2"></textarea></td>

    {{-- Dampak Lingkungan --}}
    <td><textarea name="data[{{ $idx }}][dampak_lingkungan]" class="form-control" rows="2"></textarea></td>

    {{-- Risiko Lingkungan --}}
    <td><textarea name="data[{{ $idx }}][risiko_lingkungan]" class="form-control" rows="2"></textarea></td>

    {{-- N / AB / E --}}
    <td>
        <select name="data[{{ $idx }}][na_be]" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="N">N</option>
            <option value="AB">AB</option>
            <option value="E">E</option>
        </select>
    </td>

    {{-- No Dampak --}}
    <td><input type="text" name="data[{{ $idx }}][no_dampak]" class="form-control"></td>

    {{-- Nilai Risiko Awal --}}
    <td><input type="number" name="data[{{ $idx }}][l_awal]" class="form-control" min="1"></td>
    <td><input type="number" name="data[{{ $idx }}][c_awal]" class="form-control" min="1"></td>
    <td><input type="number" name="data[{{ $idx }}][total_awal]" class="form-control" readonly></td>

    {{-- Tingkat Risiko Awal --}}
    <td><input type="text" name="data[{{ $idx }}][tingkat_risiko_awal]" class="form-control"></td>

    {{-- Pengendalian Saat Ini --}}
    <td><textarea name="data[{{ $idx }}][pengendalian_saat_ini]" class="form-control" rows="2"></textarea></td>

    {{-- Nilai Risiko Akhir --}}
    <td><input type="number" name="data[{{ $idx }}][l_akhir]" class="form-control" min="1"></td>
    <td><input type="number" name="data[{{ $idx }}][c_akhir]" class="form-control" min="1"></td>
    <td><input type="number" name="data[{{ $idx }}][total_akhir]" class="form-control" readonly></td>

    {{-- Tingkat Risiko Akhir --}}
    <td><input type="text" name="data[{{ $idx }}][tingkat_risiko_akhir]" class="form-control"></td>

    {{-- Peluang --}}
    <td><input type="text" name="data[{{ $idx }}][peluang]" class="form-control"></td>

    {{-- Peraturan Perundangan --}}
    <td><textarea name="data[{{ $idx }}][peraturan_perundangan]" class="form-control" rows="2" disabled></textarea></td>

    {{-- Pengendalian Lanjutan --}}
    <td><textarea name="data[{{ $idx }}][pengendalian_lanjutan]" class="form-control" rows="2" disabled></textarea></td>

    {{-- Aksi --}}
    <td class="text-center align-middle">
        <button type="button" class="btn btn-sm btn-danger remove-row">Hapus</button>
    </td>
</tr>
