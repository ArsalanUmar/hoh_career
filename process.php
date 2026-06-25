<?php
error_reporting(0);
ini_set('display_errors', 0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('database.php');

$path1 = 'fpdf/fpdf.php';
$path2 = 'fpdi/autoload.php';
require_once($path1);
require_once($path2);
// require_once('database.php');
if (!isset($_SESSION)) {
  session_start();
}

use \setasign\Fpdi\Fpdi;

$s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
$display = (empty($s)) ? 'none' : 'block';
$db = new Database;
$con = $db->Conn();
$html = "";
if (!empty($_POST)) {
  //check recaptcha first
  if ($_SESSION['captcha'] != $_POST['recaptcha']) {
    header("Location: index.php?e=1");
    exit;
  }

  foreach ($_POST as $key => &$post_val) {
    $_POST[$key] = $con->real_escape_string($post_val);
  }
  $date = date('Y-m-d', strtotime($_POST['date_filled'])); //date('Y-m-d');
  $timestamp = date('YmdHis');
  $post = $_POST;
  $name =       $file_name_pdf =  $_POST['first_name'] . " " . $_POST['last_name'];
  $resume_name = $pdf_file_name = "";
  if (isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])) {
    $file_name  = $_FILES['resume']['name'];
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $tmp_name = $_FILES["resume"]["tmp_name"];

    // var_dump($_FILES);die();
    $resume_name = $_POST['first_name'] . " " . $_POST['last_name'] . $timestamp . "." . $ext;
    // echo $tmp_name;die();
    move_uploaded_file($tmp_name, "resume_files/" . $resume_name);
    // $file_name = 
  }
  $pdf_consent_file = 'pdf_files/LEG_' . $_POST['first_name'] . " " . $_POST['last_name'] . ".pdf";

  // echo "<pre>",print_r($_POST),"</pre>";die();
  // echo "<pre>",print_r($_FILES),"</pre>";
  // die();
  extract($_POST);
  // Set default organization to Home Health if not provided
  if (empty($company_applying)) {
    $company_applying = 'Home Health';
  }
  $file_name = $_POST['first_name'] . " " . $_POST['last_name'] . "_1_" . $date . ".jpg";
  $file_name2 = $_POST['first_name'] . " " . $_POST['last_name'] . "_2_" . $date . ".jpg";
  $file_name3 = $_POST['first_name'] . " " . $_POST['last_name'] . "_3_" . $date . ".jpg";
  $pdf_file_name = "pdf_files/" . $file_name_pdf . ' ' . date('Y-m-d') . '.pdf';

  // var_dump($response3);die();

  $placed_signature = "";

  if (strlen($mySignature) > 0) {
    $placed_signature = $signature1;
  }

  if (strlen($mySignature2) > strlen($mySignature)) {
    $placed_signature = $mySignature2;
  }

  if (strlen($mySignature3) > strlen($mySignature2)) {
    $placed_signature = $mySignature3;
  }

  $response = base64_to_jpeg($placed_signature, $file_name);
  $response2 = base64_to_jpeg($mySignature2, $file_name2);
  $response3 = base64_to_jpeg($mySignature3, $file_name3);
  // var_dump($response3);die();
  sleep(4);
  $signature_path = 'signatures/' . $file_name;
  $signature_path_2 = 'signatures/' . $file_name2;
  $signature_path_3 = 'signatures/' . $file_name3;
  $work_currently_chk_1 = $work_currently_chk_2 = $work_currently_chk_3 = NULL;
  $hepa_agree_field = NULL;
  if (isset($hepa_agree) && $hepa_agree == 'on') {
    $hepa_agree_field = "agree";
  } else {
    $hepa_agree_field = "disagree";
  }

  // if($response){
  $data = explode(',', $mySignature);
  $data2 = explode(",", $mySignature2);
  $query = "INSERT INTO `tbl_job_applications` (`first_name`,`last_name`,`middle_initial`,`date_of_birth`,`sss_number`,`email`,`telephone_no`,`street_address`,`city`,`state`,`zip_code`,`drivers_license`,`dl_state`,`dl_expiration_date`,`position`,`organization`,`school_name_1`,`school_major_1`,`school_field_1`,`school_from_1`,`school_to_1`,`school_name_2`,`school_major_2`,`school_field_2`,`school_from_2`,`school_to_2`,`prof_ref_name_1`,`prof_ref_company_1`,`prof_ref_tel_1`,`prof_ref_name_2`,`prof_ref_company_2`,`prof_ref_tel_2`,`emergency_name`,`emergency_relationship`,`emergency_telephone`,`work_job_title_1`,`work_company_name_1`,`work_location_1`,`work_from_1`,`work_to_1`,`work_is_currently_1`,`work_job_title_2`,`work_company_name_2`,`work_location_2`,`work_from_2`,`work_to_2`,`work_is_currently_2`,`work_job_title_3`,`work_company_name_3`,`work_location_3`,`work_from_3`,`work_to_3`,`work_is_currently_3`,`work_role_1`,`work_role_2`,`work_role_3`,`gq_1`,`gq_2`,`hepa`,`gq_3`,`resume_file_path`,`pdf_file_path`,`signature_path`,`signature_path_2`,`signature_path_3`,`date_filled`,`legal_consent_path`) VALUES ('" . $first_name . "','" . $last_name . "','" . $mi_name . "','" . $date_of_birth . "','" . $sss_number . "','" . $email . "','" . $tel_no . "','" . $street_address . "','" . $city . "','" . $state . "','" . $zip_code . "','" . $driver_license_no . "','" . $dl_state . "','" . $dl_expiration . "','" . $position . "','" . $company_applying . "','" . $school_1 . "','" . $major_degree_1 . "','" . $certificate_1 . "','" . $years_from_1 . "','" . $years_to_1 . "','" . $school_2 . "','" . $major_degree_2 . "','" . $certificate_2 . "','" . $years_from_2 . "','" . $years_to_2 . "','" . $prof_name_1 . "','" . $prof_company_1 . "','" . $prof_telno_1 . "','" . $prof_name_2 . "','" . $prof_company_2 . "','" . $prof_telno_2 . "','" . $emergency_name_1 . "','" . $emergency_relationship_1 . "','" . $emergency_no_1 . "','" . $work_job_title_1 . "','" . $work_company_name_1 . "','" . $work_location_1 . "','" . $work_date_from_1 . "','" . $work_date_to_1 . "','" . $work_currently_chk_1 . "','" . $work_job_title_2 . "','" . $work_company_name_2 . "','" . $work_location_2 . "','" . $work_date_from_2 . "','" . $work_date_to_2 . "','" . $work_currently_chk_2 . "','" . $work_job_title_3 . "','" . $work_company_name_3 . "','" . $work_location_3 . "','" . $work_date_from_3 . "','" . $work_date_to_3 . "','" . $work_currently_chk_3 . "','" . $work_duties_1 . "','" . $work_duties_2 . "','" . $work_duties_3 . "','" . $gq_usa . "','" . $gq_health . "','" . $hepa_agree_field . "','" . $gq_license . "','" . $resume_name . "','" . $pdf_file_name . "','" . $signature_path . "','" . $signature_path_2 . "','" . $signature_path_3 . "','" . $date_filled . "','" . $pdf_consent_file . "')";
  // echo $query;die();
  $result = $con->query($query);
  $last_id = $con->insert_id;

  // $pdf_file_path =  send_mail($file_name,$data[1],$data2[1],$name,$date,$_POST);
  // echo "<pre>",print_r($_POST),"</pre>";
  // $send_mail = send_mail($file_name,$data[1],$name,$date,$_POST,$_POST['email'],true);
  $i1 = $i2 = $i3 = $i4 = $i5 = $i6 = $i7 = NULL;


  // save_pdf($html,$mySignature,"signatures/".$file_name2,"signatures/".$file_name3,$file_name_pdf,$pdf_consent_file,$post);
  save_pdf($html, $mySignature, $mySignature2, $mySignature3, $file_name_pdf, $pdf_consent_file, $post);

  // send_mail($file_name,"flippincrazyllc@yahoo.com",$name,$date,$_POST);
  $send_mail = send_mail($file_name, $_POST['email'], $name, $date, $_POST, false, $pdf_consent_file);
  // Proceed with redirect regardless of email outcome; email failures are logged internally
  if ($result && $last_id > 0) {
    $encoded_id = base64_encode($last_id);
    $redirect_url = "jo_form.php?ref=" . $encoded_id;
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showSuccessAndRedirect(){
          Swal.fire({
              title: 'Success!',
              html: 'Application was submitted successfully. You will be redirected to sign your Job Agreements momentarily, <strong>Do not close this window.</strong>.',
              icon: 'success',
              timer: 6000,
              timerProgressBar: true,
              showConfirmButton: false,
              allowOutsideClick: false,
              allowEscapeKey: false
          }).then(() => {
              window.location.href = '<?php echo $redirect_url; ?>';
          });
          // Backup redirect in case modal fails
          setTimeout(function() {
              window.location.href = '<?php echo $redirect_url; ?>';
          }, 6500);
        }
        if (document.body) {
          showSuccessAndRedirect();
        } else {
          window.addEventListener('DOMContentLoaded', showSuccessAndRedirect);
        }
    </script>
    <?php
    exit();
  } else {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showErrorAndGoBack(){
          Swal.fire({
              title: 'Error!',
              text: 'Something went wrong. Please try again.',
              icon: 'error',
              confirmButtonText: 'OK'
          }).then(() => {
              window.location.href = 'index.php?s=1';
          });
        }
        if (document.body) {
          showErrorAndGoBack();
        } else {
          window.addEventListener('DOMContentLoaded', showErrorAndGoBack);
        }
    </script>
    <?php
    exit();
  }
  // }
}

function base64_to_jpeg($base64_string, $output_file)
{
  // $ifp = fopen("signatures/".$output_file, "wb"); 

  $data = explode(',', $base64_string);

  // fwrite($ifp, base64_decode($data[1])); 
  // fclose($ifp); 
  $file_size = file_put_contents("signatures/" . $output_file, base64_decode($data[1]));


  return $file_size;
}


function send_mail($file_name, $email, $name, $date, $post = array(), $receiver = false, $pdf_consent_file)
{
  require_once "phpmailer/Exception.php";

  require_once "phpmailer/PHPMailer.php";
  require_once "phpmailer/SMTP.php";


  /* Email Detials */
  // $filename = "sender.txt";
  // $handle = fopen($filename, "r");
  $mail_to = "techyjust@gmail.com"; //fread($handle, filesize($filename));
  // fclose($handle);

  if ($receiver) {
    $subject = "JOB APPLICATION FORM - copy";
  } else {
    $subject = "Copies";
  }

  // echo "<pre>",print_r($post),"</pre>";die();
  $m = $html = "";
  $name = $post['first_name'] . " " . $post['last_name'];
  unset($post['mySignature-dpi']);
  unset($post['mySignature']);
  unset($post['mySignature2-type']);
  unset($post['mySignature2-dpi']);
  unset($post['mySignature2']);

  if ($receiver) {
    $m .= ""; //"You have recently signed a job application. Attached is the copy of pdf form with application details <br>";

  } else {
    $m .= ""; //"You have received new job application form: <br>";
  }


  // echo $html;die();

  /* Attachment File */
  // Attachment location
  //   $file_name = "<attachment file name>";
  $path = "signatures/";

  // Read the file content
  $file = $path . $file_name;

  $file_size = filesize($file);
  $handle = fopen($file, "r");
  $content = fread($handle, $file_size);
  fclose($handle);
  $content = chunk_split(base64_encode($content));

  $file_name_pdf = "pdf_files/" . $name . ' ' . date('Y-m-d') . '.pdf';
  $file_name_pdf_2 = "pdf_files/HBV_" . $name . ' ' . date('Y-m-d') . '.pdf';

  // $file_name_pdf = save_pdf($html,$file,$name,$post);
  /* Set the email header */
  // Generate a boundary
  $boundary = md5(uniqid(time()));
  $eol = PHP_EOL;

  $message = "$m" . $eol;
  $message .= "<br>Please keep the attached copies for your records and future reference.
 <br><br>

Regards,
Admin
 <br><br>";

  $message .= "<p style='font-size:10px;'>This is an automatically generated email, please do not reply to it. </p>";


  try {
    //PHPMailer Object (disable exceptions to avoid halting execution)
    $mail = new PHPMailer(false);
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

    //To address and name
    if (empty($email)) {
      $mail->addAddress($mail_to, "Info");
    } else {
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

    $sent = $mail->send();
    return $sent ? true : false;
  } catch (\Throwable $e) {
    error_log('Mail send failed: ' . $e->getMessage());
    return false;
  }
}

$required_pdfs = [
    "pdf/job_application_template.pdf",
    "pdf/legal_consent_template.pdf", 
    "pdf/hbv_form.pdf"
];

foreach($required_pdfs as $pdf_path) {
    if(!file_exists($pdf_path)) {
        echo "Missing PDF template: " . $pdf_path . "<br>";
    }
}

function save_pdf($html, $signature1, $signature2, $signature3, $name = "", $pdf_consent_file = "", $post = array())
{

  $pdf_file = "pdf/job_application_template.pdf";
  $pdf_file_cons = "pdf/legal_consent_template.pdf";
  $date = date('Y-m-d');
  $date_label = date('F d, Y', strtotime($post['date_filled']));
  $path = "signatures/";

  $placed_signature = "";

  if (strlen($signature1) > 0) {
    $placed_signature = $signature1;
  }

  if (strlen($signature2) > strlen($signature1)) {
    $placed_signature = $signature2;
  }

  if (strlen($signature3) > strlen($signature2)) {
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
  $pdf->SetTextColor(0, 0, 0);

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetXY(37, 57);
  $pdf->Write(0, ucwords($post['first_name'] . " " . $post['last_name']));
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetXY(34, 121);
  $pdf->Write(0, ucwords($post['first_name'] . " " . $post['last_name']));
  // $pdf->SetXY(34 ,121);  
  // $pdf->Write(0, ucwords($post['first_name']." ".$post['last_name']));
  $pdf->Image($signature2, 25, 95, 100, 40, "PNG");
  // $pdf->Image($signature2,25,140,100,40,"PNG");
  // $pdf->Image($signature3,25,175,100,40,"PNG");
  $pdf->SetXY(138, 121);
  $pdf->Write(0, $date_label);
  // $pdf->Image($signature2,25,140,100,40,"PNG");
  // $pdf->Image($signature3,25,160,100,40,"PNG");
  // echo $pdf_consent_file;die();
  $pdf->Output($pdf_consent_file, 'F'); //exit;


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
  $pdf->SetTextColor(0, 0, 0);

  $pdf_file_name = "pdf_files/" . $name . ' ' . $date . '.pdf';
  // echo "<pre>",print_r($post),"</pre>";die();

  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(22, 44);
  $pdf->Write(0, $post['first_name']);
  $pdf->SetXY(82, 44);
  $pdf->Write(0, $post['last_name']);
  $pdf->SetXY(142, 44);
  $pdf->Write(0, $post['mi_name']);
  $pdf->SetXY(160, 44);
  $pdf->Write(0, $date_label);

  $pdf->SetXY(22, 54);
  $pdf->Write(0, date('F d, Y', strtotime($post['date_of_birth'])));
  $pdf->SetXY(53, 54);
  $pdf->Write(0, $post['sss_number']);
  $pdf->SetXY(93, 54);
  $pdf->Write(0, $post['email']);
  $pdf->SetXY(150, 54);
  $pdf->Write(0, $post['tel_no']);

  $pdf->SetXY(22, 61);
  $pdf->MultiCell(58, 3, $post['street_address'], 0, 'L');
  $pdf->SetXY(82, 64);
  $pdf->Write(0, $post['city']);
  $pdf->SetXY(135, 64);
  $pdf->Write(0, $post['state']);
  $pdf->SetXY(160, 64);
  $pdf->Write(0, $post['zip_code']);

  $pdf->SetXY(22, 72);
  $pdf->MultiCell(58, 3, $post['driver_license_no'], 0, 'L');
  $pdf->SetXY(82, 74);
  $pdf->Write(0, $post['dl_state']);
  $pdf->SetXY(103, 74);
  $pdf->Write(0, date('F d, Y', strtotime($post['dl_expiration'])));
  $pdf->SetXY(134, 72);
  $pdf->MultiCell(66, 3, ucwords(str_replace("_", " ", $post['position'])), 0, 'L');

  // $pdf->Write(0, ucwords(str_replace("_", " ",$post['position'])));


  $pdf->SetXY(22, 88);
  $pdf->MultiCell(58, 3, $post['school_1'], 0, 'L');
  $pdf->SetXY(71, 90);
  $pdf->Write(0, str_replace("\\", "", $post['major_degree_1']));
  $pdf->SetXY(105, 90);
  $pdf->Write(0, $post['certificate_1']);
  $pdf->SetXY(143, 90);
  $pdf->Write(0, $post['years_from_1']);
  $pdf->SetXY(173, 90);
  $pdf->Write(0, $post['years_to_1']);



  $pdf->SetXY(22, 100);
  $pdf->MultiCell(58, 3, $post['school_2'], 0, 'L');
  $pdf->SetXY(71, 102);
  $pdf->Write(0, $post['major_degree_2']);
  $pdf->SetXY(105, 102);
  $pdf->Write(0, $post['certificate_2']);
  $pdf->SetXY(143, 102);
  $pdf->Write(0, $post['years_from_2']);
  $pdf->SetXY(173, 102);
  $pdf->Write(0, $post['years_to_2']);


  $pdf->SetXY(22, 116);
  $pdf->Write(0, $post['emergency_name_1']);
  $pdf->SetXY(82, 116);
  $pdf->Write(0, $post['emergency_relationship_1']);
  $pdf->SetXY(135, 116);
  $pdf->Write(0, $post['emergency_no_1']);

  $pdf->SetXY(22, 132);
  $pdf->Write(0, $post['work_job_title_1']);
  $pdf->SetXY(112, 132);
  $pdf->Write(0, $post['work_company_name_1']);
  $pdf->SetXY(22, 141);
  $pdf->Write(0, $post['work_location_1']);

  if (isset($post['work_currently_chk_1'])) {
    $pdf->SetFont('zapfdingbats', '', 13);

    $pdf->SetXY(194, 136);
    $pdf->Write(0, "4");
  } else {
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(157, 141);
    $pdf->Write(0, date('F d, Y', strtotime($post['work_date_to_1'])));
  }
  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(112, 141);
  $pdf->Write(0, date('F d, Y', strtotime($post['work_date_from_1'])));
  $pdf->SetXY(22, 150);
  if (strlen($post['work_duties_1']) > 100) {
    $pdf->MultiCell(175, 3, 'Job Role description attached on next page', 0, 'L');
  } else {

    $pdf->MultiCell(175, 3, $post['work_duties_1'], 0, 'L');
  }



  $pdf->SetXY(22, 163);
  $pdf->Write(0, $post['work_job_title_2']);
  $pdf->SetXY(112, 163);
  $pdf->Write(0, $post['work_company_name_2']);
  $pdf->SetXY(22, 173);
  $pdf->Write(0, $post['work_location_2']);

  if (isset($post['work_currently_chk_2'])) {
    $pdf->SetFont('zapfdingbats', '', 13);

    $pdf->SetXY(194, 166.5);
    $pdf->Write(0, "4");
  } else {
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(157, 173);
    if (!empty($post['work_date_to_2'])) {

      $pdf->Write(0, date('F d, Y', strtotime($post['work_date_to_2'])));
    }
  }
  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(112, 173);
  if (!empty($post['work_date_from_2'])) {

    $pdf->Write(0, date('F d, Y', strtotime($post['work_date_from_2'])));
  }
  $pdf->SetXY(22, 181);
  if (strlen($post['work_duties_2']) > 100) {
    $pdf->MultiCell(175, 3, 'Job Role description attached on next page', 0, 'L');
  } else {

    $pdf->MultiCell(175, 3, $post['work_duties_2'], 0, 'L');
  }

  // $pdf->MultiCell( 175, 3,$post['work_duties_2'],0,'L');


  $pdf->SetXY(22, 193);
  $pdf->Write(0, $post['work_job_title_3']);
  $pdf->SetXY(112, 193);
  $pdf->Write(0, $post['work_company_name_3']);
  $pdf->SetXY(22, 203);
  $pdf->Write(0, $post['work_location_3']);

  if (isset($post['work_currently_chk_3'])) {
    $pdf->SetFont('zapfdingbats', '', 13);

    $pdf->SetXY(194, 198);
    $pdf->Write(0, "4");
  } else {
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(157, 203);
    if (!empty($post['work_date_to_3'])) {

      $pdf->Write(0, date('F d, Y', strtotime($post['work_date_to_3'])));
    }
  }
  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(112, 203);
  if (!empty($post['work_date_from_3'])) {

    $pdf->Write(0, date('F d, Y', strtotime($post['work_date_from_3'])));
  }
  $pdf->SetXY(22, 212);
  if (strlen($post['work_duties_3']) > 100) {
    $pdf->MultiCell(175, 3, 'Job Role description attached on next page', 0, 'L');
  } else {

    $pdf->MultiCell(175, 3, $post['work_duties_3'], 0, 'L');
  }
  // $pdf->MultiCell( 214, 3,$post['work_duties_3'],0,'L');

  // $pdf->Output($pdf_file_name,'I');exit;

  $pdf->SetFont('zapfdingbats', '', 12);

  //  $pdf->SetXY(50 ,251);  
  // $pdf->Write(0, "4");


  //  $pdf->SetXY(59.5 ,251);  
  // $pdf->Write(0, "4");

  if ($post['gq_usa'] == 'yes') {
    $pdf->SetXY(143, 224);
    $pdf->Write(0, "4");
  } else {
    $pdf->SetXY(152.5, 224);
    $pdf->Write(0, "4");
  }

  if ($post['gq_health'] == 'yes') {
    $pdf->SetXY(100, 236);
    $pdf->Write(0, "4");
  } else {

    $pdf->SetXY(110, 236);
    $pdf->Write(0, "4");
  }

  if ($post['gq_license'] == 'yes') {
    $pdf->SetXY(50, 248);
    $pdf->Write(0, "4");
  } else {

    $pdf->SetXY(59.5, 248);
    $pdf->Write(0, "4");
  }
  if (strlen($post['work_duties_1']) > 100 || strlen($post['work_duties_2'])  > 100 || strlen($post['work_duties_3'])  > 100) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $next_yy = 30;
    if (strlen($post['work_duties_1']) > 100) {
      $pdf->SetXY(28, $next_yy);
      $pdf->MultiCell(175, 3, $post['work_company_name_1'] . ': ' . $post['work_duties_1'], 0, 'L');
      $next_yy  = 80;
    }
    if (strlen($post['work_duties_2']) > 100) {
      $pdf->SetXY(28, $next_yy);
      $pdf->MultiCell(175, 3, $post['work_company_name_2'] . ': ' . $post['work_duties_2'], 0, 'L');
      $next_yy  = 150;
    }
    if (strlen($post['work_duties_3']) > 100) {
      $pdf->SetXY(28, $next_yy);
      $pdf->MultiCell(175, 3, $post['work_company_name_3'] . ': ' . $post['work_duties_3'], 0, 'L');
      // $next_yy  = 150;
    }
  }
  // import page 1  
  $pdf->AddPage();
  $tplIdx = $pdf->importPage(2);
  $pdf->Image($placed_signature, 35, 175, 100, 40, "PNG");
  $pdf->SetFont('Arial', '', 8);
  $pdf->SetXY(50, 202);
  $pdf->Write(0, $post['first_name'] . " " . $post['last_name']);
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetXY(134, 202);
  $pdf->Write(0, $date_label);
  // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
  $pdf->useTemplate($tplIdx, 10, 10, 200);
  $pdf->AddPage();
  $tplIdx = $pdf->importPage(3);
  // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
  $pdf->useTemplate($tplIdx, 10, 10, 200);
  $pdf->SetXY(54, 43);
  $pdf->Write(0, $post['prof_name_1']);
  $pdf->SetXY(45, 53);
  $pdf->Write(0, $post['prof_company_1']);
  $pdf->SetXY(142, 53);
  $pdf->Write(0, $post['prof_telno_1']);
  $pdf->SetXY(57, 90);
  $pdf->Write(0, $post['first_name'] . " " . $post['last_name']);
  $pdf->Image($placed_signature, 50, 70, 80, 25, "PNG");
  $pdf->SetXY(135, 90);
  $pdf->Write(0, $date_label);
  $pdf->AddPage();
  $tplIdx = $pdf->importPage(4);

  // use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
  $pdf->useTemplate($tplIdx, 10, 10, 200);
  $pdf->SetXY(54, 43);
  $pdf->Write(0, $post['prof_name_2']);
  $pdf->SetXY(45, 53);
  $pdf->Write(0, $post['prof_company_2']);
  $pdf->SetXY(142, 53);
  $pdf->Write(0, $post['prof_telno_2']);
  $pdf->Image($placed_signature, 50, 70, 80, 25, "PNG");
  $pdf->SetXY(57, 89);
  $pdf->Write(0, $post['first_name'] . " " . $post['last_name']);
  $pdf->SetXY(135, 89);
  $pdf->Write(0, $date_label);



  $date = date('mdY');

  $pdf->Output($pdf_file_name, 'F'); //exit;

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
  $pdf->SetTextColor(0, 0, 0);

  // echo "<pre>",print_r($post),"</pre>";die();
  $pdf->SetFont('zapfdingbats', '', 12);
  if (isset($post['hepa_disagree']) && $post['hepa_disagree'] == "on") {
    $pdf->SetXY(21, 208.5);
    $pdf->Write(0, "4");
  }

  if (isset($post['hepa_agree']) && $post['hepa_agree'] == "on") {
    $pdf->SetXY(21, 161.5);
    $pdf->Write(0, "4");
  }


  $pdf->SetFont('Arial', '', 9);
  $pdf->SetXY(32, 245);
  $pdf->Write(0, ucwords($post['first_name'] . " " . $post['last_name']));
  $pdf->Image($placed_signature, 145, 230, 60, 20, "PNG");
  $pdf->SetXY(108, 245);
  $pdf->Write(0, $date_label);
  // echo $signature3;die();

  $pdf_file_name = "pdf_files/HBV_" . $name . ' ' . date('Y-m-d') . '.pdf';
  $pdf->Output($pdf_file_name, 'F'); //exit;
  return $pdf_file_name;
}
