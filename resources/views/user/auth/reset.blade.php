@extends('user.layout.main')
@section('title', __('log.resetpw'))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="reset_pass_form">
            <div class="card-header">
                <h2>{{__('log.resetpw')}}</h2>
            </div>
            <div class="line_green"></div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email" class="control-label">{{trans('rspass.mail')}}</label>
                        <input id="email" class="form-control" name="email" autocomplete="email" autofocus>
                        <strong class="text-danger">{{ $errors->first('email')}}</strong>
                    </div>


                    <div class="form-group">
                        <label for="password" class="control-label">{{__('rspass.pass')}}</label>
                        <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                        <strong class="text-danger">{{ $errors->first('password')}}</strong>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="control-label">{{__('regis.Passcf')}}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        <strong class="text-danger">{{ $errors->first('password_confirmation')}}</strong>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success">{{__('log.resetpw')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection