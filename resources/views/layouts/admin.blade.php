<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A2z | Dashboard</title>
    <meta name="_token" content="{!! csrf_token() !!}" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <script src="{{ asset('admin-panel/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('swal/sweet-alert-2.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <script src="{{ asset('admin-panel/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin-panel/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    
    
    <script src="{{ asset('admin-panel/dist/js/adminlte.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('admin-panel/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>
 
    <x-admin.header />

    <x-admin.aside />

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0">@yield('title')</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <x-alert />
                    @yield('content')
            </div>
        </section>
    </div>
    
    <footer class="main-footer">
        Jalani Kumkum
    </footer>

</div>

<script>
    $('.pwd-show-btn').click(function(){
        var type=$(this).parent().find('input').attr('type')
        if(type=='password'){
            $(this).addClass('fa-eye-slash').removeClass('fa-eye')
            $(this).parent().find('input').attr('type', 'text')
        }else{
            $(this).removeClass('fa-eye-slash').addClass('fa-eye')
            $(this).parent().find('input').attr('type', 'password')
        }
    })
</script>


</body>
</html>
