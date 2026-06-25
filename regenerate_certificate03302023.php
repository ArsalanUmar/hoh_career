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
      if($test_type=='waive'){
        $staff_id = $employee_test_exists['waived_staff_id'];
      }elseif($test_type=='hepab'){
           $staff_id = $employee_test_exists['hepa_staff_id'];
      }elseif($test_type=='harass'){
           $staff_id = $employee_test_exists['harass_staff_id'];
      }elseif($test_type=='handhygiene'){
           $staff_id = $employee_test_exists['hygiene_staff_id'];
      }elseif($test_type=='glucometer'){
           $staff_id = $employee_test_exists['glucometer_staff_id'];
      }elseif($test_type=='emergency'){
           $staff_id = $employee_test_exists['emergency_staff_id'];
      }elseif($test_type=='bloodpatho'){
           $staff_id = $employee_test_exists['bloodpatho_staff_id'];
      }elseif($test_type=='covid'){
           $staff_id = $employee_test_exists['covid_staff_id'];
      }

      $sql = "SELECT * FROM `tbl_job_applications` where id='".$emp_id."'";
      $result_logged = $conn->query($sql);
       $employee_details= $result_logged->fetch_assoc();
       // $employee_details = $employee_details_raw[0];

      $sql = "SELECT * FROM `tbl_staff` where staff_id='".$staff_id."'";
      $result_logged = $conn->query($sql);
       $staff_details= $result_logged->fetch_assoc();
       // $staff_details = $staff_details_raw[0];
        $employee_signature = str_replace("../", "", $employee_details['signature_path']);
        $staff_signature = str_replace("../", "", $staff_details['signature_path']);
        $employee_name = ucwords(strtolower($employee_details['first_name']." ".$employee_details['last_name']));
           $staff_name = ucwords(strtolower($staff_details['staff_name']));
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
        extract($_POST);
      
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
              $employee_id = $waived_employee_name;
            // echo "ad";die();
              $test_score =  $employee_test_exists['waived_test_score'];
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_waive.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_waive_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `waived_test_file_path` = '".$pdf_test_file_path."', `waived_certificate_file_path` = '".$certificate_file_path."',`waived_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
        }elseif($test_type == 'hepab'){
            $employee_id = $hepab_employee_name;
            // echo "ad";die();
           $test_score =  $employee_test_exists['hepa_test_score'];
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_hepab.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_hepab_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `hepa_test_file_path` = '".$pdf_test_file_path."', `hepa_certificate_file_path` = '".$certificate_file_path."',`hepa_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'harass'){
            $employee_id = $harass_employee_name;
            // echo "ad";die();
             $test_score =  $employee_test_exists['harass_test_score'];
            $harass_score = 0;
           
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_harass.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_harass_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `harass_test_file_path` = '".$pdf_test_file_path."', `harass_certificate_file_path` = '".$certificate_file_path."',`harass_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'handhygiene'){
            $employee_id = $handhygiene_employee_name;
            // echo "ad";die();
               $test_score =  $employee_test_exists['hygiene_test_score'];
             // echo $waive_score;die();
             $test_score = $handhygiene_score;
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_handhygiene.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_handhygiene_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `hygiene_test_file_path` = '".$pdf_test_file_path."', `hygiene_certificate_file_path` = '".$certificate_file_path."',`hygiene_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'emergency'){
            $employee_id = $emergency_employee_name;
            // echo "ad";die();
            $emergency_score = 0;
            $test_score =  $employee_test_exists['emergency_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_emergency.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_emergency_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `emergency_test_file_path` = '".$pdf_test_file_path."', `emergency_certificate_file_path` = '".$certificate_file_path."',`emergency_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'covid'){
            $employee_id = $covid_employee_name;
            // echo "ad";die();
            $covid_score = 0;
            $test_score =  $employee_test_exists['covid_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_covid.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_covid_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `covid_test_file_path` = '".$pdf_test_file_path."', `covid_certificate_file_path` = '".$certificate_file_path."',`covid_test_date`='".$date_filled."'WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'bloodpatho'){
            $employee_id = $bloodpatho_employee_name;
            // echo "ad";die();
            $bloodpatho_score = 0;
            $test_score =  $employee_test_exists['bloodpatho_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_bloodpatho.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_bloodpatho_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `bloodpatho_test_file_path` = '".$pdf_test_file_path."', `bloodpatho_certificate_file_path` = '".$certificate_file_path."',`bloodpatho_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
           }elseif($test_type == 'glucometer'){
              //  echo "ad";die();
            $employee_id = $glucometer_employee_name;
            
            $bloodpatho_score = 0;
            $test_score =  $employee_test_exists['glucometer_test_score'];
             // echo $waive_score;die();
             $pdf_test_file_path = "pdf_files/".$employee_name." ".$date_filled."_glucometer.pdf";
             if($test_pass){

                $certificate_file_path =  "pdf_files/".$employee_name." ".$date_filled."_glucometer_cert.pdf";
             }
             $query = "UPDATE `tbl_test_certificates` SET `glucometer_test_file_path` = '".$pdf_test_file_path."', `glucometer_certificate_file_path` = '".$certificate_file_path."',`glucometer_test_date`='".$date_filled."' WHERE employee_id='".$emp_id."'";
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
          $employee_test_record['staff_name'] = $staff_name;
          // echo "<pre>",print_r($employee_test_record),"</pre>";die();
         // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);
          save_pdf($html,$test_type,$test_score,$test_pass,$employee_signature,$staff_signature,$pdf_test_file_path,$certificate_file_path,$employee_test_record);

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
        $date_label=date('F d, Y',strtotime($post['waived_test_date']));

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
        $pdf->SetXY(12,58);  
        $pdf->Write(0, translate($post['waived_q_1']));

        $pdf->SetXY(12,103);  
        $pdf->Write(0, translate($post['waived_q_2']));
       
        $pdf->SetXY(15,129);  
        $pdf->Write(0, $post['waived_q_3']);

         $pdf->SetXY(12,169.5);  
        $pdf->Write(0, translate($post['waived_q_4']));

         $pdf->SetXY(15,206);  
        $pdf->Write(0, $post['waived_q_5']);

         $pdf->AddPage();
         $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(15,24);  
        $pdf->Write(0, $post['waived_q_6']);

           $pdf->SetXY(15,64);  
        $pdf->Write(0, $post['waived_q_7']);


           $pdf->SetXY(15,100);  
        $pdf->Write(0, $post['waived_q_8']);
           $pdf->SetXY(15,129);  
        $pdf->Write(0, $post['waived_q_9']);

        $pdf->SetXY(15,171);  
        $pdf->Write(0, $post['waived_q_10']);

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

           $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Waived Testing",0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           $pdf->Image($staff_signature,160,148,80,30,"PNG");
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
                $pdf->Output($certificate_file_path,'F');
          // die();
        }

    }

       if($test_type == 'hepab'){
        $date_label=date('F d, Y',strtotime($post['hepa_test_date']));

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
        $pdf->SetXY(22,57);  
        $pdf->Write(0, translate($post['hepa_q_1']));

        $pdf->SetXY(22,92);  
        $pdf->Write(0,translate($post['hepa_q_2']));


        $pdf->SetXY(22,126);  
        $pdf->Write(0,translate($post['hepa_q_3']));

         $pdf->SetXY(22,155);  
        $pdf->Write(0,translate($post['hepa_q_4']));
    
         $pdf->SetXY(22,185);  
        $pdf->Write(0,translate($post['hepa_q_5']));


        $pdf->SetXY(22,215);  
        $pdf->Write(0,translate($post['hepa_q_6']));

        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
         $pdf->SetXY(22,35);  
        $pdf->Write(0, translate($post['hepa_q_7']));

        $pdf->SetXY(22,65);  
        $pdf->Write(0, translate($post['hepa_q_8']));

        $pdf->SetXY(22,95);  
        $pdf->Write(0, translate($post['hepa_q_9']));

        $pdf->SetXY(22,127);  
        $pdf->Write(0, translate($post['hepa_q_10']));

        $pdf->SetXY(22,154);  
        $pdf->Write(0, translate($post['hepa_q_11']));
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

           $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hepatitis B",0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           $pdf->Image($staff_signature,160,148,80,30,"PNG");
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
           $pdf->Output($certificate_file_path,'F');//die();
        }
        // die();

    }

      if($test_type == 'harass'){
        $date_label=date('F d, Y',strtotime($post['harass_test_date']));

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
        $pdf->SetXY(18,69);  
        $pdf->Write(0, translate($post['harass_q_1']));

        $pdf->SetXY(18,92);  
        $pdf->Write(0,translate($post['harass_q_2']));

        $pdf->SetXY(18,121);  
        $pdf->Write(0,translate($post['harass_q_3']));

         $pdf->SetXY(18,144);  
        $pdf->Write(0,translate($post['harass_q_4']));

        $pdf->SetXY(18,174);  
        $pdf->Write(0,translate($post['harass_q_5']));

        $pdf->SetXY(18,209);  
        $pdf->Write(0,translate($post['harass_q_6']));


        $pdf->SetXY(18,239);  
        $pdf->Write(0,translate($post['harass_q_7']));


        $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        // now write some text above the imported page
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(18,21);  
        $pdf->Write(0, translate($post['harass_q_8']));

        $pdf->SetXY(18,43);  
        $pdf->Write(0, translate($post['harass_q_9']));

        $pdf->SetXY(18,66);  
        $pdf->Write(0, translate($post['harass_q_10']));

        $pdf->SetXY(18,99);  
        $pdf->Write(0, translate($post['harass_q_11']));

        $pdf->SetXY(18,130);  
        $pdf->Write(0, translate($post['harass_q_12']));

        $pdf->SetXY(18,160);  
        $pdf->Write(0, translate($post['harass_q_13']));

          $pdf->SetXY(18,195);  
        $pdf->Write(0, translate($post['harass_q_14']));

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

           $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Harassment",0,'C');

           $pdf->SetFont('Arial','',12);  
            $pdf->SetXY(60 ,180);  
           $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           $pdf->Image($staff_signature,160,148,80,30,"PNG");
          $pdf->SetXY(172 ,180);  
           $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
           $pdf->Output($certificate_file_path,'F');//die();
        }
        // die();

    }
 
       if($test_type == 'handhygiene'){
        $date_label=date('F d, Y',strtotime($post['hygiene_test_date']));

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
        $pdf->SetXY(29,77);  
        $pdf->Write(0, translate($post['hygiene_q_1']));

        $pdf->SetXY(29,158);  
        $pdf->Write(0, translate($post['hygiene_q_2']));
      
         $pdf->SetXY(29,212);  
        $pdf->Write(0, translate($post['hygiene_q_3']));

         $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  

         $pdf->SetFont('Arial','',12);  
         $pdf->SetXY(29,29);  
         $pdf->Write(0, translate($post['hygiene_q_4']));

           $pdf->SetXY(20,83);  
         $pdf->Write(0, translate($post['hygiene_q_5']));

          $pdf->SetXY(29,115);  
         $pdf->Write(0, translate($post['hygiene_q_6']));

         $pdf->SetXY(29,182);  
         $pdf->Write(0, translate($post['hygiene_q_7']));
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

         $pdf->SetXY(70 ,143);  
         $pdf->MultiCell( 170, 3,"Hand Hygiene",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         $pdf->Image($staff_signature,160,148,80,30,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

      if($test_type == 'emergency'){
        $date_label=date('F d, Y',strtotime($post['emergency_test_date']));

        $pdf_file = "pdf/test_emergency.pdf";
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


        $pdf->Write(0, $post['emergency_test_score']."/7");
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',12);  
        $pdf->SetXY(20,42);  
        $pdf->Write(0, translate($post['emergency_q_1']));

        $pdf->SetXY(20,81);  
        $pdf->Write(0, translate($post['emergency_q_2']));
      
         $pdf->SetXY(20,121);  
        $pdf->Write(0, translate($post['emergency_q_3']));


         $pdf->SetXY(16,165);  
         $pdf->Write(0, translate($post['emergency_q_4']));

           $pdf->SetXY(16,184);  
         $pdf->Write(0, translate($post['emergency_q_5']));

          $pdf->SetXY(16,203);  
         $pdf->Write(0, translate($post['emergency_q_6']));

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

         $pdf->SetXY(70 ,143);  
         $pdf->MultiCell( 170, 3,"Emergency Training",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         $pdf->Image($staff_signature,160,148,80,30,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
        // die();

    }
 
   if($test_type == 'covid'){
        $date_label=date('F d, Y',strtotime($post['covid_test_date']));
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
        $pdf->SetXY(18,67);  
        $pdf->Write(0, translate($post['covid_q_1']));

        $pdf->SetXY(18,85);  
        $pdf->Write(0, translate($post['covid_q_2']));
      
         $pdf->SetXY(18,105);  
        $pdf->Write(0, translate($post['covid_q_3']));

        $pdf->SetXY(18,127);  
        $pdf->Write(0, translate($post['covid_q_4']));

        $pdf->SetXY(18,143);  
        $pdf->Write(0, translate($post['covid_q_5']));

          $pdf->SetXY(18,159);  
        $pdf->Write(0, translate($post['covid_q_6']));

          $pdf->SetXY(18,173);  
        $pdf->Write(0, translate($post['covid_q_7']));

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

         $pdf->SetXY(70 ,143);  
         $pdf->MultiCell( 170, 3,"Covid-19",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         $pdf->Image($staff_signature,160,148,80,30,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

       if($test_type == 'glucometer'){
        $date_label=date('F d, Y',strtotime($post['glucometer_test_date']));
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
        $pdf->SetXY(23,71);  
        $pdf->Write(0, translate($post['glucometer_q_1']));

        $pdf->SetXY(23,91);  
        $pdf->Write(0, translate($post['glucometer_q_2']));

        $pdf->SetXY(23,108);  
        $pdf->Write(0, translate($post['glucometer_q_3']));

        $pdf->SetXY(23,129);  
        $pdf->Write(0, translate($post['glucometer_q_4']));

        $pdf->SetXY(23,145);  
        $pdf->Write(0, translate($post['glucometer_q_5']));

         $pdf->SetXY(23,161);  
        $pdf->Write(0, translate($post['glucometer_q_6']));

         $pdf->SetXY(23,178);  
        $pdf->Write(0, translate($post['glucometer_q_7']));

            $pdf->SetXY(23,199);  
        $pdf->Write(0, translate($post['glucometer_q_8']));

         $pdf->SetXY(23,219);  
        $pdf->Write(0, translate($post['glucometer_q_9']));


         $pdf->SetXY(23,236);  
        $pdf->Write(0, translate($post['glucometer_q_10']));


         $pdf->AddPage();  
        // set the sourcefile  
        $pdf->setSourceFile($pdf_file);  
        // import page 1  
        $tplIdx = $pdf->importPage(2);  
          $pdf->useTemplate($tplIdx, 10, 10, 200); 

          $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(23,39);  
        $pdf->Write(0, translate($post['glucometer_q_11']));

         $pdf->SetXY(25,59);  
        $pdf->Write(0, translate($post['glucometer_q_12']));

         $pdf->SetXY(25,83);  
        $pdf->Write(0, translate($post['glucometer_q_13']));

          $pdf->SetXY(25,115);  
        $pdf->Write(0, translate($post['glucometer_q_14']));

           $pdf->SetXY(23,145);  
        $pdf->Write(0, translate($post['glucometer_q_15']));

         $pdf->SetXY(25,176);  
        $pdf->Write(0, translate($post['glucometer_q_16']));

           $pdf->SetXY(25,208);  
        $pdf->Write(0, translate($post['glucometer_q_17']));
    
    
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

         $pdf->SetXY(70 ,143);  
         $pdf->MultiCell( 170, 3,"Glucometer POCT",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         $pdf->Image($staff_signature,160,148,80,30,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }

     if($test_type == 'bloodpatho'){
        $date_label=date('F d, Y',strtotime($post['bloodpatho_test_date']));
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
        $pdf->SetXY(15,38);  
        $pdf->Write(0, translate($post['bloodpatho_q_1']));

          $pdf->SetXY(15,45);  
        $pdf->Write(0, translate($post['bloodpatho_q_2']));

          $pdf->SetXY(15,52);  
        $pdf->Write(0, translate($post['bloodpatho_q_3']));

        $pdf->SetXY(15,59.5);  
        $pdf->Write(0, translate($post['bloodpatho_q_4']));

        if($post['bloodpatho_q_5'] == 'a'){

          $pdf->SetXY(15,71);  
           $pdf->Write(0, 'HIV');
        }elseif($post['bloodpatho_q_5'] == 'b'){
           $pdf->SetXY(15,71);  
           $pdf->Write(0, 'HBV');
        }elseif($post['bloodpatho_q_5'] == 'c'){
           $pdf->SetXY(15,71);  
           $pdf->Write(0, 'HCV');
        }
         $pdf->SetFont('Arial','',7);
        if($post['bloodpatho_q_6'] == 'a'){

          $pdf->SetXY(3,79.5);  
           $pdf->Write(0, 'Green or Blue');
        }elseif($post['bloodpatho_q_6'] == 'b'){
           $pdf->SetXY(3,79.5);  
           $pdf->Write(0, 'Red or Red-Orange');
        }elseif($post['bloodpatho_q_6'] == 'c'){
           $pdf->SetXY(3,79.5);  
           $pdf->Write(0, 'Clear or Black');
        }

          $pdf->SetFont('Arial','',9);
        

        $pdf->SetXY(15,86);  
        $pdf->Write(0, translate($post['bloodpatho_q_7']));
       $pdf->SetFont('Arial','',9);
        if($post['bloodpatho_q_8'] == 'a'){

          $pdf->SetXY(10,98);  
           $pdf->Write(0, 'Monthly');
        }elseif($post['bloodpatho_q_8'] == 'b'){
           $pdf->SetXY(10,98);  
           $pdf->Write(0, 'Annually');
        }elseif($post['bloodpatho_q_8'] == 'c'){
           $pdf->SetXY(10,98);  
           $pdf->Write(0, 'One each decade');
        }

        if($post['bloodpatho_q_9'] == 'a'){

          $pdf->SetXY(15,105);  
           $pdf->Write(0, 'Heart');
        }elseif($post['bloodpatho_q_9'] == 'b'){
           $pdf->SetXY(15,105);  
           $pdf->Write(0, 'Lungs');
        }elseif($post['bloodpatho_q_9'] == 'c'){
           $pdf->SetXY(15,105);  
           $pdf->Write(0, 'Liver');
        }
        elseif($post['bloodpatho_q_9'] == 'd'){
           $pdf->SetXY(15,105);  
           $pdf->Write(0, 'Pancreas');
        }
        $pdf->SetXY(15,113);  
        $pdf->Write(0, translate($post['bloodpatho_q_10']));
       $pdf->SetFont('Arial','',9);

        $pdf->SetXY(15,120);  
        $pdf->Write(0, translate($post['bloodpatho_q_11']));
       $pdf->SetFont('Arial','',9);
        
        if($post['bloodpatho_q_12'] == 'a'){

          $pdf->SetXY(15,128);  
           $pdf->Write(0, '100%');
        }elseif($post['bloodpatho_q_12'] == 'b'){
           $pdf->SetXY(15,128);  
           $pdf->Write(0, '95%');
        }elseif($post['bloodpatho_q_12'] == 'c'){
           $pdf->SetXY(15,128);  
           $pdf->Write(0, '90%');
        }
        elseif($post['bloodpatho_q_12'] == 'd'){
           $pdf->SetXY(15,128);  
           $pdf->Write(0, '70%');
        }

        $pdf->SetXY(15,139);  
        $pdf->Write(0, translate($post['bloodpatho_q_13']));

        $pdf->SetXY(15,147);  
        $pdf->Write(0, translate($post['bloodpatho_q_14']));

          $pdf->SetXY(15,154);  
        $pdf->Write(0, translate($post['bloodpatho_q_15']));

         $pdf->SetXY(15,161);  
        $pdf->Write(0, translate($post['bloodpatho_q_16']));

          $pdf->SetXY(15,169);  
        $pdf->Write(0, translate($post['bloodpatho_q_17']));


          $pdf->SetXY(15,176);  
        $pdf->Write(0, translate($post['bloodpatho_q_18']));


         $pdf->SetXY(15,184);  
        $pdf->Write(0, translate($post['bloodpatho_q_19']));

        $pdf->SetXY(15,191.5);  
        $pdf->Write(0, translate($post['bloodpatho_q_20']));

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

         $pdf->SetXY(70 ,143);  
         $pdf->MultiCell( 170, 3,"Blood Borne",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
         $pdf->Image($staff_signature,160,148,80,30,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      }
    }
    return $pdf_test_file_path;

  }

  
?>