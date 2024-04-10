@extends('layouts.admin')
@section('title')
Product
@endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    #product-img 
    {
        height: 50px;
    }
    #productAddModel 
    {
        max-width: 1000px !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <a class="btn btn-sm btn-info float-right" href="{{ route('product.create')}}">
            <i class="fa fa-upload"></i> Add Product
        </a>
    </div>

<!-- table view produts  -->

    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Color Name</th>
                        <th>Measurment</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price}}</td>
                        <td>{{ $product->color->name}}</td>
                        <td>{{ $product->measurment->name}}</td>
                        <td><img src="{{ asset('product_image/'.$product->image) }}" class="img-fluid border w-100 rounded" id="product-img"></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-default">Edit</i></a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-default">Trash</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function price_number(evt,el){
        var key = evt.keyCode?evt.keyCode:evt.which;
        var priceValue = $(el).val();
        if(key >= 48 && key <= 57 || key >= 96 && key <= 105)
        {
            return true;
        }
        if(key==8)
        {
            return true;
        }
       
        var array=[8,37,38,39,40,13,16,9,18,17,46];
        if(array.indexOf(key)>-1)
            {
            return true;
             }
        return false;
    }


    function volume_number(evt,el){
        var key = evt.keyCode?evt.keyCode:evt.which;
        var priceValue = $(el).val();
        if(key >= 48 && key <= 57 || key >= 96 && key <= 105)
        {
            return true;
        }
        if(key==8)
        {
            return true;
        }
       
        var array=[8,37,38,39,40,13,16,9,18,17,46];
        if(array.indexOf(key)>-1)
            {
            return true;
             }
        return false;
    }
   
</script>

<script type="text/javascript">
    function getMeasur(el) {
        var form_id = $(el).val();
        console.log(form_id)
        var dataString = 'form_id=' + form_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url: '{{ url("/get-measurment")}}',
            method: 'post',
            dataType: 'JSON',
            data: dataString,
            success: function(result) {
                console.log(result.volumes);
                if (result.status == 1) {
                    var options = '<option value="">--Select Volumes--</option>';
                    $(result.volumes).each(function(key, item) {
                        options += '<option value="' + item.id + '">' + item.name + '</option>'
                    })
                    $('#measurment-show').html(options)
                }
            }
        })
    }
    // 


    //get sub category by ajax

    function getSubcategory(element) {
        var category_id = $(element).val();
        var dataString = 'category_id=' + category_id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url: '{{ url("/get_subcategory")}}',
            method: 'post',
            dataType: 'JSON',
            data: dataString,
            success: function(response) {
                if (response.status == 1) {
                    var options = '<option value="">--Select Sub Category--</option>';
                    $(response.volumes).each(function(key, item) {
                        options += '<option value="' + item.id + '">' + item.name + '</option>'
                    })
                    $('#subcatshow').html(options)
                }


            }
        })
    }
</script>
<script> 
    $('#formType').select2({
        dropdownParent: $('#product-details')
    });
</script>

<script>  
    $('#brandss').select2({
        dropdownParent: $('#product-details')
    });
</script>

<script>
    $('#category').select2({
        dropdownParent: $('#product-details')
    });
</script>






<script>
    $("#data-table").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "searching": true,
        "ordering": true,
        "info": false,
    }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

    $('.delete-btn').click(function(evt) {
        if (!confirm('Do you want to Trashed this Product')) {
            evt.preventDefault()
        }
    })
</script>



<!-- validation for add form -->
<script>
    function validateProductForm(el) {
        var pname = $('#productName').val();
        var files = $('#image')[0].files;
        var productfile = $('#productimage')[0].files;
        var brand = $('#brandss').val();
        var category = $('#category').val();
        var subcategory = $('#subcatshow').val();
        var form =$('#formType').val()
        var volume = $('#measurment-show').val()
        var volumevalue = $('#volume_value').val();
        var description= $('#description').val()
        var price = $('#price').val();
        alert(brand)
        if (pname='') 
        {
            $('#productErr').html('Product Name Required !');
            el.preventDefault();
            return false;
        }
        if (files.length!=0) 
        {
            if (files[0].type != 'image/jpeg' && files[0].type != 'image/png') {
                Swal.fire({
                    icon: 'error',
                    text: "Product Image must be image",
                })
                evt.preventDefault();
                return false;
            }
            return false;
        } 
        else 
        {
            $('#imageErr').html('Image Required');
            return false;
        }
        if(brand='')
        {
            Swal.fire({
                icon: 'error',
                text: 'Brand Name Required',
            });
            el.preventDefault();
            return false;
        }
        if(category='')
        {
            Swal.fire({
                icon: 'error',
                text: 'Category Name required',
            })
            return false;
        }
        if('')
        if (!productfile.length == 0) {
            for (var i=0; i<productfile.length; i++) {
                if (files[i].type != 'image/jpeg' && files[i].type != 'image/png') {
                    Swal.fire({
                        icon: 'error',
                        text: "Product Image must be image",
                    })
                    evt.preventDefault();
                    return false;
                }
            }
        } 
        else{
            $('#multiimageErr').html('image required');
        }
        el.preventDefault()
        return false;
    }
</script>
@endsection