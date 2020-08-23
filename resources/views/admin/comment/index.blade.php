@extends('admin.layout.main')
@section('title','Index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Comment</li>
	</ol>
	<!-- <h1 style=" font-family: 'Open Sans', sans-serif; font-size: 50px; font-weight: 300; text-transform: uppercase;">comment</h1> -->
</div>
<div class="card">
	<div class="card-body ">
		<div class="row">
			<div class="col-md-9">
				@if(count($comments) == 0)
				<a href="{{route('comment.create')}}" class="btn btn-outline-success mb-2 mt-2">Create New</a>
				@endif
			</div>
			<div class="col-md-3">
			</div>
		</div>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th >#</th>
					<th >User</th>
					<th >Comment</th>
					<th >star</th>
					<th >Product</th>
					<th >isdisplay</th>
					<th colspan="5">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr> 
					@foreach($comments as $key => $comment)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{$comment->user->username}}</td>
						<td>{!! $comment->content !!}</td>
						<td>{{$comment->star}}</td>
						<td>{{$comment->product->name}}</td>
						<td>{!! $comment->isdisplay ? '<span class="label label-success">Display</span>':'<span class="label label-danger">Hidden</span>' !!}</td>
						<td colspan="5">
							@if($comment->isdisplay)
							<button class="btn-xs btn btn-danger displaycomment" value= "{{ $comment->id }}">Hidden</button>
							@else
							<button class="btn-xs btn btn-success displaycomment" value="{{ $comment->id }}">Display</button>
							@endif
						</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script>
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}); 
	$(".displaycomment").click(function(){
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '{{ URL::to('edit_comment') }}',
			data: {
				id: id
			},
			dataType: 'JSON',
			success:function(data){     
				if (data == 1) { 
					window.location.reload();
				}
			}
		});
	});
</script>
@endsection