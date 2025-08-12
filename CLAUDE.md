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

## Task Request Format
```
TASK: [Title]
FILE(S): [Paths]
REQUIREMENTS:
1. ...
2. ...
```
