<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InspectionReportMail;
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
     * Generate and download PDF report
     */
    public function generatePDF(Request $request)
    {
        // Get all inspection data from request
        $inspectionData = $this->gatherInspectionData($request);
        
        // Generate PDF from view
        $pdf = PDF::loadView('reports.inspection-pdf', compact('inspectionData'));
        
        // Configure PDF settings
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'debugPng' => false,
            'debugKeepTemp' => false,
            'debugCss' => false,
            'debugLayout' => false,
            'debugLayoutLines' => false,
            'debugLayoutBlocks' => false,
            'debugLayoutInline' => false,
            'debugLayoutPaddingBox' => false,
        ]);
        
        // Generate filename with timestamp
        $filename = 'Vehicle_Inspection_Report_' . date('Y-m-d_H-i-s') . '.pdf';
        
        // Save to storage
        $pdfContent = $pdf->output();
        $path = 'inspection-reports/' . date('Y/m/') . $filename;
        Storage::disk('public')->put($path, $pdfContent);
        
        // Save to database
        $report = InspectionReport::create([
            'client_name' => $inspectionData['client']['name'] ?? 'Unknown',
            'client_email' => $inspectionData['client']['email'] ?? null,
            'client_phone' => $inspectionData['client']['contact'] ?? null,
            'vehicle_make' => $inspectionData['vehicle']['make'] ?? 'Unknown',
            'vehicle_model' => $inspectionData['vehicle']['model'] ?? 'Unknown',
            'vehicle_year' => $inspectionData['vehicle']['year'] ?? null,
            'vin_number' => $inspectionData['vehicle']['vin'] ?? null,
            'license_plate' => $inspectionData['vehicle']['license_plate'] ?? null,
            'mileage' => $inspectionData['vehicle']['mileage'] ?? null,
            'inspection_date' => $inspectionData['inspection']['date'] ?? now(),
            'inspector_name' => $inspectionData['inspection']['inspector'] ?? null,
            'report_number' => InspectionReport::generateReportNumber(),
            'pdf_filename' => $filename,
            'pdf_path' => $path,
            'file_size' => strlen($pdfContent),
            'status' => 'completed',
            'inspection_data' => $inspectionData,
        ]);
        
        // Return download response
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Email the inspection report
     */
    public function emailReport(Request $request)
    {
        $request->validate([
            'client_email' => 'required|email',
            'client_name' => 'required|string',
            'subject' => 'nullable|string',
            'message' => 'nullable|string'
        ]);

        try {
            // Get all inspection data
            $inspectionData = $this->gatherInspectionData($request);
            
            // Generate PDF for attachment
            $pdf = PDF::loadView('reports.inspection-pdf', compact('inspectionData'));
            $pdf->setPaper('A4', 'portrait');
            
            // Generate filename
            $filename = 'Vehicle_Inspection_Report_' . date('Y-m-d_H-i-s') . '.pdf';
            
            // Send email with PDF attachment
            Mail::to($request->client_email)->send(
                new InspectionReportMail(
                    $inspectionData,
                    $pdf->output(),
                    $filename,
                    $request->subject,
                    $request->message
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Inspection report has been sent successfully to ' . $request->client_email
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gather all inspection data from request
     */
    private function gatherInspectionData(Request $request)
    {
        return [
            // Client & Vehicle Information
            'client' => [
                'name' => $request->input('client_name', ''),
                'contact' => $request->input('contact_number', ''),
                'email' => $request->input('email', ''),
            ],
            'vehicle' => [
                'make' => $request->input('vehicle_make', ''),
                'model' => $request->input('vehicle_model', ''),
                'year' => $request->input('vehicle_year', ''),
                'vin' => $request->input('vin_number', ''),
                'mileage' => $request->input('mileage', ''),
                'license_plate' => $request->input('license_plate', ''),
            ],
            'inspection' => [
                'date' => $request->input('inspection_date', date('Y-m-d')),
                'inspector' => $request->input('inspector_name', ''),
                'notes' => $request->input('additional_notes', ''),
            ],
            
            // Body Panel Assessment
            'body_panels' => json_decode($request->input('body_panel_data', '{}'), true),
            
            // Interior Assessment
            'interior' => json_decode($request->input('interior_data', '{}'), true),
            
            // Service History
            'service' => [
                'has_history' => $request->input('has_service_history', 'no'),
                'last_service_date' => $request->input('last_service_date', ''),
                'last_service_mileage' => $request->input('last_service_mileage', ''),
                'service_provider' => $request->input('service_provider', ''),
                'next_service_due' => $request->input('next_service_due', ''),
                'notes' => $request->input('service_notes', ''),
            ],
            
            // Tyres & Rims
            'tyres' => [
                'lf' => [
                    'brand' => $request->input('lf_brand', ''),
                    'size' => $request->input('lf_size', ''),
                    'tread_depth' => $request->input('lf_tread_depth', ''),
                    'condition' => $request->input('lf_condition', ''),
                    'notes' => $request->input('lf_notes', ''),
                ],
                'rf' => [
                    'brand' => $request->input('rf_brand', ''),
                    'size' => $request->input('rf_size', ''),
                    'tread_depth' => $request->input('rf_tread_depth', ''),
                    'condition' => $request->input('rf_condition', ''),
                    'notes' => $request->input('rf_notes', ''),
                ],
                'lr' => [
                    'brand' => $request->input('lr_brand', ''),
                    'size' => $request->input('lr_size', ''),
                    'tread_depth' => $request->input('lr_tread_depth', ''),
                    'condition' => $request->input('lr_condition', ''),
                    'notes' => $request->input('lr_notes', ''),
                ],
                'rr' => [
                    'brand' => $request->input('rr_brand', ''),
                    'size' => $request->input('rr_size', ''),
                    'tread_depth' => $request->input('rr_tread_depth', ''),
                    'condition' => $request->input('rr_condition', ''),
                    'notes' => $request->input('rr_notes', ''),
                ],
                'spare' => [
                    'type' => $request->input('spare_type', ''),
                    'condition' => $request->input('spare_condition', ''),
                    'notes' => $request->input('spare_notes', ''),
                ],
            ],
            'rims' => [
                'type' => $request->input('rim_type', ''),
                'condition' => $request->input('rim_condition', ''),
                'notes' => $request->input('rim_notes', ''),
            ],
            
            // Mechanical Report
            'mechanical' => [
                'engine_startup' => $request->input('engine_startup', ''),
                'idling_quality' => $request->input('idling_quality', ''),
                'acceleration' => $request->input('acceleration', ''),
                'engine_noises' => $request->input('engine_noises', ''),
                'exhaust_smoke' => $request->input('exhaust_smoke', ''),
                'oil_level' => $request->input('oil_level', ''),
                'coolant_level' => $request->input('coolant_level', ''),
                'brake_fluid' => $request->input('brake_fluid', ''),
                'power_steering_fluid' => $request->input('power_steering_fluid', ''),
                'transmission_type' => $request->input('transmission_type', ''),
                'gear_shifting' => $request->input('gear_shifting', ''),
                'brake_performance' => $request->input('brake_performance', ''),
                'brake_pad_thickness_front' => $request->input('brake_pad_thickness_front', ''),
                'brake_pad_thickness_rear' => $request->input('brake_pad_thickness_rear', ''),
                'notes' => $request->input('mechanical_notes', ''),
            ],
            
            // Engine Compartment
            'engine_compartment' => [
                'overall_condition' => $request->input('overall_condition', ''),
                'oil_leaks' => $request->input('oil_leaks', ''),
                'coolant_leaks' => $request->input('coolant_leaks', ''),
                'belt_condition' => $request->input('belt_condition', ''),
                'battery_condition' => $request->input('battery_condition', ''),
                'battery_age' => $request->input('battery_age', ''),
                'notes' => $request->input('engine_notes', ''),
            ],
            
            // Physical Hoist Inspection
            'physical_hoist' => [
                'undercarriage_condition' => $request->input('undercarriage_condition', ''),
                'rust_present' => $request->input('rust_present', ''),
                'exhaust_condition' => $request->input('exhaust_condition', ''),
                'suspension_condition' => $request->input('suspension_condition', ''),
                'brake_lines' => $request->input('brake_lines', ''),
                'notes' => $request->input('additional_hoist_notes', ''),
            ],
            
            // Images from all sections
            'images' => $this->gatherInspectionImages($request),
            
            // Generated timestamp
            'generated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Gather images from all inspection sections
     */
    private function gatherInspectionImages(Request $request)
    {
        $images = [
            'visual' => [],
            'specific_areas' => [],
            'interior' => [],
            'engine_compartment' => [],
            'physical_hoist' => []
        ];

        // Process visual inspection images
        if ($request->hasFile('visual_images')) {
            foreach ($request->file('visual_images') as $index => $image) {
                if ($image && $image->isValid()) {
                    $images['visual'][] = [
                        'base64' => base64_encode(file_get_contents($image->getPathname())),
                        'mime_type' => $image->getClientMimeType(),
                        'area_name' => 'visual_' . ($index + 1),
                        'original_name' => $image->getClientOriginalName()
                    ];
                }
            }
        }

        // Process base64 images from JavaScript (current system)
        $visualImagesData = $request->input('visual_images_data');
        if ($visualImagesData) {
            $visualImages = json_decode($visualImagesData, true);
            if (is_array($visualImages)) {
                foreach ($visualImages as $index => $imageData) {
                    if (isset($imageData['base64']) && $imageData['base64']) {
                        // Remove data URL prefix if present
                        $base64 = preg_replace('/^data:image\/[^;]+;base64,/', '', $imageData['base64']);
                        $images['visual'][] = [
                            'base64' => $base64,
                            'mime_type' => $imageData['mime_type'] ?? 'image/jpeg',
                            'area_name' => $imageData['area_name'] ?? 'visual_' . ($index + 1),
                            'original_name' => $imageData['original_name'] ?? 'visual_image_' . ($index + 1) . '.jpg'
                        ];
                    }
                }
            }
        }

        // Process specific area images
        $specificAreasData = $request->input('specific_areas_images_data');
        if ($specificAreasData) {
            $specificImages = json_decode($specificAreasData, true);
            if (is_array($specificImages)) {
                foreach ($specificImages as $index => $imageData) {
                    if (isset($imageData['base64']) && $imageData['base64']) {
                        $base64 = preg_replace('/^data:image\/[^;]+;base64,/', '', $imageData['base64']);
                        $images['specific_areas'][] = [
                            'base64' => $base64,
                            'mime_type' => $imageData['mime_type'] ?? 'image/jpeg',
                            'area_name' => $imageData['area_name'] ?? 'specific_' . ($index + 1),
                            'original_name' => $imageData['original_name'] ?? 'specific_area_' . ($index + 1) . '.jpg'
                        ];
                    }
                }
            }
        }

        // Process interior images
        $interiorImagesData = $request->input('interior_images_data');
        if ($interiorImagesData) {
            $interiorImages = json_decode($interiorImagesData, true);
            if (is_array($interiorImages)) {
                foreach ($interiorImages as $index => $imageData) {
                    if (isset($imageData['base64']) && $imageData['base64']) {
                        $base64 = preg_replace('/^data:image\/[^;]+;base64,/', '', $imageData['base64']);
                        $images['interior'][] = [
                            'base64' => $base64,
                            'mime_type' => $imageData['mime_type'] ?? 'image/jpeg',
                            'area_name' => $imageData['area_name'] ?? 'interior_' . ($index + 1),
                            'original_name' => $imageData['original_name'] ?? 'interior_' . ($index + 1) . '.jpg'
                        ];
                    }
                }
            }
        }

        return $images;
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
     * Generate PDF from existing web report
     */
    public function generateFromWeb($id)
    {
        $report = InspectionReport::findOrFail($id);
        
        // Use stored inspection data
        $inspectionData = $report->inspection_data;
        
        // Generate PDF from the same template
        $pdf = PDF::loadView('reports.inspection-pdf', compact('inspectionData'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download($report->pdf_filename);
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
     * Download a saved report
     */
    public function download($id)
    {
        $report = InspectionReport::findOrFail($id);
        
        // Check if file exists
        if (!Storage::disk('public')->exists($report->pdf_path)) {
            return redirect()->back()->with('error', 'Report file not found.');
        }
        
        return Storage::disk('public')->download($report->pdf_path, $report->pdf_filename);
    }

    /**
     * View report details
     */
    public function view($id)
    {
        $report = InspectionReport::findOrFail($id);
        
        // Check if file exists
        if (!Storage::disk('public')->exists($report->pdf_path)) {
            return redirect()->back()->with('error', 'Report file not found.');
        }
        
        // Return PDF for inline viewing
        return response(Storage::disk('public')->get($report->pdf_path))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $report->pdf_filename . '"');
    }

    /**
     * Delete a report
     */
    public function destroy($id)
    {
        $report = InspectionReport::findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($report->pdf_path)) {
            Storage::disk('public')->delete($report->pdf_path);
        }
        
        // Delete from database
        $report->delete();
        
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}