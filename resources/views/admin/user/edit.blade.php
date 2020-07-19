@extends('admin.layout.main')
@section('title','Edit User')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li> 
		<li class="breadcrumb-item" ><a href="{{route('user.index')}}" title="Danh mục">User</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</div> 
<div class="card">
	<div class="card-body "> 
		<div class="card-body"> 
			{{Form::open(['route'=>['user.update',$user->id],'method'=>'put'])}}
				<input type="hidden" name="id" value="{{$user->id}}">
				<div class="form-group col-md-6 {{ $errors->has('first_name') ?'has-error':'' }}">
					{{ Form::label('first_name','First Name : ')}}
					{{ Form::text('first_name',$user->first_name,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('first_name')}}</span>
				</div> 
				<div class="form-group col-md-6 {{ $errors->has('last_name') ?'has-error':'' }}">
					{{ Form::label('last_name','Last Name : ')}}
					{{ Form::text('last_name',$user->last_name,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('last_name')}}</span>
				</div>
				<div class="form-group col-md-6 {{ $errors->has('address') ?'has-error':'' }}">
					{{ Form::label('address','Address : ')}}
					{{ Form::text('address',$user->address,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('address')}}</span>
				</div>
				<div class="form-group col-md-6 {{ $errors->has('phone') ?'has-error':'' }}">
					{{ Form::label('phone','Phone : ')}}
					{{ Form::text('phone',$user->phone,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('phone')}}</span>
				</div>   
				<div class="form-group col-md-6 {{ $errors->has('email') ?'has-error':'' }}">
					{{ Form::label('email','Email : ')}}
					{{ Form::text('email',$user->email,['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('email')}}</span>
				</div>   
				<div class="form-group col-md-6">
					{{Form::label('Roles:')}}
					{{Form::select('role_id[]',$roles,$list_roles,['class' => 'form-control roles', 'multiple'=>'multiple'])}}   
				</div>
				<div class="form-group col-md-12"> 
					{{ Form::submit('Save',['class'=>'btn btn-success']) }}
					<a class="btn btn-danger" href="{{route('user.index')}}">Back</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
<script>
	$('.roles').select2();
</script>
@endsection