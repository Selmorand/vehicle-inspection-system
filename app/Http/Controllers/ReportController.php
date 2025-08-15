<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InspectionReport;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display the inspection report view
     */
    public function show(Request $request)
    {
        return view('inspection-report');
    }



    /**
     * Show web version of a specific report
     */
    public function showWeb($id)
    {
        try {
            // First try to find an InspectionReport
            $inspectionReport = InspectionReport::find($id);
            
            if ($inspectionReport) {
                // Use existing InspectionReport logic
                $inspectionData = $this->processInspectionDataForWeb($inspectionReport);
                return view('reports.web-report', ['report' => $inspectionReport, 'inspectionData' => $inspectionData]);
            }
            
            // If no InspectionReport, try to find an Inspection and generate report view
            $inspection = \App\Models\Inspection::with(['client', 'vehicle', 'images', 'bodyPanelAssessments', 'interiorAssessments'])->findOrFail($id);
            
            // Create a report-like object for the view
            $report = (object)[
                'id' => $inspection->id,
                'report_number' => 'INS-' . str_pad($inspection->id, 6, '0', STR_PAD_LEFT),
                'client_name' => $inspection->client->name ?? 'Not specified',
                'client_email' => $inspection->client->email ?? null,
                'client_phone' => $inspection->client->phone ?? null,
                'vehicle_make' => $inspection->vehicle->manufacturer ?? 'Unknown Make',
                'vehicle_model' => $inspection->vehicle->model ?? 'Unknown Model',
                'vehicle_year' => $inspection->vehicle->year ?? date('Y'),
                'vin_number' => $inspection->vehicle->vin ?? null,
                'license_plate' => $inspection->vehicle->registration_number ?? null,
                'mileage' => $inspection->vehicle->mileage ?? null,
                'inspection_date' => $inspection->inspection_date ?? $inspection->created_at->toDateString(),
                'inspector_name' => $inspection->inspector_name ?? 'Unknown Inspector',
                'status' => $inspection->status ?? 'draft',
                'created_at' => $inspection->created_at,
                'updated_at' => $inspection->updated_at
            ];
            
            // Create inspection data using the same format as testVisualReport
            $inspectionData = [
                'client' => [
                    'name' => $inspection->client->name ?? 'Not specified',
                    'contact' => $inspection->client->phone ?? null,
                    'email' => $inspection->client->email ?? null
                ],
                'vehicle' => [
                    'make' => $inspection->vehicle->manufacturer ?? 'Not specified',
                    'model' => $inspection->vehicle->model ?? 'Not specified',
                    'year' => $inspection->vehicle->year ?? 'Not specified',
                    'vin' => $inspection->vehicle->vin ?? 'Not specified',
                    'license_plate' => $inspection->vehicle->registration_number ?? 'Not specified',
                    'mileage' => $inspection->vehicle->mileage ?? 'Not specified',
                    'vehicle_type' => $inspection->vehicle->vehicle_type ?? 'Not specified',
                    'colour' => $inspection->vehicle->colour ?? 'Not specified',
                    'fuel_type' => $inspection->vehicle->fuel_type ?? 'Not specified',
                    'transmission' => $inspection->vehicle->transmission ?? 'Not specified',
                    'doors' => $inspection->vehicle->doors ?? 'Not specified',
                    'engine_number' => $inspection->vehicle->engine_number ?? 'Not specified'
                ],
                'inspection' => [
                    'inspector' => $inspection->inspector_name ?? 'Not specified',
                    'date' => $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d H:i'),
                    'diagnostic_report' => $inspection->diagnostic_report ?? 'No diagnostic report provided',
                    'diagnostic_file' => $this->getDiagnosticFileData($inspection)
                ],
                'images' => $this->organizeImagesForReport($inspection->images),
                'body_panels' => $this->formatBodyPanelsForReport($inspection),
                'interior' => [
                    'assessments' => $this->formatInteriorAssessmentsForReport($inspection)
                ],
                'service_booklet' => $this->formatServiceBookletForReport($inspection),
                'tyres_rims' => $this->formatTyresRimsForReport($inspection)
            ];
            
            // Debug log to check Interior data
            \Log::info('Interior data being passed to view:', [
                'interior_assessments_count' => $inspection->interiorAssessments->count(),
                'interior_data' => $inspectionData['interior']['assessments'] ?? 'NOT SET',
                'interior_data_count' => isset($inspectionData['interior']['assessments']) ? count($inspectionData['interior']['assessments']) : 0
            ]);
            
            // Debug log to check Service Booklet data
            \Log::info('Service Booklet data being passed to view:', [
                'service_comments' => $inspection->service_comments ?? 'NULL',
                'service_recommendations' => $inspection->service_recommendations ?? 'NULL',
                'service_booklet_images_count' => $inspection->images()->where('image_type', 'service_booklet')->count(),
                'service_booklet_data' => $inspectionData['service_booklet'] ?? 'NOT SET'
            ]);
            
            // Debug log to check Tyres & Rims data
            \Log::info('Tyres & Rims data being passed to view:', [
                'tyres_rims_count' => \DB::table('tyres_rims')->where('inspection_id', $inspection->id)->count(),
                'tyres_rims_images_count' => $inspection->images()->where('image_type', 'tyres_rims')->count(),
                'tyres_rims_data' => $inspectionData['tyres_rims'] ?? 'NOT SET',
                'tyres_rims_data_count' => isset($inspectionData['tyres_rims']) ? count($inspectionData['tyres_rims']) : 0
            ]);
            
            return view('reports.web-report', compact('report', 'inspectionData'));
            
        } catch (\Exception $e) {
            return redirect()->route('reports.index')
                ->with('error', 'Report not found or could not be loaded: ' . $e->getMessage());
        }
    }


    /**
     * Process inspection data for web display
     */
    private function processInspectionDataForWeb($report)
    {
        $data = $report->inspection_data;
        
        // Transform the data structure to match what the view expects
        $transformedData = [];
        
        // Client information (Visual inspection doesn't collect client info)
        $transformedData['client'] = [
            'name' => 'Not collected', // Visual inspection form doesn't have client fields
            'contact' => null,
            'email' => null
        ];
        
        // Vehicle information (Fixed field mappings to match form names)
        $transformedData['vehicle'] = [
            'make' => $data['visual']['manufacturer'] ?? $report->vehicle_make ?? 'Not specified',
            'model' => $data['visual']['model'] ?? $report->vehicle_model ?? 'Not specified',
            'year' => $data['visual']['year_model'] ?? $report->vehicle_year ?? 'Not specified',
            'vin' => $data['visual']['vin'] ?? $report->vin_number ?? 'Not specified',
            'license_plate' => $data['visual']['registration_number'] ?? $report->license_plate ?? 'Not specified',
            'mileage' => $data['visual']['km_reading'] ?? $report->mileage ?? 'Not specified',
            'colour' => $data['visual']['colour'] ?? 'Not specified',
            'fuel_type' => $data['visual']['fuel_type'] ?? 'Not specified',
            'transmission' => $data['visual']['transmission'] ?? 'Not specified',
            'doors' => $data['visual']['doors'] ?? 'Not specified',
            'vehicle_type' => $data['visual']['vehicle_type'] ?? 'Not specified',
            'engine_number' => $data['visual']['engine_number'] ?? 'Not specified'
        ];
        
        // Inspection information
        $transformedData['inspection'] = [
            'inspector' => $data['visual']['inspector_name'] ?? $report->inspector_name ?? 'Not specified',
            'date' => $data['visual']['inspection_datetime'] ?? $report->inspection_date ?? now()->format('Y-m-d H:i'),
            'diagnostic_report' => $data['visual']['diagnostic_report'] ?? null,
            'diagnostic_file' => [
                'name' => $data['visual']['diagnostic_file_name'] ?? null,
                'data' => $data['visual']['diagnostic_file_data'] ?? null,
                'size' => $data['visual']['diagnostic_file_size'] ?? null
            ]
        ];
        
        // Body Panel Assessment
        if (isset($data['bodyPanels']['assessments'])) {
            $transformedData['body_panels']['assessments'] = $data['bodyPanels']['assessments'];
        }
        
        // Interior Assessment
        if (isset($data['interior']['assessments'])) {
            $transformedData['interior']['assessments'] = $data['interior']['assessments'];
        }
        
        // Service Booklet
        if (isset($data['serviceBooklet'])) {
            $transformedData['service_booklet'] = $data['serviceBooklet'];
        }
        
        // Tyres Assessment
        if (isset($data['tyres']['assessments'])) {
            $transformedData['tyres'] = $data['tyres']['assessments'];
        }
        
        // Mechanical Report
        if (isset($data['mechanical'])) {
            $transformedData['mechanical'] = array_merge(
                $data['mechanical']['road_test'] ?? [],
                $data['mechanical']['assessments'] ?? []
            );
            if (isset($data['mechanical']['braking'])) {
                $transformedData['mechanical']['braking'] = $data['mechanical']['braking'];
            }
        }
        
        // Engine Compartment
        if (isset($data['engineCompartment'])) {
            $transformedData['engine_compartment'] = [
                'findings' => $data['engineCompartment']['findings'] ?? [],
                'assessments' => $data['engineCompartment']['assessments'] ?? []
            ];
        }
        
        // Physical Hoist (if exists - only for technical inspections)
        if (isset($data['physicalHoist'])) {
            $transformedData['physical_hoist'] = $data['physicalHoist'];
        }
        
        // Process images if they exist
        if (isset($data['images'])) {
            $transformedData['images'] = [];
            foreach ($data['images'] as $section => $images) {
                if (is_array($images)) {
                    $transformedData['images'][$section] = [];
                    foreach ($images as $index => $image) {
                        // Skip service booklet images from appearing in other galleries
                        $areaName = $image['area_name'] ?? '';
                        if (strpos($areaName, 'service_page') !== false || strpos($areaName, 'service_booklet') !== false) {
                            continue; // Skip service booklet images from general galleries
                        }
                        
                        // Ensure images have proper data URL format for web display
                        if (isset($image['base64']) && !str_starts_with($image['base64'], 'data:')) {
                            $mimeType = $image['mime_type'] ?? 'image/jpeg';
                            $transformedData['images'][$section][$index]['data_url'] = 'data:' . $mimeType . ';base64,' . $image['base64'];
                        } else {
                            $transformedData['images'][$section][$index]['data_url'] = $image['base64'] ?? $image['data'] ?? $image['src'] ?? $image ?? '';
                        }
                        $transformedData['images'][$section][$index]['area_name'] = $image['area_name'] ?? 'Image ' . ($index + 1);
                        $transformedData['images'][$section][$index]['timestamp'] = $image['timestamp'] ?? now()->format('Y-m-d H:i:s');
                    }
                    // Re-index array after filtering
                    $transformedData['images'][$section] = array_values($transformedData['images'][$section]);
                }
            }
        }
        
        return $transformedData;
    }

    /**
     * Display a listing of all reports
     */
    public function index(Request $request)
    {
        try {
            // Get saved inspections from the inspections table, not just inspection_reports
            $query = \App\Models\Inspection::with(['client', 'vehicle']);
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('inspector_name', 'like', "%{$search}%")
                      ->orWhereHas('client', function($clientQuery) use ($search) {
                          $clientQuery->where('name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%");
                      })
                      ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                          $vehicleQuery->where('manufacturer', 'like', "%{$search}%")
                                     ->orWhere('model', 'like', "%{$search}%")
                                     ->orWhere('vin', 'like', "%{$search}%");
                      });
                });
            }
            
            // Date filter
            if ($request->has('from_date')) {
                $query->whereDate('inspection_date', '>=', $request->from_date);
            }
            if ($request->has('to_date')) {
                $query->whereDate('inspection_date', '<=', $request->to_date);
            }
            
            $inspections = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // Transform inspections to reports format for the view
            $reports = $inspections->through(function ($inspection) {
                // Create a report-like object from inspection data
                $report = new \stdClass();
                $report->id = $inspection->id;
                $report->report_number = 'INS-' . str_pad($inspection->id, 6, '0', STR_PAD_LEFT);
                $report->client_name = $inspection->client->name ?? 'N/A';
                $report->client_email = $inspection->client->email ?? null;
                $report->vehicle_make = $inspection->vehicle->manufacturer ?? 'Unknown';
                $report->vehicle_model = $inspection->vehicle->model ?? 'Unknown';
                $report->vehicle_year = $inspection->vehicle->year ?? '';
                $report->inspection_date = $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d');
                $report->status = $inspection->status ?? 'draft';
                $report->inspector_name = $inspection->inspector_name ?? 'N/A';
                $report->vin_number = $inspection->vehicle->vin ?? 'N/A';
                $report->created_at = $inspection->created_at;
                $report->updated_at = $inspection->updated_at;
                $report->formatted_file_size = 'N/A'; // Inspections don't have file size
                return $report;
            });
            
            // If no reports exist, add sample data
            if ($reports->isEmpty()) {
                $sampleReport = new \stdClass();
                $sampleReport->id = 1;
                $sampleReport->report_number = 'SAMPLE-001';
                $sampleReport->client_name = 'Sample Client';
                $sampleReport->client_email = null;
                $sampleReport->vehicle_make = 'Toyota';
                $sampleReport->vehicle_model = 'Camry';
                $sampleReport->vehicle_year = '2020';
                $sampleReport->inspection_date = now()->toDateString();
                $sampleReport->status = 'completed';
                $sampleReport->inspector_name = 'Sample Inspector';
                $sampleReport->vin_number = 'SAMPLE123456789';
                $sampleReport->created_at = now();
                $sampleReport->updated_at = now();
                $sampleReport->formatted_file_size = 'N/A';
                
                // Create a paginated collection with the sample data
                $reports = new \Illuminate\Pagination\LengthAwarePaginator(
                    collect([$sampleReport]),
                    1, // total items
                    15, // per page  
                    1, // current page
                    ['path' => $request->url()]
                );
            }
            
            return view('reports.index', compact('reports'));
            
        } catch (\Exception $e) {
            // If there's an error (like missing table), show sample data
            $sampleReport = new InspectionReport();
            $sampleReport->id = 1;
            $sampleReport->report_number = 'SAMPLE-001';
            $sampleReport->client_name = 'Sample Client';
            $sampleReport->vehicle_make = 'Toyota';
            $sampleReport->vehicle_model = 'Camry';
            $sampleReport->vehicle_year = '2020';
            $sampleReport->inspection_date = now()->toDateString();
            $sampleReport->status = 'completed';
            $sampleReport->inspector_name = 'Sample Inspector';
            $sampleReport->vin_number = 'SAMPLE123456789';
            $sampleReport->created_at = now();
            $sampleReport->updated_at = now();
            
            $reports = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([$sampleReport]),
                1,
                15, 
                1,
                ['path' => $request->url()]
            );
            
            return view('reports.index', compact('reports'))->with('error', 'Database unavailable - showing sample data');
        }
    }


    /**
     * Delete a report
     */
    public function destroy($id)
    {
        try {
            // First try to find an InspectionReport
            $inspectionReport = InspectionReport::find($id);
            
            if ($inspectionReport) {
                $inspectionReport->delete();
                return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
            }
            
            // If no InspectionReport, try to find and delete an Inspection
            $inspection = \App\Models\Inspection::findOrFail($id);
            
            // Delete associated images first
            if ($inspection->images) {
                foreach ($inspection->images as $image) {
                    // Delete physical file if it exists
                    $fullPath = storage_path('app/public/' . $image->file_path);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                    // Delete database record
                    $image->delete();
                }
            }
            
            // Delete the inspection record
            $inspection->delete();
            
            return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
            
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'Error deleting report: ' . $e->getMessage());
        }
    }

    /**
     * Delete all reports
     */
    public function destroyAll()
    {
        try {
            // Delete all InspectionReports
            $inspectionReports = InspectionReport::all();
            foreach ($inspectionReports as $report) {
                $report->delete();
            }
            
            // Delete all Inspections and their associated data
            $inspections = \App\Models\Inspection::all();
            $deletedCount = 0;
            
            foreach ($inspections as $inspection) {
                // Delete associated images first
                if ($inspection->images) {
                    foreach ($inspection->images as $image) {
                        // Delete physical file if it exists
                        $fullPath = storage_path('app/public/' . $image->file_path);
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                        // Delete database record
                        $image->delete();
                    }
                }
                
                // Delete the inspection record
                $inspection->delete();
                $deletedCount++;
            }
            
            $totalDeleted = $inspectionReports->count() + $deletedCount;
            
            if ($totalDeleted > 0) {
                return redirect()->route('reports.index')->with('success', "Successfully deleted {$totalDeleted} reports and all associated data.");
            } else {
                return redirect()->route('reports.index')->with('info', 'No reports found to delete.');
            }
            
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'Error clearing all reports: ' . $e->getMessage());
        }
    }
    
    /**
     * Organize images into different categories for report display
     */
    private function organizeImagesForReport($images)
    {
        $organizedImages = [
            'visual' => [],
            'interior' => [],
            'body_panel' => []
        ];
        
        if ($images) {
            foreach ($images as $image) {
                // Skip diagnostic PDFs - they're handled separately
                if ($image->image_type === 'diagnostic_pdf') {
                    continue;
                }
                
                // Skip service booklet images - they're handled separately in formatServiceBookletForReport
                if ($image->image_type === 'service_booklet') {
                    continue;
                }
                
                // Skip tyres_rims images - they're handled separately in formatTyresRimsForReport
                if ($image->image_type === 'tyres_rims') {
                    continue;
                }
                
                // Check if image file exists (with fallback for interior path mismatch)
                $fullPath1 = storage_path('app/public/' . $image->file_path);
                $fullPath2 = null;
                
                // Handle interior path mismatch
                if (strpos($image->file_path, '/interior/') === false && strpos($image->file_path, 'interior_') !== false) {
                    $pathParts = explode('/', $image->file_path);
                    if (count($pathParts) >= 3) {
                        array_splice($pathParts, 2, 0, 'interior');
                        $alternativePath = implode('/', $pathParts);
                        $fullPath2 = storage_path('app/public/' . $alternativePath);
                    }
                }
                
                $existingPath = null;
                $publicPath = null;
                
                if (file_exists($fullPath1)) {
                    $existingPath = $fullPath1;
                    $publicPath = $image->file_path;
                } elseif ($fullPath2 && file_exists($fullPath2)) {
                    $existingPath = $fullPath2;
                    $publicPath = str_replace(storage_path('app/public/'), '', $fullPath2);
                }
                
                if ($existingPath) {
                    $imageData = [
                        'area_name' => $image->area_name ?? $image->original_name ?? 'Image',
                        'data_url' => asset('storage/' . $publicPath),
                        'timestamp' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                        'type' => $image->image_type ?? 'general'
                    ];
                    
                    // Categorize images - INTERIOR IMAGES DO NOT GO TO GALLERY
                    if ($image->image_type === 'specific_area' && str_starts_with($image->area_name, 'body_panel_')) {
                        // Skip body panel images - handled in component cards
                        continue;
                    } elseif ($image->image_type === 'specific_area' && $this->isInteriorImage($image->area_name)) {
                        // Skip interior images - handled in component cards only, NOT gallery
                        continue;
                    } else {
                        $organizedImages['visual'][] = $imageData;
                    }
                } else {
                    // If file doesn't exist in either location, log warning
                    \Log::warning('Image file not found in any location', [
                        'image_id' => $image->id,
                        'db_file_path' => $image->file_path,
                        'tried_path_1' => $fullPath1,
                        'tried_path_2' => $fullPath2
                    ]);
                }
            }
        }
        
        return $organizedImages;
    }

    /**
     * Format images from database for report display (DEPRECATED - use organizeImagesForReport)
     */
    private function formatImagesForReport($images)
    {
        $formattedImages = [];
        
        if ($images) {
            foreach ($images as $image) {
                // Skip diagnostic PDFs here - they're handled separately
                if ($image->image_type === 'diagnostic_pdf') {
                    continue;
                }
                
                // Skip body panel images - they're handled in formatBodyPanelsForReport
                if ($image->image_type === 'specific_area' && str_starts_with($image->area_name, 'body_panel_')) {
                    continue;
                }
                
                // Check if image file exists
                $fullPath = storage_path('app/public/' . $image->file_path);
                if (file_exists($fullPath)) {
                    // Use the public URL for the image
                    $formattedImages[] = [
                        'area_name' => $image->area_name ?? $image->original_name ?? 'Image',
                        'data_url' => asset('storage/' . $image->file_path),
                        'timestamp' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                        'type' => $image->image_type ?? 'general'
                    ];
                } else {
                    // If file doesn't exist, log warning but continue
                    \Log::warning('Image file not found: ' . $fullPath, [
                        'image_id' => $image->id,
                        'file_path' => $image->file_path
                    ]);
                }
            }
        }
        
        return $formattedImages;
    }
    
    /**
     * Format body panels data for report display
     */
    private function formatBodyPanelsForReport($inspection)
    {
        $bodyPanelData = [];
        
        // Get body panel assessments from database
        if ($inspection->bodyPanelAssessments) {
            foreach ($inspection->bodyPanelAssessments as $panel) {
                // Clean up panel name - remove 'body_panel_' prefix if present
                $panelId = str_replace('body_panel_', '', $panel->panel_name);
                
                // Get images for this panel
                // Handle both underscore and hyphen variations
                $panelImages = [];
                $searchName1 = 'body_panel_' . $panelId; // As stored (with underscores)
                $searchName2 = 'body_panel_' . str_replace('_', '-', $panelId); // Convert underscores to hyphens
                
                $bodyPanelImages = $inspection->images()
                    ->where('image_type', 'specific_area')
                    ->where(function($query) use ($searchName1, $searchName2) {
                        $query->where('area_name', $searchName1)
                              ->orWhere('area_name', $searchName2);
                    })
                    ->get();
                
                foreach ($bodyPanelImages as $image) {
                    $fullPath = storage_path('app/public/' . $image->file_path);
                    if (file_exists($fullPath)) {
                        $panelImages[] = [
                            'url' => asset('storage/' . $image->file_path),
                            'thumbnail' => asset('storage/' . $image->file_path),
                            'timestamp' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s')
                        ];
                    }
                }
                
                $bodyPanelData[] = [
                    'panel_id' => $panelId,
                    'panel_name' => $this->formatPanelName($panelId),
                    'condition' => $panel->condition,
                    'comment_type' => $panel->comment_type,
                    'additional_comment' => $panel->additional_comment,
                    'other_notes' => $panel->other_notes,
                    'images' => $panelImages
                ];
            }
        }
        
        return $bodyPanelData;
    }
    
    /**
     * Format interior assessments for report display
     */
    private function formatInteriorAssessmentsForReport($inspection)
    {
        $interiorData = [];
        
        
        // Get interior assessments from database
        if ($inspection->interiorAssessments) {
            foreach ($inspection->interiorAssessments as $assessment) {
                // Get images for this component
                $componentImages = [];
                
                // Search for images using multiple patterns (handle naming inconsistencies)
                $componentId = $assessment->component_name;
                
                // Map interior_XX to exact panelId values from interior-assessment.blade.php
                $componentMap = [
                    'interior_77' => ['dash'],
                    'interior_78' => ['steering-wheel'], 
                    'interior_79' => ['buttons'],
                    'interior_80' => ['driver-seat'],
                    'interior_81' => ['passenger-seat'],
                    'interior_82' => [], // Rooflining - no panelId 
                    'interior_83' => ['fr-door-panel'],
                    'interior_84' => ['fl-door-panel'], 
                    'interior_85' => ['rear-seat'],
                    'interior_86' => [], // Additional Seats - no panelId
                    'interior_87' => ['backboard'],
                    'interior_88' => ['rr-door-panel'],
                    'interior_89' => ['lr-door-panel'],
                    'interior_90' => ['boot'],
                    'interior_91' => ['centre-console'],
                    'interior_92' => ['gearlever'], // Form shows panelId: 'gearlever'
                    'interior_93' => [], // Other - no panelId
                    'interior_94' => ['air-vents']
                ];
                
                $searchNames = [
                    $componentId, // Direct search: interior_92
                    'interior_' . str_replace('interior_', '', $componentId), // Ensure prefix
                ];
                
                // Add mapped variations
                if (isset($componentMap[$componentId])) {
                    $searchNames = array_merge($searchNames, $componentMap[$componentId]);
                }
                
                $interiorImages = $inspection->images()
                    ->where('image_type', 'specific_area')
                    ->where(function($query) use ($searchNames) {
                        foreach ($searchNames as $name) {
                            $query->orWhere('area_name', $name);
                        }
                    })
                    ->get();
                
                
                foreach ($interiorImages as $image) {
                    // Check if image file exists - handle both path formats
                    $fullPath1 = storage_path('app/public/' . $image->file_path);
                    $fullPath2 = null;
                    
                    // If path doesn't include 'interior/' subdirectory, try adding it
                    if (strpos($image->file_path, '/interior/') === false && strpos($image->file_path, 'interior_') !== false) {
                        $pathParts = explode('/', $image->file_path);
                        if (count($pathParts) >= 3) {
                            // Insert 'interior' subdirectory: inspections/ID/filename -> inspections/ID/interior/filename
                            array_splice($pathParts, 2, 0, 'interior');
                            $alternativePath = implode('/', $pathParts);
                            $fullPath2 = storage_path('app/public/' . $alternativePath);
                        }
                    }
                    
                    $existingPath = null;
                    $publicPath = null;
                    
                    if (file_exists($fullPath1)) {
                        $existingPath = $fullPath1;
                        $publicPath = $image->file_path;
                    } elseif ($fullPath2 && file_exists($fullPath2)) {
                        $existingPath = $fullPath2;
                        $publicPath = str_replace(storage_path('app/public/'), '', $fullPath2);
                    }
                    
                    if ($existingPath) {
                        $componentImages[] = [
                            'url' => asset('storage/' . $publicPath),
                            'thumbnail' => asset('storage/' . $publicPath),
                            'timestamp' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s')
                        ];
                    } else {
                        // If file doesn't exist in either location, log warning
                        \Log::warning('Interior image file not found in any location', [
                            'image_id' => $image->id,
                            'db_file_path' => $image->file_path,
                            'tried_path_1' => $fullPath1,
                            'tried_path_2' => $fullPath2,
                            'component_name' => $assessment->component_name
                        ]);
                    }
                }
                
                // Return indexed array like body panels (NOT associative array)
                $interiorData[] = [
                    'component_id' => $componentId,
                    'component_name' => $this->formatInteriorComponentName($assessment->component_name),
                    'condition' => $assessment->condition,
                    'colour' => $assessment->colour,
                    'comment' => $assessment->comment,
                    'images' => $componentImages
                ];
            }
        }
        
        
        return $interiorData;
    }
    
    /**
     * Format service booklet data for report display
     */
    private function formatServiceBookletForReport($inspection)
    {
        $serviceBookletData = [
            'comments' => $inspection->service_comments,
            'recommendations' => $inspection->service_recommendations,
            'images' => []
        ];
        
        // Get service booklet images
        $serviceBookletImages = $inspection->images()
            ->where('image_type', 'service_booklet')
            ->orderBy('created_at')
            ->get();
        
        foreach ($serviceBookletImages as $image) {
            // Check if image file exists (with fallback for path mismatches)
            $fullPath1 = storage_path('app/public/' . $image->file_path);
            $existingPath = null;
            $publicPath = null;
            
            if (file_exists($fullPath1)) {
                $existingPath = $fullPath1;
                $publicPath = $image->file_path;
            }
            
            if ($existingPath) {
                $serviceBookletData['images'][] = [
                    'url' => asset('storage/' . $publicPath),
                    'title' => $image->area_name ?? 'Service Booklet Page',
                    'created_at' => $image->created_at->format('Y-m-d H:i:s')
                ];
            }
        }
        
        return $serviceBookletData;
    }
    
    /**
     * Check if an area name represents an interior image
     */
    private function isInteriorImage($areaName)
    {
        // List of exact panelId values from interior-assessment.blade.php
        $interiorComponents = [
            'dash',
            'steering-wheel', 
            'buttons',
            'driver-seat',
            'passenger-seat',
            'fr-door-panel',
            'fl-door-panel',
            'rear-seat',
            'backboard',
            'rr-door-panel',
            'lr-door-panel',
            'boot',
            'centre-console',
            'gearlever',
            'air-vents'
        ];
        
        // Check if it starts with interior_ or matches any exact panelId
        return str_starts_with($areaName, 'interior_') || in_array($areaName, $interiorComponents);
    }
    
    /**
     * Format interior component name to readable format
     */
    private function formatInteriorComponentName($componentName)
    {
        // Map interior IDs to actual component names
        $interiorNameMap = [
            'interior_77' => 'Dashboard',
            'interior_78' => 'Steering Wheel',
            'interior_79' => 'Buttons',
            'interior_80' => 'Driver Seat',
            'interior_81' => 'Passenger Seat',
            'interior_82' => 'Rooflining',
            'interior_83' => 'FR Door Panel',
            'interior_84' => 'FL Door Panel',
            'interior_85' => 'Rear Seat',
            'interior_86' => 'Additional Seats',
            'interior_87' => 'Backboard',
            'interior_88' => 'RR Door Panel',
            'interior_89' => 'LR Door Panel',
            'interior_90' => 'Boot',
            'interior_91' => 'Centre Console',
            'interior_92' => 'Gear Lever',
            'interior_93' => 'Handbrake',
            'interior_94' => 'Air Vents',
            'interior_95' => 'Mats',
            'interior_96' => 'General'
        ];
        
        // Return mapped name if exists, otherwise format the raw name
        if (isset($interiorNameMap[$componentName])) {
            return $interiorNameMap[$componentName];
        }
        
        // Fallback: Convert underscores to spaces and capitalize words
        $formatted = str_replace('_', ' ', $componentName);
        return ucwords($formatted);
    }
    
    /**
     * Format panel ID to readable name
     */
    private function formatPanelName($panelId)
    {
        // Normalize panel ID (convert underscores to hyphens for consistency)
        $normalizedId = str_replace('_', '-', $panelId);
        
        $names = [
            'rear-bumber' => 'Rear Bumper',
            'rear-bumper' => 'Rear Bumper',
            'lr-quarter-panel' => 'Left Rear Quarter Panel',
            'rr-quarter-panel' => 'Right Rear Quarter Panel',
            'rr-rim' => 'Right Rear Rim',
            'rf-rim' => 'Right Front Rim',
            'lf-rim' => 'Left Front Rim',
            'lr-rim' => 'Left Rear Rim',
            'fr-door' => 'Right Front Door',
            'fr-fender' => 'Right Front Fender',
            'fr-headlight' => 'Right Front Headlight',
            'fr-mirror' => 'Right Front Mirror',
            'lf-door' => 'Left Front Door',
            'lf-fender' => 'Left Front Fender',
            'lf-headlight' => 'Left Front Headlight',
            'lf-mirror' => 'Left Front Mirror',
            'lr-door' => 'Left Rear Door',
            'lr-taillight' => 'Left Rear Taillight',
            'rr-door' => 'Right Rear Door',
            'rr-taillight' => 'Right Rear Taillight',
            'bonnet' => 'Bonnet',
            'windscreen' => 'Windscreen',
            'roof' => 'Roof',
            'rear-window' => 'Rear Window',
            'boot' => 'Boot',
            'front-bumper' => 'Front Bumper'
        ];
        
        return $names[$normalizedId] ?? ucwords(str_replace(['-', '_'], ' ', $panelId));
    }

    /**
     * Get diagnostic file data for an inspection
     */
    private function getDiagnosticFileData($inspection)
    {
        // Look for diagnostic PDF in the images table
        $diagnosticFile = $inspection->images()->where('image_type', 'diagnostic_pdf')->first();
        
        if ($diagnosticFile) {
            $fullPath = storage_path('app/public/' . $diagnosticFile->file_path);
            if (file_exists($fullPath)) {
                return [
                    'name' => $diagnosticFile->original_name,
                    'data' => asset('storage/' . $diagnosticFile->file_path),
                    'size' => filesize($fullPath)
                ];
            } else {
                \Log::warning('Diagnostic PDF file not found: ' . $fullPath);
            }
        }
        
        return [
            'name' => null,
            'data' => null,
            'size' => null
        ];
    }

    /**
     * Format tyres & rims data for report display
     */
    private function formatTyresRimsForReport($inspection)
    {
        $tyresData = [];
        
        // Get tyres data from database
        $tyresRims = \DB::table('tyres_rims')
            ->where('inspection_id', $inspection->id)
            ->get();
        
        foreach ($tyresRims as $tyre) {
            // Get images for this tyre component
            $tyreImages = [];
            
            // Try both naming conventions: underscores and hyphens
            $componentNameUnderscore = $tyre->component_name; // e.g., front_left
            $componentNameHyphen = str_replace('_', '-', $tyre->component_name); // e.g., front-left
            
            $images = $inspection->images()
                ->where('image_type', 'tyres_rims')
                ->where(function($query) use ($componentNameUnderscore, $componentNameHyphen) {
                    $query->where('area_name', $componentNameUnderscore)
                          ->orWhere('area_name', $componentNameHyphen);
                })
                ->get();
            
            \Log::info('Tyres images for component: ' . $tyre->component_name, [
                'searched_names' => [$componentNameUnderscore, $componentNameHyphen],
                'images_found' => $images->count(),
                'images_data' => $images->pluck('file_path')->toArray()
            ]);
            
            foreach ($images as $image) {
                $fullPath = storage_path('app/public/' . $image->file_path);
                \Log::info('Processing tyre image: ' . $image->file_path, [
                    'full_path' => $fullPath,
                    'file_exists' => file_exists($fullPath)
                ]);
                
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
}