<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin|Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->


    <!-- Plugin css -->

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <style>

        .vertical-menu {
            min-width: 100px;
            max-width: var(--bs-sidebar-width);
            width: 100px;
            z-index: 1001;
            background: var(--bs-sidebar-bg);
            bottom: 0;
            margin-top: 0;
            position: fixed;
            top: var(--bs-header-height);
            -webkit-box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            margin-bottom: 55px;

        }


        .arow {


            position: fixed;
            top: 100px;
            left: 10px;

            z-index: 100;
            padding: 10px;

        }

        .toggle-sidebar {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }


        .collapsed .widthSideBare {
            width: 220px !important;
            background-color: #ffffff;
        }

        .vertical-menu.collapsed .arow .toggle-sidebar {
            left: auto;
            right: 0;
        }

        .display {
            display: none;
        }
    </style>
</head>



<body data-layout="detached" data-topbar="colored">

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- Header start -->
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">

                            <div class="dropdown d-inline-block d-lg-none ms-2">

                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>



                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span
                                        class="badge rounded-pill bg-danger ">{{ Auth::user()->unreadNotifications->count() }}</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-notifications-dropdown">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0"> Notifications </h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('markAsRead') }}" class="small green"><i
                                                        class="fas fa-eye"></i>
                                                    Mark All As Read</a>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('Clear') }}" class="small danger"><i
                                                        class="fas fa-trash-alt"></i>
                                                    Clear</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach (Auth::user()->Notifications as $Notification)
                                        <div data-simplebar style="max-height: 230px;">
                                            <a href="{{ route('AllRequest') }}" class="text-reset notification-item">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar-xs me-3">
                                                        <span
                                                            class="avatar-title bg-primary rounded-circle font-size-16">
                                                            <i class="mdi mdi-account-question"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        @if ($Notification->data['type'] === 'emploi')
                                                            <h6 class="mt-0 mb-1">
                                                                {{ $Notification->data['FormateurRequest'] }}</h6>
                                                            <p>a deamnder une nouvelle emplois du temps</p>
                                                            <div class="font-size-12 text-muted">
                                                                <p class="mb-1">
                                                                    {{ $Notification->data['RequestCommentaire'] }}</p>
                                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                                    {{ $Notification->created_at->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        @elseif ($Notification->data['type'] === 'seance')
                                                            <h6 class="mt-0 mb-1">
                                                                {{ $Notification->data['FormateurRequest'] }} </h6>
                                                            <p>a deamnder une nouvelle seance</p>
                                                            <div class="font-size-12 text-muted">
                                                                <p class="mb-1">
                                                                    {{ $Notification->data['RequestCommentaire'] }}</p>
                                                                <p class="mb-1">
                                                                    {{ $Notification->data['statusSission'] }}</p>
                                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                                    {{ $Notification->created_at->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach

                                    <div class="p-2 border-top d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 " href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div style="z-index:999999999999999999999" class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">

                                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->user_name }}</span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="{{ route('showProfileAdmin') }}"><i
                                            class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>

                                    <a class="dropdown-item d-block" href="{{ route('AllSetting') }}"><span
                                            class="badge bg-success float-end">11</span><i
                                            class="bx bx-wrench font-size-16 align-middle me-1"></i> Settings</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                        Logout</a>
                                </div>
                            </div>



                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box" style="color: white">
                                <a class="logo logo-dark">
                                    <span class="logo-sm" style="font-size: 20px;font-weight:bold;color:white">
                                        @php
                                            $ISTA = Auth::user()->establishment_id;
                                            $establishmentName = \App\Models\establishment::find($ISTA)
                                                ->name_establishment;
                                        @endphp

                                        {{ $establishmentName }} </span>
                                    <span class="logo-lg" style="font-size: 17px;font-weight:bold">
                                        @php
                                            $ISTA = Auth::user()->establishment_id;
                                            $establishmentName = \App\Models\establishment::find($ISTA)
                                                ->name_establishment;
                                        @endphp

                                        {{ $establishmentName }} </span>
                                </a>

                                <a class="logo logo-light">
                                    <span class="w3-cursive" style="font-size: 20px;font-weight:bold;color:white">
                                        @php
                                            $ISTA = Auth::user()->establishment_id;
                                            $establishmentName = \App\Models\establishment::find($ISTA)
                                                ->name_establishment;
                                        @endphp

                                        {{ $establishmentName }}
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button class="btn btn-sm px-3 font-size-16 header-item toggle-sidebar "
                                    style="margin-left: -125px;margin-top: 20px;">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>
                            </div>


                            <button type="button"
                                class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->

                            <!-- Mega menu -->

                        </div>
                    </div>
                </div>
            </header>
            <!-- ENd header  -->
            <!-- ========== Left Sidebar Start ========== -->
            <div id="sideBareMenu" class="vertical-menu  display">
                {{-- <div class="arow">
                        <button class="btn btn-primary toggle-sidebar"><i class="mdi mdi-chevron-left"></i></button>
                    </div> --}}
                <div class="widthSideBare ">
                    <div class="user-wid text-center py-4">
                        <div class="user-img">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/user.jpg') }}" alt="">
                        </div>

                        <div class="mt-3">

                            <a href="#"
                                class="text-reset fw-medium font-size-16">{{ Auth::user()->user_name }}</a>
                            <p class="text-muted mt-1 mb-0 font-size-13">Admin</p>

                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="{{ route('dashboardAdmin') }}" class=" waves-effect">
                                    <i style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-home-lightbulb-outline"></i>

                                </a>
                            </li>





                            <li><a href="{{ route('CreateEmploi') }}" class=" waves-effect"> <span
                                        data-toggle="tooltip" data-placement="right" title="tout les groupes"
                                        class="mdi mdi-lightbulb-group-outline"
                                        style="font-weight: 400 ; font-size:25PX"></span></a></li>
                            <li><a href="{{ route('emploiForFormateurs') }}" class=" waves-effect"> <span
                                        data-toggle="tooltip" data-placement="right" title="tout les Formateurs"
                                        style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-account-supervisor-outline"></span></a></li>
                            <li><a href="{{ route('ChaqueFormateur') }}" class=" waves-effect"> <span
                                        data-toggle="tooltip" data-placement="right" title="chaque formateur"
                                        style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-account-tie-outline"></span></a></li>
                            <li><a href="{{ route('emploiForGroup') }}" class=" waves-effect"> <span
                                        data-toggle="tooltip" data-placement="right" title="chaque group"
                                        style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-lightbulb-multiple-outline"></span></a></li>


                            <li>
                                <a href="{{ route('toutlesEmploi') }}" class=" waves-effect">
                                    <span style="font-weight: 400 ; font-size:25PX" class="mdi mdi-history"
                                        data-toggle="tooltip" data-placement="right" title="tous les emplois"></span>

                                </a>
                            </li>


                            <li>
                                <a href="{{ route('AllRequest') }}" class=" waves-effect">
                                    <span style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-message-text-clock-outline" data-toggle="tooltip"
                                        data-placement="right" title="tous les demandes"></span>

                                </a>
                            </li>

                            <li>
                                <a href="{{ route('AllSetting') }}" class=" waves-effect">
                                    <span style="font-weight: 400 ; font-size:25PX"
                                        class="mdi mdi-settings-transfer-outline" data-toggle="tooltip"
                                        data-placement="right" title="les paramteres "></span>

                                </a>
                            </li>



                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                    <i style="font-weight: 400 ; font-size:25PX"
                                        class="bx bx-power-off font-size-16 align-middle me-1 text-danger"
                                        data-toggle="tooltip" data-placement="right" title="Déconnexion"></i>

                                </a>
                            </li>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- ===========Left Sidebar End=========== -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <div style="margin-top: 6.4rem; border-radius: 10px ;" class="row">
                        {{ $slot }}
                    </div>
                    <!-- end row -->

                </div>
                <!-- End Page-content -->



            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->


    <div class="rightbar-overlay"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- plugin js -->

    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Calendar init -->

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let sidebarMenu = document.querySelector('#sideBareMenu');

            function hideHidentext() {
                if (sidebarMenu.classList.contains('display')) {
                    sidebarMenu.classList.remove('display');

                } else {
                    sidebarMenu.classList.add('display');

                }
            }

            hideHidentext();

            document.querySelector('.toggle-sidebar').addEventListener('click', function() {
                sidebarMenu.classList.toggle('collapsed');
                hideHidentext();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>




</body>

</html>
