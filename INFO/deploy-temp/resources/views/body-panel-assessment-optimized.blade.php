@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Body Panel Assessment</h2>
            
            <form id="bodyPanelForm">
                @csrf
                
                <!-- Vehicle Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Vehicle Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="client_name" placeholder="Client Name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="vehicle_make" placeholder="Vehicle Make" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="vehicle_model" placeholder="Vehicle Model" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Interactive Body Panel Diagram -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Select Body Panels</h5>
                        <small class="text-muted">Click on panels to assess them</small>
                    </div>
                    <div class="card-body text-center">
                        <div class="vehicle-container">
                            <!-- Base vehicle image -->
                            <img src="/images/panels/FullVehicle.jpg" alt="Vehicle Base" class="base-vehicle" id="baseVehicle">
                            
                            <!-- Panel overlays with lazy loading -->
                            <!-- Windscreen -->
                            <img data-src="/images/panels/windscreen.png" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='147' height='279'%3E%3C/svg%3E"
                                 class="panel-overlay" 
                                 data-panel="windscreen" 
                                 style="position: absolute; left: 576px; top: 350px; width: 147px; height: 279px;"
                                 title="Windscreen" 
                                 alt="Windscreen">
                            
                            <!-- Rear Right Taillight -->
                            <img data-src="/images/panels/rr-taillight.png" 
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='92' height='52'%3E%3C/svg%3E"
                                 class="panel-overlay" 
                                 data-panel="rr-taillight" 
                                 style="position: absolute; left: 820px; top: 1122px; width: 92px; height: 52px;"
                                 title="RR Taillight" 
                                 alt="RR Taillight">
                            
                            <!-- Add all other panels with data-src for lazy loading -->
                            @include('partials.body-panels-lazy')
                        </div>
                    </div>
                </div>
                
                <!-- Dynamic Assessment Fields -->
                <div id="assessmentFields"></div>
                
                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Body Panel Assessment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add the image compression script -->
<script src="{{ asset('js/image-compression.js') }}"></script>

<style>
/* Optimized styles for lazy loading */
.panel-overlay {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.panel-overlay.loaded {
    opacity: 1;
}

/* Placeholder style while loading */
.panel-overlay:not(.loaded) {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Rest of your existing styles */
.vehicle-container {
    position: relative;
    display: inline-block;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
}

.base-vehicle {
    width: 100%;
    height: auto;
    display: block;
}

.panel-overlay {
    cursor: pointer;
    transition: opacity 0.3s, filter 0.3s;
    filter: brightness(1);
}

.panel-overlay:hover {
    filter: brightness(0.8) sepia(1) hue-rotate(-10deg) saturate(5);
}

.panel-overlay.highlighted {
    filter: brightness(0.6) sepia(1) hue-rotate(-10deg) saturate(8);
    opacity: 0.9;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize lazy loading for panel images
    const lazyLoader = new LazyImageLoader();
    lazyLoader.observe('.panel-overlay[data-src]');
    
    // Your existing panel interaction code
    const panels = document.querySelectorAll('.panel-overlay');
    const assessmentFields = document.getElementById('assessmentFields');
    const selectedPanels = new Set();
    
    panels.forEach(panel => {
        panel.addEventListener('click', function() {
            const panelId = this.dataset.panel;
            
            if (selectedPanels.has(panelId)) {
                selectedPanels.delete(panelId);
                this.classList.remove('highlighted');
                removeAssessmentField(panelId);
            } else {
                selectedPanels.add(panelId);
                this.classList.add('highlighted');
                addAssessmentField(panelId);
            }
        });
    });
    
    // Rest of your existing JavaScript code...
});
</script>
@endsection