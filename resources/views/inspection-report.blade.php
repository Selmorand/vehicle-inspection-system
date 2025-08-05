@extends('layouts.app')

@section('title', 'Inspection Report')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Vehicle Inspection Report</h2>
                <div>
                    <button class="btn btn-primary me-2" onclick="generatePDF()">
                        <i class="bi bi-file-pdf"></i> Generate & Save PDF
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list"></i> View All Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Preview -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Report Preview</h5>
            <small class="text-muted">This is a preview of your inspection data. Click "Generate PDF" to create a professional report.</small>
        </div>
        <div class="card-body" id="reportPreview">
            <div class="text-center text-muted">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading report data...</span>
                </div>
                <p class="mt-2">Loading inspection data...</p>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Inspection Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="emailForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="clientEmail" class="form-label">Client Email *</label>
                        <input type="email" class="form-control" id="clientEmail" name="client_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientName" class="form-label">Client Name *</label>
                        <input type="text" class="form-control" id="clientName" name="client_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" 
                               placeholder="Vehicle Inspection Report - [Auto-generated]">
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Personal Message (Optional)</label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="3" 
                                placeholder="Add a personal message to accompany the report..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send"></i> Send Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('additional-css')
<style>
.report-preview {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.section-title {
    color: #4f959b;
    border-bottom: 2px solid #4f959b;
    padding-bottom: 8px;
    margin-bottom: 15px;
}

.info-table {
    width: 100%;
    margin-bottom: 20px;
}

.info-table td {
    padding: 8px;
    border: 1px solid #dee2e6;
}

.info-table .label {
    background-color: #f8f9fa;
    font-weight: bold;
    width: 25%;
}

.condition-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: bold;
}

.condition-good { background-color: #d4edda; color: #155724; }
.condition-average { background-color: #fff3cd; color: #856404; }
.condition-bad { background-color: #f8d7da; color: #721c24; }

@media print {
    .btn, .modal { display: none !important; }
}
</style>
@endsection

@section('additional-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadReportPreview();
    
    // Pre-fill email form with stored data
    const visualData = JSON.parse(sessionStorage.getItem('visualInspectionData') || '{}');
    if (visualData.clientName) {
        document.getElementById('clientName').value = visualData.clientName;
    }
    if (visualData.email) {
        document.getElementById('clientEmail').value = visualData.email;
    }
});

function loadReportPreview() {
    // Collect all session data
    const allData = {
        visual: JSON.parse(sessionStorage.getItem('visualInspectionData') || '{}'),
        bodyPanel: JSON.parse(sessionStorage.getItem('panelAssessmentData') || '{}'),
        interior: JSON.parse(sessionStorage.getItem('interiorAssessmentData') || '{}'),
        service: JSON.parse(sessionStorage.getItem('serviceBookletData') || '{}'),
        tyres: JSON.parse(sessionStorage.getItem('tyresRimsData') || '{}'),
        mechanical: JSON.parse(sessionStorage.getItem('mechanicalReportData') || '{}'),
        engine: JSON.parse(sessionStorage.getItem('engineCompartmentData') || '{}'),
        hoist: JSON.parse(sessionStorage.getItem('physicalHoistData') || '{}')
    };
    
    // Generate preview HTML
    let previewHTML = generatePreviewHTML(allData);
    document.getElementById('reportPreview').innerHTML = previewHTML;
}

function generatePreviewHTML(data) {
    let html = '<div class="report-preview">';
    
    // Header
    html += '<div class="text-center mb-4">';
    html += '<h1 style="color: #4f959b;">ALPHA VEHICLE INSPECTION</h1>';
    html += '<p class="lead">Professional Vehicle Assessment Report</p>';
    html += '<p><small>Generated: ' + new Date().toLocaleString() + '</small></p>';
    html += '</div>';
    
    // Vehicle & Client Info
    if (data.visual.clientName || data.visual.vehicleMake) {
        html += '<h3 class="section-title">Vehicle & Client Information</h3>';
        html += '<table class="info-table">';
        html += '<tr><td class="label">Client Name</td><td>' + (data.visual.clientName || 'Not specified') + '</td>';
        html += '<td class="label">Contact</td><td>' + (data.visual.contactNumber || 'Not specified') + '</td></tr>';
        html += '<tr><td class="label">Vehicle</td><td>' + (data.visual.vehicleMake || '') + ' ' + (data.visual.vehicleModel || '') + '</td>';
        html += '<td class="label">Year</td><td>' + (data.visual.vehicleYear || 'Not specified') + '</td></tr>';
        html += '<tr><td class="label">VIN</td><td>' + (data.visual.vinNumber || 'Not specified') + '</td>';
        html += '<td class="label">Mileage</td><td>' + (data.visual.mileage || 'Not specified') + ' km</td></tr>';
        html += '</table>';
    }
    
    // Body Panel Assessment
    if (data.bodyPanel.assessments && Object.keys(data.bodyPanel.assessments).length > 0) {
        html += '<h3 class="section-title">Body Panel Assessment</h3>';
        html += '<table class="table table-sm">';
        html += '<thead><tr><th>Panel</th><th>Condition</th><th>Comments</th></tr></thead><tbody>';
        
        Object.entries(data.bodyPanel.assessments).forEach(([panel, assessment]) => {
            const panelName = panel.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            html += '<tr>';
            html += '<td>' + panelName + '</td>';
            html += '<td><span class="condition-badge condition-' + (assessment.condition || 'good') + '">' + 
                    (assessment.condition || 'Good') + '</span></td>';
            html += '<td>' + (assessment.comment || '-') + '</td>';
            html += '</tr>';
        });
        
        html += '</tbody></table>';
    }
    
    // Service History
    if (data.service.hasServiceHistory) {
        html += '<h3 class="section-title">Service History</h3>';
        html += '<table class="info-table">';
        html += '<tr><td class="label">Service History</td><td>' + (data.service.hasServiceHistory || 'No') + '</td>';
        html += '<td class="label">Last Service</td><td>' + (data.service.lastServiceDate || 'Not specified') + '</td></tr>';
        html += '<tr><td class="label">Service Provider</td><td>' + (data.service.serviceProvider || 'Not specified') + '</td>';
        html += '<td class="label">Next Due</td><td>' + (data.service.nextServiceDue || 'Not specified') + '</td></tr>';
        html += '</table>';
    }
    
    // Summary
    html += '<h3 class="section-title">Summary</h3>';
    html += '<div class="alert alert-info">';
    html += '<h5>Report Status</h5>';
    let sectionsCompleted = 0;
    const totalSections = 8;
    
    if (Object.keys(data.visual).length > 0) sectionsCompleted++;
    if (Object.keys(data.bodyPanel).length > 0) sectionsCompleted++;
    if (Object.keys(data.interior).length > 0) sectionsCompleted++;
    if (Object.keys(data.service).length > 0) sectionsCompleted++;
    if (Object.keys(data.tyres).length > 0) sectionsCompleted++;
    if (Object.keys(data.mechanical).length > 0) sectionsCompleted++;
    if (Object.keys(data.engine).length > 0) sectionsCompleted++;
    if (Object.keys(data.hoist).length > 0) sectionsCompleted++;
    
    html += '<p><strong>Sections Completed:</strong> ' + sectionsCompleted + ' of ' + totalSections + '</p>';
    html += '<p>This preview shows the data that will be included in your PDF report. ';
    html += 'Complete more inspection sections to generate a comprehensive report.</p>';
    html += '</div>';
    
    html += '</div>';
    
    return html;
}

function generatePDF() {
    // Create form with all session data
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/inspection/report/pdf';
    form.style.display = 'none';
    
    // Add CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.content;
        form.appendChild(csrfInput);
    }
    
    // Add all session data as form fields
    const allData = {
        visual: JSON.parse(sessionStorage.getItem('visualInspectionData') || '{}'),
        bodyPanel: JSON.parse(sessionStorage.getItem('panelAssessmentData') || '{}'),
        interior: JSON.parse(sessionStorage.getItem('interiorAssessmentData') || '{}'),
        service: JSON.parse(sessionStorage.getItem('serviceBookletData') || '{}'),
        tyres: JSON.parse(sessionStorage.getItem('tyresRimsData') || '{}'),
        mechanical: JSON.parse(sessionStorage.getItem('mechanicalReportData') || '{}'),
        engine: JSON.parse(sessionStorage.getItem('engineCompartmentData') || '{}'),
        hoist: JSON.parse(sessionStorage.getItem('physicalHoistData') || '{}')
    };
    
    // Flatten data into form fields
    addDataToForm(form, allData.visual, '');
    addDataToForm(form, { body_panel_data: JSON.stringify(allData.bodyPanel) }, '');
    addDataToForm(form, { interior_data: JSON.stringify(allData.interior) }, '');
    addDataToForm(form, allData.service, '');
    addDataToForm(form, allData.tyres, '');
    addDataToForm(form, allData.mechanical, '');
    addDataToForm(form, allData.engine, '');
    addDataToForm(form, allData.hoist, '');
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function addDataToForm(form, data, prefix) {
    for (const [key, value] of Object.entries(data)) {
        if (value !== null && value !== undefined && value !== '') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = prefix + key;
            input.value = value;
            form.appendChild(input);
        }
    }
}

function showEmailModal() {
    const modal = new bootstrap.Modal(document.getElementById('emailModal'));
    modal.show();
}

// Handle email form submission
document.getElementById('emailForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Add all session data
    const allData = {
        visual: JSON.parse(sessionStorage.getItem('visualInspectionData') || '{}'),
        bodyPanel: JSON.parse(sessionStorage.getItem('panelAssessmentData') || '{}'),
        interior: JSON.parse(sessionStorage.getItem('interiorAssessmentData') || '{}'),
        service: JSON.parse(sessionStorage.getItem('serviceBookletData') || '{}'),
        tyres: JSON.parse(sessionStorage.getItem('tyresRimsData') || '{}'),
        mechanical: JSON.parse(sessionStorage.getItem('mechanicalReportData') || '{}'),
        engine: JSON.parse(sessionStorage.getItem('engineCompartmentData') || '{}'),
        hoist: JSON.parse(sessionStorage.getItem('physicalHoistData') || '{}')
    };
    
    // Add session data to form
    Object.entries(allData.visual).forEach(([key, value]) => {
        if (value) formData.append(key, value);
    });
    formData.append('body_panel_data', JSON.stringify(allData.bodyPanel));
    formData.append('interior_data', JSON.stringify(allData.interior));
    Object.entries(allData.service).forEach(([key, value]) => {
        if (value) formData.append(key, value);
    });
    
    // Add CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        formData.append('_token', csrfToken.content);
    }
    
    try {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
        
        const response = await fetch('/inspection/report/email', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Report sent successfully!');
            bootstrap.Modal.getInstance(document.getElementById('emailModal')).hide();
        } else {
            alert('Failed to send report: ' + result.message);
        }
    } catch (error) {
        alert('Error sending report: ' + error.message);
    } finally {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-send"></i> Send Report';
    }
});
</script>
@endsection