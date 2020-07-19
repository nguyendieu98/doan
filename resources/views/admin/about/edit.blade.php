@extends('admin.layout.main')
@section('title','Edit About')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('about.index')}}" title="Danh mục">About</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
	<!-- <h1 style=" font-family: 'Open Sans', sans-serif; font-size: 50px; font-weight: 300; text-transform: uppercase;">About</h1> -->
</div>
<div class="card">
	<div class="card-body ">
		{{Form::open(['route'=>['about.update',$about->id],'method'=>'put','enctype '=>'multipart/form-data']) }}
		<div class="row ">
			<div class="col-md-6 row">
				<div class="form-group col-md-12 {{ $errors->has('title') ?'has-error':'' }}">
					{{ Form::label('title','Title : ')}}
					{{ Form::text('title',$about->title,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('title')}}</span>
				</div>
				<div class="form-group col-md-12 {{ $errors->has('name') ?'has-error':'' }}">
					{{ Form::label('name','Name : ')}}
					{{ Form::text('name',$about->name,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('name')}}</span>
				</div>
				<div class="form-group col-md-12 {{ $errors->has('content') ?'has-error':'' }}">
					{{ Form::label('content','Content: ')}}
					<br>
					{{ Form::textarea('content',$about->content,['id'=>'editor'])}}
					<br>
					<span class="text-danger">{{ $errors->first('content')}}</span>
				</div>
			</div>
			<div class="col-md-6 row">
				<div class="form-group col-md-12 {{ $errors->has('phone') ?'has-error':'' }}">
					{{ Form::label('phone','Phone : ')}}
					{{ Form::text('phone',$about->phone,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('phone')}}</span>
				</div>	
				<div class="form-group col-md-12 {{ $errors->has('email') ?'has-error':'' }}">
					{{ Form::label('email','Email : ')}}
					{{ Form::text('email',$about->email,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('email')}}</span>
				</div>
				<div class="form-group col-md-12 {{ $errors->has('logo') ?'has-error':'' }}">
					{{Form::label('logo:','',['class'=>''])}}
					<input name="logoo" type="file" class="form-control" id="filename">
					{{ Form::hidden('logo', $about->logo, ['class' => 'form-control','id' => 'image_file' ]) }}
					<p id="path">{{ $about->logo }}</p>
					<span class="text-danger">{{ $errors->first('logo')}}</span>	
				</div>
				<div class="form-group col-md-12 {{ $errors->has('address') ?'has-error':'' }}">
					{{ Form::label('address','Address : ')}}
					{{ Form::text('address',$about->address,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('address')}}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{ Form::submit('Update',['class'=>'btn btn-success']) }}
			<a class="btn btn-danger" href="{{route('about.index')}}">Back</a>
		</div>
		{{ Form::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#filename').on('change',function(e){               
		value = $(this).val();
		$.ajax({
			type: 'get',
			url: '{{ URL::to('setvalue') }}',
			data: {
				value: value
			},
			success:function(data){
				document.getElementById("image_file").value = data;
				$("#path").html(data);
			}
		});
	});
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection