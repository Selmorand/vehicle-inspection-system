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
            $report = InspectionReport::findOrFail($id);
            
            // Process inspection data for web display
            $inspectionData = $this->processInspectionDataForWeb($report);
            
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
            $query = InspectionReport::query();
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('client_name', 'like', "%{$search}%")
                      ->orWhere('vehicle_make', 'like', "%{$search}%")
                      ->orWhere('vehicle_model', 'like', "%{$search}%")
                      ->orWhere('vin_number', 'like', "%{$search}%")
                      ->orWhere('report_number', 'like', "%{$search}%");
                });
            }
            
            // Date filter
            if ($request->has('from_date')) {
                $query->whereDate('inspection_date', '>=', $request->from_date);
            }
            if ($request->has('to_date')) {
                $query->whereDate('inspection_date', '<=', $request->to_date);
            }
            
            $reports = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // If no reports exist, add sample data
            if ($reports->isEmpty()) {
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