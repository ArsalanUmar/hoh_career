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

    $ref = (!empty($_GET['ref']) && isset($_GET['ref'])) ? $_GET['ref'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $conn = $db->Conn();

    // echo base64_decode($ref);die();
    $sql = "SELECT * FROM `tbl_staff` where staff_id='".base64_decode($ref)."' ";
    // echo $sql;die();
    $result_logged = $conn->query($sql);
    $record_details= $result_logged->fetch_assoc();
    // echo "<pre>",print_r($record_details),"</pre>";die();
    $html ="";
// echo "<pre>",print_r($record_details),"</pre>";die();
    	$date= date('Y-m-d');//date('Y-m-d');
      $timestamp= date('YmdHis');
       $name=       $file_name_pdf =  $record_details['staff_name'];

      $resume_name=$pdf_file_name = "";
     
        $pdf_consent_file = 'pdf_files/LEG_'.$record_details['staff_name'].".pdf";

      $query = "UPDATE `tbl_staff` SET `legal_consent_path` = '".$pdf_consent_file."' where staff_id='".base64_decode($ref)."'";
       
          // echo $query;die();
      $result = $conn->query($query);
      $pdf_file_cons = "pdf/legal_consent_template.pdf";
       $date_label=date('F d, Y',strtotime($record_details['date_created']));

      $pdf = new FPDF();
      $pdf->AddPage();
       
      $pdf = new FPDI();  
      $pdf->AddPage();  
      $pdf->setSourceFile($pdf_file_cons);  
      $tplIdx = $pdf->importPage(1);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
      $pdf->SetTextColor(0,0,0);

      $pdf->SetFont('Arial','',10);  
      $pdf->SetXY(37 ,57);  
      $pdf->Write(0, ucwords($record_details['staff_name']));
      $pdf->SetFont('Arial','',10);  
      $signature_path = str_replace("../","",$record_details['signature_path']);
      // var_dump(file_exists($signature_path));die();
      // echo $signature_path;die();
      $pdf->Image($signature_path,25,95,100,40,"PNG");  
      $pdf->SetXY(138,121);  
      $pdf->Write(0, $date_label); 
      $pdf->Output($pdf_consent_file,'F');

    
      echo "File was successfully generated you can click <a href='".$pdf_consent_file."' > here </a> to download";
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
          $subject = "EMPLOYEE REGISTRATION";
        }else{
          $subject = "EMPLOYEE REGISTRATION - New  form has been received.";
        }
           
      // echo "<pre>",print_r($post),"</pre>";die();
     $m = $html = "";
      $name = $post['staff_name'];
      unset($post['mySignature-dpi']);
      unset($post['mySignature']);
        unset($post['mySignature2-type']);
      unset($post['mySignature2-dpi']);
      unset($post['mySignature2']);

      if($receiver){
         $m .= "You have recently signed a employee registration with hohcareers.com with the following info:  <br>";
        

      }else{
         $m .= "You have received new employee registration form: <br>";
          $m .= "First Name: ".$post['first_name']."<br>";
         $m .= "Last Name: ".$post['last_name']."<br>";
          $m .= "Email: ".$post['email']."<br><br>";

          $m .="<p>I agree and understand that by signing the Electronic Signature Acknowledgment and Consent Form, that all electronic signatures are the legal equivalent of my manual/handwritten signature and I consent to be legally bound to this agreement. I further agree my signature on this document is as valid as if I signed the document in writing. This is to be used in conjunction with the use of electronic signatures on all forms regarding any and all future documentation with a signature requirement, should I elect to have signed electronically. Under penalty of perjury, I herewith affirm that my electronic signature, and all future electronic signatures, were signed by myself with full knowledge and consent and am legally bound to these terms and conditions.</p>";
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
        // $mail->addAttachment($file_name_pdf);
                // $mail->addAttachment($file_name_pdf_2);

        // $mail->addAttachment($pdf_consent_file);

        $mail->send();
        return $file_name_pdf;
  

  }


  
?>