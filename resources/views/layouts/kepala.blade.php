
@if(!empty($isi['children']) && (count($isi['children']) > 0))
    @php ( $pnh = '<i class="iconly-Arrow-Right-2 icli"> </i>')
    @php ( $href = 'javascript:void(0)')
@else
    @php ( $pnh = '')
    @php ( $href = $isi['href'])
@endif

<li class="sidebar-list">
    <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="{!! $href !!}">
        <svg class="stroke-icon">
          <use href="{{asset('assets/svg/iconly-sprite.svg#'.$isi['basedir'] ) }}"></use>
        </svg>
        <h6 class="f-w-600">{{ $isi['name'] }}</h6>{!! $pnh !!}</a>

    @if(!empty($isi['children']) && (count($isi['children']) > 0))
	    <ul class="sidebar-submenu" >
            @each('layouts.kosong', $isi['children'], 'isi')
	    </ul>
    @endif
</li>

