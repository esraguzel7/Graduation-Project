<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page ?? 'Not Found' }}</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Simplebar -->
    <link type="text/css" href="{!! asset('assets/vendor/simplebar.min.css') !!}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{!! asset('assets/css/app.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/app.rtl.css') !!}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{!! asset('assets/css/vendor-material-icons.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-material-icons.rtl.css') !!}" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="{!! asset('assets/css/vendor-fontawesome-free.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-fontawesome-free.rtl.css') !!}" rel="stylesheet">

    <!-- Flatpickr -->
    <link type="text/css" href="{!! asset('assets/css/vendor-flatpickr.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-flatpickr.rtl.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-flatpickr-airbnb.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-flatpickr-airbnb.rtl.css') !!}" rel="stylesheet">

    <!-- Toastr -->
    <link type="text/css" href="{!! asset('assets/vendor/toastr.min.css') !!}" rel="stylesheet">

    <!-- Vector Maps -->
    <link type="text/css" href="{!! asset('assets/vendor/jqvmap/jqvmap.min.css') !!}" rel="stylesheet">

    <!-- Dropzone -->
    <link type="text/css" href="{!! asset('assets/css/vendor-dropzone.css') !!}" rel="stylesheet">
    <link type="text/css" href="{!! asset('assets/css/vendor-dropzone.rtl.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link type="text/css" href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet">
</head>

<body class="layout-default">
    <div class="preloader"></div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark  pr-0" id="navbar" data-primary>
                    <div class="container-fluid p-0">

                        <!-- Navbar toggler -->

                        <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                            data-toggle="sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <!-- Navbar Brand -->
                        <a href="{!! url('/') !!}" class="navbar-brand ">
                            <img class="navbar-brand-icon" src="{!! asset('assets/images/logo-white.svg') !!}"
                                height="40" alt="Turnique">
                        </a>

                        <form class="search-form d-none d-sm-flex flex" action="index.html">
                            <button class="btn" type="submit" role="button"><i
                                    class="material-icons">search</i></button>
                            <input type="text" class="form-control" placeholder="Search">
                        </form>

                        <ul class="nav navbar-nav ml-auto d-none d-md-flex">
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="material-icons">help_outline</i> Get Help
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#notifications_menu" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                    data-caret="false">
                                    <i class="material-icons nav-icon navbar-notifications-indicator">notifications</i>
                                </a>
                                <div id="notifications_menu"
                                    class="dropdown-menu dropdown-menu-right navbar-notifications-menu">
                                    <div class="dropdown-item d-flex align-items-center py-2">
                                        <span class="flex navbar-notifications-menu__title m-0">Notifications</span>
                                        <a href="javascript:void(0)" class="text-muted"><small>Clear all</small></a>
                                    </div>
                                    <div class="navbar-notifications-menu__content" data-simplebar>
                                        <div class="py-2">

                                            <div class="dropdown-item d-flex">
                                                <div class="flex">
                                                    Test Notification<br>
                                                    <small class="text-muted">1 minute ago</small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <a href="javascript:void(0);"
                                        class="dropdown-item text-center navbar-notifications-menu__footer">View All</a>
                                </div>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                            <li class="nav-item dropdown">
                                <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                    data-caret="false">
                                    <div class="avatar avatar-sm" data-toggle="tooltip" data-placement="top"
                                        title="{{ auth()->user()->get_fullname() }}">
                                        <span
                                            class="avatar-title rounded-circle">{{ auth()->user()->get_shortname() }}</span>
                                    </div>
                                    <span class="ml-1 d-flex-inline">
                                        <span class="text-light">{{ auth()->user()->get_fullname() }}</span>
                                    </span>
                                </a>
                                <div id="account_menu" class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item-text dropdown-item-text--lh">
                                        <div><strong>{{ auth()->user()->get_fullname() }}</strong></div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item active" href="{!! route('home.show') !!}">Dashboard</a>
                                    <a class="dropdown-item" href="#">My profile</a>
                                    <a class="dropdown-item" href="#">Edit account</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{!! route('logout') !!}">Logout</a>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <div class="mdk-header-layout__content">


            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                <div class="mdk-drawer-layout__content page">

                    <div class="container-fluid page__heading-container">
                        <div class="page__heading d-flex align-items-center">
                            <div class="flex">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                                        @if (isset($breadcrumb))
                                            @foreach ($breadcrumb as $key => $value)
                                                @if (array_key_last($breadcrumb) == $key)
                                                    <li class="breadcrumb-item active" aria-current="page">
                                                        {{ $value }}
                                                    </li>
                                                @else
                                                    <li class="breadcrumb-item" aria-current="page">
                                                        <a href="{{ $value }}">
                                                            {{ $key }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ol>
                                </nav>
                                <h1 class="m-0">{{ $page ?? 'Not Defined' }}</h1>
                            </div>
                            @if (isset($breadcrumb_button))
                                @foreach ($breadcrumb_button as $key => $value)
                                    <a href="{{ $value }}" class="btn btn-success ml-3">{{ $key }} <i
                                            class="material-icons">add</i></a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="container-fluid page__container">
                        @yield('content')
                    </div>

                </div>

                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
                            <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account">
                                <a href="#" class="flex d-flex align-items-center text-underline-0 text-body">
                                    <div class="avatar avatar-sm mr-3" data-toggle="tooltip" data-placement="top"
                                        title="Adrian Demian">
                                        <span
                                            class="avatar-title rounded-circle">{{ auth()->user()->get_shortname() }}</span>
                                    </div>
                                    <span class="flex d-flex flex-column">
                                        <strong>{{ auth()->user()->get_fullname() }}</strong>
                                        <small
                                            class="text-muted text-uppercase">{{ auth()->user()->get_fullname() }}</small>
                                    </span>
                                </a>
                                <div class="dropdown ml-auto">
                                    <a href="#" data-toggle="dropdown" data-caret="false" class="text-muted"><i
                                            class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item-text dropdown-item-text--lh">
                                            <div><strong>{{ auth()->user()->get_fullname() }}</strong></div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item active" href="{!! route('home.show') !!}">Dashboard</a>
                                        <a class="dropdown-item" href="#">My profile</a>
                                        <a class="dropdown-item" href="#">Edit account</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{!! route('logout') !!}">Logout</a>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-heading sidebar-m-t">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{!! url('/') !!}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">home</i>
                                        <span class="sidebar-menu-text">Home</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{!! route('home.show') !!}">
                                        <i
                                            class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#apps_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-id-card"></i>
                                        <span class="sidebar-menu-text">My Cards</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="apps_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="#">
                                                <span class="sidebar-menu-text">List My Cards</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{!! route('card.ordernewcard.show') !!}">
                                                <span class="sidebar-menu-text">Order New Card</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="#">
                                                <span class="sidebar-menu-text">Card Orders</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="#">
                                                <span class="sidebar-menu-text text-danger"><i
                                                        class="fa fa-exclamation mr-2"></i> Report Lost Card</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#wallets_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-wallet"></i>
                                        <span class="sidebar-menu-text">My Wallets</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="wallets_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{!! route('wallet.mywallets.show') !!}">
                                                <span class="sidebar-menu-text">List My Wallets</span>
                                            </a>
                                        </li>
                                        @foreach (Auth::user()->wallets as $wallet)
                                            <li class="sidebar-menu-item">
                                                <a class="sidebar-menu-button"
                                                    href="{!! route('wallet.show', $wallet->id) !!}">
                                                    <span class="sidebar-menu-text"><i class="fa fa-arrow-right mr-2"></i>
                                                        {{ $wallet->name }}</span>
                                                    <span class="badge badge-secondary ml-auto">#{{ $wallet->id }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{!! route('wallet.generaltransactions.show') !!}">
                                                <span class="sidebar-menu-text">Wallet Transactions</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="sidebar-heading">Events</div>
                            <div class="sidebar-block p-0">
                                <ul class="sidebar-menu" id="components_menu">
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="{!! route('events.list') !!}">
                                            <i
                                                class="sidebar-menu-icon sidebar-menu-icon--left material-icons fa fa-calendar"></i>
                                            <span class="sidebar-menu-text">Events</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="{!! route('events.participations') !!}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-calendar-day"></i>
                                            <span class="sidebar-menu-text">My Participations</span>
                                        </a>
                                    </li>

                                    <li class="sidebar-menu-item">
                                        <a class="sidebar-menu-button" href="{!! route('events.history') !!}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left fa fa-history"></i>
                                            <span class="sidebar-menu-text">My Event History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- // END header-layout__content -->

    </div>

    <!-- jQuery -->
    <script src="{!! asset('assets/vendor/jquery.min.js') !!}"></script>

    <!-- Bootstrap -->
    <script src="{!! asset('assets/vendor/popper.min.js') !!}"></script>
    <script src="{!! asset('assets/vendor/bootstrap.min.js') !!}"></script>

    <!-- Simplebar -->
    <script src="{!! asset('assets/vendor/simplebar.min.js') !!}"></script>

    <!-- DOM Factory -->
    <script src="{!! asset('assets/vendor/dom-factory.js') !!}"></script>

    <!-- MDK -->
    <script src="{!! asset('assets/vendor/material-design-kit.js') !!}"></script>

    <!-- App -->
    <script src="{!! asset('assets/js/toggle-check-all.js') !!}"></script>
    <script src="{!! asset('assets/js/check-selected-row.js') !!}"></script>
    <script src="{!! asset('assets/js/dropdown.js') !!}"></script>
    <script src="{!! asset('assets/js/sidebar-mini.js') !!}"></script>
    <script src="{!! asset('assets/js/app.js') !!}"></script>

    <!-- Flatpickr -->
    <script src="{!! asset('assets/vendor/flatpickr/flatpickr.min.js') !!}"></script>
    <script src="{!! asset('assets/js/flatpickr.js') !!}"></script>

    <!-- Global Settings -->
    <script src="{!! asset('assets/js/settings.js') !!}"></script>

    <!-- Chart.js -->
    <script src="{!! asset('assets/vendor/Chart.min.js') !!}"></script>

    <!-- App Charts JS -->
    <script src="{!! asset('assets/js/charts.js') !!}"></script>

    <!-- jQuery Mask Plugin -->
    <script src="{!! asset('assets/vendor/jquery.mask.min.js') !!}"></script>

    <!-- Chart Samples -->
    <script src="{!! asset('assets/js/page.dashboard.js') !!}"></script>

    <!-- Vector Maps -->
    <script src="{!! asset('assets/vendor/jqvmap/jquery.vmap.min.js') !!}"></script>
    <script src="{!! asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') !!}"></script>
    <script src="{!! asset('assets/js/vector-maps.js') !!}"></script>

    <!-- Dropzone -->
    <script src="{!! asset('assets/vendor/dropzone.min.js') !!}"></script>
    <script src="{!! asset('assets/js/dropzone.js') !!}"></script>

    <script src="{!! asset('assets/vendor/toastr.min.js') !!}"></script>
    <script src="{!! asset('assets/js/ajax-form.js') !!}"></script>

</body>

</html>