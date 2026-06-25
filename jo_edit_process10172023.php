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
  if(!isset($_SESSION)){
    session_start();
  }
  use \setasign\Fpdi\Fpdi;

    $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $con = $db->Conn();
    $html ="";
        $ref_decode = base64_decode($_POST['ref']);
    

    $sql = "SELECT * FROM `tbl_job_applications`  where id='".$ref_decode."'";
  $result_logged = $con->query($sql);
  $record_details= $result_logged->fetch_assoc();
  $agreement_file = 'pdf/ho_template.pdf';
  $employee_records = array();
  $staff_records = array();
  // echo $ref_decode;
    // echo "<pre>",print_r($_POST),"</pre>";
    // echo "<pre>",print_r($record_details),"</pre>";

    // die();
    if(!empty($_POST)){
        //check recaptcha first
        
      foreach($_POST as $key => &$post_val){
           $_POST[$key] = $con->real_escape_string($post_val);
      }
    	$date= date('Y-m-d',strtotime($_POST['date_filled']));//date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;
       $name=       $file_name_pdf =  $_POST['first_name']." ".$_POST['last_name'];
      $resume_name=$pdf_file_name = "";
       $organization = $record_details['organization'];
        $position = $record_details['position'];
        $post['organization'] =  $record_details['organization'];
        $jo_pdf_file = $jo_pdf_file_2 = $jo_pdf_file_3  = $jo_pdf_file_4= "";
      if($organization == 'Both'){
            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file = 'pdf/jo_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file = 'pdf/jo_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file = 'pdf/jo_vocational_nurse.pdf';
              $jo_pdf_file_3 = 'pdf/jo_pa_lvn.pdf';
            }
            // else if($position == 'Medical Social Worker'){
            //   $jo_pdf_file = 'pdf/jo_medical_social_worker.pdf';
            // }
            else if($position == 'Social Health Aid'){
              $jo_pdf_file = 'pdf/jo_health_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file = 'pdf/jo_registered_nurse.pdf';
               $jo_pdf_file_3 = 'pdf/jo_pa_registered_nurse.pdf';
               $jo_pdf_file_4 = 'pdf/jo_pa_nurse_prac.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file = 'pdf/jo_office_manager.pdf';
            }else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file = 'pdf/jo_receptionist.pdf';
            }else if($position == 'Human Resources'){
              $jo_pdf_file = 'pdf/jo_human_resource.pdf';
            }else if($position == 'Administrator'){
              $jo_pdf_file = 'pdf/jo_admin.pdf';
            }


            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file_2 = 'pdf/jo_hc_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file_2 = 'pdf/jo_hc_lvc.pdf';
            }
            else if($position == 'Medical Social Worker'){
              $jo_pdf_file_2 = 'pdf/jo_hc_medical_social_worker.pdf';
               $jo_pdf_file_3 = 'pdf/jo_pa_social_worker.pdf';
            }
            else if($position == 'Social Health Aid'){
              $jo_pdf_file_2 = 'pdf/jo_hc_hospital_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file_2 = 'pdf/jo_hc_registered_nurse.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file_2 = 'pdf/jo_hc_office_manager.pdf';
            }
            else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file_2 = 'pdf/jo_hc_receptionist.pdf';
            }
            else if($position == 'Bereavement Coordinator'){
              $jo_pdf_file_2 = 'pdf/jo_hc_bereavement.pdf';
            }else if($position == 'Chaplain'){
              $jo_pdf_file_2 = 'pdf/jo_hc_chaplain.pdf';
               $jo_pdf_file_3 = 'pdf/jo_pa_chaplain.pdf';
            }else if($position == 'Referral/Intake Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_intake.pdf';
            }else if($position == 'Social Services Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_social_service_supervisor.pdf';
            }else if($position == 'Volunteer'){
              $jo_pdf_file_2 = 'pdf/jo_hc_volunteer.pdf';
            }
            // else if($position == 'Human Resources'){
            //   $jo_pdf_file_2 = 'pdf/jo_human_resource.pdf';
            // }
            else if($position == 'Medical Director'){
              $jo_pdf_file = 'pdf/jo_hc_medical_director.pdf';
                $jo_pdf_file_2 = 'pdf/jo_pa_physician.pdf';
                 $jo_pdf_file_3 = 'pdf/jo_pa_nurse_prac.pdf';
            }else if($position == 'Managed Care Coordinator'){
              $jo_pdf_file_2 = 'pdf/jo_hc_managed_care.pdf';
            }else if($position == 'Administrator'){
              $jo_pdf_file_2 = 'pdf/jo_hc_admin.pdf';
            }
        }else{
          if($organization == 'Home Health'){

            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file = 'pdf/jo_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file = 'pdf/jo_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file = 'pdf/jo_vocational_nurse.pdf';
            }else if($position == 'Medical Social Worker'){
              $jo_pdf_file = 'pdf/jo_medical_social_worker.pdf';
            }else if($position == 'Social Health Aid'){
              $jo_pdf_file = 'pdf/jo_health_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file = 'pdf/jo_registered_nurse.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file = 'pdf/jo_office_manager.pdf';
            }else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file = 'pdf/jo_receptionist.pdf';
            }else if($position == 'Human Resources'){
              $jo_pdf_file = 'pdf/jo_human_resource.pdf';
            }else if($position == 'Administrator'){
              $jo_pdf_file = 'pdf/jo_admin.pdf';
            }
          }elseif($organization == 'Hospice'){

            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file = 'pdf/jo_hc_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file = 'pdf/jo_hc_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file = 'pdf/jo_hc_lvc.pdf';
                $jo_pdf_file_3 = 'pdf/jo_pa_lvn.pdf';
            }else if($position == 'Medical Social Worker'){
              $jo_pdf_file = 'pdf/jo_hc_medical_social_worker.pdf';
              $jo_pdf_file_3 = 'pdf/jo_pa_social_worker.pdf';
            }else if($position == 'Social Health Aid'){
              $jo_pdf_file = 'pdf/jo_hc_hospital_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file = 'pdf/jo_hc_registered_nurse.pdf';
              $jo_pdf_file_3 = 'pdf/jo_pa_registered_nurse.pdf';
              $jo_pdf_file_4 = 'pdf/jo_pa_nurse_prac.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file = 'pdf/jo_hc_office_manager.pdf';
            }else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file = 'pdf/jo_hc_receptionist.pdf';
            }else if($position == 'Bereavement Coordinator'){
              $jo_pdf_file = 'pdf/jo_hc_bereavement.pdf';
            }else if($position == 'Chaplain'){
              $jo_pdf_file = 'pdf/jo_hc_chaplain.pdf';
              $jo_pdf_file_3 = 'pdf/jo_pa_chaplain.pdf';
            }else if($position == 'Referral/Intake Supervisor'){
              $jo_pdf_file = 'pdf/jo_hc_intake.pdf';
            }else if($position == 'Social Services Supervisor'){
              $jo_pdf_file = 'pdf/jo_hc_social_service_supervisor.pdf';
            }else if($position == 'Volunteer'){
              $jo_pdf_file = 'pdf/jo_hc_volunteer.pdf';
            }else if($position == 'Human Resources'){
              $jo_pdf_file = 'pdf/jo_human_resource.pdf';
            }else if($position == 'Medical Director'){
              $jo_pdf_file = 'pdf/jo_hc_medical_director.pdf';
               $jo_pdf_file_2 = 'pdf/jo_pa_physician.pdf';
              $jo_pdf_file_3 = 'pdf/jo_pa_nurse_prac.pdf';
            }else if($position == 'Managed Care Coordinator'){
              $jo_pdf_file = 'pdf/jo_hc_managed_care.pdf';
            }else if($position == 'Administrator'){
              $jo_pdf_file = 'pdf/jo_hc_admin.pdf';
            }
          }

        }

      if(isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])){
        $file_name  = $_FILES['resume']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $tmp_name = $_FILES["resume"]["tmp_name"];

        // var_dump($_FILES);die();
        $resume_name = $_POST['first_name']." ".$_POST['last_name'].$timestamp.".".$ext;
      // echo $tmp_name;die();
            move_uploaded_file($tmp_name, "resume_files/".$resume_name);
        // $file_name = 
      }
        $pdf_consent_file = 'pdf_files/LEG_'.$_POST['first_name']." ".$_POST['last_name'].".pdf";

     // echo "<pre>",print_r($_POST),"</pre>";die();
     // echo "<pre>",print_r($_FILES),"</pre>";
     // die();
        extract($_POST);
        $file_name = $_POST['first_name']." ".$_POST['last_name']."_1_".$date.".jpg";
        $file_name2 = $_POST['first_name']." ".$_POST['last_name']."_2_".$date.".jpg";
        $file_name3 = $_POST['first_name']." ".$_POST['last_name']."_3_".$date.".jpg";
        $pdf_file_name = "pdf_files/".$file_name_pdf.' '.date('Y-m-d').'.pdf';

        // var_dump($response3);die();
        // $response = base64_to_jpeg($mySignature,$file_name);
        // $response = base64_to_jpeg($mySignature2,$file_name);
        // $response3 = base64_to_jpeg($mySignature3,$file_name3);
        // var_dump($response3);die();
        sleep(4);
        $signature_path = 'signatures/'.$file_name;
        $work_currently_chk_1 = $work_currently_chk_2 = $work_currently_chk_3 = NULL;
        $hepa_agree_field = NULL;
        $post['hepa'] = $record_details['hepa'];
        // if(isset($hepa_agree) && $hepa_agree == 'on'){
        //   $hepa_agree_field = "agree";
        // }else{
        //    $hepa_agree_field = "disagree";
        // }

        // if($response){
          // $data = explode(',', $mySignature);
          // $data2= explode(",", $mySignature2);
          $query = "UPDATE `tbl_job_applications` set `first_name` = '".$first_name."' ,`last_name`='".$last_name."',`middle_initial`='".$mi_name."',`date_of_birth`='".$date_of_birth."',`sss_number`='".$sss_number."',`email`='".$email."',`telephone_no`='".$tel_no."',`street_address`='".$street_address."',`city`='".$city."',`state`='".$state."',`zip_code`='".$zip_code."',`drivers_license`='".$driver_license_no."',`dl_state`='".$dl_state."',`dl_expiration_date`='".$dl_expiration."',`position`='".$position."',`organization`='".$company_applying."',`school_name_1`='".$school_1."',`school_major_1`='".$major_degree_1."',`school_field_1`='".$certificate_1."',`school_from_1`='".$years_from_1."',`school_to_1`='".$years_to_1."',`school_name_2`='".$school_2."',`school_major_2`='".$major_degree_2."',`school_field_2`='".$certificate_2."',`school_from_2`='".$years_from_2."',`school_to_2`='".$years_to_2."',`prof_ref_name_1`='".$prof_name_2."',`prof_ref_company_1`='".$prof_company_1."',`prof_ref_tel_1`='".$prof_telno_1."',`prof_ref_name_2`='".$prof_name_2."',`prof_ref_company_2`='".$prof_company_2."',`prof_ref_tel_2`='".$prof_telno_2."',`emergency_name`='".$emergency_name_1."',`emergency_relationship`='".$emergency_relationship_1."',`emergency_telephone`='".$emergency_no_1."',`work_job_title_1`='".$work_job_title_1."',`work_company_name_1`='".$work_company_name_1."',`work_location_1`='".$work_location_1."',`work_from_1`='".$work_date_from_1."',`work_to_1`='".$work_date_to_1."',`work_is_currently_1`='".$work_currently_chk_1."',`work_job_title_2`='".$work_job_title_2."',`work_company_name_2`='".$work_company_name_2."',`work_location_2`='".$work_location_2."',`work_from_2`='".$work_date_from_2."',`work_to_2`='".$work_date_to_2."',`work_is_currently_2`='".$work_currently_chk_2."',`work_job_title_3`='".$work_job_title_3."',`work_company_name_3`='".$work_company_name_3."',`work_location_3`='".$work_location_3."',`work_from_3`='".$work_date_from_3."',`work_to_3`='".$work_date_to_3."',`work_is_currently_3`='".$work_currently_chk_3."',`work_role_1`='".$work_duties_1."',`work_role_2`='".$work_duties_2."',`work_role_3`='".$work_duties_3."',`gq_1`='".$gq_usa."',`gq_2`='".$gq_health."',`gq_3`='".$gq_license."',`resume_file_path`='".$resume_name."',`pdf_file_path`='".$pdf_file_name."',`date_filled`='".$date_filled."',`legal_consent_path` = '".$pdf_consent_file."' where id='".$ref_decode."'";
          // echo $query;die();
          $result = $con->query($query);

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
           $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;

           
         // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);
          save_pdf($html, $record_details['signature_path'],$record_details['signature_path'],$record_details['signature_path'],$file_name_pdf,$pdf_consent_file,$post);
             $pdf_file_path = $record_details['pdf_file_path'];

        $file_name = "JO_".$first_name." ".$last_name."_1_".$date.".jpg";

        $file_name2 = $first_name." ".$last_name."_2_".$date.".jpg";

        $file_name3 ="JO_".$first_name." ".$last_name."_3_".$date.".jpg";

       $pdf_jo_file_name = "JO_".$first_name." ".$last_name.' '.date('Y-m-d').'.pdf';
       $pdf_jo_file_name_2 =  $pdf_jo_file_name_3 =  $pdf_jo_file_name_4 = "";
       if(!empty($jo_pdf_file_2)){

       $pdf_jo_file_name_2 = "JO_2_".$first_name." ".$last_name.' '.date('Y-m-d').'.pdf';
       }

       if(!empty($jo_pdf_file_3)){

       $pdf_jo_file_name_3 = "JO_3_".$first_name." ".$last_name.' '.date('Y-m-d').'.pdf';
       }

       if(!empty($jo_pdf_file_4)){

       $pdf_jo_file_name_4 = "JO_4_".$first_name." ".$last_name.' '.date('Y-m-d').'.pdf';
       }

       $pdf_agr_file_name = "pdf_files/AGR_".$file_name_pdf.' '.date('Y-m-d').'.pdf';

      
          $query = "UPDATE `tbl_job_applications` SET has_agreement_job='true',jo_file_path='pdf_files/".$pdf_jo_file_name."',jo_agreement_file_path='".$pdf_agr_file_name."' WHERE id='".$ref_decode."'";

          // echo $query;die();

          $result = $con->query($query);

              $file_name = "HH_".$first_name." ".$last_name."_1_".$date.".jpg";

   

         $file_name_pdf =  str_replace("pdf_files/", "pdf_files/HH_", $pdf_file_path);

        $file_name_pdf_2 = $file_name_pdf_3 = NULL;
          if($organization == 'Both'){
               $file_name_pdf_2 =  str_replace("pdf_files/", "pdf_files/HH_2_", $pdf_file_path);
         }

           if($organization == 'Both' || $organization == 'Hospice'){
               $file_name_pdf_3 =  str_replace("pdf_files/", "pdf_files/HH_3_", $pdf_file_path);
           }

         $query = "UPDATE `tbl_job_applications` SET hh_file_path='".$file_name_pdf."' WHERE id='".$ref_decode."'";

          // echo $query;die();

          $result = $con->query($query);
          $post['name'] = ucwords($first_name." ".$last_name);

           save_pdf2($html,$mySignature, $record_details['signature_path'], $record_details['signature_path'],$pdf_jo_file_name,$pdf_jo_file_name_2 ,$pdf_jo_file_name_3, $pdf_jo_file_name_4,$pdf_agr_file_name,$jo_pdf_file,$jo_pdf_file_2,$jo_pdf_file_3,$jo_pdf_file_4,$file_name_pdf,$file_name_pdf_2,$file_name_pdf_3,$post);


          // $send_mail =send_mail($file_name,$_POST['email'],$name,$date,$_POST,false,$pdf_consent_file);
          // if($send_mail){
            header("Location: job_application_edit_form.php?ref=".$_POST['ref']."&s=1");exit;
            
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
          $subject = "Copies";
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
         $m .= "";//"You have recently signed a job application. Attached is the copy of pdf form with application details <br>";
        
      }else{
         $m .= "";//"You have received new job application form: <br>";
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


  function save_pdf($html,$signature1,$signature2,$signature3,$name="",$pdf_consent_file="",$post=array()){

    $pdf_file = "pdf/job_application_template.pdf";
    $pdf_file_cons = "pdf/legal_consent_template.pdf";
    $date=date('Y-m-d');
     $date_label=date('F d, Y',strtotime($post['date_filled']));
    $path = "signatures/";

    $placed_signature = "";

    if(strlen($signature1) > 0){
      $placed_signature = $signature1;
    }

    if(strlen($signature2) > strlen($signature1) ){
      $placed_signature = $signature2;
    }

     if(strlen($signature3) > strlen($signature2) ){
      $placed_signature = $signature3;
    }


    // echo "<pre>",print_r($post),"</pre>";die();
  //  echo "<img src='".$signature1."'>";die();
// echo $signature1;die();
      // $img = explode(',',$signature1,2)[1];
    // $signature1 = 'data://text/plain;base64,'. $img;

     $pdf = new FPDF();
    $pdf->AddPage();
  // $pdf->Image($pic, 10,30,0,0,'png');
// echo $signature1;die();
    $pdf = new FPDI();  
    // add a page
    $pdf->AddPage();  
    // set the sourcefile  
    $pdf->setSourceFile($pdf_file_cons);  
    // import page 1  
    $tplIdx = $pdf->importPage(1);  
    // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // now write some text above the imported page
    $pdf->SetTextColor(0,0,0);

    $pdf->SetFont('Arial','',10);  
    $pdf->SetXY(37 ,57);  
    $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
     $pdf->SetFont('Arial','',10);  
    // $pdf->SetXY(34 ,121);  
    // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
    $pdf->Image($signature2,25,95,100,40,"PNG");
       // $pdf->Image($signature2,25,140,100,40,"PNG");
       // $pdf->Image($signature3,25,175,100,40,"PNG");
     $pdf->SetXY(138,121);  
    $pdf->Write(0, $date_label);
            // $pdf->Image($signature2,25,140,100,40,"PNG");
            // $pdf->Image($signature3,25,160,100,40,"PNG");
// echo $pdf_consent_file;die();
    $pdf->Output($pdf_consent_file,'F');//exit;


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
    // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // now write some text above the imported page
    $pdf->SetTextColor(0,0,0);
  
    $pdf_file_name = "pdf_files/".$name.' '.$date.'.pdf';
       // echo "<pre>",print_r($post),"</pre>";die();

    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(22 ,44);  
    $pdf->Write(0, $post['first_name']);
     $pdf->SetXY(82     ,44);  
    $pdf->Write(0, $post['last_name']);
    $pdf->SetXY(142 ,44);  
    $pdf->Write(0, $post['mi_name']);
    $pdf->SetXY(160 ,44);  
    $pdf->Write(0, $date_label);

    $pdf->SetXY(22 ,54);  
    $pdf->Write(0, date('F d, Y',strtotime($post['date_of_birth'])));
    $pdf->SetXY(53 ,54);  
    $pdf->Write(0, $post['sss_number']);
    $pdf->SetXY(93 ,54);  
    $pdf->Write(0, $post['email']);
    $pdf->SetXY(150 ,54);  
    $pdf->Write(0, $post['tel_no']);

    $pdf->SetXY(22 ,61);  
    $pdf->MultiCell( 58, 3,$post['street_address'],0,'L');
    $pdf->SetXY(82 ,64);  
    $pdf->Write(0, $post['city']);
    $pdf->SetXY(135 ,64);  
    $pdf->Write(0, $post['state']);
    $pdf->SetXY(160 ,64);  
    $pdf->Write(0, $post['zip_code']);

    $pdf->SetXY(22 ,72);  
    $pdf->MultiCell( 58, 3,$post['driver_license_no'],0,'L');
    $pdf->SetXY(82 ,74);  
    $pdf->Write(0, $post['dl_state']);
    $pdf->SetXY(103 ,74);  
    $pdf->Write(0, $post['dl_expiration']);
    $pdf->SetXY(134 ,72);  
        $pdf->MultiCell( 66, 3,ucwords(str_replace("_", " ",$post['position'])),0,'L');

    // $pdf->Write(0, ucwords(str_replace("_", " ",$post['position'])));


    $pdf->SetXY(22 ,88);  
    $pdf->MultiCell( 58, 3,$post['school_1'],0,'L');
    $pdf->SetXY(71,90);  
    $pdf->Write(0, str_replace("\\", "", $post['major_degree_1']));
    $pdf->SetXY(105 ,90);  
    $pdf->Write(0, $post['certificate_1']);
    $pdf->SetXY(143,90);  
    $pdf->Write(0, $post['years_from_1']);
    $pdf->SetXY(173 ,90);  
    $pdf->Write(0, $post['years_to_1']);



    $pdf->SetXY(22 ,100);  
    $pdf->MultiCell( 58, 3,$post['school_2'],0,'L');
    $pdf->SetXY(71,102);  
    $pdf->Write(0, $post['major_degree_2']);
    $pdf->SetXY(105 ,102);  
    $pdf->Write(0, $post['certificate_2']);
    $pdf->SetXY(143,102);  
    $pdf->Write(0, $post['years_from_2']);
    $pdf->SetXY(173 ,102);  
    $pdf->Write(0, $post['years_to_2']);


    $pdf->SetXY(22 ,116); 
    $pdf->Write(0, $post['emergency_name_1']);
    $pdf->SetXY(82,116);  
    $pdf->Write(0, $post['emergency_relationship_1']);
    $pdf->SetXY(135 ,116);  
    $pdf->Write(0, $post['emergency_no_1']);

    $pdf->SetXY(22 ,132); 
    $pdf->Write(0, $post['work_job_title_1']);
    $pdf->SetXY(112,132);  
    $pdf->Write(0, $post['work_company_name_1']);
    $pdf->SetXY(22 ,141);  
    $pdf->Write(0, $post['work_location_1']);
     
    if(isset($post['work_currently_chk_1'])){
      $pdf->SetFont('zapfdingbats', '', 13);

         $pdf->SetXY(194 ,136);  
        $pdf->Write(0, "4");
    }else{
       $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(157 ,141);  
       $pdf->Write(0,date('F d, Y',strtotime($post['work_date_to_1'])));
    }
     $pdf->SetFont('Arial','',9);  
      $pdf->SetXY(112 ,141);  
      $pdf->Write(0,date('F d, Y',strtotime($post['work_date_from_1'])));
     $pdf->SetXY(22 ,150);  
     if(strlen($post['work_duties_1']) > 100){
        $pdf->MultiCell( 175, 3,'Job Role description attached on next page',0,'L');
     }else{

        $pdf->MultiCell( 175, 3,$post['work_duties_1'],0,'L');
     }
   


    $pdf->SetXY(22 ,163); 
    $pdf->Write(0, $post['work_job_title_2']);
    $pdf->SetXY(112,163);  
    $pdf->Write(0, $post['work_company_name_2']);
    $pdf->SetXY(22 ,173);  
    $pdf->Write(0, $post['work_location_2']);
     
    if(isset($post['work_currently_chk_2'])){
      $pdf->SetFont('zapfdingbats', '', 13);

         $pdf->SetXY(194 ,166.5);  
        $pdf->Write(0, "4");
    }else{
       $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(157 ,173);  
       if(!empty($post['work_date_to_2'])){

        $pdf->Write(0,date('F d, Y',strtotime($post['work_date_to_2'])));
       }
    }
     $pdf->SetFont('Arial','',9);  
      $pdf->SetXY(112 ,173);  
      if(!empty($post['work_date_from_2'])){

        $pdf->Write(0,date('F d, Y',strtotime($post['work_date_from_2'])));
      }
     $pdf->SetXY(22 ,181);  
       if(strlen($post['work_duties_2']) > 100){
        $pdf->MultiCell( 175, 3,'Job Role description attached on next page',0,'L');
     }else{

        $pdf->MultiCell( 175, 3,$post['work_duties_2'],0,'L');
     }
   
     // $pdf->MultiCell( 175, 3,$post['work_duties_2'],0,'L');


    $pdf->SetXY(22 ,193); 
    $pdf->Write(0, $post['work_job_title_3']);
    $pdf->SetXY(112,193);  
    $pdf->Write(0, $post['work_company_name_3']);
    $pdf->SetXY(22 ,203);  
    $pdf->Write(0, $post['work_location_3']);
     
    if(isset($post['work_currently_chk_3'])){
      $pdf->SetFont('zapfdingbats', '', 13);

         $pdf->SetXY(194 ,198);  
        $pdf->Write(0, "4");
    }else{
       $pdf->SetFont('Arial','',9);  
       $pdf->SetXY(157 ,203);  
       if(!empty($post['work_date_to_3'])){

         $pdf->Write(0,date('F d, Y',strtotime($post['work_date_to_3'])));
       }
    }
     $pdf->SetFont('Arial','',9);  
      $pdf->SetXY(112 ,203);  
      if(!empty($post['work_date_from_3'])){

      $pdf->Write(0,date('F d, Y',strtotime($post['work_date_from_3'])));
      }
     $pdf->SetXY(22 ,212);  
       if(strlen($post['work_duties_3']) > 100){
        $pdf->MultiCell( 175, 3,'Job Role description attached on next page',0,'L');
     }else{

        $pdf->MultiCell( 175, 3,$post['work_duties_3'],0,'L');
     }
     // $pdf->MultiCell( 214, 3,$post['work_duties_3'],0,'L');

    // $pdf->Output($pdf_file_name,'I');exit;

        $pdf->SetFont('zapfdingbats', '', 12);

        //  $pdf->SetXY(50 ,251);  
        // $pdf->Write(0, "4");


        //  $pdf->SetXY(59.5 ,251);  
        // $pdf->Write(0, "4");

        if($post['gq_usa'] == 'yes'){
           $pdf->SetXY(143 ,224);  
          $pdf->Write(0, "4");
        }else{
            $pdf->SetXY(152.5 ,224);  
        $pdf->Write(0, "4");
        }

        if($post['gq_health'] == 'yes'){
           $pdf->SetXY(100 ,236);  
           $pdf->Write(0, "4");
    
        }else{

         $pdf->SetXY(110 ,236);  
         $pdf->Write(0, "4");
        }

         if($post['gq_license'] == 'agr' || $post['gq_license'] == "yes"){
           $pdf->SetXY(50 ,248);  
           $pdf->Write(0, "4");
    
        }else{

         $pdf->SetXY(59.5 ,248);  
         $pdf->Write(0, "4");
        }
        if(strlen($post['work_duties_1']) > 100 || strlen($post['work_duties_2'])  > 100 || strlen($post['work_duties_3'])  > 100 ){
                $pdf->AddPage(); 
                $pdf->SetFont('Arial','',10); 
                $next_yy = 30;
                if(strlen($post['work_duties_1']) > 100){
                    $pdf->SetXY(28 ,$next_yy); 
                     $pdf->MultiCell( 175, 3,$post['work_company_name_1'] . ': '.$post['work_duties_1'],0,'L');
                    $next_yy  = 80;
                }
                 if(strlen($post['work_duties_2']) > 100){
                    $pdf->SetXY(28 ,$next_yy); 
                     $pdf->MultiCell( 175, 3,$post['work_company_name_2'] . ': '.$post['work_duties_2'],0,'L');
                    $next_yy  = 150;
                }
                 if(strlen($post['work_duties_3']) > 100){
                    $pdf->SetXY(28 ,$next_yy); 
                     $pdf->MultiCell( 175, 3,$post['work_company_name_3'] . ': '.$post['work_duties_3'],0,'L');
                    // $next_yy  = 150;
                }

        }
         // import page 1  
         $pdf->AddPage();  
        $tplIdx = $pdf->importPage(2);  
            $pdf->Image($placed_signature,35,175,100,40,"PNG");
        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(134 ,202);  
         $pdf->Write(0, $date_label);
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
            $pdf->AddPage();  
        $tplIdx = $pdf->importPage(3);  
        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
            $pdf->SetXY(54 ,43); 
           $pdf->Write(0, $post['prof_name_1']);
           $pdf->SetXY(45 ,53); 
           $pdf->Write(0, $post['prof_company_1']);
            $pdf->SetXY(142 ,53); 
           $pdf->Write(0, $post['prof_telno_1']);
            $pdf->Image($placed_signature,50,70,80,25,"PNG");
            $pdf->SetXY(135 ,90); 
           $pdf->Write(0,$date_label);
            $pdf->AddPage();  
        $tplIdx = $pdf->importPage(4);  

        // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
           $pdf->SetXY(54 ,43); 
           $pdf->Write(0, $post['prof_name_2']);
           $pdf->SetXY(45 ,53); 
           $pdf->Write(0, $post['prof_company_2']);
            $pdf->SetXY(142 ,53); 
           $pdf->Write(0, $post['prof_telno_2']);
            $pdf->Image($placed_signature,50,70,80,25,"PNG");
            $pdf->SetXY(135 ,89); 
           $pdf->Write(0,$date_label);



    $date = date('mdY');

    $pdf->Output($pdf_file_name,'F');//exit;

     $pdf = new FPDI();  
    // add a page
    $pdf->AddPage();  
    // set the sourcefile  
    $pdf->setSourceFile('pdf/hbv_form.pdf');  
    // echo "adsa";die();
    // import page 1  
    $tplIdx = $pdf->importPage(1);  
    // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // now write some text above the imported page
    $pdf->SetTextColor(0,0,0);
  
       // echo "<pre>",print_r($post),"</pre>";die();
  $pdf->SetFont('zapfdingbats', '', 12);
if(isset($post['hepa']) && $post['hepa']=="no"){
     $pdf->SetXY(21 ,208.5);  
        $pdf->Write(0, "4");
}else{
    $pdf->SetXY(21 ,161.5);  
        $pdf->Write(0, "4");
}
         
        
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(32 ,245);  
    $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
                $pdf->Image($placed_signature,145,230,60,20,"PNG");
     $pdf->SetXY(108,245);  
    $pdf->Write(0, $date_label);
    // echo $signature3;die();

    $pdf_file_name = "pdf_files/HBV_".$name.' '.date('Y-m-d').'.pdf';
        $pdf->Output($pdf_file_name,'F');//exit;
    return $pdf_file_name;

  }



  function save_pdf2($html,$signature1,$signature2,$signature3,$name="",$pdf_jo_file_name_2="",$pdf_jo_file_name_3="",$pdf_jo_file_name_4="",$agr_name="",$jo_pdf_file="",$jo_pdf_file_2="",$jo_pdf_file_3="",$jo_pdf_file_4="",$ack_pdf_file="",$ack_2_pdf_file="",$ack_3_pdf_file="",$post=array()){
// echo "adsa";die();
    // echo $name;die();

    $pdf_file =$jo_pdf_file;// "pdf/.pdf";
// echo $name;die();
    $date=date('Y-m-d');

     $date_label=date('F d, Y',strtotime($post['date_filled']));

    $path = "signatures/";

    // echo $pdf_file;die();

  $placed_signature = "";

    if(strlen($signature1) > 0){
      $placed_signature = $signature1;
    }

    if(strlen($signature2) > strlen($signature1) ){
      $placed_signature = $signature2;
    }

     if(strlen($signature3) > strlen($signature2) ){
      $placed_signature = $signature3;
    }

// echo $pdf_file;die();
        // $file_spr_name = $path.$post['spr_name']." ".$date.".jpg";

    // $year = date('Y',strtotime( $);

    // echo $year;die();

    $pdf = new FPDI();  

    // add a page

    // $pdf->AddPage();  

    // set the sourcefile  
// var_dump($jo_pdf_file);die();
    $pdf->setSourceFile($pdf_file);  

    // import page 1  
    $get_dimensions = get_x_y_dimensions($pdf_file);
    for($x=1;$x<=$get_dimensions['num_pages'];$x++){
          $pdf->AddPage();
         $tplIdx = $pdf->importPage($x);  
          $pdf->useTemplate($tplIdx, 10, 10, 200);  
          $pdf->SetTextColor(0,0,0);

          if($x === $get_dimensions['num_pages']){
            $pdf->Image($placed_signature,$get_dimensions['sig_x'],$get_dimensions['sig_y'],60,20,"PNG");

            $pdf->SetFont('Arial','',9);  
            $pdf->SetXY($get_dimensions['label_x'],$get_dimensions['label_y']);  
            $pdf->Write(0, $date_label);
          }
    }

      $pdf_file_name = "pdf_files/".$name;
 // echo $pdf_file;die();
      // var_dump($placed_signature);die();
      $pdf->Output($pdf_file_name,'F');//exit;


      if(!empty($jo_pdf_file_2)){
            $pdf = new FPDI();  
            // echo $jo_pdf_file_2;die();
        // add a page

        // $pdf->AddPage();  

        // set the sourcefile  

        $pdf->setSourceFile($jo_pdf_file_2);  

        // import page 1  
        $get_dimensions = get_x_y_dimensions($jo_pdf_file_2);
        for($x=1;$x<=$get_dimensions['num_pages'];$x++){
              $pdf->AddPage();
             $tplIdx = $pdf->importPage($x);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->SetTextColor(0,0,0);

              if($x === $get_dimensions['num_pages']){
                $pdf->Image($placed_signature,$get_dimensions['sig_x'],$get_dimensions['sig_y'],60,20,"PNG");

                $pdf->SetFont('Arial','',9);  
                $pdf->SetXY($get_dimensions['label_x'],$get_dimensions['label_y']);  
                $pdf->Write(0, $date_label);
              }
        }

          $pdf_file_name = "pdf_files/".$pdf_jo_file_name_2;

         $pdf->Output($pdf_file_name,'F');//exit;
      }

      if(!empty($jo_pdf_file_3)){
            $pdf = new FPDI();  
       

        $pdf->setSourceFile($jo_pdf_file_3);  

        // import page 1  
        $get_dimensions = get_x_y_dimensions($jo_pdf_file_3);
        // echo "<pre>",print_r($get_dimensions),"</pre>";die();
        // echo $jo_pdf_file_3;die();
        for($x=1;$x<=$get_dimensions['num_pages'];$x++){
              $pdf->AddPage();
             $tplIdx = $pdf->importPage($x);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->SetTextColor(0,0,0);

              if($x === $get_dimensions['num_pages']){
                $pdf->Image($placed_signature,$get_dimensions['sig_x'],$get_dimensions['sig_y'],60,20,"PNG");

                $pdf->SetFont('Arial','',9);  
                $pdf->SetXY($get_dimensions['label_x'],$get_dimensions['label_y']);  
                $pdf->Write(0, $date_label);
              }
        }

            $pdf_file_name = "pdf_files/".$pdf_jo_file_name_3;

         $pdf->Output($pdf_file_name,'F');//exit;
      }   
        if(!empty($jo_pdf_file_4)){
            $pdf = new FPDI();  
       

        $pdf->setSourceFile($jo_pdf_file_4);  

        // import page 1  
        $get_dimensions = get_x_y_dimensions($jo_pdf_file_4);
        // echo "<pre>",print_r($get_dimensions),"</pre>";die();
        // echo $jo_pdf_file_3;die();
        for($x=1;$x<=$get_dimensions['num_pages'];$x++){
              $pdf->AddPage();
             $tplIdx = $pdf->importPage($x);  
              $pdf->useTemplate($tplIdx, 10, 10, 200);  
              $pdf->SetTextColor(0,0,0);

              if($x === $get_dimensions['num_pages']){
                $pdf->Image($placed_signature,$get_dimensions['sig_x'],$get_dimensions['sig_y'],60,20,"PNG");

                $pdf->SetFont('Arial','',9);  
                $pdf->SetXY($get_dimensions['label_x'],$get_dimensions['label_y']);  
                $pdf->Write(0, $date_label);
              }
        }

          $pdf_file_name = "pdf_files/".$pdf_jo_file_name_4;

         $pdf->Output($pdf_file_name,'F');//exit;
      }


       //exit;//exit;
    // echo "<pre>",print_r($get_dimensions),"</pre>";die();
   


       // echo "<pre>",print_r($post),"</pre>";die();



    //   $pdf_file_name=$name;

    // $pdf->Output($pdf_file_name,'F');//exit;



     $pdf = new FPDI();  

    // add a page

    $pdf->AddPage();  

    // set the sourcefile  

    $pdf->setSourceFile('pdf/job_agreement.pdf');  

    // echo "adsa";die();

    // import page 1  

    $tplIdx = $pdf->importPage(1);  

    // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)

    $pdf->useTemplate($tplIdx, 10, 10, 200);  

    // now write some text above the imported page

    $pdf->SetTextColor(0,0,0);

         

        
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

    $pdf->AddPage();
    $tplIdx = $pdf->importPage(2);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);     
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


    $pdf->AddPage();
    $tplIdx = $pdf->importPage(3);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


    $pdf->AddPage();
    $tplIdx = $pdf->importPage(4);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

     $pdf->AddPage();
    $tplIdx = $pdf->importPage(5);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

     $pdf->AddPage();
    $tplIdx = $pdf->importPage(6);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

     $pdf->AddPage();
    $tplIdx = $pdf->importPage(7);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

     $pdf->AddPage();
    $tplIdx = $pdf->importPage(8);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");

     $pdf->AddPage();
    $tplIdx = $pdf->importPage(9);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


     $pdf->AddPage();
    $tplIdx = $pdf->importPage(10);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


     $pdf->AddPage();
    $tplIdx = $pdf->importPage(11);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  
    $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


    //  $pdf->AddPage();
    // $tplIdx = $pdf->importPage(12);  
    // $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // $pdf->SetTextColor(0,0,0);
    // $pdf->SetFont('Arial','',9);  
    // $pdf->SetXY(184 ,258);  
    // // $pdf->Write(0, ucwords($post['initial']));
    // // $pdf->Image($signature3,145,260,60,20,"PNG");



    //  $pdf->AddPage();
    // $tplIdx = $pdf->importPage(13);  
    // $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // $pdf->SetTextColor(0,0,0);
    // $pdf->SetFont('Arial','',9);  
    // $pdf->SetXY(184 ,258);  
    // // $pdf->Write(0, ucwords($post['initial']));
    // // $pdf->Image($signature3,145,260,60,20,"PNG");

    //  $pdf->AddPage();
    // $tplIdx = $pdf->importPage(14);  
    // $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // $pdf->SetTextColor(0,0,0);
    // $pdf->SetFont('Arial','',9);  
    // $pdf->SetXY(184 ,258);  
    // // $pdf->Write(0, ucwords($post['initial']));
    // // $pdf->Image($signature3,145,260,60,20,"PNG");


    //  $pdf->AddPage();
    // $tplIdx = $pdf->importPage(15);  
    // $pdf->useTemplate($tplIdx, 10, 10, 200);  
    // $pdf->SetTextColor(0,0,0);
    // $pdf->SetFont('Arial','',9);  
    // $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
    // $pdf->Image($signature3,145,260,60,20,"PNG");


     $pdf->AddPage();
    $tplIdx = $pdf->importPage(12);  
    $pdf->useTemplate($tplIdx, 10, 10, 200);  
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);  

    $pdf->SetXY(26 ,224);  
    $pdf->Write(0, ucwords($post['name']));
    $pdf->Image($placed_signature,70,214,60,20,"PNG");
    $pdf->SetXY(155 ,224);  
    $pdf->Write(0, $date_label);



    // $pdf->SetXY(26 ,251);  
    // $pdf->Write(0, ucwords($post['name']));
    // $pdf->Image($placed_signature,70,241,60,20,"PNG");
    // $pdf->SetXY(155 ,251);  
    // $pdf->Write(0, $date_label);

    // $pdf->SetXY(184 ,258);  
    // $pdf->Write(0, ucwords($post['initial']));
     // $pdf->SetXY(108,245);  
    // $pdf->Write(0, date('F d, Y',strtotime(date('Y-m-d'))));
    // echo $signature3;die();
// echo $agr_name;die();
    $pdf_file_name = $agr_name;//"pdf_files/HBV_".$name.' '.date('Y-m-d').'.pdf';
        $pdf->Output($pdf_file_name,'F');//exit;





    if($post['organization'] == 'Both'){
      $pdf_file = 'pdf/ho_hc_template.pdf';
      $pdf_file2 = 'pdf/ho_template.pdf';
      $pdf_file3 = 'pdf/pa_template.pdf';
    }else{

      if($post['organization'] == 'Hospice'){
       $pdf_file = 'pdf/ho_hc_template.pdf';
        $pdf_file3 = 'pdf/pa_template.pdf';
      }else{

      $pdf_file = 'pdf/ho_template.pdf';//$jo_pdf_file;// "pdf/.pdf";
      }
    }


    $date=date('Y-m-d');

     $date_label=date('F d, Y',strtotime($post['date_filled']));

    // $path = "signatures/";

    // echo $pdf_file;die();



        // $file_spr_name = $path.$post['spr_name']." ".$date.".jpg";

    // $year = date('Y',strtotime( $);

    // echo $year;die();

    $pdf = new FPDI();  

    // add a page

    $pdf->AddPage();  

    // echo $pdf_file;die();

    // set the sourcefile  

    $pdf->setSourceFile($pdf_file);  

    // import page 1  

    $tplIdx = $pdf->importPage(1);  

    $pdf->useTemplate($tplIdx, 10, 10, 200);  

   

     $pdf->SetFont('Arial','',10);  

    $pdf->SetXY(55 ,54);  


    if($post['organization'] == 'Both'){
       $pdf->Write(0, ucwords($post['name']));

       $pdf->Image($placed_signature,50,200,60,20,"PNG");

       $pdf->SetXY(155 ,212);  

       $pdf->Write(0, $date_label);
       // echo $pdf_file . " ".$pdf_file2;die();
         $pdf->Output($ack_pdf_file,'F');//exit;
        $pdf = new FPDI();  
        $pdf->AddPage();  
        $pdf->setSourceFile($pdf_file2);  
        $tplIdx = $pdf->importPage(1);  
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(55 ,54);  

     
       $pdf->Write(0, ucwords($post['name']));

       $pdf->Image($placed_signature,50,198,60,20,"PNG");

       $pdf->SetXY(155 ,213);  

       $pdf->Write(0, $date_label);
          $pdf->Output($ack_2_pdf_file,'F');//exit;

    }else{

      if($post['organization'] == 'Hospice'){
      
       $pdf->Write(0, ucwords($post['name']));

       $pdf->Image($placed_signature,50,200,60,20,"PNG");

       $pdf->SetXY(155 ,212);  

       $pdf->Write(0, $date_label);
      }else{

     
       $pdf->Write(0, ucwords($post['name']));

       $pdf->Image($placed_signature,50,198,60,20,"PNG");

       $pdf->SetXY(155 ,213);  

       $pdf->Write(0, $date_label);
      }
       $pdf->Output($ack_pdf_file,'F');//exit;
    }

    if($post['organization'] == 'Hospice' || $post['organization'] =='Both'){

        $pdf = new FPDI();  
        $pdf->AddPage();  
        $pdf->setSourceFile($pdf_file3);  
        $tplIdx = $pdf->importPage(1);  
        $pdf->useTemplate($tplIdx, 10, 10, 200);  
        $pdf->SetFont('Arial','',10);  
        $pdf->SetXY(55 ,47);  

     
       $pdf->Write(0, ucwords($post['name']));

       $pdf->Image($placed_signature,50,192,60,20,"PNG");

       $pdf->SetXY(155 ,205);  

       $pdf->Write(0, $date_label);
          $pdf->Output($ack_3_pdf_file,'F');//exit;

    }


     // $pdf->Output($ack_pdf_file,'I');exit;

     // echo $ack_pdf_file;die();



    return $pdf_file_name;



  }

 function  get_x_y_dimensions($pdf_file_name=""){
    $num_pages = $sig_x = $sig_y = $label_x = $label_y= NULL;
    $output = array();
    if($pdf_file_name=="pdf/jo_dpcs.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 150;
      $output['label_x'] = 110;
       $output['label_y'] = 165;
    }

    if($pdf_file_name=="pdf/jo_clinical_supervisor.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 160;
      $output['label_x'] = 110;
       $output['label_y'] = 175;
    }

    if($pdf_file_name=="pdf/jo_vocational_nurse.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 25;
      $output['sig_y'] = 58;
      $output['label_x'] = 110;
       $output['label_y'] = 77;
    }

     if($pdf_file_name=="pdf/jo_health_aide.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 115;
      $output['label_x'] = 110;
       $output['label_y'] = 127;
    }

    if($pdf_file_name=="pdf/jo_medical_social_worker.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 30;
      $output['sig_y'] = 178;
      $output['label_x'] = 110;
       $output['label_y'] = 187;
    }


     if($pdf_file_name=="pdf/jo_registered_nurse.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 215;
      $output['label_x'] = 110;
       $output['label_y'] = 227;
    }


     if($pdf_file_name=="pdf/jo_office_manager.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 165;
      $output['label_x'] = 110;
       $output['label_y'] = 178;
    }

     if($pdf_file_name=="pdf/jo_receptionist.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 85;
      $output['label_x'] = 110;
       $output['label_y'] = 100;
    }

     if($pdf_file_name=="pdf/jo_human_resource.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 175;
      $output['label_x'] = 110;
       $output['label_y'] = 190;
    }

    if($pdf_file_name=="pdf/jo_hc_clinical_supervisor.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 198;
      $output['label_x'] = 110;
       $output['label_y'] = 212;
    }

    if($pdf_file_name=="pdf/jo_hc_dpcs.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 98;
      $output['label_x'] = 110;
       $output['label_y'] = 112;
    }

    if($pdf_file_name=="pdf/jo_hc_lvc.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 118;
      $output['label_x'] = 110;
       $output['label_y'] = 134;
    }

     if($pdf_file_name=="pdf/jo_hc_medical_social_worker.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 170;
      $output['label_x'] = 110;
       $output['label_y'] = 186;
    }
// echo $pdf_file_name;die();
     if($pdf_file_name=="pdf/jo_hc_hospital_aide.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 180;
      $output['label_x'] = 110;
       $output['label_y'] = 192;
    }

     if($pdf_file_name=="pdf/jo_hc_registered_nurse.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 142;
      $output['label_x'] = 110;
       $output['label_y'] = 156;
    }


     if($pdf_file_name=="pdf/jo_hc_office_manager.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 172;
      $output['label_x'] = 110;
       $output['label_y'] = 188;
    }

      if($pdf_file_name=="pdf/jo_hc_bereavement.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 85;
      $output['label_x'] = 110;
       $output['label_y'] = 102;
    }

      if($pdf_file_name=="pdf/jo_hc_chaplain.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 145;
      $output['label_x'] = 110;
       $output['label_y'] = 157;
    }


      if($pdf_file_name=="pdf/jo_hc_intake.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 185;
      $output['label_x'] = 110;
       $output['label_y'] = 200;
    }
     if($pdf_file_name=="pdf/jo_hc_social_service_supervisor.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 185;
      $output['label_x'] = 110;
       $output['label_y'] = 196;
    }

      if($pdf_file_name=="pdf/jo_hc_volunteer.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 100;
      $output['label_x'] = 110;
       $output['label_y'] = 113;
    }

      if($pdf_file_name=="pdf/jo_hc_medical_director.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 190;
      $output['label_x'] = 110;
       $output['label_y'] = 206;
    }

    if($pdf_file_name=="pdf/jo_hc_managed_care.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 160;
      $output['label_x'] = 110;
       $output['label_y'] = 176;
    }

     if($pdf_file_name=="pdf/jo_hc_admin.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 53;
      $output['label_x'] = 110;
       $output['label_y'] = 72;
    }


     if($pdf_file_name=="pdf/jo_hc_receptionist.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 123;
      $output['label_x'] = 110;
       $output['label_y'] = 136;
    }

     if($pdf_file_name=="pdf/jo_hc_admin.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 35;
      $output['sig_y'] = 54;
      $output['label_x'] = 110;
       $output['label_y'] = 72;
    }

     if($pdf_file_name=="pdf/jo_admin.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 150;
      $output['label_x'] = 110;
       $output['label_y'] = 170;
    }


     if($pdf_file_name=="pdf/jo_admin.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 35;
      $output['sig_y'] = 150;
      $output['label_x'] = 110;
       $output['label_y'] = 170;
    }

     if($pdf_file_name=="pdf/jo_pa_lvn.pdf"){
      $output['num_pages'] = 2;
      $output['sig_x'] = 28;
      $output['sig_y'] = 155;
      $output['label_x'] = 110;
       $output['label_y'] = 168;
    }


     if($pdf_file_name=="pdf/jo_pa_registered_nurse.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 28;
      $output['sig_y'] = 170;
      $output['label_x'] = 110;
       $output['label_y'] = 180;
    }

    if($pdf_file_name=="pdf/jo_pa_nurse_prac.pdf"){
      $output['num_pages'] = 3;
      $output['sig_x'] = 28;
      $output['sig_y'] = 220;
      $output['label_x'] = 110;
       $output['label_y'] = 233;
    }

     if($pdf_file_name=="pdf/jo_pa_chaplain.pdf"){
      $output['num_pages'] =2;
      $output['sig_x'] = 28;
      $output['sig_y'] = 160;
      $output['label_x'] = 110;
       $output['label_y'] = 171;
    }

      if($pdf_file_name=="pdf/jo_pa_social_worker.pdf"){
      $output['num_pages'] =2;
      $output['sig_x'] = 28;
      $output['sig_y'] = 165;
      $output['label_x'] = 110;
       $output['label_y'] = 175;
    }

    if($pdf_file_name=="pdf/jo_pa_physician.pdf"){
      $output['num_pages'] =2;
      $output['sig_x'] = 28;
      $output['sig_y'] = 220;
      $output['label_x'] = 110;
       $output['label_y'] = 233;
    }





    // echo $pdf_file_name;die();
    return $output;
  }

  

  
?>