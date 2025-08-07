# Inspection Cards with Camera Functionality - Usage Guide

## Single Instruction for Implementation

To add interactive panel cards with camera functionality to any page:

### 1. Include Required Files

Add to your Blade template's `@section('additional-css')`:
```php
<link rel="stylesheet" href="{{ asset('css/panel-cards.css') }}">
```

Add to your Blade template's `@section('additional-js')`:
```php
<script src="{{ asset('js/inspection-cards.js') }}"></script>
```

### 2. Use This Single JavaScript Call

```javascript
document.addEventListener('DOMContentLoaded', function() {
    InspectionCards.init({
        // Required Configuration
        formId: 'yourFormId',
        containerId: 'yourContainerId', 
        items: [
            { id: 'item_1', category: 'Component Name', panelId: 'component-id' },
            // ... more items
        ],
        
        // Optional Configuration  
        storageKey: 'yourPageData',
        hasColorField: false, // true for interior-style assessments
        hasOverlays: false,   // true if you have interactive diagrams
        
        // Custom callbacks (optional)
        onFormSubmit: function(data) {
            // Handle form submission
            console.log('Form submitted:', data);
        }
    });
});
```

## Configuration Examples

### Body Panel Style (with overlays):
```javascript
InspectionCards.init({
    formId: 'panelAssessmentForm',
    containerId: 'panelAssessments',
    storageKey: 'panelAssessmentData',
    hasOverlays: true,
    overlaySelector: '.panel-overlay',
    items: [
        { id: 'front-bumper', category: 'Front Bumper', panelId: 'front-bumper' },
        { id: 'bonnet', category: 'Bonnet', panelId: 'bonnet' }
    ]
});
```

### Interior Style (with color field):
```javascript
InspectionCards.init({
    formId: 'interiorAssessmentForm',
    containerId: 'interiorAssessments', 
    storageKey: 'interiorAssessmentData',
    hasColorField: true,
    hasOverlays: true,
    colorOptions: [
        { value: '', text: 'Select Color' },
        { value: 'Black', text: 'Black' },
        { value: 'Grey', text: 'Grey' }
    ],
    items: [
        { id: 'interior_1', category: 'Dashboard', panelId: 'dash' },
        { id: 'interior_2', category: 'Steering Wheel', panelId: 'steering-wheel' }
    ]
});
```

### Simple Assessment (no overlays):
```javascript
InspectionCards.init({
    formId: 'simpleForm',
    containerId: 'assessments',
    storageKey: 'simpleData',
    items: [
        { id: 'item_1', category: 'Component 1', panelId: 'comp-1' },
        { id: 'item_2', category: 'Component 2', panelId: 'comp-2' }
    ]
});
```

## HTML Structure Required

Your Blade template needs:
```html
<form id="yourFormId">
    @csrf
    <div id="yourContainerId">
        <!-- Cards will be generated here -->
    </div>
</form>
```

## Features Automatically Included

- ✅ Clean panel cards with form fields
- ✅ Photo buttons with camera functionality  
- ✅ Image thumbnails with removal buttons
- ✅ Full-screen modal image viewing
- ✅ Data persistence with sessionStorage
- ✅ Responsive tablet-optimized design
- ✅ Two-way highlighting (if hasOverlays: true)
- ✅ Condition-based overlay coloring
- ✅ Color dropdown support (if hasColorField: true)

## Complete Implementation Example

See `resources/views/body-panel-assessment.blade.php` and `resources/views/interior-assessment.blade.php` for full implementation examples that use this reusable system.

---

That's it! One function call gives you complete interactive assessment cards with camera functionality.