# CLAUDE.md – Vehicle Inspection System Development
**Lean Startup-Friendly Version – Core Instructions for Claude Max**

## Purpose
This file is loaded at the start of every Claude Max session in VS Code. It contains ONLY essential, always-relevant information for the project.

---

## Project Overview
Web-based vehicle inspection system for tablet use. Features:
- Field inspectors complete reports, capture photos, generate PDFs.
- Interactive body panel assessments with visual highlighting.
- Tablet-optimised interface.

---

## Tech Stack (Fixed)
- Laravel 12.0 + PHP 8.2
- MySQL (no SQLite)
- Bootstrap 5.3.2 (no Tailwind)
- Blade templates
- Vanilla JavaScript
- XAMPP local dev on F: drive

---

## Non-Negotiables
- Must remain Laravel + PHP + Bootstrap.
- Must be tablet-optimised first.
- Minimal dependencies for low maintenance.
- Do not break working camera capture.
- **NEVER modify panel-card CSS or styling in web-report.blade.php unless explicitly requested and confirmed** - This styling is finalized and critical for report consistency.

---

## Prompt Rules for Claude
When responding:
1. Give full working code with file paths.
2. Explain WHY, not just how.
---

## Data Integrity & Retention
- Store all data/images in MySQL for at least 2 years.
- Weekly DB + uploads backup (SQL + zip).
- Transaction-safe writes; rollback on failure.
- Use soft deletes to prevent data loss.
- Index DB tables for performance.

---

## Known Issues to Watch
- Bootstrap overriding custom CSS (load order).
- Camera quirks (double click, cropping).
- Highlighting misalignments in interactive panels.
- Session data loss before DB save.

---

## Backup Plan
1. Export DB + zip `/public` and `/resources/views` before big changes.
2. Back up before migrations.
3. Store backups locally + in the cloud.
4. Weekly automated backup.

---

## Testing Checklist
✅ Works on tablet  
✅ Saves to DB without corruption  
✅ Matches brand styling  
✅ No console errors  
✅ Camera works everywhere  
✅ PDF export correct  

---

## Current Session Status - August 16, 2025
**LAST COMPLETED WORK:**

### ✅ Draft/Continue Functionality - COMPLETED
- **Problem**: Draft inspections were creating duplicate records instead of updating existing ones
- **Fixed**: Modified `InspectionController::saveVisualInspection()` to detect continuation vs new inspection
- **Fixed**: Updated visual inspection JavaScript to pass `inspection_id` when continuing
- **Result**: Dashboard "Continue" button now properly resumes drafts without duplicates

### ✅ Custom Notification System - COMPLETED
- **Created**: `/public/js/notifications.js` - Professional notification system
- **Added**: Toast notifications (success, error, warning, info, draft)
- **Added**: Modal confirmation dialogs replacing `confirm()`
- **Updated**: All major forms to use custom notifications instead of `alert()`
- **Styled**: Using inspection system color scheme (#28a745, #ffc107, #dc3545, #4f959b)

### ✅ Dashboard Improvements - COMPLETED
- **Fixed**: Shows real inspection data from database (last 6 draft/completed)
- **Added**: "Continue" buttons for draft inspections
- **Added**: "View Report" buttons for completed inspections
- **Updated**: Status badges using proper color scheme (green/orange/red)

### 🎯 NEXT PRIORITIES (when returning):
1. **Complete notification migration** - Still some `alert()` calls in engine-compartment, mechanical-report, etc.
2. **Test full inspection flow** - Ensure draft/continue works across all forms
3. **Optimize database queries** - Dashboard inspection loading
4. **Mobile/tablet responsiveness** - Test notification system on tablets

### 📁 KEY FILES MODIFIED:
- `app/Http/Controllers/InspectionController.php` (draft continuation logic)
- `public/js/notifications.js` (new notification system)
- `resources/views/layouts/app.blade.php` (notification script inclusion)
- `resources/views/dashboard.blade.php` (real data + continue links)
- `resources/views/body-panel-assessment.blade.php` (notifications + draft fix)
- `resources/views/visual-inspection.blade.php` (continuation logic + notifications)
- Multiple assessment forms (notification updates)

---

## Task Request Format
```
TASK: [Title]
FILE(S): [Paths]
REQUIREMENTS:
1. ...
2. ...
```

- never use tables in this project 
- work local only never update git without without explicit instructions are given