@extends('layouts.site')
@section('content')
<div class="main-content">
    <div class="container-fluid">
        <div class="row my-3">
            <div class="col-md-12">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" id="main-slider">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('images/jalani-pooja-items.jpg')}}">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('images/slider/kumkum-indai.jpg')}}">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <h3 class="text-center">You may also like</h3>
        <div class="row mt-3">
            @foreach($products as $product)
            <div class="col-md-3">
                <a href="{{url('/product_detailes/'.encrypt($product->id) )}}" id="product-link">
                    <div class="card" id="productCard">
                        <div class="card-body">
                            <img src="{{ asset('product_image/'.$product->image) }}" class="img-fluid  w-100 rounded productImg">
                            <h6 class="text-center">{{ $product->name}}</h6>
                            <div class="productpricevalue d-flex justify-content-end">
                                <span class="price-heading">Price*</span>
                                <span class="productPrice">{{ $product->price}}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    $('.carousel').carousel({
        interval: 2000
    })
</script>

@endsection