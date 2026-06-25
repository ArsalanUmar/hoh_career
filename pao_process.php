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
    $conn = $db->Conn();
    $html ="";
    // echo "<pre>",print_r($_POST),"</pre>";die();
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $conn->real_escape_string($post_val);
      }
      $ref = $_POST['ref'];
      $sql = "SELECT * FROM `tbl_job_applications` where id='".$ref."' ";
      $result_logged = $conn->query($sql);
      $record_details= $result_logged->fetch_assoc();
      $first_name = $record_details['first_name'];
        $last_name = $record_details['last_name'];
        $email = $record_details['email'];

      $pdf_file_path = $record_details['pdf_file_path'];

      $date=date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;

//       echo "<pre>",print_r($post),"</pre>";
// echo $pdf_file_path;die();
//       die();
    $file_name_pdf =  str_replace("pdf_files/", "pdf_files/WREF_", $pdf_file_path);
    	$date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;
       $name=       $file_name_pdf =  "";
       $position = $record_details['position'];
        if($position == 'Clinical Supervisor/Nursing Supervisor'){
          $jo_pdf_file = 'pdf/jo_clinical_supervisor.pdf';
        }else if($position == 'Clinical Director/Director of Patient Care Services'){
          $jo_pdf_file = 'pdf/jo_dpcs.pdf';
        }else if($position == 'Licensed Vocational Nurse'){
          $jo_pdf_file = 'pdf/jo_vocational_nurse.pdf';
        }else if($position == 'Medical Social Worker'){
          $jo_pdf_file = 'pdf/jo_medical_social_worker.pdf';
        }else if($position == 'Home Health Aid'){
          $jo_pdf_file = 'pdf/jo_health_aide.pdf';
        }else if($position == 'Registered Nurse'){
          $jo_pdf_file = 'pdf/jo_registered_nurse';
        }else if($position == 'Office Manager'){
          $jo_pdf_file = 'pdf/jo_office_manager.pdf';
        }else if($position == 'Secretary/Receptionist'){
          $jo_pdf_file = 'pdf/jo_receptionist.pdf';
        }
// echo "<pre>",print_r($post),"</pre>";die();
    $pdf_file_name = "";


     // echo "<pre>",print_r($_POST),"</pre>";die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        extract($_POST);
        $file_name = "HH_".$first_name." ".$last_name."_1_".$date.".jpg";
   
        $file_name_pdf =  str_replace("pdf_files/", "pdf_files/HH_", $pdf_file_path);

       // $pdf_jo_file_name = "pdf_files/JO_".$file_name_pdf.' '.date('Y-m-d').'.pdf';
       // $pdf_agr_file_name = "pdf_files/AGR_".$file_name_pdf.' '.date('Y-m-d').'.pdf';

        // var_dump($response3);die();
        $response = base64_to_jpeg($mySignature,$file_name);
        // $response = base64_to_jpeg($mySignature2,$file_name);
        // $response3 = base64_to_jpeg($mySignature3,$file_name3);
        // var_dump($response3);die();
        sleep(5);
        $signature_path = 'signatures/'.$file_name;
   
        if($response){
          $data = explode(',', $mySignature);
          $query = "UPDATE `tbl_job_applications` SET hh_file_path='".$file_name_pdf."' WHERE id='".$ref."'";
          // echo $query;die();
          $result = $conn->query($query);
          // $last_id = $con->insert_id;

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
          $post['name'] = ucwords($first_name." ".$last_name);
           // echo $signature_path;die();
         save_pdf($html,"signatures/".$file_name,$file_name_pdf,$post);
          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          $send_mail =send_mail($file_name,$email,$name,$date,$post,false,$file_name_pdf,$ref);
          if($send_mail){
            header("Location: pao_form.php?ref=".base64_encode($ref)."&s=1");exit;
            
          }
        }
    }

  function base64_to_jpeg($base64_string, $output_file) {
      // $ifp = fopen("signatures/".$output_file, "wb"); 

      $data = explode(',', $base64_string);

      // fwrite($ifp, base64_decode($data[1])); 
      // fclose($ifp); 
      $file_size = file_put_contents("signatures/".$output_file,base64_decode($data[1]));

      
      return $file_size; 
  }


  function send_mail($file_name,$email,$name,$date,$post=array(),$receiver=false,$file_name_pdf="",$ref=""){
      require_once "phpmailer/Exception.php";

      require_once "phpmailer/PHPMailer.php";
       require_once "phpmailer/SMTP.php";
// echo $email;
// echo "<pre>",print_r($post),"</pre>";
// die();

      /* Email Detials */
      // $filename = "sender.txt";
      // $handle = fopen($filename, "r");
      $mail_to = "techyjust@gmail.com";//fread($handle, filesize($filename));
      // fclose($handle);
    
        if($receiver){
          $subject = "PERSONNEL ACKNOWLEDGEMENT ORIENTATION FORM - copy";
        }else{
          $subject = "PERSONNEL ACKNOWLEDGEMENT ORIENTATION FORM - New  form has been received.";
        }
           
      // echo "<pre>",print_r($post),"</pre>";die();
     $m = $html = "";
      // $name = $post['first_name']." ".$post['last_name'];
      unset($post['mySignature-dpi']);
      unset($post['mySignature']);


      if($receiver){
         $m .= "You have recently signed a personnel orientation acknowledgement. Attached is the copy of pdf form with the signed document <br>";
        
      }else{
         $m .= "You have received new personnel orientation acknowledgement: <br>";
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

        // $file_name_pdf = "pdf_files/".$name.' '.date('Y-m-d').'.pdf';
        //         $file_name_pdf_2 = "pdf_files/HBV_".$name.' '.date('Y-m-d').'.pdf';

      // $file_name_pdf = save_pdf($html,$file,$name,$post);
    /* Set the email header */
      // Generate a boundary
      $boundary = md5(uniqid(time()));    
      $eol = PHP_EOL;
     
      $message = "$m".$eol;
     $message .= "<br>See attachment to read the copy of your job application, and please keep in your records. <br><br>
Thank you so much!";
   

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
             // $mail->addAddress($post['email'], "Info");
        }

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->addAttachment($file_name_pdf);

        // $mail->addAttachment("pdf/tem.pdf");

        $mail->send();
        return $file_name_pdf;
  

  }

  function save_pdf($html,$signature1,$file_name_pdf="",$post=array()){

    $pdf_file = 'pdf/ho_template.pdf';//$jo_pdf_file;// "pdf/.pdf";
    $date=date('Y-m-d');
     $date_label=date('F d, Y',strtotime($post['date_filled']));
    $path = "signatures/";
    // echo $pdf_file;die();
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
   
     $pdf->SetFont('Arial','',10);  
    $pdf->SetXY(55 ,47);  
     $pdf->Write(0, ucwords($post['name']));
     $pdf->Image($signature1,50,190,60,20,"PNG");
     $pdf->SetXY(155 ,206);  
     $pdf->Write(0, $date_label);
     $pdf->Output($file_name_pdf,'F');//exit;

  
    return $file_name_pdf;

  }

  
?>