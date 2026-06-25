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
        
        // Default organization to Home Health if not provided
        if (empty($record_details['organization'])) {
          $record_details['organization'] = 'Home Health';
        }

      $pdf_file_path = $record_details['pdf_file_path'];

      $date=date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;

//       echo "<pre>",print_r($post),"</pre>";
// echo $pdf_file_path;die();
//       die();
    // $file_name_pdf =  str_replace("pdf_files/", "pdf_files/WREF_", $pdf_file_path);
    	$date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;
      $file_name_pdf_2 = NULL;
       $name=       $file_name_pdf =  "pdf_files/HCHK_".$first_name." ".$last_name." ".date('Y-m-d').".pdf";
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
       $pdf_file_name = $file_name_pdf;
        if(!empty($_POST['checklist_for']) && $_POST['checklist_for'] == 'Both'){
            $file_name_pdf_2 =  "pdf_files/HCHK_2_".$first_name." ".$last_name." ".date('Y-m-d').".pdf";
            $pdf_file_name .= "**,**".$file_name_pdf_2;
        }

     // echo "<pre>",print_r($_POST),"</pre>";die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        extract($_POST);
        $file_name = "HH_".$first_name." ".$last_name."_1_".$date.".jpg";
   
        // $file_name_pdf =  str_replace("pdf_files/", "pdf_files/HH_", $pdf_file_path);

       // $pdf_jo_file_name = "pdf_files/JO_".$file_name_pdf.' '.date('Y-m-d').'.pdf';
       // $pdf_agr_file_name = "pdf_files/AGR_".$file_name_pdf.' '.date('Y-m-d').'.pdf';

        // var_dump($response3);die();
        // $response = base64_to_jpeg($mySignature,$file_name);
        // $response = base64_to_jpeg($mySignature2,$file_name);
        // $response3 = base64_to_jpeg($mySignature3,$file_name3);
        // var_dump($response3);die();
        // sleep(5);
        $signature_path = 'signatures/'.$file_name;
   
        // if($response){
          // $data = explode(',', $mySignature);
          $query = "UPDATE `tbl_job_applications` SET pcklist_file_path='".$pdf_file_name."' WHERE id='".$ref."'";
          // echo $query;die();
          $result = $conn->query($query);
          // $last_id = $con->insert_id;

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
          // Set name without position - only first and last name
          $post['name'] = ucwords($first_name." ".$last_name);
          // Ensure position is not included in the name
          if (isset($post['position'])) {
            // Remove position from name if it was somehow added
            $post['name'] = str_replace(" (".$post['position'].")", "", $post['name']);
            $post['name'] = str_replace(" / (".$post['position'].")", "", $post['name']);
          }
           // echo $signature_path;die();
         $pdf_result = save_pdf($html,"signatures/".$file_name,$file_name_pdf,$file_name_pdf_2,$post);
          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$email,$name,$date,$post,false,$file_name_pdf,$ref);
          // if($send_mail){
            header("Location: pchk_form.php?ref=".base64_encode($ref)."&s=1");exit;
            
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


  function send_mail($file_name,$email,$name,$date,$post=array(),$receiver=false,$file_name_pdf="",$file_name_pdf_2="",$ref=""){
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
          $subject = "COPIES";
        }else{
          $subject = "PERSONNEL CHECKLIST ORIENTATION FORM - New  form has been received.";
        }
           
      // echo "<pre>",print_r($post),"</pre>";die();
     $m = $html = "";
      // $name = $post['first_name']." ".$post['last_name'];
      unset($post['mySignature-dpi']);
      unset($post['mySignature']);


      if($receiver){
         $m .= "Please keep the attached copies for your records and future reference.<br>";
        
      }else{
         $m .= "You have received new personnel orientation checklist: <br>";
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
//      $message .= "<br>See attachment to read the copy of your personnel orientation checklist, and please keep in your records. <br><br>
// Thank you so much!";
   

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

  function save_pdf($html,$signature1,$file_name_pdf="",$file_name_pdf_2="",$post=array()){

    $date=date('Y-m-d');

// echo "<pre>",print_r($post),"</pre>";die();
    // Default to Home Health if organization is missing
    if (empty($post['checklist_for'])) {
      $post['checklist_for'] = 'Home Health';
    }
    
    if($post['checklist_for'] =='Hospice' || $post['checklist_for'] == 'Both'){
         $pdf_file = 'pdf/ho_checklist.pdf';//$jo_pdf_file;// "pdf/.pdf";

    }else{
          $pdf_file = 'pdf/ho_hc_checklist.pdf';//$jo_pdf_file;// "pdf/.pdf";

    }
     $date_label=date('F d, Y',strtotime($post['date_filled']));
    $path = "signatures/";
    // echo $pdf_file;die();
// echo "<pre>",print_r($post),"</pre>";die();

        // $file_spr_name = $path.$post['spr_name']." ".$date.".jpg";
    // $year = date('Y',strtotime( $);
    // echo $year;die();
    // Check if PDF template exists
    if (!file_exists($pdf_file)) {
      error_log("PDF template not found: " . $pdf_file);
      return false;
    }
    
    $pdf = new FPDI();  
    // add a page
    $pdf->AddPage();  
    // set the sourcefile  
    $pdf->setSourceFile($pdf_file);  
    // import page 1  
    $tplIdx = $pdf->importPage(1);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    if($post['checklist_for'] =='Hospice' ||  $post['checklist_for'] == 'Both'){
       $pdf->SetFont('Arial','',10);  
       $pdf->SetXY(45 ,41);  
       $pdf->Write(0, ucwords($post['name']));
       $pdf->SetXY(138 ,41);  
       $pdf->Write(0, $date_label);


       $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(130 ,61);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_1'])));
       $pdf->SetXY(153 ,61);  
       $pdf->Write(0, ucwords($post['orientation_1']));
       $pdf->SetXY(185 ,61);  
       $pdf->Write(0, ucwords($post['personel_initial_1']));


       $pdf->SetXY(130 ,66);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_2'])));
       $pdf->SetXY(153 ,66);  
       $pdf->Write(0, ucwords($post['orientation_2']));
       $pdf->SetXY(185 ,66);  
       $pdf->Write(0, ucwords($post['personel_initial_2']));


       $pdf->SetXY(130 ,71);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_3'])));
       $pdf->SetXY(153 ,71);  
       $pdf->Write(0, ucwords($post['orientation_3']));
       $pdf->SetXY(185 ,71);  
       $pdf->Write(0, ucwords($post['personel_initial_3']));

       $pdf->SetXY(130 ,76);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_4'])));
       $pdf->SetXY(153 ,76);  
       $pdf->Write(0, ucwords($post['orientation_4']));
       $pdf->SetXY(185 ,76);  
       $pdf->Write(0, ucwords($post['personel_initial_4']));


       $pdf->SetXY(130 ,133);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_5'])));
       $pdf->SetXY(153 ,133);  
       $pdf->Write(0, ucwords($post['orientation_5']));
       $pdf->SetXY(185 ,133);  
       $pdf->Write(0, ucwords($post['personel_initial_5']));

         $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(130 ,138.5);  
       $pdf->Write(0, date('m/d/y',strtotime($post['date_completed_6'])));
       $pdf->SetXY(153 ,138.5);  
       $pdf->Write(0, ucwords($post['orientation_6']));
       $pdf->SetXY(185 ,138.5);  
       $pdf->Write(0, ucwords($post['personel_initial_6']));
      $pdf->AddPage();  
      $tplIdx = $pdf->importPage(2);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
     


       $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(130 ,112.5);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_7'])));
       $pdf->SetXY(153 ,112.5);  
       $pdf->Write(0, ucwords($post['orientation_7']));
       $pdf->SetXY(185 ,112.5);  
       $pdf->Write(0, ucwords($post['personel_initial_7']));

         $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(130 ,117.5);  
       $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_8'])));
       $pdf->SetXY(153 ,117.5);  
       $pdf->Write(0, ucwords($post['orientation_8']));
       $pdf->SetXY(185 ,117.5);  
       $pdf->Write(0, ucwords($post['personel_initial_8']));
            $pdf->Output($file_name_pdf,'F');//exit;

    }

    if($post['checklist_for'] =='Home Health' ||  $post['checklist_for'] == 'Both'){
      if($post['checklist_for'] == 'Both'){
        $pdf_file = 'pdf/ho_hc_checklist.pdf';
         $pdf = new FPDI();  
          // add a page
          $pdf->AddPage();  
          // set the sourcefile  
          $pdf->setSourceFile($pdf_file);  
          // import page 1  
          $tplIdx = $pdf->importPage(1);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
        } else {
          // For Home Health only, use the existing PDF object
          if (!isset($pdf)) {
            $pdf = new FPDI();  
            $pdf->AddPage();  
            $pdf->setSourceFile($pdf_file);  
            $tplIdx = $pdf->importPage(1);  
            $pdf->useTemplate($tplIdx, 10, 10, 200);
          }
        }

            $pdf->SetFont('Arial','',10);  
         $pdf->SetXY(45 ,35);  
         $pdf->Write(0, ucwords($post['name']));
         $pdf->SetXY(148 ,35);  
         $pdf->Write(0, $date_label);


         $pdf->SetFont('Arial','',9);  
         $pdf->SetXY(134 ,56);  
         $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_1'])));
         $pdf->SetXY(157 ,56);  
         $pdf->Write(0, ucwords($post['orientation_1']));
         $pdf->SetXY(189 ,56);  
         $pdf->Write(0, ucwords($post['personel_initial_1']));


         $pdf->SetXY(134 ,61);  
         $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_2'])));
         $pdf->SetXY(157 ,61);  
         $pdf->Write(0, ucwords($post['orientation_2']));
         $pdf->SetXY(189 ,61);  
         $pdf->Write(0, ucwords($post['personel_initial_2']));


         $pdf->SetXY(134 ,66);  
         $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_3'])));
         $pdf->SetXY(157 ,66);  
         $pdf->Write(0, ucwords($post['orientation_3']));
         $pdf->SetXY(189 ,66);  
         $pdf->Write(0, ucwords($post['personel_initial_3']));

         $pdf->SetXY(134 ,71);  
         $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_4'])));
         $pdf->SetXY(157 ,71);  
         $pdf->Write(0, ucwords($post['orientation_4']));
         $pdf->SetXY(189 ,71);  
         $pdf->Write(0, ucwords($post['personel_initial_4']));


         $pdf->SetXY(134 ,120);  
         $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_5'])));
         $pdf->SetXY(157 ,120);  
         $pdf->Write(0, ucwords($post['orientation_5']));
         $pdf->SetXY(189 ,120);  
         $pdf->Write(0, ucwords($post['personel_initial_5']));

           $pdf->SetFont('Arial','',9);  
         $pdf->SetXY(134 ,126);  
         $pdf->Write(0, date('m/d/y',strtotime($post['date_completed_6'])));
         $pdf->SetXY(157 ,126);  
         $pdf->Write(0, ucwords($post['orientation_6']));
         $pdf->SetXY(189 ,126);  
         $pdf->Write(0, ucwords($post['personel_initial_6']));
        $pdf->AddPage();  
        $tplIdx = $pdf->importPage(2);  
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        if($post['checklist_for'] == 'Both'){
           $pdf->Output($file_name_pdf_2,'F');
      }else{
           $pdf->Output($file_name_pdf,'F');
      }
    }
    
    // Ensure PDF is always created for Home Health
    if($post['checklist_for'] == 'Home Health' && !isset($pdf)){
      $pdf = new FPDI();  
      $pdf->AddPage();  
      $pdf->setSourceFile($pdf_file);  
      $tplIdx = $pdf->importPage(1);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);
      
      $pdf->SetFont('Arial','',10);  
      $pdf->SetXY(45 ,35);  
      $pdf->Write(0, ucwords($post['name']));
      $pdf->SetXY(148 ,35);  
      $pdf->Write(0, $date_label);
      
      $pdf->SetFont('Arial','',9);  
      $pdf->SetXY(134 ,56);  
      $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_1'])));
      $pdf->SetXY(157 ,56);  
      $pdf->Write(0, ucwords($post['orientation_1']));
      $pdf->SetXY(189 ,56);  
      $pdf->Write(0, ucwords($post['personel_initial_1']));
      
      $pdf->SetXY(134 ,61);  
      $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_2'])));
      $pdf->SetXY(157 ,61);  
      $pdf->Write(0, ucwords($post['orientation_2']));
      $pdf->SetXY(189 ,61);  
      $pdf->Write(0, ucwords($post['personel_initial_2']));
      
      $pdf->SetXY(134 ,66);  
      $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_3'])));
      $pdf->SetXY(157 ,66);  
      $pdf->Write(0, ucwords($post['orientation_3']));
      $pdf->SetXY(189 ,66);  
      $pdf->Write(0, ucwords($post['personel_initial_3']));
      
      $pdf->SetXY(134 ,71);  
      $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_4'])));
      $pdf->SetXY(157 ,71);  
      $pdf->Write(0, ucwords($post['orientation_4']));
      $pdf->SetXY(189 ,71);  
      $pdf->Write(0, ucwords($post['personel_initial_4']));
      
      $pdf->SetXY(134 ,120);  
      $pdf->Write(0,  date('m/d/y',strtotime($post['date_completed_5'])));
      $pdf->SetXY(157 ,120);  
      $pdf->Write(0, ucwords($post['orientation_5']));
      $pdf->SetXY(189 ,120);  
      $pdf->Write(0, ucwords($post['personel_initial_5']));
      
      $pdf->SetFont('Arial','',9);  
      $pdf->SetXY(134 ,126);  
      $pdf->Write(0, date('m/d/y',strtotime($post['date_completed_6'])));
      $pdf->SetXY(157 ,126);  
      $pdf->Write(0, ucwords($post['orientation_6']));
      $pdf->SetXY(189 ,126);  
      $pdf->Write(0, ucwords($post['personel_initial_6']));
      
      $pdf->AddPage();  
      $tplIdx = $pdf->importPage(2);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
      
      $pdf->Output($file_name_pdf,'F');
    }
     
    return $file_name_pdf;
}