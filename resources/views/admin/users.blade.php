@extends('layouts.app')

@section('title', 'User Management - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">User Management</h4>
                        <small>Manage system users and permissions</small>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3">
                                                        {{ substr($user->name, 0, 2) }}
                                                    </div>
                                                    {{ $user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge bg-danger">Admin</span>
                                                @elseif($user->role === 'inspector')
                                                    <span class="badge bg-warning">Inspector</span>
                                                @else
                                                    <span class="badge bg-info">User</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <form method="POST" 
                                                              action="{{ route('admin.users.delete', $user->id) }}" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No users found</h5>
                            <p class="text-muted">Start by adding your first user to the system.</p>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Add First User
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 14px;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.btn-group .btn {
    margin-right: 5px;
}

.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}
</style>
@endsection