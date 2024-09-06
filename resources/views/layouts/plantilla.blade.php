<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="/image/x-icon" href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="/assets/css/animate.css">

    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="/assets/img/logo.png" alt="">
                </a>
                <a href="{{ route('dashboard') }}" class="logo-small">
                    <img src="/assets/img/logo-small.png" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <span><img src="/assets/img/icons/closes.svg" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv"><img src="/assets/img/icons/search.svg" alt="img"></a>
                        </form>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img"><img src="/assets/img/profiles/avator1.jpg" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="/assets/img/profiles/avator1.jpg" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <h5>Admin</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="#"> <i class="me-2" data-feather="user"></i>
                                My Profile</a>

                            <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                                    data-feather="settings"></i>Settings</a>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0"><img src="/assets/img/icons/log-out.svg" class="me-2"
                                    alt="img">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button style="width: 100%" type="submit">Salir</button>
                                </form>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="generalsettings.html">Settings</a>
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="{{ route('dashboard') }}"><img src="/assets/img/icons/dashboard.svg"
                                    alt="img"><span>
                                    Inicio</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:vVioid(0);"><img src="/assets/img/icons/users1.svg"
                                    alt="img"><span> Trabajadores</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('empleado.index') }}">Choferes</a></li>
                                <li><a href="#">Reporte</a></li>

                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="/assets/img/icons/purchase1.svg"
                                    alt="img"><span>Gastos</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('flete.index') }}">Fletes</a></li>
                                <li><a href="{{ route('viatico.index') }}">Viaticos</a></li>
                                <li><a href="{{ route('detalleFV.index') }}">Gastos/Ingresos</a></li>
                                <li><a href="importpurchase.html">Reportes</a></li>
                            </ul>
                        </li><!--
                         <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/expense1.svg"
                                    alt="img"><span> Expense</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="expenselist.html">Expense List</a></li>
                                <li><a href="createexpense.html">Add Expense</a></li>
                                <li><a href="expensecategory.html">Expense Category</a></li>
                            </ul>
                        </li>


                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="assets/img/icons/time.svg" alt="img"><span>
                                    Report</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="purchaseorderreport.html">Purchase order report</a></li>
                                <li><a href="inventoryreport.html">Inventory Report</a></li>
                                <li><a href="salesreport.html">Sales Report</a></li>
                                <li><a href="invoicereport.html">Invoice Report</a></li>
                                <li><a href="purchasereport.html">Purchase Report</a></li>
                                <li><a href="supplierreport.html">Supplier Report</a></li>
                                <li><a href="customerreport.html">Customer Report</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                @yield('contenido')
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.0.min.js"></script>

    <script src="/assets/js/feather.min.js"></script>

    <script src="/assets/js/jquery.slimscroll.min.js"></script>

    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="/assets/plugins/apexchart/chart-data.js"></script>

    <script src="/assets/js/script.js"></script>
</body>

</html>
