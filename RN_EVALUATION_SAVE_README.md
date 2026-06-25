# Registered Nurse Evaluation Form - Save Feature

## Overview
This system allows you to fill out, save, view, and print Registered Nurse performance evaluation forms.

## Features

### 1. Fill Out Evaluations
- Open `registered_nurse.php` in your browser
- All performance ratings are pre-selected at 4 (Superior Performance) by default
- Fill out all required information:
  - Review date
  - Reviewer name
  - Review type (Annual, 90 Day, or Other)
  - Performance ratings for each category
  - Targeted goals and comments
  - Signatures and dates

### 2. Save Evaluations
- Click the **"💾 Save Form"** button (green button on the right side)
- Enter the employee name when prompted
- The form will be saved as an HTML file in the system directory
- You'll receive a confirmation message with the filename

**Saved Location:**
- Files are saved to: `performace_eva/registered_nurse_evaluations/`
- Filename format: `RN_Evaluation_EmployeeName_YYYY-MM-DD_HHMMSS.html`

### 3. View Saved Evaluations
- Click the **"📁 View Saved"** button (orange button on the right side)
- Or directly access: `view_saved_rn_evaluations.php`
- You'll see a list of all saved evaluations with:
  - Employee name
  - Date created
  - File size
  - Action buttons

### 4. Manage Saved Evaluations
From the saved evaluations list, you can:
- **👁️ View**: Open the saved form in a new tab
- **⬇️ Download**: Download the HTML file to your computer
- **🗑️ Delete**: Remove the evaluation from the system (requires confirmation)
- **Search**: Use the search box to filter evaluations by employee name

### 5. Print Evaluations
- Open any evaluation (saved or new)
- Click the **"🖨️ Print Form"** button
- Or press `Ctrl+P` (Windows/Linux) or `Cmd+P` (Mac)
- The form will print cleanly with all buttons hidden

## Files Created

1. **registered_nurse.php** (modified)
   - Added Save Form button
   - Added View Saved button
   - Added JavaScript to collect and save form data

2. **save_rn_evaluation_to_server.php**
   - Backend script that saves the filled form as HTML
   - Creates the directory structure if it doesn't exist
   - Generates unique filenames with timestamps

3. **view_saved_rn_evaluations.php**
   - Dashboard to view all saved evaluations
   - Beautiful, modern interface with search functionality
   - Statistics showing total number of evaluations

4. **get_saved_rn_evaluations.php**
   - Backend script to retrieve list of saved evaluations
   - Returns data in JSON format

5. **delete_saved_rn_evaluation.php**
   - Backend script to delete saved evaluations
   - Includes security checks to prevent unauthorized deletions

## Directory Structure

```
new_hoh/
├── registered_nurse.php
├── save_rn_evaluation_to_server.php
├── view_saved_rn_evaluations.php
├── get_saved_rn_evaluations.php
├── delete_saved_rn_evaluation.php
└── performace_eva/
    └── registered_nurse_evaluations/
        ├── RN_Evaluation_John_Doe_2025-10-10_143022.html
        ├── RN_Evaluation_Jane_Smith_2025-10-10_151545.html
        └── ...
```

## Usage Instructions

### To Create a New Evaluation:
1. Navigate to `registered_nurse.php`
2. Fill out the form
3. Click "💾 Save Form"
4. Enter employee name
5. Form is saved automatically

### To View Saved Evaluations:
1. Click "📁 View Saved" from the form, OR
2. Navigate directly to `view_saved_rn_evaluations.php`
3. Click "👁️ View" to open any evaluation

### To Print an Evaluation:
1. Open the evaluation (saved or new)
2. Click "🖨️ Print Form" or press `Ctrl+P`/`Cmd+P`
3. The form will print without buttons

## Technical Details

- **Storage Format**: HTML files with all form data preserved
- **Filename Format**: `RN_Evaluation_{EmployeeName}_{Timestamp}.html`
- **Save Location**: Server directory `performace_eva/registered_nurse_evaluations/`
- **Permissions**: Directory created with 0755 permissions
- **Search**: Client-side search for instant filtering
- **Security**: Filenames are sanitized to prevent directory traversal

## Benefits

✅ **No Database Required**: All data stored as HTML files  
✅ **Easy to View**: Saved forms open directly in browser  
✅ **Portable**: HTML files can be downloaded and shared  
✅ **Print-Ready**: Saved forms maintain print formatting  
✅ **Search & Filter**: Quickly find evaluations by employee name  
✅ **Timestamped**: Each save creates a unique file with timestamp  
✅ **Backup-Friendly**: Simple file-based storage for easy backups  

## Troubleshooting

**Issue**: "Failed to save HTML file" error  
**Solution**: Check that the web server has write permissions to the directory

**Issue**: Can't see saved evaluations  
**Solution**: Verify that files exist in `performace_eva/registered_nurse_evaluations/`

**Issue**: Save button doesn't work  
**Solution**: Check browser console for JavaScript errors

## Future Enhancements

Possible future features:
- Export to PDF directly from the save
- Email saved evaluations
- Bulk export/download
- Advanced filtering (by date, reviewer, etc.)
- Edit existing saved evaluations
- Version history tracking

---

Last Updated: October 10, 2025


