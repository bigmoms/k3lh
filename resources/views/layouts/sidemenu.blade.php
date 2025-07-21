<aside class="page-sidebar">
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-main-title">
                <div>
                  <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
            </li>

            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i>
                <a class="sidebar-link" href="javascript:void(0)">
                    <svg class="stroke-icon">
                        <use href="{{asset('assets/svg/iconly-sprite.svg#Home-dashboard') }}"></use>
                    </svg>
                    <h6>Dashboards</h6>
                </a>
            </li>
            @each('layouts.kepala', $menus, 'isi', 'layouts.kosong')
        </ul>
    </div>
</aside>
