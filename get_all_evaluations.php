<?php
/**
 * Get list of all saved evaluations (RN, LPN/LVN, Home Health Aide, and Office Staff)
 */

header('Content-Type: application/json');

// Define directories for all evaluation types
$directories = [
    'RN' => __DIR__ . '/performace_eva/registered_nurse_evaluations/',
    'LPN' => __DIR__ . '/performace_eva/lpn_lvn_evaluations/',
    'HHA' => __DIR__ . '/performace_eva/home_health_aide_evaluations/',
    'OfficeStaff' => __DIR__ . '/performace_eva/office_staff_evaluations/'
];

$evaluations = [];

// Loop through each directory and get files
foreach ($directories as $type => $directory) {
    if (!file_exists($directory)) {
        continue;
    }
    
    $files = glob($directory . '*.html');
    
    foreach ($files as $file) {
        $filename = basename($file);
        
        // Extract employee name from filename
        $namePart = preg_replace('/^(RN|LPN|HHA|OfficeStaff)_Evaluation_/', '', $filename);
        $namePart = preg_replace('/_\d{4}-\d{2}-\d{2}_\d{6}\.html$/', '', $namePart);
        $employeeName = str_replace('_', ' ', $namePart);
        
        // Get file info
        $fileSize = filesize($file);
        $fileSizeFormatted = formatBytes($fileSize);
        $dateCreated = filemtime($file);
        
        $relativePath = str_replace(__DIR__ . '/', '', $file);
        
        $evaluations[] = [
            'filename' => $filename,
            'employeeName' => $employeeName,
            'formType' => $type,
            'formTypeName' => getFormTypeName($type),
            'dateCreated' => date('Y-m-d H:i:s', $dateCreated),
            'fileSize' => $fileSizeFormatted,
            'filepath' => $relativePath,
            'timestamp' => $dateCreated
        ];
    }
}

// Sort by modification time (newest first)
usort($evaluations, function($a, $b) {
    return $b['timestamp'] - $a['timestamp'];
});

// Remove timestamp from output
foreach ($evaluations as &$eval) {
    unset($eval['timestamp']);
}

echo json_encode([
    'success' => true,
    'evaluations' => $evaluations,
    'count' => count($evaluations)
]);

/**
 * Get form type display name
 */
function getFormTypeName($type) {
    $names = [
        'RN' => 'Registered Nurse',
        'LPN' => 'LPN/LVN',
        'HHA' => 'Home Health Aide',
        'OfficeStaff' => 'Office Staff'
    ];
    return isset($names[$type]) ? $names[$type] : $type;
}

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

