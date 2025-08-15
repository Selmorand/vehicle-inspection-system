This procedure documents the complete process to add a new assessment section (Tyres & Rims) to   
  the vehicle inspection system, including database integration, form functionality, image handling,
   and report generation.

  Step 1: Frontend Form Development

  1.1 Create Assessment Page Template

  - Create resources/views/tyres-rims-assessment.blade.php
  - Copy structure from existing assessment pages (interior/body panel)
  - Include breadcrumb navigation with proper active state
  - Add form with CSRF protection

  1.2 Configure InspectionCards System

  InspectionCards.init({
      formId: 'tyresRimsAssessmentForm',
      containerId: 'tyresRimsAssessments',
      storageKey: 'tyresRimsAssessmentData',
      hasOverlays: false,
      items: [
          { id: 'front_left', category: 'Front Left Tyre', panelId: 'front-left' },
          { id: 'front_right', category: 'Front Right Tyre', panelId: 'front-right' },
          { id: 'rear_left', category: 'Rear Left Tyre', panelId: 'rear-left' },
          { id: 'rear_right', category: 'Rear Right Tyre', panelId: 'rear-right' },
          { id: 'spare', category: 'Spare Tyre', panelId: 'spare' }
      ],
      fields: {
          size: { enabled: true, label: 'Size', type: 'text' },
          manufacture: { enabled: true, label: 'Manufacture', type: 'text' },
          model: { enabled: true, label: 'Model', type: 'text' },
          tread_depth: { enabled: true, label: 'Tread Depth (mm)', type: 'text' },
          damages: {
              enabled: true,
              label: 'Damages',
              type: 'select',
              options: ['None', 'Puncture', 'Sidewall damage', 'Tread', 'Uneven rundown', 'Mag 
  scuffed', 'Bulges', 'Cracking']
          }
      }
  });

  1.3 Add Section-Specific Content

  - Include tyre safety disclaimer text
  - Add proper CSS styling for responsive layout
  - Configure navigation buttons (Back, Save Draft, Continue)

  Step 2: Database Schema

  2.1 Create Migration

  php artisan make:migration create_tyres_rims_table

  2.2 Define Table Structure

  Schema::create('tyres_rims', function (Blueprint $table) {
      $table->id();
      $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
      $table->string('component_name', 50); // front_left, front_right, etc.
      $table->string('size', 100)->nullable();
      $table->string('manufacture', 100)->nullable();
      $table->string('model', 100)->nullable();
      $table->string('tread_depth', 50)->nullable();
      $table->string('damages', 100)->nullable();
      $table->timestamps();

      $table->index('inspection_id');
  });

  2.3 Run Migration

  php artisan migrate

  Step 3: Backend API Development

  3.1 Add Route

  In routes/web.php:
  Route::post('/api/inspection/tyres-rims',
  'saveTyresRimsAssessment')->name('api.inspection.tyres-rims');

  3.2 Create Controller Method

  In InspectionController.php:
  public function saveTyresRimsAssessment(Request $request)
  {
      $validated = $request->validate([
          'inspection_id' => 'nullable|exists:inspections,id',
          'components' => 'nullable|array',
          'components.*.component_name' => 'nullable|string',
          'components.*.size' => 'nullable|string',
          'components.*.manufacture' => 'nullable|string',
          'components.*.model' => 'nullable|string',
          'components.*.tread_depth' => 'nullable|numeric', // Accept numeric input
          'components.*.damages' => 'nullable|string',
          'images' => 'nullable|array'
      ]);

      DB::beginTransaction();

      try {
          $inspection = Inspection::findOrFail($validated['inspection_id']);

          // Delete existing data for updates
          DB::table('tyres_rims')->where('inspection_id', $inspection->id)->delete();

          // Save component data with tread_depth formatting
          if (isset($validated['components'])) {
              foreach ($validated['components'] as $component) {
                  // Format tread_depth with mm suffix if numeric
                  $treadDepth = null;
                  if (isset($component['tread_depth']) && is_numeric($component['tread_depth'])) {       
                      $treadDepth = $component['tread_depth'] . 'mm';
                  } elseif (isset($component['tread_depth']) && !empty($component['tread_depth'])) {     
                      $treadDepth = $component['tread_depth'];
                  }

                  DB::table('tyres_rims')->insert([
                      'inspection_id' => $inspection->id,
                      'component_name' => $component['component_name'] ?? '',
                      'size' => $component['size'] ?? null,
                      'manufacture' => $component['manufacture'] ?? null,
                      'model' => $component['model'] ?? null,
                      'tread_depth' => $treadDepth,
                      'damages' => $component['damages'] ?? null,
                      'created_at' => now(),
                      'updated_at' => now()
                  ]);
              }
          }

          // Save images (using file_path column, not image_path)
          if (isset($validated['images'])) {
              foreach ($validated['images'] as $componentName => $componentImages) {
                  foreach ($componentImages as $image) {
                      if (isset($image['data'])) {
                          // Process base64 image
                          $imageData = $image['data'];
                          if (strpos($imageData, 'data:image') === 0) {
                              $imageData = substr($imageData, strpos($imageData, ',') + 1);
                          }

                          $decodedImage = base64_decode($imageData);
                          $fileName = 'tyres_' . $inspection->id . '_' . $componentName . '_' .
  uniqid() . '.jpg';
                          $path = 'inspections/' . $inspection->id . '/tyres/' . $fileName;

                          Storage::disk('public')->put($path, $decodedImage);

                          DB::table('inspection_images')->insert([
                              'inspection_id' => $inspection->id,
                              'image_type' => 'tyres_rims',
                              'file_path' => $path, // Note: file_path not image_path
                              'area_name' => $componentName,
                              'created_at' => now(),
                              'updated_at' => now()
                          ]);
                      }
                  }
              }
          }

          DB::commit();
          return response()->json(['success' => true, 'message' => 'Tyres & Rims assessment saved        
  successfully']);

      } catch (\Exception $e) {
          DB::rollBack();
          return response()->json(['success' => false, 'message' => 'Error saving tyres assessment:      
  ' . $e->getMessage()], 500);
      }
  }

  Step 4: Frontend Database Integration

  4.1 Replace Simple Navigation

  Replace simple window.location.href with comprehensive API call:

  document.getElementById('nextBtn').addEventListener('click', async function(e) {
      e.preventDefault();

      // Get form data and images
      let formData = {};
      let imageData = {};

      try {
          if (window.InspectionCards && typeof InspectionCards.getFormData === 'function') {
              formData = InspectionCards.getFormData();
              imageData = InspectionCards.getImages();
          }
      } catch (e) {
          console.error('Error getting InspectionCards data:', e);
      }

      const inspectionId = sessionStorage.getItem('currentInspectionId');

      // Prepare API data structure
      const apiData = {
          inspection_id: inspectionId,
          components: [],
          images: imageData
      };

      // Extract component data from form data
      const componentMap = {};
      for (const [key, value] of Object.entries(formData)) {
          const match = key.match(/^([^-]+)-(.+)$/);
          if (match) {
              const componentId = match[1];
              const fieldName = match[2];

              if (!componentMap[componentId]) {
                  componentMap[componentId] = { component_name: componentId };
              }

              // Map field names to expected backend format
              componentMap[componentId][fieldName] = value;
          }
      }

      apiData.components = Object.values(componentMap);

      try {
          // Save to database via API
          const response = await fetch('/api/inspection/tyres-rims', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN':
  document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Accept': 'application/json'
              },
              body: JSON.stringify(apiData)
          });

          if (!response.ok) {
              const errorText = await response.text();
              throw new Error(`HTTP ${response.status}: ${errorText}`);
          }

          const result = await response.json();

          if (result.success) {
              // Show success notification
              const notification = document.createElement('div');
              notification.style.cssText = `
                  position: fixed; top: 20px; right: 20px; padding: 15px 20px;
                  background: #28a745; color: white; border-radius: 5px;
                  box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10000;
                  font-weight: 500;
              `;
              notification.textContent = '✅ Tyres & Rims data saved successfully!';
              document.body.appendChild(notification);

              // Navigate after delay
              setTimeout(() => {
                  notification.remove();
                  window.location.href = '/inspection/mechanical-report';
              }, 1500);
          } else {
              throw new Error(result.message || 'Failed to save tyres & rims data');
          }

      } catch (error) {
          console.error('Failed to save tyres & rims assessment:', error);

          // Show error notification and fallback
          // ... error handling code
      }
  });

  Step 5: Report Integration

  5.1 Update ReportController Data Loading

  In ReportController.php, add to showWeb() method:
  'tyres_rims' => $this->formatTyresRimsForReport($inspection)

  5.2 Create Data Formatting Method

  private function formatTyresRimsForReport($inspection)
  {
      $tyresData = [];

      $tyresRims = \DB::table('tyres_rims')
          ->where('inspection_id', $inspection->id)
          ->get();

      foreach ($tyresRims as $tyre) {
          // Handle naming convention mismatch (underscores vs hyphens)
          $componentNameUnderscore = $tyre->component_name;
          $componentNameHyphen = str_replace('_', '-', $tyre->component_name);

          $images = $inspection->images()
              ->where('image_type', 'tyres_rims')
              ->where(function($query) use ($componentNameUnderscore, $componentNameHyphen) {
                  $query->where('area_name', $componentNameUnderscore)
                        ->orWhere('area_name', $componentNameHyphen);
              })
              ->get();

          $tyreImages = [];
          foreach ($images as $image) {
              $fullPath = storage_path('app/public/' . $image->file_path);
              if (file_exists($fullPath)) {
                  $tyreImages[] = [
                      'url' => asset('storage/' . $image->file_path),
                      'created_at' => $image->created_at->format('Y-m-d H:i:s')
                  ];
              }
          }

          $tyresData[] = [
              'component_name' => $tyre->component_name,
              'size' => $tyre->size,
              'manufacture' => $tyre->manufacture,
              'model' => $tyre->model,
              'tread_depth' => $tyre->tread_depth,
              'damages' => $tyre->damages,
              'images' => $tyreImages
          ];
      }

      return $tyresData;
  }

  5.3 Exclude Images from General Gallery

  Update organizeImagesForReport() method:
  // Skip tyres_rims images - they're handled separately
  if ($image->image_type === 'tyres_rims') {
      continue;
  }

  5.4 Add Report Section Template

  In web-report.blade.php, add after Service Booklet section:
  <!-- Tyres & Rims Assessment -->
  @if(!empty($inspectionData['tyres_rims']))
  <div class="section">
      <h2 class="section-title">
          <i class="bi bi-circle"></i>
          Tyres & Rims Assessment
      </h2>

      @foreach($inspectionData['tyres_rims'] as $tyre)
      <div class="panel-card" data-tyre-card="{{ $tyre['component_name'] ?? '' }}">
          <!-- First Row: Tyre Name -->
          <div class="panel-header">
              <div class="panel-name" style="width: 100%; font-weight: 600; margin-bottom: 10px;
  font-size: 1.1rem;">
                  @php
                      $tyreName = str_replace('_', ' ', $tyre['component_name'] ?? '');
                      $tyreName = ucwords($tyreName);
                  @endphp
                  {{ $tyreName }}
              </div>
          </div>

          <!-- Second Row: Tyre Details -->
          <div class="panel-details" style="display: flex; justify-content: space-between;
  align-items: center; margin: 15px 20px; flex-wrap: wrap; gap: 15px;">
              @if(!empty($tyre['size']))
              <div class="tyre-size" style="display: flex; align-items: center;">
                  <span style="font-weight: 500; margin-right: 10px;">Size:</span>
                  <span>{{ $tyre['size'] }}</span>
              </div>
              @endif

              @if(!empty($tyre['manufacture']))
              <div class="tyre-manufacture" style="display: flex; align-items: center;">
                  <span style="font-weight: 500; margin-right: 10px;">Manufacture:</span>
                  <span>{{ $tyre['manufacture'] }}</span>
              </div>
              @endif

              @if(!empty($tyre['model']))
              <div class="tyre-model" style="display: flex; align-items: center;">
                  <span style="font-weight: 500; margin-right: 10px;">Model:</span>
                  <span>{{ $tyre['model'] }}</span>
              </div>
              @endif

              @if(!empty($tyre['tread_depth']))
              <div class="tyre-tread" style="display: flex; align-items: center;">
                  <span style="font-weight: 500; margin-right: 10px;">Tread Depth:</span>
                  <span>{{ $tyre['tread_depth'] }}</span>
              </div>
              @endif

              @if(!empty($tyre['damages']))
              <div class="tyre-damages" style="display: flex; align-items: center;">
                  <span style="font-weight: 500; margin-right: 10px;">Damages:</span>
                  <span class="{{ $tyre['damages'] === 'None' ? 'text-success' : 'text-warning'
  }}">{{ $tyre['damages'] }}</span>
              </div>
              @endif
          </div>

          <!-- Third Row: Images -->
          @if(!empty($tyre['images']))
          <div class="panel-images" style="padding: 15px 20px; border-top: 1px solid #e0e0e0;">
              <div class="images-label" style="font-weight: 500; margin-bottom: 10px;">Images:</div>     
              <div class="tyre-images-grid" style="display: grid; grid-template-columns:
  repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 1.5rem;">
                  @foreach($tyre['images'] as $image)
                  <div class="tyre-image-card" style="border: 1px solid #dee2e6; border-radius: 8px;     
   overflow: hidden; background: white;">
                      <a href="{{ $image['url'] }}" data-lightbox="tyre-{{ $tyre['component_name']       
  }}" data-title="{{ $tyreName }}">
                          <img src="{{ $image['url'] }}" alt="{{ $tyreName }}" style="width: 100%;       
  height: 200px; object-fit: cover; cursor: pointer;">
                      </a>
                      <div style="padding: 10px; text-align: center; font-size: 0.9rem; color:
  #6c757d;">
                          {{ ucwords(str_replace(['_', '-'], ' ', $tyre['component_name'])) }}
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>
          @endif
      </div>
      @endforeach

      <!-- Tyre Safety Disclaimer -->
      <div class="alert alert-info mt-4" style="background-color: #e8f4f8; border-color: #4f959b;        
  border-radius: 8px; padding: 20px;">
          <h4 style="color: #4f959b; margin-bottom: 15px;">
              <i class="bi bi-info-circle"></i> Tyre Safety Information
          </h4>
          <p style="margin-bottom: 10px; line-height: 1.6;">
              It is recommended that tyres are replaced when the tread depth reaches 2mm. If uneven      
  tyre wear is noted, this may indicate incorrect geometry, which can result in excessive and rapid      
  tyre wear. A full steering and geometry check is therefore recommended.
          </p>
          <p style="margin-bottom: 10px; line-height: 1.6;">
              If this vehicle is fitted with "Run Flat" tyres and no spare wheel. The tyre's
  effectiveness in a puncture situation cannot be commented on.
          </p>
          <p style="margin-bottom: 0; line-height: 1.6;">
              It is advised to have tyres of the correct size and of similar make, tread pattern and     
   tread depth across axles. This will benefit steering and handling, the operation of the
  transmission, 4 wheel drive, traction control, ABS and puncture detection systems. This can also       
  prevent premature transmission wear or failure.
          </p>
      </div>
  </div>
  @endif

  Step 6: Data Persistence Management

  6.1 Update Session Clearing Functions

  Add tyresRimsAssessmentData to clearing functions in:

  Dashboard.blade.php:
  function clearInspectionData() {
      sessionStorage.removeItem('tyresRimsAssessmentData');
      // ... other removals
  }

  Visual-inspection.blade.php:
  // Starting a new inspection - clear all data
  sessionStorage.removeItem('tyresRimsAssessmentData');
  // ... other removals

  Body-panel-assessment.blade.php:
  // Starting a new inspection - clear all data  
  sessionStorage.removeItem('tyresRimsAssessmentData');
  // ... other removals

  Step 7: Testing and Validation

  7.1 Test Data Flow

  1. Complete form with all tyre details
  2. Take photos for multiple tyres
  3. Submit form and verify API success
  4. Check database for correct data storage
  5. View report and verify display

  7.2 Test Edge Cases

  1. Empty form submission
  2. Numeric vs string tread depth values
  3. Image naming convention mismatches
  4. New inspection data clearing

  7.3 Common Issues and Solutions

  Issue: Images not displaying in reports
  - Check naming convention mismatch (underscores vs hyphens)
  - Verify image_type is 'tyres_rims'
  - Ensure using 'file_path' not 'image_path' column

  Issue: Validation errors on tread_depth
  - Ensure validation accepts 'numeric' not 'string'
  - Add formatting logic for mm suffix

  Issue: Data persists between inspections
  - Add storage key to all clearing functions
  - Use exact key name from InspectionCards config

  Step 8: Final Integration

  8.1 Update Navigation

  - Add route to web.php
  - Update breadcrumb navigation
  - Ensure proper flow between sections

  8.2 Production Considerations

  - Test with real image sizes
  - Verify responsive design on tablets
  - Check performance with multiple images
  - Validate all field constraints

  This procedure can be adapted for adding any new assessment section to the vehicle inspection
  system.

