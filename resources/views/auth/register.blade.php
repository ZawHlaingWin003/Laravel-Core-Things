@extends('layouts.app')

@section('content')
<div class="card w-50 mx-auto">
    <div class="card-header">
        <h4>Register</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="John Doe" value="{{ old('name') }}">
                <label for="floatingInput">Name</label>
                @error('name')
                    <span class="text-danger"><small>**{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                <label for="floatingInput">Email address</label>
                @error('email')
                    <span class="text-danger"><small>**{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="floatingInput" placeholder="09283747832" value="{{ old('phone') }}">
                <label for="floatingInput">Phone</label>
                @error('phone')
                    <span class="text-danger"><small>**{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                @error('password')
                    <span class="text-danger"><small>**{{ $message }}</small></span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password_confirmation" class="form-control" id="floatingPassword" placeholder="Confirm Password">
                <label for="floatingPassword">Confirm Password</label>
            </div>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input @error('agree_term') is-invalid @enderror" name="agree_term" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                @error('agree_term')
                    <p class="text-danger"><small>**{{ $message }}</small></p>
                @enderror
            </div>
            <div class="mb-3">
                <button class="btn btn-primary">Submit</button>
                <a href="{{ route('login') }}" class="float-end">Already a member?</a>
            </div>
        </form>
    </div>
</div>
@endsection
