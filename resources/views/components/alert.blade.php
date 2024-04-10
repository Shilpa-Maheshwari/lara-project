@if (count($errors) > 0)
	<div class="alert alert-danger">
		<ul style="margin:0">
			@foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif
@if (\Session::has('success'))
	<div class="alert alert-success alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>{!! \Session::get('success') !!}</strong>
	</div>
@elseif (\Session::has('failed'))
    <div class="alert alert-danger alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>{!! \Session::get('failed') !!}</strong>
	</div>
@elseif (\Session::has('warning'))
    <div class="alert alert-warning alert-dismissible " role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong> {!! \Session::get('warning') !!}</strong> 
	</div>
@elseif (\Session::has('info'))
    <div class="alert alert-info alert-dismissible " role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>{!! \Session::get('info') !!}</strong> 
    </div>
@endif

