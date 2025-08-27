<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspection;

class DebugController extends Controller
{
    /**
     * Show the search debugging page
     */
    public function searchDebug()
    {
        return view('debug.search-debug');
    }

    /**
     * AJAX endpoint for search debugging
     */
    public function searchAjax(Request $request)
    {
        try {
            // Get the search term
            $searchTerm = $request->input('search', '');
            $hasSearch = !empty(trim($searchTerm));
            
            // Build the same query logic as ReportController
            // Since report numbers are generated from IDs, all inspections have report numbers
            // Show ALL reports regardless of status (as requested)
            $query = Inspection::with(['client', 'vehicle']); // No status filtering
            
            // Store original query for debugging
            $originalSql = $query->toSql();
            $originalBindings = $query->getBindings();
            
            // Apply enhanced search logic (same as ReportController)
            if ($hasSearch) {
                $search = trim($searchTerm);
                
                // Determine search type and apply appropriate logic
                if (stripos($search, 'INS-') === 0) {
                    // Full report number search (INS-XXXXXX format)
                    $reportId = str_replace(['INS-', 'ins-'], '', $search);
                    $reportId = ltrim($reportId, '0'); // Remove leading zeros
                    if (is_numeric($reportId)) {
                        $query->where('id', $reportId);
                    }
                } elseif (is_numeric($search)) {
                    // Numeric search - could be partial report ID, VIN digits, or registration
                    $searchLength = strlen($search);
                    
                    if ($searchLength >= 3 && $searchLength <= 6) {
                        // Partial report number search (3-6 digits) 
                        $query->where(function($q) use ($search) {
                            // Search by partial ID (report number digits)
                            $q->where('id', 'like', "%{$search}%")
                              // Also search in vehicle fields for numeric matches
                              ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                                  $vehicleQuery->where('vin', 'like', "%{$search}%")
                                             ->orWhere('registration_number', 'like', "%{$search}%")
                                             ->orWhere('engine_number', 'like', "%{$search}%");
                              });
                        });
                    } elseif ($searchLength >= 4) {
                        // Longer numeric search - likely VIN or full registration
                        $query->whereHas('vehicle', function($vehicleQuery) use ($search) {
                            $vehicleQuery->where('vin', 'like', "%{$search}%")
                                       ->orWhere('registration_number', 'like', "%{$search}%")
                                       ->orWhere('engine_number', 'like', "%{$search}%");
                        });
                    } else {
                        // Short numeric search (1-2 digits) - search everywhere
                        $query->where(function($q) use ($search) {
                            $q->where('id', 'like', "%{$search}%")
                              ->orWhereHas('vehicle', function($vehicleQuery) use ($search) {
                                  $vehicleQuery->where('vin', 'like', "%{$search}%")
                                             ->orWhere('registration_number', 'like', "%{$search}%")
                                             ->orWhere('engine_number', 'like', "%{$search}%");
                              });
                        });
                    }
                } else {
                    // Text-based search - search in vehicle fields with partial matching
                    $query->whereHas('vehicle', function($vehicleQuery) use ($search) {
                        $vehicleQuery->where('vin', 'like', "%{$search}%")
                                   ->orWhere('registration_number', 'like', "%{$search}%")
                                   ->orWhere('engine_number', 'like', "%{$search}%");
                    });
                }
            }
            
            // Get final SQL and bindings after search conditions
            $finalSql = $query->toSql();
            $finalBindings = $query->getBindings();
            
            // Execute query and get raw count
            $inspections = $query->orderBy('created_at', 'desc')->get();
            $rawCount = $inspections->count();
            
            // Transform data (same as ReportController)
            $reports = $inspections->map(function ($inspection) {
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
                $report->license_plate = $inspection->vehicle->registration_number ?? 'N/A';
                $report->engine_number = $inspection->vehicle->engine_number ?? 'N/A';
                $report->created_at = $inspection->created_at;
                $report->updated_at = $inspection->updated_at;
                $report->formatted_file_size = 'N/A';
                return $report;
            });
            
            $isEmpty = $reports->isEmpty();
            $showingSample = false;
            
            // Check if sample data logic would be triggered (same as ReportController)
            if ($isEmpty && !$hasSearch) {
                $showingSample = true;
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
                $sampleReport->license_plate = 'SAMPLE-REG';
                $sampleReport->engine_number = 'SAMPLE-ENG-001';
                $sampleReport->created_at = now();
                $sampleReport->updated_at = now();
                $sampleReport->formatted_file_size = 'N/A';
                
                $reports = collect([$sampleReport]);
            }
            
            // CRITICAL DEBUG: Check if search has results but sample is still showing
            if ($hasSearch && $rawCount > 0 && $showingSample) {
                $showingSample = true; // This indicates the bug!
            }
            
            // Additional debug: Check the actual condition used in ReportController
            $reportControllerCondition = $isEmpty && !$hasSearch;
            $actualShowingSample = $reportControllerCondition;
            
            // If we have search results but ReportController would still show sample, that's the bug
            if ($hasSearch && $rawCount > 0 && $actualShowingSample) {
                $showingSample = true;
            }
            
            return response()->json([
                'search_term' => $searchTerm,
                'has_search' => $hasSearch,
                'raw_count' => $rawCount,
                'final_count' => $reports->count(),
                'is_empty' => $isEmpty,
                'showing_sample' => $showingSample,
                'sql_query' => $finalSql,
                'sql_bindings' => $finalBindings,
                'original_sql' => $originalSql,
                'original_bindings' => $originalBindings,
                'report_controller_condition' => $reportControllerCondition,
                'results' => $reports->take(10)->map(function($report) {
                    return [
                        'id' => $report->id,
                        'report_number' => $report->report_number,
                        'vin_number' => $report->vin_number,
                        'vehicle_make' => $report->vehicle_make,
                        'vehicle_model' => $report->vehicle_model,
                        'inspector_name' => $report->inspector_name,
                        'is_sample' => strpos($report->report_number, 'SAMPLE') !== false
                    ];
                })->toArray()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}