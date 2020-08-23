@extends('admin.layout.main')
@section('title','Create banner')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('banner.index')}}" title="Danh mục">banner</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div>
<div class="card">
	<div class="card-body">	
		{{ Form::open(['url' => 'admin/banner', 'method' => 'post','enctype '=>'multipart/form-data']) }}
			<div class="form-group {{ $errors->has('link') ?'has-error':'' }}">
				{{ Form::label('link','Link : ')}}
				{{ Form::text('link','',['class'=>'form-control'])}}
				<span class="text-danger">{{ $errors->first('link')}}</span>
			</div>
			<div class="form-group {{ $errors->has('url_img') ?'has-error':'' }}">
				{{Form::label('Url img:')}}
				<input  name="url_img" type="file" class="form-control">
				<span class="text-danger">{{ $errors->first('url_img')}}</span>
			</div> 
		</div>
		<div class="form-group">
			{{ Form::submit('Save',['class'=>'btn btn-success']) }}
			<a class="btn btn-danger" href="{{route('banner.index')}}">Back</a>
		</div>
		{{ Form::close() }}
</div>
@endsection