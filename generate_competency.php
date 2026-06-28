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
    // echo "<pre>",print_r($_POST),"</pre>";
    if(!empty($_POST)){
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
      $timestamp= date('YmdHis');
      $post = $_POST;
      $waived_test  = $hepab_test = $harass_test = $handhygiene_test = $emergency_test = $covid_test =  $bloodpatho_test = $gluco_test= false;
      $test_type = "";
      $emp_id = $post['employee_name'];
      $staff_id = $post['staff_name'];
      $employment_date =date('F d, Y',strtotime($post['employment_date'])); 
    
     $sql = "SELECT * FROM `tbl_job_applications`  where id='".$emp_id."'";
     $result_logged = $conn->query($sql);
     $employee_details = $result_logged->fetch_assoc() ;
     if (!employee_is_active($employee_details)) {
        header("Location: competency.php?e=archived");
        exit;
     }
     $sql = "SELECT * FROM `tbl_staff`  where staff_id='".$post['staff_name']."'";
     $result_logged = $conn->query($sql);
     $staff_details = $result_logged->fetch_assoc() ;
          $employee_name = $employee_details['first_name']. " ".$employee_details['last_name'];
          $employee_signature = $employee_details['signature_path'];
     $staff_name = $staff_details['staff_name'];
            $initials = initials( $staff_name);
     $date_label=date('F d, Y',strtotime($post['generate_date']));
     $staff_signature = str_replace("../", "", $staff_details['signature_path']);
     // Sanitize position for filename: slash would be interpreted as path separator
     $pdf_file_path = "COM_".$employee_name." ".str_replace('/', '-', $post['position']).".pdf";
     $post['employee_name'] = $employee_name;
     $post['staff_name']= $staff_name;
     $post['initials'] = $initials;
           $query = "INSERT INTO `tbl_competencies` (`employee_id`,`staff_id`,`position`,`organization`,`generate_date`,`generate_to_date`,`employment_date`,`pdf_file_path`) VALUES ('".$emp_id."','".$staff_id."','".$post['position']."','".$post['company_applying']."','".$post['generate_date']."','".$post['generate_to_date']."','".$post['employment_date']."','".$pdf_file_path."')";
          // echo $query;die();
          $result = $con->query($query);
          $last_id = $con->insert_id;

       $name =       $file_name_pdf = $employee_name;
      $resume_name=$pdf_file_name = "";
    
      
       
          // echo "<pre>",print_r($employee_test_record),"</pre>";die();
         // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);
          save_pdf($html,$employee_signature,$staff_signature,$pdf_file_path,$post);

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // if($send_mail){
            header("Location: competency.php?s=1");exit;
            
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

  function save_pdf($html,$employee_signature,$staff_signature,$pdf_file_name,$post=array()){
    extract($post);
      $date = new DateTime($post['employment_date']);
        $date->modify('+3 month'); // or you can use '-90 day' for deduct
        $date_ = $date->format('Y-m-d h:i:s');
        $random_date = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date2 = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date3 = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date4 = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date5 = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date6 = randomDate($post['generate_date'],$post['generate_to_date']);
        $random_date7 = randomDate($post['generate_date'],$post['generate_to_date']);

        $completed_date= "";
        if(strtotime($random_date) > strtotime($random_date2)){
          $completed_date = $random_date;
        }else{
          $completed_date = $random_date2;
        }

        if(strtotime($completed_date) < strtotime($random_date3)) {
          $completed_date = $random_date3;
        }

          if(strtotime($completed_date) < strtotime($random_date4)) {
          $completed_date = $random_date4;
        }

          if(strtotime($completed_date) < strtotime($random_date5)) {
          $completed_date = $random_date5;
        }

        if(strtotime($completed_date) < strtotime($random_date6)) {
          $completed_date = $random_date6;
        }

        if(strtotime($completed_date) < strtotime($random_date7)) {
          $completed_date = $random_date7;
        }



        $save_pdf_path = "pdf_files/".$pdf_file_name;
        $employment_date = date('m/d/Y',strtotime($employment_date));

        // echo "<pre>",print_r($post),"</pre>";die();
      if($post['company_applying'] == 'Home Health' && $post['position'] == 'Home Health Aide'){

          $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hm_aide.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,43);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,52);  
          $pdf->Write(0, ucwords($employment_date));

          $pdf->SetXY(145 ,52);  
          $pdf->Write(0,$completed_date);
          $y = 96;
          for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }
           $y -=2;
           for ($i=0; $i<=1;$i++){

            $pdf->SetXY(174 ,$y);  
           if(!in_array( $i,array(2))){

            $pdf->Write(0, ucwords($initials)." ".$random_date4);
            } 
              $y += 7;
          }
          for ($i=0; $i<=15;$i++){

            $pdf->SetXY(174 ,$y);  
           if(!in_array( $i,array(0))){

            $pdf->Write(0, ucwords($initials)." ".$random_date5);
            } 
              $y += 7;
          }
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
            $pdf->useTemplate($tplIdx, 10, 10, 200);  

          // echo $initials;die();    
          $pdf->SetFont('Arial','',9);  
          $y = 56;

         for ($i=0; $i<=26;$i++){
            $pdf->SetXY(174 ,$y);  
             if(!in_array( $i,array(1,6,11,22))){

                $pdf->Write(0, ucwords($initials)." ".$random_date6); 
              }
              $y += 7;
          }
          $pdf->AddPage(); 
          $tplIdx = $pdf->importPage(3);  
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

          // echo $initials;die();    
          $pdf->SetFont('Arial','',9);  
                   $y = 56;

         for ($i=0; $i<=5;$i++){

            $pdf->SetXY(174 ,$y);  
            if(!in_array( $i,array(0,4,10,17))){

            $pdf->Write(0, ucwords($initials)." ".$random_date5);
            }
              $y += 7;
          }
          for ($i=0; $i<=15;$i++){

            $pdf->SetXY(174 ,$y);  
            if(!in_array( $i,array(4,11,17))){

            $pdf->Write(0, ucwords($initials)." ".$random_date2);
            }
              $y += 7;
          }
          $y+=2;
           for ($i=0; $i<=4;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $pdf->AddPage(); 
          $tplIdx = $pdf->importPage(4);  
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
           $y = 56;

         for ($i=0; $i<=4;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
           $pdf->SetXY(167 ,154);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(40 ,154);  
          $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,76,134,60,20,"PNG");
          $pdf->SetXY(167 ,170);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(40 ,170);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,158,60,20,"PNG");
                 
          $pdf->Output($save_pdf_path,'F');// die();
         // $pdf->Output($save_pdf_path,'I'); die();
      }
      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Social Health Aid'){
          $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_aide.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
             // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,43);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,52);  
          $pdf->Write(0, ucwords($employment_date));
          $pdf->SetXY(150 ,53);  
          $pdf->Write(0, ucwords($completed_date));
          $y = 92;
          for ($i=0; $i<=2 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 8;
          }
          $y-=2 ;
          for ($i=0; $i<=2 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
          $y+=7;
           for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
           for ($i=0; $i<=7 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
          $y+=7;

           for ($i=0; $i<=1 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

          $y = 57;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 8;
          }

          $y +=7;
           for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }
           $y += 7;
          
          for ($i=0; $i<=0 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
       
          for ($i=0; $i<=8 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 7;

           for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
           $y += 7;

           for ($i=0; $i<=2 ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
          $pdf->AddPage();  

          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

          $y = 65;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
          $y += 7;
          for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

            $y += 7;
          for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

            $y += 5;
           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
             $y += 4;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

           for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

            $pdf->AddPage();  

          // set the sourcefile  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

          $y = 57;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
          $y += 11;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y += 14;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

            $y += 10;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

              $pdf->AddPage();  

          // set the sourcefile  
          $tplIdx = $pdf->importPage(7);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
            $y = 67;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y +=6;
          for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
           $pdf->SetXY(167 ,148);  
          $pdf->Write(0, ucwords($completed_date));
                     $pdf->SetXY(38 ,148);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,76,128,60,20,"PNG");
          $pdf->SetXY(167 ,160);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(38 ,158);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,150,60,20,"PNG");
   
          $pdf->output($save_pdf_path,'F');//die();
           // $pdf->output($save_pdf_path,'I');die();
      }

      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Bereavement Coordinator'){
          $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_bereave.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
          $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));

           $y = 98;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $y += 4;

          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $y += 14;


          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }


           $y += 5;

          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

            $y += 7;

          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
            $y = 58 ;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 8;
          }
           $y += 7;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 8;
          }
           $y -= 2;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

          $y += 7;
           for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

          $y += 7;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


          $y += 9;
           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 9;
          }



          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
            $y = 65 ;
          for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 8;
          }

            $pdf->SetXY(160 ,135);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(38  ,135);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,114,60,20,"PNG");
          $pdf->SetXY(160,150);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(38 ,150);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,140,60,20,"PNG");
           // $pdf->output($save_pdf_path,'I');die();
          $pdf->output($save_pdf_path,'F');
      }

      
      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Chaplain'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_chaplain.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
        $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));

           $y = 98;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

          $y += 2;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

            $y+=14;
           for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          } 
            $y += 5;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
            $y += 7;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 8;
          }
          

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  
         
           $y = 56;
          for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }


            $y +=7;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

           $y +=10;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 8;
          }

            $y +=5;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }


            $y +=7;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 9;
          }

             $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  
           $pdf->SetXY(160 ,85);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(38  ,85);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,64,60,20,"PNG");
          $pdf->SetXY(160,100);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(38 ,100);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,90,60,20,"PNG");
         // $pdf->output($save_pdf_path,'I');die();
           $pdf->output($save_pdf_path,'F');//die();
      }



      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Licensed Vocational Nurse'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_lvn.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
          $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));

           $y = 94;
          for ($i=0; $i<=8   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $y += 2;
           for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

           $y += 10;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=13   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
            $y += 10;

           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
          $y+=2;
          for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

            $y+=7;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }


           $y +=7;
          for ($i=0; $i<=11   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

             $y +=7;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

          $y+=7;
          for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


          $y+=5;
          for ($i=0; $i<=8   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

            $y+=5;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }



          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(7);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=8   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $y+=7;

          for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y+=7;

          for ($i=0; $i<=2  ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $y+=7;

          for ($i=0; $i<=4  ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(8);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
          $y+=18;
           for ($i=0; $i<=9   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
           $y+=4;
           for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }



          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(9);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


           for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }
            $y += 7;
           for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

            $y += 4;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }




          $pdf->AddPage();  
          $tplIdx = $pdf->importPage(10);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

           $y = 57;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(176 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
            $pdf->SetXY(147 ,126);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(33  ,126);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,105,60,20,"PNG");
          $pdf->SetXY(147,137);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(33 ,137);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,125,60,20,"PNG");
           $pdf->output($save_pdf_path,'F');//die();
           // $pdf->output($save_pdf_path,'I');//die();
      }

      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Physician'){

          $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_physician.pdf";
          $passing_score = 7;
          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page

             $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->SetFont('Arial','',10);  
          $pdf->SetXY(49 ,43);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,52);  
          $pdf->Write(0, ucwords($employment_date));
               $pdf->SetXY(145 ,52);  
          $pdf->Write(0, ucwords($completed_date));
          $y = 92;
          for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }
           $y +=7    ;
           for ($i=0; $i<=1;$i++){

            $pdf->SetXY(167 ,$y);  
           if(!in_array( $i,array(2))){

            $pdf->Write(0, ucwords($initials)." ".$random_date4);
            } 
              $y += 7;
          }
            $y += 7;
           for ($i=0; $i<=0;$i++){

            $pdf->SetXY(167 ,$y);  
           if(!in_array( $i,array(2))){

            $pdf->Write(0, ucwords($initials)." ".$random_date4);
            } 
              $y += 7;
          }

            $y += 12;
           for ($i=0; $i<=6;$i++){

            $pdf->SetXY(167 ,$y);  

            $pdf->Write(0, ucwords($initials)." ".$random_date3);
             
              $y += 7;
           }

           $y += 9;
           for ($i=0; $i<=1;$i++){

            $pdf->SetXY(167 ,$y);  

            $pdf->Write(0, ucwords($initials)." ".$random_date4);
            
              $y += 7;
          }
           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

       
          $y = 56;
          for ($i=0; $i<=1 ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }
          $y += 5;
           for ($i=0; $i<=3 ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 8;
          }
            $y -=2;
           for ($i=0; $i<=0  ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 8;
          }

            $y +=3;
           for ($i=0; $i<=1  ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 14;
          }

          $y-=3;
           for ($i=0; $i<=5  ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

          $y+=7;
           for ($i=0; $i<=1  ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

            $y+=6;
           for ($i=0; $i<=4  ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

       
          $y = 56;
          for ($i=0; $i<=1 ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }
          $y += 5;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 8;
          }

            $y += 4;
           for ($i=0; $i<=13   ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

           $y += 7;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

       
          $y = 56;
          for ($i=0; $i<=0 ;$i++){
            $pdf->SetXY(167 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }

              $pdf->SetXY(160 ,120);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(33  ,120);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,100,60,20,"PNG");
          $pdf->SetXY(160,136);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(33 ,136);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,125,60,20,"PNG");
         
          $pdf->Output($save_pdf_path,'F');//die();
// $pdf->Output($save_pdf_path,'I');//die();
      }

      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Medical Social Worker'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_social_worker.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
          $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));
           $y = 92;
          for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $y += 14;

           for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }


           $y += 7;

           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y += 6;

           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 8;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
         

           $y = 58;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $y += 8;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

           $y += 7;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
           $y += 7;
           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y += 10;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

           $y += 10;
           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

           $y += 7;
           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
         

           $y = 62;
          for ($i=0; $i<=9   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

          $y += 7;

           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y += 13;

           for ($i=0; $i<=8   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
         

           $y = 62;
          for ($i=0; $i<=10   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
           $y += 12;
            for ($i=0; $i<=2  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
           $y += 14;
            for ($i=0; $i<=2  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $y += 3;
            for ($i=0; $i<=4  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6 );
              $y += 7;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(7);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
         

           $y = 62;
          for ($i=0; $i<=9   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 14;
           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 12;
           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

             $y += 7;
           for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $y += 30;
           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(8);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
         

           $y = 57;
          for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }


              $pdf->SetXY(160 ,138);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(33  ,138);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,115,60,20,"PNG");
          $pdf->SetXY(160,149);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(33 ,149);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,138,60,20,"PNG");
             //$pdf->Output($save_pdf_path,'I');//die();
           $pdf->Output($save_pdf_path,'F');//die();
     }

     if($post['company_applying'] == 'Hospice' && $post['position'] == 'Registered Nurse'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_rn.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',9);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
          $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));
           $y = 95;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 6;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

           $y += 6;
           for ($i=0; $i<=6  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=60;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $y += 7;

            for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
            $y += 7;
            for ($i=0; $i<=1  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $y += 14;
            for ($i=0; $i<=6  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=56;
          for ($i=0; $i<=11   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
          $y+=7;
          for ($i=0; $i<=13  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=63;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
           $y += 5;
          for ($i=0; $i<=4     ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

           $y += 7;
          for ($i=0; $i<=6     ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

           $y += 7;
          for ($i=0; $i<=8     ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(7);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=57;
          for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
           $y += 7;
           for ($i=0; $i<=14   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
          $y += 5;
           for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }


          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(8);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=57;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
          $y += 6;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

          for ($i=0; $i<=13   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 6.8;
          }
           $y+=7;
           for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 6.8;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(9);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=59;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

          $y+=7;

          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }
         $y+=7;
          for ($i=0; $i<=8   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7.2;
          }

          $y+=7;
          for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7.2;
          }

           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(10);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=59;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
          $y+=5;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
           $y+=7;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }
          $y+=7;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

           $y+=19;
          for ($i=0; $i<=2  ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 8;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(11);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=58;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }

          $y+=7;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
           $y+=7;
          for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

             $y+=7;
          for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(12);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=58;
          for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

          for ($i=0; $i<=12   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $y+=7;

           for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(13);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=60;
          for ($i=0; $i<=11   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

          $y+=12;
           for ($i=0; $i<=0   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }



          $y+=17;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(174 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(14);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  

               $pdf->SetXY(150 ,31);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(33  ,31);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,12,60,20,"PNG");
          $pdf->SetXY(150,42);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(33 ,42);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,33,60,20,"PNG");
            $pdf->Output($save_pdf_path,'F');//die();
           // $pdf->Output($save_pdf_path,'I');
      }


      if($post['company_applying'] == 'Hospice' && $post['position'] == 'Volunteer'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hc_vol.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);

          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  
          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
         $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));
           $y = 100;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(166.5,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 8;

            for ($i=0; $i<=4 ;$i++){
            $pdf->SetXY(166.5,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
            $y += 5;

           for ($i=0; $i<=2 ;$i++){
            $pdf->SetXY(166.5,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

           $y += 7;

           for ($i=0; $i<=2 ;$i++){
            $pdf->SetXY(166.5,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }


           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $y=57;
          for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(166.5 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

           $y += 7;

         for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(166.5 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

          $y += 7;

         for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(166.5 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }


          $y += 7;

         for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(166.5 ,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7.5;
          }

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
             $pdf->SetXY(160 ,123);  
          $pdf->Write(0, ucwords($completed_date));
          $pdf->SetXY(33  ,123);  

            $pdf->Write(0, $employee_name);
          $pdf->Image($employee_signature,70,100,60,20,"PNG");
          $pdf->SetXY(160,138);  
          $pdf->Write(0, $completed_date);
          $pdf->SetXY(33 ,138);  
          $pdf->Write(0, $staff_name);
          $pdf->Image($staff_signature,70,125,60,20,"PNG");

          // $pdf->Output($save_pdf_path,'F');

          $pdf->Output($save_pdf_path,'F');
        }

       if($post['company_applying'] == 'Home Health' && $post['position'] == 'Licensed Vocational Nurse'){
         $date_label=date('F d, Y',strtotime($post['generate_date']));
          $pdf_file = "pdf/com_hm_lvn_template.pdf";

          $pdf = new FPDF();
          $pdf->AddPage();
      
          $pdf = new FPDI();  
          // add a page
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(1);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
           $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(2);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  

          $pdf->SetXY(49 ,45);  
          $pdf->Write(0, ucwords($employee_name));

          $pdf->SetXY(70 ,53);  
          $pdf->Write(0, ucwords($employment_date));
            $pdf->SetXY(145 ,53);  
          $pdf->Write(0, ucwords($completed_date));

           $y = 93    ;
          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 8;
            for ($i=0; $i<=6  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
           $y += 8;
          for ($i=0; $i<=2  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }
           $y += 14;
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
             $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(3);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetFont('Arial','',10);  

             // import page 1  
        


           $y = 58    ;
          for ($i=0; $i<=12   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7   ;
          }
           $y += 7;   
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
           $y += 6   ;   
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
             $y += 5;
           for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

          
              // import page 1  
          $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(4);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 57;
          for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

           $y += 7;

           for ($i=0; $i<=11   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date);
              $y += 7;
          }

           $y += 6;

           for ($i=0; $i<=9   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }

            $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(5);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 64;
          for ($i=0; $i<=3   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }
            $y += 4;
            for ($i=0; $i<=7   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }
          $y += 7;
            for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

          for ($i=0; $i<=6   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
              $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(6);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 57;
          for ($i=0; $i<=6  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date6);
              $y += 7;
          }
            $y += 7;
            for ($i=0; $i<=5   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date5);
              $y += 7;
          }

             $y += 9;
            for ($i=0; $i<=2   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

            $y += 5;
            for ($i=0; $i<=4   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

           $y += 7;
            for ($i=0; $i<=1   ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }

              $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(7);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 57;
          for ($i=0; $i<=5  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
             $y += 10;
           for ($i=0; $i<=9  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

            $y += 5;
           for ($i=0; $i<=8  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date3);
              $y += 7;
          }


              $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(8);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 57;
          for ($i=0; $i<=13  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date2);
              $y += 7;
          }
             $y += 7;
              for ($i=0; $i<=5  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

           $y += 2;
              for ($i=0; $i<=5  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

              $pdf->AddPage();  
          // set the sourcefile  
          $tplIdx = $pdf->importPage(9);  
          // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          // now write some text above the imported page
          $pdf->SetTextColor(0,0,0);
          $pdf->SetFont('Arial','',10);  


           $y = 57;
          for ($i=0; $i<=3  ;$i++){
            $pdf->SetXY(172,$y);  
            $pdf->Write(0, ucwords($initials)." ".$random_date4);
              $y += 7;
          }

          $pdf->SetXY(33  ,120);  
            $pdf->Write(0, $employee_name);
            $pdf->Image($employee_signature,70,100,60,20,"PNG");
                    $pdf->SetXY(150,120);  
            $pdf->Write(0, $completed_date);
            $pdf->SetXY(150,130);  
            $pdf->Write(0, $completed_date);
            $pdf->SetXY(33 ,130);  
            $pdf->Write(0, $staff_name);
            $pdf->Image($staff_signature,70,123,60,20,"PNG");
            $pdf->Output($save_pdf_path,"F");//die();
            // $pdf->Output($save_pdf_path,"I");
         }

        // Home Health positions using RN competency template (RN, Clinical Supervisor, Administrator, HR, Office Manager, Secretary/Receptionist)
        $home_health_rn_template_positions = array('Registered Nurse', 'Clinical Supervisor/Nursing Supervisor', 'Administrator', 'Human Resources', 'Office Manager', 'Secretary/Receptionist');
        if($post['company_applying'] == 'Home Health' && in_array($post['position'], $home_health_rn_template_positions)){
           $date_label=date('F d, Y',strtotime($post['generate_date']));
            $pdf_file = "pdf/com_hm_rn.pdf";

            $pdf = new FPDF();
            $pdf->AddPage();
        
            $pdf = new FPDI();  
            // add a page
            $pdf->setSourceFile($pdf_file);  
            // import page 1  
            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(1);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
             // import page 1  
            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(2);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $pdf->Write(0, ucwords($employee_name));

            $pdf->SetXY(70 ,56);  
            $pdf->Write(0, ucwords($employment_date));
            $pdf->SetXY(145 ,56);  
            $pdf->Write(0, ucwords($completed_date));

             $y = 98    ;
            for ($i=0; $i<=7   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
               
                $y += 7.5;
            }
             $y -=1;
            for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }

             $y +=10;
            for ($i=0; $i<=4   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }

              // import page 1  
            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(3);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=1   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
               
                $y += 7;
            }
               $y += 7;
             for ($i=0; $i<=1   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
               
                $y += 7;
            }
               $y += 7;
             for ($i=0; $i<=0  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date2);
               
                $y += 7;
            }

             $y += 7;
             for ($i=0; $i<=13  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date2);
               
                $y += 7;
            }

              $y += 10;
             for ($i=0; $i<=3  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
               
                $y += 7;
            }

                  // import page 1  
            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(4);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=3   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7;
            }
             $y += 6;
            for ($i=0; $i<=6   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
               
                $y += 7;
            }
           

             $y += 7;
             for ($i=0; $i<=11   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date6);
               
                $y += 7;
            }

              $y += 4;
             for ($i=0; $i<=1   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
               
                $y += 7;
            }
             $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(5);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=7   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
                $y += 7;
            }
             $y += 6;

              for ($i=0; $i<=3   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
                $y += 7;
            }

             $y += 7;

              for ($i=0; $i<=8   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
                $y += 7;
            }

            $y += 5;

              for ($i=0; $i<=3   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
                $y += 7;
            }

             $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(6);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7;
            }   
               $y -= 2;
            for ($i=0; $i<=13   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date2);
                $y += 7;
            }
               $y += 7;
            
            for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }

              $y += 5;
            
            for ($i=0; $i<=1   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }

             $y += 8;
            
            for ($i=0; $i<=6   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }

            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(7);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  
              $y += 7;
            for ($i=0; $i<=8   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7;
            }  

             $y += 9;
            for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7;
            }  

             $y += 8;
            for ($i=0; $i<=2  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
                $y += 7;
            }   

              $y += 7;
            for ($i=0; $i<=3  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
                $y += 7;
            }   


            $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(8);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date4);
                $y += 7;
            }  
              $y += 7;

              for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7;
            }  
              $y += 5;

              for ($i=0; $i<=7   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date5);
                $y += 7.5;
            }  

             $y += 16;

              for ($i=0; $i<=7  ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date2);
                $y += 7;
            } 

              $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(9);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=3   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date2);
                $y += 7;
            }  
           $y += 5; 

            for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  

             $y += 7; 

            for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  

             $y += 7; 

            for ($i=0; $i<=7   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date6);
                $y += 7;
            }  

           $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(10);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=1   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date6);
                $y += 7;
            }  

            for ($i=0; $i<=12   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date3);
                $y += 7;
            }  
               $y += 8;
             for ($i=0; $i<=10   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7.2;
            }  


           $pdf->AddPage();  
            // set the sourcefile  
            $tplIdx = $pdf->importPage(11);  
            // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
            $pdf->useTemplate($tplIdx, 10, 10, 200);  
            // now write some text above the imported page
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',10);  
            $pdf->SetXY(49 ,48);  
            $y = 58    ;
            for ($i=0; $i<=5   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  

            $y += 12;
              for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  
            $y += 11;
            for ($i=0; $i<=0   ;$i++){
              $pdf->SetXY(172,$y);  
              $pdf->Write(0, ucwords($initials)." ".$random_date);
                $y += 7;
            }  


            $pdf->SetXY(150  ,180);  
              $pdf->Write(0, ucwords($completed_date));
             $pdf->SetXY(33  ,180);  

            $pdf->Write(0, $employee_name);
            $pdf->Image($employee_signature,60,165,60,20,"PNG");
            $pdf->SetXY(150,192);  
            $pdf->Write(0, $completed_date);
            $pdf->SetXY(33 ,192   );  
            $pdf->Write(0, $staff_name);
            $pdf->Image($staff_signature,60,180,60,20,"PNG");
              $pdf->Output($save_pdf_path,"F");//die();
          }
      return $pdf_file_name;

  }

function randomDate($startDate, $endDate) {
    $minTimestamp = strtotime($startDate);
    $maxTimestamp = strtotime($endDate);
    $randomTimestamp = rand($minTimestamp, $maxTimestamp);
    $randomDate = date('m/d/Y', $randomTimestamp);
    return $randomDate;
}

function initials($str) {
    $ret = '';
    foreach (explode(' ', $str) as $word)
      if(isset($word[0])){

        $ret .= strtoupper($word[0]);
      }
    return $ret;
}
  
?>