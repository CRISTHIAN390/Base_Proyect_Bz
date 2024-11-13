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
    <title>Sistema de control de fletes</title>

    <link rel="shortcut icon" type="/image/x-icon" href="assets/img/avator1.png">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="/assets/css/animate.css">

    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">
    <!--Para el selec-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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
                        <span class="user-img"><img src="/assets/img/profiles/avator1.png" alt="">
                            <span class="status online"></span></span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img src="/assets/img/profiles/avator1.png" alt="">
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ optional(Auth::user())->name ?? 'Invitado' }}</h6>
                                    <h5>{{ optional(Auth::user()->rol)->name ?? 'Invitado' }}</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}"> <i class="me-2"
                                    data-feather="user"></i>
                                My Profile</a>

                            <!--    <a class="dropdown-item" href="#"><i class="me-2"
                                    data-feather="settings"></i>Settings</a> -->
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
                    <!-- <a class="dropdown-item" href="generalsettings.html">Settings</a>-->
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="active">
                            <a href="{{ route('dashboard') }}">
                                <img src="/assets/img/icons/dashboard.svg" alt="img">
                                <span>Inicio</span>
                            </a>
                        </li>

                        @if (Auth::check() && Auth::user()->idrol === 1)
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <img src="/assets/img/icons/search.svg " alt="img">
                                    <span> Usuarios</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('listauser') }}">Lista de usuarios</a></li>
                                </ul>
                            </li>
                        @endif


                        <li class="submenu">
                            <a href="javascript:vVioid(0);"><img src="/assets/img/icons/users1.svg"
                                    alt="img"><span> Colaboradores</span> <span class="menu-arrow"></span></a>

                            <ul>
                                <li><a href="{{ route('empleado.create') }}">Registro</a></li>
                                <li><a href="{{ route('empleado.index') }}">Lista de Transportistas</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <img src="/assets/img/icons/time.svg" alt="img">
                                <span>Vehiculos</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{ route('vehiculo.index') }}">Lista de Vehiculos</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="/assets/img/icons/purchase1.svg"
                                    alt="img"><span>Ver Fletes y Viáticos</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>

                                <li><a href="{{ route('flete.index') }}">Lista de Fletes</a></li>
                                <li><a href="{{ route('viatico.index') }}">Lista de Viaticos</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="/assets/img/icons/time.svg"
                                    alt="img"><span>Flujo Operativo</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('detalleFV.create') }}">Nuevo Registro </a></li>
                                <li><a href="{{ route('detalleFV.index') }}">Ver Gastos/Pagos</a></li>
                                <li><a href="{{ route('detallecar.index') }}">Detalle Vehicular</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="/assets/img/icons/expense1.svg"
                                    alt="img"><span>Reportes</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('reporte.index') }}">Registros Operativos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                @yield('contenido')
            </div>
            <style>
                .chat-float {
                    position: fixed;
                    bottom: 20px; /* Ajusta la posición del botón de chat */
                    right: 20px;
                    background-color: #a1a1a1; /* Color azul para el chat */
                    color: white;
                    border-radius: 50%;
                    padding: 10px;
                    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                    z-index: 1000; /* Asegúrate de que esté por encima de otros elementos */
                  /* Ajusta el tamaño según lo desees */
                    transition: background-color 0.3s ease; /* Efecto de transición */
                }
            
                .chat-float:hover {
                    background-color: #272727; /* Color más oscuro al pasar el mouse */
                }
            
                .chat-float img {
                    width: 50px; /* Ajusta el tamaño de la imagen si es necesario */
                    height: 50px; /* Ajusta el tamaño de la imagen si es necesario */
                }
            </style>
            
            
            <a href="{{ route('Consultabot') }}" class="chat-float" target="_blank">
                <img src="/assets/img/icons/bot.png" alt="Chat" />
            </a>
 
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
