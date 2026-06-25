<?php
/**
 * Stream the job application PDF for an employee (no browser caching).
 */
require_once __DIR__ . '/database.php';

$ref = isset($_GET['ref']) ? trim((string) $_GET['ref']) : '';
if ($ref === '') {
    http_response_code(400);
    exit('Missing application reference.');
}

$id = base64_decode($ref, true);
if ($id === false || !ctype_digit((string) $id)) {
    http_response_code(400);
    exit('Invalid application reference.');
}

$db = new Database();
$conn = $db->Conn();
$id = (int) $id;
$result = $conn->query("SELECT pdf_file_path, first_name, last_name FROM tbl_job_applications WHERE id = {$id} LIMIT 1");
$row = $result ? $result->fetch_assoc() : null;

if (empty($row) || empty($row['pdf_file_path'])) {
    http_response_code(404);
    exit('Job application PDF not found.');
}

$relative = str_replace('\\', '/', ltrim($row['pdf_file_path'], '/'));
$absolute = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

if (!is_readable($absolute)) {
    http_response_code(404);
    exit('Job application PDF file is missing on the server.');
}

$download_name = preg_replace('/[^A-Za-z0-9_\-\. ]+/', '_', trim($row['first_name'] . ' ' . $row['last_name'])) . '.pdf';

header('Content-Type: application/pdf');
header('Content-Length: ' . filesize($absolute));
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Disposition: inline; filename="' . $download_name . '"');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($absolute)) . ' GMT');

readfile($absolute);
exit;
