<?php
/**
 * Delete a saved evaluation file
 */

header('Content-Type: application/json');

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($data['filename'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request or missing filename'
    ]);
    exit;
}

$filename = basename($data['filename']); // Security: prevent directory traversal

// Determine which directory based on filename prefix
$directories = [
    'RN_Evaluation' => __DIR__ . '/performace_eva/registered_nurse_evaluations/',
    'LPN_Evaluation' => __DIR__ . '/performace_eva/lpn_lvn_evaluations/',
    'HHA_Evaluation' => __DIR__ . '/performace_eva/home_health_aide_evaluations/',
    'OfficeStaff_Evaluation' => __DIR__ . '/performace_eva/office_staff_evaluations/'
];

$filepath = null;
foreach ($directories as $prefix => $directory) {
    if (strpos($filename, $prefix) === 0) {
        $filepath = $directory . $filename;
        break;
    }
}

if (!$filepath || !file_exists($filepath)) {
    echo json_encode([
        'success' => false,
        'message' => 'File not found'
    ]);
    exit;
}

// Delete the file
if (unlink($filepath)) {
    echo json_encode([
        'success' => true,
        'message' => 'Evaluation deleted successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete file'
    ]);
}
?>


