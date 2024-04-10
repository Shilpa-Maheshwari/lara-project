@extends('layouts.site')

@section('content')

<x-slider :sliders="$sliders"></x-slider>

<h2 class="f-raleway text-center">Treding Medicine</h2>

<div class="row">
    <div class="col-md-12">
        <div id="trending" class="owl-carousel owl-theme">

            @foreach($trendings as $trend)
            <div class="item">
                <img src="{{ asset('trending_slider/web/'.$trend->web_image) }}" style="width:100%; height:200px" class="rounded">
            </div>
            @endforeach
            
        </div>
    </div>
</div> 


<script type="text/javascript">

$(document).ready(function(){
    var owl = $('#trending');
    owl.owlCarousel({
        items: 3,
        loop: true,
        margin: 15,
        dots:false,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: false
    });
    $('#trending .play').on('click', function() {
        owl.trigger('play.owl.autoplay', [1000])
    })
    $('#trending .stop').on('click', function() {
        owl.trigger('stop.owl.autoplay')
    })
});
</script>
@endsection