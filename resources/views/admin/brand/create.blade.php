@extends('admin.layout.main')
@section('title','Create Brand')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('brand.index')}}" title="Danh mục">Brand</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div>
<div class="card">
	<div class="card-body col-md-12">
		{{ Form::open(['url' => 'admin/brand', 'method' => 'post']) }}
		<div class="form-group col-md-12">
			{{ Form::label('name','Name : ')}}
			{{ Form::text('name','',['class'=>'form-control col-md-8'])}}
			<br>
			<span class="text-danger">{{ $errors->first('name')}}</span>
		</div>
		<div class="form-group col-md-12">
			{{ Form::label('description','Description : ')}}
			<br>
			{{ Form::textarea('description','',['id'=>'editor'])}}
			<br>
			<span class="text-danger">{{ $errors->first('description')}}</span>
		</div>		
		<div class="form-group col-md-12">
			{{ Form::submit('Save',['class'=>'btn btn-success']) }}
			<a class="btn btn-danger" href="{{route('brand.index')}}">Back</a>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection