@extends('layouts.admin')

@php
$route=Route::currentRouteName()
@endphp

@section('title')
{{ $route=='category.create' ? 'Add Category' : 'Edit Category' }}
@endsection


@section('content')


<form id="form" action="{{ $route=='category.create' ? route('category.store') : route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
{{ $route=='category.create' ? method_field('POST') : method_field('PUT') }}

@csrf


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Category Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ @$category->name }}">
                </div>
                <p style="color:red; margin:0">Category image must be 150 x 150px</p>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="control-label w-100">Image:</label>
                            <input type="file" id="image" name="image" class="form-control border-0 pl-0" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        @if(@$category->image)
                            <label class="control-label w-100">Previous Image</label>
                            <img src="{{ asset('category_image/'.$category->image) }}" class="img-fluid border w-100 rounded">
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                @if($route=='category.create'?'category.store':'category.update')
                <button type="submit" id="submit_btn" class="btn btn-success"> {{ $route=='category.create'?'Save':'Update' }} </button>
                @endif
                <a href="{{ route('category.index') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
</div>

</form>

<script type="text/javascript">
$('#form').submit(function(evt){

    var name = $('#name').val();
    var files = $('#image')[0].files;

    if(name.length==0)
    {
        Swal.fire({
            icon:'error',
            text: "Please enter category name.",
        })
        return false;
    }
    else if(files.length==0)
    {
        if(files[0].type!='image/jpeg' && files[0].type!='image/png')
        {
            Swal.fire({
                icon:'error',
                text: "Category Image must be image",
            })
            evt.preventDefault();
            return false;
        }
    }
})
</script>
@endsection
