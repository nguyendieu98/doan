@extends('admin.layout.main')
@section('title','Detal Category')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('category.index')}}" title="Danh mục">Brand</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
</div>
<div class="card mt-3">
	<div class="card-body col-md-12">
		<p><b>Name : </b>{{$category->name}}</p>
		<p><b>Description : </b>{!! $category->description !!}</p>
		<p><b>Created at : </b>{{$category->created_at}}</p>
		<p><b>Updated at : </b>{{$category->updated_at}}</p>
	</div>
</div>
@endsection
