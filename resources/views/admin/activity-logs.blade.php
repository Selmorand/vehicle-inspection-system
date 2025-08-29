@extends('layouts.app')

@section('title', 'Activity Logs - Admin Only')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-shield-lock"></i> Activity Logs 
                        <span class="badge bg-white text-danger">Admin Only</span>
                    </h3>
                </div>
                
                <!-- Statistics Cards -->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Activity Today</h5>
                                    <h2>{{ $stats['total_today'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>Unique Visitors</h5>
                                    <h2>{{ $stats['unique_visitors_today'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Failed Logins</h5>
                                    <h2>{{ $stats['failed_logins_today'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Active Users</h5>
                                    <h2>{{ $stats['active_users_today'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.activity-logs') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="date_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Time</option>
                                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week</option>
                                    <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="user_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user }}" {{ request('user_filter') == $user ? 'selected' : '' }}>
                                            {{ $user }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="action_filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Actions</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action_filter') == $action ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $action)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="visitors_only" value="1" class="form-check-input" 
                                           {{ request('visitors_only') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label">Visitors Only (Non-logged in)</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Activity Logs Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Device</th>
                                    <th>Browser</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr class="{{ !$log->user_id ? 'table-warning' : '' }}">
                                        <td>
                                            <small>{{ $log->created_at->format('Y-m-d H:i:s') }}</small>
                                            <br>
                                            <span class="text-muted">{{ $log->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td>
                                            @if($log->user_id)
                                                <strong>{{ $log->user_name }}</strong>
                                                <br>
                                                <small>{{ $log->user_email }}</small>
                                            @else
                                                <span class="badge bg-warning text-dark">Anonymous Visitor</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->user_role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($log->user_role == 'inspector')
                                                <span class="badge bg-primary">Inspector</span>
                                            @else
                                                <span class="badge bg-secondary">Visitor</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $actionColors = [
                                                    'login_success' => 'success',
                                                    'login_attempt' => 'danger',
                                                    'logout' => 'info',
                                                    'page_view' => 'secondary',
                                                    'view_report' => 'primary',
                                                    'admin_access' => 'warning',
                                                ];
                                                $color = $actionColors[$log->action] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                            </span>
                                        </td>
                                        <td>{{ $log->description }}</td>
                                        <td>
                                            <code>{{ $log->ip_address }}</code>
                                        </td>
                                        <td>
                                            <i class="bi bi-{{ $log->device == 'mobile' ? 'phone' : ($log->device == 'tablet' ? 'tablet' : 'laptop') }}"></i>
                                            {{ ucfirst($log->device) }}
                                        </td>
                                        <td>{{ $log->browser }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No activity logs found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $logs->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                    
                    <!-- Export Button (Super Admin Only) -->
                    @if(auth()->user()->is_super_admin ?? false)
                        <div class="mt-3">
                            <form action="{{ route('admin.activity-logs.export') }}" method="GET" class="d-inline">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-download"></i> Export to CSV
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection