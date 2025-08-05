@extends('layouts.app')

@section('title', 'Inspector Dashboard')

@section('content')
<div class="container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="display-4">ALPHA Vehicle Inspection System</h1>
        <p class="lead">Inspector Dashboard</p>
    </div>

    <!-- Action Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card action-card h-100">
                <div class="card-body">
                    <h5 class="card-title">New Inspection</h5>
                    <p class="card-text">Start a new vehicle inspection report. Capture photos, fill out forms, and generate professional reports.</p>
                    <a href="{{ url('/inspection/visual') }}" class="btn btn-primary">Start New Inspection</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card action-card h-100">
                <div class="card-body">
                    <h5 class="card-title">View All Reports</h5>
                    <p class="card-text">Browse all completed inspections. Search by VIN, client name, date, or inspector.</p>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">View Reports</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card action-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Quick Search</h5>
                    <p class="card-text">Find a specific inspection report quickly using various search criteria.</p>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Search Reports</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="recent-reports">
        <h2>Recent Inspections</h2>
        
        <div class="report-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="report-info">
                    <h6 class="mb-1">VIN: 1HGBH41JXMN109186</h6>
                    <small class="text-muted">Client: John Smith | Date: June 14, 2025 | Inspector: Demo User</small>
                </div>
                <span class="badge bg-success report-status">Completed</span>
            </div>
        </div>

        <div class="report-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="report-info">
                    <h6 class="mb-1">VIN: 2T1BURHE0JC014242</h6>
                    <small class="text-muted">Client: Sarah Johnson | Date: June 13, 2025 | Inspector: Demo User</small>
                </div>
                <span class="badge bg-success report-status">Completed</span>
            </div>
        </div>

        <div class="report-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="report-info">
                    <h6 class="mb-1">VIN: 5YFBURHE0JP123456</h6>
                    <small class="text-muted">Client: Mike Wilson | Date: June 12, 2025 | Inspector: Demo User</small>
                </div>
                <span class="badge bg-warning report-status">In Progress</span>
            </div>
        </div>
    </div>
</div>
@endsection