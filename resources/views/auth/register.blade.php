@extends('layouts.app')

@section('title', 'Register New User - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Register New User</h4>
                    <small>Admin Panel - Add new system user</small>
                </div>
                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">User Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Select Role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                    User (Reports only - email, print, view)
                                </option>
                                <option value="inspector" {{ old('role') == 'inspector' ? 'selected' : '' }}>
                                    Inspector (Full inspection process + reports)
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Admin (Full access + user management)
                                </option>
                            </select>
                            @error('role')
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

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.users') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Users
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-user-plus me-2"></i>Register User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.btn-success {
    border-radius: 8px;
    font-weight: 600;
}

.btn-secondary {
    border-radius: 8px;
    font-weight: 600;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}
</style>
@endsection