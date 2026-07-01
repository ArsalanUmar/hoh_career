<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
    require_once('database.php');

  $path1 = 'fpdf/fpdf.php';
  $path2 = 'fpdi/autoload.php';
  require_once($path1);
  require_once($path2);
  require_once __DIR__ . '/hand_hygiene_pdf_marks.php';
  // require_once('database.php');

  use \setasign\Fpdi\Fpdi;

    $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $con = $conn = $db->Conn();
    $html ="";
    // echo "<pre>",print_r($_POST),"</pre>";
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
      $timestamp= date('YmdHis');
      $post = $_POST;
      $waived_test  = $hepab_test = $harass_test = $handhygiene_test = $emergency_test = $covid_test =  $bloodpatho_test = $gluco_test= false;
      $test_type = "";
      $emp_id = $_POST['ref'];
      $redirect_page = 'manage/'.$_POST['cur_page']."?s=1";
      $staff_id = NULL;
      $test_type = $_POST['test_type'];
       $date_filled = $_POST['date_filled'];
       $date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
          $sql = "SELECT * FROM `tbl_test_certificates` where id='".$emp_id."'";
         // echo $sql;die();
         
      $result_logged = $conn->query($sql);
       $employee_test_exists= $result_logged->fetch_assoc();
       $emp_id = $employee_test_exists['employee_id'];
//echo "<pre>",print_r($employee_test_exists),"</pre>";die();
      $staff_id_columns = array(
        'waive' => 'waived_staff_id',
        'hepab' => 'hepa_staff_id',
        'harass' => 'harass_staff_id',
        'handhygiene' => 'hygiene_staff_id',
        'glucometer' => 'glucometer_staff_id',
        'emergency' => 'emergency_staff_id',
        'bloodpatho' => 'bloodpatho_staff_id',
        'covid' => 'covid_staff_id',
      );

      $staff_id = null;
      if (!empty($post['regenerate_staff_id'])) {
        $staff_id = trim($post['regenerate_staff_id']);
      } elseif (isset($staff_id_columns[$test_type], $employee_test_exists[$staff_id_columns[$test_type]])) {
        $staff_id = trim((string) $employee_test_exists[$staff_id_columns[$test_type]]);
      }

      if ($staff_id === '' || $staff_id === null) {
        header('Location: ' . $redirect_page . (strpos($redirect_page, '?') !== false ? '&' : '?') . 'e=staff');
        exit;
      }

      $sql = "SELECT * FROM `tbl_job_applications` where id='".$emp_id."'";
      $result_logged = $conn->query($sql);
       $employee_details= $result_logged->fetch_assoc();
       // $employee_details = $employee_details_raw[0];

      $sql = "SELECT * FROM `tbl_staff` WHERE staff_id='".$staff_id."' AND status='active' LIMIT 1";
      $result_logged = $conn->query($sql);
       $staff_details= $result_logged ? $result_logged->fetch_assoc() : null;

      if (empty($staff_details)) {
        header('Location: ' . $redirect_page . (strpos($redirect_page, '?') !== false ? '&' : '?') . 'e=staff');
        exit;
      }

        $employee_signature = ($employee_details && isset($employee_details['signature_path'])) ? str_replace("../", "", $employee_details['signature_path']) : '';
        $staff_signature = isset($staff_details['signature_path']) ? str_replace("../", "", $staff_details['signature_path']) : '';
        $employee_name = ($employee_details && isset($employee_details['first_name'], $employee_details['last_name'])) ? ucwords(strtolower($employee_details['first_name']." ".$employee_details['last_name'])) : '';
        $staff_name = ucwords(strtolower($staff_details['staff_name']));

        // Persist staff choice on the certificate row (fixes old records saved with wrong staff_id).
        if (isset($staff_id_columns[$test_type])) {
          $staff_col = $staff_id_columns[$test_type];
          $cert_row_id = (int) $employee_test_exists['id'];
          $conn->query("UPDATE `tbl_test_certificates` SET `".$staff_col."`='".$conn->real_escape_string($staff_id)."' WHERE id='".$cert_row_id."' LIMIT 1");
        }

        // Preserve resolved staff for PDF — extract() must not overwrite these.
        $cert_staff_name = $staff_name;
        $cert_staff_signature = $staff_signature;
        $cert_employee_name = $employee_name;
        $cert_employee_signature = $employee_signature;

        $post['employee_name'] = $employee_name;
        $post['staff_name'] = $staff_name;

        // echo "<pre>",print_r($employee_test_exists),"</pre>";
//echo "<pre>",print_r($staff_details),"</pre>";
 //die();
       $name =       $file_name_pdf = $employee_name;
      $resume_name=$pdf_file_name = "";
        // echo $test_type;//die();
     // echo "<pre>",print_r($_POST),"</pre>";die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        extract($_POST, EXTR_SKIP);
      
        //answer_keys 

        $waived_keys = ["true","true","b","true","c","a","a","b","d","d"];
        $hepab_keys = ["false","true","false","false","true","false","false","false","true","false","false"];
        $harass_keys = ["false","false","false","false","false","false","true","false","true","true","true","true","true","true"];
        $handhygiene_keys = ["d","c","c","e","false","c","c"];
        $emergency_keys =  ["a","b","b","false","true","true"];
        $covid_keys =  ["false","true","true","false","true","true","true"];
        $blood_patho_keys  = ["false","false","true","false","a","b","true","b","c","true","false","b","false","false","true","false","true","false","false","true"];
        $gluco_keys = ["true","true","true","true","true","true","true","true","true","true","true","c","d","e","f","b","a"];

        $test_pass  = true;
        $test_score = 0;
        $pdf_test_file_path = $certificate_file_path ="";
        $employee_id = "";
        //echo $test_type;die();
        // echo "<pre>",print_r($waived_keys),"</pre>";//die();
        if(!empty($employee_test_exists)){
          if($test_type == 'waive'){
              $employee_id = $waived_employee_name ?? $employee_name;
            // echo "ad";die();
              $test_score =  $employee_test_exists['waived_test_score'];
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_waive.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_waive_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `waived_test_file_path` = '".$pdf_test_file_path."', `waived_certificate_file_path` = '".$certificate_file_path."', `waived_num_hour` = '".$num_hours."',`waived_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
        }elseif($test_type == 'hepab'){
            $employee_id = $hepab_employee_name ?? $employee_name;
            // echo "ad";die();
           $test_score =  $employee_test_exists['hepa_test_score'];
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_hepab.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_hepab_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `hepa_test_file_path` = '".$pdf_test_file_path."', `hepa_num_hour` = '".$num_hours."', `hepa_certificate_file_path` = '".$certificate_file_path."',`hepa_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'harass'){
            $employee_id = $harass_employee_name ?? $employee_name;
            // echo "ad";die();
             $test_score =  $employee_test_exists['harass_test_score'];
            $harass_score = 0;
           
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_harass.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_harass_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `harass_test_file_path` = '".$pdf_test_file_path."', `harass_num_hour` = '".$num_hours."', `harass_certificate_file_path` = '".$certificate_file_path."',`harass_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'handhygiene'){
            $employee_id = $handhygiene_employee_name ?? $employee_name;
            // echo "ad";die();
               $test_score =  $employee_test_exists['hygiene_test_score'];
             // echo $waive_score;die();
             $test_score = $handhygiene_score;
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_handhygiene.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_handhygiene_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `hygiene_test_file_path` = '".$pdf_test_file_path."', `hh_num_hour` = '".$num_hours."', `hygiene_certificate_file_path` = '".$certificate_file_path."',`hygiene_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'emergency'){
            $employee_id = $emergency_employee_name ?? $employee_name;
            // echo "ad";die();
            $emergency_score = 0;
            $test_score =  $employee_test_exists['emergency_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_emergency.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_emergency_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `emergency_test_file_path` = '".$pdf_test_file_path."', `emerg_num_hour` = '".$num_hours."', `emergency_certificate_file_path` = '".$certificate_file_path."',`emergency_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'covid'){
            $employee_id = $covid_employee_name ?? $employee_name;
            // echo "ad";die();
            $covid_score = 0;
            $test_score =  $employee_test_exists['covid_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_covid.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_covid_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `covid_test_file_path` = '".$pdf_test_file_path."', `covid_num_hour` = '".$num_hours."', `covid_certificate_file_path` = '".$certificate_file_path."',`covid_test_date`='".$date_filled."'WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'bloodpatho'){
            $employee_id = $bloodpatho_employee_name ?? $employee_name;
            // echo "ad";die();
            $bloodpatho_score = 0;
            $test_score =  $employee_test_exists['bloodpatho_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_bloodpatho.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_bloodpatho_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `bloodpatho_test_file_path` = '".$pdf_test_file_path."', `patho_num_hour` = '".$num_hours."', `bloodpatho_certificate_file_path` = '".$certificate_file_path."',`bloodpatho_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'glucometer'){
              //  echo "ad";die();
            $employee_id = $glucometer_employee_name ?? $employee_name;
            
            $bloodpatho_score = 0;
            $test_score =  $employee_test_exists['glucometer_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_glucometer.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_glucometer_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `glucometer_test_file_path` = '".$pdf_test_file_path."', `gluco_num_hour` = '".$num_hours."', `glucometer_certificate_file_path` = '".$certificate_file_path."',`glucometer_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }

        }
          
          //echo $query;die();
          $result = $con->query($query);
          $test_cert_id = $con->insert_id;

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;

               $sql = "SELECT tbl_test_certificates.*,tbl_job_applications.first_name, tbl_job_applications.last_name FROM `tbl_test_certificates` LEFT JOIN tbl_job_applications on tbl_job_applications.id = tbl_test_certificates.employee_id where employee_id='".$emp_id."'";
          $result_logged = $conn->query($sql);
          $employee_test_record= $result_logged->fetch_assoc();
          $employee_test_record['staff_name'] = $cert_staff_name;
          $employee_test_record['first_name'] = $employee_test_record['first_name'] ?? '';
          $employee_test_record['last_name'] = $employee_test_record['last_name'] ?? '';
          // echo "<pre>",print_r($employee_test_record),"</pre>";die();
         // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);
          save_pdf($html,$test_type,$test_score,$test_pass,$cert_employee_signature,$cert_staff_signature,$pdf_test_file_path,$certificate_file_path,$employee_test_record);

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // if($send_mail){
            header("Location: ".$redirect_page);exit;
            
          // }
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

  function save_pdf($html,$test_type=NULL,$test_score=NULL,$test_pass=true,$employee_signature="",$staff_signature="",$pdf_test_file_path="",$certificate_file_path="",$post=array()){
    if($test_type == 'waive'){
        $date_label=date('m/d/Y',strtotime($post['waived_test_date']));

        $pdf_file = "pdf/test_waived.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(49 ,43);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
         $pdf->SetFont('Arial','',10);  
        // $pdf->SetXY(34 ,121);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        // $pdf->Image($employee_signature,25,95,100,40,"PNG");
           // $pdf->Image($signature2,25,140,100,40,"PNG");
           // $pdf->Image($signature3,25,175,100,40,"PNG");
         $pdf->SetXY(132,43);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(178,43);  
         $pdf->SetFont('Arial','',12);  
         if($test_pass){
          $pdf->SetTextColor(0,255,0);

         }else{
          $pdf->SetTextColor(255,0,0);
         }


        $pdf->Write(0, $post['waived_test_score']."/10");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',9);  
        test_pdf_write_answer_circled($pdf, 12, 58, translate($post['waived_q_1']));

        test_pdf_write_answer_circled($pdf, 12, 103, translate($post['waived_q_2']));
       
        test_pdf_write_answer_circled($pdf, 15, 129, translate($post['waived_q_3']));

         test_pdf_write_answer_circled($pdf, 12, 169.5, translate($post['waived_q_4']));

         test_pdf_write_answer_circled($pdf, 15, 206, translate($post['waived_q_5']));

         $pdf->AddPage();
         $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',9);  
          test_pdf_write_answer_circled($pdf, 15, 24, translate($post['waived_q_6']));

           test_pdf_write_answer_circled($pdf, 15, 64, translate($post['waived_q_7']));


           test_pdf_write_answer_circled($pdf, 15, 100, translate($post['waived_q_8']));
           test_pdf_write_answer_circled($pdf, 15, 129, translate($post['waived_q_9']));

        test_pdf_write_answer_circled($pdf, 15, 171, translate($post['waived_q_10']));

           $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(3);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  

          $pdf->SetXY(62,42);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));

          $pdf->SetXY(151,42);  
        $pdf->Write(0, ucwords($post['position']));

            $pdf->SetXY(62,50);  
        $pdf->Write(0,'Sample Specimen');

          $pdf->SetXY(145,50);  
        $pdf->Write(0,$date_label);

            $pdf->SetXY(58,163);  
        $pdf->Write(0,$post['staff_name']);

        $pdf->SetXY(130,163);  
        $pdf->Write(0,$date_label);
                // $pdf->Image($signature2,25,140,100,40,"PNG");
                // $pdf->Image($signature3,25,160,100,40,"PNG");
    // echo $pdf_consent_file;die();
        $pdf->Output($pdf_test_file_path,'F');//die();
        if($test_pass){

          $pdf_file = "pdf/training_certificate.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
       
          $pdf = new FPDI();  
          // add a page
          $pdf->AddPage();  
          // set the sourcefile  
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $tplIdx = $pdf->importPage(1);  
          $size = $pdf->getTemplateSize($tplIdx);
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->SetFont('Arial','',16);  
          $pdf->SetXY(70 ,83);  
           $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

        
           $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Waived Testing',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['waived_num_hour'],0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
                $pdf->Output($certificate_file_path,'F');
          // die();
        }

    }

       if($test_type == 'hepab'){
        $date_label=date('m/d/Y',strtotime($post['hepa_test_date']));

        $pdf_file = "pdf/test_hepab.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',10);  
        // $pdf->SetXY(49 ,43);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        //  $pdf->SetFont('Arial','',10);  
        // $pdf->SetXY(34 ,121);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        // $pdf->Image($employee_signature,25,95,100,40,"PNG");
           // $pdf->Image($signature2,25,140,100,40,"PNG");
           // $pdf->Image($signature3,25,175,100,40,"PNG");
         // $pdf->SetXY(132,43);  
        // $pdf->Write(0, $date_label);
         $pdf->SetFont('Arial','',12);  
         $pdf->SetXY(178,36);  
         if($test_pass){
          $pdf->SetTextColor(0,255,0);

         }else{
          $pdf->SetTextColor(255,0,0);
         }


        $pdf->Write(0, $post['hepa_test_score']."/11");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',9);  
        test_pdf_write_answer_circled($pdf, 22, 57, translate($post['hepa_q_1']));
        test_pdf_write_answer_circled($pdf, 22, 92, translate($post['hepa_q_2']));
        test_pdf_write_answer_circled($pdf, 22, 126, translate($post['hepa_q_3']));
        test_pdf_write_answer_circled($pdf, 22, 155, translate($post['hepa_q_4']));
        test_pdf_write_answer_circled($pdf, 22, 185, translate($post['hepa_q_5']));
        test_pdf_write_answer_circled($pdf, 22, 215, translate($post['hepa_q_6']));

        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        test_pdf_write_answer_circled($pdf, 22, 35, translate($post['hepa_q_7']));
        test_pdf_write_answer_circled($pdf, 22, 65, translate($post['hepa_q_8']));
        test_pdf_write_answer_circled($pdf, 22, 95, translate($post['hepa_q_9']));
        test_pdf_write_answer_circled($pdf, 22, 127, translate($post['hepa_q_10']));
        test_pdf_write_answer_circled($pdf, 22, 154, translate($post['hepa_q_11']));
        $pdf->SetXY(62 ,216);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
    
         $pdf->SetXY(152,216);  
        $pdf->Write(0, $date_label);

        $pdf->Output($pdf_test_file_path,'F');//die();
        if($test_pass){
          $pdf_file = "pdf/training_certificate.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
        // $pdf->Image($pic, 10,30,0,0,'png');
      // echo $signature1;die();
          $pdf = new FPDI();  
          // add a page
          $pdf->AddPage();  
          // set the sourcefile  
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $tplIdx = $pdf->importPage(1);  
          $size = $pdf->getTemplateSize($tplIdx);
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->SetFont('Arial','',16);  
          $pdf->SetXY(70 ,83);  
           $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

        
             $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Hepatitis B',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['hepa_num_hour'],0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
           $pdf->Output($certificate_file_path,'F');//die();
        }
        // die();

    }

      if($test_type == 'harass'){
        $date_label=date('m/d/Y',strtotime($post['harass_test_date']));

        $pdf_file = "pdf/test_harass.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(54 ,41);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        
         $pdf->SetXY(134,41);  
          $pdf->Write(0, $date_label);
         $pdf->SetFont('Arial','',12);  
         $pdf->SetXY(183,41);  
         if($test_pass){
          $pdf->SetTextColor(0,255,0);

         }else{
          $pdf->SetTextColor(255,0,0);
         }


        $pdf->Write(0, $post['harass_test_score']."/14");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',9);  
        test_pdf_write_answer_circled($pdf, 18, 69, translate($post['harass_q_1']));
        test_pdf_write_answer_circled($pdf, 18, 92, translate($post['harass_q_2']));
        test_pdf_write_answer_circled($pdf, 18, 121, translate($post['harass_q_3']));
        test_pdf_write_answer_circled($pdf, 18, 144, translate($post['harass_q_4']));
        test_pdf_write_answer_circled($pdf, 18, 174, translate($post['harass_q_5']));
        test_pdf_write_answer_circled($pdf, 18, 209, translate($post['harass_q_6']));
        test_pdf_write_answer_circled($pdf, 18, 239, translate($post['harass_q_7']));

        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
        test_pdf_write_answer_circled($pdf, 18, 21, translate($post['harass_q_8']));
        test_pdf_write_answer_circled($pdf, 18, 43, translate($post['harass_q_9']));
        test_pdf_write_answer_circled($pdf, 18, 66, translate($post['harass_q_10']));
        test_pdf_write_answer_circled($pdf, 18, 99, translate($post['harass_q_11']));
        test_pdf_write_answer_circled($pdf, 18, 130, translate($post['harass_q_12']));
        test_pdf_write_answer_circled($pdf, 18, 160, translate($post['harass_q_13']));
        test_pdf_write_answer_circled($pdf, 18, 195, translate($post['harass_q_14']));

        $pdf->Output($pdf_test_file_path,'F');//die();
        if($test_pass){
          $pdf_file = "pdf/training_certificate.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
        $pdf = new FPDI();  
          // add a page
          // add a page
          $pdf->AddPage();  
          // set the sourcefile  
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $tplIdx = $pdf->importPage(1);  
          $size = $pdf->getTemplateSize($tplIdx);
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->SetFont('Arial','',16);  
          $pdf->SetXY(70 ,83);  
           $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

           $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Harassment',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['harass_num_hour'],0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
           $pdf->Output($certificate_file_path,'F');//die();
        }
        // die();

    }
 
       if($test_type == 'handhygiene'){
        $date_label=date('m/d/Y',strtotime($post['hygiene_test_date']));

        $pdf_file = "pdf/test_handhygiene.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('zapfdingbats', '', 13);
          if($test_pass){

            $pdf->SetXY(162 ,24);  
            $pdf->Write(0, "4");
          }else{

            $pdf->SetXY(175 ,24);  
            $pdf->Write(0, "4");

          }



        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(63 ,40);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
         $pdf->SetFont('Arial','',10);  
        // $pdf->SetXY(34 ,121);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        // $pdf->Image($employee_signature,25,95,100,40,"PNG");
           // $pdf->Image($signature2,25,140,100,40,"PNG");
           // $pdf->Image($signature3,25,175,100,40,"PNG");
         $pdf->SetXY(149,40);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(162,20);  
         $pdf->SetFont('Arial','',12);  
         if($test_pass){
          $pdf->SetTextColor(0,255,0);

         }else{
          $pdf->SetTextColor(255,0,0);
         }


        $pdf->Write(0, $post['hygiene_test_score']."/7");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',12);
        hh_pdf_write_answer_circled($pdf, 29, 77, translate($post['hygiene_q_1']));
        hh_pdf_write_answer_circled($pdf, 29, 158, translate($post['hygiene_q_2']));
        hh_pdf_write_answer_circled($pdf, 29, 212, translate($post['hygiene_q_3']));

         $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  

         $pdf->SetFont('Arial','',12);
        hh_pdf_write_answer_circled($pdf, 29, 29, translate($post['hygiene_q_4']));
        hh_pdf_write_answer_circled($pdf, 20, 83, translate($post['hygiene_q_5']));
        hh_pdf_write_answer_circled($pdf, 29, 115, translate($post['hygiene_q_6']));
        hh_pdf_write_answer_circled($pdf, 29, 182, translate($post['hygiene_q_7']));
                // $pdf->Image($signature2,25,140,100,40,"PNG");
                // $pdf->Image($signature3,25,160,100,40,"PNG");
    // echo $pdf_consent_file;die();
        $pdf->Output($pdf_test_file_path,'F');//die();
      if($test_pass){
        $pdf_file = "pdf/training_certificate.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
      // $pdf->Image($pic, 10,30,0,0,'png');
    // echo $signature1;die();
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        $size = $pdf->getTemplateSize($tplIdx);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

       
           $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Hand Hygiene',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['hh_num_hour'],0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

      if($test_type == 'emergency'){
        $date_label=date('m/d/Y',strtotime($post['emergency_test_date']));

        $pdf_file = "pdf/test_emergency.pdf";
        $passing_score = 6;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
          //   $pdf->SetFont('zapfdingbats', '', 13);
          // if($test_pass){

          //   $pdf->SetXY(162 ,24);  
          //   $pdf->Write(0, "4");
          // }else{

          //   $pdf->SetXY(175 ,24);  
          //   $pdf->Write(0, "4");

          // }



        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(45 ,228);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
         $pdf->SetFont('Arial','',10);  
        // $pdf->SetXY(34 ,121);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        // $pdf->Image($employee_signature,25,95,100,40,"PNG");
           // $pdf->Image($signature2,25,140,100,40,"PNG");
           // $pdf->Image($signature3,25,175,100,40,"PNG");
         $pdf->SetXY(45,237);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(162,26);  
         $pdf->SetFont('Arial','',14);  
         if($test_pass){
          $pdf->SetTextColor(0,255,0);

         }else{
          $pdf->SetTextColor(255,0,0);
         }
         // $pdf->SetFont('Arial','',10);  


        $pdf->Write(0, $post['emergency_test_score']."/6");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',12);  
        test_pdf_write_answer_circled($pdf, 20, 42, translate($post['emergency_q_1']), 12);
        test_pdf_write_answer_circled($pdf, 20, 81, translate($post['emergency_q_2']), 12);
        test_pdf_write_answer_circled($pdf, 20, 121, translate($post['emergency_q_3']), 12);
        test_pdf_write_answer_circled($pdf, 16, 165, translate($post['emergency_q_4']), 12);
        test_pdf_write_answer_circled($pdf, 16, 184, translate($post['emergency_q_5']), 12);
        test_pdf_write_answer_circled($pdf, 16, 203, translate($post['emergency_q_6']), 12);

                // $pdf->Image($signature2,25,140,100,40,"PNG");
                // $pdf->Image($signature3,25,160,100,40,"PNG");
    // echo $pdf_consent_file;die();
        $pdf->Output($pdf_test_file_path,'F');//die();
        if($test_pass){
        $pdf_file = "pdf/training_certificate.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
      // $pdf->Image($pic, 10,30,0,0,'png');
    // echo $signature1;die();
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        $size = $pdf->getTemplateSize($tplIdx);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

   $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Emergency Training',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['emerg_num_hour'],0,'C');
         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
        // die();

    }
 
   if($test_type == 'covid'){
        $date_label=date('m/d/Y',strtotime($post['covid_test_date']));
        $test_score = $post['covid_test_score'];
        $percentage = number_format(($test_score/7)*100);

        // echo $percentage;die(); 
        $pdf_file = "pdf/test_covid.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
         



        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(58 ,48);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
         $pdf->SetFont('Arial','',8);  
        // $pdf->SetXY(34 ,121);  
        // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
        // $pdf->Image($employee_signature,25,95,100,40,"PNG");
           // $pdf->Image($signature2,25,140,100,40,"PNG");
           // $pdf->Image($signature3,25,175,100,40,"PNG");
         $pdf->SetXY(160,48);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(162,20);  
         
        $pdf->SetFont('Arial','',10);  
        test_pdf_write_answer_circled($pdf, 18, 67, translate($post['covid_q_1']), 10);
        test_pdf_write_answer_circled($pdf, 18, 85, translate($post['covid_q_2']), 10);
        test_pdf_write_answer_circled($pdf, 18, 105, translate($post['covid_q_3']), 10);
        test_pdf_write_answer_circled($pdf, 18, 127, translate($post['covid_q_4']), 10);
        test_pdf_write_answer_circled($pdf, 18, 143, translate($post['covid_q_5']), 10);
        test_pdf_write_answer_circled($pdf, 18, 159, translate($post['covid_q_6']), 10);
        test_pdf_write_answer_circled($pdf, 18, 173, translate($post['covid_q_7']), 10);

       $pdf->SetXY(175,191);  
        $pdf->Write(0, translate($percentage)." %");

        $pdf->SetFont('zapfdingbats', '', 13);
        

          if($percentage == 100){
             $pdf->SetXY(27 ,200);   
            $pdf->Write(0, "4");
           
          }elseif($percentage >= 80){

            $pdf->SetXY(175 ,205);  
            $pdf->Write(0, "4");

          }elseif($percentage <80){

            $pdf->SetXY(175 ,214);  
            $pdf->Write(0, "4");

          }
    
        $pdf->Output($pdf_test_file_path,'F');//die();
      if($test_pass){
        $pdf_file = "pdf/training_certificate.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
      // $pdf->Image($pic, 10,30,0,0,'png');
    // echo $signature1;die();
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        $size = $pdf->getTemplateSize($tplIdx);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

    
          $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Covid-19',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['covid_num_hour'],0,'C');
         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         
         if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

       if($test_type == 'glucometer'){
        $date_label=date('m/d/Y',strtotime($post['glucometer_test_date']));
        $test_score = $post['glucometer_test_score'];
        // $percentage = number_format(($test_score/7)*100);

        // echo $percentage;die(); 
        $pdf_file = "pdf/test_gluco.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
         



        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(38 ,38);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
      
         $pdf->SetXY(145,38);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(162,20);  

           $pdf->SetXY(95,61);  
        $pdf->Write(0, $test_score);


        $pdf->SetFont('zapfdingbats', '', 13);
             

          if($test_pass){
             $pdf->SetXY(105 ,61);   
            $pdf->Write(0, "4");
           
          }else{
            $pdf->SetXY(117 ,61);   
            $pdf->Write(0, "4");
          }
          //   $pdf->SetXY(175 ,205);  
          //   $pdf->Write(0, "4");

          // }elseif($percentage <80){

          //   $pdf->SetXY(175 ,214);  
          //   $pdf->Write(0, "4");

          // }
         
        $pdf->SetFont('Arial','',10);  
        test_pdf_write_answer_circled($pdf, 23, 71, translate($post['glucometer_q_1']), 10);
        test_pdf_write_answer_circled($pdf, 23, 91, translate($post['glucometer_q_2']), 10);
        test_pdf_write_answer_circled($pdf, 23, 108, translate($post['glucometer_q_3']), 10);
        test_pdf_write_answer_circled($pdf, 23, 129, translate($post['glucometer_q_4']), 10);
        test_pdf_write_answer_circled($pdf, 23, 145, translate($post['glucometer_q_5']), 10);
        test_pdf_write_answer_circled($pdf, 23, 161, translate($post['glucometer_q_6']), 10);
        test_pdf_write_answer_circled($pdf, 23, 178, translate($post['glucometer_q_7']), 10);
        test_pdf_write_answer_circled($pdf, 23, 199, translate($post['glucometer_q_8']), 10);
        test_pdf_write_answer_circled($pdf, 23, 219, translate($post['glucometer_q_9']), 10);
        test_pdf_write_answer_circled($pdf, 23, 236, translate($post['glucometer_q_10']), 10);

         $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
          $pdf->useTemplate($tplIdx, 10, 10, 200); 

          $pdf->SetFont('Arial','',10);  
        test_pdf_write_answer_circled($pdf, 23, 39, translate($post['glucometer_q_11']), 10);
        test_pdf_write_answer_circled($pdf, 25, 59, translate($post['glucometer_q_12']), 10);
        test_pdf_write_answer_circled($pdf, 25, 83, translate($post['glucometer_q_13']), 10);
        test_pdf_write_answer_circled($pdf, 25, 115, translate($post['glucometer_q_14']), 10);
        test_pdf_write_answer_circled($pdf, 23, 145, translate($post['glucometer_q_15']), 10);
        test_pdf_write_answer_circled($pdf, 25, 176, translate($post['glucometer_q_16']), 10);
        test_pdf_write_answer_circled($pdf, 25, 208, translate($post['glucometer_q_17']), 10);
    
    
        $pdf->Output($pdf_test_file_path,'F');//die();
      if($test_pass){
        $pdf_file = "pdf/training_certificate.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
      // $pdf->Image($pic, 10,30,0,0,'png');
    // echo $signature1;die();
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        $size = $pdf->getTemplateSize($tplIdx);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

       
          $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Glucometer POCT',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['gluco_num_hour'],0,'C');
         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

     if($test_type == 'bloodpatho'){
        $date_label=date('m/d/Y',strtotime($post['bloodpatho_test_date']));
        $test_score = $post['bloodpatho_test_score'];
        // $percentage = number_format(($test_score/7)*100);

        // echo $percentage;die(); 
        $pdf_file = "pdf/test_bloodpatho.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
    
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
         



        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(28 ,215);  
        $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
      
         $pdf->SetXY(110,215);  
        $pdf->Write(0, $date_label);
         $pdf->SetXY(162,20);  

           $pdf->SetXY(95,61);  
        // $pdf->Write(0, $test_score);


          //   $pdf->SetXY(175 ,205);  
          //   $pdf->Write(0, "4");

          // }elseif($percentage <80){

          //   $pdf->SetXY(175 ,214);  
          //   $pdf->Write(0, "4");

          // }
         
        $pdf->SetFont('Arial','',9);  
        test_pdf_write_answer_circled($pdf, 15, 38, translate($post['bloodpatho_q_1']));
        test_pdf_write_answer_circled($pdf, 15, 45, translate($post['bloodpatho_q_2']));
        test_pdf_write_answer_circled($pdf, 15, 52, translate($post['bloodpatho_q_3']));
        test_pdf_write_answer_circled($pdf, 15, 59.5, translate($post['bloodpatho_q_4']));

        if($post['bloodpatho_q_5'] == 'a'){
          test_pdf_write_text_circled($pdf, 15, 71, 'HIV');
        }elseif($post['bloodpatho_q_5'] == 'b'){
          test_pdf_write_text_circled($pdf, 15, 71, 'HBV');
        }elseif($post['bloodpatho_q_5'] == 'c'){
          test_pdf_write_text_circled($pdf, 15, 71, 'HCV');
        }
        if($post['bloodpatho_q_6'] == 'a'){
          test_pdf_write_text_circled($pdf, 3, 79.5, 'Green or Blue', 7, 0);
        }elseif($post['bloodpatho_q_6'] == 'b'){
          test_pdf_write_text_circled($pdf, 3, 79.5, 'Red or Red-Orange', 7, 0);
        }elseif($post['bloodpatho_q_6'] == 'c'){
          test_pdf_write_text_circled($pdf, 3, 79.5, 'Clear or Black', 7, 0);
        }

        test_pdf_write_answer_circled($pdf, 15, 86, translate($post['bloodpatho_q_7']));
        if($post['bloodpatho_q_8'] == 'a'){
          test_pdf_write_text_circled($pdf, 10, 98, 'Monthly');
        }elseif($post['bloodpatho_q_8'] == 'b'){
          test_pdf_write_text_circled($pdf, 10, 98, 'Annually');
        }elseif($post['bloodpatho_q_8'] == 'c'){
          test_pdf_write_text_circled($pdf, 10, 98, 'One each decade');
        }

        if($post['bloodpatho_q_9'] == 'a'){
          test_pdf_write_text_circled($pdf, 15, 105, 'Heart');
        }elseif($post['bloodpatho_q_9'] == 'b'){
          test_pdf_write_text_circled($pdf, 15, 105, 'Lungs');
        }elseif($post['bloodpatho_q_9'] == 'c'){
          test_pdf_write_text_circled($pdf, 15, 105, 'Liver');
        }elseif($post['bloodpatho_q_9'] == 'd'){
          test_pdf_write_text_circled($pdf, 15, 105, 'Pancreas');
        }
        test_pdf_write_answer_circled($pdf, 15, 113, translate($post['bloodpatho_q_10']));
        test_pdf_write_answer_circled($pdf, 15, 120, translate($post['bloodpatho_q_11']));
        if($post['bloodpatho_q_12'] == 'a'){
          test_pdf_write_text_circled($pdf, 15, 128, '100%');
        }elseif($post['bloodpatho_q_12'] == 'b'){
          test_pdf_write_text_circled($pdf, 15, 128, '95%');
        }elseif($post['bloodpatho_q_12'] == 'c'){
          test_pdf_write_text_circled($pdf, 15, 128, '90%');
        }elseif($post['bloodpatho_q_12'] == 'd'){
          test_pdf_write_text_circled($pdf, 15, 128, '70%');
        }

        test_pdf_write_answer_circled($pdf, 15, 139, translate($post['bloodpatho_q_13']));
        test_pdf_write_answer_circled($pdf, 15, 147, translate($post['bloodpatho_q_14']));
        test_pdf_write_answer_circled($pdf, 15, 154, translate($post['bloodpatho_q_15']));
        test_pdf_write_answer_circled($pdf, 15, 161, translate($post['bloodpatho_q_16']));
        test_pdf_write_answer_circled($pdf, 15, 169, translate($post['bloodpatho_q_17']));
        test_pdf_write_answer_circled($pdf, 15, 176, translate($post['bloodpatho_q_18']));
        test_pdf_write_answer_circled($pdf, 15, 184, translate($post['bloodpatho_q_19']));
        test_pdf_write_answer_circled($pdf, 15, 191.5, translate($post['bloodpatho_q_20']));

        // $pdf->Output($pdf_test_file_path,'I');die();

      
    
        $pdf->Output($pdf_test_file_path,'F');//die();
      if($test_pass){
        $pdf_file = "pdf/training_certificate.pdf";
        $passing_score = 7;
        $pdf = new FPDF();
        $pdf->AddPage();
      // $pdf->Image($pic, 10,30,0,0,'png');
    // echo $signature1;die();
        $pdf = new FPDI();  
        // add a page
        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(1);  
        $size = $pdf->getTemplateSize($tplIdx);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, null, null, $size['width'],$size['height'],true);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['first_name']." ".$post['last_name']),0,'C');

      
             $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,'Blood Borne',0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['patho_num_hour'],0,'C');
         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         if (!empty($staff_signature)) { $pdf->Image($staff_signature,190,164,60,20,"PNG"); }

        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }
    return $pdf_test_file_path;

  }

  
?>