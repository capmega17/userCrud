<!DOCTYPE html>
<html ng-cloak ng-app="sic">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM |  @yield('title_tab') </title>

    <link rel="icon" type="image/png" sizes="16x16" href="">

    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" media="screen">

    <!-- Animate CSS -->
    <link href="{{asset('css/animate.css')}}" rel="stylesheet" media="screen">

    <!-- Alertify CSS -->
    <link href="{{asset('css/alertify/alertify.core.css')}}" rel="stylesheet">
    <link href="{{asset('css/alertify/alertify.default.css')}}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{asset('css/main.css')}}" rel="stylesheet" media="screen">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/datepicker.css')}}">

    <!-- OLD Font Awesome
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    -->

    <!-- NEW Font Awesome -->
    <script src="https://kit.fontawesome.com/67678e9f76.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('tagEditor/jquery.tag-editor.css')}}">
    <link rel="stylesheet" href="{{asset('eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">

    {{--Library to apply on hover effects CSS--}}
    <link rel="stylesheet" href="{{asset('components/hover/css/hover-min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/styles2.css')}}">
    <link rel="stylesheet" href="{{asset('css/helpers.css?v=1')}}">
    <link rel="stylesheet" href="{{asset('css/colors.css?v=2')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css?v=2')}}">

    {{-- Multi Select CSS --}}
    <link rel="stylesheet" href="{{asset('lou-multi-select/css/multi-select.css')}}">

    {{-- Full Calendar --}}
    <link rel="stylesheet" href="{{asset('components/fullcalendar/dist/fullcalendar.css')}}">
    <link rel="stylesheet" media="print" href="{{asset('components/fullcalendar/dist/fullcalendar.print.css')}}">

    <style>
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }
    </style>
    @yield('extra_css')
</head>
<body>

{{--
@if(Auth::user()->role->seoname !== 'cliente_admin')
<div class="alert alert-warning alert-due-payment">
    <b>Te recordamos que tu fecha de pago está próxima a vencer, para impedir la interrupción del servicio contáctate con soporte técnico.</b>
</div>
@endif
--}}

<!-- Header Start -->
<header class="wh-bg-primary {{ env('APP_ENV') == 'local' ? 'local_bg' : ''}}">

    <!-- Logo starts -->
    <div class="logo">
        <a href="#" class="menu-toggle hidden-xs">
	    <img src="{{ asset('img/logos/logoclinica.png') }}" alt="logo">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <!-- Logo ends -->

    <!-- Mini right nav starts -->
    <div class="pull-right">
        <ul ng-controller="NotificationController" id="mini-nav" class="clearfix">
            <li class="list-box hidden-lg hidden-md hidden-sm" id="mob-nav">
                <a href="#">
                    <i class="fa fa-reorder"></i>
                </a>
            </li>
            <!--NOTIFICACIONES DEMOSTRATIVAS-->
            <li class="list-box dropdown hidden-xs">
                <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" data-original-title="" title="">
                    <i class="fa fa-bell"></i>
                </a>
                <span ng-show="notifications.length > 0" class="info-label danger-bg animated rubberBand">@{{ notifications.length }}</span>
                <ul class="dropdown-menu bounceIn animated messages">
                    <li class="plain">
                        Notificaciones
                    </li>
                    <li ng-repeat="notification in notifications">
                        <a href="@{{ notification.uri }}">
                            <div class="user-pic">
                                <i class="@{{ notification.icon }}"></i>
                            </div>
                            <div class="details">
                                <strong class="text-info">
                                    @{{ notification.title }} - @{{ notification.created_at }}
                                </strong>
                                <span>
                                    @{{ notification.message }}
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="list-box dropdown hidden-xs">
                <a href="/logout">
                    <i class="fa fa-sign-out"></i>
                    <i>Salir</i>
                </a>
            </li>
        </ul>
    </div>
    <!-- Mini right nav ends -->

</header>
<!-- Header ends -->

<!-- Left sidebar starts -->
<aside id="sidebar" class="wh-bg-primary">

    @if(Auth::user()->role->seoname == 'master' or Auth::user()->role->seoname == 'centermanager' or Auth::user()->role->seoname == 'operationsleader' or Auth::user()->role->seoname == 'operationshelper' or Auth::user()->role->seoname == 'observador')
    <div class="user-side-menu expanded">
    @else
    <div class="user-side-menu">
    @endif
        <div class="user-photo">
            <img src="/img/avatar/{{ Auth::user()->avatar }}" alt="Usuario">
        </div>
        <div class="user-info">
            @if(Auth::user()->role->seoname == 'cliente_admin')
                {{ substr(Auth::user()->client->enterprise_name, 0, 26) }}
                <br>
                {{ Auth::user()->email }}
                <br>
                {{ Auth::user()->center->name }}
                <br>
            @else
                {{ Auth::user()->name }}
                <br>
                {{ Auth::user()->role->name }}
                <br>
                {{ Auth::user()->center->name }}
                <br>
            @endif

            @if(Auth::user()->role->seoname == 'master' or Auth::user()->role->seoname == 'centermanager' or Auth::user()->role->seoname == 'operationsleader' or Auth::user()->role->seoname == 'operationshelper' or Auth::user()->role->seoname == 'observador')
                Meta: ${{ number_format(Auth::user()->center->fee_goal, 2) }} {{ strtoupper(Auth::user()->center->currency) }}
                <br>
                Vendido: ${{ number_format(get_fee_goal(false, true), 2) }} {{ strtoupper(Auth::user()->center->currency) }}
                <br>
                Pagado: ${{ number_format(get_fee_goal(false, true, false), 2) }} {{ strtoupper(Auth::user()->center->currency) }}
                <br>
                Pagado / Meta: {{ get_fee_goal(false, false, false) }}%
                <br>
                <div class="progress-stats clearfix">
                    <div class="progress progress_fee_goal ">
                        <div class="progress-bar progress-bar-info {{ get_fee_goal(true, false, false) }}" role="progressbar" aria-valuenow="{{ get_fee_goal(false, false, false) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ get_fee_goal(false, false, false) }}%;">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Menu start -->
    <div id='menu' class="wh-bg-primary">
        <ul>
            @if(Auth::user()->role->seoname !== 'cliente_admin')
                @if(Auth::user()->role->seoname == 'observador')
                    <li class="{{ Request::is('dashboard') ? 'highlight' : '' }}">
                        <a href="/dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('payment*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <span>Pagos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/payment/collection" class="{{ Request::is('payment/collection') ? 'select' : '' }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <span>Cobranza</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('invoice*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-book" aria-hidden="true"></i>
                            <span>Facturación</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/invoice/downloadFiles" class="{{ Request::is('invoice/downloadFiles') ? 'select' : '' }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <span>Descargas</span>
                                </a>
                            </li>
                            <li>
                                <a href="/invoice" class="{{ Request::is('invoice') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Facturas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    @if(Auth::user()->role->seoname == 'master')
                        <li class="{{ Request::is('centers') ? 'highlight' : '' }}">
                            <a href="/centers">
                                <i class="fa fa-building"></i>
                                <span>Centros</span>
                            </a>
                        </li>
                    @endif
                    <li class="{{ Request::is('dashboard') ? 'highlight' : '' }}">
                        <a href="/dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('forecast*') || Request::is('client*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-users"></i>
                            <span>Pacientes</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/forecast/create" class="{{ Request::is('forecast/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus"></i>
                                    <span>Crear Prospecto</span>
                                </a>
                            </li>
                            <li>
                                <a href="/forecast" class="{{ Request::is('forecast') ? 'select' : '' }}">
                                    <i class="fa fa-users"></i>
                                    <span>Prospectos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/client" class="{{ Request::is('client') || Request::is('client/*') ? 'select' : '' }}">
                                    <i class="fa fa-book"></i>
                                    <span>Listado de Pacientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="/forecast/trackings" class="{{ Request::is('forecast/trackings') ? 'select' : '' }}">
                                    <i class="fa fa-calendar"></i>
                                    <span>Seguimientos</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- crear usuarios --}}

                    <li class="{{ Request::is('user*') || Request::is('client*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/user/create" class="{{ Request::is('user/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus"></i>
                                    <span>Crear Usuario</span>
                                </a>
                            </li>
                            <li>
                                <a href="/user" class="{{ Request::is('client') || Request::is('client/*') ? 'select' : '' }}">
                                    <i class="fa fa-book"></i>
                                    <span>Listado de usuarios</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- End Crear Usuarios --}}






                    {{--
                    <li class="{{ Request::is('provider*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-users-cog"></i>
                            <span>Proveedores</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/provider/create" class="{{ Request::is('provider/create') ? 'select' : '' }}">
                                    <i class="fa fa-user-cog"></i>
                                    <span>Crear Proveedor</span>
                                </a>
                            </li>
                            <li>
                                <a href="/provider" class="{{ Request::is('provider') ? 'select' : '' }}">
                                    <i class="fa fa-users-cog"></i>
                                    <span>Lista Proveedores</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}

{{--
                    <li class="{{ Request::is('quotations*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-tags"></i>
                            <span>Cotizaciones</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/quotations/create" class="{{ Request::is('quotations/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus"></i>
                                    <span>Crear Cotización</span>
                                </a>
                            </li>
                            <li>
                                <a href="/quotations" class="{{ Request::is('quotations') ? 'select' : '' }}">
                                    <i class="fa fa-list"></i>
                                    <span>Historial de Cotizaciones</span>
                                </a>
                            </li>
                        </ul>
                    </li>
--}}

                    {{--
                    <li class="{{ Request::is('purchase*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-dollar"></i>
                            <span>Compras</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/purchase/create" class="{{ Request::is('purchase/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus"></i>
                                    <span>Nueva Compra</span>
                                </a>
                            </li>
                            <li>
                                <a href="/purchase" class="{{ Request::is('purchase') ? 'select' : '' }}">
                                    <i class="fa fa-list"></i>
                                    <span>Historial de Compras</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('sale*') || Request::is('payment*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-money"></i>
                            <span>Ventas y Pagos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/sale/create" class="{{ Request::is('sale/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus"></i>
                                    <span>Nueva Venta</span>
                                </a>
                            </li>
                            <li>
                                <a href="/sale" class="{{ Request::is('sale') ? 'select' : '' }}">
                                    <i class="fa fa-list"></i>
                                    <span>Historial de Ventas</span>
                                </a>
                            </li>
                            <li>
                                <a href="/payment" class="{{ Request::is('payment') || Request::is('payment*') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Pagos</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('inventory*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-boxes"></i>
                            <span>Productos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/inventory" class="{{ Request::is('inventory') ? 'select' : '' }}">
                                    <i class="fa fa-warehouse"></i>
                                    <span>Inventario</span>
                                </a>
                            </li>
                            <li>
                                <a href="/inventoryChanges" class="{{ Request::is('inventoryChanges') ? 'select' : '' }}">
                                    <i class="fa fa-history" aria-hidden="true"></i>
                                    <span>Historial de Cambios</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}


                    {{--
                    <li class="{{ Request::is('payment*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <span>Pagos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/payment" class="{{ Request::is('payment') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Pagos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/payment/collection" class="{{ Request::is('payment/collection') ? 'select' : '' }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <span>Cobranza</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}

                    {{--
                    <li class="{{ Request::is('message*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-envelope"></i>
                            <span>Centro de Mensajes</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/message/create" class="{{ Request::is('message/create') ? 'select' : '' }}">
                                    <i class="fa fa-envelope-open"></i>
                                    <span>Crear Mensaje</span>
                                </a>
                            </li>
                            <li>
                                <a href="/message" class="{{ Request::is('message') ? 'select' : '' }}">
                                    <i class="fa fa-list"></i>
                                    <span>Historial de Mensajes</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('reservations*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-book"></i>
                            <span>Reservaciones</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/reservations/calendar" class="{{ Request::is('reservations/calendar') ? 'select' : '' }}">
                                    <i class="fa fa-calendar"></i>
                                    <span>Calendario</span>
                                </a>
                            </li>
                            <li>
                                <a href="/reservations/history" class="{{ Request::is('reservations/history') ? 'select' : '' }}">
                                    <i class="fa fa-list"></i>
                                    <span>Historial</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('contract*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <span>Contratos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/contract/create" class="{{ Request::is('contract/create') ? 'select' : '' }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <span>Nuevo Contrato</span>
                                </a>
                            </li>
                            <li>
                                <a href="/contract/" class="{{ Request::is('contract') ? 'select' : '' }}">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    <span>Contratos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('consumption*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-cubes" aria-hidden="true"></i>
                            <span>Consumos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/consumption/create" class="{{ Request::is('consumption/create') ? 'select' : '' }}">
                                    <i class="fa fa-cube" aria-hidden="true"></i>
                                    <span>Nuevo Consumo</span>
                                </a>
                            </li>
                            <li>
                                <a href="/consumption" class="{{ Request::is('consumption*') ? 'select' : '' }}">
                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                    <span>Historial de Consumos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ Request::is('accountStatement*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-copy" aria-hidden="true"></i>
                            <span>Estados de Cuenta</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/accountStatement/validation" class="{{ Request::is('accountStatement/validat*') ? 'select' : '' }}">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span>Validación</span>
                                </a>
                            </li>
                            <li>
                                <a href="/accountStatement" class="{{ Request::is('accountStatement') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Estados</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('invoice*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-book" aria-hidden="true"></i>
                            <span>Facturación</span>
                        </a>
                        <ul>
                            @if(Auth::user()->role->seoname == 'masteradmin' or Auth::user()->role->seoname == 'master')
                                <li>
                                    <a href="/invoice/getDeleteRequests" class="{{ Request::is('invoice/getDeleteRequests') ? 'select' : '' }}">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <span>Cancelaciones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/invoice/downloadFiles" class="{{ Request::is('invoice/downloadFiles') ? 'select' : '' }}">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <span>Descargas</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="/invoice" class="{{ Request::is('invoice') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Facturas</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ Request::is('payment*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <span>Pagos</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/payment" class="{{ Request::is('payment') ? 'select' : '' }}">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Historial de Pagos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/payment/collection" class="{{ Request::is('payment/collection') ? 'select' : '' }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <span>Cobranza</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}

                    @if(App::environment('local'))

                    @endif

                    <li class="{{ Request::is('profile') ? 'highlight' : '' }}">
                        <a href="/profile">
                            <i class="fa fa-user"></i>
                            <span>Mi Perfil</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('report*') ? 'has-sub highlight active' : '' }}">
                        <a href='#'>
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <span>Reportes</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/report/summary" class="{{ Request::is('report/summary') ? 'select' : '' }}">
                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                    <span>General</span>
                                </a>
                            </li>
                            <li>
                                <a href="/report/fee_goal" class="{{ Request::is('report/fee_goal') ? 'select' : '' }}">
                                    <i class="fa fa-line-chart" aria-hidden="true"></i>
                                    <span>Cuotas</span>
                                </a>
                            </li>
                            <li>
                                <a href="/report/forecasts" class="{{ Request::is('report/forecasts*') ? 'select' : '' }}">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <span>Prospectos</span>
                                </a>
                            </li>
                            {{--
                            <li>
                                <a href="/report/occupation" class="{{ Request::is('report/occupation*') ? 'select' : '' }}">
                                    <i class="fa fa-briefcase"></i>
                                    <span>Ocupación</span>
                                </a>
                            </li>
                            --}}
                        </ul>
                    </li>

                    @if(Auth::user()->role->seoname == 'master' or Auth::user()->role->seoname == 'centermanager')
                        <li class="{{ Request::is('configuration*') ? 'has-sub highlight active' : '' }}">
                            <a href='#'>
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                <span>Configuración</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="/configuration/center" class="{{ Request::is('configuration/center') ? 'select' : '' }}">
                                        <i class="fa fa-building" aria-hidden="true"></i>
                                        <span>Centro</span>
                                    </a>
                                </li>
                                @if(Auth::user()->role->seoname == 'master')
                                    <li>
                                        <a href="/configuration/messages" class="{{ Request::is('configuration/messages') ? 'select' : '' }}">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <span>Mensajes</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
            @else
                <li class="{{ Request::is('client/profile') ? 'highlight' : '' }}">
                    <a href="/client/profile">
                        <i class="fa fa-user"></i>
                        <span>Mi Perfil</span>
                    </a>
                </li>

                <li class="{{ Request::is('client/consumptions') ? 'highlight' : '' }}">
                    <a href="/client/consumptions">
                        <i class="fa fa-cubes"></i>
                        <span>Mis consumos</span>
                    </a>
                </li>

                <li class="{{ Request::is('client/reserve') ? 'highlight' : '' }}">
                    <a href="/client/reserve">
                        <i class="fa fa-calendar"></i>
                        <span>Reservador</span>
                    </a>
                </li>

                {{--
                <li class="{{ Request::is('client/consumptions') ? 'highlight' : '' }}">
                    <a href="/client/consumptions">
                        <i class="fa fa-cubes"></i>
                        <span>Mis Consumos</span>
                    </a>
                </li>
                --}}
            @endif

            <li class="{{ Request::is('logout') ? 'highlight' : '' }}">
                <a href="/logout">
                    <i class="fa fa-sign-out"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Menu End -->

</aside>
<!-- Left sidebar ends -->

<!-- Dashboard Wrapper starts -->
<div class="dashboard-wrapper">

    <div class="top-bar">
        <div class="page-title">
            @yield('breadcrumb')
        </div>

        @if(Auth::user()->role->seoname == "centermanager" || Auth::user()->role->seoname == "master")
            <!--<ul class="stats hidden-xs">-->
            <!--    <li>-->
            <!--        <div class="stats-block hidden-sm hidden-xs">-->
            <!--            <span id="downloads_graph"><canvas width="159" height="24" style="display: inline-block; vertical-align: top; width: 159px; height: 24px;"></canvas></span>-->
            <!--        </div>-->
            <!--        <div class="stats-details">-->
            <!--            <h4>$<span id="today_income">1745</span> <i class="fa fa-chevron-up up"></i></h4>-->
            <!--            <h5>Facturación</h5>-->
            <!--        </div>-->
            <!--    </li>-->
            <!--    <li>-->
            <!--        <div class="stats-block hidden-sm hidden-xs">-->
            <!--            <span id="users_online_graph"><canvas width="150" height="24" style="display: inline-block; vertical-align: top; width: 150px; height: 24px;"></canvas></span>-->
            <!--        </div>-->
            <!--        <div class="stats-details">-->
            <!--            <h4>$<span id="today_expenses">829</span> <i class="fa fa-chevron-down down"></i></h4>-->
            <!--            <h5>Restante</h5>-->
            <!--        </div>-->
            <!--    </li>-->
            <!--</ul>-->
        @endif
    </div>

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid Starts -->
        <div class="container-fluid">

            <!-- Spacer starts -->
            <div class="spacer">
                <!-- Row Start -->
                @yield('content')
                <!-- Row End -->
            </div>
            <!-- Spacer ends -->

        </div>
        <!-- Container fluid ends -->

    </div>
    <!-- Main Container ends -->

</div>
<!-- Dashboard Wrapper ends -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('components/jquery/dist/jquery.min.js')}}"></script>

<!-- jQuery UI JS -->
<script src="{{asset('js/jquery-ui-v1.10.3.js')}}"></script>

<script src="{{asset('tagEditor/jquery.tag-editor.js')}}"></script>
<script src="{{asset('js/jquery.caret.js')}}"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<!-- Sparkline graphs -->
<script src="{{asset('js/sparkline.js')}}"></script>

<!-- jquery ScrollUp JS -->
<script src="{{asset('js/scrollup/jquery.scrollUp.js')}}"></script>

<!-- Notifications JS -->
<script src="{{asset('js/alertify/alertify.js')}}"></script>
<script src="{{asset('js/alertify/alertify-custom.js')}}"></script>

<!-- Flot Charts -->
<script src="{{asset('js/flot/jquery.flot.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.resize.min.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.stack.min.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.orderBar.min.js')}}"></script>
<script src="{{asset('js/flot/jquery.flot.pie.min.js')}}"></script>

<!-- JVector Map -->
<script src="{{asset('js/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('js/jvectormap/jquery-jvectormap-usa.js')}}"></script>

<!-- Custom Index -->
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/custom-index.js')}}"></script>

<script src="{{asset('components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

{{--Chart.js dependency--}}
<script src="{{asset('components/chart.js/dist/Chart.min.js')}}"></script>

{{-- Multi select plugin --}}
<script src="{{asset('lou-multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>



<script type="text/javascript" src="{{ asset('components/angular/angular.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/angular-bootstrap/ui-bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('components/angular-bootstrap/ui-bootstrap-tpls.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/controllers/notification.js?v=1') }}"></script>
<script>
    $(".alert-dismissible").fadeTo(4500, 500).slideUp(500, function(){
        $(".alert-dismissible").alert('close');
    });
</script>
{{-- Full Calendar --}}
<script src="{{asset('components/fullcalendar/dist/fullcalendar.js')}}" type="text/javascript"></script>
<script src="{{asset('components/fullcalendar/dist/locale-all.js')}}" type="text/javascript"></script>

@yield('extra_scripts')

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139141723-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-139141723-3');
</script>
</body>
</html>
