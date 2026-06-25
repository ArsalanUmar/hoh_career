<?php

ob_start(); // Start output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');
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

      $date= date('Y-m-d');

            $pdf_file_path = $record_details['pdf_file_path'];

    $signature_path = $record_details['signature_path'];
    if(filesize($signature_path) == 0){
        if(!empty($record_details['signature_path_2'])){
            $signature_path = $record_details['signature_path_2'];
        
            
        }else{
              if(!empty($record_details['signature_path_3'])){
                   $signature_path = $record_details['signature_path_3'];
              }else{
                  
                  echo "Signature Not Found!";
              }
        }
    
    }

     /// echo "<pre>",print_r($record_details),"</pre>";die();
      $timestamp= date('YmdHis');

      $post = $_POST;
      $post['date_filled'] = $date;
       $name=       $file_name_pdf =  "";

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
// echo $jo_pdf_file."<br>";
// echo $position;die();
// echo "<pre>",print_r($post),"</pre>";die();

    $pdf_file_name = "";

// echo $jo_pdf_file;die();



     // echo "<pre>",print_r($_POST),"</pre>";die();

     // echo "<pre>",print_r($_FILES),"</pre>";

     // die();

        extract($_POST);

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



        // var_dump($response3);die();

        // $response = base64_to_jpeg($mySignature,$file_name);

//        $response = base64_to_jpeg($mySignature2,$file_name);

  //      $response3 = base64_to_jpeg($mySignature3,$file_name3);

        // var_dump($response3);die();

        // sleep(5);

        //$signature_path = 'signatures/'.$file_name;

   

//        if($response){

    //      $data = explode(',', $mySignature);

      //    $data2= explode(",", $mySignature2);

          $query = "UPDATE `tbl_job_applications` SET has_agreement_job='true',jo_file_path='pdf_files/".$pdf_jo_file_name."',jo_agreement_file_path='".$pdf_agr_file_name."' WHERE id='".$ref."'";

          // echo $query;die();

          $result = $conn->query($query);

          // $last_id = $con->insert_id;

         $file_name = "HH_".$first_name." ".$last_name."_1_".$date.".jpg";

   

         $file_name_pdf =  str_replace("pdf_files/", "pdf_files/HH_", $pdf_file_path);

        $file_name_pdf_2 = $file_name_pdf_3 = NULL;
          if($organization == 'Both'){
               $file_name_pdf_2 =  str_replace("pdf_files/", "pdf_files/HH_2_", $pdf_file_path);
         }

           if($organization == 'Both' || $organization == 'Hospice'){
               $file_name_pdf_3 =  str_replace("pdf_files/", "pdf_files/HH_3_", $pdf_file_path);
           }

         $query = "UPDATE `tbl_job_applications` SET hh_file_path='".$file_name_pdf."' WHERE id='".$ref."'";

          // echo $query;die();

          $result = $conn->query($query);

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);

           // echo "<pre>",print_r($_POST),"</pre>";

           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);

          $post['name'] = ucwords($first_name." ".$last_name);

           // echo $pdf_jo_file_name;die();

         $pdf_save = save_pdf($html,$signature_path, $signature_path, $signature_path,$pdf_jo_file_name,$pdf_jo_file_name_2 ,$pdf_jo_file_name_3, $pdf_jo_file_name_4,$pdf_agr_file_name,$jo_pdf_file,$jo_pdf_file_2,$jo_pdf_file_3,$jo_pdf_file_4,$file_name_pdf,$file_name_pdf_2,$file_name_pdf_3,$post);

         if($pdf_save){
         	echo json_encode(array('success'=>true));exit;
         }

          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);

         // echo $pdf_jo_file_name;die();

          //$send_mail =send_mail($file_name,$email,$name,$date,$post,false,$pdf_jo_file_name,$pdf_jo_file_name_2,$pdf_jo_file_name_3, $pdf_jo_file_name_4, $pdf_agr_file_name,$file_name_pdf,$file_name_pdf_2,$file_name_pdf_3);

         // if($send_mail){

           // header("Location: jo_form.php?ref=".base64_encode($ref)."&s=1");exit;

            

          //}

        //}

    }



  function base64_to_jpeg($base64_string, $output_file) {

      // $ifp = fopen("signatures/".$output_file, "wb"); 



      $data = explode(',', $base64_string);



      // fwrite($ifp, base64_decode($data[1])); 

      // fclose($ifp); 

      $file_size = file_put_contents("signatures/".$output_file,base64_decode($data[1]));



      

      return $file_size; 

  }





  function send_mail($file_name,$email,$name,$date,$post=array(),$receiver=false,$pdf_file1="",$pdf_jo_file_name_2="",$pdf_jo_file_name_3="",$pdf_jo_file_name_4="",$pdf_file2="",$file_name_pdf="",$file_name_pdf_2="",$file_name_pdf_3=""){

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

          $subject = "JOB AGREEMENT FORM - copy";

        }else{

          $subject = "JOB AGREEMENT - copy";

        }

           

      // echo "<pre>",print_r($post),"</pre>";die();

     $m = $html = "";

      // $name = $post['first_name']." ".$post['last_name'];

      unset($post['mySignature-dpi']);

      unset($post['mySignature']);

        unset($post['mySignature2-type']);

      unset($post['mySignature2-dpi']);

      unset($post['mySignature2']);



      if($receiver){

         $m .= "";//"You have recently signed a job agreement. Attached is the copy of pdf form with the signed document <br>";

        

      }else{

         $m .= "";//"You have received new job agreement form: <br>";

      }

   

      

// echo $html;die();

     

    /* Attachment File */

      // Attachment location

   // //   $file_name = "<attachment file name>";

   //    $path = "signatures/";

       

   //    // Read the file content

   //    $file = $path.$file_name;



   //    $file_size = filesize($file);

   //    $handle = fopen($file, "r");

   //    $content = fread($handle, $file_size);

   //    fclose($handle);

   //    $content = chunk_split(base64_encode($content));



        // $file_name_pdf = "pdf_files/".$name.' '.date('Y-m-d').'.pdf';

                // $file_name_pdf_2 = "pdf_files/HBV_".$name.' '.date('Y-m-d').'.pdf';



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

        //  if(empty($email)){

        //    $mail->addAddress($mail_to, "NOReply");

        // }else{

            $mail->addAddress($email, "NOReply");

        //      $mail->addAddress($post['email'], "NOREply");

        // }



        //Send HTML or Plain Text email

        $mail->isHTML(true);



        $mail->Subject = $subject;

        $mail->Body = $message;

        $mail->addAttachment('pdf_files/'.$pdf_file1);

                $mail->addAttachment($pdf_file2);

                $mail->addAttachment($file_name_pdf);
        if(!empty($pdf_jo_file_name_2)){
           $mail->addAttachment('pdf_files/'.$pdf_jo_file_name_2);

        }

        if(!empty($pdf_jo_file_name_3)){
           $mail->addAttachment('pdf_files/'.$pdf_jo_file_name_3);

        }

         if(!empty($pdf_jo_file_name_4)){
           $mail->addAttachment('pdf_files/'.$pdf_jo_file_name_4);

        }


          if(!empty($file_name_pdf_2)){
             $mail->addAttachment($file_name_pdf_2);

        }

        if(!empty($file_name_pdf_3)){
             $mail->addAttachment($file_name_pdf_3);

        }


        // $mail->addAttachment("pdf/tem.pdf");



        $mail->send();

        return $file_name_pdf;

  



  }

       

  function save_pdf($html,$signature1,$signature2,$signature3,$name="",$pdf_jo_file_name_2="",$pdf_jo_file_name_3="",$pdf_jo_file_name_4="",$agr_name="",$jo_pdf_file="",$jo_pdf_file_2="",$jo_pdf_file_3="",$jo_pdf_file_4="",$ack_pdf_file="",$ack_2_pdf_file="",$ack_3_pdf_file="",$post=array()){
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
           $pdf->SetXY(30,$get_dimensions['label_y']);  
            $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
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

                $pdf->SetXY(30,$get_dimensions['label_y']);  
                $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
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
                $pdf->SetXY(30,$get_dimensions['label_y']);  
                $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
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
                $pdf->SetXY(30,$get_dimensions['label_y']);  
              $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
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
    $pdf->Write(0, ucwords($post['name']." / (".$post['position'].")"));
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

       $pdf->Image($placed_signature,50,210,60,20,"PNG");

       $pdf->SetXY(155 ,228);  

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
       $pdf->Image($placed_signature,50,208,60,20,"PNG");
       $pdf->SetXY(55 ,223);  
       $pdf->Write(0, ucwords($post['name']));
       $pdf->SetXY(155 ,223);
       $pdf->Write(0, $date_label);
          $pdf->Output($ack_2_pdf_file,'F');//exit;

    }else{

      if($post['organization'] == 'Hospice'){
      
       $pdf->Write(0, ucwords($post['name']));

     $pdf->Image($placed_signature,50,210,60,20,"PNG");
      $pdf->SetXY(55 ,228);  
       $pdf->Write(0, ucwords($post['name']));
       $pdf->SetXY(155 ,228);  

       $pdf->Write(0, $date_label);
      }else{

     
       $pdf->Write(0, ucwords($post['name']));

        $pdf->Image($placed_signature,50,208,60,20,"PNG");
        $pdf->SetXY(55 ,223);  
       $pdf->Write(0, ucwords($post['name']));
       $pdf->SetXY(155 ,223);

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
       $pdf->SetXY(55 ,205);  
       $pdf->Write(0, ucwords($post['name']));
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