<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('assets/images/fav.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/fav.png') }}" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet">
    <!-- Flag icon css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bulk-style.css') }}">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}">
    <!--fontawesome-->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-min.css') }}">
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    {{-- @include('sweetalert::alert') --}}
    @yield('style')
    <style>
        .sidebar-submenu {
            display: none;
        }

        .sidebar-submenu.show {
            display: block;
        }

        .sidebar-list.open>a {
            background: #f0f0f0;
            /* Biar ada efek aktif */
        }
    </style>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page header start -->
        <header class="page-header row">
            <div class="logo-wrapper d-flex align-items-center col-auto"><a href="{{ route('dashboard')}}"><img
                        class="light-logo img-fluid" src="{{ asset('logo_putih.png') }}" alt="logo"
                        width="170px"><img class="dark-logo img-fluid" src="{{ asset('logo_ks.png') }}"
                        alt="logo"></a><a class="close-btn toggle-sidebar" href="javascript:void(0)">
                            <i class="iconly-Category icli"></i></a></div>
            <div class="page-main-header col">
                <div class="header-left">

                </div>
                <div class="nav-right">
                    <ul class="header-right">

                        <li class="profile-nav custom-dropdown">
                            <div class="user-wrap">
                                {{-- <div class="avatar-intial img-60 bg-light-primary"><span class="fs-1">A</span></div> --}}
                                <div class="user-img">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=random" class="rounded-circle" width="32" alt="User Avatar" />
                                </div>
                                <div class="user-content">
                                    <h6>{{ auth()->user()->name ?? 'Guest' }}</h6>
                                    <p class="mb-0">{{ auth()->user()->email ?? '-' }}<i class="fa-solid fa-chevron-down"></i></p>
                                </div>
                            </div>
                            <div class="custom-menu overflow-hidden">
                                <ul class="profile-body">
                                    <li class="d-flex">
                                        <i class="iconly-Profile icli"></i><a class="ms-2" href="javascript:;">Account</a>
                                    </li>
                                    <li class="d-flex">
                                        <i class="iconly-Login icli"></i><a class="ms-2" href="javascript:;" id="logoutButton">Log Out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Page header end-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page sidebar start-->
            @include('layouts.sidemenu')
            <!-- Page sidebar end-->
            @yield('content')

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright">
                            <p class="mb-0">Copyright {{date('Y')}} © PT Krakatau Sarana Properti.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- jquery-->
    <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
    <!-- bootstrap js-->
    <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer=""></script>
    <script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js') }}" defer=""></script>
    <!--fontawesome-->
    <script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js') }}"></script>
    <!-- sidebar -->
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <!-- scrollbar-->
    <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
    <!-- custom script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.getElementById('logoutButton').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Logout?',
                text: "Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                buttonsStyling: true,
                customClass: {
                    confirmButton: 'mx-2 px-4 py-2',
                    cancelButton: 'mx-2 px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @yield('scripts')
</body>

</html>
