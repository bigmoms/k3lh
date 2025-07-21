@php
    $aidx = $aidx ?? 0;
    $kidx = $kidx ?? 0;
@endphp
<tr class="row-item kegiatan-row" data-parent="{{ $aidx }}">
    <td class="text-center align-middle">-</td>
    <td></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][potensi_bahaya]" class="form-control" rows="2" required></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][dampak_k3]" class="form-control" rows="2" required></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][resiko_k3]" class="form-control" rows="2" required></textarea></td>
    <td>
        <select name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][r_n]" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="R">R</option>
            <option value="NR">NR</option>
            <option value="E">E</option>
        </select>
    </td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][no_dampak]" readonly class="form-control no-dampak"></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][l]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][c]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][total]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][tingkat_risiko]" class="form-control" readonly></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][pengendalian_saat_ini]" class="form-control" rows="2" required></textarea></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][l_after]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][c_after]" class="form-control" min="1" required></td>
    <td><input type="number" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][total_after]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][tingkat_risiko_after]" class="form-control" readonly></td>
    <td><input type="text" name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][peluang]" class="form-control"></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][peraturan_perundangan]" class="form-control" disabled></textarea></td>
    <td><textarea name="data[{{ $aidx }}][kegiatan][{{ $kidx }}][pengendalian_lanjutan]" class="form-control" required></textarea></td>
    <td class="text-center align-middle">
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
    </td>
</tr>
