@extends('layouts.app')

@section('content')
    <div class="card w-50 mx-auto">
        <div class="card-header">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" placeholder="name@example.com"
                        type="email" value="{{ old('email') }}">
                    <label for="floatingInput">Email address</label>
                    @error('email')
                        <span class="text-danger"><small>** {{ $message }}</small></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" placeholder="Password"
                        type="password">
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <span class="text-danger"><small>** {{ $message }}</small></span>
                    @enderror
                </div>

                <div class="form-check form-check-inline mb-3">
                    <input class="form-check-input" id="inlineCheckbox1" name="remember_me" type="checkbox">
                    <label class="form-check-label" for="inlineCheckbox1">Remember me</label>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <span class="ms-3">
                        Or
                        <a href="">Forget Password?</a>
                    </span>
                </div>

                <div class="text-center">
                    <a class="text-decoration-none" href="{{ route('register') }}">Create an account</a>
                </div>
                <div class="my-3 text-center">Or Login With</div>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-success" href="">
                        Google <i class="fa-brands fa-google"></i>
                    </a>
                    <a class="btn btn-primary" href="/auth/facebook/redirect">
                        Facebook <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a class="btn btn-secondary" href="/auth/github/redirect">
                        Github <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
