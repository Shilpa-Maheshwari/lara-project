<!doctype html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="_token" content="{!! csrf_token() !!}" />
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.carousel.css')}}">
    <script type="text/javascript" src="{{ asset('jquery/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('swal/sweet-alert-2.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">

    <!-- old website css -->
    <link rel="stylesheet" href="{{ asset('css/css-old/drift-basic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/font-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/defined.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/home-default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/single-masonry-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css-old/single-product.css') }}">


    <!-- end css links -->
    <title>Jalani Kumkum</title>
    <style type="text/css">
        .f-raleway {
            font-family: 'Raleway', sans-serif;
        }
    </style>


<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Old Website Js -->
    <script src="{{asset('js/jarallax.min.js') }}"></script>
    <script src="{{asset('js/packery.pkgd.min.js') }}"></script>
    <script src="{{asset('js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{asset('js/magnific-popup.min.js') }}"></script>
    <script src="{{asset('js/flickity.pkgd.min.js') }}"></script>
    <script src="{{asset('js/lazysizes.min.js') }}"></script>
    <script src="{{asset('js/js-cookie.min.js') }}"></script>
    <script src="{{asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{asset('js/photoswipe.min.js') }}"></script>
    <script src="{{asset('js/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{asset('js/drift.min.js') }}"></script>
    <script src="{{asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{asset('js/resize-sensor.min.js') }}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.min.js') }}"></script>
    <script src="{{asset('js/interface.js') }}"></script>
    <script src="{{asset('owlcarousel/owl.carousel.min.js') }}"></script>


</head>

<body>
    <x-navbar />

    <div class="py-0 px-3 ">
        @yield('content')
    </div>


    
    <script>
        $('.pwd-show-btn').click(function() {
            var type = $(this).parent().find('input').attr('type')
            if (type == 'password') {
                $(this).addClass('fa-eye-slash').removeClass('fa-eye')
                $(this).parent().find('input').attr('type', 'text')
            } else {
                $(this).removeClass('fa-eye-slash').addClass('fa-eye')
                $(this).parent().find('input').attr('type', 'password')
            }
        })
    </script>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</body>

</html>