# Registered Nurse Performance Evaluation - PDF Save Feature

## Overview
The Registered Nurse Performance Evaluation form now has automatic PDF generation and saving capabilities.

## Features

### 1. Download PDF (Client-side)
- Click the **"💾 Download PDF"** button
- The form will be converted to PDF and downloaded to your browser's download folder
- Filename format: `RegisteredNurse_Evaluation_[Name]_[Date].pdf`
- Example: `RegisteredNurse_Evaluation_John_Doe_2025-10-09.pdf`

### 2. Save to Server
- Click the **"💾 Save to Server"** button
- The PDF will be saved directly to the server at: `pdf_files/registered_nurse_evaluations/`
- Same filename format as download
- You'll get a confirmation message with the file location

### 3. Print Form
- Click the **"🖨️ Print Form"** button
- Opens the browser's print dialog for traditional printing

## File Naming Convention

The filename is automatically generated based on:
- **Personnel Name**: From the "Reviewer" field (first occurrence)
- **Review Date**: From the "Date" field (first occurrence)

Format: `RegisteredNurse_Evaluation_[CleanName]_[YYYY-MM-DD].pdf`
- Special characters in names are replaced with underscores
- If fields are empty, defaults are used (Employee, Current Date)

## Server Storage Location

PDFs saved to server are stored in:
```
/pdf_files/registered_nurse_evaluations/
```

This folder is created automatically if it doesn't exist.

## Browser Configuration (Optional)

To automatically save downloads to a specific folder:

### Chrome/Edge:
1. Go to Settings > Downloads
2. Set "Download location" to your desired folder
3. Enable "Ask where to save each file before downloading" if you want to choose location each time

### Firefox:
1. Go to Settings > General > Files and Applications
2. Set "Save files to" to your desired folder

## Technical Details

- Uses `html2pdf.js` library for PDF generation
- Converts HTML/CSS to PDF maintaining formatting
- All form data (radio buttons, text fields) are captured in the PDF
- Buttons are hidden during PDF generation

## Requirements

- Internet connection (for html2pdf.js CDN)
- Modern web browser (Chrome, Firefox, Edge, Safari)
- For server save: PHP with file write permissions

## Troubleshooting

**PDF not generating?**
- Check internet connection (needs html2pdf.js from CDN)
- Try refreshing the page

**Server save failing?**
- Check folder permissions for `pdf_files/` directory
- Ensure PHP has write permissions

**Filename shows "Employee"?**
- Fill in the "Reviewer" field before generating PDF


