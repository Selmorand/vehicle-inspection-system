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
        
        // Process images if they exist
        if (isset($data['images'])) {
            foreach ($data['images'] as $section => $images) {
                if (is_array($images)) {
                    foreach ($images as $index => $image) {
                        // Ensure images have proper data URL format for web display
                        if (isset($image['base64']) && !str_starts_with($image['base64'], 'data:')) {
                            $mimeType = $image['mime_type'] ?? 'image/jpeg';
                            $data['images'][$section][$index]['data_url'] = 'data:' . $mimeType . ';base64,' . $image['base64'];
                        } else {
                            $data['images'][$section][$index]['data_url'] = $image['base64'] ?? '';
                        }
                    }
                }
            }
        }
        
        return $data;
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
            
            return view('reports.index', compact('reports'));
            
        } catch (\Exception $e) {
            // If there's an error (like missing table), return empty collection
            $reports = collect()->paginate(15);
            return view('reports.index', compact('reports'))->with('error', 'Unable to load reports: ' . $e->getMessage());
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