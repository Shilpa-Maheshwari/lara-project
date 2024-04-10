@extends('layouts.admin')

@section('title')
Category
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('category.create') }}" class="btn btn-sm btn-info float-right">
            <i class="fa fa-upload"></i> Add Category
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th width="14%">Image</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td><img src="{{ asset('category_image/'.$category->image) }}" class="img-fluid border w-100" style="height:70px"></td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Edit</a>
                                @if('category.destroy')
                                <form action="{{ route('category.destroy', $category->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="delete-btn btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</button>
                                </form>
                                @endif
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
$("#data-table").DataTable({
    "responsive": false,
    "lengthChange": false,
    "autoWidth": false,

    "paging": false,
    "searching": true,
    "ordering": false,
    "info": false,
}).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

$('.delete-btn').click(function(evt){
    if(!confirm('Do you want to delete this category'))
    {
        evt.preventDefault()
    }
})
</script>

@endsection
