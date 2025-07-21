<tr data-node-id="{{ $isi['id'] }}" data-node-pid="{{ $isi['parent_id'] }}">
    <td>{{ $isi['id'] }}</td>
    <td>{{ $isi['name'] }}</td>
</tr>
@if(!empty($isi['children']) && (count($isi['children']) > 0))
    @each('roles.table', $isi['children'], 'isi')
@endif
