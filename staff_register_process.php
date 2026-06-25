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
    $con = $db->Conn();
    $html ="";
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
    	$date= date('Y-m-d');//date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;
       $name=       $file_name_pdf =  $_POST['full_name'];

      $resume_name=$pdf_file_name = "";
     
        // $pdf_consent_file = 'pdf_files/LEG_'.$_POST['first_name']." ".$_POST['last_name'].".pdf";

     // echo "<pre>",print_r($_POST),"</pre>";die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        extract($_POST);
        $file_name = $_POST['full_name']."_1_".$date.".jpg";
   
        $pdf_file_name = "pdf_files/".$file_name_pdf.' '.date('Y-m-d').'.pdf';

        // var_dump($response3);die();
        $response = base64_to_jpeg($mySignature,$file_name);
        // $response = base64_to_jpeg($mySignature2,$file_name);
        // $response3 = base64_to_jpeg($mySignature3,$file_name3);
        // var_dump($response3);die();
        sleep(4);
        $signature_path = 'staff_signatures/'.$file_name;
        $work_currently_chk_1 = $work_currently_chk_2 = $work_currently_chk_3 = NULL;
        $hepa_agree_field = NULL;
        if(isset($hepa_agree) && $hepa_agree == 'on'){
          $hepa_agree_field = "agree";
        }else{
           $hepa_agree_field = "disagree";
        }

        // if($response){
          $data = explode(',', $mySignature);
          // $data2= explode(",", $mySignature2);
          $date_filled = date('Y-m-d');
          $query = "INSERT INTO `tbl_staff` (`staff_name`,`signature_path`) VALUES ('".$name."','../".$signature_path."')";
          $result = $con->query($query);
          $last_id = $con->insert_id;

          // echo $query;die();
          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;

           
         // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // if($send_mail){
            header("Location: staff_sign.php?s=1");exit;
            
          // }
        // }
    }

  function base64_to_jpeg($base64_string, $output_file) {
      // $ifp = fopen("signatures/".$output_file, "wb"); 

      $data = explode(',', $base64_string);

      // fwrite($ifp, base64_decode($data[1])); 
      // fclose($ifp); 
      $file_size = file_put_contents("staff_signatures/".$output_file,base64_decode($data[1]));

      
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
      $name = $post['first_name']." ".$post['last_name'];
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
    $mail->setFrom('noreply@hohcareers.com', 'HOHCareers');
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