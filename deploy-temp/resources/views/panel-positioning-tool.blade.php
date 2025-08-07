@extends('layouts.app')

@section('title', 'Panel Positioning Tool')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4" style="color: var(--primary-color);">Panel Positioning Tool</h2>
            <p class="text-center text-muted">Drag panels to position them correctly over the base image. Use arrow keys for fine adjustment (Shift+Arrow = 10px steps).</p>
        </div>
    </div>

    <div class="row">
        <!-- Vehicle Image Section -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Vehicle Base Image</h5>
                    <small class="text-muted">Drag the panels to their correct positions</small>
                </div>
                <div class="card-body">
                    <div id="vehicle-container" class="position-relative" style="background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px; padding: 20px;">
                        <!-- Base vehicle image -->
                        <img src="/images/panels/FullVehicle.png" alt="Vehicle Base" class="img-fluid" id="base-image">
                        
                        <!-- Draggable panel overlays -->
                        <img src="/images/panels/front-bumper.png" class="draggable-panel" data-panel="front-bumper" title="Front Bumper" alt="Front Bumper">
                        <img src="/images/panels/bonnet.png" class="draggable-panel" data-panel="bonnet" title="Bonnet" alt="Bonnet">
                        <img src="/images/panels/lf-headlight.png" class="draggable-panel" data-panel="lf-headlight" title="Left Front Headlight" alt="Left Front Headlight">
                        <img src="/images/panels/fr-headlight.png" class="draggable-panel" data-panel="fr-headlight" title="Right Front Headlight" alt="Right Front Headlight">
                        <img src="/images/panels/lf-fender.png" class="draggable-panel" data-panel="lf-fender" title="Left Front Fender" alt="Left Front Fender">
                        <img src="/images/panels/fr-fender.png" class="draggable-panel" data-panel="fr-fender" title="Right Front Fender" alt="Right Front Fender">
                        <img src="/images/panels/lf-door.png" class="draggable-panel" data-panel="lf-door" title="Left Front Door" alt="Left Front Door">
                        <img src="/images/panels/fr-door.png" class="draggable-panel" data-panel="fr-door" title="Right Front Door" alt="Right Front Door">
                        <img src="/images/panels/lr-door.png" class="draggable-panel" data-panel="lr-door" title="Left Rear Door" alt="Left Rear Door">
                        <img src="/images/panels/rr-door.png" class="draggable-panel" data-panel="rr-door" title="Right Rear Door" alt="Right Rear Door">
                        <img src="/images/panels/lf-mirror.png" class="draggable-panel" data-panel="lf-mirror" title="Left Front Mirror" alt="Left Front Mirror">
                        <img src="/images/panels/fr-mirror.png" class="draggable-panel" data-panel="fr-mirror" title="Right Front Mirror" alt="Right Front Mirror">
                        <img src="/images/panels/lr-quarter-panel.png" class="draggable-panel" data-panel="lr-quarter" title="Left Rear Quarter Panel" alt="Left Rear Quarter Panel">
                        <img src="/images/panels/rr-quarter-panel.png" class="draggable-panel" data-panel="rr-quarter" title="Right Rear Quarter Panel" alt="Right Rear Quarter Panel">
                        <img src="/images/panels/lr-taillight.png" class="draggable-panel" data-panel="lr-taillight" title="Left Rear Taillight" alt="Left Rear Taillight">
                        <img src="/images/panels/rr-taillight.png" class="draggable-panel" data-panel="rr-taillight" title="Right Rear Taillight" alt="Right Rear Taillight">
                        <img src="/images/panels/roof.png" class="draggable-panel" data-panel="roof" title="Roof" alt="Roof">
                        <img src="/images/panels/windscreen.png" class="draggable-panel" data-panel="windscreen" title="Windscreen" alt="Windscreen">
                        <img src="/images/panels/rear-window.png" class="draggable-panel" data-panel="rear-window" title="Rear Window" alt="Rear Window">
                        <img src="/images/panels/boot.png" class="draggable-panel" data-panel="boot" title="Boot" alt="Boot">
                        <img src="/images/panels/rear-bumper.png" class="draggable-panel" data-panel="rear-bumper" title="Rear Bumper" alt="Rear Bumper">
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls Section -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Panel Controls</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Selected Panel:</label>
                        <div id="selected-panel" class="text-muted">None selected</div>
                        <small class="text-muted">Use ↑↓←→ keys to move (Shift = 10px steps)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Position:</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">Left (px):</label>
                                <input type="number" id="position-x" class="form-control form-control-sm" placeholder="0">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Top (px):</label>
                                <input type="number" id="position-y" class="form-control form-control-sm" placeholder="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Size:</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">Width (px):</label>
                                <input type="number" id="size-width" class="form-control form-control-sm" placeholder="100">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Height (px):</label>
                                <input type="number" id="size-height" class="form-control form-control-sm" placeholder="100">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Opacity:</label>
                        <input type="range" id="opacity-slider" class="form-range" min="0.1" max="1" step="0.1" value="0.7">
                        <small class="text-muted">Adjust to see panel alignment</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" id="apply-changes">Apply Changes</button>
                        <button type="button" class="btn btn-success" id="export-css">Export CSS</button>
                        <button type="button" class="btn btn-secondary" id="reset-positions">Reset All</button>
                    </div>
                </div>
            </div>
            
            <!-- CSS Output -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Generated CSS</h5>
                </div>
                <div class="card-body">
                    <textarea id="css-output" class="form-control" rows="15" placeholder="Position panels and click 'Export CSS' to generate code..."></textarea>
                    <button type="button" class="btn btn-outline-primary mt-2 btn-sm" id="copy-css">Copy CSS</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#vehicle-container {
    min-height: 500px;
    max-width: 1005px;
    overflow: hidden;
}

#base-image {
    width: 1005px;
    height: auto;
    display: block;
    user-select: none;
}

.draggable-panel {
    position: absolute;
    cursor: move;
    border: 2px solid transparent;
    opacity: 0.7;
    z-index: 10;
    /* No transitions - disable animations */
}

.draggable-panel:hover {
    border-color: #007bff;
    opacity: 1;
}

.draggable-panel.selected {
    border-color: #dc3545;
    opacity: 1;
    z-index: 100;
}

.draggable-panel.dragging {
    opacity: 0.8;
    z-index: 200;
    /* No transform/scale animation */
}

/* Removed duplicate - already defined above */

#css-output {
    font-family: 'Courier New', monospace;
    font-size: 12px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedPanel = null;
    let isDragging = false;
    let panelPositions = {};
    let baseImage = document.getElementById('base-image');
    let vehicleContainer = document.getElementById('vehicle-container');
    
    // Scaling constants
    const ORIGINAL_BASE_WIDTH = 4828; // Original base image width
    const DISPLAY_WIDTH = 1005; // Target display width  
    const SCALE_RATIO = DISPLAY_WIDTH / ORIGINAL_BASE_WIDTH; // 0.208
    
    // Panel original dimensions
    const PANEL_DIMENSIONS = {
        'rr-door': { width: 996, height: 1076 },
        'front-bumper': { width: 1200, height: 300 },
        'bonnet': { width: 1400, height: 900 },
        'boot': { width: 1200, height: 800 },
        'roof': { width: 1600, height: 2000 },
        'windscreen': { width: 1200, height: 800 },
        'rear-window': { width: 1000, height: 600 },
        // Add actual dimensions for other panels as needed
    };
    
    // Initialize all panels
    const panels = document.querySelectorAll('.draggable-panel');
    panels.forEach((panel, index) => {
        // Initial positioning in a grid
        const panelId = panel.dataset.panel;
        const row = Math.floor(index / 5);
        const col = index % 5;
        const initialX = col * 120 + 20;
        const initialY = row * 120 + 20;
        
        // Calculate scaled dimensions
        let scaledWidth, scaledHeight;
        if (PANEL_DIMENSIONS[panelId]) {
            scaledWidth = Math.round(PANEL_DIMENSIONS[panelId].width * SCALE_RATIO);
            scaledHeight = Math.round(PANEL_DIMENSIONS[panelId].height * SCALE_RATIO);
        } else {
            // Default fallback size
            scaledWidth = Math.round(200 * SCALE_RATIO);
            scaledHeight = Math.round(200 * SCALE_RATIO);
        }
        
        panel.style.left = initialX + 'px';
        panel.style.top = initialY + 'px';
        panel.style.width = scaledWidth + 'px';
        panel.style.height = scaledHeight + 'px';
        
        panelPositions[panelId] = {
            left: initialX,
            top: initialY,
            width: scaledWidth,
            height: scaledHeight,
            originalWidth: PANEL_DIMENSIONS[panelId] ? PANEL_DIMENSIONS[panelId].width : 200,
            originalHeight: PANEL_DIMENSIONS[panelId] ? PANEL_DIMENSIONS[panelId].height : 200
        };
        
        // Panel selection
        panel.addEventListener('click', function(e) {
            e.stopPropagation();
            selectPanel(this);
        });
        
        // Drag functionality
        panel.addEventListener('mousedown', startDrag);
    });
    
    // Deselect when clicking container
    vehicleContainer.addEventListener('click', function(e) {
        if (e.target === this || e.target === baseImage) {
            deselectAll();
        }
    });
    
    function selectPanel(panel) {
        deselectAll();
        selectedPanel = panel;
        panel.classList.add('selected');
        
        const panelId = panel.dataset.panel;
        document.getElementById('selected-panel').textContent = panel.title;
        document.getElementById('position-x').value = parseInt(panel.style.left) || 0;
        document.getElementById('position-y').value = parseInt(panel.style.top) || 0;
        document.getElementById('size-width').value = parseInt(panel.style.width) || 100;
        document.getElementById('size-height').value = parseInt(panel.style.height) || 100;
        document.getElementById('opacity-slider').value = panel.style.opacity || 0.7;
    }
    
    function deselectAll() {
        panels.forEach(p => p.classList.remove('selected'));
        selectedPanel = null;
        document.getElementById('selected-panel').textContent = 'None selected';
    }
    
    function startDrag(e) {
        e.preventDefault();
        isDragging = true;
        selectedPanel = this;
        selectPanel(this);
        this.classList.add('dragging');
        
        const rect = vehicleContainer.getBoundingClientRect();
        const offsetX = e.clientX - rect.left - parseInt(this.style.left);
        const offsetY = e.clientY - rect.top - parseInt(this.style.top);
        
        function drag(e) {
            if (!isDragging) return;
            
            const rect = vehicleContainer.getBoundingClientRect();
            const x = e.clientX - rect.left - offsetX;
            const y = e.clientY - rect.top - offsetY;
            
            selectedPanel.style.left = Math.max(0, x) + 'px';
            selectedPanel.style.top = Math.max(0, y) + 'px';
            
            // Update position inputs
            document.getElementById('position-x').value = Math.max(0, x);
            document.getElementById('position-y').value = Math.max(0, y);
        }
        
        function stopDrag() {
            if (isDragging) {
                isDragging = false;
                selectedPanel.classList.remove('dragging');
                
                // Update stored positions
                const panelId = selectedPanel.dataset.panel;
                panelPositions[panelId] = {
                    left: parseInt(selectedPanel.style.left),
                    top: parseInt(selectedPanel.style.top),
                    width: parseInt(selectedPanel.style.width),
                    height: selectedPanel.style.height === 'auto' ? 'auto' : parseInt(selectedPanel.style.height)
                };
            }
            document.removeEventListener('mousemove', drag);
            document.removeEventListener('mouseup', stopDrag);
        }
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', stopDrag);
    }
    
    // Apply changes from inputs
    document.getElementById('apply-changes').addEventListener('click', function() {
        if (!selectedPanel) {
            alert('Please select a panel first');
            return;
        }
        
        const x = parseInt(document.getElementById('position-x').value) || 0;
        const y = parseInt(document.getElementById('position-y').value) || 0;
        const width = parseInt(document.getElementById('size-width').value) || 100;
        const height = parseInt(document.getElementById('size-height').value) || 100;
        const opacity = parseFloat(document.getElementById('opacity-slider').value) || 0.7;
        
        selectedPanel.style.left = x + 'px';
        selectedPanel.style.top = y + 'px';
        selectedPanel.style.width = width + 'px';
        selectedPanel.style.height = height === 100 ? 'auto' : height + 'px';
        selectedPanel.style.opacity = opacity;
        
        // Update stored positions
        const panelId = selectedPanel.dataset.panel;
        panelPositions[panelId] = { left: x, top: y, width: width, height: height === 100 ? 'auto' : height };
    });
    
    // Export CSS
    document.getElementById('export-css').addEventListener('click', function() {
        let css = '/* Generated Panel Positions */\\n';
        
        for (const [panelId, pos] of Object.entries(panelPositions)) {
            css += `.panel-overlay[data-panel="${panelId}"] {\\n`;
            css += `    left: ${pos.left}px;\\n`;
            css += `    top: ${pos.top}px;\\n`;
            css += `    /* Original size: ${pos.width}x${pos.height}px */\\n`;
            css += `}\\n\\n`;
        }
        
        document.getElementById('css-output').value = css;
    });
    
    // Copy CSS to clipboard
    document.getElementById('copy-css').addEventListener('click', function() {
        const textarea = document.getElementById('css-output');
        if (textarea.value.trim() === '') {
            alert('Generate CSS first by clicking "Export CSS"');
            return;
        }
        textarea.select();
        document.execCommand('copy');
        alert('CSS copied to clipboard!');
    });
    
    // Reset positions
    document.getElementById('reset-positions').addEventListener('click', function() {
        if (confirm('Reset all panel positions?')) {
            panels.forEach((panel, index) => {
                const panelId = panel.dataset.panel;
                const row = Math.floor(index / 5);
                const col = index % 5;
                const x = col * 120 + 20;
                const y = row * 120 + 20;
                
                // Calculate scaled dimensions
                let scaledWidth, scaledHeight;
                if (PANEL_DIMENSIONS[panelId]) {
                    scaledWidth = Math.round(PANEL_DIMENSIONS[panelId].width * SCALE_RATIO);
                    scaledHeight = Math.round(PANEL_DIMENSIONS[panelId].height * SCALE_RATIO);
                } else {
                    scaledWidth = Math.round(200 * SCALE_RATIO);
                    scaledHeight = Math.round(200 * SCALE_RATIO);
                }
                
                panel.style.left = x + 'px';
                panel.style.top = y + 'px';
                panel.style.width = scaledWidth + 'px';
                panel.style.height = scaledHeight + 'px';
                panel.style.opacity = '0.7';
                
                panelPositions[panelId] = { 
                    left: x, 
                    top: y, 
                    width: scaledWidth, 
                    height: scaledHeight,
                    originalWidth: PANEL_DIMENSIONS[panelId] ? PANEL_DIMENSIONS[panelId].width : 200,
                    originalHeight: PANEL_DIMENSIONS[panelId] ? PANEL_DIMENSIONS[panelId].height : 200
                };
            });
            deselectAll();
        }
    });
    
    // Opacity slider
    document.getElementById('opacity-slider').addEventListener('input', function() {
        if (selectedPanel) {
            selectedPanel.style.opacity = this.value;
        }
    });
    
    // Arrow key movement
    document.addEventListener('keydown', function(e) {
        if (!selectedPanel) return;
        
        let x = parseInt(selectedPanel.style.left) || 0;
        let y = parseInt(selectedPanel.style.top) || 0;
        const step = e.shiftKey ? 10 : 1; // Hold Shift for 10px steps
        
        switch(e.key) {
            case 'ArrowLeft':
                x = Math.max(0, x - step);
                e.preventDefault();
                break;
            case 'ArrowRight':
                x = x + step;
                e.preventDefault();
                break;
            case 'ArrowUp':
                y = Math.max(0, y - step);
                e.preventDefault();
                break;
            case 'ArrowDown':
                y = y + step;
                e.preventDefault();
                break;
            default:
                return;
        }
        
        // Apply new position
        selectedPanel.style.left = x + 'px';
        selectedPanel.style.top = y + 'px';
        
        // Update inputs
        document.getElementById('position-x').value = x;
        document.getElementById('position-y').value = y;
        
        // Update stored positions
        const panelId = selectedPanel.dataset.panel;
        if (panelPositions[panelId]) {
            panelPositions[panelId].left = x;
            panelPositions[panelId].top = y;
        }
    });
});
</script>
@endsection