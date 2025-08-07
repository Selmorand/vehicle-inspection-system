// Test Data Population Script
// Add this to any inspection page to quickly fill forms

function populateTestData() {
    const currentPath = window.location.pathname;
    
    if (currentPath.includes('/inspection/visual')) {
        // Visual Inspection Test Data
        document.querySelector('input[name="client_name"]').value = "Test Client - " + new Date().toLocaleTimeString();
        document.querySelector('input[name="contact_number"]').value = "082 555 1234";
        document.querySelector('input[name="email"]').value = "test@example.com";
        document.querySelector('input[name="vin_number"]').value = "TEST123456789";
        document.querySelector('input[name="vehicle_make"]').value = "Toyota";
        document.querySelector('input[name="vehicle_model"]').value = "Corolla";
        document.querySelector('input[name="vehicle_year"]').value = "2020";
        document.querySelector('input[name="mileage"]').value = "25000";
        document.querySelector('input[name="license_plate"]').value = "TEST 123 GP";
        document.querySelector('input[name="inspector_name"]').value = "Test Inspector";
        document.querySelector('input[name="inspection_date"]').value = new Date().toISOString().split('T')[0];
        console.log('✅ Visual inspection data populated!');
    }
    
    else if (currentPath.includes('/inspection/body-panel')) {
        // Click a few panels
        setTimeout(() => {
            ['front-bumper', 'bonnet', 'windscreen'].forEach(panelId => {
                const panel = document.querySelector(`[data-panel="${panelId}"]`);
                if (panel) panel.click();
            });
            console.log('✅ Body panels selected!');
        }, 500);
    }
}

// Auto-add test button to pages
document.addEventListener('DOMContentLoaded', function() {
    const testBtn = document.createElement('button');
    testBtn.innerHTML = '🧪 Fill Test Data';
    testBtn.className = 'btn btn-warning position-fixed';
    testBtn.style.cssText = 'bottom: 80px; right: 20px; z-index: 1000;';
    testBtn.onclick = populateTestData;
    document.body.appendChild(testBtn);
});