# CHANGELOG

## [1.2.0] - 2025-08-11 - Field Mapping Fixes

### Fixed
- **Critical**: Fixed visual inspection form field collection - empty fields now properly sent to API
- **Database**: Added missing vehicle fields (`colour`, `doors`, `fuel_type`) to database schema
- **Controller**: Updated validation rules to include new vehicle fields
- **Reports**: Fixed field mapping in report templates to display all vehicle information
- **Media**: Confirmed storage link exists for image/PDF rendering

### Added  
- **Migration**: `2025_08_11_100339_add_missing_vehicle_fields_to_vehicles_table.php`
- **Diagnostic Tool**: `tools/field_map_check.php` for validating form → controller → database → view consistency
- **Tests**: Comprehensive test suite for field persistence and validation in `tests/Feature/VisualInspectionFieldMappingTest.php`

### Changed
- **Visual Inspection Form**: Modified JavaScript to send all form fields (including empty ones) to API
- **Vehicle Model**: Added `colour`, `doors`, `fuel_type` to fillable fields
- **InspectionController**: Added validation and persistence for new vehicle fields  
- **ReportController**: Enhanced vehicle data mapping to include `engine_number` and all vehicle fields

### Removed
- **Client Phone/Email**: Removed unnecessary client phone and email requirements from forms and validation
- **Inspector Phone/Email**: Removed inspector contact fields to simplify data collection

### Technical Details
- **Issue Root Cause**: JavaScript condition `&& value` prevented empty form fields from being sent to API
- **Database Schema**: Added nullable string columns for colour, doors, and fuel_type
- **Data Flow**: Fixed end-to-end mapping: Form → Controller → Database → Report Template
- **Validation**: All fields now use consistent nullable validation with appropriate length limits

### Testing
- ✅ All 5 critical fields (`engine_number`, `colour`, `doors`, `fuel_type`, `vehicle_type`) save correctly
- ✅ Empty fields handled gracefully without validation errors  
- ✅ Report displays real data from database instead of dummy data
- ✅ Field validation enforces appropriate length limits
- ✅ Special characters in field values handled correctly

### Assumptions Made
1. **Field Requirements**: Made all new fields optional/nullable to maintain backward compatibility
2. **Field Length Limits**: Set reasonable limits (colour: 50 chars, doors: 20 chars, fuel_type: 50 chars)
3. **Migration Placement**: Added new columns after `vehicle_type` for logical grouping
4. **Naming Convention**: Used `snake_case` in database and `kebab-case` in HTML IDs consistently

### Rollback Instructions
```bash
# Rollback database migration
php artisan migrate:rollback --step=1

# Restore previous controller validation
git checkout HEAD~1 -- app/Http/Controllers/InspectionController.php

# Restore previous vehicle model
git checkout HEAD~1 -- app/Models/Vehicle.php

# Restore previous report controller
git checkout HEAD~1 -- app/Http/Controllers/ReportController.php

# Remove test files
rm tests/Feature/VisualInspectionFieldMappingTest.php
rm tools/field_map_check.php
```

### Migration Rollback Details
**Migration Name**: `2025_08_11_100339_add_missing_vehicle_fields_to_vehicles_table`
**Rollback SQL**: 
```sql
ALTER TABLE vehicles DROP COLUMN colour, DROP COLUMN doors, DROP COLUMN fuel_type;
```
**Laravel Command**: `php artisan migrate:rollback --step=1`