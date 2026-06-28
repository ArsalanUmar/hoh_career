<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
    require_once('database.php');
    require_once('employee_status.php');

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
    // echo "<pre>",print_r($_POST),"</pre>";die();
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
      $timestamp= date('YmdHis');
      $post = $_POST;
      extract($_POST);
   
      $emp_id = $post['employee_name'];
      $staff_id = $post['staff_name'];
      
       $date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
       

      $sql = "SELECT * FROM `tbl_job_applications` where id='".$emp_id."'";
      $result_logged = $conn->query($sql);
       $employee_details= $result_logged->fetch_assoc();
       if (!employee_is_active($employee_details)) {
        header("Location: custom_certificates.php?e=archived");
        exit;
       }
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
        extract($_POST);
        $certificate_file_path = "pdf_files/".$certificate_name." ".$employee_name." certificate.pdf";
               $query = "INSERT INTO `tbl_custom_certificates` (`employee_id`,`staff_id`,`position`,`training_hours`,`cert_date`,`cert_name`,`cert_file_path`) VALUES ('".$emp_id."','".$staff_id."','".$position."','".$waived_num_hour."','".$date."','".$certificate_name."','".$certificate_file_path."')";

      
          // echo $query;die();
          $result = $con->query($query);
          $test_cert_id = $con->insert_id;

          
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;

          
          save_pdf($html,$employee_signature,$staff_signature,$certificate_file_path,$post);

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // if($send_mail){
            header("Location: custom_certificates.php?s=1");exit;
            
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

  function save_pdf($html,$employee_signature="",$staff_signature="",$certificate_file_path="",$post=array()){
  

      $date_label = date('m/d/Y',strtotime($post['date_filled']));
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
// echo "<pre>",print_r($post),"</pre>";die();
        $pdf->SetFont('Arial','',16);  
        $pdf->SetXY(70 ,83);  
         $pdf->MultiCell( 170, 3,ucwords($post['employee_name']),0,'C');
         $pdf->SetXY(70 ,131);  
           $pdf->MultiCell( 170, 3,$post['certificate_name'],0,'C');
          $pdf->SetFont('Arial','',14);  

         $pdf->SetXY(70 ,143);  
           $pdf->MultiCell( 170, 3,"Hours completed: ".$post['waived_num_hour'],0,'C');

         // $pdf->MultiCell( 170, 3,"Covid-19",0,'C');

         $pdf->SetFont('Arial','',12);  
          $pdf->SetXY(60 ,180);  
         $pdf->MultiCell( 57, 3,"DATE: ".$date_label,0,'C');
           $pdf->Image($staff_signature,190,164,60,20,"PNG");
        $pdf->SetXY(172 ,180);  
         $pdf->MultiCell( 57, 3,"BY: ".$post['staff_name'],0,'C');
              $pdf->Output($certificate_file_path,'F');//die();
      
    

 
    return $certificate_file_path;

  }

  
?>