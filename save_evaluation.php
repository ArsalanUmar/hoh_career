<?php
/**
 * Unified evaluation form storage
 * Handles saving for all evaluation types: RN, LPN/LVN, Home Health Aide, and Office Staff
 */

header('Content-Type: application/json');

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if this is a POST request with required data
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($data['htmlContent']) || !isset($data['employeeName']) || !isset($data['formType'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request or missing required data'
    ]);
    exit;
}

$employeeName = $data['employeeName'];
$htmlContent = $data['htmlContent'];
$formType = $data['formType']; // 'RN', 'LPN', 'HHA', or 'OfficeStaff'

// Define directories based on form type
$directories = [
    'RN' => __DIR__ . '/performace_eva/registered_nurse_evaluations/',
    'LPN' => __DIR__ . '/performace_eva/lpn_lvn_evaluations/',
    'HHA' => __DIR__ . '/performace_eva/home_health_aide_evaluations/',
    'OfficeStaff' => __DIR__ . '/performace_eva/office_staff_evaluations/'
];

$filePrefixes = [
    'RN' => 'RN_Evaluation',
    'LPN' => 'LPN_Evaluation',
    'HHA' => 'HHA_Evaluation',
    'OfficeStaff' => 'OfficeStaff_Evaluation'
];

// Validate form type
if (!isset($directories[$formType])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid form type'
    ]);
    exit;
}

$htmlDirectory = $directories[$formType];
$filePrefix = $filePrefixes[$formType];

// Create directory if it doesn't exist
if (!file_exists($htmlDirectory)) {
    mkdir($htmlDirectory, 0755, true);
}

// Clean the name for filename
$cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $employeeName);

// Create filename with timestamp
$timestamp = date('Y-m-d_His');
$filename = "{$filePrefix}_{$cleanName}_{$timestamp}.html";
$filepath = $htmlDirectory . $filename;

// Modify the HTML to hide the save button
$modifiedHtml = str_replace(
    '<button class="save-btn" onclick="saveForm()">💾 Save Form</button>',
    '<!-- Save button hidden for saved form -->',
    $htmlContent
);

// Add a title indicating this is a saved form
$titleMap = [
    'RN' => 'RN Evaluation',
    'LPN' => 'LPN/LVN Evaluation',
    'HHA' => 'Home Health Aide Evaluation',
    'OfficeStaff' => 'Office Staff Evaluation'
];

$modifiedHtml = preg_replace(
    '/<title>.*?<\/title>/',
    '<title>' . $titleMap[$formType] . ' - ' . htmlspecialchars($employeeName) . ' - ' . date('Y-m-d') . '</title>',
    $modifiedHtml
);

// Save the HTML file
if (file_put_contents($filepath, $modifiedHtml)) {
    $relativePath = str_replace(__DIR__ . '/', '', $filepath);
    
    echo json_encode([
        'success' => true,
        'message' => 'Form saved successfully',
        'filename' => $filename,
        'filepath' => $relativePath,
        'formType' => $formType
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save file'
    ]);
}
?>

