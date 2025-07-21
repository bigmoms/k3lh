@php $idx = $index ?? 1; @endphp
<tr class="row-item">
    <td class="text-center" style="vertical-align: middle;">{{ $idx }}</td>
    <td><input type="text" name="data[{{ $idx }}][aktivitas]" class="form-control" required
            style="min-width: 140px;"></td>

    <td>
        <textarea name="data[{{ $idx }}][potensi_bahaya]" class="form-control" rows="2" style="min-width: 190px;"></textarea>
    </td>
    <td>
        <textarea name="data[{{ $idx }}][dampak_k3]" class="form-control" rows="2"
            style="min-width: 190px;"></textarea>
    </td>
    <td>
        <textarea name="data[{{ $idx }}][resiko_k3]" class="form-control" rows="2"
            style="min-width: 190px;"></textarea>
    </td>

    <td><input type="text" name="data[{{ $idx }}][r_n]" class="form-control" style="min-width: 90px;">
    </td>
    <td><input type="text" name="data[{{ $idx }}][no_dampak]" class="form-control"
            style="min-width: 110px;"></td>

    <td><input type="number" name="data[{{ $idx }}][l]" class="form-control" step="1"
            min="1" style="width: 40px;"></td>
    <td><input type="number" name="data[{{ $idx }}][c]" class="form-control" step="1"
            min="1" style="width: 40px;"></td>
    <td><input type="number" name="data[{{ $idx }}][total]" readonly class="form-control" step="1"
            min="1" style="width: 40px;"></td>

    <td><input type="text" name="data[{{ $idx }}][tingkat_risiko]" class="form-control"
            style="min-width: 110px;"></td>

    <td>
        <textarea name="data[{{ $idx }}][pengendalian_saat_ini]" class="form-control" rows="2"
            style="min-width: 190px;"></textarea>
    </td>

    <td><input type="number" name="data[{{ $idx }}][l_after]" class="form-control" step="1"
            min="1" style="width: 40px;"></td>
    <td><input type="number" name="data[{{ $idx }}][c_after]" class="form-control" step="1"
            min="1" style="width: 40px;"></td>
    <td><input type="number" name="data[{{ $idx }}][total_after]" readonly class="form-control"
            step="1" min="1" style="width: 40px;"></td>

    <td><input type="text" name="data[{{ $idx }}][tingkat_risiko_after]" class="form-control"
            style="min-width: 110px;"></td>
    <td><input type="text" name="data[{{ $idx }}][peluang]" class="form-control" style="min-width: 90px;">
    </td>

    <td>
        <textarea name="data[{{ $idx }}][peraturan_perundangan]" disabled class="form-control"
            style="min-width: 140px;"></textarea>
    </td>
    <td>
        <textarea name="data[{{ $idx }}][pengendalian_lanjutan]" disabled class="form-control"
            style="min-width: 140px;"></textarea>
    </td>

    <td class="text-center" style="vertical-align: middle;">
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
    </td>
</tr>
