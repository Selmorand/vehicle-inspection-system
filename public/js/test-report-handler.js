/**
 * Reusable Test Report Handler for all inspection sections
 * Usage: TestReportHandler.init('formId', 'storageKey', '/test/endpoint')
 */

const TestReportHandler = (function() {
    'use strict';
    
    /**
     * Initialize the test report handler for a specific form
     * @param {string} formId - The ID of the form to process
     * @param {string} storageKey - The sessionStorage key for this section's data
     * @param {string} endpoint - The test report endpoint URL
     * @param {string} sectionName - Name of the section (e.g., 'visual', 'bodyPanel', etc.)
     */
    function init(formId, storageKey, endpoint, sectionName) {
        // Add test button if it doesn't exist
        addTestButton(formId);
        
        // Bind the test function
        window.testSectionReport = function() {
            processAndSubmit(formId, storageKey, endpoint, sectionName);
        };
    }
    
    /**
     * Add test report button to the form
     */
    function addTestButton(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        
        // Check if button already exists
        if (document.getElementById('testReportBtn')) return;
        
        // Find the action buttons container
        const buttonContainer = form.querySelector('.text-center.mb-4') || 
                              form.querySelector('[class*="button"]') ||
                              form.querySelector('.mt-4');
        
        if (buttonContainer) {
            // Create test button
            const testBtn = document.createElement('button');
            testBtn.type = 'button';
            testBtn.id = 'testReportBtn';
            testBtn.className = 'btn btn-info me-3';
            testBtn.innerHTML = 'Test Report View';
            testBtn.onclick = function() { testSectionReport(); };
            
            // Insert before the primary button
            const primaryBtn = buttonContainer.querySelector('.btn-primary');
            if (primaryBtn) {
                buttonContainer.insertBefore(testBtn, primaryBtn);
            } else {
                buttonContainer.appendChild(testBtn);
            }
        }
    }
    
    /**
     * Process form data and submit to test endpoint
     */
    function processAndSubmit(formId, storageKey, endpoint, sectionName) {
        const form = document.getElementById(formId);
        if (!form) {
            console.error('Form not found:', formId);
            return;
        }
        
        // Get form data
        const formData = new FormData(form);
        const sectionData = {};
        
        // Process form data
        const processPromises = [];
        
        for (let [key, value] of formData.entries()) {
            // Handle file inputs
            if (value instanceof File && value.size > 0) {
                if (key.includes('pdf') || key.includes('file') || value.type === 'application/pdf') {
                    // Handle PDF files
                    processPromises.push(
                        readFileAsBase64(value).then(result => {
                            sectionData[key + '_data'] = result;
                            sectionData[key + '_name'] = value.name;
                            sectionData[key + '_size'] = value.size;
                        })
                    );
                } else if (value.type.startsWith('image/')) {
                    // Handle image files
                    processPromises.push(
                        readFileAsBase64(value).then(result => {
                            if (!sectionData.images) sectionData.images = [];
                            sectionData.images.push(result);
                        })
                    );
                }
            } else if (!(value instanceof File)) {
                // Regular form fields
                sectionData[key] = value;
            }
        }
        
        // Check for images in sessionStorage
        const storedData = sessionStorage.getItem(storageKey);
        if (storedData) {
            try {
                const parsed = JSON.parse(storedData);
                // Merge stored data with form data
                Object.assign(sectionData, parsed);
            } catch (e) {
                console.error('Error parsing stored data:', e);
            }
        }
        
        // Check for stored images (for sections using InspectionCards)
        const storedImages = sessionStorage.getItem(storageKey + 'Images');
        if (storedImages) {
            try {
                const images = JSON.parse(storedImages);
                if (!sectionData.images) sectionData.images = [];
                sectionData.images = sectionData.images.concat(images);
            } catch (e) {
                console.error('Error parsing stored images:', e);
            }
        }
        
        // Check for uploaded images (global variable used by some sections)
        if (typeof uploadedImages !== 'undefined' && uploadedImages && uploadedImages.length > 0) {
            const imagePromises = uploadedImages.map(img => {
                return readBlobAsBase64(img.blob).then(result => {
                    if (!sectionData.images) sectionData.images = [];
                    sectionData.images.push(result);
                });
            });
            processPromises.push(...imagePromises);
        }
        
        // Wait for all file processing to complete
        Promise.all(processPromises).then(() => {
            // Submit to test endpoint
            submitTestReport(sectionData, endpoint, sectionName);
        }).catch(error => {
            console.error('Error processing files:', error);
            // Submit anyway without files
            submitTestReport(sectionData, endpoint, sectionName);
        });
    }
    
    /**
     * Read file as base64
     */
    function readFileAsBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = e => resolve(e.target.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }
    
    /**
     * Read blob as base64
     */
    function readBlobAsBase64(blob) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = e => resolve(e.target.result);
            reader.onerror = reject;
            reader.readAsDataURL(blob);
        });
    }
    
    /**
     * Submit the test report
     */
    function submitTestReport(data, endpoint, sectionName) {
        // Create form for submission
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = endpoint;
        form.style.display = 'none';
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            addHiddenInput(form, '_token', csrfToken.getAttribute('content'));
        }
        
        // Add section name
        addHiddenInput(form, 'section', sectionName);
        
        // Add section data
        addHiddenInput(form, 'sectionData', JSON.stringify(data));
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }
    
    /**
     * Add hidden input to form
     */
    function addHiddenInput(form, name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
    
    // Public API
    return {
        init: init
    };
})();