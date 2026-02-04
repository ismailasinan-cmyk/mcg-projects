@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white text-center py-4 border-0">
                    <h4 class="fw-bold text-dark mb-0 letter-spacing-tight">{{ __('Welcome Back') }}</h4>
                    <p class="text-muted small mb-0">Sign in to your account to continue</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted small fw-bold text-uppercase">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label text-muted small fw-bold text-uppercase mb-0">{{ __('Password') }}</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small text-primary fw-bold" href="{{ route('password.request') }}">
                                        {{ __('Forgot?') }}
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                {{ __('Sign In') }}
                            </button>
                        </div>

                        <div class="position-relative text-center mb-4">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small">OR</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('auth.google') }}" class="btn btn-light btn-lg border shadow-sm d-flex align-items-center justify-content-center gap-2 font-medium">
                                <i class="bi bi-google text-danger"></i> 
                                <span class="text-dark small">Continue with Google</span>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light border-0 text-center py-3">
                    <p class="mb-0 text-muted small">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Create Account</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
