<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> Formateur | Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    {{-- driver JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />


    <!-- Plugin css -->

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/RequestEmploi.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .row {
            margin-left: 0px;
        }

        .hide-menu {
            display: none;
        }

        .main-content.expanded {
            margin-left: 0;
        }
    </style>

</head>

<body data-layout="detached" data-topbar="colored">



    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- Header start -->
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">

                            <div class="dropdown d-inline-block d-lg-none ms-2">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
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
                                                <a href="#!" class="small"> View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach (Auth::user()->unreadNotifications as $Notification)
                                        <div data-simplebar style="max-height: 230px;">
                                            <a href="" class="text-reset notification-item">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar-xs me-3">
                                                        <span
                                                            class="avatar-title bg-primary rounded-circle font-size-16">
                                                            <i class="mdi mdi-account-question"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h6 class="mt-0 mb-1">
                                                            {{ $Notification->data['FormateurRequest'] }}</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">
                                                                {{ $Notification->data['RequestCommentaire'] }}</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                                {{ $Notification->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
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


                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="assets/images/users/user.jpg"
                                        alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->user_name }}</span>

                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i
                                            class="bx bx-user font-size-16 align-middle me-1"></i>
                                        Profile</a>

                                    <a class="dropdown-item d-block" href="#"><span
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
                            <div class="navbar-brand-box">
                                <a class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/images/logo-dark.png" alt="" height="17">
                                    </span>
                                </a>

                                <a class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="assets/images/logo-sm.png" alt="" height="20">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/images/logo-light.png" alt="" height="19">
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button class="btn btn-sm px-3 font-size-16 header-item " id="vertical-menu-toggle">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>
                            </div>

                            <button type="button"
                                class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->
                            {{-- <form class="app-search d-none d-lg-inline-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="bx bx-search-alt"></span>
                    </div>
                </form> --}}
                            <!-- Mega menu -->

                        </div>

                    </div>
                </div>
            </header>
            <!-- ENd header  -->
            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu" style="height: 100%;">
                <div class="h-100">
                    <div class="user-wid text-center py-4">
                        <div class="user-img">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/user.jpg"
                                alt="Header Avatar">
                        </div>


                        <div class="mt-3">
                            <a href="#"
                                class="text-reset fw-medium font-size-16">{{ Auth::user()->user_name }}</a>
                            <p class="text-muted mt-1 mb-0 font-size-13">
                                Domaine du formation
                            </p>
                        </div>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->

                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li class="Acceuil">
                                <a class="waves-effect" href="{{ url('dashboardFormateur') }}">
                                    <i class="fas fa-home"></i>
                                    <span>Acceuil</span>
                                </a>
                            </li>

                            <li class="RequestCalendar">
                                <a href="{{ url('DemanderEmploi') }}" class="waves-effect">
                                    <i class="mdi mdi-frequently-asked-questions"></i>
                                    <span>RequestCalendar</span>
                                </a>
                            </li>

                            <li class="Calendar">
                                <a href="{{ url('calendarFormateur') }}" class="waves-effect">
                                    <i class="mdi mdi-calendar-text"></i>
                                    <span>Calendar</span>
                                </a>
                            </li>

                            <li class="Groupes">
                                <a href="javascript:void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-account-group"></i>
                                    <span>Groupes</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('FormateurGroupeList') }}">List des Groupes</a></li>
                                </ul>
                            </li>

                            <li class="Modules">
                                <a href="javascript:void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-inbox-full"></i>
                                    <span>Modules</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('FormateurModuleList') }}">List des Modules</a></li>
                                </ul>
                            </li>

                            <li class="Settings">
                                <a class="dropdown-item d-block" href="{{ url('settings') }}">
                                    <i class="mdi mdi-settings-outline"></i> Settings
                                </a>
                            </li>
                            <li class="Documentation">
                                <a class="dropdown-item d-block" onclick="launchDriver()">
                                    <i class="fas fa-book"></i>Lunch Documentation
                                </a>
                            </li>



                            <li class="Logout">
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- ===========Left Sidebar End=========== -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <div style="margin-top: 6.4rem;margin-left:2rem" class="row">
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


    <script src="{{ asset('/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- plugin js -->
    <script src="{{ asset('/assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    {{-- driver js --}}
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>


    <script>
        $(document).ready(function() {
            $('#vertical-menu-toggle').click(function() {
                $('.vertical-menu').toggleClass('hide-menu');
            });
        });


        function launchDriver() {
            const driver = window.driver.js.driver;
            const username = "{{ Auth::user()->user_name }}"; // Obtenir le nom d'utilisateur dynamiquement
            const driverObj = driver({
                showProgress: true,
                showButtons: ['next', 'previous'],
                steps: [
                    // Première étape
                    {
                        element: '#some-element',
                        popover: {
                            title: username,
                            description: 'Suivez les instructions pour comprendre comment vous pouvez utiliser ce site.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Deuxième étape
                    {
                        element: '.vertical-menu',
                        popover: {
                            title: 'Menu Principal',
                            description: 'Voici le menu principal du tableau de bord.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Troisième étape
                    {
                        element: '.navbar-header',
                        popover: {
                            title: 'En-tête',
                            description: 'Ceci est l\'en-tête du tableau de bord.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Quatrième étape
                    {
                        element: '.logo-light',
                        popover: {
                            title: 'Logo',
                            description: 'Ceci est notre logo.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Cinquième étape
                    {
                        element: '#vertical-menu-toggle',
                        popover: {
                            title: 'Basculer le Menu Vertical',
                            description: 'Cliquez ici pour basculer la visibilité du menu vertical.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Sixième étape
                    {
                        element: '.mdi-fullscreen',
                        popover: {
                            title: 'Bouton Plein Écran',
                            description: 'Cliquez ici pour basculer en mode plein écran.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Septième étape
                    {
                        element: '.mdi-bell-outline',
                        popover: {
                            title: 'Menu des Notifications',
                            description: 'Cliquez ici pour afficher les notifications.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Huitième étape
                    {
                        element: '.header-profile-user',
                        popover: {
                            title: 'Profil Utilisateur',
                            description: 'Cliquez ici pour afficher votre profil.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Neuvième étape
                    {
                        element: '#page-header-user-dropdown span',
                        popover: {
                            title: 'Menu de Profil',
                            description: 'Cliquez ici pour accéder aux options de profil.',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    // Dixième étape
                    {
                        element: '.user-wid',
                        popover: {
                            title: 'Widget Utilisateur',
                            description: 'Ceci est le widget utilisateur.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Onzième étape
                    {
                        element: '.Acceuil',
                        popover: {
                            title: 'Page d\'Accueil',
                            description: 'Ceci est la page d\'accueil.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Douzième étape
                    {
                        element: '.RequestCalendar ',
                        popover: {
                            title: 'Calendrier des Demandes',
                            description: 'Ceci est le calendrier des demandes.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Treizième étape
                    {
                        element: '.Calendar ',
                        popover: {
                            title: 'Calendrier',
                            description: 'Ceci est le calendrier.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Quatorzième étape
                    {
                        element: '.Groupes ',
                        popover: {
                            title: 'Groupes',
                            description: 'Ceci sont les groupes.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Quinzième étape
                    {
                        element: '.Modules ',
                        popover: {
                            title: 'Modules',
                            description: 'Ceci sont les modules.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Seizième étape
                    {
                        element: '.Settings ',
                        popover: {
                            title: 'Paramètres',
                            description: 'Ceci sont les paramètres.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Dix-septième étape
                    {
                        element: '.Documentation ',
                        popover: {
                            title: 'Documentation',
                            description: 'Cliquez ici pour accéder à la documentation.',
                            side: "left",
                            align: 'start'
                        }
                    },
                    // Dix-huitième étape
                    {
                        element: '.Logout',
                        popover: {
                            title: 'Déconnexion',
                            description: 'Cliquez ici pour vous déconnecter.',
                            side: "left",
                            align: 'start'
                        }
                    }
                ]
            });

            driverObj.drive();
        }
    </script>

</body>

</html>
