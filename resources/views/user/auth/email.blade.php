@extends('user.layout.main')
@section('title', 'Reset password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="reset_pass_form">
            <div class="card-header">
                <h2>Reset Password</h2>
            </div>
            <div class="line_green"></div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="control-label">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-success">Send Password Reset Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
