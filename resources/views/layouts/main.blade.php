<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria">
    <meta name="author" content="">

    <title>@yield('titulo_pagina', 'Veterinaria') - Sistema</title>

    {{-- Font Awesome --}}
    <link href="/startbootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="/startbootstrap/css/sb-admin-2.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">

    {{-- Page Wrapper --}}
    <div id="wrapper">

        {{-- ===== SIDEBAR ===== --}}
        @include('layouts.partials.sidebar')
        {{-- ===== FIN SIDEBAR ===== --}}

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">

                {{-- ===== TOPBAR (NAVBAR) ===== --}}
                @include('layouts.partials.topbar')
                {{-- ===== FIN TOPBAR ===== --}}

                {{-- Begin Page Content --}}
                <div class="container-fluid">

                    {{-- Page Heading --}}
                    @hasSection('page_heading')
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">@yield('page_heading')</h1>
                            @yield('page_actions')
                        </div>
                    @endif

                    {{-- Contenido de la página --}}
                    @yield('contenido')

                </div>
                {{-- /.container-fluid --}}

            </div>
            {{-- End of Main Content --}}

            {{-- ===== FOOTER ===== --}}
            @include('layouts.partials.footer')
            {{-- ===== FIN FOOTER ===== --}}

        </div>
        {{-- End of Content Wrapper --}}

    </div>
    {{-- End of Page Wrapper --}}

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- ===== MODAL DE LOGOUT ===== --}}
    @include('layouts.partials.logout_modal')
    {{-- ===== FIN MODAL ===== --}}

    {{-- Bootstrap core JS --}}
    <script src="/startbootstrap/vendor/jquery/jquery.min.js"></script>
    <script src="/startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    {{-- Core plugin JS --}}
    <script src="/startbootstrap/vendor/jquery-easing/jquery.easing.min.js"></script>

    {{-- SB Admin 2 scripts --}}
    <script src="/startbootstrap/js/sb-admin-2.min.js"></script>

    @stack('scripts')

</body>

</html>
