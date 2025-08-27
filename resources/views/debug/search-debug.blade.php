<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Search Function Debug Tool</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
    .debug-section {
        margin-bottom: 2rem;
        border-left: 4px solid #007bff;
        padding-left: 1rem;
    }
    .debug-result {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        margin: 1rem 0;
    }
    .sql-query {
        background-color: #1e1e1e;
        color: #ffffff;
        padding: 1rem;
        border-radius: 0.375rem;
        font-family: 'Courier New', monospace;
        white-space: pre-wrap;
        word-break: break-all;
    }
    .test-result {
        margin: 0.5rem 0;
        padding: 0.75rem;
        border-radius: 0.375rem;
    }
    .test-success {
        background-color: #d1edff;
        border-left: 4px solid #28a745;
    }
    .test-fail {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
    }
    .test-info {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-bug"></i> Search Debug Tool
            </a>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-search"></i> Search Function Debugging Tool
                        </h5>
                    </div>
                    <div class="card-body">

                        <!-- Interactive Search Test -->
                        <div class="debug-section">
                            <h6><i class="bi bi-play-circle"></i> Interactive Search Test</h6>
                            <form id="debugSearchForm" class="row g-3">
                                <div class="col-md-8">
                                    <label for="search_term" class="form-label">Search Term</label>
                                    <input type="text" class="form-control" id="search_term" 
                                           placeholder="Enter VIN, Registration, Engine No, or Report #" 
                                           value="INS-000011">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Debug Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div id="searchResults" class="debug-result" style="display: none;">
                                <h6>Search Results:</h6>
                                <div id="searchResultsContent"></div>
                            </div>
                        </div>

                        <!-- Database Analysis -->
                        <div class="debug-section">
                            <h6><i class="bi bi-database"></i> Database State Analysis</h6>
                            <div class="debug-result">
                                @php
                                    try {
                                        $inspectionCount = \App\Models\Inspection::count();
                                        $vehicleCount = \App\Models\Vehicle::count();
                                        $clientCount = \App\Models\Client::count();
                                    } catch (\Exception $e) {
                                        $inspectionCount = 'Error: ' . $e->getMessage();
                                        $vehicleCount = 'Error';
                                        $clientCount = 'Error';
                                    }
                                @endphp
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $inspectionCount }}</h5>
                                                <p class="card-text">Total Inspections</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $vehicleCount }}</h5>
                                                <p class="card-text">Total Vehicles</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $clientCount }}</h5>
                                                <p class="card-text">Total Clients</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sample vs Real Data Analysis -->
                        <div class="debug-section">
                            <h6><i class="bi bi-table"></i> Data Type Analysis</h6>
                            <div class="debug-result">
                                @php
                                    try {
                                        // Get all inspections with their data
                                        $inspections = \App\Models\Inspection::with(['client', 'vehicle'])
                                            ->orderBy('created_at', 'desc')
                                            ->take(10)
                                            ->get();
                                    } catch (\Exception $e) {
                                        $inspections = collect();
                                    }
                                @endphp
                                
                                <h6>Recent Inspections (Last 10):</h6>
                                @if($inspections->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Report #</th>
                                                    <th>VIN</th>
                                                    <th>Registration</th>
                                                    <th>Engine #</th>
                                                    <th>Vehicle</th>
                                                    <th>Inspector</th>
                                                    <th>Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inspections as $inspection)
                                                <tr>
                                                    <td>{{ $inspection->id }}</td>
                                                    <td><span class="badge bg-primary">INS-{{ str_pad($inspection->id, 6, '0', STR_PAD_LEFT) }}</span></td>
                                                    <td>{{ $inspection->vehicle->vin ?? 'N/A' }}</td>
                                                    <td>{{ $inspection->vehicle->registration_number ?? 'N/A' }}</td>
                                                    <td>{{ $inspection->vehicle->engine_number ?? 'N/A' }}</td>
                                                    <td>{{ ($inspection->vehicle->manufacturer ?? 'Unknown') . ' ' . ($inspection->vehicle->model ?? 'Unknown') }}</td>
                                                    <td>{{ $inspection->inspector_name ?? 'N/A' }}</td>
                                                    <td>{{ $inspection->created_at ? $inspection->created_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> 
                                        No inspections found in database. This explains why searches are showing sample data.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Predefined Test Cases -->
                        <div class="debug-section">
                            <h6><i class="bi bi-list-check"></i> Automated Test Cases</h6>
                            <div class="debug-result">
                                <button type="button" class="btn btn-success" onclick="runAllTests()">
                                    <i class="bi bi-play"></i> Run All Tests
                                </button>
                                <div id="testResults" class="mt-3"></div>
                            </div>
                        </div>

                        <!-- Search Logic Analysis -->
                        <div class="debug-section">
                            <h6><i class="bi bi-code-square"></i> Search Logic Analysis</h6>
                            <div class="debug-result">
                                <h6>Current Search Implementation:</h6>
                                <ul>
                                    <li><strong>Searchable Fields:</strong> VIN, Registration Number, Engine Number, Report Number (INS-XXXXXX format)</li>
                                    <li><strong>Query Type:</strong> LIKE queries with % wildcards</li>
                                    <li><strong>Fallback Logic:</strong> Shows sample data if no results AND no search parameter</li>
                                    <li><strong>Expected Behavior:</strong> Show empty results if search finds nothing</li>
                                </ul>
                                
                                <h6>Potential Issues:</h6>
                                <ul class="text-danger">
                                    <li>Sample data condition may not be checking search parameter correctly</li>
                                    <li>Search query may not be executing properly</li>
                                    <li>Data transformation may be overriding search results</li>
                                    <li>Cache issues causing stale results</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Interactive search debugging
    document.getElementById('debugSearchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = document.getElementById('search_term').value;
        debugSearch(searchTerm);
    });

    async function debugSearch(searchTerm) {
        const resultsDiv = document.getElementById('searchResults');
        const contentDiv = document.getElementById('searchResultsContent');
        
        resultsDiv.style.display = 'block';
        contentDiv.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Running debug search...';
        
        try {
            const response = await fetch(`/debug/search-ajax`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    search: searchTerm
                })
            });
            
            const data = await response.json();
            
            let html = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Debug Information:</h6>
                        <ul>
                            <li><strong>Search Term:</strong> "${searchTerm}"</li>
                            <li><strong>Has Search Param:</strong> ${data.has_search ? 'Yes' : 'No'}</li>
                            <li><strong>Raw Query Results:</strong> ${data.raw_count} records</li>
                            <li><strong>Final Results:</strong> ${data.final_count} records</li>
                            <li><strong>Is Empty:</strong> ${data.is_empty ? 'Yes' : 'No'}</li>
                            <li><strong>Showing Sample:</strong> ${data.showing_sample ? 'Yes' : 'No'}</li>
                        </ul>
                        
                        <h6>SQL Query:</h6>
                        <div class="sql-query">${data.sql_query}</div>
                        
                        <h6>SQL Bindings:</h6>
                        <pre>${JSON.stringify(data.sql_bindings, null, 2)}</pre>
                    </div>
                    <div class="col-md-6">
                        <h6>Returned Results:</h6>
                        ${data.results.length > 0 ? 
                            '<div class="table-responsive"><table class="table table-sm"><thead><tr><th>Report #</th><th>VIN</th><th>Vehicle</th><th>Type</th></tr></thead><tbody>' +
                            data.results.map(result => `
                                <tr>
                                    <td><span class="badge ${result.report_number.includes('SAMPLE') ? 'bg-warning' : 'bg-primary'}">${result.report_number}</span></td>
                                    <td>${result.vin_number}</td>
                                    <td>${result.vehicle_make} ${result.vehicle_model}</td>
                                    <td><span class="badge ${result.report_number.includes('SAMPLE') ? 'bg-warning' : 'bg-success'}">${result.report_number.includes('SAMPLE') ? 'Sample' : 'Real'}</span></td>
                                </tr>
                            `).join('') +
                            '</tbody></table></div>'
                            : '<div class="alert alert-info">No results found</div>'
                        }
                    </div>
                </div>
            `;
            
            contentDiv.innerHTML = html;
            
        } catch (error) {
            contentDiv.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${error.message}
                </div>
            `;
        }
    }

    // Automated test suite
    async function runAllTests() {
        const testResults = document.getElementById('testResults');
        testResults.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Running tests...</span></div>';
        
        const testCases = [
            { term: 'INS-000011', description: 'Search for report number INS-000011' },
            { term: 'TEST-VIN-68adc4d995761', description: 'Search for known VIN' },
            { term: '321456987', description: 'Search for VIN number' },
            { term: 'NONEXISTENT', description: 'Search for non-existent term' },
            { term: '', description: 'Empty search (should show all records or sample)' }
        ];
        
        let html = '<h6>Test Results:</h6>';
        
        for (const testCase of testCases) {
            try {
                const response = await fetch(`/debug/search-ajax`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        search: testCase.term
                    })
                });
                
                const data = await response.json();
                
                // Analyze results
                let status = 'info';
                let analysis = '';
                
                if (testCase.term === '') {
                    // Empty search should show all records or sample
                    status = 'success';
                    analysis = `Empty search returned ${data.final_count} results`;
                } else if (testCase.term === 'NONEXISTENT') {
                    // Non-existent search should return no results
                    if (data.final_count === 0) {
                        status = 'success';
                        analysis = 'Correctly returned no results for non-existent search';
                    } else if (data.showing_sample) {
                        status = 'fail';
                        analysis = 'ERROR: Showing sample data when should show no results';
                    } else {
                        status = 'info';
                        analysis = `Returned ${data.final_count} results (may be valid matches)`;
                    }
                } else {
                    // Specific searches
                    if (data.showing_sample) {
                        status = 'fail';
                        analysis = 'ERROR: Showing sample data instead of search results';
                    } else if (data.final_count > 0) {
                        status = 'success';
                        analysis = `Found ${data.final_count} matching results`;
                    } else {
                        status = 'info';
                        analysis = 'No matching results found (may be valid if data doesn\'t exist)';
                    }
                }
                
                html += `
                    <div class="test-result test-${status}">
                        <strong>${testCase.description}</strong> (Term: "${testCase.term}")<br>
                        <small>${analysis} | Raw: ${data.raw_count}, Final: ${data.final_count}, Sample: ${data.showing_sample ? 'Yes' : 'No'}</small>
                    </div>
                `;
                
            } catch (error) {
                html += `
                    <div class="test-result test-fail">
                        <strong>${testCase.description}</strong> (Term: "${testCase.term}")<br>
                        <small>ERROR: ${error.message}</small>
                    </div>
                `;
            }
        }
        
        testResults.innerHTML = html;
    }

    // Auto-run initial debug search
    window.onload = function() {
        debugSearch('INS-000011');
    };
    </script>
</body>
</html>