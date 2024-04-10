@extends('layouts.admin')


@section('title')
Add Product
@endsection

@section('content')

<form id="form" action="{{ route('product.store')}}" method="POST" enctype="multipart/form-data" onsubmit="return validateProductForm(event)">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input type="text" class="form-control" id="productName" name="name" value="" required>
                        <span class="text-danger" style="font-size: 14px;" id="productErr"></span>
                    </div>
                    <p style="color:red; margin:0">Product image must be 150 x 150px</p>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Product Image:</label>
                        <input class="form-control" type="file" id="productimage" name="image" required>
                        <span id="multiimageErr" class="text-danger" style="font-size:14px;"></span>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Product Multiple Images:</label>
                        <input class="form-control" type="file" id="formFile" name="multi_image[]" multiple required>
                        <span id="imageErr" class="text-danger" style="font-size:14px;"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="brand">Color Name:</label>
                            <select class="form-control" name="color_id" id="colors" required>
                                <option value="">--Select Color--</option>
                                @foreach($colors as $color)
                                <option value="{{ $color->id}}">{{ $color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="category">Product Measurment:</label>
                            <select class="form-control" name="measurment_id" id="measurment" onchange="getSubcategory(this)" required>
                                <option value="">--Select Measurment--</option>
                                @foreach($measurments as $measur)
                                <option value="{{ $measur->id}}">{{ $measur->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="description">Product Weight Value:</label>
                            <input class="form-control" name="weight" id="weight_value" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="price">Price:</label>
                            <input type="text" name="price" class="form-control" id="price" required onkeydown="return price_number(event,this)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value=""> -Select Status- </option>
                                <option value="0"> In-Active </option>
                                <option value="2"> Active </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="submit_btn" class="btn btn-success">Save</button>
                        <a href="{{ route('product.index') }}" class="btn btn-default">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection