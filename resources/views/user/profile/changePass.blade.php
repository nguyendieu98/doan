@extends('user.layout.main')
@section('title',__('profileUser.editpass'))
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                    <form class="form-horizontal" method="POST" action="{{ route('changepassword') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('editpass.currentpassword')}}</label>
                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control" name="current_password">
                                <strong class="text-danger">{{ $errors->first('current_password') }}</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('editpass.newpassword')}}</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password">
                                <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{__('editpass.cfnewpassword')}}</label>
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password">
                                <strong class="text-danger">{{ $errors->first('new_confirm_password') }}</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">{{__('editpass.editpass')}}</button>
                                <a href="{{ url('/profile') }}" class="btn btn-danger">{{__('editpass.back')}}</a>
                            </div>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection