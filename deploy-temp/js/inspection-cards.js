/**
 * Reusable Inspection Cards with Camera Functionality
 * 
 * Usage:
 * 1. Include panel-cards.css and this JS file
 * 2. Call InspectionCards.init(config) with your configuration
 * 
 * @author Claude Code
 */

window.InspectionCards = (function() {
    
    let config = {};
    let images = {};
    
    /**
     * Initialize inspection cards functionality
     * @param {Object} options - Configuration object
     */
    function init(options = {}) {
        config = {
            // Required
            items: options.items || [], // Array of items with id, category, panelId
            formId: options.formId || '', // Form element ID
            containerId: options.containerId || '', // Container for cards
            
            // Optional  
            storageKey: options.storageKey || 'inspectionData',
            imageStorageKey: options.imageStorageKey || 'inspectionImages',
            hasColorField: options.hasColorField || false,
            colorOptions: options.colorOptions || [],
            hasOverlays: options.hasOverlays || false,
            overlaySelector: options.overlaySelector || '.panel-overlay',
            
            // Callbacks
            onImageCapture: options.onImageCapture || null,
            onImageRemove: options.onImageRemove || null,
            onFormSubmit: options.onFormSubmit || null,
            
            // Field configuration
            fields: options.fields || {
                condition: { enabled: true, label: 'Condition', options: ['Good', 'Average', 'Bad'] },
                comments: { enabled: true, label: 'Comments', type: 'text', placeholder: 'Additional comments' }
            }
        };
        
        // Load existing data
        loadExistingData();
        
        // Generate cards
        generateCards();
        
        // Initialize camera functionality
        initializeCameraHandlers();
        
        // Initialize overlay interactions if enabled
        if (config.hasOverlays) {
            initializeOverlayInteractions();
        }
        
        // Initialize form handlers
        initializeFormHandlers();
    }
    
    /**
     * Generate panel cards HTML
     */
    function generateCards() {
        const container = document.getElementById(config.containerId);
        if (!container) return;
        
        config.items.forEach(item => {
            const card = createCard(item);
            container.appendChild(card);
        });
    }
    
    /**
     * Create individual card element
     */
    function createCard(item) {
        const cardDiv = document.createElement('div');
        cardDiv.className = 'panel-assessment';
        cardDiv.dataset.panel = item.panelId || item.id;
        
        let fieldsHtml = '';
        
        // Color field (if enabled)
        if (config.hasColorField && config.colorOptions.length > 0) {
            const colorOptionsHtml = config.colorOptions.map(opt => 
                `<option value="${opt.value}">${opt.text}</option>`
            ).join('');
            
            fieldsHtml += `
                <select class="form-select form-select-sm color-select" name="${item.id}-colour">
                    ${colorOptionsHtml}
                </select>
            `;
        }
        
        // Dynamic field generation based on config.fields
        Object.keys(config.fields).forEach(fieldKey => {
            const field = config.fields[fieldKey];
            if (!field.enabled) return;
            
            const fieldName = `${item.id}-${fieldKey}`;
            const fieldLabel = field.label || fieldKey;
            const placeholder = field.placeholder || fieldLabel;
            
            // Check if we should use field groups (for tyres layout) or simple layout (for panels/interior)
            const useFieldGroups = !config.hasOverlays && config.containerId === 'tyresRimsAssessments';
            
            if (field.options && Array.isArray(field.options)) {
                // Select dropdown field
                const optionsHtml = field.options.map(opt => 
                    `<option value="${opt.toLowerCase()}">${opt}</option>`
                ).join('');
                
                if (useFieldGroups) {
                    fieldsHtml += `
                        <div class="form-field-group">
                            <div class="field-label">${fieldLabel}</div>
                            <select class="form-select form-select-sm" name="${fieldName}">
                                <option value="">${fieldLabel}</option>
                                ${optionsHtml}
                            </select>
                        </div>
                    `;
                } else {
                    fieldsHtml += `
                        <select class="form-select form-select-sm" name="${fieldName}">
                            <option value="">${fieldLabel}</option>
                            ${optionsHtml}
                        </select>
                    `;
                }
            } else if (field.type === 'textarea') {
                // Textarea field
                if (useFieldGroups) {
                    fieldsHtml += `
                        <div class="form-field-group">
                            <div class="field-label">${fieldLabel}</div>
                            <textarea class="form-control form-control-sm" 
                                   name="${fieldName}" 
                                   placeholder="${placeholder}"
                                   rows="1"></textarea>
                        </div>
                    `;
                } else {
                    fieldsHtml += `
                        <textarea class="form-control form-control-sm" 
                               name="${fieldName}" 
                               placeholder="${placeholder}"
                               rows="1"></textarea>
                    `;
                }
            } else {
                // Text input field (default)
                if (useFieldGroups) {
                    fieldsHtml += `
                        <div class="form-field-group">
                            <div class="field-label">${fieldLabel}</div>
                            <input type="text" class="form-control form-control-sm" 
                                   name="${fieldName}" 
                                   placeholder="${placeholder}">
                        </div>
                    `;
                } else {
                    fieldsHtml += `
                        <input type="text" class="form-control form-control-sm" 
                               name="${fieldName}" 
                               placeholder="${placeholder}">
                    `;
                }
            }
        });
        
        cardDiv.innerHTML = `
            <div class="panel-card" data-panel-card="${item.panelId || item.id}">
                <div class="panel-card-title" data-panel-label="${item.panelId || item.id}">${item.category}</div>
                <div class="panel-controls">
                    ${fieldsHtml}
                    <button type="button" class="photo-btn" data-panel="${item.panelId || item.id}">
                        <i class="bi bi-camera-fill"></i> Photo
                    </button>
                    <input type="file" accept="image/*" capture="environment" 
                           class="d-none camera-input" id="camera-${item.panelId || item.id}">
                </div>
                <div class="image-gallery" id="gallery-${item.panelId || item.id}" style="display: none;">
                    <!-- Images will be added here -->
                </div>
            </div>
        `;
        
        return cardDiv;
    }
    
    /**
     * Initialize camera handlers
     */
    function initializeCameraHandlers() {
        // Create modal if it doesn't exist
        if (!document.getElementById('imageModal')) {
            const modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'image-modal';
            modal.innerHTML = `
                <span class="image-modal-close">&times;</span>
                <img class="image-modal-content" id="modalImage">
            `;
            document.body.appendChild(modal);

            // Modal close handlers
            modal.querySelector('.image-modal-close').onclick = function() {
                modal.style.display = 'none';
            };
            modal.onclick = function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            };
        }

        // Photo button click handlers
        document.addEventListener('click', function(e) {
            if (e.target.closest('.photo-btn')) {
                const btn = e.target.closest('.photo-btn');
                const panelId = btn.dataset.panel;
                const fileInput = document.getElementById(`camera-${panelId}`);
                if (fileInput) fileInput.click();
            }
        });

        // File input change handlers
        document.querySelectorAll('.camera-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const panelId = this.id.replace('camera-', '');
                    processImage(file, panelId);
                }
            });
        });
    }
    
    /**
     * Process captured image
     */
    function processImage(file, panelId) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const imageData = e.target.result;
            const imageId = `${panelId}-${Date.now()}`;
            
            // Store image data
            if (!images[panelId]) {
                images[panelId] = [];
            }
            
            const imageInfo = {
                id: imageId,
                data: imageData,
                timestamp: new Date().toISOString()
            };
            
            images[panelId].push(imageInfo);
            
            // Display the image
            displayImage(imageInfo, panelId);
            
            // Clear the file input
            const fileInput = document.getElementById(`camera-${panelId}`);
            if (fileInput) fileInput.value = '';
            
            // Callback
            if (config.onImageCapture) {
                config.onImageCapture(imageInfo, panelId);
            }
        };
        
        reader.readAsDataURL(file);
    }
    
    /**
     * Display image in gallery
     */
    function displayImage(imageInfo, panelId) {
        const gallery = document.getElementById(`gallery-${panelId}`);
        if (!gallery) return;
        
        // Show gallery if hidden
        if (gallery.style.display === 'none') {
            gallery.style.display = 'flex';
        }
        
        const container = document.createElement('div');
        container.className = 'image-thumbnail-container';
        container.id = `img-container-${imageInfo.id}`;
        
        container.innerHTML = `
            <img src="${imageInfo.data}" 
                 class="image-thumbnail" 
                 onclick="InspectionCards.showFullImage('${imageInfo.id}', '${panelId}')">
            <button class="remove-image" 
                    onclick="InspectionCards.removeImage('${imageInfo.id}', '${panelId}')">&times;</button>
        `;
        
        gallery.appendChild(container);
    }
    
    /**
     * Show full image in modal
     */
    function showFullImage(imageId, panelId) {
        const imageInfo = images[panelId] && images[panelId].find(img => img.id === imageId);
        if (imageInfo) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            if (modal && modalImg) {
                modal.style.display = 'block';
                modalImg.src = imageInfo.data;
            }
        }
    }
    
    /**
     * Remove image
     */
    function removeImage(imageId, panelId) {
        if (!images[panelId]) return;
        
        // Remove from storage
        images[panelId] = images[panelId].filter(img => img.id !== imageId);
        
        // Remove from DOM
        const container = document.getElementById(`img-container-${imageId}`);
        if (container) {
            container.remove();
        }
        
        // Hide gallery if no images left
        const gallery = document.getElementById(`gallery-${panelId}`);
        if (images[panelId].length === 0) {
            delete images[panelId];
            if (gallery) gallery.style.display = 'none';
        }
        
        // Callback
        if (config.onImageRemove) {
            config.onImageRemove(imageId, panelId);
        }
    }
    
    /**
     * Initialize overlay interactions
     */
    function initializeOverlayInteractions() {
        const overlays = document.querySelectorAll(config.overlaySelector);
        const labels = document.querySelectorAll('[data-panel-label]');
        
        // Overlay click and hover handlers
        overlays.forEach(overlay => {
            const panelId = overlay.dataset.panel;
            
            // Click handler
            overlay.addEventListener('click', function() {
                // Remove active from all
                overlays.forEach(p => p.classList.remove('active'));
                labels.forEach(l => l.classList.remove('active'));
                
                // Add active to current
                this.classList.add('active');
                
                // Handle button groups
                if (this.classList.contains('buttons-group') || panelId === 'buttons') {
                    document.querySelectorAll('[data-panel="buttons"]').forEach(btn => {
                        btn.classList.add('active');
                    });
                }
                
                // Highlight corresponding card and scroll
                const label = document.querySelector(`[data-panel-label="${panelId}"]`);
                if (label) {
                    label.classList.add('active');
                    label.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
            
            // Hover handlers
            overlay.addEventListener('mouseenter', function() {
                const card = document.querySelector(`.panel-card[data-panel-card="${panelId}"]`);
                if (card) card.classList.add('highlighted');
            });
            
            overlay.addEventListener('mouseleave', function() {
                const card = document.querySelector(`.panel-card[data-panel-card="${panelId}"]`);
                if (card) card.classList.remove('highlighted');
            });
        });
        
        // Label hover handlers
        labels.forEach(label => {
            const panelId = label.dataset.panelLabel;
            
            label.addEventListener('mouseenter', function() {
                const overlay = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (overlay) overlay.classList.add('active');
            });
            
            label.addEventListener('mouseleave', function() {
                const overlay = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (overlay) overlay.classList.remove('active');
            });
            
            label.addEventListener('click', function() {
                const overlay = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                if (overlay) overlay.click();
            });
        });
        
        // Condition change handlers for overlays
        document.addEventListener('change', function(e) {
            if (e.target.name && e.target.name.endsWith('-condition')) {
                const itemId = e.target.name.replace('-condition', '');
                
                // Find the item configuration to get the correct panelId
                const item = config.items.find(item => item.id === itemId);
                const panelId = item ? item.panelId : itemId;
                
                // Only proceed if there's a panelId (some items like "Other" have null panelId)
                if (panelId) {
                    const overlay = document.querySelector(`.panel-overlay[data-panel="${panelId}"]`);
                    
                    if (overlay) {
                        overlay.classList.remove('condition-good', 'condition-average', 'condition-bad', 'active');
                        if (e.target.value) {
                            overlay.classList.add(`condition-${e.target.value}`);
                        }
                    }
                }
            }
        });
    }
    
    /**
     * Initialize form handlers
     */
    function initializeFormHandlers() {
        const form = document.getElementById(config.formId);
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (config.onFormSubmit) {
                const formData = collectFormData();
                config.onFormSubmit(formData);
            } else {
                saveCurrentData();
                alert('Data saved successfully!');
            }
        });
    }
    
    /**
     * Collect form data
     */
    function collectFormData() {
        const form = document.getElementById(config.formId);
        if (!form) return {};
        
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (value && key !== '_token') {
                data[key] = value;
            }
        }
        
        // Include images
        if (Object.keys(images).length > 0) {
            data.images = images;
        }
        
        return data;
    }
    
    /**
     * Save current data to sessionStorage
     */
    function saveCurrentData() {
        const data = collectFormData();
        sessionStorage.setItem(config.storageKey, JSON.stringify(data));
    }
    
    /**
     * Load existing data from sessionStorage
     */
    function loadExistingData() {
        const savedData = sessionStorage.getItem(config.storageKey);
        if (!savedData) return;
        
        try {
            const data = JSON.parse(savedData);
            
            // Wait for DOM to be ready, then restore data
            setTimeout(() => {
                restoreFormData(data);
            }, 100);
        } catch (e) {
            console.warn('Could not load existing data:', e);
        }
    }
    
    /**
     * Restore form data and images
     */
    function restoreFormData(data) {
        Object.keys(data).forEach(key => {
            if (key === 'images') {
                // Restore images
                images = data.images;
                Object.keys(data.images).forEach(panelId => {
                    data.images[panelId].forEach(imageInfo => {
                        displayImage(imageInfo, panelId);
                    });
                });
            } else {
                // Restore form fields
                const field = document.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                    
                    // Trigger change event to ensure condition colors are applied
                    if (key.endsWith('-condition') && data[key]) {
                        const changeEvent = new Event('change', { bubbles: true });
                        field.dispatchEvent(changeEvent);
                    }
                }
            }
        });
    }
    
    // Public API
    return {
        init: init,
        showFullImage: showFullImage,
        removeImage: removeImage,
        saveData: saveCurrentData,
        loadData: loadExistingData,
        getImages: () => images,
        getFormData: collectFormData
    };
})();