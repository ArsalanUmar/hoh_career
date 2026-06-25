<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
    require_once('database.php');

  $path1 = 'fpdf/fpdf.php';
  $path2 = 'fpdi/autoload.php';
  require_once($path1);
  require_once($path2);
  // require_once('database.php');

  use \setasign\Fpdi\Fpdi;

    $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $con = $conn = $db->Conn();
    $html ="";
    if(empty($_POST['employee_name'])){
            header("Location: create_service_log.php?e=2");exit;

    }
    // echo "<pre>",print_r($_POST),"</pre>";die();
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
      $timestamp= date('YmdHis');
      $post = $_POST;
      extract($_POST);
   
      $emp_id = $post['employee_name'];
      
       // $date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
       

      $sql = "SELECT * FROM `tbl_job_applications` where id='".$emp_id."'";
      $result_logged = $conn->query($sql);
       $employee_details= $result_logged->fetch_assoc();
       // $employee_details = $employee_details_raw[0];

       // $staff_details = $staff_details_raw[0];
        $employee_signature = str_replace("../", "", $employee_details['signature_path']);
        $post['employee_name'] = $employee_name;
        $employee_name = ucwords(strtolower($employee_details['first_name']." ".$employee_details['last_name']));
        $post['employee_name_label'] = $employee_name;
        $post['position'] = ucwords(strtolower($employee_details['position']));
//         echo "<pre>",print_r($employee_details),"</pre>";
// echo "<pre>",print_r($staff_details),"</pre>";
// die();
       $name =       $file_name_pdf = $employee_name;
      $resume_name=$pdf_file_name = "";
        // echo $test_type;//die();
     // echo "<pre>",print_r($_POST),"</pre>";//die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        $service_file_path = "pdf_files/in-service log"." ".$employee_name.".pdf";
        extract($_POST);
        // echo $service_file_path;die();

          $sql = "SELECT * FROM `tbl_inservice_logs` where employee_id='".$emp_id."'";
         $result_logged = $conn->query($sql);
          $service_details= $result_logged->fetch_assoc();

          for ($i = 1; $i <= 12; $i++) {
              $key = 'duration_' . $i;
              if (!isset($post[$key]) || $post[$key] === '') {
                  $post[$key] = '1 hour';
              }
          }
          foreach (array('semi_duration_1', 'semi_duration_2') as $sdk) {
              if (!isset($post[$sdk]) || $post[$sdk] === '') {
                  $post[$sdk] = '1 hour';
              }
          }
          $dur_list = array();
          for ($i = 1; $i <= 12; $i++) {
              $dur_list[] = "duration_".$i."='".(isset($post['duration_'.$i]) ? $post['duration_'.$i] : '1 hour')."'";
          }
          $duration_set = implode(', ', $dur_list);
          $semi_emergency_1 = isset($post['semi_emergency_1']) ? $post['semi_emergency_1'] : '';
          $semi_emergency_2 = isset($post['semi_emergency_2']) ? $post['semi_emergency_2'] : '';
          $semi_duration_1 = isset($post['semi_duration_1']) ? $post['semi_duration_1'] : '1 hour';
          $semi_duration_2 = isset($post['semi_duration_2']) ? $post['semi_duration_2'] : '1 hour';
          if(!empty($service_details)){
                 $query = "UPDATE tbl_inservice_logs SET q_1='".$q_1."',q_2='".$q_2."',q_3='".$q_3."',q_4='".$q_4."',q_5='".$q_5."',q_6='".$q_6."',q_7='".$q_7."',q_8='".$q_8."',q_9='".$q_9."',q_10='".$q_10."',q_11='".$q_11."',q_12='".$q_12."',semi_emergency_1='".$semi_emergency_1."',semi_duration_1='".$semi_duration_1."',semi_emergency_2='".$semi_emergency_2."',semi_duration_2='".$semi_duration_2."', ".$duration_set." WHERE employee_id='".$emp_id."'";

          }else{
               $query = "INSERT INTO `tbl_inservice_logs` (`employee_id`,`q_1`,`q_2`,`q_3`,`q_4`,`q_5`,`q_6`,`q_7`,`q_8`,`q_9`,`q_10`,`q_11`,`q_12`,`pdf_path`,`duration_1`,`duration_2`,`duration_3`,`duration_4`,`duration_5`,`duration_6`,`duration_7`,`duration_8`,`duration_9`,`duration_10`,`duration_11`,`duration_12`,`semi_emergency_1`,`semi_duration_1`,`semi_emergency_2`,`semi_duration_2`) VALUES ('".$emp_id."','".$q_1."','".$q_2."','".$q_3."','".$q_4."','".$q_5."','".$q_6."','".$q_7."','".$q_8."','".$q_9."','".$q_10."','".$q_11."','".$q_12."','".$service_file_path."','".(isset($post['duration_1'])?$post['duration_1']:'1 hour')."','".(isset($post['duration_2'])?$post['duration_2']:'1 hour')."','".(isset($post['duration_3'])?$post['duration_3']:'1 hour')."','".(isset($post['duration_4'])?$post['duration_4']:'1 hour')."','".(isset($post['duration_5'])?$post['duration_5']:'1 hour')."','".(isset($post['duration_6'])?$post['duration_6']:'1 hour')."','".(isset($post['duration_7'])?$post['duration_7']:'1 hour')."','".(isset($post['duration_8'])?$post['duration_8']:'1 hour')."','".(isset($post['duration_9'])?$post['duration_9']:'1 hour')."','".(isset($post['duration_10'])?$post['duration_10']:'1 hour')."','".(isset($post['duration_11'])?$post['duration_11']:'1 hour')."','".(isset($post['duration_12'])?$post['duration_12']:'1 hour')."','".$semi_emergency_1."','".$semi_duration_1."','".$semi_emergency_2."','".$semi_duration_2."')";
          }

      
          // echo $query;die();
          $result = $con->query($query);
          $test_cert_id = $con->insert_id;

          
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;
// die();
          
          save_pdf($html,$employee_signature,$service_file_path,$post);
          // Auto-create per-topic training certificates for this employee (use label: extract($_POST) overwrites $employee_name with ID)
          save_training_certificates($post['employee_name_label'], $employee_signature, $post);

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // On success, go back to the main Manage Service Logs listing in the admin with success flag
          header("Location: manage/service-logs?s=1");exit;
        // }
    }

  function base64_to_jpeg($base64_string, $output_file) {
      // $ifp = fopen("signatures/".$output_file, "wb"); 

      $data = explode(',', $base64_string);

      // fwrite($ifp, base64_decode($data[1])); 
      // fclose($ifp); 
      $file_size = file_put_contents("signatures/".$output_file,base64_decode($data[1]));

      
      return $file_size; 
  }


  function send_mail($file_name,$email,$name,$date,$post=array(),$receiver=false,$pdf_consent_file){
      require_once "phpmailer/Exception.php";

      require_once "phpmailer/PHPMailer.php";
       require_once "phpmailer/SMTP.php";


      /* Email Detials */
      // $filename = "sender.txt";
      // $handle = fopen($filename, "r");
      $mail_to = "techyjust@gmail.com";//fread($handle, filesize($filename));
      // fclose($handle);
    
        if($receiver){
          $subject = "JOB APPLICATION FORM - copy";
        }else{
          $subject = "JOB APPLICATION - New  form has been received.";
        }
           
      // echo "<pre>",print_r($post),"</pre>";die();
     $m = $html = "";
      $name = $post['first_name']." ".$post['last_name'];
      unset($post['mySignature-dpi']);
      unset($post['mySignature']);
        unset($post['mySignature2-type']);
      unset($post['mySignature2-dpi']);
      unset($post['mySignature2']);

      if($receiver){
         $m .= "You have recently signed a job application. Attached is the copy of pdf form with application details <br>";
        
      }else{
         $m .= "You have received new job application form: <br>";
      }
   
      
// echo $html;die();
     
    /* Attachment File */
      // Attachment location
   //   $file_name = "<attachment file name>";
      $path = "signatures/";
       
      // Read the file content
      $file = $path.$file_name;

      $file_size = filesize($file);
      $handle = fopen($file, "r");
      $content = fread($handle, $file_size);
      fclose($handle);
      $content = chunk_split(base64_encode($content));

        $file_name_pdf = "pdf_files/".$name.' '.date('Y-m-d').'.pdf';
                $file_name_pdf_2 = "pdf_files/HBV_".$name.' '.date('Y-m-d').'.pdf';

      // $file_name_pdf = save_pdf($html,$file,$name,$post);
    /* Set the email header */
      // Generate a boundary
      $boundary = md5(uniqid(time()));    
      $eol = PHP_EOL;
     
      $message = "$m".$eol;
     $message .= "<br>Please keep the attached copies for your records and future reference.
 <br><br>

Regards,
Admin
 <br><br>";

    $message .="<p style='font-size:10px;'>This is an automatically generated email, please do not reply to it. </p>";
   

      //PHPMailer Object
        $mail = new PHPMailer(true);
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
     $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'hohcareers.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply@hohcareers.com';                     //SMTP username
    $mail->Password   = '9pw?TAk+z_ik';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


    //Recipients
    $mail->setFrom('noreply@hohcareers.com', 'Careers');
        //From email address and name
        // $mail->From = $mail_to;
        // $mail->FromName = "";

        //To address and name
         if(empty($email)){
           $mail->addAddress($mail_to, "Info");
        }else{
            $mail->addAddress($email, "Info");
             $mail->addAddress($post['email'], "Info");
        }

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->addAttachment($file_name_pdf);
                $mail->addAttachment($file_name_pdf_2);

        $mail->addAttachment($pdf_consent_file);

        $mail->send();
        return $file_name_pdf;
  

  }

  function translate($val){
    $return_val = $val;
    if($val=='t'){
         $return_val = 'true';
    }elseif($val=='f'){
         $return_val = 'false';
    }
    return $return_val;
  }

  function format_date_training($date_str) {
        if (empty($date_str)) return '';
        $ts = strtotime($date_str);
        // Numeric month/day/year, e.g. 02/22/2026
        return ($ts !== false) ? date('m/d/Y', $ts) : $date_str;
  }

  /**
   * Try to attach a background PDF page. Returns true if a template was loaded.
   */
  function service_log_try_attach_pdf_template(Fpdi $pdf) {
      $dir = __DIR__ . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;
      foreach (array($dir . 'service_log.pdf', $dir . 'service_log_compat.pdf') as $path) {
          if (!is_readable($path)) {
              continue;
          }
          try {
              $pdf->setSourceFile($path);
              $tplIdx = $pdf->importPage(1);
              $size = $pdf->getTemplateSize($tplIdx);
              $pdf->useTemplate($tplIdx, null, null, $size['width'], $size['height'], true);
              return true;
          } catch (\Throwable $e) {
              // try next candidate
          }
      }
      return false;
  }

  /**
   * Full in-service log on a blank page when FPDI cannot parse the template PDF.
   */
  function save_pdf_fallback_layout(Fpdi $pdf, $post) {
      $pdf->SetMargins(10, 10, 10);
      $pdf->SetAutoPageBreak(true, 12);
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFont('Arial', 'B', 14);
      $pdf->Cell(0, 8, 'Annual In-Service / Education Log', 0, 1, 'C');
      $pdf->Ln(2);
      $pdf->SetFont('Arial', '', 11);
      $pdf->Cell(0, 6, 'Employee: ' . (isset($post['employee_name_label']) ? $post['employee_name_label'] : ''), 0, 1, 'L');
      $pdf->Ln(3);

      $topics = array(
          'How to handle grievances/complaints',
          'Infection Control Training',
          'Cultural Diversity',
          'Communication Barriers',
          'Ethics Training',
          'Workplace (OSHA) and patient safety',
          'Patients\' Rights & Responsibilities',
          'Compliance Program',
          'Methods for coping with work related issues of grief, loss and change',
          'Pain and Symptom Management',
          'Infection Control/Hand Hygiene',
          'Patient Safety',
      );

      $wTopic = 118;
      $wDate = 72;
      $rowH = 7;
      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Cell($wTopic, $rowH, 'Topic', 1, 0, 'L');
      $pdf->Cell($wDate, $rowH, 'Date of training', 1, 1, 'C');
      $pdf->SetFont('Arial', '', 8);
      for ($i = 1; $i <= 12; $i++) {
          $date_str = format_date_training(isset($post['q_' . $i]) ? $post['q_' . $i] : '');
          $dur_str = isset($post['duration_' . $i]) && $post['duration_' . $i] !== '' ? $post['duration_' . $i] : '1 hour';
          $cell = $date_str !== '' ? $date_str . ' (' . $dur_str . ')' : '';
          $label = isset($topics[$i - 1]) ? $topics[$i - 1] : ('Topic ' . $i);
          $pdf->Cell($wTopic, $rowH, $label, 1, 0, 'L');
          $pdf->Cell($wDate, $rowH, $cell, 1, 1, 'C');
      }

      $pdf->Ln(2);
      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Cell(0, 6, 'Semi-annual emergency training', 0, 1, 'L');
      $pdf->SetFont('Arial', '', 8);
      $semi = array(
          array('Semi-Annual Emergency Training 1', 'semi_emergency_1', 'semi_duration_1'),
          array('Semi-Annual Emergency Training 2', 'semi_emergency_2', 'semi_duration_2'),
      );
      foreach ($semi as $sr) {
          $raw = isset($post[$sr[1]]) ? trim($post[$sr[1]]) : '';
          $dur = isset($post[$sr[2]]) && $post[$sr[2]] !== '' ? $post[$sr[2]] : '1 hour';
          $d = ($raw !== '' && $raw !== '0000-00-00') ? format_date_training($raw) : '';
          $pdf->Cell($wTopic, $rowH, $sr[0], 1, 0, 'L');
          $pdf->Cell($wDate, $rowH, $d !== '' ? $d . ' (' . $dur . ')' : '', 1, 1, 'C');
      }
  }

  function save_pdf($html,$employee_signature="",$service_file_path="",$post=array()){
  

        $pdf = new FPDI();
        $pdf->AddPage();
        $usedTemplate = service_log_try_attach_pdf_template($pdf);

        $pdf->SetTextColor(0,0,0);
        if ($usedTemplate) {
        // Overlay positions tuned for pdf/service_log.pdf (mm). Adjust if the template layout changes.
        $name_x = 56;
        $name_y = 43;
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY($name_x, $name_y);
        $pdf->MultiCell(150, 5, ucwords($post['employee_name_label']), 0, 'L');

        // Main table — right column only (topic labels are printed on the template).
        $y_positions = array(71, 83, 93, 103, 113, 123, 133, 143, 153, 163, 173, 183);
        $date_col_x = 94;
        $date_col_w = 96;
        $row_cell_h = 8;
        $pdf->SetFont('Arial', '', 11);
        for ($i = 1; $i <= 12; $i++) {
            $date_str = format_date_training(isset($post['q_'.$i]) ? $post['q_'.$i] : '');
            $dur_str = isset($post['duration_'.$i]) && $post['duration_'.$i] !== '' ? $post['duration_'.$i] : '1 hour';
            $cell_text = $date_str !== '' ? $date_str . ' (' . $dur_str . ')' : '';
            $pdf->SetXY($date_col_x, $y_positions[$i - 1]);
            $pdf->Cell($date_col_w, $row_cell_h, $cell_text, 0, 0, 'C');
        }
        $semi1_raw = isset($post['semi_emergency_1']) ? trim($post['semi_emergency_1']) : '';
        $semi2_raw = isset($post['semi_emergency_2']) ? trim($post['semi_emergency_2']) : '';
        $semi1_dur = isset($post['semi_duration_1']) && $post['semi_duration_1'] !== '' ? $post['semi_duration_1'] : '1 hour';
        $semi2_dur = isset($post['semi_duration_2']) && $post['semi_duration_2'] !== '' ? $post['semi_duration_2'] : '1 hour';
        $semi1_date = ($semi1_raw !== '' && $semi1_raw !== '0000-00-00') ? format_date_training($semi1_raw) : '';
        $semi2_date = ($semi2_raw !== '' && $semi2_raw !== '0000-00-00') ? format_date_training($semi2_raw) : '';
        $semi_right_x = 94;
        $semi_right_w = 96;
        $semi_row_y = array(219, 230);
        $semi_row_h = 8;
        $pdf->SetFont('Arial', '', 11);
        $semi_rows = array(
            array('date' => $semi1_date, 'dur' => $semi1_dur),
            array('date' => $semi2_date, 'dur' => $semi2_dur),
        );
        foreach ($semi_rows as $idx => $row) {
            $y = $semi_row_y[$idx];
            $cell_text = $row['date'] !== '' ? $row['date'] . ' (' . $row['dur'] . ')' : '';
            $pdf->SetXY($semi_right_x, $y);
            $pdf->Cell($semi_right_w, $semi_row_h, $cell_text, 0, 0, 'C');
        }
        } else {
            save_pdf_fallback_layout($pdf, $post);
        }
        $pdf->Output($service_file_path,'F');
  }

  /**
   * One certificate PDF per topic (same layout as the in-service save flow).
   * Optional $filename_topic_label: used for the saved filename when the on-page title should differ.
   */
  function write_one_training_certificate_pdf($employee_name, $topic_label, $duration, $date_label, $template_file, $pdf_files_dir, $filename_topic_label = null) {
      $pdf = new FPDI();
      $pdf->AddPage();
      $pdf->setSourceFile($template_file);
      $tplIdx = $pdf->importPage(1);
      $size   = $pdf->getTemplateSize($tplIdx);
      $pdf->useTemplate($tplIdx, null, null, $size['width'], $size['height'], true);

      $pdf->SetTextColor(0, 0, 0);

      $pdf->SetFont('Arial', 'BI', 15);
      $pdf->SetXY(20, 80);
      $pdf->Cell(0, 8, $employee_name, 0, 1, 'C');

      $pdf->SetFont('Arial', 'I', 16);
      $pdf->SetXY(20, 130);
      $pdf->Cell(0, 7, $topic_label, 0, 1, 'C');

      $pdf->SetFont('Arial', '', 14);
      $pdf->SetXY(20, 143);
      $pdf->Cell(0, 6, 'Hours Completed: ' . $duration, 0, 1, 'C');

      $pdf->SetFont('Arial', 'I', 13);
      $pdf->SetXY(65, 178);
      $pdf->Cell(60, 6, 'DATE: ' . $date_label, 0, 1, 'L');

      $pdf->SetFont('Arial', 'I', 13);
      $pdf->SetXY(160, 178);
      $pdf->Cell(60, 6, 'BY: '. "Liana Berzins", 0, 1, 'R');

      $signaturePath = __DIR__ . DIRECTORY_SEPARATOR . 'staff_signatures' . DIRECTORY_SEPARATOR . 'liana_berzins_signature.png';
      if (file_exists($signaturePath)) {
          $pdf->Image($signaturePath, 176, 160, 40, 0, 'PNG');
      }

      $safe_employee = preg_replace('/[^A-Za-z0-9_\-]/', '_', $employee_name);
      $file_topic    = ($filename_topic_label !== null && $filename_topic_label !== '') ? $filename_topic_label : $topic_label;
      $safe_topic    = preg_replace('/[^A-Za-z0-9_\-]/', '_', $file_topic);
      $out_path      = $pdf_files_dir . DIRECTORY_SEPARATOR . "training_certificate_" . $safe_employee . "_" . $safe_topic . ".pdf";

      $pdf->Output($out_path, 'F');
  }

  /**
   * Generate individual training certificates using pdf/training_certificate.pdf
   * for each completed topic.
   *
   * 1st dotted line: employee name
   * 2nd dotted line: topic name
   * 3rd dotted line: total hours completed for that topic
   * Left bottom    : date of completion
   * Right bottom   : staff signature image
   */
  function save_training_certificates($employee_name, $employee_signature, $post = array()) {
      $base_dir = __DIR__;
      $template_file = $base_dir . DIRECTORY_SEPARATOR . "pdf" . DIRECTORY_SEPARATOR . "training_certificate.pdf";
      $pdf_files_dir = $base_dir . DIRECTORY_SEPARATOR . "pdf_files";

      if (!file_exists($template_file)) {
          return;
      }
      if (!is_dir($pdf_files_dir)) {
          @mkdir($pdf_files_dir, 0755, true);
      }

      // Map topic index to topic label (same mapping used in the list page)
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

      for ($i = 1; $i <= 12; $i++) {
          $date_raw = isset($post['q_' . $i]) ? trim($post['q_' . $i]) : '';
          if ($date_raw === '' || $date_raw === '0000-00-00') {
              continue; // skip topics without a completion date
          }

          $topic_label = isset($topic_labels[$i]) ? $topic_labels[$i] : ('Topic ' . $i);
          $duration    = isset($post['duration_' . $i]) && $post['duration_' . $i] !== '' ? $post['duration_' . $i] : '1 hour';
          $date_label  = format_date_training($date_raw);

          write_one_training_certificate_pdf($employee_name, $topic_label, $duration, $date_label, $template_file, $pdf_files_dir);
      }

      $semi_display = 'Emergency Training';
      $semi_cert_defs = array(
          array('semi_emergency_1', 'semi_duration_1', 'Semi-Annual Emergency Training 1'),
          array('semi_emergency_2', 'semi_duration_2', 'Semi-Annual Emergency Training 2'),
      );
      foreach ($semi_cert_defs as $def) {
          $date_raw = isset($post[$def[0]]) ? trim($post[$def[0]]) : '';
          if ($date_raw === '' || $date_raw === '0000-00-00') {
              continue;
          }
          $duration   = isset($post[$def[1]]) && $post[$def[1]] !== '' ? $post[$def[1]] : '1 hour';
          $date_label = format_date_training($date_raw);
          write_one_training_certificate_pdf($employee_name, $semi_display, $duration, $date_label, $template_file, $pdf_files_dir, $def[2]);
      }
  }

?>