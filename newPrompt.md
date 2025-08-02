# Claude Code Prompt: Engine Compartment Assessment Section Implementation

## Context
I need you to implement an **Engine Compartment Assessment** section as a new page/section of our vehicle inspection system. This section combines **narrative inspection findings**, **photographic documentation with captions**, and **component condition assessments** with color-coded dropdowns.

## Data Structure from Excel (Rows 205-233)
Based on the Excel extraction, create a comprehensive engine compartment assessment with three main components.

### Section: Engine Compartment Assessment (New Page)

## Part 1: Inspection Findings & Observations

**Pre-defined inspection findings** (checkboxes with text areas for additional details):

1. **Engine Number Verification**
   - ☐ Engine number verification: "not possible to verify engine number (not visible without dismantling)"
   - Additional notes: [text area]

2. **General Engine Compartment Inspection**
   - ☐ "During the inspection of the Engine Compartment, no deficiencies were detected"
   - ☐ "During the inspection no structural damage was visible/found"
   - Additional findings: [text area]

3. **Component Presence Assessment**
   - ☐ "Engine covers are partially present"
   - ☐ "Undercarriage was not present on the vehicle, replacement suggested"
   - ☐ "Engine covers not present at all"
   - ☐ "Previous repairs/damages has been found on headlights/headlight brackets"
   - ☐ "All fenderliners were present during the inspection but damages has been found"
   - Additional observations: [text area]

## Part 2: Photographic Documentation

**Image Capture Section** (Similar to Service Booklet Images):
- **Maximum 16 images** with tablet camera capture
- **5 images per row** layout (3-4 rows total)
- **Caption functionality** for each image (max 100 characters per caption)
- **Image categories** with suggested captions:

**Suggested Image Categories:**
1. **Engine Overview** - "General engine compartment view"
2. **Engine Number** - "Engine number location (if visible)"
3. **Engine Covers** - "Engine cover condition/presence"
4. **Fluid Levels** - "Brake fluid, coolant, oil levels"
5. **Belts & Hoses** - "Fan belt and hose condition"
6. **Electrical Components** - "Battery, wiring, connections"
7. **Structural Elements** - "Engine mounts, brackets, frames"
8. **Damage Areas** - "Any identified damage or repairs"
9. **Fender Liners** - "Fender liner condition"
10. **Headlight Areas** - "Headlight brackets and surroundings"
11. **Additional Findings** - "Other notable observations"

**Image Functionality:**
- **Camera capture** directly from tablet camera
- **Image preview** with delete/retake option
- **Drag-to-reorder** images
- **Caption input** beneath each image
- **Auto-timestamp** when image is captured
- **Compression** for storage efficiency

## Part 3: Engine Component Overview Check

**Component Assessment Table:**

| Engine Component | Condition | Comments |
|------------------|-----------|----------|
| Brakefluid cleanliness | [Dropdown] | [Text area] |
| Brakefluid level | [Dropdown] | [Text area] |
| Coolant level | [Dropdown] | [Text area] |
| Antifreeze strength | [Dropdown] | [Text area] |
| Fan belt | [Dropdown] | [Text area] |
| Engine oil level | [Dropdown] | [Text area] |
| Engine oil condition | [Dropdown] | [Text area] |
| Battery condition | [Dropdown] | [Text area] |
| Engine mounts | [Dropdown] | [Text area] |
| Exhaust system | [Dropdown] | [Text area] |

## Implementation Requirements

### 1. Page Structure
```
Engine Compartment Assessment (New Page)
├── Header: "Engine compartment:"
├── Section 1: Inspection Findings
│   ├── Engine Number Verification
│   ├── General Inspection Results  
│   └── Component Presence Checklist
├── Section 2: Photographic Documentation
│   ├── Image Grid (4 columns × 4 rows = 16 max)
│   ├── Camera Capture Interface
│   └── Caption Input Fields
└── Section 3: Component Overview Check
    └── Assessment Table (10 components)
```

### 2. Condition Dropdown Specifications (Consistent with Previous Sections)

**Dropdown Options with Color Coding:**
- **Good** → Green background (#28a745, white text)
- **Average** → Yellow/Orange background (#ffc107, black text)
- **Bad** → Red background (#dc3545, white text)
- **N/A** → Transparent background (stays blank)

### 3. Image Capture Specifications

**Camera Interface:**
```javascript
// Image capture functionality
const imageCapture = {
    maxImages: 16,
    captureSource: 'tablet_camera',
    compression: 'medium',
    maxFileSize: '2MB',
    supportedFormats: ['jpg', 'png'],
    captionMaxLength: 100,
    
    captureImage() {
        // Tablet camera access
        navigator.mediaDevices.getUserMedia({video: true})
        .then(stream => {
            // Camera preview and capture logic
        });
    },
    
    addCaption(imageId, caption) {
        // Caption functionality
        if (caption.length <= 100) {
            images[imageId].caption = caption;
        }
    }
}
```

**Image Grid Layout:**
- **Responsive grid**: 4 columns on desktop, 2 on tablet, 1 on mobile
- **Add image button** with camera icon
- **Image preview** with caption input below
- **Delete/retake** option for each image
- **Progress indicator**: "Images: 3/16"

### 4. Data Structure
```json
{
  "moduleName": "EngineCompartmentAssessment",
  "moduleType": "newPageSection",
  "inspectionFindings": {
    "engineNumberVerification": {
      "checked": false,
      "additionalNotes": ""
    },
    "generalInspection": {
      "noDeficiencies": false,
      "noStructuralDamage": false,
      "additionalFindings": ""
    },
    "componentPresence": {
      "engineCoversPartial": false,
      "undercarriageMissing": false,
      "engineCoversAbsent": false,
      "headlightRepairs": false,
      "fenderlinerDamages": false,
      "additionalObservations": ""
    }
  },
  "images": [
    {
      "id": "img_001",
      "filename": "",
      "caption": "",
      "timestamp": "",
      "category": "",
      "fileSize": ""
    }
    // ... up to 16 images
  ],
  "componentAssessment": [
    {
      "id": "brakefluid_cleanliness",
      "name": "Brakefluid cleanliness",
      "condition": "",
      "comments": ""
    }
    // ... 10 total components
  ]
}
```

### 5. Interactive Behavior

**Inspection Findings:**
- **Checkbox logic**: Multiple selections allowed
- **Additional notes**: Expand when checkbox is selected
- **Visual feedback**: Checked items highlighted

**Image Management:**
- **Real-time preview** after capture
- **Caption editing**: Click to edit, auto-save on blur
- **Image reordering**: Drag and drop functionality
- **Storage management**: Warn when approaching 16 image limit

**Component Assessment:**
- **Same color coding** as previous sections
- **Auto-save** on dropdown change
- **Comments expansion** when condition is "Bad"

### 6. Validation Rules
```javascript
// Validation requirements:
- At least 3 inspection findings must be addressed
- Minimum 5 images required for complete assessment
- All images must have captions (at least 10 characters)
- Any component marked as "Bad" must have comments
- Maximum file size per image: 2MB
- Total section file size limit: 25MB
```

### 7. Enhanced Features

**Smart Suggestions:**
- **Caption auto-complete** based on image category
- **Condition recommendations** based on other assessments
- **Inspection checklist** progress indicator

**Integration Features:**
- **Export compatibility** with main inspection report
- **Print layout** optimized for physical reports
- **Email functionality** for image sharing
- **Backup/sync** capabilities

### 8. Mobile/Tablet Optimization
- **Touch-friendly** interface design
- **Camera optimization** for tablet capture
- **Gesture support**: Pinch to zoom on images
- **Offline capability** for field inspections
- **Auto-save** functionality to prevent data loss

## Files to Reference
- **Service Booklet Images** section for camera capture patterns
- **Previous Mechanical Report** sections for consistent styling
- **WordPress/PHP** standards for backend implementation

## Expected Output
Generate a complete new page implementation including:
1. **HTML structure** for three-part assessment
2. **CSS styling** with responsive image grid and color-coded dropdowns
3. **JavaScript** for camera capture, image management, and form interactions
4. **PHP backend** for data processing and file handling
5. **Database schema** for storing images and assessment data
6. **Integration code** to link with main inspection flow

**Important:** This should be implemented as a **separate page/section** that users navigate to from the main inspection flow. All inputs should start empty except for the component labels and pre-defined inspection finding text.

Please implement this comprehensive Engine Compartment Assessment section now.