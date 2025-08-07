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
            'inspector_phone' => 'nullable|string|max:50',
            'inspector_email' => 'nullable|email|max:255',
            'client_name' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_email' => 'nullable|email|max:255',
            'vin' => 'nullable|string|max:50',
            'manufacturer' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'engine_number' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:50',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'nullable|integer|min:0',
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
                    ['name' => $validated['client_name']],
                    [
                        'phone' => $validated['client_phone'],
                        'email' => $validated['client_email']
                    ]
                );
            } else {
                // Create a dummy client for testing
                $client = Client::firstOrCreate(
                    ['name' => 'Test Client'],
                    ['phone' => null, 'email' => null]
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
                    'transmission' => $validated['transmission'],
                    'engine_number' => $validated['engine_number'],
                    'registration_number' => $validated['registration_number'],
                    'year' => $validated['year'],
                    'mileage' => $validated['mileage']
                ]
            );

            // Create inspection (handle null values for testing)
            $inspection = Inspection::create([
                'client_id' => $client->id,
                'vehicle_id' => $vehicle->id,
                'inspector_name' => $validated['inspector_name'] ?: 'Test Inspector',
                'inspector_phone' => $validated['inspector_phone'],
                'inspector_email' => $validated['inspector_email'],
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
                    \DB::table('interior_assessments')->updateOrInsert(
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
                    \DB::table('tyres_assessments')->updateOrInsert(
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
                    \DB::table('mechanical_assessments')->updateOrInsert(
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
            // Collect all inspection data from session storage (passed from frontend)
            $inspectionData = $request->input('inspectionData', []);
            
            // Create a test inspection report
            $report = \App\Models\InspectionReport::create([
                'title' => '[TEST] ' . ($inspectionData['visual']['client_name'] ?? 'Tablet Test') . ' - ' . ($inspectionData['visual']['manufacturer'] ?? 'Unknown') . ' ' . ($inspectionData['visual']['model'] ?? 'Vehicle'),
                'inspection_data' => $inspectionData,
                'status' => 'completed',
                'inspector_name' => $inspectionData['visual']['inspector_name'] ?? 'Tablet Tester',
                'client_name' => $inspectionData['visual']['client_name'] ?? 'Test Client',
                'vehicle_info' => [
                    'vin' => $inspectionData['visual']['vin'] ?? 'TEST-VIN-' . date('YmdHis'),
                    'manufacturer' => $inspectionData['visual']['manufacturer'] ?? 'Test Make',
                    'model' => $inspectionData['visual']['model'] ?? 'Test Model',
                    'year' => $inspectionData['visual']['year'] ?? date('Y'),
                    'registration' => $inspectionData['visual']['registration_number'] ?? 'TEST-REG-' . rand(100, 999)
                ],
                'created_at' => now(),
                'updated_at' => now()
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
}