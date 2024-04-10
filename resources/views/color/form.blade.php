@extends('layouts.admin')

@php 
$route=Route::currentRouteName()
@endphp

@section('title')
{{ $route=='color.create' ? 'Add Color' : 'Edit Color' }}
@endsection

@section('content')

<form id="form" action="{{ $route=='color.create' ? route( 'color.store') : route( 'color.update',$color->id)  }}" method="POST">
{{ $route=='color.create' ? method_field('POST') : method_field('PUT') }}

    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value=""> -Select- </option>
                            <option value="0" {{ @$color->status=='0'?'selected':'' }}> In-Active </option>
                            <option value="1" {{ @$color->status=='1'?'selected':'' }}> Active </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label w-100">Name:</label>
                                <input type="text" value="{{ @$color->name}}" id="name" name="name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label w-100">Color:</label>
                                <input type="text" id="color" value="{{ @$color->color}}" name="color" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if($route=='color.create'?'color.store':'color.update')
                <button type="submit" id="submit_btn" class="btn btn-success"> {{ $route=='color.create'?'Save':'Update' }} </button>
            @endif
            <a href="{{ route('color.index') }}" class="btn btn-default">Back</a>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#form').submit(function(evt){

    var status = $('#status').val();
   var color = $('#color').val();
    if(!status)
    {
        Swal.fire({
            icon:'error',
            text: "Please select any color status (Web/App).",
        })
        return false;
    } 
    if(!color)
    {
        Swal.fire({
            icon:'error',
            text: "Please select any color.",
        })
        return false;
    }
   else if(color < 3)
    {
        Swal.fire({
            icon:'error',
            text: "Please select valid color.",
        })
        return false;
    }
})
</script>
@endsection