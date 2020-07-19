@extends('admin.layout.app')
@section('title','Login')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-5 col-sm-offset-4">
			<div class="admin_login_form">
				<form method="POST" action="{{ url('/admin/login') }}">
					<div class="card-header"><h2 class="text-center">Login</h2></div>
					@csrf
					<div class="form-group">							
						<input id="username" type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" autofocus>					
						<strong class="text-danger">{{ $errors->first('username')}}</strong> 
					</div>
					<div class="form-group">
						<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password">
						<strong class="text-danger">{{ $errors->first('password') }}</strong>
						@if (Session::has('err'))
						<span class="invalid-feedback text-danger"><strong>{{ Session::get('err')}}</strong></span>
						@endif
					</div>
					<div class="form-group">							
						<button type="submit" class="btn btn-block login_button">LOGIN</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection