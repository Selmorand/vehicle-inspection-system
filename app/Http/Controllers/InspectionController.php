<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Inspection;
use App\Models\BodyPanelAssessment;
use App\Models\InspectionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InspectionController extends Controller
{
    public function visualInspection()
    {
        return view('visual-inspection');
    }

    public function bodyPanelAssessment()
    {
        return view('body-panel-assessment');
    }

    public function interiorAssessment()
    {
        return view('interior-assessment');
    }

    public function serviceBooklet()
    {
        return view('service-booklet');
    }

    public function tyresRimsAssessment()
    {
        return view('tyres-rims-assessment');
    }

    public function mechanicalReport()
    {
        return view('mechanical-report');
    }

    public function engineCompartmentAssessment()
    {
        return view('engine-compartment-assessment');
    }

    public function physicalHoistInspection()
    {
        return view('physical-hoist-inspection');
    }

    public function saveVisualInspection(Request $request)
    {
        // TESTING: All fields made optional for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspector_name' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'vin' => 'nullable|string|max:50',
            'manufacturer' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:50',
            'colour' => 'nullable|string|max:50',
            'doors' => 'nullable|string|max:20',
            'fuel_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'engine_number' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:50',
            'year_model' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'km_reading' => 'nullable|integer|min:0',
            'diagnostic_report' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:10240' // 10MB max per image
        ]);

        DB::beginTransaction();

        try {
            // Create or update client (handle null values for testing)
            $client = null;
            if (!empty($validated['client_name'])) {
                $client = Client::firstOrCreate(
                    ['name' => $validated['client_name']]
                );
            } else {
                // Create a dummy client for testing
                $client = Client::firstOrCreate(
                    ['name' => 'Test Client']
                );
            }

            // Create or update vehicle (handle null values for testing)
            $vin = $validated['vin'] ?: 'TEST-VIN-' . uniqid();
            $vehicle = Vehicle::updateOrCreate(
                ['vin' => $vin],
                [
                    'manufacturer' => $validated['manufacturer'] ?: 'Test Manufacturer',
                    'model' => $validated['model'] ?: 'Test Model',
                    'vehicle_type' => $validated['vehicle_type'] ?: 'passenger vehicle',
                    'colour' => $validated['colour'],
                    'doors' => $validated['doors'],
                    'fuel_type' => $validated['fuel_type'],
                    'transmission' => $validated['transmission'],
                    'engine_number' => $validated['engine_number'],
                    'registration_number' => $validated['registration_number'],
                    'year' => $validated['year_model'],
                    'mileage' => $validated['km_reading']
                ]
            );

            // Create inspection (handle null values for testing)
            $inspection = Inspection::create([
                'client_id' => $client->id,
                'vehicle_id' => $vehicle->id,
                'inspector_name' => $validated['inspector_name'] ?: 'Test Inspector',
                'inspection_date' => now(),
                'diagnostic_report' => $validated['diagnostic_report'],
                'status' => 'draft'
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('inspections/' . $inspection->id . '/general', 'public');
                    
                    InspectionImage::create([
                        'inspection_id' => $inspection->id,
                        'image_type' => 'general',
                        'file_path' => $path,
                        'original_name' => $image->getClientOriginalName()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'inspection_id' => $inspection->id,
                'message' => 'Visual inspection saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving inspection: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveBodyPanelAssessment(Request $request)
    {
        // TESTING: Relaxed validation for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspection_id' => 'nullable|exists:inspections,id',
            'panels' => 'nullable|array',
            'panels.*.panel_name' => 'nullable|string',
            'panels.*.condition' => 'nullable|in:good,average,bad',
            'panels.*.comment_type' => 'nullable|string',
            'panels.*.additional_comment' => 'nullable|string',
            'panels.*.other_notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            // Handle missing inspection_id for testing
            $inspectionId = $validated['inspection_id'];
            if (!$inspectionId) {
                // For testing, just skip database operations if no inspection_id
                return response()->json([
                    'success' => true,
                    'message' => 'Body panel assessment saved (testing mode)'
                ]);
            }

            // Delete existing panel assessments for this inspection
            BodyPanelAssessment::where('inspection_id', $inspectionId)->delete();

            // Save new panel assessments
            if (!empty($validated['panels'])) {
                foreach ($validated['panels'] as $panel) {
                    if (!empty($panel['condition']) || !empty($panel['comment_type']) || 
                        !empty($panel['additional_comment']) || !empty($panel['other_notes'])) {
                        
                        BodyPanelAssessment::create([
                            'inspection_id' => $inspectionId,
                            'panel_name' => $panel['panel_name'],
                            'condition' => $panel['condition'] ?? null,
                            'comment_type' => $panel['comment_type'] ?? null,
                            'additional_comment' => $panel['additional_comment'] ?? null,
                            'other_notes' => $panel['other_notes'] ?? null
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Body panel assessment saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving panel assessment: ' . $e->getMessage()
            ], 500);
        }
    }


    public function saveInteriorAssessment(Request $request)
    {
        // TESTING: Relaxed validation for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspection_id' => 'nullable|exists:inspections,id',
            'interior_data' => 'nullable|array'
        ]);

        DB::beginTransaction();

        try {
            // Handle missing inspection_id for testing
            $inspectionId = $validated['inspection_id'];
            if (!$inspectionId) {
                return response()->json([
                    'success' => true,
                    'message' => 'Interior assessment saved (testing mode)'
                ]);
            }
            
            $inspection = Inspection::findOrFail($inspectionId);

            // Save interior assessment data
            if (isset($validated['interior_data'])) {
                foreach ($validated['interior_data'] as $itemId => $data) {
                    // Store interior assessment data
                    // You may need to create an InteriorAssessment model for this
                    DB::table('interior_assessments')->updateOrInsert(
                        [
                            'inspection_id' => $inspection->id,
                            'item_id' => $itemId
                        ],
                        [
                            'colour' => $data['colour'] ?? null,
                            'condition' => $data['condition'] ?? null,
                            'comments' => $data['comments'] ?? null,
                            'updated_at' => now()
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Interior assessment saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving interior assessment: ' . $e->getMessage()
            ], 500);
        }
    }


    public function saveServiceBooklet(Request $request)
    {
        // TESTING: Relaxed validation for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspection_id' => 'nullable|exists:inspections,id',
            'service_comments' => 'nullable|string',
            'service_recommendations' => 'nullable|string',
            'service_booklet_images' => 'nullable|array',
            'service_booklet_images.*' => 'image|max:10240' // 10MB max per image
        ]);

        DB::beginTransaction();

        try {
            // Handle missing inspection_id for testing
            $inspectionId = $validated['inspection_id'];
            if (!$inspectionId) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service booklet saved (testing mode)'
                ]);
            }
            
            $inspection = Inspection::findOrFail($inspectionId);

            // Update inspection with service booklet data
            $inspection->update([
                'service_comments' => $validated['service_comments'] ?? null,
                'service_recommendations' => $validated['service_recommendations'] ?? null,
            ]);

            // Handle service booklet image uploads
            if ($request->hasFile('service_booklet_images')) {
                foreach ($request->file('service_booklet_images') as $index => $image) {
                    $path = $image->store('inspections/' . $inspection->id . '/service-booklet', 'public');
                    
                    InspectionImage::create([
                        'inspection_id' => $inspection->id,
                        'image_type' => 'service_booklet',
                        'area_name' => 'service_page_' . ($index + 1),
                        'file_path' => $path,
                        'original_name' => $image->getClientOriginalName()
                    ]);
                }
            }

            // Update inspection status to completed if all sections are done
            $inspection->update(['status' => 'completed']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service booklet saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving service booklet: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveTyresRimsAssessment(Request $request)
    {
        // TESTING: Relaxed validation for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspection_id' => 'nullable|exists:inspections,id',
            'tyres_data' => 'nullable|array'
        ]);

        DB::beginTransaction();

        try {
            // Handle missing inspection_id for testing
            $inspectionId = $validated['inspection_id'];
            if (!$inspectionId) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tyres & Rims assessment saved (testing mode)'
                ]);
            }
            
            $inspection = Inspection::findOrFail($inspectionId);

            // Save tyres assessment data
            if (isset($validated['tyres_data'])) {
                foreach ($validated['tyres_data'] as $fieldName => $value) {
                    // Store tyres assessment data
                    // You may need to create a TyresAssessment model for this
                    DB::table('tyres_assessments')->updateOrInsert(
                        [
                            'inspection_id' => $inspection->id,
                            'field_name' => $fieldName
                        ],
                        [
                            'field_value' => $value,
                            'updated_at' => now()
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tyres & Rims assessment saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving tyres assessment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveMechanicalReport(Request $request)
    {
        // TESTING: Relaxed validation for testing navigation
        // TODO: Restore required validations before production
        $validated = $request->validate([
            'inspection_id' => 'nullable|exists:inspections,id',
            'mechanical_data' => 'nullable|array'
        ]);

        DB::beginTransaction();

        try {
            // Handle missing inspection_id for testing
            $inspectionId = $validated['inspection_id'];
            if (!$inspectionId) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mechanical report saved (testing mode)'
                ]);
            }
            
            $inspection = Inspection::findOrFail($inspectionId);

            // Save mechanical report data
            if (isset($validated['mechanical_data'])) {
                foreach ($validated['mechanical_data'] as $component => $data) {
                    // Store mechanical assessment data
                    // You may need to create a MechanicalAssessment model for this
                    DB::table('mechanical_assessments')->updateOrInsert(
                        [
                            'inspection_id' => $inspection->id,
                            'component_name' => $component
                        ],
                        [
                            'condition' => $data['condition'] ?? null,
                            'comments' => $data['comments'] ?? null,
                            'updated_at' => now()
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mechanical report saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving mechanical report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function saveEngineCompartmentAssessment(Request $request)
    {
        $validated = $request->validate([
            'findings' => 'nullable|array',
            'findings.*' => 'nullable',
            'images' => 'nullable|array',
            'images.*.category' => 'nullable|string|max:100',
            'images.*.caption' => 'nullable|string|max:100',
            'images.*.file' => 'nullable|image|max:2048', // 2MB limit per image
            'components' => 'nullable|array',
            'components.*.condition' => 'nullable|in:Good,Average,Bad,N/A',
            'components.*.comments' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();

        try {
            // Create or find inspection record
            $inspection = Inspection::firstOrCreate(
                ['id' => session('current_inspection_id', 1)], // Use session or default for testing
                [
                    'client_id' => 1, // Default for testing
                    'vehicle_id' => 1, // Default for testing
                    'inspector_name' => 'Default Inspector',
                    'status' => 'in_progress'
                ]
            );

            // Store engine compartment findings
            if (!empty($validated['findings'])) {
                $inspection->update([
                    'engine_compartment_findings' => json_encode($validated['findings'])
                ]);
            }

            // Store component assessments
            if (!empty($validated['components'])) {
                $inspection->update([
                    'engine_compartment_components' => json_encode($validated['components'])
                ]);
            }

            // Process and store images
            if (!empty($validated['images'])) {
                foreach ($validated['images'] as $imageData) {
                    if (isset($imageData['file'])) {
                        $file = $imageData['file'];
                        $filename = 'engine_compartment_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('inspection_images/engine_compartment', $filename, 'public');

                        InspectionImage::create([
                            'inspection_id' => $inspection->id,
                            'image_type' => 'engine_compartment',
                            'image_path' => $path,
                            'caption' => $imageData['caption'] ?? '',
                            'category' => $imageData['category'] ?? '',
                            'metadata' => json_encode([
                                'timestamp' => now()->toISOString(),
                                'file_size' => $file->getSize(),
                                'original_name' => $file->getClientOriginalName()
                            ])
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Engine compartment assessment saved successfully',
                'inspection_id' => $inspection->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving engine compartment assessment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function savePhysicalHoistInspection(Request $request)
    {
        $validated = $request->validate([
            'suspension' => 'nullable|array',
            'suspension.*.primary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'suspension.*.secondary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'suspension.*.comments' => 'nullable|string|max:1000',
            'engine' => 'nullable|array',
            'engine.*.primary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'engine.*.secondary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'engine.*.comments' => 'nullable|string|max:1000',
            'drivetrain' => 'nullable|array',
            'drivetrain.*.primary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'drivetrain.*.secondary_condition' => 'nullable|in:Good,Average,Bad,N/A',
            'drivetrain.*.comments' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Create or find inspection record
            $inspection = Inspection::firstOrCreate(
                ['id' => session('current_inspection_id', 1)], // Use session or default for testing
                [
                    'client_id' => 1, // Default for testing
                    'vehicle_id' => 1, // Default for testing
                    'inspector_name' => 'Default Inspector',
                    'status' => 'in_progress'
                ]
            );

            // Store physical hoist inspection data
            if (!empty($validated['suspension']) || !empty($validated['engine']) || !empty($validated['drivetrain'])) {
                $hoistData = [
                    'suspension' => $validated['suspension'] ?? [],
                    'engine' => $validated['engine'] ?? [],
                    'drivetrain' => $validated['drivetrain'] ?? []
                ];
                
                $inspection->update([
                    'physical_hoist_data' => json_encode($hoistData),
                    'status' => 'completed', // Mark as completed since this is final section
                    'completed_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Physical hoist inspection completed successfully',
                'inspection_id' => $inspection->id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving physical hoist inspection: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:10240',
            'type' => 'required|in:general,specific_area',
            'area_name' => 'nullable|required_if:type,specific_area|string'
        ]);

        try {
            $tempPath = $request->file('image')->store('temp', 'public');
            
            return response()->json([
                'success' => true,
                'temp_path' => $tempPath,
                'url' => Storage::url($tempPath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete the full inspection and create a test report
     */
    public function completeInspection(Request $request)
    {
        try {
            // Get data from request (same method as testVisualReport)
            $rawInspectionData = $request->input('inspectionData', []);
            $rawImageData = $request->input('images', []);
            
            // If inspectionData is a string, decode it (same as testVisualReport)
            if (is_string($rawInspectionData)) {
                $rawInspectionData = json_decode($rawInspectionData, true) ?? [];
            }
            
            // Log the raw data for debugging
            logger('Complete inspection data received:', ['data' => $rawInspectionData, 'images' => $rawImageData]);
            
            // Use the data directly (same approach as testVisualReport)
            $inspectionData = $rawInspectionData;
            
            // Include images in the inspection data (same structure as testVisualReport)
            if (!empty($rawImageData)) {
                $inspectionData['images'] = $rawImageData;
            }
            
            // Generate unique report number
            $reportNumber = 'TEST-' . date('YmdHis') . '-' . rand(100, 999);
            
            // Extract visual data (same way testVisualReport works)
            $visualData = $inspectionData['visual'] ?? [];
            
            // Create inspection report using actual form data
            $report = \App\Models\InspectionReport::create([
                // Required fields from actual form data (client_name removed - not collected in visual inspection)
                'client_name' => 'Not specified', // Visual inspection doesn't collect client name
                'vehicle_make' => $visualData['manufacturer'] ?? 'Unknown Make',
                'vehicle_model' => $visualData['model'] ?? 'Unknown Model',
                'inspection_date' => now()->toDateString(),
                'report_number' => $reportNumber,
                'pdf_filename' => $reportNumber . '.pdf',
                'pdf_path' => 'reports/' . $reportNumber . '.pdf',
                
                // Optional fields from actual form data (Fixed field names to match form)
                'client_email' => $visualData['client_email'] ?? null,
                'client_phone' => $visualData['client_phone'] ?? null,
                'vehicle_year' => $visualData['year_model'] ?? date('Y'),
                'vin_number' => $visualData['vin'] ?? null,
                'license_plate' => $visualData['registration_number'] ?? null,
                'mileage' => $visualData['km_reading'] ?? null,
                'inspector_name' => $visualData['inspector_name'] ?? 'Unknown Inspector',
                'status' => 'completed',
                'inspection_data' => $inspectionData, // Store all data as received
            ]);

            // Clear session storage (will be done by frontend)
            
            return response()->json([
                'success' => true,
                'message' => 'Test inspection report created successfully!',
                'report_id' => $report->id,
                'report_url' => route('reports.show', $report->id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating test report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Transform raw sessionStorage data to web report format
     */
    private function transformInspectionDataForReport($rawData)
    {
        $transformed = [];
        
        // Visual inspection data (client, vehicle info) - parse if it's JSON string
        if (isset($rawData['visual'])) {
            $visualData = is_string($rawData['visual']) ? json_decode($rawData['visual'], true) : $rawData['visual'];
            $transformed['visual'] = $visualData;
        }
        
        // Body panels assessment
        if (isset($rawData['bodyPanels'])) {
            $bodyPanelData = is_string($rawData['bodyPanels']) ? json_decode($rawData['bodyPanels'], true) : $rawData['bodyPanels'];
            $transformed['bodyPanels']['assessments'] = [];
            
            foreach ($bodyPanelData as $key => $value) {
                // Handle keys like "body_panel_front-bumper-condition"
                if (strpos($key, 'body_panel_') === 0) {
                    $withoutPrefix = str_replace('body_panel_', '', $key);
                    $parts = explode('-', $withoutPrefix);
                    
                    if (count($parts) >= 2) {
                        $fieldType = array_pop($parts); // Get last part (condition, comments, etc.)
                        $panelName = implode('_', $parts); // Rejoin the rest as panel name
                        
                        if (!isset($transformed['bodyPanels']['assessments'][$panelName])) {
                            $transformed['bodyPanels']['assessments'][$panelName] = [];
                        }
                        $transformed['bodyPanels']['assessments'][$panelName][$fieldType] = $value;
                    }
                } 
                // Also handle simplified format
                elseif (str_contains($key, '-condition') || str_contains($key, '-comments')) {
                    if (str_contains($key, '-condition')) {
                        $panelName = str_replace('-condition', '', $key);
                        $transformed['bodyPanels']['assessments'][$panelName]['condition'] = $value;
                    }
                    if (str_contains($key, '-comments')) {
                        $panelName = str_replace('-comments', '', $key);
                        $transformed['bodyPanels']['assessments'][$panelName]['comments'] = $value;
                    }
                }
            }
        }
        
        // Interior assessment
        if (isset($rawData['interior'])) {
            $interiorData = is_string($rawData['interior']) ? json_decode($rawData['interior'], true) : $rawData['interior'];
            $transformed['interior']['assessments'] = [];
            
            foreach ($interiorData as $key => $value) {
                // Handle keys like "interior_78-condition"
                if (strpos($key, 'interior_') === 0) {
                    $parts = explode('-', $key);
                    if (count($parts) >= 2) {
                        $componentId = $parts[0]; // e.g., "interior_78"
                        $fieldType = $parts[1]; // e.g., "condition"
                        
                        if (!isset($transformed['interior']['assessments'][$componentId])) {
                            $transformed['interior']['assessments'][$componentId] = [];
                        }
                        $transformed['interior']['assessments'][$componentId][$fieldType] = $value;
                    }
                }
                // Also handle simplified format
                elseif (str_contains($key, '-condition') || str_contains($key, '-colour') || str_contains($key, '-comments')) {
                    if (str_contains($key, '-condition')) {
                        $componentName = str_replace('-condition', '', $key);
                        $transformed['interior']['assessments'][$componentName]['condition'] = $value;
                    }
                    if (str_contains($key, '-colour')) {
                        $componentName = str_replace('-colour', '', $key);
                        $transformed['interior']['assessments'][$componentName]['colour'] = $value;
                    }
                    if (str_contains($key, '-comments')) {
                        $componentName = str_replace('-comments', '', $key);
                        $transformed['interior']['assessments'][$componentName]['comments'] = $value;
                    }
                }
            }
        }
        
        // Service booklet
        if (isset($rawData['serviceBooklet'])) {
            $serviceData = is_string($rawData['serviceBooklet']) ? json_decode($rawData['serviceBooklet'], true) : $rawData['serviceBooklet'];
            $transformed['serviceBooklet'] = $serviceData;
        }
        
        // Tyres assessment
        if (isset($rawData['tyres'])) {
            $tyresData = is_string($rawData['tyres']) ? json_decode($rawData['tyres'], true) : $rawData['tyres'];
            $transformed['tyres']['assessments'] = [];
            
            foreach ($tyresData as $key => $value) {
                // Parse keys like "front_left-size" or "rear_right-condition"
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $tyrePosition = $parts[0]; // e.g., "front_left"
                    $fieldType = $parts[1]; // e.g., "size", "condition", etc.
                    
                    if (!isset($transformed['tyres']['assessments'][$tyrePosition])) {
                        $transformed['tyres']['assessments'][$tyrePosition] = [];
                    }
                    $transformed['tyres']['assessments'][$tyrePosition][$fieldType] = $value;
                }
            }
        }
        
        // Mechanical assessment
        if (isset($rawData['mechanical'])) {
            $mechanicalData = is_string($rawData['mechanical']) ? json_decode($rawData['mechanical'], true) : $rawData['mechanical'];
            $transformed['mechanical'] = [
                'assessments' => [],
                'road_test' => [],
                'braking' => []
            ];
            
            foreach ($mechanicalData as $key => $value) {
                // Handle brake-related fields
                if (strpos($key, 'brake_') === 0) {
                    $withoutBrake = str_replace('brake_', '', $key);
                    $parts = explode('-', $withoutBrake);
                    if (count($parts) >= 2) {
                        $position = $parts[0]; // e.g., "front_left"
                        $fieldType = $parts[1]; // e.g., "pad_life"
                        
                        if (!isset($transformed['mechanical']['braking'][$position])) {
                            $transformed['mechanical']['braking'][$position] = [];
                        }
                        $transformed['mechanical']['braking'][$position][$fieldType] = $value;
                    }
                }
                // Handle road test fields
                elseif ($key === 'road_test_distance' || $key === 'distance') {
                    $transformed['mechanical']['road_test']['distance'] = $value;
                }
                elseif ($key === 'road_test_speed' || $key === 'speed') {
                    $transformed['mechanical']['road_test']['speed'] = $value;
                }
                // Handle other mechanical components
                else {
                    $parts = explode('-', $key);
                    if (count($parts) >= 2) {
                        $fieldType = array_pop($parts); // Get last part
                        $componentName = implode('_', $parts); // Rejoin the rest
                        
                        if (!isset($transformed['mechanical']['assessments'][$componentName])) {
                            $transformed['mechanical']['assessments'][$componentName] = [];
                        }
                        $transformed['mechanical']['assessments'][$componentName][$fieldType] = $value;
                    }
                }
            }
        }
        
        // Engine compartment assessment
        if (isset($rawData['engineCompartment'])) {
            $engineData = is_string($rawData['engineCompartment']) ? json_decode($rawData['engineCompartment'], true) : $rawData['engineCompartment'];
            $transformed['engineCompartment'] = [
                'findings' => [],
                'assessments' => []
            ];
            
            foreach ($engineData as $key => $value) {
                // Handle findings (checkboxes)
                if (strpos($key, 'findings[') === 0) {
                    $findingKey = str_replace(['findings[', ']'], '', $key);
                    $transformed['engineCompartment']['findings'][$findingKey] = $value;
                }
                // Handle component assessments
                else {
                    $parts = explode('-', $key);
                    if (count($parts) >= 2) {
                        $fieldType = array_pop($parts);
                        $componentName = implode('_', $parts);
                        
                        if (!isset($transformed['engineCompartment']['assessments'][$componentName])) {
                            $transformed['engineCompartment']['assessments'][$componentName] = [];
                        }
                        $transformed['engineCompartment']['assessments'][$componentName][$fieldType] = $value;
                    }
                }
            }
        }
        
        // Physical hoist assessment (only for technical inspections)
        if (isset($rawData['physicalHoist'])) {
            $hoistData = is_string($rawData['physicalHoist']) ? json_decode($rawData['physicalHoist'], true) : $rawData['physicalHoist'];
            $transformed['physicalHoist']['assessments'] = [];
            
            foreach ($hoistData as $key => $value) {
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $fieldType = array_pop($parts);
                    $componentName = implode('_', $parts);
                    
                    if (!isset($transformed['physicalHoist']['assessments'][$componentName])) {
                        $transformed['physicalHoist']['assessments'][$componentName] = [];
                    }
                    $transformed['physicalHoist']['assessments'][$componentName][$fieldType] = $value;
                }
            }
        }
        
        // Add inspection metadata
        $transformed['inspection_type'] = $rawData['inspectionType'] ?? 'condition';
        $transformed['completion_date'] = now()->toDateTimeString();
        
        return $transformed;
    }

    /**
     * Test how Visual Inspection data appears in the report
     */
    public function testVisualReport(Request $request)
    {
        // Get data from request (posted from frontend) or use sample data
        $visualData = $request->input('visualData', []);
        
        // Debug: Let's see what data we're getting
        \Log::info('Visual Data Received:', ['data' => $visualData]);
        
        // If visualData is a string, decode it
        if (is_string($visualData)) {
            $visualData = json_decode($visualData, true) ?? [];
        }
        
        // If no data provided, use sample data
        if (empty($visualData)) {
            $visualData = [
                'inspector_name' => 'Test Inspector',
                'client_name' => 'John Test Client',
                'vin' => 'TEST123456789',
                'manufacturer' => 'Toyota',
                'model' => 'Camry',
                'vehicle_type' => 'Sedan',
                'transmission' => 'Automatic',
                'engine_number' => 'ENG123456',
                'registration_number' => 'ABC-123-GP',
                'year' => '2020',
                'mileage' => '50000',
                'diagnostic_report' => 'Test diagnostic report content showing how this will appear in the final report.'
            ];
        }

        // Create a mock report structure with all required properties
        $report = (object)[
            'id' => 1,
            'report_number' => 'TEST-VISUAL-001',
            'client_name' => 'Test Client', // No client fields in form
            'client_email' => null,
            'client_phone' => null,
            'vehicle_make' => $visualData['manufacturer'] ?? 'Unknown Make',
            'vehicle_model' => $visualData['model'] ?? 'Unknown Model',
            'vehicle_year' => $visualData['year_model'] ?? date('Y'),
            'vin_number' => $visualData['vin'] ?? 'Unknown VIN',
            'license_plate' => $visualData['registration_number'] ?? 'Unknown Reg',
            'mileage' => $visualData['km_reading'] ?? 0,
            'inspection_date' => now()->toDateString(),
            'inspector_name' => $visualData['inspector_name'] ?? 'Unknown Inspector',
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Create inspection data in the format expected by web report
        $inspectionData = [
            'client' => [
                'name' => 'Test Client', // No client fields in actual form
                'contact' => null,
                'email' => null
            ],
            'vehicle' => [
                'make' => $visualData['manufacturer'] ?? 'Not specified',
                'model' => $visualData['model'] ?? 'Not specified',
                'year' => $visualData['year_model'] ?? 'Not specified',
                'vin' => $visualData['vin'] ?? 'Not specified',
                'license_plate' => $visualData['registration_number'] ?? 'Not specified',
                'mileage' => $visualData['km_reading'] ?? 'Not specified',
                'colour' => $visualData['colour'] ?? 'Not specified',
                'fuel_type' => $visualData['fuel_type'] ?? 'Not specified',
                'transmission' => $visualData['transmission'] ?? 'Not specified',
                'doors' => $visualData['doors'] ?? 'Not specified'
            ],
            'inspection' => [
                'inspector' => $visualData['inspector_name'] ?? 'Not specified',
                'date' => $visualData['inspection_datetime'] ?? now()->format('Y-m-d H:i'),
                'diagnostic_report' => $visualData['diagnostic_report'] ?? 'No diagnostic report provided',
                'diagnostic_file' => [
                    'name' => $visualData['diagnostic_file_name'] ?? null,
                    'data' => $visualData['diagnostic_file_data'] ?? null,
                    'size' => $visualData['diagnostic_file_size'] ?? null
                ]
            ],
            'images' => [
                'visual' => isset($visualData['images']) ? $this->formatImagesForDisplay($visualData['images']) : []
            ]
        ];

        return view('reports.web-report', compact('report', 'inspectionData'));
    }

    public function testBodyPanelReport(Request $request)
    {
        // Get data from request - handle both nested and flat structure
        $bodyPanelData = $request->input('data', []);
        $bodyPanelImages = $request->input('images', []);
        $panelDiagram = $request->input('panelDiagram', []);
        
        // Debug logging - show exactly what we received
        \Log::info('Body Panel Test Report Request RAW:', [
            'raw_input' => $request->all(),
            'raw_content' => $request->getContent(),
            'content_type' => $request->header('Content-Type')
        ]);
        
        // Try to parse JSON body if it's JSON
        $jsonData = null;
        try {
            $rawContent = $request->getContent();
            if ($rawContent) {
                $jsonData = json_decode($rawContent, true);
                \Log::info('Parsed JSON data:', $jsonData);
            }
        } catch (\Exception $e) {
            \Log::error('Error parsing JSON:', $e->getMessage());
        }
        
        // If we have JSON data, use that structure
        if ($jsonData && isset($jsonData['data'])) {
            $bodyPanelData = $jsonData['data'];
            $bodyPanelImages = $jsonData['images'] ?? [];
            $panelDiagram = $jsonData['panelDiagram'] ?? [];
        }
        
        // Debug the extracted data
        \Log::info('Extracted Data:', [
            'bodyPanelData' => $bodyPanelData,
            'bodyPanelImages' => $bodyPanelImages,
            'panelDiagram' => $panelDiagram
        ]);
        
        // Check if we have real form data
        $hasRealData = !empty($bodyPanelData) && is_array($bodyPanelData) && count($bodyPanelData) > 0;
        
        if (!$hasRealData) {
            \Log::error('No valid body panel form data found', [
                'bodyPanelData' => $bodyPanelData,
                'is_array' => is_array($bodyPanelData),
                'count' => is_array($bodyPanelData) ? count($bodyPanelData) : 'not_array'
            ]);
            return response()->json(['error' => 'No body panel assessment data found. Please fill out the form first.'], 400);
        }
        
        \Log::info('Processing real form data from body panel assessment with ' . count($bodyPanelData) . ' fields');

        // Create basic report structure
        $report = (object)[
            'id' => 1,
            'report_number' => 'TEST-BODY-PANEL-' . date('Ymd-His'),
            'inspection_date' => now()->toDateString(),
            'status' => 'test',
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Format body panel data for display
        $formattedBodyPanels = [];
        $panels = [];
        
        // Group fields by panel
        foreach ($bodyPanelData as $key => $value) {
            if (strpos($key, 'body_panel_') === 0) {
                // Extract panel ID and field type
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $panelId = str_replace('body_panel_', '', $parts[0]);
                    $fieldType = $parts[1];
                    
                    if (!isset($panels[$panelId])) {
                        $panels[$panelId] = [];
                    }
                    $panels[$panelId][$fieldType] = $value;
                }
            }
        }
        
        // Convert to formatted display format
        foreach ($panels as $panelId => $panelData) {
            if (isset($panelData['condition'])) {
                // Create proper panel name
                $panelName = str_replace('_', ' ', $panelId);
                $panelName = ucwords($panelName);
                
                // Handle special cases for proper naming
                $panelName = str_replace([' Fr ', ' Lf ', ' Lr ', ' Rr '], 
                                       [' Right Front ', ' Left Front ', ' Left Rear ', ' Right Rear '], 
                                       $panelName);
                
                $formattedBodyPanels[] = [
                    'name' => $panelName,
                    'condition' => $panelData['condition'] ?? 'Not specified',
                    'comments' => $panelData['comments'] ?? 'No comments',
                    'additional_comments' => $panelData['additional_comments'] ?? '',
                    'images' => $bodyPanelImages['body_panel_' . $panelId] ?? []
                ];
            }
        }

        // Create inspection data for body panel report - ONLY real data
        $inspectionData = [
            'data_source' => 'Real form data from Body Panel Assessment',
            'inspection' => [
                'date' => now()->format('Y-m-d H:i'),
                'body_panels' => $formattedBodyPanels
            ],
            'panelDiagram' => empty($panelDiagram) ? [
                'basePath' => '/images/panels/',
                'panels' => [
                    ['id' => 'rear_bumper', 'name' => 'Rear Bumper', 'image_file' => 'rear-bumper.png', 'x' => 627, 'y' => 1176, 'w' => 374, 'h' => 85],
                    ['id' => 'front_bumper', 'name' => 'Front Bumper', 'image_file' => 'front-bumper.png', 'x' => 42, 'y' => 1181, 'w' => 374, 'h' => 85],
                    ['id' => 'bonnet', 'name' => 'Bonnet', 'image_file' => 'bonnet.png', 'x' => 684, 'y' => 329, 'w' => 271, 'h' => 336],
                    ['id' => 'windscreen', 'name' => 'Windscreen', 'image_file' => 'windscreen.png', 'x' => 576, 'y' => 350, 'w' => 147, 'h' => 279],
                    ['id' => 'fr_door', 'name' => 'Right Front Door', 'image_file' => 'fr-door.png', 'x' => 599, 'y' => 664, 'w' => 128, 'h' => 236],
                    ['id' => 'lf_door', 'name' => 'Left Front Door', 'image_file' => 'lf-door.png', 'x' => 279, 'y' => 664, 'w' => 128, 'h' => 236]
                ]
            ] : $panelDiagram,
            'images' => [
                'body_panel' => $this->formatImagesForDisplay($bodyPanelImages)
            ]
        ];

        return view('reports.body-panel-report', compact('report', 'inspectionData'));
    }

    public function debugBodyPanelData(Request $request)
    {
        $debugInfo = [
            'request_method' => $request->method(),
            'all_inputs' => $request->all(),
            'input_data' => $request->input('data', 'NOT_FOUND'),
            'input_images' => $request->input('images', 'NOT_FOUND'),
            'json_decode_test' => null,
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type'),
            'raw_content' => $request->getContent()
        ];

        // Test JSON decode
        try {
            $rawContent = $request->getContent();
            if ($rawContent) {
                $debugInfo['json_decode_test'] = json_decode($rawContent, true);
            }
        } catch (\Exception $e) {
            $debugInfo['json_decode_error'] = $e->getMessage();
        }

        // Log the debug info
        \Log::info('Body Panel Debug Info:', $debugInfo);

        return response()->json([
            'message' => 'Debug info logged and returned',
            'debug_info' => $debugInfo
        ]);
    }

    public function quickDebugBodyPanel(Request $request)
    {
        $rawContent = $request->getContent();
        $allInputs = $request->all();
        
        $result = [
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'raw_content' => $rawContent,
            'raw_content_length' => strlen($rawContent),
            'all_inputs' => $allInputs,
            'has_data_key' => isset($allInputs['data']),
            'data_value' => $allInputs['data'] ?? 'NOT_FOUND'
        ];
        
        if ($rawContent) {
            try {
                $jsonData = json_decode($rawContent, true);
                $result['json_parsed'] = $jsonData;
                $result['json_has_data'] = isset($jsonData['data']);
                $result['json_data_type'] = isset($jsonData['data']) ? gettype($jsonData['data']) : 'NONE';
                $result['json_data_count'] = isset($jsonData['data']) && is_array($jsonData['data']) ? count($jsonData['data']) : 'NOT_ARRAY';
            } catch (\Exception $e) {
                $result['json_error'] = $e->getMessage();
            }
        }
        
        \Log::info('Quick Debug Body Panel:', $result);
        
        return response()->json($result);
    }

    public function previewBodyPanel(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Process the form data to group by panels
        $panels = [];
        foreach ($formData as $key => $value) {
            if (strpos($key, 'body_panel_') === 0 && $value) {
                // Extract panel name and field type
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $panelId = str_replace('body_panel_', '', $parts[0]);
                    $fieldType = $parts[1];
                    
                    if (!isset($panels[$panelId])) {
                        $panels[$panelId] = [
                            'name' => $this->formatPanelName($panelId),
                            'data' => []
                        ];
                    }
                    $panels[$panelId]['data'][$fieldType] = $value;
                }
            }
        }
        
        // Add image counts to panels
        foreach ($images as $panelKey => $panelImages) {
            $panelId = str_replace('-', '_', $panelKey);
            if (isset($panels[$panelId])) {
                $panels[$panelId]['image_count'] = count($panelImages);
                $panels[$panelId]['has_images'] = true;
            }
        }
        
        // Return a simple view with the data
        return view('previews.body-panel', [
            'panels' => $panels,
            'totalPanels' => count($panels),
            'totalImages' => array_sum(array_map('count', $images)),
            'rawDataSize' => strlen($rawContent)
        ]);
    }
    
    private function formatPanelName($panelId)
    {
        // Convert underscores to hyphens for consistency with JavaScript
        $id = str_replace('_', '-', $panelId);
        
        // Create base name
        $name = str_replace(['-', '_'], ' ', $panelId);
        $name = ucwords($name);
        
        // Apply exact naming convention from body-panel-assessment.blade.php
        $exactNames = [
            'lr-quarter-panel' => 'Left Rear Quarter Panel',
            'lr_quarter_panel' => 'Left Rear Quarter Panel',
            'rr-quarter-panel' => 'Right Rear Quarter Panel',
            'rr_quarter_panel' => 'Right Rear Quarter Panel',
            'rr-rim' => 'Right Rear Rim',
            'rr_rim' => 'Right Rear Rim',
            'rf-rim' => 'Right Front Rim',
            'rf_rim' => 'Right Front Rim',
            'lf-rim' => 'Left Front Rim',
            'lf_rim' => 'Left Front Rim',
            'lr-rim' => 'Left Rear Rim',
            'lr_rim' => 'Left Rear Rim',
            'fr-door' => 'Right Front Door',
            'fr_door' => 'Right Front Door',
            'fr-fender' => 'Right Front Fender',
            'fr_fender' => 'Right Front Fender',
            'fr-headlight' => 'Right Front Headlight',
            'fr_headlight' => 'Right Front Headlight',
            'fr-mirror' => 'Right Front Mirror',
            'fr_mirror' => 'Right Front Mirror',
            'lf-door' => 'Left Front Door',
            'lf_door' => 'Left Front Door',
            'lf-fender' => 'Left Front Fender',
            'lf_fender' => 'Left Front Fender',
            'lf-headlight' => 'Left Front Headlight',
            'lf_headlight' => 'Left Front Headlight',
            'lf-mirror' => 'Left Front Mirror',
            'lf_mirror' => 'Left Front Mirror',
            'lr-door' => 'Left Rear Door',
            'lr_door' => 'Left Rear Door',
            'lr-taillight' => 'Left Rear Taillight',
            'lr_taillight' => 'Left Rear Taillight',
            'rr-door' => 'Right Rear Door',
            'rr_door' => 'Right Rear Door',
            'rr-taillight' => 'Right Rear Taillight',
            'rr_taillight' => 'Right Rear Taillight',
            'rear-bumper' => 'Rear Bumper',
            'rear_bumper' => 'Rear Bumper',
            'front-bumper' => 'Front Bumper',
            'front_bumper' => 'Front Bumper',
            'bonnet' => 'Bonnet',
            'windscreen' => 'Windscreen',
            'roof' => 'Roof',
            'boot' => 'Boot',
            'rear-window' => 'Rear Window',
            'rear_window' => 'Rear Window'
        ];
        
        // Check if we have an exact match
        if (isset($exactNames[$id])) {
            return $exactNames[$id];
        }
        if (isset($exactNames[$panelId])) {
            return $exactNames[$panelId];
        }
        
        // Otherwise return the formatted name
        return $name;
    }

    public function previewInterior(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Map interior IDs to component names (from interior-assessment.blade.php)
        $interiorMapping = [
            'interior_78' => 'Steering Wheel',
            'interior_80' => 'Driver Seat',
            'interior_81' => 'Passenger Seat',
            'interior_83' => 'FR Door Panel',
            'interior_84' => 'FL Door Panel',
            'interior_85' => 'Rear Seat',
            'interior_88' => 'RR Door Panel',
            'interior_89' => 'LR Door Panel',
            'interior_91' => 'Centre Console',
            'interior_94' => 'Air Vents',
            'interior_77' => 'Dash',
            'interior_79' => 'Buttons',
            'interior_82' => 'Headliner',
            'interior_86' => 'Backboard',
            'interior_87' => 'Sun Visor',
            'interior_90' => 'Floor Mat',
            'interior_92' => 'Boot',
            'interior_93' => 'Spare Wheel'
        ];
        
        // Process the form data to group by components
        $components = [];
        foreach ($formData as $key => $value) {
            if (strpos($key, 'interior_') === 0 && $value) {
                // Extract component ID and field type
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $componentKey = $parts[0]; // e.g., "interior_78"
                    $fieldType = $parts[1];    // e.g., "condition"
                    
                    // Get the proper component name from mapping
                    $componentName = $interiorMapping[$componentKey] ?? $this->formatComponentName(str_replace('interior_', '', $componentKey));
                    
                    if (!isset($components[$componentKey])) {
                        $components[$componentKey] = [
                            'name' => $componentName,
                            'data' => []
                        ];
                    }
                    $components[$componentKey]['data'][$fieldType] = $value;
                }
            }
        }
        
        // Add image counts to components
        foreach ($images as $componentKey => $componentImages) {
            $componentId = str_replace('-', '_', $componentKey);
            if (isset($components[$componentId])) {
                $components[$componentId]['image_count'] = count($componentImages);
                $components[$componentId]['has_images'] = true;
            }
        }
        
        // Return a simple view with the data
        return view('previews.interior', [
            'components' => $components,
            'totalComponents' => count($components),
            'totalImages' => array_sum(array_map('count', $images)),
            'rawDataSize' => strlen($rawContent)
        ]);
    }

    public function previewServiceBooklet(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Service Booklet has simpler structure - just comments and recommendations
        $serviceData = [];
        
        if (isset($formData['service_comments']) && $formData['service_comments']) {
            $serviceData['service_comments'] = [
                'name' => 'Service History Comments',
                'value' => $formData['service_comments'],
                'type' => 'textarea'
            ];
        }
        
        if (isset($formData['service_recommendations']) && $formData['service_recommendations']) {
            $serviceData['service_recommendations'] = [
                'name' => 'Service Recommendations',
                'value' => $formData['service_recommendations'],
                'type' => 'textarea'
            ];
        }
        
        // Process service booklet images
        $totalImages = 0;
        if (isset($images['service_booklet_images'])) {
            $totalImages = count($images['service_booklet_images']);
            $serviceData['images'] = [
                'name' => 'Service Booklet Images',
                'count' => $totalImages,
                'has_images' => $totalImages > 0
            ];
        }
        
        // Return a simple view with the data
        return view('previews.service-booklet', [
            'serviceData' => $serviceData,
            'totalFields' => count($serviceData),
            'totalImages' => $totalImages,
            'rawDataSize' => strlen($rawContent)
        ]);
    }

    public function previewTyresRims(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Map tyre IDs to proper names
        $tyreMapping = [
            'front_left' => 'Front Left Tyre',
            'front_right' => 'Front Right Tyre', 
            'rear_left' => 'Rear Left Tyre',
            'rear_right' => 'Rear Right Tyre',
            'spare' => 'Spare Tyre'
        ];
        
        // Process the form data to group by tyres
        $tyres = [];
        foreach ($formData as $key => $value) {
            if ($value) {
                // Parse field name like "front_left-size" or "rear_right-manufacture"
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $tyreId = $parts[0];    // e.g., "front_left"
                    $fieldType = $parts[1];  // e.g., "size"
                    
                    // Get the proper tyre name from mapping
                    $tyreName = $tyreMapping[$tyreId] ?? $this->formatTyreName($tyreId);
                    
                    if (!isset($tyres[$tyreId])) {
                        $tyres[$tyreId] = [
                            'name' => $tyreName,
                            'data' => []
                        ];
                    }
                    $tyres[$tyreId]['data'][$fieldType] = $value;
                }
            }
        }
        
        // Add image counts to tyres
        foreach ($images as $tyreKey => $tyreImages) {
            $tyreId = str_replace('-', '_', $tyreKey);
            if (isset($tyres[$tyreId])) {
                $tyres[$tyreId]['image_count'] = count($tyreImages);
                $tyres[$tyreId]['has_images'] = true;
            }
        }
        
        // Return a simple view with the data
        return view('previews.tyres-rims', [
            'tyres' => $tyres,
            'totalTyres' => count($tyres),
            'totalImages' => array_sum(array_map('count', $images)),
            'rawDataSize' => strlen($rawContent)
        ]);
    }

    public function previewMechanicalReport(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Get all data (includes both mechanical and braking)
        $allData = $formData['all'] ?? [];
        $mechanicalData = $formData['mechanical'] ?? [];
        $brakingData = $formData['braking'] ?? [];
        
        // Use allData as primary source, fallback to separated data
        $dataToProcess = !empty($allData) ? $allData : array_merge($mechanicalData, $brakingData);
        
        \Log::info('Mechanical Report Preview Data:', [
            'allData' => $allData,
            'mechanicalData' => $mechanicalData, 
            'brakingData' => $brakingData,
            'dataToProcess' => $dataToProcess
        ]);
        
        // Process mechanical components
        $mechanicalComponents = [];
        foreach ($dataToProcess as $key => $value) {
            if ($value && strpos($key, 'brake_') === false) {
                \Log::info("Processing mechanical key: {$key} = {$value}");
                
                // Try different parsing approaches
                $componentId = null;
                $fieldType = null;
                
                // Method 1: Parse field names like "final_drive_noise-condition" 
                if (strpos($key, '-') !== false) {
                    $parts = explode('-', $key);
                    if (count($parts) >= 2) {
                        $componentId = $parts[0];
                        $fieldType = $parts[1];
                        \Log::info("Method 1 - Dash separator: component={$componentId}, field={$fieldType}");
                    }
                }
                // Method 2: Parse field names like "final_drive_noise_condition"
                elseif (preg_match('/^(.+)_(condition|comments)$/', $key, $matches)) {
                    $componentId = $matches[1];
                    $fieldType = $matches[2];
                    \Log::info("Method 2 - Underscore separator: component={$componentId}, field={$fieldType}");
                }
                
                if ($componentId && $fieldType) {
                    $componentName = $this->formatMechanicalComponentName($componentId);
                    \Log::info("Mapped component: {$componentId} -> {$componentName}");
                    
                    if (!isset($mechanicalComponents[$componentId])) {
                        $mechanicalComponents[$componentId] = [
                            'name' => $componentName,
                            'data' => []
                        ];
                    }
                    $mechanicalComponents[$componentId]['data'][$fieldType] = $value;
                } else {
                    \Log::warning("Could not parse mechanical field: {$key}");
                }
            }
        }
        
        // Process braking system data
        $brakingComponents = [];
        foreach ($dataToProcess as $key => $value) {
            if ($value && strpos($key, 'brake_') === 0) {
                \Log::info("Processing brake key: {$key} = {$value}");
                
                // Parse brake field names like "brake_front_left-pad_life" or "brake_rear_right-disc_condition"
                $withoutBrake = str_replace('brake_', '', $key);
                
                // Check if it uses dash separator (newer format)
                if (strpos($withoutBrake, '-') !== false) {
                    $parts = explode('-', $withoutBrake);
                    if (count($parts) >= 2) {
                        $position = $parts[0]; // e.g., "front_left"
                        $fieldType = $parts[1]; // e.g., "pad_life"
                        \Log::info("Brake parsing (dash): position={$position}, field={$fieldType}");
                    }
                } else {
                    // Fallback to underscore parsing (older format)
                    $keyParts = explode('_', $withoutBrake);
                    \Log::info("Brake key parts: " . implode(', ', $keyParts));
                    
                    if (count($keyParts) >= 3) {
                        $position = $keyParts[0] . '_' . $keyParts[1]; // e.g., "front_left"
                        $fieldType = implode('_', array_slice($keyParts, 2)); // e.g., "pad_life"
                        \Log::info("Brake parsing (underscore): position={$position}, field={$fieldType}");
                    }
                }
                
                if (isset($position) && isset($fieldType)) {
                    $positionName = $this->formatBrakePositionName($position);
                    
                    if (!isset($brakingComponents[$position])) {
                        $brakingComponents[$position] = [
                            'name' => $positionName,
                            'data' => []
                        ];
                    }
                    $brakingComponents[$position]['data'][$fieldType] = $value;
                } else {
                    \Log::warning("Could not parse brake field: {$key} (not enough parts)");
                }
            }
        }
        
        // Add image counts
        foreach ($images as $componentKey => $componentImages) {
            // Check if it matches mechanical or braking components
            $componentId = str_replace('-', '_', $componentKey);
            if (isset($mechanicalComponents[$componentId])) {
                $mechanicalComponents[$componentId]['image_count'] = count($componentImages);
                $mechanicalComponents[$componentId]['has_images'] = true;
            } elseif (isset($brakingComponents[$componentId])) {
                $brakingComponents[$componentId]['image_count'] = count($componentImages);
                $brakingComponents[$componentId]['has_images'] = true;
            }
        }
        
        \Log::info('Processed Components:', [
            'mechanical' => $mechanicalComponents,
            'braking' => $brakingComponents
        ]);
        
        // Return a simple view with the data
        return view('previews.mechanical-report', [
            'mechanicalComponents' => $mechanicalComponents,
            'brakingComponents' => $brakingComponents,
            'totalMechanicalComponents' => count($mechanicalComponents),
            'totalBrakingComponents' => count($brakingComponents),
            'totalImages' => array_sum(array_map('count', $images)),
            'rawDataSize' => strlen($rawContent),
            'debugData' => $dataToProcess // For debugging
        ]);
    }

    public function previewEngineCompartment(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Separate findings and components data
        $findingsData = $formData['findings'] ?? [];
        $componentsData = $formData['components'] ?? [];
        
        \Log::info('Engine Compartment Preview Data:', [
            'findings' => $findingsData,
            'components' => $componentsData,
            'images' => $images
        ]);
        
        // Process findings data
        $processedFindings = [];
        foreach ($findingsData as $key => $value) {
            // Remove "findings[" and "]" from key names
            $cleanKey = str_replace(['findings[', ']'], '', $key);
            
            // Map to readable names
            $findingName = $this->formatEngineCompartmentFinding($cleanKey);
            
            if ($findingName) {
                $processedFindings[] = [
                    'key' => $cleanKey,
                    'name' => $findingName,
                    'value' => $value,
                    'type' => (strpos($cleanKey, '_notes') !== false) ? 'note' : 'finding'
                ];
            }
        }
        
        // Process engine components data
        $engineComponents = [];
        foreach ($componentsData as $key => $value) {
            if ($value) {
                // Parse field names like "brakefluid_cleanliness-condition" or "engine_oil_level-comments"
                $parts = explode('-', $key);
                if (count($parts) >= 2) {
                    $componentId = $parts[0];
                    $fieldType = $parts[1];
                    
                    $componentName = $this->formatEngineComponentName($componentId);
                    
                    if (!isset($engineComponents[$componentId])) {
                        $engineComponents[$componentId] = [
                            'name' => $componentName,
                            'data' => []
                        ];
                    }
                    $engineComponents[$componentId]['data'][$fieldType] = $value;
                }
            }
        }
        
        // Add image counts to components
        foreach ($images as $componentKey => $componentImages) {
            $componentId = str_replace('-', '_', $componentKey);
            if (isset($engineComponents[$componentId])) {
                $engineComponents[$componentId]['image_count'] = count($componentImages);
                $engineComponents[$componentId]['has_images'] = true;
            }
        }
        
        \Log::info('Processed Engine Compartment Data:', [
            'findings' => $processedFindings,
            'components' => $engineComponents
        ]);
        
        // Return a simple view with the data
        return view('previews.engine-compartment', [
            'findings' => $processedFindings,
            'engineComponents' => $engineComponents,
            'totalFindings' => count($processedFindings),
            'totalComponents' => count($engineComponents),
            'totalImages' => array_sum(array_map('count', $images)),
            'rawDataSize' => strlen($rawContent)
        ]);
    }
    
    private function formatEngineCompartmentFinding($findingKey)
    {
        // Map finding keys to readable names
        $findingsMapping = [
            'engine_number_not_visible' => 'Engine number verification: not possible to verify engine number (not visible without dismantling)',
            'engine_number_notes' => 'Engine Number Notes',
            'no_deficiencies' => 'During the inspection of the Engine Compartment, no deficiencies were detected',
            'no_structural_damage' => 'During the inspection no structural damage was visible/found',
            'general_inspection_notes' => 'General Inspection Notes',
            'engine_covers_partial' => 'Engine covers are partially present',
            'undercarriage_missing' => 'Undercarriage was not present on the vehicle, replacement suggested',
            'engine_covers_absent' => 'Engine covers not present at all',
            'headlight_repairs' => 'Previous repairs/damages has been found on headlights/headlight brackets',
            'fenderliner_damages' => 'All fenderliners were present during the inspection but damages has been found',
            'component_presence_notes' => 'Component Presence Notes'
        ];
        
        return $findingsMapping[$findingKey] ?? ucwords(str_replace('_', ' ', $findingKey));
    }
    
    private function formatEngineComponentName($componentId)
    {
        // Map component IDs to proper names
        $componentMapping = [
            'brakefluid_cleanliness' => 'Brake Fluid Cleanliness',
            'brakefluid_level' => 'Brake Fluid Level',
            'coolant_level' => 'Coolant Level',
            'antifreeze_strength' => 'Antifreeze Strength',
            'fan_belt' => 'Fan Belt',
            'engine_oil_level' => 'Engine Oil Level',
            'engine_oil_condition' => 'Engine Oil Condition',
            'battery_condition' => 'Battery Condition',
            'engine_mounts' => 'Engine Mounts',
            'exhaust_system' => 'Exhaust System'
        ];
        
        return $componentMapping[$componentId] ?? ucwords(str_replace('_', ' ', $componentId));
    }
    
    private function formatMechanicalComponentName($componentId)
    {
        // Map component IDs to proper names
        $componentMapping = [
            'final_drive_noise' => 'Final Drive Operation (Noise)',
            'instrument_control' => 'Instrument/Control Function',
            'road_holding' => 'Road Holding/Stability',
            'gearbox_operation' => 'Gearbox Operation/Noise',
            'clutch_operation' => 'Clutch Operation',
            'general_steering' => 'General Steering/Handling',
            'engine_performance' => 'Engine Performance',
            'cooling_fan' => 'Cooling Fan Operation',
            'footbrake_operation' => 'Footbrake Operation',
            'engine_noise' => 'Engine Noise',
            'power_steering' => 'Power Steering',
            'handbrake_operation' => 'Hand/Park Brake Operation',
            'excess_smoke' => 'Excess Smoke',
            'warning_lights' => 'Warning Lights',
            'overheating' => 'Overheating',
            'auto_changes' => 'Auto Changes/Kick-down',
            '4wd_operation' => '4WD Operation',
            'cruise_control' => 'Cruise Control',
            'airconditioning' => 'Air Conditioning',
            'heating' => 'Heating',
            'air_suspension' => 'Air Suspension',
            'electric_windows' => 'Electric Windows',
            'sunroof' => 'Sunroof',
            'central_locking' => 'Central Locking',
            'vented_heated_seats' => 'Vented/Heated Seats',
            'electronic_seat_adjustments' => 'Electronic Seat Adjustments',
            'control_arm_noise' => 'Control Arm (Noise)',
            'brake_noise' => 'Brake (Noise)',
            'suspension_noise' => 'Suspension (Noise)',
            'oil_leaks' => 'Oil Leaks'
        ];
        
        return $componentMapping[$componentId] ?? ucwords(str_replace('_', ' ', $componentId));
    }
    
    private function formatBrakePositionName($position)
    {
        $positionMapping = [
            'front_left' => 'Front Left',
            'front_right' => 'Front Right',
            'rear_left' => 'Rear Left',
            'rear_right' => 'Rear Right'
        ];
        
        return $positionMapping[$position] ?? ucwords(str_replace('_', ' ', $position));
    }
    
    private function formatTyreName($tyreId)
    {
        // Convert underscores to spaces and capitalize each word
        return ucwords(str_replace('_', ' ', $tyreId)) . ' Tyre';
    }
    
    private function formatComponentName($componentId)
    {
        // Convert underscores to hyphens for consistency
        $id = str_replace('_', '-', $componentId);
        
        // Create base name
        $name = str_replace(['-', '_'], ' ', $componentId);
        $name = ucwords($name);
        
        // Apply exact naming convention for interior components
        $exactNames = [
            'dash' => 'Dash',
            'steering-wheel' => 'Steering Wheel',
            'steering_wheel' => 'Steering Wheel',
            'buttons' => 'Buttons',
            'buttons-rf' => 'Buttons RF',
            'buttons_rf' => 'Buttons RF',
            'buttons-centre' => 'Buttons Centre',
            'buttons_centre' => 'Buttons Centre',
            'buttons-ml' => 'Buttons ML',
            'buttons_ml' => 'Buttons ML',
            'buttons-mr' => 'Buttons MR',
            'buttons_mr' => 'Buttons MR',
            'buttons-fl' => 'Buttons FL',
            'buttons_fl' => 'Buttons FL',
            'buttons-rl' => 'Buttons RL',
            'buttons_rl' => 'Buttons RL',
            'buttons-rr' => 'Buttons RR',
            'buttons_rr' => 'Buttons RR',
            'driver-seat' => 'Driver Seat',
            'driver_seat' => 'Driver Seat',
            'passenger-seat' => 'Passenger Seat',
            'passenger_seat' => 'Passenger Seat',
            'fr-door-panel' => 'FR Door Panel',
            'fr_door_panel' => 'FR Door Panel',
            'fl-door-panel' => 'FL Door Panel',
            'fl_door_panel' => 'FL Door Panel',
            'rear-seat' => 'Rear Seat',
            'rear_seat' => 'Rear Seat',
            'backboard' => 'Backboard',
            'rr-door-panel' => 'RR Door Panel',
            'rr_door_panel' => 'RR Door Panel',
            'rl-door-panel' => 'RL Door Panel',
            'rl_door_panel' => 'RL Door Panel',
            'centre-console' => 'Centre Console',
            'centre_console' => 'Centre Console',
            'headliner' => 'Headliner',
            'sun-visor' => 'Sun Visor',
            'sun_visor' => 'Sun Visor',
            'floor-mat' => 'Floor Mat',
            'floor_mat' => 'Floor Mat',
            'boot' => 'Boot'
        ];
        
        // Check if we have an exact match
        if (isset($exactNames[$id])) {
            return $exactNames[$id];
        }
        if (isset($exactNames[$componentId])) {
            return $exactNames[$componentId];
        }
        
        // Otherwise return the formatted name
        return $name;
    }

    /**
     * Format images for display in web report
     */
    private function formatImagesForDisplay($images)
    {
        if (!is_array($images)) {
            return [];
        }

        $formattedImages = [];
        $counter = 1;
        
        foreach ($images as $index => $image) {
            // Handle different image formats
            if (is_array($image)) {
                // If image is an array with data/src properties
                $imageData = $image['data'] ?? $image['src'] ?? $image;
                $areaName = $image['area_name'] ?? 'Body panel image ' . $counter;
                $timestamp = $image['timestamp'] ?? now()->format('Y-m-d H:i:s');
            } else {
                // If image is a direct data URL string
                $imageData = $image;
                $areaName = 'Body panel image ' . $counter;
                $timestamp = now()->format('Y-m-d H:i:s');
            }
            
            $formattedImages[] = [
                'data_url' => $imageData,
                'area_name' => $areaName,
                'timestamp' => $timestamp
            ];
            
            $counter++;
        }

        return $formattedImages;
    }

    public function previewPhysicalHoist(Request $request)
    {
        // Get the raw data from the request
        $rawContent = $request->getContent();
        $jsonData = json_decode($rawContent, true);
        
        // Extract the form data and images
        $formData = $jsonData['data'] ?? [];
        $images = $jsonData['images'] ?? [];
        
        // Get all data from different categories
        $allData = $formData['all'] ?? [];
        $suspensionData = $formData['suspension'] ?? [];
        $engineData = $formData['engine'] ?? [];
        $drivetrainData = $formData['drivetrain'] ?? [];
        
        // Use allData as primary source, fallback to separated data
        $dataToProcess = !empty($allData) ? $allData : array_merge($suspensionData, $engineData, $drivetrainData);
        
        \Log::info('Physical Hoist Preview Data:', [
            'allData' => $allData,
            'suspensionData' => $suspensionData, 
            'engineData' => $engineData,
            'drivetrainData' => $drivetrainData,
            'dataToProcess' => $dataToProcess
        ]);
        
        // Process components by category
        $suspensionComponents = [];
        $engineComponents = [];
        $drivetrainComponents = [];
        
        foreach ($dataToProcess as $key => $value) {
            if ($value) {
                \Log::info("Processing physical hoist key: {$key} = {$value}");
                
                // Parse field names like "lf_shock_leaks-primary_condition" 
                if (strpos($key, '-') !== false) {
                    $parts = explode('-', $key);
                    if (count($parts) >= 2) {
                        $componentId = $parts[0];
                        $fieldType = $parts[1];
                        \Log::info("Parsed: component={$componentId}, field={$fieldType}");
                        
                        $componentName = $this->formatPhysicalHoistComponentName($componentId);
                        $category = $this->getPhysicalHoistCategory($componentId);
                        
                        // Determine which category this component belongs to
                        if ($category === 'suspension') {
                            if (!isset($suspensionComponents[$componentId])) {
                                $suspensionComponents[$componentId] = [
                                    'name' => $componentName,
                                    'data' => []
                                ];
                            }
                            $suspensionComponents[$componentId]['data'][$fieldType] = $value;
                        } elseif ($category === 'engine') {
                            if (!isset($engineComponents[$componentId])) {
                                $engineComponents[$componentId] = [
                                    'name' => $componentName,
                                    'data' => []
                                ];
                            }
                            $engineComponents[$componentId]['data'][$fieldType] = $value;
                        } elseif ($category === 'drivetrain') {
                            if (!isset($drivetrainComponents[$componentId])) {
                                $drivetrainComponents[$componentId] = [
                                    'name' => $componentName,
                                    'data' => []
                                ];
                            }
                            $drivetrainComponents[$componentId]['data'][$fieldType] = $value;
                        }
                    }
                } else {
                    \Log::warning("Could not parse physical hoist field: {$key}");
                }
            }
        }
        
        // Count totals
        $totalSuspensionComponents = count($suspensionComponents);
        $totalEngineComponents = count($engineComponents);
        $totalDrivetrainComponents = count($drivetrainComponents);
        $totalImages = count($images);
        $rawDataSize = strlen(json_encode($dataToProcess));
        
        // Pass data to preview template
        return view('previews.physical-hoist', compact(
            'suspensionComponents',
            'engineComponents', 
            'drivetrainComponents',
            'totalSuspensionComponents',
            'totalEngineComponents',
            'totalDrivetrainComponents',
            'totalImages',
            'rawDataSize',
            'dataToProcess'
        ));
    }

    /**
     * Format physical hoist component names for display
     */
    private function formatPhysicalHoistComponentName($componentId)
    {
        $componentMapping = [
            // Suspension System
            'lf_shock_leaks' => 'Left Front Shock Leaks',
            'rf_shock_leaks' => 'Right Front Shock Leaks',
            'lr_shock_leaks' => 'Left Rear Shock Leaks',
            'rr_shock_leaks' => 'Right Rear Shock Leaks',
            'lf_shock_mounts' => 'Left Front Shock Mounts',
            'rf_shock_mounts' => 'Right Front Shock Mounts',
            'lr_shock_mounts' => 'Left Rear Shock Mounts',
            'rr_shock_mounts' => 'Right Rear Shock Mounts',
            'lf_control_arm_cracks' => 'Left Front Control Arm Cracks',
            'rf_control_arm_cracks' => 'Right Front Control Arm Cracks',
            'lf_control_arm_play' => 'Left Front Control Arm Play',
            'rf_control_arm_play' => 'Right Front Control Arm Play',
            
            // Engine System
            'engine_mountings' => 'Engine Mountings',
            'engine_oil_viscosity' => 'Engine Oil Viscosity',
            'engine_oil_level' => 'Engine Oil Level',
            'gearbox_mountings' => 'Gearbox Mountings',
            'gearbox_oil_viscosity' => 'Gearbox Oil Viscosity',
            'gearbox_oil_level' => 'Gearbox Oil Level',
            'timing_cover' => 'Timing Cover',
            'sump' => 'Sump',
            'side_shafts' => 'Side Shafts',
            'front_main_seal' => 'Front Main Seal',
            'rear_main_seal' => 'Rear Main Seal',
            
            // Drivetrain System
            'lf_cv_joint' => 'Left Front CV Joint',
            'rf_cv_joint' => 'Right Front CV Joint',
            'propshaft' => 'Propshaft',
            'centre_bearing' => 'Centre Bearing',
            'differential_mounting' => 'Differential Mounting'
        ];
        
        return $componentMapping[$componentId] ?? ucwords(str_replace('_', ' ', $componentId));
    }

    /**
     * Determine which category a physical hoist component belongs to
     */
    private function getPhysicalHoistCategory($componentId)
    {
        $suspensionComponents = ['lf_shock_leaks', 'rf_shock_leaks', 'lr_shock_leaks', 'rr_shock_leaks', 
                                'lf_shock_mounts', 'rf_shock_mounts', 'lr_shock_mounts', 'rr_shock_mounts',
                                'lf_control_arm_cracks', 'rf_control_arm_cracks', 'lf_control_arm_play', 'rf_control_arm_play'];
        
        $engineComponents = ['engine_mountings', 'engine_oil_viscosity', 'engine_oil_level', 'gearbox_mountings',
                            'gearbox_oil_viscosity', 'gearbox_oil_level', 'timing_cover', 'sump', 'side_shafts',
                            'front_main_seal', 'rear_main_seal'];
        
        $drivetrainComponents = ['lf_cv_joint', 'rf_cv_joint', 'propshaft', 'centre_bearing', 'differential_mounting'];
        
        if (in_array($componentId, $suspensionComponents)) {
            return 'suspension';
        } elseif (in_array($componentId, $engineComponents)) {
            return 'engine';
        } elseif (in_array($componentId, $drivetrainComponents)) {
            return 'drivetrain';
        }
        
        return 'unknown';
    }

}