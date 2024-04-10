@extends('layouts.admin')

@section('title')
Home Slider
@endsection

@section('content')
<div class="card">
    @if('config.slider.store')
    <div class="card-header">
        <a href="{{ route('config.slider.create') }}" class="btn btn-sm btn-info float-right">
            <i class="fa fa-upload"></i> Upload Slide
        </a>
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th width="20%">Web Image</th>
                        <th width="10%">Status</th>
                        <th width="15%">Order</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slide)
                    <tr>
                        <td>@if($slide->web_image) 
                            <img src="{{ asset('home_slider/web/'.$slide->web_image) }}" class="img-fluid border w-100" style="height:70px"> @endif </td>
                        <td>{{ $slide->web_status=='1'?'Active':'In-Active' }}</td>
                        <td>
                            <input type="number" value="{{ $slide->order_number }}"  class="form-control">
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('config.slider.edit', $slide->id) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('config.slider.destroy', $slide->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-default"><i class="fa fa-trash"></i></button>
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
            url:"{{ route('config.slider.update-order') }}",
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