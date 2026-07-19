<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <title>@yield('title', 'Admin') · {{ config('app.name', 'Saree Info') }}</title>
        <!-- Custom fonts for this template-->
        <link href="{{ asset('css/fonts-googleapis.css') }}" rel="stylesheet">
        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="{{ asset('backend/admin-lte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/admin-modern.css') }}">
        @stack('styles')
        <!-- <link rel="stylesheet" href="{{-- asset('css/font-awesome-all-min.css') --}}"> -->

        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css">

         <!-- SweetAlert2 CSS (optional) -->
        <link rel="stylesheet" href="{{ asset('backend/css/sweetalert2.min.css') }}">
        
    </head>
    
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed admin-premium-theme">
        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper">

            <!-- Navbar -->
            @include('backend.includes.header')
        
            <!-- Main Sidebar -->
            @include('backend.includes.sidebar')

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <section class="content pt-3">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>

            <!-- Footer -->
            @include('backend.includes.footer')

        </div>

        <!-- REQUIRED SCRIPTS -->
        <script src="{{ asset('backend/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/admin-lte/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('backend/js/dataTables.min.js') }}"></script>

        <!-- SweetAlert2 JS -->
        <script src="{{ asset('backend/js/sweetalert2.all.min.js') }}"></script>


        <!-- ChartJS -->
        <script src="{{ asset('backend/admin-lte/plugins/chart.js/Chart.min.js') }}"></script>
        <script>
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.classList.remove('show');
                    alert.style.display = 'none';
                });
            }, 3000); // 3 seconds me hide ho jayega
        </script>
        @stack('scripts')
    </body>
</html>
