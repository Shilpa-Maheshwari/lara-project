@extends('layouts.admin')

@section('title')
Trending Slider
@endsection



@section('content')
<div class="card">
    @can('config.trending.slider.store')
    <div class="card-header">
        <a href="{{ route('config.trending.slider.create') }}" class="btn btn-sm btn-info float-right">
            <i class="fa fa-upload"></i> Upload Slide
        </a>
    </div>
    @endcan
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th width="20%">Web Image</th>
                        <th width="10%">Status</th>
                        <th width="20%">App Image</th>
                        <th width="10%">Status</th>
                        <th width="15%">Order</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slide)
                    <tr>
                        <td>@if($slide->web_image) <img src="{{ asset('trending_slider/web/'.$slide->web_image) }}" class="img-fluid border w-100" style="height:70px"> @endif </td>
                        <td>{{ $slide->web_status=='1'?'Active':'In-Active' }}</td>
                        <td>@if($slide->app_image) <img src="{{ asset('trending_slider/app/'.$slide->app_image) }}" class="img-fluid border w-100" style="height:70px"> @endif </td>
                        <td>{{ $slide->app_status=='1'?'Active':'In-Active' }}</td>
                        <td>
                            <input type="number" value="{{ $slide->order_number }}" @if(Auth::user()->can('config.trending.slider.update-order')) onchange="updateSliderOrder({{ $slide->id }}, this)" @else disabled @endif class="form-control">
                        </td>
                        <td>
                            <div class="btn-group">

                                @if(Auth::user()->hasAnyPermission(['config.trending.slider.edit','config.trending.slider.update']))
                                <a href="{{ route('config.trending.slider.edit', $slide->id) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
                                @endif

                                @can('config.trending.slider.destroy')
                                <form action="{{ route('config.trending.slider.destroy', $slide->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-default"><i class="fa fa-trash"></i></button>
                                </form>
                                @endcan

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
$('.delete-btn').click(function(evt){
    if(!confirm('Do you want to delete this slider'))
    {
        evt.preventDefault()
    }
})

function updateSliderOrder(id, element)
{
    var order = parseInt($(element).val());
    if(order && id)
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url:"{{ route('config.trending.slider.update-order') }}",
            method:'POST',
            data:'id='+id+'&order='+order,
            dataType:'JSON',
            success:function(response)
            {
                alert(response.message)
            }
        })
    }
}
</script>

@endsection