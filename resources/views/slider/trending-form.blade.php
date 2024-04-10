@extends('layouts.admin')

@php 
$route=Route::currentRouteName()
@endphp

@section('title')
{{ $route=='config.trending.slider.create' ? 'Add Slider' : 'Edit Slider' }}
@endsection


@section('content')

<form id="form" action="{{ $route=='config.trending.slider.create' ? route('config.trending.slider.store') : route('config.trending.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
{{ $route=='config.trending.slider.create' ? method_field('POST') : method_field('PUT') }}
@csrf

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Display in Web:</label>
                    <select class="form-control" id="web_status" name="web_status">
                        <option value=""> -Select- </option>
                        <option value="0" {{ @$slider->web_status=='0'?'selected':'' }}> In-Active </option>
                        <option value="1" {{ @$slider->web_status=='1'?'selected':'' }}> Active </option>
                    </select>
                </div>
                <p style="color:red; margin:0">Slider image must be 1680 x 320px</p>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="control-label w-100">Image:</label>
                            <input type="file" id="web_image" name="web_image" class="form-control border-0 pl-0" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        @if(@$slider->web_image)
                            <label class="control-label w-100">Previous Image</label>
                            <img src="{{ asset('trending_slider/web/'.$slider->web_image) }}" class="img-fluid border w-100 rounded">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Display in App:</label>
                    <select class="form-control" id="app_status" name="app_status">
                        <option value=""> -Select- </option>
                        <option value="0" {{ @$slider->app_status=='0'?'selected':'' }}> In-Active </option>
                        <option value="1" {{ @$slider->app_status=='1'?'selected':'' }}> Active </option>
                    </select>
                </div>
                <p style="color:red; margin:0">Slider image must be 1680 x 320px</p>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" id="app_image" name="app_image" class="form-control border-0 pl-0" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        @if(@$slider->app_image)
                            <label>Previous Image</label>
                            <img src="{{ asset('trending_slider/app/'.$slider->app_image) }}" class="img-fluid border w-100 rounded">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @can($route=='config.trending.slider.create'?'config.trending.slider.store':'config.trending.slider.update')
        <button type="submit" id="submit_btn" class="btn btn-success"> {{ $route=='config.trending.slider.create'?'Save':'Update' }} </button>
        @endcan
        <a href="{{ route('config.trending.slider.index') }}" class="btn btn-default">Back</a>
    </div>
</div>

</form>

<script type="text/javascript">
$('#form').submit(function(evt){

    var web_status = $('#web_status').val();
    var app_status = $('#app_status').val();
    var app_files = $('#app_image')[0].files;
    var web_files = $('#web_image')[0].files;
    return true;

    if(!web_status && !app_status)
    {
        Swal.fire({
            icon:'error',
            text: "Please select any slider status (Web/App).",
        })
        return false;
    } 
    else if(app_files.length>0) 
    {
        if(app_files[0].type!='image/jpeg' && app_files[0].type!='image/png')
        {
            Swal.fire({
                icon:'error',
                text: "App slider file type must be image",
            })
            evt.preventDefault();
            return false;
        }
    }
    else if(web_files.length>0) 
    {
        if(web_files[0].type!='image/jpeg' && web_files[0].type!='image/png')
        {
            Swal.fire({
                icon:'error',
                text: "Web slider file type must be image",
            })
            evt.preventDefault();
            return false;
        }
    }
})
</script>
@endsection