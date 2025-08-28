# Panel Card Pattern - Benchmark Template
## Vehicle Inspection System

This document defines the standardized panel card pattern used throughout the vehicle inspection system. Follow this template when creating new assessment sections.

---

## 1. Visual Layout Structure

### Panel Card Layout (3-Row Structure)
```
Row 1: Panel/Component Name (standalone, bold, larger font)
Row 2: Condition | Comments | Additional Comments (flexbox, space-between)
Row 3: Image thumbnails (if any)
```

### HTML Structure in Report View
```blade
<div class="panel-card" data-panel-card="{{ $panel['panel_id'] }}">
    <!-- Row 1: Panel Name -->
    <div class="panel-header">
        <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px; font-size: 1.1rem;">
            {{ $panel['panel_name'] }}
        </div>
    </div>
    
    <!-- Row 2: Details (all on same line) -->
    <div class="panel-details" style="display: flex; justify-content: space-between; align-items: center; margin: 15px 20px; flex-wrap: wrap;">
        <!-- Condition -->
        <div class="panel-condition" style="display: flex; align-items: center;">
            <span style="font-weight: 500; margin-right: 10px;">Condition:</span>
            <span class="condition-{{ $panel['condition'] }}">{{ ucfirst($panel['condition']) }}</span>
        </div>
        
        <!-- Dropdown Comments -->
        @if($panel['comment_type'])
        <div class="panel-dropdown-comment" style="display: flex; align-items: center;">
            <span style="font-weight: 500; margin-right: 10px;">Comments:</span>
            <span>{{ $panel['comment_type'] }}</span>
        </div>
        @endif
        
        <!-- Additional Comments -->
        @if($panel['additional_comment'])
        <div class="panel-additional-comment" style="display: flex; align-items: center;">
            <span style="font-weight: 500; margin-right: 10px;">Additional Comments:</span>
            <span>{{ $panel['additional_comment'] }}</span>
        </div>
        @endif
    </div>
    
    <!-- Row 3: Images -->
    @if(!empty($panel['images']))
    <div class="panel-images">
        <div class="images-row">
            @foreach($panel['images'] as $image)
            <div class="image-thumbnail">
                <a href="{{ $image['url'] }}" data-lightbox="panel-{{ $panel['panel_id'] }}" 
                   data-title="{{ $panel['panel_name'] }}">
                    <img src="{{ $image['thumbnail'] }}" alt="{{ $panel['panel_name'] }} image">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
```

---

## 2. Database Schema Pattern

### Table Structure Template
```sql
CREATE TABLE `{section}_assessments` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `inspection_id` bigint(20) unsigned NOT NULL,
    `{item}_name` varchar(255) NOT NULL,  -- e.g., panel_name, component_name
    `condition` enum('good','average','bad') DEFAULT NULL,
    `comment_type` varchar(255) DEFAULT NULL,  -- Dropdown selection
    `additional_comment` text DEFAULT NULL,     -- Text input
    `other_notes` text DEFAULT NULL,           -- Optional extra field
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `{section}_assessments_inspection_id_foreign` (`inspection_id`),
    CONSTRAINT `{section}_assessments_inspection_id_foreign` 
        FOREIGN KEY (`inspection_id`) REFERENCES `inspections` (`id`) ON DELETE CASCADE
);
```

---

## 3. Model Structure Pattern

### Eloquent Model Template
```php
// app/Models/{Section}Assessment.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {Section}Assessment extends Model
{
    protected $table = '{section}_assessments';
    
    protected $fillable = [
        'inspection_id',
        '{item}_name',
        'condition',
        'comment_type',
        'additional_comment',
        'other_notes'
    ];
    
    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }
}
```

### Add Relationship to Inspection Model
```php
// In app/Models/Inspection.php
public function {section}Assessments()
{
    return $this->hasMany({Section}Assessment::class);
}
```

---

## 4. Frontend Form Configuration

### InspectionCards.init() Configuration
```javascript
InspectionCards.init({
    // Required Configuration
    formId: '{section}AssessmentForm',
    containerId: '{section}Assessments',
    storageKey: '{section}AssessmentData',
    
    // Visual configuration (if has diagrams)
    hasOverlays: true,  // Set to false if no visual diagram
    overlaySelector: '.panel-overlay',
    
    // Items/Components list
    items: [
        { id: '{section}_1', category: 'Component Name 1', panelId: 'component-1' },
        { id: '{section}_2', category: 'Component Name 2', panelId: 'component-2' },
        // ... more items
    ],
    
    // Field configuration (STANDARDIZED)
    fields: {
        condition: { 
            enabled: true, 
            label: 'Condition', 
            options: ['Good', 'Average', 'Bad'] 
        },
        comments: { 
            enabled: true, 
            label: 'Comments', 
            type: 'select',
            options: ['Option 1', 'Option 2', 'Option 3', 'etc'] // Customize per section
        },
        additional_comments: { 
            enabled: true, 
            label: 'Additional Comments', 
            type: 'text', 
            placeholder: 'Additional comments' 
        }
    },
    
    // Navigation callback
    onFormSubmit: function(data) {
        sessionStorage.setItem('{section}AssessmentData', JSON.stringify(data));
        window.location.href = '/inspection/{next-section}';
    }
});
```

---

## 5. API Endpoint Pattern

### Controller Method for Saving
```php
// In app/Http/Controllers/InspectionController.php
public function save{Section}Assessment(Request $request)
{
    $validated = $request->validate([
        'inspection_id' => 'nullable|exists:inspections,id',
        'components' => 'nullable|array',
        'components.*.component_name' => 'nullable|string',
        'components.*.condition' => 'nullable|in:good,average,bad,Good,Average,Bad',
        'components.*.comment_type' => 'nullable|string',
        'components.*.additional_comment' => 'nullable|string',
        'images' => 'nullable|array'
    ]);
    
    DB::beginTransaction();
    
    try {
        $inspectionId = $validated['inspection_id'] ?? session('current_inspection_id');
        $inspection = Inspection::findOrFail($inspectionId);
        
        // Delete existing assessments
        {Section}Assessment::where('inspection_id', $inspectionId)->delete();
        
        // Save new assessments
        if (!empty($validated['components'])) {
            foreach ($validated['components'] as $component) {
                if (!empty($component['condition']) || !empty($component['comment_type']) || 
                    !empty($component['additional_comment'])) {
                    
                    {Section}Assessment::create([
                        'inspection_id' => $inspectionId,
                        '{item}_name' => $component['component_name'],
                        'condition' => strtolower($component['condition'] ?? null),
                        'comment_type' => $component['comment_type'] ?? null,
                        'additional_comment' => $component['additional_comment'] ?? null
                    ]);
                }
            }
        }
        
        // Handle images (using the nested array structure)
        if (!empty($validated['images'])) {
            foreach ($validated['images'] as $componentName => $imageList) {
                if (is_array($imageList)) {
                    foreach ($imageList as $imageInfo) {
                        if (!empty($imageInfo['data'])) {
                            // Process and save image
                            // ... (image processing code)
                        }
                    }
                }
            }
        }
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => '{Section} assessment saved successfully',
            'inspection_id' => $inspectionId
        ]);
        
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'message' => 'Failed to save {section} assessment',
            'error' => $e->getMessage()
        ], 500);
    }
}
```

### Route Registration
```php
// In routes/web.php
Route::post('/api/inspection/{section}', [InspectionController::class, 'save{Section}Assessment']);
```

---

## 6. Frontend Field Mapping

### CRITICAL: Form to Database Field Mapping
```javascript
// In the assessment blade template, map form fields to database columns
const panelMap = {};
for (const [key, value] of Object.entries(formData)) {
    const match = key.match(/^([^-]+)-(.+)$/);
    if (match) {
        const componentId = match[1];
        const fieldName = match[2];
        
        if (!panelMap[componentId]) {
            panelMap[componentId] = { component_name: componentId };
        }
        
        // STANDARDIZED FIELD MAPPING
        if (fieldName === 'condition') {
            panelMap[componentId].condition = value;
        } else if (fieldName === 'comments') {
            // Dropdown maps to 'comment_type'
            panelMap[componentId].comment_type = value;
        } else if (fieldName === 'additional_comments') {
            // Text input maps to 'additional_comment'
            panelMap[componentId].additional_comment = value;
        } else {
            panelMap[componentId][fieldName] = value;
        }
    }
}
```

---

## 7. Report Display Pattern

### ReportController Data Formatting
```php
// In app/Http/Controllers/ReportController.php
private function format{Section}AssessmentsForReport($inspection)
{
    ${section}Data = [];
    
    if ($inspection->{section}Assessments) {
        foreach ($inspection->{section}Assessments as $assessment) {
            // Get images for this component
            $componentImages = [];
            $searchName = $assessment->{item}_name;
            
            ${section}Images = $inspection->images()
                ->where('image_type', 'specific_area')
                ->where('area_name', $searchName)
                ->get();
            
            foreach (${section}Images as $image) {
                $fullPath = storage_path('app/public/' . $image->file_path);
                if (file_exists($fullPath)) {
                    $componentImages[] = [
                        'url' => asset('storage/' . $image->file_path),
                        'thumbnail' => asset('storage/' . $image->file_path),
                        'timestamp' => $image->created_at->format('Y-m-d H:i:s')
                    ];
                }
            }
            
            ${section}Data[] = [
                'panel_id' => $assessment->{item}_name,
                'panel_name' => $this->format{Section}Name($assessment->{item}_name),
                'condition' => $assessment->condition,
                'comment_type' => $assessment->comment_type,
                'additional_comment' => $assessment->additional_comment,
                'images' => $componentImages
            ];
        }
    }
    
    return ${section}Data;
}

// Add to showWeb() method
$inspectionData['{section}'] = $this->format{Section}AssessmentsForReport($inspection);
```

---

## 8. Naming Conventions

### Database
- Table: `{section}_assessments` (snake_case, plural)
- Columns: `{item}_name`, `comment_type`, `additional_comment` (snake_case)

### Models
- Class: `{Section}Assessment` (PascalCase, singular)
- Relationship: `{section}Assessments()` (camelCase, plural)

### Frontend
- Form ID: `{section}AssessmentForm` (camelCase)
- Container ID: `{section}Assessments` (camelCase)
- Storage Key: `{section}AssessmentData` (camelCase)

### API
- Endpoint: `/api/inspection/{section}` (kebab-case)
- Method: `save{Section}Assessment` (camelCase)

---

## 9. Visual Diagram with Overlays (Optional)

If the section includes a visual diagram with clickable areas:

### CSS Mask Overlay Pattern
```blade
<div class="overlay" 
     data-panel="{{ $component['id'] }}"
     data-condition="{{ strtolower($condition) }}"
     style="position: absolute; {{ $component['style'] }} 
            -webkit-mask-image: url('/images/{section}/{{ $imageName }}'); 
            mask-image: url('/images/{section}/{{ $imageName }}'); 
            -webkit-mask-repeat: no-repeat; 
            mask-repeat: no-repeat; 
            -webkit-mask-position: center; 
            mask-position: center; 
            -webkit-mask-size: contain; 
            mask-size: contain;">
</div>
```

### Condition Legend (Below Diagram)
```blade
<div class="condition-legend" style="display: flex; justify-content: center; align-items: center; gap: 30px; margin: 20px auto; padding: 10px;">
    <div class="legend-title" style="font-weight: 600;">Condition Status:</div>
    <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
        <span class="legend-color good"></span>
        <span class="legend-label">Good</span>
    </div>
    <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
        <span class="legend-color average"></span>
        <span class="legend-label">Average</span>
    </div>
    <div class="legend-item" style="display: flex; align-items: center; gap: 8px;">
        <span class="legend-color bad"></span>
        <span class="legend-label">Poor</span>
    </div>
</div>
```

---

## 10. Implementation Checklist

When creating a new section, ensure:

- [ ] Database migration created with correct schema
- [ ] Model created with relationships
- [ ] Frontend form uses InspectionCards.init() with standard fields
- [ ] Field mapping follows the standard (comments → comment_type, additional_comments → additional_comment)
- [ ] API endpoint created in InspectionController
- [ ] Route registered in routes/web.php
- [ ] Report formatting method added to ReportController
- [ ] Report view section added with panel card layout
- [ ] Images handled with nested array structure
- [ ] Navigation to next section configured
- [ ] Visual diagram (if applicable) with CSS mask overlays
- [ ] Condition legend placed below diagram

---

## Example: Creating "Engine Compartment" Section

1. **Migration**: `create_engine_compartment_assessments_table.php`
2. **Model**: `EngineCompartmentAssessment.php`
3. **View**: `engine-compartment-assessment.blade.php`
4. **Controller Method**: `saveEngineCompartmentAssessment()`
5. **Route**: `Route::post('/api/inspection/engine-compartment', ...)`
6. **Report Method**: `formatEngineCompartmentAssessmentsForReport()`
7. **Comments Options**: ['Oil Leak', 'Worn Belt', 'Corrosion', 'Damage', 'Missing Part']

---

## Notes

- Always use the 3-row panel card structure
- Keep field names consistent across all sections
- Use flexbox with space-between for Row 2
- Images are optional but follow the same thumbnail pattern
- The condition legend is only needed when there's a visual diagram
- All text should be properly escaped in Blade templates
- Use transactions for database operations
- Validate all input data