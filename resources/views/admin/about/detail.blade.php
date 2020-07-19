@extends('admin.layout.main')
@section('title','Detail About')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('brand.index')}}" title="Danh mục">About</a></li>
	</ol>
	<!-- <h1 style=" font-family: 'Open Sans', sans-serif; font-size: 50px; font-weight: 300; text-transform: uppercase;">About</h1> -->
</div>
<div class="card">
	<div class="card-body">
		<div class="ml-3">
			<p><b>Name: </b>{{$about->name}}</p>
			<p><b>Title: </b>{{$about->title}}</p>
			<p><b>Logo: </b><img src="{{ asset('images/'.$about->logo) }}" width="80" height=></img></p>
			<p><b>Phone Number: </b>{{$about->phone}}</p>
			<p><b>Content: </b>{!! $about->content !!}</p>
			<p><b>Email: </b>{{$about->email}}</p>
			<p><b>Adress: </b>{{$about->address}}</p>
			<p><b>Created at: </b>{{$about->created_at}}</p>
			<p><b>Updated at: </b>{{$about->updated_at}}</p>
			<a class="btn btn-outline-secondary" href="{{route('about.index')}}">Back</a>
		</div>
	</div>
</div>
@endsection