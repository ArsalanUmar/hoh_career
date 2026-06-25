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
        $file_name = $_POST['full_name']."_influenza_".$date.".jpg";
         if($post['i_consent'] == 'no'){

              $pdf_file_name = "pdf_files/".$file_name_pdf.' influenza form '.date('Y-m-d His').'.pdf';
         } else{
          $pdf_file_name = NULL;
         }

        // var_dump($response3);die();
        $response = base64_to_jpeg($mySignature,$file_name);
        // $response = base64_to_jpeg($mySignature2,$file_name);
        // $response3 = base64_to_jpeg($mySignature3,$file_name3);
        // var_dump($response3);die();
        sleep(4);
        $signature_path = 'signatures/'.$file_name;
  
        // if($response){
          $data = explode(',', $mySignature);
          // $data2= explode(",", $mySignature2);
          $date_filled = date('Y-m-d');

          if($_POST['i_consent'] =='no'){

          $consented=0; 
          }else{
            $consented=1;
          }
          $reason=  $other_reason = NULL;

                    if(!empty($post['decline_reason']) && $post['i_consent'] == 'no'){
             $decline_reason= $post['decline_reason'];
             if($decline_reason == 'opt_1'){
               $reason = "I have already received influenza vaccine and have provided documentation";
             }else if($decline_reason == 'opt_2'){
               $reason = "I believe I will get the flu if I get the shot.";
             }else if($decline_reason == 'opt_3'){
               $reason = "I do not like needles.";
             }else if($decline_reason == 'opt_4'){
               $reason = "My philosophical or religious beliefs prohibit vaccination.";
             }else if($decline_reason == 'opt_5'){
               $reason = "I have a medical contraindication to receiving the vaccine.";
             }else if($decline_reason == 'opt_6'){
               $reason = "I do not wish to say why I decline.";
             }else if($decline_reason == 'other'){
               $reason = "other";
               $other_reason=$post['other_reason'];
             }
          }
         
          $query = "INSERT INTO `tbl_influenza_forms` (`name`,`signature`,`date_signed`,`reason`,`other_reason`,`accept`,`pdf_path`) VALUES ('".$post['full_name']."','../".$signature_path."','".$post['date']."','".$reason."','".$other_reason."','".$consented."','".$pdf_file_name."')";      
         $result = $con->query($query);
          // echo $con->error;
          $last_id = $con->insert_id;

          // echo $query;
          // echo $last_id;
          // die();
          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;

          
          if($post['i_consent']){

            save_pdf($html,$mySignature,"signatures/".$file_name,$pdf_file_name,$post);
          }

          // if($send_mail){
            header("Location: influenza_form.php?s=1");exit;
            
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

    function save_pdf($html,$signature1,$signature_file="",$file_name_pdf="",$post=array()){

    $date=date('Y-m-d');

// echo "<pre>",print_r($post),"</pre>";die();
   
          $pdf_file = 'pdf/influenza_form.pdf';//$jo_pdf_file;// "pdf/.pdf";

    
     $date_label=date('F d, Y',strtotime($post['date']));
    $path = "signatures/";
    // echo $pdf_file;die();
// echo "<pre>",print_r($post),"</pre>";die();

        // $file_spr_name = $path.$post['spr_name']." ".$date.".jpg";
    // $year = date('Y',strtotime( $);
    // echo $year;die();
    $pdf = new FPDI();  
    // add a page
    $pdf->AddPage();  
    // set the sourcefile  
    $pdf->setSourceFile($pdf_file);  
    // import page 1  
    $tplIdx = $pdf->importPage(1);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
      $pdf->SetFont('zapfdingbats', '', 13);
        

          if($post['i_consent'] != "no"){
               $pdf->SetXY(20 ,100);   
            $pdf->Write(0, "4");
          }else{
             $pdf->SetXY(20 ,152);   
            $pdf->Write(0, "4");

          }
    
              $pdf->SetFont('zapfdingbats', '', 9);

            if($post['decline_reason']=='opt_1'){
                 $pdf->SetXY(27 ,179);   
                $pdf->Write(0, "4");
            }else if($post['decline_reason']=='opt_2'){

               $pdf->SetXY(27 ,184);   
               $pdf->Write(0, "4");
            }else if($post['decline_reason']=='opt_3'){

               $pdf->SetXY(27 ,188);   
               $pdf->Write(0, "4");
            }else if($post['decline_reason']=='opt_4'){

               $pdf->SetXY(27 ,193);   
               $pdf->Write(0, "4");
            }else if($post['decline_reason']=='opt_5'){

               $pdf->SetXY(27 ,197);   
               $pdf->Write(0, "4");
            }else if($post['decline_reason']=='other'){

               $pdf->SetXY(27 ,202);   
               $pdf->Write(0, "4");
               $pdf->SetFont('Arial','',9);  
                   $pdf->SetXY(70    ,202);  

               $pdf->Write(0,$post['other_reason']);
            }else if($post['decline_reason']=='opt_6'){

               $pdf->SetXY(27 ,206);   
               $pdf->Write(0, "4");
            }
      
// var_dump($signature1);die();
           $pdf->SetFont('Arial','',9);  
                           $pdf->SetXY(34 ,250);   
              
               $pdf->Write(0,ucwords($post['full_name']));
                      $pdf->Image($signature1,110,235   ,60,20,"PNG");
                   // $pdf->SetXY(70    ,202);  
               $pdf->SetFont('Arial','',8);  
           
                              $pdf->SetXY(175    ,250);   
              
               $pdf->Write(0,$date_label);

            $pdf->Output($file_name_pdf,'F');//exit;

    

    
      
     


    

        return $file_name_pdf;

  
    

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