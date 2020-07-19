@extends('admin.layout.main')
@section('title','Change password')
@section('content')
<div class="row">
    <div class="col-md-7 col-md-offset-2">
    	<h2 class="text-center">Change your password</h2>
        <div class="panel panel-default mt-50">
            <div class="panel-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Form -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.changepass') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-4 control-label">Current Password</label>
                        <div class="col-md-6">
                            <input id="current_password" type="password" class="form-control" name="current_password">
                            <strong class="text-danger">{{ $errors->first('current_password') }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">New Password</label>
                        <div class="col-md-6">
                            <input id="new_password" type="password" class="form-control" name="new_password">
                            <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Confirm New Password</label>
                        <div class="col-md-6">
                            <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password">
                            <strong class="text-danger">{{ $errors->first('new_confirm_password') }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success">Change Password</button>
                            <a href="{{ url('/admin/home') }}" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>
@endsection