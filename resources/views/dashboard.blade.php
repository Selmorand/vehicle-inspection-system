@extends('layouts.app')

@section('title', 'Inspector Dashboard')

@section('content')
<div class="container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="display-4">ALPHA Vehicle Inspection System</h1>
        <p class="lead">Inspector Dashboard</p>
    </div>

    <!-- Inspection Type Selection -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6 col-md-12">
            <div class="card action-card h-100 border-primary">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-file-text display-4 text-primary"></i>
                    </div>
                    <h4 class="card-title text-primary">Condition Report</h4>
                    <p class="card-text">Standard vehicle condition assessment. Covers visual inspection, body panels, interior, service history, tyres, mechanical systems, and engine compartment.</p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <strong>Steps:</strong> Visual → Body Panels → Interior → Service Booklet → Tyres & Rims → Mechanical Report → Engine Compartment
                        </small>
                    </div>
                    <a href="{{ url('/inspection/visual') }}" class="btn btn-primary btn-lg" onclick="clearInspectionData(); setInspectionType('condition')">
                        <i class="bi bi-play-circle me-2"></i>Start Condition Report
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card action-card h-100 border-success">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-gear-wide-connected display-4 text-success"></i>
                    </div>
                    <h4 class="card-title text-success">Technical Inspection</h4>
                    <p class="card-text">Comprehensive technical assessment including all condition report items PLUS detailed physical hoist inspection of suspension, engine, and drivetrain systems.</p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <strong>Steps:</strong> All Condition Report steps + Physical Hoist Inspection
                        </small>
                    </div>
                    <a href="{{ url('/inspection/visual') }}" class="btn btn-success btn-lg" onclick="clearInspectionData(); setInspectionType('technical')">
                        <i class="bi bi-tools me-2"></i>Start Technical Inspection
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Actions -->
    <div class="row g-4 mb-5">
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

        <div class="col-lg-4 col-md-6">
            <div class="card action-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Inspection Statistics</h5>
                    <p class="card-text">View inspection completion rates, average times, and performance metrics.</p>
                    <a href="#" class="btn btn-secondary">View Stats</a>
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

@section('additional-js')
<script>
function clearInspectionData() {
    // Clear all inspection session data when starting a new inspection
    sessionStorage.removeItem('currentInspectionId');
    sessionStorage.removeItem('visualInspectionData');
    sessionStorage.removeItem('visualInspectionImages');
    sessionStorage.removeItem('bodyPanelAssessmentData');
    sessionStorage.removeItem('bodyPanelAssessmentImages');
    sessionStorage.removeItem('interiorAssessmentData');
    sessionStorage.removeItem('interiorAssessmentImages');
    sessionStorage.removeItem('serviceBookletData');
    sessionStorage.removeItem('tyresRimsData');
    sessionStorage.removeItem('mechanicalReportData');
    sessionStorage.removeItem('engineCompartmentData');
    sessionStorage.removeItem('physicalHoistData');
    sessionStorage.removeItem('inspectionType');
    
    console.log('Inspection data cleared for new inspection');
}

function setInspectionType(type) {
    // Set the inspection type so forms know what workflow to follow
    sessionStorage.setItem('inspectionType', type);
    
    console.log('Inspection type set to:', type);
    
    // Show appropriate message
    if (type === 'condition') {
        console.log('Starting Condition Report - ends at Engine Compartment');
    } else if (type === 'technical') {
        console.log('Starting Technical Inspection - includes Physical Hoist');
    }
}
</script>
@endsection