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
            $inspection = \App\Models\Inspection::with(['client', 'vehicle', 'images', 'bodyPanelAssessments'])->findOrFail($id);
            
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
                'images' => [
                    'visual' => $this->formatImagesForReport($inspection->images)
                ],
                'body_panels' => $this->formatBodyPanelsForReport($inspection)
            ];
            
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
     * Format images from database for report display
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
}