@extends('layouts.admin')

@php 
$route=Route::currentRouteName()
@endphp

@section('title')
{{ $route=='measurment.create' ? 'Add measurment' : 'Edit measurment' }}
@endsection


@section('content')
<form id="form" action="{{ $route=='measurment.create' ? route( 'measurment.store') : route( 'measurment.update',$measur->id)  }}" method="POST">
{{ $route=='measurment.create' ? method_field('POST') : method_field('PUT') }}
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label w-100">Measurment Name:</label>
                                <input type="text" value="{{ @$measur->name}}" id="name" name="name" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if($route=='measurment.create'?'measurment.store':'measurment.update')
                <button type="submit" id="submit_btn" class="btn btn-success"> {{ $route=='measurment.create'?'Save':'Update' }} </button>
            @endif
            <a href="{{ route('measurment.index') }}" class="btn btn-default">Back</a>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#form').submit(function(evt){
   var measurment = $('#name').val();
    if(!measurment)
    {
        Swal.fire({
            icon:'error',
            text: "Please select any measurment.",
        })
        return false;
    }
   else if(measurment < 2)
    {
        Swal.fire({
            icon:'error',
            text: "Please select valid measurment.",
        })
        return false;
    }
})
</script>
@endsection