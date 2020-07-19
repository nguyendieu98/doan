@extends('user.layout.main')
@section('title','Reset password')
@section('content')
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">Home</a><span>/</span>Reset password</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="reset_pass_form">
				<h2>Reset your password</h2>
				<div class="line_green"></div>
				<form action="{{ route('resetpass') }}" method="POST">
					@csrf
					<div class="form-group">
						<label class="control-label">Content</label>
                    	<input id="content" type="content" class="form-control" name="content" placeholder="Content">
                    	<strong class="text-danger">{{ $errors->first('content') }}</strong>
					</div>
					
					<div class="form-group">
						<label class="control-label">Email</label>
                    	<input id="email" type="email" class="form-control" name="email" placeholder="Email">
                    	<strong class="text-danger">{{ $errors->first('email') }}</strong>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-success">Send Email</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
@endsection