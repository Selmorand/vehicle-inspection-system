# Search Enhancement Documentation

## Overview
Enhanced search functionality with partial matching and completed reports filtering.

## Key Features

### 1. Status Filtering (CORRECTED)
- **Requirement**: Show all reports except drafts
- **Implementation**: `->where('status', '!=', 'draft')`
- **Logic**: All inspections have report numbers (generated from ID), so exclude only drafts
- **Impact**: Shows finalized, submitted, approved, completed reports; excludes drafts

### 2. Partial Search Types

#### Report Number Search
- **Full Format**: `INS-000011` → Exact match for report ID 11
- **Partial (3-6 digits)**: `011` → Matches any report containing "011"
- **Short (1-2 digits)**: `1` → Matches any report containing "1"

#### VIN Search  
- **Full VIN**: `TEST-VIN-68adc4d995761` → Exact VIN match
- **Partial (4+ digits)**: `1234` → Matches VINs containing "1234"
- **Mixed**: `68adc` → Matches VINs containing "68adc"

#### Registration/Engine Search
- **Numeric**: `321456987` → Searches registration and engine numbers
- **Alphanumeric**: `ABC123` → Searches registration numbers

### 3. Search Logic Flow

```php
if (stripos($search, 'INS-') === 0) {
    // Full report number format
    $query->where('id', $extracted_id);
} elseif (is_numeric($search)) {
    $length = strlen($search);
    if ($length >= 3 && $length <= 6) {
        // Partial report number + vehicle fields
    } elseif ($length >= 4) {
        // VIN/registration focused
    } else {
        // Short search - everywhere
    }
} else {
    // Text search in vehicle fields
}
```

## Performance Optimizations

### Database Indexes
- `inspections.status` - For completed report filtering
- `inspections.inspection_date` - For date range queries  
- `vehicles.vin` - For VIN partial matching
- `vehicles.registration_number` - For registration searching
- `vehicles.engine_number` - For engine number searching

### Query Optimization
- Uses `LIKE '%search%'` for partial matching
- Implements `whereHas()` for relationship searches
- Groups related conditions with `where(function($q))`

## Usage Examples

### Search Types
```
Search: "1234"     → VINs containing 1234
Search: "005"      → Report IDs containing 005  
Search: "INS-000011" → Exact report INS-000011
Search: "TEST"     → VINs/registrations containing "TEST"
```

### Date Filtering
```
/reports?search=1234&from_date=2025-01-01&to_date=2025-12-31
```

### Status Behavior (CORRECTED)
```
Before: Shows all reports (draft, completed, pending)
After:  Shows all reports except drafts (completed, finalized, submitted, approved, etc.)
```

## Testing Scenarios

### Valid Searches
- ✅ Partial VIN: `1234` finds VINs with these digits
- ✅ Partial Report: `011` finds report INS-000011
- ✅ Full Report: `INS-000011` finds exact match
- ✅ Registration: `ABC123` finds matching registrations

### Status Filtering (CORRECTED)  
- ✅ All non-draft reports appear in results
- ✅ Draft reports are excluded
- ✅ Completed, finalized, submitted, approved reports are included

### Performance
- ✅ Indexes support partial LIKE queries
- ✅ Status filtering is indexed
- ✅ Date ranges use indexed columns

## Migration Commands
```bash
php artisan migrate
```

## Rollback (if needed)
```bash
php artisan migrate:rollback
```