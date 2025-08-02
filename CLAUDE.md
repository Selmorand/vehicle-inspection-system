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

#### Dashboard (`/dashboard`)
- Professional layout with action cards
- Recent inspections display (mock data)
- Navigation to inspection forms
- Responsive Bootstrap design
- Custom CSS in `public/css/inspection.css`

#### Visual Inspection Form (`/inspection/visual`) - Frontend Only
- Vehicle details form (client info, car details)
- Image upload grid with camera integration
- Automatic square cropping via JavaScript
- Diagnostic report section
- Form validation (client-side)
- **File**: `resources/views/visual-inspection.blade.php`

#### Layout System
- Bootstrap navbar with brand colors
- Responsive navigation
- Custom CSS theming
- **File**: `resources/views/layouts/app.blade.php`

### 🚧 Currently Working On: Interactive Body Panel Assessment

#### Requirements
- **22 body panels**: Front bumper, Bonnet, FR/LF headlights, LF/FR fenders, doors, mirrors, quarter panels, taillights, roof, windscreen, rear window, engine compartment
- **Two-way highlighting**: 
  - Click panel → highlights form field + label background turns red
  - Hover on form label → corresponding panel turns red
- **White panel images** with black outlines that turn red on hover
- **Assessment fields**: Condition (Good/Average/Bad), Comments dropdown, Additional Comments, Other
- **Visual feedback**: Panel colors change based on interaction, not condition

#### Technical Implementation
- **Image overlay method**: Base car image + individual panel PNGs
- **CSS positioning**: Absolute positioning for panel overlays
- **JavaScript coordination**: Event listeners for two-way highlighting
- **Form integration**: Dynamic form generation for selected panels

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

### Immediate (Body Panel System)
1. **Complete interactive panel highlighting** with white panel images
2. **Implement form-to-panel coordination** for seamless UX
3. **Add panel assessment data collection** (condition, comments)
4. **Test on tablet devices** for touch interaction

### Short Term (Backend Integration)
1. **Create database models** for inspections, vehicles, clients
2. **Implement form submission** and data persistence
3. **Add image upload handling** with proper storage
4. **Build basic CRUD operations** for inspection management

### Medium Term (Advanced Features)
1. **PDF generation** with company branding
2. **Email delivery system** for reports
3. **Search and filtering** for inspection history
4. **User authentication** and inspector management

### Long Term (Production Ready)
1. **Deploy to South African VPS** (domains.co.za)
2. **SSL configuration** and security hardening
3. **Backup and monitoring** systems
4. **Performance optimization** for production use

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