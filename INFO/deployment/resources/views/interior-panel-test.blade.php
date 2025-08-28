@extends('layouts.app')

@section('title', 'Interior Panel Positioning Test')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center" style="color: var(--primary-color);">Interior Panel Positioning Test</h2>
            <p class="text-center text-muted">Test panel positioning - panels should appear when you hover</p>
        </div>
    </div>

    <div class="row">
        <!-- Interior Visual Section - matching body panel layout -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Interior Panels</h5>
                </div>
                <div class="card-body">
                    <div class="interior-container">
                        <!-- Base interior image -->
                        <img src="/images/interior/interiorMain.png" 
                             alt="Interior View" 
                             class="base-interior" 
                             id="baseImage">
                        
                        <!-- Interior panel overlays - UPDATED CSV COORDINATES -->
                        <!-- Using corrected coordinates from interior-panels.csv -->
                        
                        <!-- Dash: x=61, y=61, w=888, h=254 -->
                        <img src="/images/interior/Dash.png" 
                             class="panel-overlay" 
                             data-panel="dash"
                             data-corel-x="61" data-corel-y="61"
                             style="position: absolute; left: 61px; top: 61px; width: 888px; height: 254px;"
                             title="Dash" 
                             alt="Dash">
                        
                        <!-- Steering Wheel: x=595, y=254, w=240, h=123 -->
                        <img src="/images/interior/steering-wheel.png" 
                             class="panel-overlay" 
                             data-panel="steering-wheel"
                             data-corel-x="595" data-corel-y="254"
                             style="position: absolute; left: 595px; top: 254px; width: 240px; height: 123px;"
                             title="Steering Wheel" 
                             alt="Steering Wheel">
                        
                        <!-- Main Buttons Panel: x=79, y=270, w=853, h=507 -->
                        <img src="/images/interior/buttons.png" 
                             class="panel-overlay" 
                             data-panel="buttons"
                             data-corel-x="79" data-corel-y="270"
                             style="position: absolute; left: 79px; top: 270px; width: 853px; height: 507px;"
                             title="Buttons" 
                             alt="Buttons">
                        
                        <!-- Individual Button Components with higher z-index -->
                        <!-- Buttons RF: x=876, y=283, w=85, h=85 -->
                        <img src="/images/interior/buttons-RF.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="876" data-corel-y="283"
                             style="position: absolute; left: 876px; top: 283px; width: 85px; height: 85px; z-index: 2;"
                             title="Buttons RF" 
                             alt="Buttons RF">
                        
                        <!-- Buttons Centre: x=427, y=271, w=65, h=66 -->
                        <img src="/images/interior/buttons-centre.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="427" data-corel-y="271"
                             style="position: absolute; left: 427px; top: 271px; width: 65px; height: 66px; z-index: 2;"
                             title="Buttons Centre" 
                             alt="Buttons Centre">
                        
                        <!-- Buttons ML: x=455, y=384, w=30, h=42 -->
                        <img src="/images/interior/buttons-ML.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="455" data-corel-y="384"
                             style="position: absolute; left: 455px; top: 384px; width: 30px; height: 42px; z-index: 2;"
                             title="Buttons ML" 
                             alt="Buttons ML">
                        
                        <!-- Buttons MR: x=527, y=387, w=30, h=40 -->
                        <img src="/images/interior/buttons-MR.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="527" data-corel-y="387"
                             style="position: absolute; left: 527px; top: 387px; width: 30px; height: 40px; z-index: 2;"
                             title="Buttons MR" 
                             alt="Buttons MR">
                        
                        <!-- Buttons FL: x=77, y=325, w=36, h=36 -->
                        <img src="/images/interior/buttons-FL.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="77" data-corel-y="325"
                             style="position: absolute; left: 77px; top: 325px; width: 36px; height: 36px; z-index: 2;"
                             title="Buttons FL" 
                             alt="Buttons FL">
                        
                        <!-- Buttons RL: x=104, y=739, w=33, h=33 -->
                        <img src="/images/interior/buttons-RL.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="104" data-corel-y="739"
                             style="position: absolute; left: 104px; top: 739px; width: 33px; height: 33px; z-index: 2;"
                             title="Buttons RL" 
                             alt="Buttons RL">
                        
                        <!-- Buttons RR: x=881, y=731, w=39, h=39 -->
                        <img src="/images/interior/buttons-RR.png" 
                             class="panel-overlay buttons-group" 
                             data-panel="buttons"
                             data-corel-x="881" data-corel-y="731"
                             style="position: absolute; left: 881px; top: 731px; width: 39px; height: 39px; z-index: 2;"
                             title="Buttons RR" 
                             alt="Buttons RR">
                        
                        <!-- Driver Seat: x=558, y=271, w=346, h=449 -->
                        <img src="/images/interior/driver-seat.png" 
                             class="panel-overlay" 
                             data-panel="driver-seat"
                             data-corel-x="558" data-corel-y="271"
                             style="position: absolute; left: 558px; top: 271px; width: 346px; height: 449px;"
                             title="Driver Seat" 
                             alt="Driver Seat">
                        
                        <!-- Passenger Seat: x=115, y=298, w=332, h=420 -->
                        <img src="/images/interior/passenger-seat.png" 
                             class="panel-overlay" 
                             data-panel="passenger-seat"
                             data-corel-x="115" data-corel-y="298"
                             style="position: absolute; left: 115px; top: 298px; width: 332px; height: 420px;"
                             title="Passenger Seat" 
                             alt="Passenger Seat">
                        
                        <!-- FR Door Panel: x=883, y=203, w=97, h=471 -->
                        <img src="/images/interior/fr-dOORPANEL.png" 
                             class="panel-overlay" 
                             data-panel="fr-door-panel"
                             data-corel-x="883" data-corel-y="203"
                             style="position: absolute; left: 883px; top: 203px; width: 97px; height: 471px;"
                             title="FR Door Panel" 
                             alt="FR Door Panel">
                        
                        <!-- FL Door Panel: x=31, y=203, w=101, h=481 -->
                        <img src="/images/interior/FL Doorpanel.png" 
                             class="panel-overlay" 
                             data-panel="fl-door-panel"
                             data-corel-x="31" data-corel-y="203"
                             style="position: absolute; left: 31px; top: 203px; width: 101px; height: 481px;"
                             title="FL Door Panel" 
                             alt="FL Door Panel">
                        
                        <!-- Rear Seat: x=131, y=712, w=737, h=400 -->
                        <img src="/images/interior/Rear-Seat.png" 
                             class="panel-overlay" 
                             data-panel="rear-seat"
                             data-corel-x="131" data-corel-y="712"
                             style="position: absolute; left: 131px; top: 712px; width: 737px; height: 400px;"
                             title="Rear Seat" 
                             alt="Rear Seat">
                        
                        <!-- Backboard: x=107, y=1100, w=812, h=275 -->
                        <img src="/images/interior/backboard.png" 
                             class="panel-overlay" 
                             data-panel="backboard"
                             data-corel-x="107" data-corel-y="1100"
                             style="position: absolute; left: 107px; top: 1100px; width: 812px; height: 275px;"
                             title="Backboard" 
                             alt="Backboard">
                        
                        <!-- RR Door Panel: x=854, y=677, w=119, h=443 -->
                        <img src="/images/interior/RR-Door-Panel.png" 
                             class="panel-overlay" 
                             data-panel="rr-door-panel"
                             data-corel-x="854" data-corel-y="677"
                             style="position: absolute; left: 854px; top: 677px; width: 119px; height: 443px;"
                             title="RR Door Panel" 
                             alt="RR Door Panel">
                        
                        <!-- LR Door Panel: x=44, y=678, w=131, h=443 -->
                        <img src="/images/interior/LR-DoorPanel.png" 
                             class="panel-overlay" 
                             data-panel="lr-door-panel"
                             data-corel-x="44" data-corel-y="678"
                             style="position: absolute; left: 44px; top: 678px; width: 131px; height: 443px;"
                             title="LR Door Panel" 
                             alt="LR Door Panel">
                        
                        <!-- Boot: x=103, y=1310, w=811, h=125 -->
                        <img src="/images/interior/Boot.png" 
                             class="panel-overlay" 
                             data-panel="boot"
                             data-corel-x="103" data-corel-y="1310"
                             style="position: absolute; left: 103px; top: 1310px; width: 811px; height: 125px;"
                             title="Boot" 
                             alt="Boot">
                        
                        <!-- Centre Console: x=394, y=256, w=227, h=484 -->
                        <img src="/images/interior/Centre-Consol.png" 
                             class="panel-overlay" 
                             data-panel="centre-console"
                             data-corel-x="394" data-corel-y="256"
                             style="position: absolute; left: 394px; top: 256px; width: 227px; height: 484px;"
                             title="Centre Console" 
                             alt="Centre Console">
                        
                        <!-- Gear Lever: x=478, y=388, w=54, h=65 -->
                        <img src="/images/interior/Gear-Lever.png" 
                             class="panel-overlay" 
                             data-panel="gearlever"
                             data-corel-x="478" data-corel-y="388"
                             style="position: absolute; left: 478px; top: 388px; width: 54px; height: 65px;"
                             title="Gear Lever" 
                             alt="Gear Lever">
                        
                        <!-- Air Vents: x=71, y=182, w=868, h=150 -->
                        <img src="/images/interior/Airvents.png" 
                             class="panel-overlay" 
                             data-panel="air-vents"
                             data-corel-x="71" data-corel-y="182"
                             style="position: absolute; left: 71px; top: 182px; width: 868px; height: 150px;"
                             title="Air Vents" 
                             alt="Air Vents">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Panel Information Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header" style="background-color: var(--primary-color); color: white;">
                    <h5 class="mb-0">Panel Information</h5>
                </div>
                <div class="card-body">
                    <div id="panelInfo" class="alert alert-secondary">
                        Click a panel to edit its coordinates
                    </div>
                    
                    <div id="coordinateEditor" style="display: none;">
                        <h6>Edit Panel Position</h6>
                        <div class="mb-2">
                            <strong>Panel:</strong> <span id="editPanelName"></span>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="form-label">Left (px):</label>
                                <input type="number" id="editLeft" class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Top (px):</label>
                                <input type="number" id="editTop" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="form-label">Width (px):</label>
                                <input type="number" id="editWidth" class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Height (px):</label>
                                <input type="number" id="editHeight" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary btn-sm" onclick="applyChanges()">Apply</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit()">Cancel</button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Axis Flip Testing</h6>
                        <p class="small text-muted">Apply different coordinate transformations to all panels:</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyAxisFlipping('none')">Original CSV</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyAxisFlipping('y')">Flip Y Axis</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyAxisFlipping('x')">Flip X Axis</button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="applyAxisFlipping('both')">Flip Both Axes</button>
                        <div class="mt-2">
                            <small class="text-muted">
                                <strong>Your Reference Points:</strong><br>
                                Dash should be at: (59, 59)<br>
                                Steering Wheel should be at: (259, 252)
                            </small>
                        </div>
                        <div id="flipTestResults" class="mt-2 small" style="background: #f0f0f0; padding: 5px; border-radius: 3px;"></div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Coordinate Management</h6>
                        <button type="button" class="btn btn-success btn-sm" onclick="saveAllCoordinates()">Save All Coordinates</button>
                        <button type="button" class="btn btn-info btn-sm" onclick="loadSavedCoordinates()">Load Saved</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="exportCoordinates()">Export CSV</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="resetToOriginal()">Reset to Original</button>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Import Coordinates</h6>
                        <textarea id="importCoordinates" class="form-control" rows="4" placeholder="Paste coordinate data here (JSON format)"></textarea>
                        <button type="button" class="btn btn-primary btn-sm mt-2" onclick="importCoordinates()">Import</button>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Saved Coordinates</h6>
                        <pre id="savedCoordinatesDisplay" style="font-size: 10px; max-height: 200px; overflow-y: auto; background: #f8f9fa; padding: 10px;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Interior container - exactly like body panel container */
.interior-container {
    position: relative;
    max-width: 1005px;
    width: 100%;
    margin: 0 auto;
    background-color: #f8f9fa;
    padding: 0;
    overflow: visible;
}

/* Base interior image - exactly like body panel base image */
.base-interior {
    width: 100%;
    height: auto;
    display: block;
    max-width: 1005px;
}

/* Panel overlay styling - black lines fully visible, red color more transparent */
.panel-overlay {
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 1; /* Full opacity to show black lines clearly */
    filter: none; /* No color filter by default - show black lines */
}

/* Hover effects for panels */
.panel-overlay:hover {
    opacity: 0.4; /* More transparent red color on hover */
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Active state */
.panel-overlay.active {
    opacity: 0.4; /* More transparent red color when active */
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* Special handling for button groups - they all highlight together */
.buttons-group:hover ~ .buttons-group,
.buttons-group:hover,
.buttons-group.active {
    opacity: 0.4;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}

/* When hovering any button part, highlight all button parts */
.interior-container:has(.buttons-group:hover) .buttons-group {
    opacity: 0.4;
    filter: brightness(0) saturate(100%) invert(21%) sepia(100%) saturate(7463%) hue-rotate(358deg) brightness(105%) contrast(115%);
}
</style>

<script>
let currentEditingPanel = null;
let originalCoordinates = {};

// Store original coordinates
const originalPanelData = {
    'dash': {left: 59, top: 59, width: 888, height: 254},
    'steering-wheel': {left: 259, top: 252, width: 240, height: 123},
    'buttons': {left: 61, top: 574, width: 853, height: 507},
    'driver-seat': {left: 275, top: 530, width: 346, height: 449},
    'passenger-seat': {left: -153, top: 550, width: 332, height: 420},
    'fr-door-panel': {left: 466, top: 445, width: 97, height: 471},
    'fl-door-panel': {left: -344, top: 451, width: 101, height: 481},
    'rear-seat': {left: 54, top: 1164, width: 737, height: 400},
    'backboard': {left: 67, top: 1666, width: 812, height: 275},
    'rr-door-panel': {left: 447, top: 1149, width: 119, height: 443},
    'lr-door-panel': {left: -316, top: 1151, width: 131, height: 443},
    'boot': {left: 62, top: 1872, width: 811, height: 125},
    'centre-console': {left: 62, top: 532, width: 227, height: 484},
    'gearlever': {left: 60, top: 414, width: 54, height: 65}
};

document.addEventListener('DOMContentLoaded', function() {
    const panels = document.querySelectorAll('.panel-overlay');
    const panelInfo = document.getElementById('panelInfo');
    
    // Load saved coordinates on page load
    loadSavedCoordinates();
    
    panels.forEach(panel => {
        panel.addEventListener('click', function() {
            // Remove active class from all panels
            panels.forEach(p => p.classList.remove('active'));
            
            // Add active class to clicked panel
            this.classList.add('active');
            
            // Show coordinate editor
            editPanel(this);
        });
    });
});

function editPanel(panel) {
    currentEditingPanel = panel;
    const panelName = panel.dataset.panel;
    const style = window.getComputedStyle(panel);
    
    document.getElementById('editPanelName').textContent = panelName;
    document.getElementById('editLeft').value = parseInt(style.left);
    document.getElementById('editTop').value = parseInt(style.top);
    document.getElementById('editWidth').value = parseInt(style.width);
    document.getElementById('editHeight').value = parseInt(style.height);
    
    document.getElementById('coordinateEditor').style.display = 'block';
    document.getElementById('panelInfo').innerHTML = `Editing: <strong>${panelName}</strong>`;
}

function applyChanges() {
    if (!currentEditingPanel) return;
    
    const left = document.getElementById('editLeft').value;
    const top = document.getElementById('editTop').value;
    const width = document.getElementById('editWidth').value;
    const height = document.getElementById('editHeight').value;
    
    currentEditingPanel.style.left = left + 'px';
    currentEditingPanel.style.top = top + 'px';
    currentEditingPanel.style.width = width + 'px';
    currentEditingPanel.style.height = height + 'px';
    
    cancelEdit();
    
    // Show confirmation
    document.getElementById('panelInfo').innerHTML = `
        <span class="text-success">Updated ${currentEditingPanel.dataset.panel}!</span><br>
        Position: ${left}px, ${top}px | Size: ${width}px x ${height}px
    `;
}

function cancelEdit() {
    currentEditingPanel = null;
    document.getElementById('coordinateEditor').style.display = 'none';
    document.getElementById('panelInfo').innerHTML = 'Click a panel to edit its coordinates';
}

function saveAllCoordinates() {
    const panels = document.querySelectorAll('.panel-overlay');
    const coordinates = {};
    
    panels.forEach(panel => {
        const style = window.getComputedStyle(panel);
        coordinates[panel.dataset.panel] = {
            left: parseInt(style.left),
            top: parseInt(style.top),
            width: parseInt(style.width),
            height: parseInt(style.height)
        };
    });
    
    // Save to localStorage
    localStorage.setItem('interiorPanelCoordinates', JSON.stringify(coordinates));
    
    // Display saved coordinates
    document.getElementById('savedCoordinatesDisplay').textContent = JSON.stringify(coordinates, null, 2);
    
    alert('Coordinates saved to browser storage!');
}

function loadSavedCoordinates() {
    const saved = localStorage.getItem('interiorPanelCoordinates');
    if (saved) {
        const coordinates = JSON.parse(saved);
        
        Object.keys(coordinates).forEach(panelName => {
            const panel = document.querySelector(`[data-panel="${panelName}"]`);
            if (panel) {
                const coord = coordinates[panelName];
                panel.style.left = coord.left + 'px';
                panel.style.top = coord.top + 'px';
                panel.style.width = coord.width + 'px';
                panel.style.height = coord.height + 'px';
            }
        });
        
        document.getElementById('savedCoordinatesDisplay').textContent = JSON.stringify(coordinates, null, 2);
        document.getElementById('panelInfo').innerHTML = '<span class="text-success">Loaded saved coordinates!</span>';
    } else {
        document.getElementById('panelInfo').innerHTML = '<span class="text-warning">No saved coordinates found</span>';
    }
}

function exportCoordinates() {
    const panels = document.querySelectorAll('.panel-overlay');
    let csvContent = "Panel,Left,Top,Width,Height\n";
    
    panels.forEach(panel => {
        const style = window.getComputedStyle(panel);
        csvContent += `${panel.dataset.panel},${parseInt(style.left)},${parseInt(style.top)},${parseInt(style.width)},${parseInt(style.height)}\n`;
    });
    
    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'interior-panel-coordinates.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

function importCoordinates() {
    const importText = document.getElementById('importCoordinates').value;
    if (!importText.trim()) {
        alert('Please paste coordinate data first');
        return;
    }
    
    try {
        const coordinates = JSON.parse(importText);
        
        Object.keys(coordinates).forEach(panelName => {
            const panel = document.querySelector(`[data-panel="${panelName}"]`);
            if (panel) {
                const coord = coordinates[panelName];
                panel.style.left = coord.left + 'px';
                panel.style.top = coord.top + 'px';
                panel.style.width = coord.width + 'px';
                panel.style.height = coord.height + 'px';
            }
        });
        
        document.getElementById('panelInfo').innerHTML = '<span class="text-success">Imported coordinates successfully!</span>';
        document.getElementById('importCoordinates').value = '';
        
    } catch (e) {
        alert('Invalid JSON format. Please check your data.');
    }
}

function resetToOriginal() {
    if (confirm('Reset all panels to original positions?')) {
        Object.keys(originalPanelData).forEach(panelName => {
            const panel = document.querySelector(`[data-panel="${panelName}"]`);
            if (panel) {
                const coord = originalPanelData[panelName];
                panel.style.left = coord.left + 'px';
                panel.style.top = coord.top + 'px';
                panel.style.width = coord.width + 'px';
                panel.style.height = coord.height + 'px';
            }
        });
        
        document.getElementById('panelInfo').innerHTML = '<span class="text-info">Reset to original positions</span>';
    }
}

function applyAxisFlipping(flipType) {
    const panels = document.querySelectorAll('.panel-overlay');
    let resultMessage = `Applied ${flipType} axis transformation:<br>`;
    
    panels.forEach(panel => {
        const corelX = parseInt(panel.dataset.corelX);
        const corelY = parseInt(panel.dataset.corelY);
        let newX, newY;
        
        // Apply different flipping strategies
        switch(flipType) {
            case 'none':
                newX = corelX;
                newY = corelY;
                break;
            case 'y':
                newX = corelX;
                newY = 1437 - corelY;
                break;
            case 'x':
                newX = 1005 - corelX;
                newY = corelY;
                break;
            case 'both':
                newX = 1005 - corelX;
                newY = 1437 - corelY;
                break;
        }
        
        // Apply new coordinates
        panel.style.left = newX + 'px';
        panel.style.top = newY + 'px';
        
        // Show key panels in results
        if (panel.dataset.panel === 'dash' || panel.dataset.panel === 'steering-wheel') {
            resultMessage += `${panel.dataset.panel}: (${corelX},${corelY}) → (${newX},${newY})<br>`;
        }
    });
    
    // Show reference comparison
    const dashPanel = document.querySelector('[data-panel="dash"]');
    const steeringPanel = document.querySelector('[data-panel="steering-wheel"]');
    
    if (dashPanel && steeringPanel) {
        const dashActual = { 
            left: parseInt(dashPanel.style.left), 
            top: parseInt(dashPanel.style.top) 
        };
        const steeringActual = { 
            left: parseInt(steeringPanel.style.left), 
            top: parseInt(steeringPanel.style.top) 
        };
        
        resultMessage += `<br><strong>Reference Check:</strong><br>`;
        resultMessage += `Dash: Actual(${dashActual.left},${dashActual.top}) vs Target(59,59)<br>`;
        resultMessage += `Steering: Actual(${steeringActual.left},${steeringActual.top}) vs Target(259,252)<br>`;
        
        // Check accuracy
        const dashDiffX = Math.abs(dashActual.left - 59);
        const dashDiffY = Math.abs(dashActual.top - 59);
        const steeringDiffX = Math.abs(steeringActual.left - 259);
        const steeringDiffY = Math.abs(steeringActual.top - 252);
        
        if (dashDiffX < 50 && dashDiffY < 50 && steeringDiffX < 50 && steeringDiffY < 50) {
            resultMessage += `<span style="color: green; font-weight: bold;">This transformation looks promising!</span>`;
        } else {
            resultMessage += `<span style="color: red;">This transformation is off by significant amounts</span>`;
        }
    }
    
    document.getElementById('flipTestResults').innerHTML = resultMessage;
    document.getElementById('panelInfo').innerHTML = `Applied <strong>${flipType}</strong> axis transformation to all panels`;
}

function applyLinearTransform(corelX, corelY, flipType) {
    let transformedX, transformedY;
    
    // Apply flipping first
    switch(flipType) {
        case 'none':
            transformedX = corelX;
            transformedY = corelY;
            break;
        case 'y':
            transformedX = corelX;
            transformedY = 1437 - corelY;
            break;
        case 'x':
            transformedX = 1005 - corelX;
            transformedY = corelY;
            break;
        case 'both':
            transformedX = 1005 - corelX;
            transformedY = 1437 - corelY;
            break;
    }
    
    // Now derive linear transformation for this flipping scenario
    // Using reference points: Dash(504,1249)→(59,59), SteeringWheel(714,1123)→(259,252)
    
    let x1, y1, x2, y2;
    
    // Apply same flipping to reference points
    switch(flipType) {
        case 'none':
            x1 = 504; y1 = 1249;
            x2 = 714; y2 = 1123;
            break;
        case 'y':
            x1 = 504; y1 = 1437 - 1249; // = 188
            x2 = 714; y2 = 1437 - 1123; // = 314
            break;
        case 'x':
            x1 = 1005 - 504; y1 = 1249; // = 501, 1249
            x2 = 1005 - 714; y2 = 1123; // = 291, 1123
            break;
        case 'both':
            x1 = 1005 - 504; y1 = 1437 - 1249; // = 501, 188
            x2 = 1005 - 714; y2 = 1437 - 1123; // = 291, 314
            break;
    }
    
    // Calculate linear transformation coefficients
    // For X: left = a*x + b
    const a = (259 - 59) / (x2 - x1); // 200 / (x2-x1)
    const b = 59 - a * x1;
    
    // For Y: top = c*y + d
    const c = (252 - 59) / (y2 - y1); // 193 / (y2-y1)
    const d = 59 - c * y1;
    
    // Apply transformation
    const left = Math.round(a * transformedX + b);
    const top = Math.round(c * transformedY + d);
    
    return {left, top};
}
</script>
@endsection