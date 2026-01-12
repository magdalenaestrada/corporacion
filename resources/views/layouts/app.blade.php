<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicons/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/structure.css') }}" rel="stylesheet">
    @stack('css')

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #070809;
        }

        .submenu {
            display: none;
            margin-left: 20px;
            padding-left: 10px;
            border-left: 2px solid #8d1b34;
            transition: all 0.3s ease;
        }

        .submenu.show {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-5px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .submenu a { padding-left: 20px; }
        .submenu li { padding: 5px 0; }

        #default-sidebar {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
            color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #334155;
        }

        #default-sidebar a {
            color: #cbd5e1;
            transition: all 0.3s ease;
        }

        #default-sidebar a:hover {
            background-color: #334155;
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar-item, .submenu li {
            border-radius: 10px;
            margin: 6px 0;
            padding: 8px;
        }

        /* Sidebar oculto */
        #default-sidebar.collapsed {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        /* Ajustar el contenido cuando el sidebar está oculto */
        #app.sidebar-collapsed main {
            margin-left: 0 !important;
            width: 100% !important;
        }

        #toggleSidebarBtn { border-radius: 12px; }
    </style>
</head>

<body>
<button id="toggleSidebarBtn" class="btn btn-dark btn-sm" style="position: fixed; top: 10px; left: 10px; z-index: 1000;">
    ☰
</button>

<div id="app" class="flex min-h-screen">
    <aside id="default-sidebar" class="sidebar w-64 h-screen bg-gray-50 dark:bg-gray-800 transition-transform">
        <div class="sidebar-in h-full px-3 py-4 overflow-y-auto">
            <ul class="text-center space-y-2">
                @auth
                    <li class="title-sidebar">
                        <a href="{{ route('home') }}" class="flex items-center p-1 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <span><img src="{{ asset('images/innovalogo.png') }}" alt="" style="width: 80px"></span>
                            <span class="ms-0">Innova Corporativo</span>
                        </a>
                    </li>

                    <li>
                        <li class="sidebar-item">
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" id="pesos-toggle">
                                <div class="sidebar-box">
                                    <span class="ms-3 whitespace-nowrap">
                                        <button class="link-sidebar-btn">PESOS</button>
                                    </span>
                                </div>
                            </a>

                            <ul id="pesos-menu" class="submenu">
                                <li>
                                    <a href="{{route('pesos.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> BALANZA</button></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('humedad.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> HUMEDAD</button></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('lotizacion')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn">LOTIZACION</button></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('ingresos.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn">INGRESOS</button></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('blendings.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> BLENDINGS</button></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('despachos.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                        <div class="sidebar-box">
                                            <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> DESPACHOS</button></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </li>

                    {{-- ✅ ESTADOS (OCULTO / COMENTADO) --}}
                    {{--
                    <li class="sidebar-item">
                        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" id="estados-toggle">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap">
                                    <button class="link-sidebar-btn">ESTADOS</button>
                                </span>
                            </div>
                        </a>

                        <ul id="estados-menu" class="submenu">
                            <li>
                                <a href="{{ route('estados_mineral.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap">
                                            <button class="link-sidebar-btn">ESTADOS MINERAL</button>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}

                    <li class="sidebar-item">
                        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" id="liquidaciones-toggle">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap">
                                    <button class="link-sidebar-btn">LIQUIDACIONES</button>
                                </span>
                            </div>
                        </a>

                        <ul id="liquidaciones-menu" class="submenu">
                            <li>
                                <a href="{{route('muestras.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> MUESTRAS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('clientes.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> CLIENTES</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('requerimientos.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> REQUERIMIENTOS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('facturas.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> ADELANTOS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('liquidaciones.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> VALORIZACION</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('procesadas')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> FINA</button></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Pestaña de Inventario -->
                    <li class="sidebar-item">
                        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" id="inventario-toggle">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap">
                                    <button class="link-sidebar-btn"> INVENTARIO</button>
                                </span>
                            </div>
                        </a>
                        <ul id="inventario-menu" class="submenu">
                            <li>
                                <a href="{{route('acactivos.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> ACTIVOS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('accategorias.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> CATEGORÍAS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('areas.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> ÁREAS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('empleados.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> EMPLEADOS</button></span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('posiciones.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <div class="sidebar-box">
                                        <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> POSICIONES</button></span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('reportes.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> REPORTES</button></span>
                            </div>
                        </a>
                    </li>

                    <!-- Usuarios -->
                    <li>
                        <a href="{{route('users.index')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> USUARIOS</button></span>
                            </div>
                        </a>
                    </li>

                    <!-- Cerrar sesión -->
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group" onclick="confirmLogout(event);">
                            <div class="sidebar-box">
                                <span class="ms-3 whitespace-nowrap"><button class="link-sidebar-btn"> CERRAR SESIÓN</button></span>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth

                @if (!Auth::check())
                    <div style="text-align: center;">
                        <img src="{{ asset('images/innovalogo.png') }}" alt="" style="width:200px; height:200px; vertical-align:middle; margin-bottom: 20px;">
                        <p style="font-size: 30px; font-family: 'Arial', sans-serif; margin-top: 10px;">INNOVA CORPORATIVO</p>
                    </div>
                @endif
            </ul>
        </div>
    </aside>

    <main class="flex-1 p-4">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function () {
        const sidebar = document.getElementById('default-sidebar');
        const app = document.getElementById('app');
        sidebar.classList.toggle('collapsed');
        app.classList.toggle('sidebar-collapsed');
    });
</script>

<script>
    function confirmLogout(event) {
        event.preventDefault();

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas cerrar sesión?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        function isRucOrDni(value) {
            return value.length === 8 || value.length === 11;
        }

        function buscarDocumento(url, inputId, datosId) {
            var inputValue = $(inputId).val();
            var tipoDocumento = inputValue.length === 8 ? 'dni' : 'ruc';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    documento: inputValue,
                    tipo_documento: tipoDocumento
                },
                success: function(response) {
                    if (tipoDocumento === 'dni') {
                        $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' + response.apellidoMaterno);
                    } else {
                        $(datosId).val(response.razonSocial);
                    }
                    $(datosId).removeClass('is-invalid').addClass('is-valid');
                },
                error: function() {
                    $(datosId).val('');
                    $(datosId).removeClass('is-valid').addClass('is-invalid');
                }
            });
        }

        $('#buscar_cliente_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#documento_cliente', '#datos_cliente');
        });

        $('#buscar_empresa_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#ruc_empresa', '#razon_social');
        });

        $('#buscar_identificador_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#identificador', '#nom_iden');
        });

        $('#buscar_nroruc_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#nro_ruc', '#documento_ruc');
        });

        $('#buscar_dniencargado_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#documento_encargado', '#datos_encargado');
        });

        $('#buscar_dniconductor_btn').click(function() {
            buscarDocumento('{{ route('buscar.documento') }}', '#dni_conductor', '#datos_conductor');
        });

        $('.documento-input').on('input', function() {
            var value = $(this).val();
            var isValid = isRucOrDni(value);

            $(this).toggleClass('is-valid', isValid);
            $(this).toggleClass('is-invalid', !isValid);
        });

        $('.datos-input').on('input', function() {
            var value = $(this).val();
            $(this).toggleClass('is-valid', value.trim().length > 0);
            $(this).toggleClass('is-invalid', value.trim().length === 0);
        });
    });
</script>

<!-- Script para manejar la visibilidad del menú -->
<script>
    $(document).ready(function(){
        $('#liquidaciones-toggle').click(function(){
            $('#liquidaciones-menu').toggleClass('show');
        });

        $('#inventario-toggle').click(function(){
            $('#inventario-menu').toggleClass('show');
        });

        $('#pesos-toggle').click(function(){
            $('#pesos-menu').toggleClass('show');
        });

        // ✅ ESTADOS (OCULTO / COMENTADO)
        // $('#estados-toggle').click(function(){
        //     $('#estados-menu').toggleClass('show');
        // });
    });
</script>

@stack('js')
@stack('styles')
@stack('scripts')
</body>
</html>
