@extends('admin.layout.main')
@section('title','Banner')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Banner</li>
	</ol>
</div>
<div class="row ml-1">
	@if (Session::has('message'))
	<p class="alert alert-success notification">{{ Session::get('message')}}</p> 
	@elseif(Session::has('err'))    
	<p class="alert alert-danger notification">{{ Session::get('err')}}</p>
	@endif
</div>
<div class="card">
	<div class="card-body ">
		<div class="row">
			<div class="col-md-9">
				<a href="{{route('banner.create')}}" class="btn btn-outline-success mb-2 mt-2">Create New</a>
			</div>
			<div class="col-md-3"> 	
			</div>
		</div>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th >#</th>
					<th >Link</th>
					<th >Url img</th>
					<th >IsDisplay</th>
					<th colspan="5">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($banners as $key => $banner)
					<tr>
						<td >{{ ++$key }}</td>
						<td>{{$banner->link}}</td>
						<td><img src="{{ asset('images/'.$banner->url_img) }}" width="80" height=></img>
						</td>
						@if($banner->isdisplay)
						<td><span class="label label-success" style="font-size: 13px;">Display</span></td>
						@else
						<td><span class="label label-danger" style="font-size: 13px;">Hidden</span></td>
						@endif
						<td colspan="5">
							<!-- Button trigger modal -->
							<!-- Tạo data-id để chưa giá trị id -->
							<button type="button" class="fas fa-trash-alt deleteUser text-danger btn" data-id="{{$banner->id}}" data-toggle="modal" data-target="#Modal" style="width: 40px; padding: 7px 5px;">
							</button>
							<a href="{{route('banner.edit',$banner->id)}}" class="ml-1 btn" style="width:40px; padding: 4px;background: #f0f0f0;"><i class="fa fa-edit "></i></a>
						</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
</div>
{{Form::open(['route' => 'banner_delete_modal', 'method' => 'POST', 'class'=>'col-md-5'])}}
{{ method_field('DELETE') }}
{{ csrf_field() }}
<!-- Modal -->
@include('admin.Modal.delete')
{{ Form::close() }}
@endsection