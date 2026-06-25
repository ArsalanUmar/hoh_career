<?php
/**
 * Get list of saved RN evaluations
 */

header('Content-Type: application/json');

// Define the directory where evaluations are saved
$directory = __DIR__ . '/performace_eva/registered_nurse_evaluations/';

// Check if directory exists
if (!file_exists($directory)) {
    echo json_encode([
        'success' => false,
        'message' => 'No evaluations directory found',
        'evaluations' => []
    ]);
    exit;
}

// Get all HTML files in the directory
$files = glob($directory . '*.html');

// Sort by modification time (newest first)
usort($files, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

$evaluations = [];

foreach ($files as $file) {
    $filename = basename($file);
    
    // Extract employee name from filename (format: RN_Evaluation_EmployeeName_YYYY-MM-DD_HHMMSS.html)
    $namePart = preg_replace('/^RN_Evaluation_/', '', $filename);
    $namePart = preg_replace('/_\d{4}-\d{2}-\d{2}_\d{6}\.html$/', '', $namePart);
    $employeeName = str_replace('_', ' ', $namePart);
    
    // Get file info
    $fileSize = filesize($file);
    $fileSizeFormatted = formatBytes($fileSize);
    $dateCreated = filemtime($file);
    
    $evaluations[] = [
        'filename' => $filename,
        'employeeName' => $employeeName,
        'dateCreated' => date('Y-m-d H:i:s', $dateCreated),
        'fileSize' => $fileSizeFormatted,
        'filepath' => 'performace_eva/registered_nurse_evaluations/' . $filename
    ];
}

echo json_encode([
    'success' => true,
    'evaluations' => $evaluations,
    'count' => count($evaluations)
]);

/**
 * Format bytes to human readable format
 */
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>


