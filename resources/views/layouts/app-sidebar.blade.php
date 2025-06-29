<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @isset($title)
            {{ config('app.name') | $title }}
        @else
            {{ config('app.name') }}
        @endisset
    </title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="/stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/stisla/dist/assets/modules/fontawesome/css/all.min.css">

    {{-- CUSTOMIZE CSS --}}
    <link href="/customize/style.css" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/stisla/dist/assets/modules/izitoast/css/iziToast.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    {{-- Yield Style --}}
    @yield('css')
    @stack('css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="/stisla/dist/assets/css/style.css">
    <link rel="stylesheet" href="/stisla/dist/assets/css/components.css">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body style="font-family: 'Figtree">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <x-navbar></x-navbar>
            <x-sidebar></x-sidebar>

            <!-- Main Content -->
            @yield('content')

            @include('pages.auth.logout')
            <x-footer></x-footer>
        </div>
    </div>

    <div id="loader" class="loader"></div>
    <div id="loaderAtShow" class="loaderAtShow"></div>
    <div id="loaderAMoment" class="loader"></div>

    <!-- General JS Scripts -->
    <script src="/stisla/dist/assets/modules/jquery.min.js"></script>
    <script src="/stisla/dist/assets/modules/popper.js"></script>
    <script src="/stisla/dist/assets/modules/tooltip.js"></script>
    <script src="/stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="/stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/stisla/dist/assets/modules/moment.min.js"></script>
    <script src="/stisla/dist/assets/js/stisla.js"></script>

    {{-- CUSTOMIZE --}}
    <script src="/customize/script.js"></script>

    <!-- JS Libraies -->
    <script src="/stisla/dist/assets/modules/izitoast/js/iziToast.min.js"></script>
    <x-toastr></x-toastr>

    {{-- Select2 --}}
    <script src="/stisla/dist/assets/modules/select2/dist/js/select2.full.min.js"></script>

    {{-- Yield JS --}}
    @yield('js')
    @stack('js')

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="/stisla/dist/assets/js/scripts.js"></script>
    <script src="/stisla/dist/assets/js/custom.js"></script>

    <script>
        $(document).ready(function() {
            $('#defaultTable').dataTable({
                ordering: false,
            });
        });
    </script>

    {{-- Customize JS --}}

</body>

</html>
