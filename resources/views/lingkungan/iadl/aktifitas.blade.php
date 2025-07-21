@php $aidx = $index; @endphp
<tr class="row-item aktifitas-row" data-aidx="{{ $aidx }}">
    <td class="text-center align-middle">-</td>
    <td>
        <textarea style="width: 250px;" name="data[{{ $aidx }}][aktifitas]" class="form-control" rows="2" required></textarea>
    </td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][aspek_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][dampak_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][risiko_lingkungan]" class="form-control" rows="2" required></textarea></td>
    <td>
        <select style="width: 100px;" name="data[{{ $aidx }}][kegiatan][0][na_be]" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="N">N</option>
            <option value="AB">AB</option>
            <option value="E">E</option>
        </select>
    </td>
      <td><input style="width: 150px;" type="text" name="data[{{ $aidx }}][kegiatan][0][no_dampak]" readonly class="form-control no-dampak"></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][l_awal]" class="form-control" min="1" required></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][c_awal]" class="form-control" min="1" required></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][total_awal]" class="form-control" readonly></td>
    <td><input style="width: 60px;" type="text" name="data[{{ $aidx }}][kegiatan][0][tingkat_risiko_awal]" class="form-control" readonly></td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][pengendalian_saat_ini]" class="form-control" rows="2" required></textarea></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][l_akhir]" class="form-control" min="1" required></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][c_akhir]" class="form-control" min="1" required></td>
    <td><input style="width: 60px;" type="number" name="data[{{ $aidx }}][kegiatan][0][total_akhir]" class="form-control" readonly></td>
    <td><input style="width: 60px;" type="text" name="data[{{ $aidx }}][kegiatan][0][tingkat_risiko_akhir]" class="form-control" readonly></td>
    <td><input style="width: 250px;" type="text" name="data[{{ $aidx }}][kegiatan][0][peluang]" class="form-control"></td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][peraturan_perundangan]" class="form-control" disabled></textarea></td>
    <td><textarea style="width: 250px;" name="data[{{ $aidx }}][kegiatan][0][pengendalian_lanjutan]" class="form-control" required></textarea></td>
    <td class="text-center align-middle">
        <button type="button" class="btn btn-sm btn-success addKegiatan mt-1" data-aidx="{{ $aidx }}" data-kidx="1">+</button>
        <button type="button" class="btn btn-sm btn-danger remove-row mt-1">-</button>
        <input type="hidden" class="kegiatan-count" value="1">
    </td>
</tr>
