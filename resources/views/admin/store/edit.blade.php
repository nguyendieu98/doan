@extends('admin.layout.main')
@section('title','Edit Store')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('store.index')}}" title="Danh mục">Store</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</div>
<div class="card">
	<div class="card-body">	
		{{Form::open(['route'=>['store.update',$store->id],'method'=>'put'])}}
		<div class="row ">
			<div class="form-group col-md-3">
				{{ Form::label('Product name: ') }}
				{{ Form::text('name',$store->product_detail->product->name,['class'=>'form-control', 'readonly'=>'readonly'])}}
			</div>
			<div class="form-group col-md-3">
				{{ Form::label('Size: ') }}
				{{ Form::text('size',$store->product_detail->size,['class'=>'form-control', 'readonly'=>'readonly'])}}
			</div>
			<div class="form-group col-md-3">
				{{ Form::label('Color: ') }}
				{{ Form::text('color',$store->product_detail->color,['class'=>'form-control', 'readonly'=>'readonly'])}}
			</div>
			<div class="form-group col-md-3 {{ $errors->has('quantity') ?'has-error':'' }}">
				{{ Form::label('Quantity: ') }}
				{{ Form::number('quantity',$store->quantity,['class'=>'form-control','min'=>'0','max'=>'10000'])}}
				<span class="text-danger">{{ $errors->first('quantity')}}</span>
			</div>
		</div>
		<div class="form-group col-md-12 row">
			{{ Form::submit('Update',['class'=>'btn btn-success']) }}
			<a class="btn btn-danger" href="{{route('store.index')}}">Back</a>
		</div>
		{{ Form::close() }}
	</div>
</div>@endsection