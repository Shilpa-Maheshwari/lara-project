@extends('layouts.admin')

@section('title')
Color List
@endsection

@section('content')


<div class="card">
    @if('color.store')
    <div class="card-header">
        <a href="{{ route('color.create') }}" class="btn btn-sm btn-info float-right">
            <i class="fa fa-plus"></i> Add Color
        </a>
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th width="10%">Color Name</th>
                        <th width="15%">Color</th>
                        <th width="15%">Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($colors as $color)
                    <tr>
                        <td>{{ $color->name}}</td>
                        <td class="d-flex justify-content-between" style="align-items: center;">
                            <p>{{ $color->color}}</p> 
                            <div class="color-div" style="background-color: {{ $color->color}};"></div>
                        </td>
                        <td>{{ $color->status=='1'?'Active':'In-Active' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('color.edit',$color->id) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('color.destroy',$color->id) }}" method="post">
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

</script>

@endsection