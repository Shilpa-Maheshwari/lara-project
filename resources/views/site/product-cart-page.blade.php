@extends('layouts.site')

@section('content')

<div class="container mt-5">
    <h3>My Cart</h3>
    @if(count($carts))
    <div class="row">
        <div class="col-md-8">
            @foreach($carts as $cart)
            <div class="card">
                <div class="card-body" id="addTocartPorduct">
                    <div class="product-image">
                        <img src="{{ asset('product_image/'.$cart->product->image)}}">
                    </div>
                    <div class="product-cartDetails">
                        <a href="">
                            <p>{{@$cart->product->name}}</p>
                        </a>
                        <div class="productCartprice">
                            <h6>{{@$cart->product->price}}</h6>
                        </div>
                    </div>
                    <div class="productDelete">
                        <a href="{{ route('delete-cart-product',encrypt($cart->id))}}"> <i class="fa fa-trash"></i></a>
                    </div>
                    <div class="btnforquantity">
                        <button class="btn btn-outline-danger increaseinputbox" onclick="minus('{{ $cart->id }}') , updateQuantity('{{$cart->id}}')"><i class="fa fa-minus" aria-hidden="true"></i></button>
                        <input class="inputforquatity" readonly id="q_{{ $cart->id}}" value="{{ $cart->quantity}}">
                        <button class="btn btn-outline-danger  increaseinputbox" onclick="plus('{{ $cart->id}}'), updateQuantity('{{$cart->id}}')"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-4">
            @php
            $total=0;
            $subtotal=0;
            $discount=0;
            foreach($carts as $cart)
            {
                $total = $total + (@$cart->quantity * @$cart->product->price);
                $dis=(@$cart->product->price/100)*@$cart->product->discount;
                $discount+=$dis;
            }
            @endphp
            <div class="card">
                <div class="card-body">
                    <h6>PRICE DETAILS</h6>
                    <div class="allcaluculation">
                        <div class="subtotal d-flex">
                            <label>Total Product Price</label>
                            <span id="total"><i class="fa fa-inr"></i>{{$total}}</span>
                        </div>
                        <div class="discount d-flex">
                            <label>Discount</label>
                            <span><span><i class="fa fa-minus"></i></span><i class="fa fa-inr"></i>{{ ($total/100)*$dis }}</span>
                        </div>
                        <div class="order-total d-flex">
                            <label>Order Total</label>
                            <span><i class="fa fa-inr"></i>{{ $total-(($total/100)*$dis) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div id="productEmptyCart" class="text-center">
        <img class="img-fluid" src="{{ asset('image/empty-cart.webp')}}" style="height:100px;">
        <h6>Your Cart is empty!</h6>
        <p>You have no items added in the cart.</p>
        <p>Explore and add products you like!</p>
        <a class="btn btn-primary" href="{{ route('content')}}">ADD PRODUCTS</a>
    </div>
    @endif
</div>

<script type="text/javascript">
    function updateQuantity(cart_id)
    {
        var quantity = parseInt($('#q_'+cart_id).val())
        if(quantity)
        {
            $.ajax({
                url:'{{url("/updateQuantity")}}',
                method:'POST',
                dataType:'JSON',
                data:{
                    '_token':'{!! csrf_token() !!}',
                    'quantity':quantity,
                    'cart_id':cart_id
                },
                success:function(response)
                {
                    if(response.sstatus==1)
                    {
                        $('#total').text(response.total)
                    }
                }
            })
        }
    }
    function plus(id) {
        var quantityvalue = parseInt($('#q_' + id).val())
        if (quantityvalue < 10) {
            $('#q_' + id).val(quantityvalue + 1)
        } else if (!quantityvalue) {
            $('#q_' + id).val(1)
        }
    }

    function minus(id) {
        var quantityvalue = parseInt($('#q_' + id).val())
        if (quantityvalue > 1) {
            $('#q_' + id).val(quantityvalue - 1)
        }
    }

    function update_cart_number(el, pid) {
        var quantity = $(el).val()
        $.ajax({
            url: '{{url("update_product_cart")}}',
            method: 'POST',
            dataType: 'JSON',
            data: {
                '_token': '{!! csrf_token() !!}',
                'quantity': quantity,
                'product_id': pid
            },
            success: function(response) {
                let timerInterval
                Swal.fire({
                    timer: 2000,
                    timerProgressBar: true,
                    confirmButton: false,
                }).then((result) => {


                })
                if (response.status != 1) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.message,
                    })
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Product update in cart',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }

        })
    }
</script>
@endsection