# CLAUDE.md - Vehicle Inspection System Development

## Project Overview
Building a web-based vehicle inspection system for tablet use, designed for field inspectors to complete reports, capture photos, and generate professional PDFs. The system features interactive body panel assessment with visual highlighting and comprehensive reporting capabilities.

## Developer Background
- **Not a professional developer** - need beginner-friendly explanations
- **WordPress experience** - familiar with PHP and basic web concepts  
- **VS Code user** - comfortable with the editor
- **XAMPP setup** - developing locally on F: drive
- **HTML/CSS knowledge** - basic frontend skills
- **Very little JavaScript** - need guidance with complex JS
- **Learning Laravel** - first Laravel project, explain concepts clearly

## Technology Stack

### Current Setup
- **Laravel 12.0** - PHP web framework
- **PHP 8.2** - Required version
- **MySQL** - Database (via XAMPP, not SQLite)
- **Bootstrap 5.3.2** - CSS framework (chosen over Tailwind for familiarity)
- **Blade** - Laravel templating engine
- **Vanilla JavaScript** - No frameworks, keeping it simple

### File Structure
```
F:\xampp\htdocs\vehicle-inspection\
├── app/Http/Controllers/
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── dashboard.blade.php
│   └── visual-inspection.blade.php
├── routes/web.php
├── public/
│   ├── css/inspection.css
│   ├── images/ (for vehicle panel images)
│   └── js/ (future JavaScript files)
├── database/migrations/
└── storage/app/public/ (for uploaded images)
```

## Brand Guidelines & Design System
- **Primary Color**: #4f959b (teal/blue-green)
- **Text Color**: #2b2b2b (dark gray)
- **Status Colors**: Traffic light system
  - Green (#28a745) - Good/Complete
  - Orange/Yellow (#ffc107) - Warning/In Progress  
  - Red (#dc3545) - Danger/Failed
- **Design**: Clean, professional, tablet-optimized
- **CSS Variables**: Use CSS custom properties for consistent theming

## Development Commands

### Daily Development Workflow
```bash
# Start XAMPP (Apache + MySQL)
# Open VS Code to: F:\xampp\htdocs\vehicle-inspection\

# Start Laravel development server
php artisan serve

# For frontend changes, refresh browser at:
# http://127.0.0.1:8000
```

### Future Commands (when backend is implemented)
```bash
php artisan migrate          # Run database migrations
php artisan test            # Run tests
composer dump-autoload     # Refresh autoloader
```

## Current Implementation Status

### ✅ Completed Features

#### Dashboard (`/dashboard`) - Dual Inspection Types
- **Two Inspection Workflows**: Condition Report vs Technical Inspection
- **Condition Report**: Standard assessment ending at Engine Compartment
- **Technical Inspection**: Full assessment including Physical Hoist Inspection
- Professional layout with action cards and inspection type selection
- Recent inspections display (mock data)
- Navigation to inspection forms with workflow detection
- Responsive Bootstrap design
- Custom CSS in `public/css/inspection.css`

#### Complete Inspection Module System
All inspection modules are fully functional with consistent UI/UX:

**Visual Inspection Form (`/inspection/visual`)**
- Vehicle details form (client info, car details)
- Image upload grid with camera integration
- Automatic square cropping via JavaScript
- Diagnostic report section
- Form validation (client-side)

**Body Panel Assessment (`/inspection/body-panel`)**
- **22 interactive body panels** with visual highlighting
- **Two-way highlighting**: Click panel ↔ highlights form field
- **White panel images** with red highlighting on interaction
- **Assessment fields**: Condition, Comments, Additional Comments
- **InspectionCards integration** for consistent data handling

**Interior Assessment (`/inspection/interior`)**
- **17 interior components** assessment
- Color and condition dropdown fields
- Camera integration for component documentation
- Structured data collection

**Service Booklet (`/inspection/service-booklet`)**
- Service history documentation
- Service interval tracking
- Maintenance record assessment

**Tyres & Rims Assessment (`/inspection/tyres-rims`)**
- Individual tyre assessment (4 positions)
- Tread depth, condition, and rim assessment
- Visual tyre damage documentation

**Mechanical Report (`/inspection/mechanical-report`)**
- **Road test data**: Editable distance and speed fields
- **Mechanical components**: 29 components with condition assessment
- **Braking system**: Detailed brake pad/disc life percentages
- **Automatic brake summary**: Average pad/disc life with status indicators
- Real-time brake system health calculations

**Engine Compartment Assessment (`/inspection/engine-compartment`)**
- Engine findings and observations checklist
- **27 engine components** with condition assessment
- **Adaptive navigation**: Different endpoints based on inspection type
- Preview functionality for data verification

**Physical Hoist Inspection (`/inspection/physical-hoist`)**
- **3 major categories**: Suspension, Engine, Drivetrain systems
- **28 total components**: Full names (Left Front/Right Front vs LF/RF)
- **Dual condition fields**: Primary and Secondary condition assessment
- Complete under-vehicle inspection workflow

#### Advanced System Features

**InspectionCards System (`public/js/inspection-cards.js`)**
- **Reusable component framework** for all assessment modules
- **Camera integration**: Single-click image capture (fixed double-click issue)
- **Form data management**: Consistent data structure across modules
- **Event handling**: Centralized event management with duplicate prevention
- **Dynamic field generation**: Configurable assessment fields per module

**Preview System (Complete for All Modules)**
- **Individual module previews**: Every module has working preview functionality
- **Data verification**: Shows exactly what data is captured
- **Debug information**: Raw form data display for troubleshooting
- **Professional formatting**: Clean, organized display of assessment data
- **New tab opening**: Non-disruptive preview workflow

**Navigation & Workflow Management**
- **Breadcrumb system**: Progress tracking across all modules
- **Inspection type detection**: Different workflows (Condition vs Technical)
- **Session storage**: Data persistence between form steps
- **Responsive design**: Tablet-optimized interface throughout

#### Layout & Design System
- **Consistent branding**: #4f959b primary color throughout
- **Bootstrap integration**: Professional, responsive design
- **Custom CSS theming**: `public/css/inspection.css`
- **Icon system**: Bootstrap Icons integration
- **Status color coding**: Traffic light system (Green/Orange/Red)

### 🚧 Currently Working On: Backend Integration (Next Priority)

### ❌ Not Yet Implemented (Backend Needed)

#### Database Layer
```bash
# Need to create:
php artisan make:model Inspection -m
php artisan make:model Vehicle -m  
php artisan make:model Client -m
php artisan make:model BodyPanelAssessment -m
```

#### Controllers
```bash
# Need to create:
php artisan make:controller VisualInspectionController
php artisan make:controller ImageUploadController
php artisan make:controller ReportController
```

#### File Storage
- Configure Laravel storage for uploaded images
- Implement image compression and processing
- GPS metadata extraction from photos

## Communication & Development Preferences

### Code Explanations
- **Explain the "why"** behind Laravel concepts and structure
- **Provide complete file contents** when possible
- **Use artifacts for large code blocks** - easier to copy
- **Specify exact file paths** - no ambiguity about locations
- **Include step-by-step testing** after each implementation

### Development Approach
1. **Section by section** - complete frontend, then add backend
2. **Copy-paste friendly** - provide complete, working code
3. **Minimal dependencies** - avoid complex packages when possible
4. **Progressive enhancement** - build basic functionality first
5. **Mobile-first design** - tablet optimization is priority

### File Organization Preferences
- **Separate CSS files** - keep styles in `public/css/inspection.css`
- **Minimal inline styles** - use CSS classes instead
- **Organized JavaScript** - consider separate JS files for complex features
- **Laravel conventions** - follow framework patterns for maintainability

## Next Development Priorities

### ✅ COMPLETED: Frontend Development Phase
- All 8 inspection modules fully functional
- Complete InspectionCards system with camera integration
- Preview functionality for all modules
- Dual inspection workflow (Condition Report vs Technical Inspection)
- Professional UI/UX with consistent branding

### 🎯 IMMEDIATE (Backend Integration - Current Priority)
1. **Database Models & Migrations**
   ```bash
   php artisan make:model Inspection -m
   php artisan make:model Vehicle -m
   php artisan make:model Client -m
   php artisan make:model AssessmentData -m
   ```

2. **Data Persistence System**
   - Convert preview functionality to actual data saving
   - Implement form submission handlers for all modules
   - Store assessment data in database instead of session storage
   - Handle image upload and storage properly

3. **Basic CRUD Operations**
   - Save inspection data to database
   - Retrieve inspection history
   - Update existing inspections
   - Delete draft inspections

4. **File Storage Configuration**
   - Configure Laravel storage for uploaded images
   - Implement image compression and processing
   - GPS metadata extraction from photos
   - Secure file access and organization

### Short Term (Report Generation)
1. **PDF Generation System**
   - Professional report templates with company branding
   - Convert assessment data to formatted PDFs
   - Include captured images in reports
   - Different templates for Condition vs Technical reports

2. **Report Management**
   - Email delivery system for completed reports
   - Report status tracking (Draft/Complete/Delivered)
   - Search and filtering for inspection history
   - Export functionality (PDF/Excel)

### Medium Term (User Management & Advanced Features)
1. **Authentication System**
   - Inspector login/logout functionality
   - Multi-user support with role-based permissions
   - Inspection assignment and tracking
   - User-specific inspection history

2. **Advanced Features**
   - Offline mode for field use
   - Data synchronization when connection restored
   - Advanced search and analytics
   - Performance metrics and reporting

### Long Term (Production Deployment)
1. **Production Environment Setup**
   - Deploy to South African VPS (domains.co.za)
   - SSL configuration and security hardening
   - Database optimization and indexing
   - Backup and monitoring systems

2. **Scalability & Performance**
   - Load testing and optimization
   - CDN setup for image delivery
   - Database query optimization
   - Caching implementation

## Hosting & Deployment Plans

### Current Environment
- **XAMPP local development** on F: drive
- **No version control** yet (consider Git setup)
- **Manual file management** via VS Code

### Future Deployment
- **Target**: South African VPS hosting (domains.co.za)
- **Requirements**: Step-by-step deployment guidance needed
- **Preferences**: Avoid complex Linux command-line operations
- **Timeline**: After core functionality is complete

## Testing Strategy

### Manual Testing Priorities
1. **Tablet compatibility** - primary use case
2. **Camera functionality** - photo capture and cropping
3. **Form validation** - required fields and data integrity
4. **Interactive elements** - panel highlighting and form coordination
5. **Responsive design** - various screen sizes and orientations

### Browser Testing
- **Primary**: Chrome/Safari on Android tablets
- **Secondary**: Desktop Chrome for development
- **Consider**: iPad Safari for broader compatibility

## Success Criteria & Quality Gates

### User Experience Goals
- **Intuitive interface** - inspectors can use without training
- **Fast interaction** - responsive touch targets and smooth animations
- **Professional appearance** - builds client confidence
- **Reliable operation** - works consistently in field conditions

### Technical Requirements
- **Tablet-optimized performance** - smooth scrolling and interaction
- **Offline resilience** - graceful handling of connection issues
- **Data integrity** - accurate capture and storage of inspection data
- **Scalability** - support for multiple concurrent inspectors

## Code Style & Standards

### PHP/Laravel
- Follow PSR-12 coding standards
- Use Laravel naming conventions (PascalCase for classes, snake_case for variables)
- Keep controllers thin, use services for business logic
- Prefer Eloquent ORM over raw SQL queries

### Frontend
- Use Bootstrap classes primarily, custom CSS for brand-specific styling
- Organize CSS with comments and logical sections
- Keep JavaScript functions small and focused
- Use consistent naming conventions across files

### File Naming
- **Views**: kebab-case (visual-inspection.blade.php)
- **CSS classes**: kebab-case (.body-panel-assessment)
- **JavaScript functions**: camelCase (highlightPanel())
- **Images**: kebab-case (front-bumper.png)

Remember: Provide explanations suitable for someone learning Laravel, not assumptions about advanced development knowledge. Always include the "why" behind technical decisions and Laravel-specific concepts.
# Interior Assessment Module
- Data source: interior-assessment-data.json
- Structure: Similar to Body Panel Assessment
- Dropdown fields: colour, condition
- Total items: 17 interior components