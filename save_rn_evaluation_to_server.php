<?php
/**
 * Server-side HTML Form storage
 * This file receives the completed form data and saves it as an HTML file
 */

header('Content-Type: application/json');

// Define the target directories
$htmlDirectory = __DIR__ . '/performace_eva/registered_nurse_evaluations/';
$pdfDirectory = __DIR__ . '/pdf_files/registered_nurse_evaluations/';

// Create directories if they don't exist
if (!file_exists($htmlDirectory)) {
    mkdir($htmlDirectory, 0755, true);
}
if (!file_exists($pdfDirectory)) {
    mkdir($pdfDirectory, 0755, true);
}

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get JSON data from request body
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Handle HTML form saving
    if (isset($data['htmlContent']) && isset($data['employeeName'])) {
        
        $employeeName = $data['employeeName'];
        $htmlContent = $data['htmlContent'];
        $formData = isset($data['formData']) ? $data['formData'] : [];
        
        // Clean the name for filename
        $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $employeeName);
        
        // Create filename with timestamp
        $timestamp = date('Y-m-d_His');
        $filename = "RN_Evaluation_{$cleanName}_{$timestamp}.html";
        $filepath = $htmlDirectory . $filename;
        
        // Modify the HTML to hide the save button and make form read-only
        $modifiedHtml = str_replace(
            '<button class="save-btn" onclick="saveForm()">💾 Save Form</button>',
            '<!-- Save button hidden for saved form -->',
            $htmlContent
        );
        
        // Add a title indicating this is a saved form
        $modifiedHtml = str_replace(
            '<title>Performance Evaluation Form</title>',
            '<title>RN Evaluation - ' . htmlspecialchars($employeeName) . ' - ' . date('Y-m-d') . '</title>',
            $modifiedHtml
        );
        
        // Save the HTML file
        if (file_put_contents($filepath, $modifiedHtml)) {
            
            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Form saved successfully',
                'filename' => $filename,
                'filepath' => 'performace_eva/registered_nurse_evaluations/' . $filename,
                'viewUrl' => 'performace_eva/registered_nurse_evaluations/' . $filename
            ]);
            
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save HTML file'
            ]);
        }
        
    }
    // Handle PDF upload (keeping backwards compatibility)
    elseif (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        
        $personnelName = isset($_POST['personnel_name']) ? $_POST['personnel_name'] : 'Employee';
        $reviewDate = isset($_POST['review_date']) ? $_POST['review_date'] : date('Y-m-d');
        
        // Clean the name for filename
        $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $personnelName);
        
        // Create filename
        $filename = "RegisteredNurse_Evaluation_{$cleanName}_{$reviewDate}.pdf";
        $filepath = $pdfDirectory . $filename;
        
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $filepath)) {
            
            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'PDF saved successfully',
                'filename' => $filename,
                'filepath' => 'pdf_files/registered_nurse_evaluations/' . $filename
            ]);
            
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save PDF file'
            ]);
        }
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No form data or file uploaded'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>

