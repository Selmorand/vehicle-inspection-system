<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vehicle Inspection System')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/inspection.css') }}" rel="stylesheet">
    
    @yield('additional-css')
    @yield('styles')
    <!-- Custom CSS - MUST COME AFTER BOOTSTRAP -->
    <style>
        /* Responsive navbar styling */
        @media (max-width: 1199px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.95rem;
            }
            .navbar-nav .nav-link i {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 1024px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 0.5rem;
                font-size: 0.9rem;
            }
            .navbar-brand img {
                height: 150px !important;
            }
        }
        
        /* Ensure icons stay inline */
        .navbar-nav .nav-link i {
            display: inline-block;
            vertical-align: middle;
        }
        
        .navbar-nav .nav-link {
            white-space: nowrap;
        }
        
        /* Dropdown improvements */
        .dropdown-menu {
            min-width: 200px;
        }
        
        .dropdown-item i {
            display: inline-block;
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="200" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav ms-auto">
                        @inspector
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}" style="color: #4f959b;">
                                    <i class="bi bi-house me-1 mb-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="newInspectionDropdown" role="button" data-bs-toggle="dropdown" style="color: #4f959b;">
                                    <i class="bi bi-plus-circle me-1 mb-1"></i>New Inspection
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/inspection/visual') }}" onclick="clearInspectionData(); setInspectionType('condition')">
                                            <i class="bi bi-file-text me-2"></i>Condition Report
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/inspection/visual') }}" onclick="clearInspectionData(); setInspectionType('technical')">
                                            <i class="bi bi-gear-wide-connected me-2"></i>Technical Inspection
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endinspector
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reports.index') }}" style="color: #4f959b;">
                                <i class="bi bi-file-earmark-pdf me-1 mb-1"></i>Reports
                            </a>
                        </li>
                        @admin
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users') }}" style="color: #4f959b;">
                                    <i class="bi bi-people me-1 mb-1"></i>User Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.activity-logs') }}" style="color: #dc3545;">
                                    <i class="bi bi-shield-lock me-1 mb-1"></i>Activity Logs
                                </a>
                            </li>
                        @endadmin
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="color: #4f959b;">
                                <i class="bi bi-person-circle me-1 mb-1"></i>
                                {{ Auth::user()->name }}
                                <span class="badge bg-secondary ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Account</h6></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" style="color: #4f959b;">
                                <i class="bi bi-box-arrow-in-right me-1 mb-1"></i>Login
                            </a>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vehicle Notification System -->
    <script src="{{ asset('js/notifications.js') }}"></script>
    
    <!-- Global inspection functions -->
    <script>
        function clearInspectionData() {
            // Clear all inspection session data when starting a new inspection
            sessionStorage.removeItem('currentInspectionId');
            sessionStorage.removeItem('visualInspectionData');
            sessionStorage.removeItem('visualInspectionImages');
            sessionStorage.removeItem('bodyPanelAssessmentData');
            sessionStorage.removeItem('bodyPanelAssessmentImages');
            sessionStorage.removeItem('interiorAssessmentData');
            sessionStorage.removeItem('interiorAssessmentImages');
            sessionStorage.removeItem('serviceBookletData');
            sessionStorage.removeItem('tyresRimsData');
            sessionStorage.removeItem('tyresRimsAssessmentData');
            sessionStorage.removeItem('mechanicalReportData');
            sessionStorage.removeItem('mechanicalComponentsData');
            sessionStorage.removeItem('brakingSystemData');
            sessionStorage.removeItem('engineCompartmentData');
            sessionStorage.removeItem('physicalHoistData');
            sessionStorage.removeItem('inspectionType');
            
            console.log('Inspection data cleared for new inspection');
        }

        function setInspectionType(type) {
            sessionStorage.setItem('inspectionType', type);
            console.log('Inspection type set to:', type);
        }
    </script>
    
    @yield('additional-js')
</body>
</html>