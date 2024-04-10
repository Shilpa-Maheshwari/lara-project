
<link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.theme.default.min.css') }}">
<script type="text/javascript" src="{{ asset('owlcarousel/owl.carousel.js') }}"></script>

<div class="row my-3">
    <div class="col-md-12">
        <div class="main-slider-div mb-5">
            <div class="owl-carousel owl-theme" id="main-slider">
                @foreach($sliders as $slider)
                <div class="item">
                    <img src="{{ asset('home_slider/web/'.$slider->web_image) }}" style="width:100%; height:250px">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var owl = $('#main-slider');
    owl.owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        dots:false,
        autoplay: true,
        autoplayTimeout: 1000,
        autoplayHoverPause: false
    });
    $('.play').on('click', function() {
        owl.trigger('play.owl.autoplay', [1000])
    })
    $('.stop').on('click', function() {
        owl.trigger('stop.owl.autoplay')
    })
});
</script>