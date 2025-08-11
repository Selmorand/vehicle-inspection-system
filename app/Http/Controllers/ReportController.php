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
            $inspection = \App\Models\Inspection::with(['client', 'vehicle'])->findOrFail($id);
            
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
                    'colour' => $inspection->vehicle->colour ?? 'Not specified',
                    'fuel_type' => $inspection->vehicle->fuel_type ?? 'Not specified',
                    'transmission' => $inspection->vehicle->transmission ?? 'Not specified',
                    'doors' => $inspection->vehicle->doors ?? 'Not specified'
                ],
                'inspection' => [
                    'inspector' => $inspection->inspector_name ?? 'Not specified',
                    'date' => $inspection->inspection_date ?? $inspection->created_at->format('Y-m-d H:i'),
                    'diagnostic_report' => $inspection->diagnostic_report ?? 'No diagnostic report provided',
                    'diagnostic_file' => [
                        'name' => null,
                        'data' => null,
                        'size' => null
                    ]
                ],
                'images' => [
                    'visual' => [] // TODO: Get images from inspection_images table
                ]
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
        $report = InspectionReport::findOrFail($id);
        
        // Delete from database
        $report->delete();
        
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}