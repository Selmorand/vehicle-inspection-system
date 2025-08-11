@extends('layouts.app')

@section('title', 'Inspection Reports')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Inspection Reports</h2>
                <a href="{{ route('inspection.visual') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> New Inspection
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        <strong>Success:</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle"></i>
        <strong>Info:</strong> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Client name, vehicle, VIN, report #..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" 
                           value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" 
                           value="{{ request('to_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Reports</h5>
            @if($reports->count() > 0)
            <form action="{{ route('reports.destroy-all') }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('⚠️ WARNING: This will permanently delete ALL reports and associated images. This action cannot be undone. Are you absolutely sure you want to proceed?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash3"></i> Clear All Reports
                </button>
            </form>
            @endif
        </div>
        <div class="card-body">
            @if($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Report #</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Vehicle</th>
                                <th>VIN</th>
                                <th>Inspector</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $report->report_number }}</span>
                                </td>
                                <td>{{ is_string($report->inspection_date) ? $report->inspection_date : $report->inspection_date->format('Y-m-d') }}</td>
                                <td>
                                    {{ $report->client_name }}
                                    @if($report->client_email)
                                        <br><small class="text-muted">{{ $report->client_email }}</small>
                                    @endif
                                </td>
                                <td>{{ ($report->vehicle_make ?? '') . ' ' . ($report->vehicle_model ?? '') . ' ' . ($report->vehicle_year ?? '') }}</td>
                                <td>
                                    <small>{{ $report->vin_number ?: 'N/A' }}</small>
                                </td>
                                <td>{{ $report->inspector_name ?: 'N/A' }}</td>
                                <td>
                                    <small class="text-muted">{{ $report->formatted_file_size ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('reports.show', $report->id) }}" 
                                           class="btn btn-sm btn-primary" 
                                           title="View Web Report">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <form action="{{ route('reports.destroy', $report->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this report?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete Report">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($reports, 'withQueryString'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $reports->withQueryString()->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-pdf" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="mt-3 text-muted">No reports found.</p>
                    <a href="{{ route('inspection.visual') }}" class="btn btn-primary">
                        Start New Inspection
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('additional-css')
<style>
.table td {
    vertical-align: middle;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .btn-group .btn {
        width: 100%;
    }
}
</style>
@endsection

@section('additional-js')
<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection