@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white text-center py-4 border-0">
                    <h4 class="fw-bold text-dark mb-0 letter-spacing-tight">{{ __('Create Account') }}</h4>
                    <p class="text-muted small mb-0">Join MCG Projects to get started</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label text-muted small fw-bold text-uppercase">{{ __('Full Name') }}</label>
                            <input id="name" type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted small fw-bold text-uppercase">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label text-muted small fw-bold text-uppercase">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label text-muted small fw-bold text-uppercase">{{ __('Confirm') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg bg-light border-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                {{ __('Create Account') }}
                            </button>
                        </div>

                        <div class="position-relative text-center mb-4">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">OR</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('auth.google') }}" class="btn btn-light btn-lg border shadow-sm d-flex align-items-center justify-content-center gap-2 font-medium">
                                <i class="bi bi-google text-danger"></i> 
                                <span class="text-dark small">Sign up with Google</span>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light border-0 text-center py-3">
                    <p class="mb-0 text-muted small">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
