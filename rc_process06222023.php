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
      $pdf_file_path = $record_details['pdf_file_path'];

        $email = $record_details['email'];
    	$date=date('Y-m-d');
      $timestamp= date('YmdHis');
      $post = $_POST;

//       echo "<pre>",print_r($post),"</pre>";
// echo $pdf_file_path;die();
//       die();
    $file_name_pdf =  str_replace("pdf_files/", "pdf_files/WREF_", $pdf_file_path);
      // echo $file_name_pdf;
// echo $ref;
      // die();
// echo "<pre>",print_r($post),"</pre>";die();
    $pdf_file_name = "";


     // echo "<pre>",print_r($_POST),"</pre>";die();
    

        // var_dump($response3);die();
        // $response = base64_to_jpeg($mySignature,$file_name);
    
   
       
          $query = "UPDATE `tbl_job_applications` SET pdf_file_with_reference_path='".$file_name_pdf."'  WHERE id='".$ref."'";
          // echo $query;die();
          $result = $conn->query($query);
          // $last_id = $con->insert_id;

          // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
           // echo "<pre>",print_r($_POST),"</pre>";
           // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
          // $post['name'] = ucwords($first_name." ".$last_name);
           
         save_pdf($html,$pdf_file_path,$file_name_pdf,$post);
          // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
          // $send_mail =send_mail($file_name,$email,$name,$date,$post,false,$pdf_jo_file_name,$pdf_agr_file_name);
          // if($send_mail){
         // echo "Location: rc_form.php?ref=".base64_encode($ref)."&s=1";die();
            header("Location: rc_form.php?ref=".base64_encode($ref)."&s=1");//exit;
            
          // }
        
    }



  function save_pdf($html,$pdf_file_path="",$file_name_pdf="",$post=array()){

    $pdf_file =$pdf_file_path;//$jo_pdf_file;// "pdf/.pdf";
    $date=date('Y-m-d');
     $date_label=date('F d, Y',strtotime($post['date_filled_1']));
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

    $pdf->AddPage();
      $pdf->SetTextColor(0,0,0);
      $tplIdx = $pdf->importPage(2);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
       $pdf->AddPage();
      $tplIdx = $pdf->importPage(3);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
      $pdf->SetFont('zapfdingbats', '', 13);

        if($post['ref_attendance_1'] == 'outstanding'){
          $pdf->SetXY(67,119.5);  
          $pdf->Write(0, "4");
        }
        if($post['ref_attendance_1'] == 'good'){
          $pdf->SetXY(93.5,119.5);  
          $pdf->Write(0, "4");
        }

        if($post['ref_attendance_1'] == 'needs improvement'){
          $pdf->SetXY(110,119.5);  
          $pdf->Write(0, "4");
        }

        if($post['ref_attendance_1'] == 'Unsatisfactory'){
          $pdf->SetXY(146.5,119.5);  
          $pdf->Write(0, "4");
        }


        if($post['ref_attitude_1'] == 'outstanding'){
            $pdf->SetXY(67,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_1'] == 'good'){
           $pdf->SetXY(93.5,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_1'] == 'needs improvement'){
            $pdf->SetXY(110,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_1'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_job_performance_1'] == 'outstanding'){
            $pdf->SetXY(67,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_1'] == 'good'){
           $pdf->SetXY(93.5,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_1'] == 'needs improvement'){
            $pdf->SetXY(110,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_1'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,134);  
            $pdf->Write(0, "4");
        }

        if($post['ref_job_knowledge_1'] == 'outstanding'){
          $pdf->SetXY(67,141);  
          $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_1'] == 'good'){  
          $pdf->SetXY(93.5,141);  
          $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_1'] == 'needs improvement'){
            $pdf->SetXY(110,141);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_1'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,141);  
            $pdf->Write(0, "4");
        }

        if($post['ref_quality_work_1'] == 'outstanding'){
          $pdf->SetXY(67,148);  
          $pdf->Write(0, "4");
        }

        if($post['ref_quality_work_1'] == 'good'){  
          $pdf->SetXY(93.5,148);  
          $pdf->Write(0, "4");
        }
        if($post['ref_quality_work_1'] == 'needs improvement'){
            $pdf->SetXY(110,148);  
           $pdf->Write(0, "4");
        }
        if($post['ref_quality_work_1'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,148);  
            $pdf->Write(0, "4");
        }
         $pdf->SetFont('Arial','',9);  
        $pdf->SetXY(68 ,163);  
        $pdf->Write(0, ucwords($post['reference_checked_name_1']));
          $pdf->SetXY(137 ,161);  
        $pdf->MultiCell( 24, 3,$post['reference_title_1'],0,'L');
          $pdf->SetXY(168.5 ,161);  
        $pdf->MultiCell( 31, 3,date('F d, Y',strtotime($post['date_filled_1'])),0,'L');

          $pdf->AddPage();
      $tplIdx = $pdf->importPage(4);  
      $pdf->useTemplate($tplIdx, 10, 10, 200);  
      $pdf->SetFont('zapfdingbats', '', 13);

        if($post['ref_attendance_2'] == 'outstanding'){
          $pdf->SetXY(67,119.5);  
          $pdf->Write(0, "4");
        }
        if($post['ref_attendance_2'] == 'good'){
          $pdf->SetXY(93.5,119.5);  
          $pdf->Write(0, "4");
        }

        if($post['ref_attendance_2'] == 'needs improvement'){
          $pdf->SetXY(110,119.5);  
          $pdf->Write(0, "4");
        }

        if($post['ref_attendance_2'] == 'Unsatisfactory'){
          $pdf->SetXY(146.5,119.5);  
          $pdf->Write(0, "4");
        }


        if($post['ref_attitude_2'] == 'outstanding'){
            $pdf->SetXY(67,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_2'] == 'good'){
           $pdf->SetXY(93.5,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_2'] == 'needs improvement'){
            $pdf->SetXY(110,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_attitude_2'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,127);  
            $pdf->Write(0, "4");
        }

        if($post['ref_job_performance_2'] == 'outstanding'){
            $pdf->SetXY(67,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_2'] == 'good'){
           $pdf->SetXY(93.5,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_2'] == 'needs improvement'){
            $pdf->SetXY(110,134);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_performance_2'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,134);  
            $pdf->Write(0, "4");
        }

        if($post['ref_job_knowledge_2'] == 'outstanding'){
          $pdf->SetXY(67,141);  
          $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_2'] == 'good'){  
          $pdf->SetXY(93.5,141);  
          $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_2'] == 'needs improvement'){
            $pdf->SetXY(110,141);  
            $pdf->Write(0, "4");
        }
        if($post['ref_job_knowledge_2'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,141);  
            $pdf->Write(0, "4");
        }

        if($post['ref_quality_work_2'] == 'outstanding'){
          $pdf->SetXY(67,148);  
          $pdf->Write(0, "4");
        }

        if($post['ref_quality_work_2'] == 'good'){  
          $pdf->SetXY(93.5,148);  
          $pdf->Write(0, "4");
        }
        if($post['ref_quality_work_2'] == 'needs improvement'){
            $pdf->SetXY(110,148);  
           $pdf->Write(0, "4");
        }
        if($post['ref_quality_work_2'] == 'Unsatisfactory'){
            $pdf->SetXY(146.5,148);  
            $pdf->Write(0, "4");
        }
         $pdf->SetFont('Arial','',9);  
        $pdf->SetXY(68 ,163);  
        $pdf->Write(0, ucwords($post['reference_checked_name_2']));
          $pdf->SetXY(137 ,161);  
        $pdf->MultiCell( 24, 3,$post['reference_title_2'],0,'L');
          $pdf->SetXY(168.5 ,161);  
        $pdf->MultiCell( 31, 3,date('F d, Y',strtotime($post['date_filled_2'])),0,'L');
        $pdf_file_name = $file_name_pdf;


   
  
        $pdf->Output($pdf_file_name,'F');//exit;
       return $pdf_file_name;

  }

  
?>