@extends('admin.layout.main')
@section('title','Create Role')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('role.index')}}" title="Danh mục">Role</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div>
<div class="card">
	<div class="card-body">	
		{{ Form::open(['url' => 'admin/role', 'method' => 'post']) }}
			<div class="form-group col-md-6 {{ $errors->has('name') ?'has-error':'' }}">
				{{ Form::label('name','Name : ')}}
				{{ Form::text('name','',['class'=>'form-control'])}}
				<span class="text-danger">{{ $errors->first('name')}}</span>
			</div>
			<div class="form-group col-md-6 {{ $errors->has('display_name') ?'has-error':'' }}">
				{{ Form::label('display_name','Display name : ')}}
				{{ Form::text('display_name','',['class'=>'form-control'])}}
				<span class="text-danger">{{ $errors->first('display_name')}}</span>
			</div>
			<div class="form-group col-md-12">
				{{Form::label('Permisson:')}}
				{{Form::select('permission_id[]',$permissions,null,['class' => 'form-control permissions', 'multiple'=>'multiple'])}} 
				<span class="text-danger">{{ $errors->first('permission_id')}}</span>  
			</div> 
			<div class="form-group col-md-12">
				{{ Form::submit('Save',['class'=>'btn btn-success']) }}
				<a class="btn btn-danger" href="{{route('role.index')}}">Back</a>
			</div>
		{{ Form::close() }}
	</div>
</div>
<script>
	$('.permissions').select2();
</script>
@endsection