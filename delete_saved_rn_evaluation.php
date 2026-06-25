<?php
/**
 * Delete a saved RN evaluation
 */

header('Content-Type: application/json');

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if filename is provided
if (!isset($data['filename'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No filename provided'
    ]);
    exit;
}

$filename = $data['filename'];

// Sanitize filename to prevent directory traversal
$filename = basename($filename);

// Define the directory
$directory = __DIR__ . '/performace_eva/registered_nurse_evaluations/';
$filepath = $directory . $filename;

// Check if file exists
if (!file_exists($filepath)) {
    echo json_encode([
        'success' => false,
        'message' => 'File not found'
    ]);
    exit;
}

// Attempt to delete the file
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


