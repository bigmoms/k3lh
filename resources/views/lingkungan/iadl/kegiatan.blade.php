@php
    $aidx = $aidx ?? 0;
    $kidx = $kidx ?? 0;
@endphp
<tr class="row-item kegiatan-row" data-parent="{{ $aidx }}">
    <td class="text-center align-middle">-</td>
    <td></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][aspek_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][dampak_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][risiko_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td>
        <select name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][na_be]" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="N">N</option>
            <option value="AB">AB</option>
            <option value="E">E</option>
        </select>
    </td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][no_dampak]" readonly class="form-control no-dampak"></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][l_awal]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][c_awal]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][total_awal]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][tingkat_risiko_awal]" class="form-control" readonly></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][pengendalian_saat_ini]" class="form-control" rows="2" required></textarea></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][l_akhir]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][c_akhir]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][total_akhir]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][tingkat_risiko_akhir]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][peluang]" class="form-control"></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][peraturan_perundangan]" class="form-control" disabled></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][pengendalian_lanjutan]" class="form-control" required></textarea></td>
    <td class="text-center align-middle">
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
    </td>
</tr>
