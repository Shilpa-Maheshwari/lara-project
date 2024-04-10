@extends('layouts.admin')

@section('title')
Measurment List
@endsection

@section('content')
<div class="card">
    @if('measurment.store')
    <div class="card-header">
        <a href="{{ route('measurment.create') }}" class="btn btn-sm btn-info float-right">
            <i class="fa fa-plus"></i> Add measurment
        </a>
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th width="10%">id</th>
                        <th width="15%">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($measurs as $measur)
                    <tr>
                        <td>{{ $measur->name}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('measurment.edit',$measur->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Edit</a>
                                <form action="{{ route('measurment.destroy',$measur->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</button>
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