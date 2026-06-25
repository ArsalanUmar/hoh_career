<?php
require_once('database.php');

$path1 = 'fpdf/fpdf.php';
$path2 = 'fpdi/autoload.php';
require_once($path1);
require_once($path2);

use \setasign\Fpdi\Fpdi;

// Simple helper - same format we use for training dates elsewhere
function format_date_training_local($date_str) {
    if (empty($date_str)) return '';
    $ts = strtotime($date_str);
    return ($ts !== false) ? date('M j Y', $ts) : $date_str;
}

function get_valid_topic_indexes($topic_index, $topics_raw) {
    $indexes = array();
    if (!empty($topics_raw)) {
        $parts = explode(',', $topics_raw);
        foreach ($parts as $part) {
            $idx = (int) trim($part);
            if ($idx >= 1 && $idx <= 14) {
                $indexes[] = $idx;
            }
        }
    } elseif ($topic_index >= 1 && $topic_index <= 14) {
        $indexes[] = (int) $topic_index;
    }
    $indexes = array_values(array_unique($indexes));
    sort($indexes);
    return $indexes;
}

function resolve_topic_certificate_data($log, $topic_index) {
    $semi_cert_map = array(
        13 => array('label' => 'Semi-Annual Emergency Training 1', 'date_key' => 'semi_emergency_1', 'dur_key' => 'semi_duration_1'),
        14 => array('label' => 'Semi-Annual Emergency Training 2', 'date_key' => 'semi_emergency_2', 'dur_key' => 'semi_duration_2'),
    );
    $topic_labels = array(
        1 => 'Grievances/Complaints',
        2 => 'Infection Control Training',
        3 => 'Cultural Diversity',
        4 => 'Communication Barriers',
        5 => 'Ethics Training',
        6 => 'Workplace (OSHA) & Patient Safety',
        7 => 'Patients\' Rights & Responsibilities',
        8 => 'Compliance Program',
        9 => 'Grief, Loss and Change',
        10 => 'Pain and Symptom Management',
        11 => 'Infection Control/Hand Hygiene',
        12 => 'Patient Safety'
    );

    if ($topic_index >= 1 && $topic_index <= 12) {
        $q_key   = 'q_'.$topic_index;
        $dur_key = 'duration_'.$topic_index;
        $date_raw = isset($log[$q_key]) ? trim($log[$q_key]) : '';
        if ($date_raw === '' || $date_raw === '0000-00-00') {
            return null;
        }
        return array(
            'topic_label' => isset($topic_labels[$topic_index]) ? $topic_labels[$topic_index] : ('Topic '.$topic_index),
            'topic_filename_label' => null,
            'duration' => isset($log[$dur_key]) && $log[$dur_key] !== '' ? $log[$dur_key] : '1 hour',
            'date_raw' => $date_raw
        );
    }

    if (isset($semi_cert_map[$topic_index])) {
        $sm = $semi_cert_map[$topic_index];
        $date_raw = isset($log[$sm['date_key']]) ? trim($log[$sm['date_key']]) : '';
        if ($date_raw === '' || $date_raw === '0000-00-00') {
            return null;
        }
        return array(
            'topic_label' => 'Emergency Training',
            'topic_filename_label' => $sm['label'],
            'duration' => isset($log[$sm['dur_key']]) && $log[$sm['dur_key']] !== '' ? $log[$sm['dur_key']] : '1 hour',
            'date_raw' => $date_raw
        );
    }

    return null;
}

function add_training_certificate_page($pdf, $template_file, $employee_name, $topic_label, $date_label) {
    $pdf->AddPage();
    $pdf->setSourceFile($template_file);
    $tplIdx = $pdf->importPage(1);
    $size   = $pdf->getTemplateSize($tplIdx);
    $pdf->useTemplate($tplIdx, 0, 0, $size['width'], $size['height'], false);

    $pdf->SetTextColor(0, 0, 0);

    // 1st dotted line: employee name (center, fancy font)
    $pdf->SetFont('Arial', 'BI', 20);
    $pdf->SetXY(20, 180);
    $pdf->Cell(0, 8, $employee_name, 0, 1, 'C');

    // 2nd dotted line: topic name (center, slightly smaller)
    $pdf->SetFont('Arial', 'I', 16);
    $pdf->SetXY(20, 88);
    $pdf->Cell(0, 7, $topic_label, 0, 1, 'C');

    // 3rd dotted line: label only for hours completed (center)
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(20, 100);
    $pdf->Cell(0, 6, 'Hours completed:', 0, 1, 'C');

    // Left bottom: date of completion (with DATE label)
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->SetXY(30, 130);
    $pdf->Cell(60, 6, 'DATE: '.$date_label, 0, 1, 'L');

    // Right bottom: static name + signature (Liana Berzins)
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->SetXY(140, 138);
    $pdf->Cell(60, 6, "By: Liana Berzins", 0, 1, 'R');

    // Draw signature image above the name if available
    $signaturePath = __DIR__ . DIRECTORY_SEPARATOR . 'staff_signatures' . DIRECTORY_SEPARATOR . 'liana_berzins_signature.png';
    if (file_exists($signaturePath)) {
        $pdf->Image($signaturePath, 163, 120, 40, 0, 'PNG');
    }
}

function get_training_certificate_filename($employee_name, $topic_filename_label, $topic_label) {
    $safe_employee = preg_replace('/[^A-Za-z0-9_\-]/', '_', $employee_name);
    $file_topic = ($topic_filename_label !== null && $topic_filename_label !== '') ? $topic_filename_label : $topic_label;
    $safe_topic = preg_replace('/[^A-Za-z0-9_\-]/', '_', $file_topic);
    return "training_certificate_{$safe_employee}_{$safe_topic}.pdf";
}

$employee_id = isset($_GET['employee_id']) ? (int) $_GET['employee_id'] : 0;
$topic_index = isset($_GET['topic']) ? (int) $_GET['topic'] : 0;
$topics_raw = isset($_GET['topics']) ? trim((string) $_GET['topics']) : '';
$bulk_mode = isset($_GET['bulk']) && $_GET['bulk'] == '1';
$topic_indexes = get_valid_topic_indexes($topic_index, $topics_raw);

if ($employee_id <= 0 || empty($topic_indexes)) {
    die('Invalid employee or topic.');
}

$db = new Database;
$con = $db->Conn();

// Get employee details (name + signature)
$sql_emp = "SELECT * FROM `tbl_job_applications` WHERE id = '".$employee_id."' LIMIT 1";
$res_emp = $con->query($sql_emp);
if (!$res_emp || $res_emp->num_rows === 0) {
    die('Employee not found.');
}
$employee = $res_emp->fetch_assoc();
$employee_name = ucwords(strtolower($employee['first_name'].' '.$employee['last_name']));
$employee_signature = str_replace('../', '', $employee['signature_path']);

// Get in-service log row
$sql_log = "SELECT * FROM `tbl_inservice_logs` WHERE employee_id = '".$employee_id."' LIMIT 1";
$res_log = $con->query($sql_log);
if (!$res_log || $res_log->num_rows === 0) {
    die('No in-service log found for this employee.');
}
$log = $res_log->fetch_assoc();
$template_file = __DIR__ . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . 'training_certificate.pdf';
if (!file_exists($template_file)) {
    die('training_certificate.pdf template not found.');
}

$pdf_files_dir = __DIR__ . DIRECTORY_SEPARATOR . "pdf_files";
if (!is_dir($pdf_files_dir)) {
    @mkdir($pdf_files_dir, 0755, true);
}

$certificates = array();
foreach ($topic_indexes as $idx) {
    $cert_data = resolve_topic_certificate_data($log, $idx);
    if (!empty($cert_data)) {
        $cert_data['topic_index'] = $idx;
        $certificates[] = $cert_data;
    }
}

if (empty($certificates)) {
    die('No completed training topics found for bulk print.');
}

if (!$bulk_mode && count($certificates) === 1) {
    $single = $certificates[0];
    $filename = get_training_certificate_filename($employee_name, $single['topic_filename_label'], $single['topic_label']);
    $filepath = $pdf_files_dir . DIRECTORY_SEPARATOR . $filename;

    // If the certificate file already exists (auto-created on save), just stream it
    if (file_exists($filepath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="'.$filename.'"');
        readfile($filepath);
        exit;
    }

    $pdf = new FPDI();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(0, 0, 0);
    add_training_certificate_page($pdf, $template_file, $employee_name, $single['topic_label'], format_date_training_local($single['date_raw']));

    // Save to disk and stream
    $pdf->Output($filepath, 'F');
    $pdf->Output('I', $filename);
    exit;
}

$safe_employee = preg_replace('/[^A-Za-z0-9_\-]/', '_', $employee_name);
$filename = "training_certificates_{$safe_employee}_bulk.pdf";
$pdf = new FPDI();
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(0, 0, 0);
foreach ($certificates as $cert) {
    $single_filename = get_training_certificate_filename($employee_name, $cert['topic_filename_label'], $cert['topic_label']);
    $single_filepath = $pdf_files_dir . DIRECTORY_SEPARATOR . $single_filename;

    // Preserve exact certificate layout by reusing existing per-topic PDF when available.
    if (file_exists($single_filepath)) {
        $pdf->setSourceFile($single_filepath);
        $tpl = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($tpl);
        $pdf->AddPage($size['orientation'], array($size['width'], $size['height']));
        $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], false);
        continue;
    }

    // Fallback only when a stored per-topic certificate does not yet exist.
    add_training_certificate_page($pdf, $template_file, $employee_name, $cert['topic_label'], format_date_training_local($cert['date_raw']));
}
$pdf->Output('I', $filename);

?>

