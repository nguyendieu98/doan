@extends('admin.layout.main')
@section('title','Create User')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li> 
		<li class="breadcrumb-item" ><a href="{{route('user.index')}}" title="Danh mục">User</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div> 
<div class="card">
	<div class="card-body "> 
		<div class="card-body">
			<form method="POST" action="{{ url('/admin/register') }}">
				@csrf 
				<div class="form-group col-md-6 {{ $errors->has('first_name') ?'has-error':'' }}">
					{{ Form::label('first_name','First Name : ')}}
					{{ Form::text('first_name','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('first_name')}}</span>
				</div> 
				<div class="form-group col-md-6 {{ $errors->has('last_name') ?'has-error':'' }}">
					{{ Form::label('last_name','Last Name : ')}}
					{{ Form::text('last_name','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('last_name')}}</span>
				</div>
				<div class="form-group col-md-6 {{ $errors->has('address') ?'has-error':'' }}">
					{{ Form::label('address','Address : ')}}
					{{ Form::text('address','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('address')}}</span>
				</div>
				<div class="form-group col-md-6 {{ $errors->has('phone') ?'has-error':'' }}">
					{{ Form::label('phone','Phone : ')}}
					{{ Form::text('phone','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('phone')}}</span>
				</div>  
				<div class="form-group col-md-6 {{ $errors->has('username') ?'has-error':'' }}">
					{{ Form::label('username','Username : ')}}
					{{ Form::text('username','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('username')}}</span>
				</div> 
				<div class="form-group col-md-6 {{ $errors->has('email') ?'has-error':'' }}">
					{{ Form::label('email','Email : ')}}
					{{ Form::text('email','',['class'=>'form-control'])}}
					<span class="text-danger">{{ $errors->first('email')}}</span>
				</div> 
				<div class="form-group col-md-6 {{ $errors->has('password') ?'has-error':'' }}">
					{{ Form::label('password','Password : ')}} 
					<input type="password" class="form-control" name="password">
					<span class="text-danger">{{ $errors->first('password')}}</span>
				</div>  
				<div class="form-group col-md-6 {{ $errors->has('confirm_password') ?'has-error':'' }}">
					{{ Form::label('confirm_password','Confirm Password : ')}} 
					<input type="password" class="form-control" name="confirm_password">
					<span class="text-danger">{{ $errors->first('confirm_password')}}</span>
				</div>  
				<div class="form-group col-md-6">
					{{Form::label('Roles:')}}
					{{Form::select('role_id[]',$roles,null,['class' => 'form-control roles', 'multiple'=>'multiple'])}}   
				</div>
				<div class="form-group col-md-12"> 
					{{ Form::submit('Save',['class'=>'btn btn-success']) }}
					<a class="btn btn-danger" href="{{route('user.index')}}">Back</a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('.roles').select2();
</script>
@endsection