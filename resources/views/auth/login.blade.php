@extends('layouts.app')

@section('title', 'Login - Vehicle Inspection System')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header text-white text-center">
                    <h4 class="mb-0">Vehicle Inspection System</h4>
                    <small>Please login to continue</small>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>© {{ date('Y') }} Alpha Inspections. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
body {
    background: linear-gradient(135deg, #4f959b 0%, #28a745 100%);
}

.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    background-color: #4f959b !important;
    border-color: #4f959b !important;
}

.btn-primary {
    background: #4f959b;
    border: none;
    border-radius: 8px;
    font-weight: 600;
}

.btn-primary:hover {
    background: #3d757a;
    transform: translateY(-1px);
}

.form-control:focus {
    border-color: #4f959b;
    box-shadow: 0 0 0 0.2rem rgba(79, 149, 155, 0.25);
}
</style>
@endsection