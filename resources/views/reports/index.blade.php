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
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="d-flex flex-wrap gap-3 align-items-end">
                    <div class="flex-fill" style="min-width: 200px;">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Vehicle, VIN, report #..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="flex-shrink-0" style="min-width: 150px;">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" 
                               value="{{ request('from_date') }}">
                    </div>
                    <div class="flex-shrink-0" style="min-width: 150px;">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" 
                               value="{{ request('to_date') }}">
                    </div>
                    <div class="d-flex gap-2 flex-shrink-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
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
                <div class="reports-grid">
                    @foreach($reports as $report)
                    <div class="report-card mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="report-heading">Report #</div>
                                        <div class="report-data">
                                            <span class="badge bg-primary">{{ $report->report_number }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="report-heading">Date</div>
                                        <div class="report-data">
                                            {{ is_string($report->inspection_date) ? $report->inspection_date : $report->inspection_date->format('Y-m-d') }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="report-heading">Vehicle</div>
                                        <div class="report-data">
                                            {{ ($report->vehicle_make ?? '') . ' ' . ($report->vehicle_model ?? '') . ' ' . ($report->vehicle_year ?? '') }}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="report-heading">VIN</div>
                                        <div class="report-data">
                                            {{ $report->vin_number ?: 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="report-heading">Inspector</div>
                                        <div class="report-data">
                                            {{ $report->inspector_name ?: 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="report-actions">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('reports.show', $report->id) }}" 
                                                   class="btn btn-sm btn-primary action-btn" 
                                                   title="View Web Report">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('reports.pdf', $report->id) }}" 
                                                   class="btn btn-sm btn-secondary action-btn" 
                                                   title="Download PDF Report"
                                                   target="_blank">
                                                    <i class="bi bi-file-pdf"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-success action-btn" 
                                                        title="Email Report"
                                                        onclick="openEmailModal({{ $report->id }}, '{{ $report->report_number }}', '{{ $report->client_email ?? '' }}')">
                                                    <i class="bi bi-envelope"></i>
                                                </button>
                                                <form action="{{ route('reports.destroy', $report->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this report?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger action-btn"
                                                            title="Delete Report">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #4f959b; color: white !important;">
                <h5 class="modal-title" id="emailModalLabel" style="color: white !important;">
                    <i class="bi bi-envelope"></i> Email Inspection Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="mb-3">
                        <label class="form-label">Report Number</label>
                        <input type="text" class="form-control" id="reportNumber" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="recipientEmail" class="form-label">Recipient Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control" 
                               id="recipientEmail" 
                               placeholder="client@example.com"
                               required>
                        <div class="form-text">Enter the email address where the report should be sent</div>
                    </div>
                    <div class="mb-3">
                        <label for="customMessage" class="form-label">Custom Message (Optional)</label>
                        <textarea class="form-control" 
                                  id="customMessage" 
                                  rows="3" 
                                  placeholder="Add a personal message to include in the email..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="sendEmail()" id="sendEmailBtn">
                    <i class="bi bi-send"></i> Send Email
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert (Hidden by default) -->
<div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" 
     style="z-index: 9999; display: none;" 
     id="successAlert">
    <i class="bi bi-check-circle"></i> <span id="successMessage"></span>
    <button type="button" class="btn-close" onclick="hideSuccessAlert()"></button>
</div>

@endsection

@section('additional-css')
<style>
.report-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.report-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.report-card .card-body {
    padding: 1rem;
}

.report-card .row > div {
    margin-bottom: 0.5rem;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

/* Card header styling */
.card-header h5 {
    color: #4f959b !important;
}

/* Report card layout styling */
.report-heading {
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.report-data {
    font-size: 0.9rem;
    color: #212529;
    margin-bottom: 0.5rem;
}

/* Ensure action buttons are consistent size */
.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.action-btn i {
    font-size: 0.875rem;
}

/* Search form responsive improvements */
@media (max-width: 992px) {
    .d-flex.flex-wrap.gap-3 {
        flex-direction: column;
        align-items: stretch !important;
    }
    
    .d-flex.gap-2.flex-shrink-0 {
        justify-content: stretch;
    }
    
    .d-flex.gap-2.flex-shrink-0 .btn {
        flex: 1;
    }
}

@media (max-width: 768px) {
    .report-card .row > div {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .report-actions .d-flex {
        justify-content: center !important;
    }
    
    .action-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 576px) {
    .report-card .col-md-1,
    .report-card .col-md-2,
    .report-card .col-md-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>
@endsection

@section('additional-js')
<script>
let currentReportId = null;

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

function openEmailModal(reportId, reportNumber, clientEmail = '') {
    currentReportId = reportId;
    document.getElementById('reportNumber').value = reportNumber;
    document.getElementById('recipientEmail').value = clientEmail;
    document.getElementById('customMessage').value = '';
    
    // Enable the send button
    document.getElementById('sendEmailBtn').disabled = false;
    document.getElementById('sendEmailBtn').innerHTML = '<i class="bi bi-send"></i> Send Email';
    
    // Show the modal
    new bootstrap.Modal(document.getElementById('emailModal')).show();
}

async function sendEmail() {
    const recipientEmail = document.getElementById('recipientEmail').value;
    const customMessage = document.getElementById('customMessage').value;
    const sendBtn = document.getElementById('sendEmailBtn');
    
    if (!recipientEmail) {
        alert('Please enter a recipient email address');
        return;
    }
    
    // Disable button and show loading
    sendBtn.disabled = true;
    sendBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Sending...';
    
    try {
        const response = await fetch(`/api/reports/email/${currentReportId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: recipientEmail,
                message: customMessage
            })
        });
        
        let result;
        try {
            result = await response.json();
        } catch (jsonError) {
            throw new Error('Invalid server response');
        }
        
        if (response.ok && result.success) {
            // Hide modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('emailModal'));
            if (modal) modal.hide();
            
            // Debug: Check if elements exist
            console.log('Success alert element:', document.getElementById('successAlert'));
            console.log('Success message element:', document.getElementById('successMessage'));
            
            // Show success alert
            showSuccessAlert('Email sent successfully! The report has been delivered.');
            
            // Reset button
            sendBtn.innerHTML = '<i class="bi bi-send"></i> Send Email';
            sendBtn.className = 'btn btn-success';
            sendBtn.disabled = false;
            
            return; // Exit the function successfully
        } else {
            throw new Error(result.error || 'Failed to send email');
        }
    } catch (error) {
        console.error('Email error:', error);
        
        // Simple error display - change button to show error
        sendBtn.innerHTML = '❌ Error: ' + error.message.substring(0, 20);
        sendBtn.className = 'btn btn-danger';
        
        // Reset after 3 seconds
        setTimeout(() => {
            sendBtn.innerHTML = '<i class="bi bi-send"></i> Send Email';
            sendBtn.className = 'btn btn-success';
            sendBtn.disabled = false;
        }, 3000);
    }
}

function showSuccessAlert(message) {
    console.log('showSuccessAlert called with message:', message);
    
    const alert = document.getElementById('successAlert');
    const messageElement = document.getElementById('successMessage');
    
    console.log('Alert element found:', !!alert);
    console.log('Message element found:', !!messageElement);
    
    if (!alert || !messageElement) {
        console.error('Success alert elements not found - creating dynamic alert');
        
        // Create a dynamic success alert at the top of the page
        const dynamicAlert = document.createElement('div');
        dynamicAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        dynamicAlert.style.cssText = 'top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 500px;';
        dynamicAlert.innerHTML = `
            <i class="bi bi-check-circle"></i> ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(dynamicAlert);
        
        // Auto-hide after 4 seconds
        setTimeout(() => {
            if (dynamicAlert && dynamicAlert.parentNode) {
                dynamicAlert.remove();
            }
        }, 4000);
        
        return;
    }
    
    messageElement.textContent = message;
    alert.style.display = 'block';
    alert.style.opacity = '1';
    
    // Auto-hide after 4 seconds minimum
    setTimeout(() => {
        hideSuccessAlert();
    }, 4000);
}

function hideSuccessAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.display = 'none';
        alert.style.opacity = '0';
    }
}
</script>
@endsection