<?php

require_once('database.php');
$s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
$display = (empty($s)) ? 'none' : 'block';
$db = new Database;
$conn = $db->Conn();

$sql = "SELECT * FROM `tbl_job_applications`  where status='active' AND (prof_ref_company_1 NOT IN('google','+13472950001','BitcoinSystem','Vevor','+14472960201') OR prof_ref_company_1 IS NULL);";
$result_logged = $conn->query($sql);
// $record_details= $result_logged->fetch_assoc();
$agreement_file = 'pdf/ho_template.pdf';
$staff_records = array();
// echo "<pre>",print_r($record_details),"</pre>";die();
// if(!empty($record_details)){
$employee_records = array();
$unique_names = array(); // To avoid duplicates by name

$sql = "SELECT * FROM `tbl_job_applications`  
        WHERE status = 'active' 
          AND has_agreement_job = 'true'
          AND (
            prof_ref_company_1 NOT IN ('google', '+13472950001', 'BitcoinSystem', 'Vevor', '+14472960201') 
            OR prof_ref_company_1 IS NULL
          )";

$result_logged = $conn->query($sql);

while ($details = $result_logged->fetch_assoc()) {
	if (file_exists($details['signature_path'])) {
		$full_name = ucwords(strtolower($details['first_name'] . " " . $details['last_name']));

		if (!in_array($full_name, $unique_names)) {
			$employee_records[$details['id']] = $full_name;
			$unique_names[] = $full_name;
		}
	}
}



$sql = "SELECT * FROM `tbl_staff` where status='active' ";
$result_logged = $conn->query($sql);
while ($details = $result_logged->fetch_assoc()) {
	# code...
	$staff_records[$details['staff_id']] = ucwords(strtolower($details['staff_name']));
}

// $position = $record_details['position'];
// if($position == 'Clinical Supervisor/Nursing Supervisor'){
// 	$jo_pdf_file = 'pdf/jo_clinical_supervisor.pdf';
// }else if($position == 'Clinical Director/Director of Patient Care Services'){
// 	$jo_pdf_file = 'pdf/jo_dpcs.pdf';
// }else if($position == 'Licensed Vocational Nurse'){
// 	$jo_pdf_file = 'pdf/jo_vocational_nurse.pdf';
// }else if($position == 'Home Health Aid'){
// 	$jo_pdf_file = 'pdf/jo_health_aide.pdf';
// }else if($position == 'Registered Nurse'){
// 	$jo_pdf_file = 'pdf/jo_registered_nurse';
// }else if($position == 'Office Manager'){
// 	$jo_pdf_file = 'pdf/jo_office_manager.pdf';
// }else if($position == 'Secretary/Receptionist'){
// 	$jo_pdf_file = 'pdf/jo_receptionist.pdf';
// }

// $agreement_file = 'pdf/job_agreement.pdf';

// }else{
// echo "Unauthorized Access";exit;
// }
//   echo "<pre>",print_r($employee_records),"</pre>";die();

?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Tests Perform</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->

	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">

	<!--===============================================================================================-->

	<!-- <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"> -->

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

	<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="css/util.css">

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />
	<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



</head>

<body>





	<div class="container-contact100">

		<div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>



		<div class="wrap-contact100">

			<div class="contact100-form-title">



			</div>

			<?php
			if (isset($_GET['s']) && !empty($_GET['s'])) {


			?>
				<div class="badge-md mt-4 m-4 badge-success">

					&nbsp;&nbsp;&nbsp;Form was successfully submitted!

				</div>



			<?php exit;
			} ?>
			<?php if (isset($_GET['e']) && $_GET['e'] === 'staff') { ?>
				<div class="badge-md mt-4 m-4 badge-danger">
					&nbsp;&nbsp;&nbsp;Please select a staff name for this certificate and try again.
				</div>
			<?php } ?>
			<?php if (isset($_GET['e']) && $_GET['e'] === 'archived') { ?>
				<div class="badge-md mt-4 m-4 badge-danger">
					&nbsp;&nbsp;&nbsp;Certificate generation is not available for archived employees.
				</div>
			<?php } ?>
			<?php if (isset($_GET['e']) && $_GET['e'] === '1') { ?>
				<div class="badge-md mt-4 m-4 badge-danger">
					&nbsp;&nbsp;&nbsp;Certificate could not be saved. Please try again or contact support.
				</div>
			<?php } ?>
			<div class="contact100-form-title-2">

				&nbsp;&nbsp;Test Certificates
				<p class="ml-2 ">Click the test title to take. </p>
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data" action="generate_certificates.php">

				<ul id="progressbar" class="progressbar8">
					<li class="active certs" id="waived_test"><strong>Waived Test</strong></li>
					<li id="hepab_test" class="certs"><strong>Hepatitis B</strong></li>
					<li id="harassment_test" class="certs"><strong>Harassment</strong></li>
					<li id="hand_hygiene_test" class="certs"><strong>Hand Hygiene</strong></li>
					<li id="emergency_test" class="certs"><strong>Emergency Test</strong></li>
					<li id="covid_test" class="certs"><strong>Covid Test</strong></li>
					<li id="bloodpatho_test" class="certs"><strong>Blood Pathogen Test</strong></li>
					<li id="glucometer_test" class="certs"><strong>Glucometer Test</strong></li>
				</ul>
				<!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
				<fieldset id="waived_test" class="waived_test">
					<div class="eval_class form-card">
						<div class="row">
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="waived_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="waived_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="Position is required">
									<span class="label-input100">Position:</span>
									<input name="waived_position" class="input100 ml-2 mt-2 employee_name_class">

									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="waived_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="waived_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_waived_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_waived_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;Glucose test strips are affected by humidity; the desiccant in lid prevents strips from becoming defective due to exposure of humidity. It is unacceptable to leave vials uncapped or to leave unused test strips out of their protective, properly capped vial; improperly stored test strips may result in falsely elevated glucose results. </p><br>
								<p>An indication that test strips have been damaged (i.e. by humidity) would be reflected in the control results: Level 1 would be out of range while Level 2 would be within range.</p>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;Use of the Accuchek Inform is limited to screening and monitoring purposes; therefore, a diagnosis of diabetes cannot be made just based on an elevated test result. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;Glucose control solutions are only good for _______ after opening. The new expiration date for a brand new control set opened on 1/1/07 whose manufacturer expiration date is 3/28/07 is ______, and should be written on both vials to prevent their use beyond expiration. </p><br>

							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1 ">
										<input type="radio" name="wave_q3" class="show_radio" value="a" required>
									</div>
									<div class="col-8 pl-0">
										6 months; 7/1/06
									</div>
								</div>
							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q3" class="show_radio" value="b" required>
									</div>
									<div class="col-8 pl-0">
										3 months; 4/1/07
									</div>
								</div>
							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q3" class="show_radio" value="c" required>
									</div>
									<div class="col-8 pl-0">
										3 months; 3/28/07
									</div>
								</div>
							</div>

							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q3" class="show_radio" value="d" required>
									</div>
									<div class="col-8 pl-0">
										9 months; 10/1/07
									</div>
								</div>
							</div>


						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Prior to performing a finger stick, the patient must wash their hands if possible. Then the operator must wipe the fingertip with alcohol and allow their hair to dry. Failure to thoroughly clean the fingertip and eliminate any sugary food remnants (for example, after the patient has eaten breakfast) may lead to these substances being measured as part of the patient’s blood sugar or a falsely elevated glucose test. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;Maintenance of the Accuchek Inform requires wiping of meter surfaces using a clothdampened with ____. Whichever agent is used, one should never spray meter directly, or submerse it in solution. Also, the meter must never be exposed to high temperatures (i.e. isolettes) for longer than ____. </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q5" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										10% bleack or 70% isopropyl alcohol BUT NOT Cavicide because it damages the meter’s screen; 10 seconds
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q5" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Cavicide or 10% bleach BUT NOT 70% isopropyl alcohol because it damages the meter’s screen; 10 seconds
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q5" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Cavicide or 70% isopropyl alcohol BUT NOT 10% bleach because it damages the meter’s screen; 10 seconds
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q5" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										I give up…way too confusing, we use cavicide anyways!; 10 seconds
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;Identify the properly dosed test strip by clicking on test strips 1, 2, 3 and 4 below. For improperly dosed test strips, reapplication of sample is acceptable as long as it is done with _____ seconds.
									Note: To view test strip imagine must click on the individual blue link below
									e is 3/28/07 is ______, and should be written on both vials to prevent their use beyond expiration. </p><br>

							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q6" class="show_radio" value="a" required>
									</div>
									<div class="col-8 pl-0">
										Test strip 1; 15 seconds
									</div>
								</div>
							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q6" class="show_radio" value="b" required>
									</div>
									<div class="col-8 pl-0">
										Test strip 2; 15 seconds
									</div>
								</div>
							</div>
							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q6" class="show_radio" value="c" required>
									</div>
									<div class="col-8 pl-0">
										Test strip 3; 20 seconds
									</div>
								</div>
							</div>

							<div class="col-3 col-md-3 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="wave_q6" class="show_radio" value="d" required>
									</div>
									<div class="col-8 pl-0">
										Test strip 4; 15 minutes
									</div>
								</div>
							</div>


						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;A critical blood glucose result for an adult is a value that is ______. Critical results are documented on the Accuchek Inform using the _____ comment code. </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q7" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Less than 50 mg/dl or greater than 450 mg/dl; notified provider
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q7" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Less than 10 mg/dl or greater than 600 mg/dl; notified provider
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q7" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Less than 10 mg/dl or greater than 600 mg/dl; notified provider
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q7" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Less than 40 mg/dl or greater than 110 mg/dl; operator error
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>8.&nbsp;&nbsp;As of 2005, Joint Commission requires documentation of blood glucose results in the medical record include: </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q8" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The control lot number in use
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q8" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The strip lot number in use
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q8" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The glucometer serial number
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q8" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The glucose reference (normal) range
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-7">
							<div class="col-12 ">
								<p>9.&nbsp;&nbsp;Interfering substances are those substances which may lead to lower or higher BG results (depending on substance type). Manufacturers are obligated to disclose those substances.
									As an Accuchek Inform user, you should be aware of the following interfering substances and how each one impacts the BG result. </p><br>

							</div>

							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q9" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Maltose, Xylose, Galactose (elevate result)
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q9" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Estrogens (decrease result)
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q9" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Bilirubin levels > 20 mg/dl (elevate result)
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q9" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										a & c
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>10.&nbsp;&nbsp;Controls must be performed when: </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q10" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										A new lot of strips is opened, or improper storage is suspected (i.e. refrigerated strips, or vial left open)
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q10" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Once per shift
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q10" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The meter has been dropped
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q10" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										The patient’s clinical symptom’s do not really correlate with the BG result
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="wave_q10" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										All of the above
									</div>
								</div>
							</div>

						</div>

					</div>

					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="submit_waive" class="btn btn-primary submit action-button" value="Submit">
						</div>
					</div>
				</fieldset>
				<fieldset class="hepa_b hepab_test">
					<div class=" eval_class  form-card">
						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="hepab_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="hepab_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="hepab_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="hepa_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_hepab_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_hepab_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;Patients infected with HBV who show no symptoms and have normal liver function tests are "healthy carriers."</p><br>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;Between 5% and 15% of all Asian and Pacific Islander Immigrants are chronically infected with hepatitis B. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;A HBV carrier is less likely to have serious complications than people with chronic HBV. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q3" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q3" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>



						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Hepatitis B is transmitted through eating contaminated food. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>5.&nbsp;&nbsp; Approximately one million people worldwide die annually from hepatitis B.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;There is no way of preventing liver cancer (hepatocellular carcinoma, HCC). </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q6" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q6" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;There is no way of preventing liver cancer (hepatocellular carcinoma, HCC). </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q7" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q7" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>8.&nbsp;&nbsp; Liver cancer is caused by alcohol. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q8" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q8" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-7">
							<div class="col-12 ">
								<p>9.&nbsp;&nbsp;A positive Hepatitis B Surface Antigen (HBsAg) test means the individual tested is chronically infected with the hepatitis B virus.</p><br>

							</div>

							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q9" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q9" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>10.&nbsp;&nbsp;Children born to a HBV chronically infected mother will always be chronically infected with HBV. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q10" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q10" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>11.&nbsp;&nbsp;A booster shot of the HBV vaccine is recommended after the 3-dose vaccination series is completed.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q11" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="hepab_q11" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<!-- 	 -->
						<div class="row">
							<div class="col-md-12">
								<input type="submit" name="submit_hepab" class="submit action-button" value="Submit" />
								<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset class="harass harassment_test">
					<div class=" eval_class  form-card">
						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="harass_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="harass_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="harass_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="harass_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_harass_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_harass_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;If no one complains, then it’s not sexual harassment.</p><br>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;If my intentions were good - for example, I meant to compliment someone on how great they looked there is no way my conduct could violate the sexual harassment policy. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;It cannot be sexual harassment if both parties are the same gender. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1 ">
										<input type="radio" name="harass_q3" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q3" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>



						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Quid Pro Quo harassment occurs when a female boss tells dirty jokes to the other women in the office.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-3">
							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;If someone is offended by my behavior in the break room, they should take their break somewhere else, or at another time, since I am not “working” while I’m on my break and I have a right to freedom of speech.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;If most people find a comment amusing and inoffensive, then the one person who is offended does not have a right to complain about harassment.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q6" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q6" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;Harassment based on sex can include making stereotypical remarks about someone’s gender.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q7" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q7" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>8.&nbsp;&nbsp;Sexual harassment can only come from a boss or coworker.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q8" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q8" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-7">
							<div class="col-12 ">
								<p>9.&nbsp;&nbsp;Sexual harassment is prohibited by law and is also prohibited by my employer’s policy.</p><br>

							</div>

							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q9" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q9" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>10.&nbsp;&nbsp;Harassment or discrimination based on sex, race, color, religion, national origin, age, disability, ancestry, or any other characteristic protected by federal, state or local law is unlawful and also violates my employer’s policy. </p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q10" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q10" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>11.&nbsp;&nbsp;Sexual harassment includes unwelcome sexual advances or romantic interest, or other unwelcome conduct that may be verbal, visual, or physical.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q11" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q11" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>12.&nbsp;&nbsp;Sexual harassment involves offering job benefits in exchange for sexual favors, or alternatively threatening a person’s job if they don’t agree to the offer.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q12" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q12" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>13.&nbsp;&nbsp;It is unlawful, and a violation of the company’s policy, to retaliate against someone who resists unwelcome behavior, files a complaint about harassment or perceived harassment, or participates in an investigation.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q13" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q13" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-7">
							<div class="col-12 ">
								<p>14.&nbsp;&nbsp;Employees are subject to disciplinary action, up to and including termination for engaging in unlawful harassment or discrimination.</p><br>

							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q14" class="show_radio" value="true" required>
									</div>
									<div class="col-8 pl-0">
										True
									</div>
								</div>
							</div>
							<div class="col-3 col-md-2 mt-2">
								<div class="row">
									<div class="col-4 pr-1">
										<input type="radio" name="harass_q14" class="show_radio" value="false" required>
									</div>
									<div class="col-8 pl-0">
										False
									</div>
								</div>
							</div>

						</div>
						<!-- 	 -->
						<div class="row">
							<div class="col-md-12">
								<input type="submit" name="submit_harass" class="submit action-button" value="Submit" />
								<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
							</div>
						</div>
					</div>
				</fieldset>

				<fieldset class="handhygiene hand_hygiene_test">
					<div class="eval_class form-card">

						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="handhygiene_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="handhygiene_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="handhygiene_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="hh_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_handhygiene_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_handhygiene_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;In which of the following situations should hand hygiene be performed? </p>
								<div class="col-12">
									<p>A. Before having direct contact with a patient</p>
									<p>B. Before inserting an invasive device (e.g., intravascular catheter, foley catheter)</p>
									<p>C. When moving from a contaminated body site to a clean body site during an episode of patient care</p>
									<p>D. After having direct contact with a patient or with items in the immediate vicinity of the patient</p>
									<p>E. After removing gloves</p>

								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q1" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										B and E
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q1" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										A, B and D
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q1" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										B, D and E
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q1" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										All of the above
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;If hands are not visibly soiled or visibly contaminated with blood or other proteinaceous material, which of the following regimens is the most effective for reducing the number of pathogenic bacteria on the hands of personnel? </p><br>


							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q2" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Washing hands with plain soap and water
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q2" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Washing hands with an antimicrobial soap and water
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q2" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Applying 1.5 ml to 3 ml of alcohol-based hand rub to the hands and rubbing hands together until they feel dry
									</div>
								</div>
							</div>


						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;How are antibiotic-resistant pathogens most frequently spread from one patient to another in health care settings? </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q3" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Airborne spread resulting from patients coughing or sneezing
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q3" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Patients coming in contact with contaminated equipment
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q3" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										From one patient to another via the contaminated hands of clinical staff
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q3" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Poor environmental maintenance
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Which of the following infections can be potentially transmitted from patients to clinical staff if appropriate glove use and hand hygiene are not performed </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q4" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Herpes simplex virus infection
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q4" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Colonization or infection with methicillin-resistant Staphylococcus aureus
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q4" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Respiratory syncytial virus infection
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q4" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Hepatitis B virus infection
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q4" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Hepatitis B virus infection
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>5.&nbsp;&nbsp; Clostridium difficile (the cause of antibiotic-associated diarrhea) is readily killed by alcohol-based hand hygiene products </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>


						</div>
						<div class="row">
							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;Which of the following pathogens readily survive in the environment of the patient for days to weeks?</p>
								<div class="col-12">
									<p>A. E. coli</p>
									<p>B. Klebsiella spp</p>
									<p>C. Clostridium difficile (the cause of antibiotic-associated diarrhea)</p>
									<p>D. Methicillin-resistant Staphyloccus aureus (MRSA)</p>
									<p>E. Vancomycin-resistant enterococcus (VRE)</p>

								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q6" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										A and D
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q6" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										A and B
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q6" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										C, D and E
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q6" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										All of the above
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;Which of the following statements about alcohol-based hand hygiene products is accurate? </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q7" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										They dry the skin more than repeated handwashing with soap and water
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q7" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										They cause more allergy and skin intolerance than chlorhexidine gluconate products
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q7" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										They cause stinging of the hands in some providers due to pre-existing skin irritation
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q7" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										They cause stinging of the hands in some providers due to pre-existing skin irritation
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="hh_q7" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										They kill bacteria less rapidly than chlorhexidine gluconate and other antiseptic containing soaps
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="submit_hh" class="submit action-button" value="Submit" />
							<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
						</div>
					</div>
				</fieldset>
				<fieldset class="emergency emergency_test">
					<div class="eval_class form-card">

						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="emergency_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="emergency_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="emergency_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="emerg_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_emergency_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_emergency_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;Where does staff report to during an emergency if office is down? </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q1" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Owner of agency
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q1" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Director of nursing
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q1" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Your own house
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q1" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Stand by the office and wait for someone to arrive
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;How often does staff get trained on emergency management by organization? </p><br>


							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q2" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Annually
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q2" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Twice annually
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q2" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Only upon hire
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q2" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										No set requirements
									</div>
								</div>
							</div>


						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;If communication is down and phone lines are not working, how do you know which patient you need to see? </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q3" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Stay home until DPCS contacts you
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q3" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										See patients based on acuity level
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q3" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Go to CEOs house and wait for further instruction
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q3" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Do not see patient and assume DPCS will coordinate care
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Once an acuity level is established you cannot change their acuity level.</p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>


						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;Agency must give you roles and responsibilities of emergency upon hire. </p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>


						</div>
						<div class="row mt-3">
							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;There is communication phone tree which staff should follow during an emergency</p><br>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q6" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="emerg_q6" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="submit_emerg" class="submit action-button" value="Submit" />
							<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
						</div>
					</div>
				</fieldset>
				<fieldset class="covid covid_test">
					<div class="eval_class form-card">

						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="covid_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="covid_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="covid_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="covid_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_covid_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_covid_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;If you have symptoms of physical illness that are not consistent with Covid-19 you should report to work as normal. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;All Royal Crown Home Health Care employees are required to self-monitor for Covid-19 symptoms daily prior to coming to work and visiting patients </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;Face Coverings are required to be properly worn, covering nose and mouth, while in the facility or visiting patients EXCEPT during portions of a rest/meal break where it is not feasible (due to eating or drinking) or during a face covering exchange period. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q3" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q3" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Office employees are not required to wear face covering.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;I understand the guidance outlined in this document. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;I understand the guidance outlined in this document. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q6" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q6" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;I understand the guidance outlined in this document. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q7" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="covid_q7" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="submit_covid" class="next action-button" value="Submit" />
							<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
						</div>
					</div>
				</fieldset>
				<fieldset class="bloodpatho bloodpatho_test">
					<div class="eval_class form-card">

						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="bloodpatho_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="bloodpatho_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="bloodpatho_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="patho_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_bloodpatho_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_bloodpatho_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;There is currently no vaccination available for Hepatitis B. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;Blood is the only bodily fluid that can carry pathogens.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;It is important to understand and follow your employer’s policies regarding bloodborne pathogens.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q3" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q3" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;The relative risk of exposure to bloodborne pathogens is great. However, once exposed the diseases are not that serious.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;AIDS is caused by which virus?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q5" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										HIV
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q5" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										HBV
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q5" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										HCV
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;Biological hazardous waste bags should be what color?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q6" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Green or Blue
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q6" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Red or Red-Orange
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q6" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Clear or Black
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;Personal protective equipment is an important line of defense against exposure to bloodborne pathogens.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q7" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q7" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>8.&nbsp;&nbsp;How often should Exposure Control Plans be reviewed and updated?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q8" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Monthly
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q8" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Annually
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q8" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Once each decade
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>9.&nbsp;&nbsp;Hepatitis B and Hepatitis C attack which organ?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q9" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Heart
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q9" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Lungs
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q9" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Liver
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q9" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Pancreas
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>10.&nbsp;&nbsp;Universal Precautions means treating bodily fluids as if they are known to be infectious.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q10" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q10" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>11.&nbsp;&nbsp;There are only 3 bloodborne diseases. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q11" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q11" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>12.&nbsp;&nbsp;The Hepatitis B Vaccination has been proven to prevent the disease in approximately what percentage of those receiving the vaccine</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q12" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										100%
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q12" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										95%
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q12" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										90%
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q12" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										70%
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>13.&nbsp;&nbsp;Disposable PPE can be reused if it is properly decontaminated. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q13" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q13" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>14.&nbsp;&nbsp;All persons infected with a bloodborne pathogen will begin showing symptoms soon after infection. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q14" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q14" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>15.&nbsp;&nbsp;PPE should be selected based upon the types of exposure that are reasonably anticipated. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q15" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q15" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>16.&nbsp;&nbsp;Hand washing is an important part of disease prevention. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q16" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q16" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>17.&nbsp;&nbsp;THand washing is an important part of disease prevention. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q17" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q17" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>18.&nbsp;&nbsp;Contaminated waste should immediately be placed in the nearest wastebasket. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q18" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q18" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>19.&nbsp;&nbsp;An incident report should only be completed if you do not know whose blood you were exposed to. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q19" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q19" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>20.&nbsp;&nbsp;The Needlestick Safety and Prevention Act requires the use of safer needles and disposal containers. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q20" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="bp_q20" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="submit_bp" class="submit action-button" value="Submit" />
							<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
						</div>
					</div>
				</fieldset>
				<fieldset class="glucometer glucometer_test">
					<div class="eval_class form-card">
						<div class="row">
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
									<span class="label-input100">Staff Name:</span>
									<select name="gluco_staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Staff Name</option>
										<?php foreach ($staff_records as $staff_id => $staff_rec) { ?>
											<option value="<?= $staff_id ?>"><?= $staff_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
									<span class="label-input100">Employee Name:</span>
									<select name="gluco_employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
										<option value="">Select Employee Name</option>
										<?php foreach ($employee_records as $emp_id => $emp_rec) { ?>
											<option value="<?= $emp_id ?>"><?= $emp_rec ?></option>
											<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

										<?php } ?>
									</select>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 validatez-input" data-validate="Date is required">
									<span class="label-input100">Date:</span>
									<input class="input100 ml-2 mt-2" type="date" name="gluco_date_filled" placeholder="Enter Date" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 ">
								<div class="wrap-input100 validatez-input" data-validate="No of Hours is required">
									<span class="label-input100">No. of Training Hours:</span>
									<input class="input100 ml-2 mt-2" type="number" step="any" name="gluco_num_hour" placeholder="Enter Hours" min="1" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3 ">
								<div class="wrap-input100 ">
									<span class="label-input100">Prefilled with correct answer:</span>
									<div class="row">
										<div class="col-3">
											<input class=" ml-2 mt-2 show_radio" type="radio" name="is_gluco_prefilled" value="yes" placeholder="">
										</div>
										<div class="col-3 pl-0 mt-1">Yes</div>
										<div class="col-3"><input class=" ml-2 mt-2 show_radio" type="radio" name="is_gluco_prefilled" value="no" placeholder="" checked></div>
										<div class="col-3 pl-0 mt-1">No</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>1.&nbsp;&nbsp;Quality controls should be performed; every 24 hours, after a meter has been dropped or damaged, and when the patient’s result contradicts the patient’s condition. </p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q1" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q1" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>2.&nbsp;&nbsp;Blood glucose test strips expire on the manufacturer’s printed date on the label.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q2" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q2" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>3.&nbsp;&nbsp;When not in use the glucometer can be stored in the carrying case but it must be connected to the data upload cable before and after each use to download the data to the lab.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q3" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q3" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>4.&nbsp;&nbsp;Gloves must be worn when performing blood glucose or glucose control testing and when cleaning the glucometer.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q4" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q4" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>5.&nbsp;&nbsp;The glucometer will display ‘Strip Inserted’ once the test strip is placed with the contact bars facing up into the meter.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q5" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q5" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>6.&nbsp;&nbsp;Once the test is completed, the used test strip can be disposed of in a white (non-hazardous) trash receptacle.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q6" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q6" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>7.&nbsp;&nbsp;When first opening a glucose control solution it must be dated, initialed and the new expiration (90 days from opening) date placed on the vial.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q7" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q7" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>8.&nbsp;&nbsp;If the ‘less than’ symbol (< ) occurs on a patient test, and the patient is not symptomatic, you should repeat the test prior to obtaining a laboratory sample.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q8" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q8" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>9.&nbsp;&nbsp;Only capillary, venous, arterial or heparinized and EDTA whole blood samples should be used when testing with the glucometer.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q9" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q9" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>10.&nbsp;&nbsp;Controls must come to room temperature prior to use.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q10" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q10" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>11.&nbsp;&nbsp;A Hematocrit less than 20% or if serum or plasma samples are used instead of whole blood it can cause a higher than expected glucose reading.</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q11" class="show_radio" value="true" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										True
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q11" class="show_radio" value="false" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										False
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>12.&nbsp;&nbsp;How do you know if you have applied enough blood to the target area of the Blood Glucose Test Strip?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q12" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										You must visually check the test strip
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q12" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										You will not know if you have enough sample for the test
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q12" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										You will hear an audible beep and the testing countdown will automatically start
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										You see the screen change to "Apply Sample"
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>13.&nbsp;&nbsp;Should blood or control solution come in contact with the port protector you should:</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Check for presence of blood and replace port protector if contaminated
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Check for presence of control solution and replace port protector if contaminated
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Complete test anyway and replace port protector later
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Answers a & b
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q13" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										None of the above
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>14.&nbsp;&nbsp;The Clear key will:</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q14" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Back up one space while entering numbers on the keypad
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q14" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Clear a numerical code after the Enter key is pressed
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q14" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Clear a barcode scanned by mistake
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q14" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Return to a previous menu
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q14" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										All of the above
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>15.&nbsp;&nbsp;Which of the following conditions can cause a lower than expected glucose reading?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Hematocrit higher than 70%
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Hyperglycemic, hyperosmolar state
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Dehydration, hypotension, or shock
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Water or alcohol remaining on puncture site
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Venous or arterial blood sample not tested within 30 minutes
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q15" class="show_radio" value="f" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										All of the above
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>16.&nbsp;&nbsp;What type of batteries does the Glucometer (Precision Xceed Pro Monitor) accept?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q16" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										One 9 Volt
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q16" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Two AA Batteries
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q16" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										NiMH rechargeable batteries
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q16" class="show_radio" value="d" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Answers a & c
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q16" class="show_radio" value="e" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Answers b & c
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">

							<div class="col-12 ">
								<p>17.&nbsp;&nbsp;If applicable, what is the process for verifying the patient identifier when using the Glucometer (Precision Xceed Pro Monitor)?</p>

							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q17" class="show_radio" value="a" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Confirm the Patient ID by entering the patient’s two-digit Year of Birth
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q17" class="show_radio" value="b" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Confirm the Patient ID by selecting “Confirm”
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 mt-2 ml-2">
								<div class="row">
									<div class="col-1 pl-0 ">
										<input type="radio" name="gluco_q17" class="show_radio" value="c" required>
									</div>
									<div class="col-10 pl-0 ml-n3">
										Confirm the Patient ID by manually re-entering the Patient ID number
									</div>
								</div>
							</div>

						</div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="validate_input" value="">
							<input type="submit" name="submit_gluco" class="submit action-button" style="width: 220px!important;" value="Submit" />
							<!-- <input type="button" name="previous" class="previous action-button-previous" value="Previous"/> -->
						</div>
					</div>
				</fieldset>
			</form>

		</div>

	</div>







	<div id="dropDownSelect1"></div>



	<!--===============================================================================================-->

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->

	<script src="vendor/animsition/js/animsition.min.js"></script>

	<!--===============================================================================================-->

	<script src="vendor/bootstrap/js/popper.js"></script>

	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

	<!--===============================================================================================-->

	<script src="vendor/select2/select2.min.js"></script>

	<!--===============================================================================================-->

	<script src="vendor/daterangepicker/moment.min.js"></script>

	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<!--===============================================================================================-->

	<script src="vendor/countdowntime/countdowntime.js"></script>

	<!--===============================================================================================-->

	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>

	<script src="js/map-custom.js"></script>
 -->
	<!--===============================================================================================-->

	<script src="js/main.js"></script>



	<!-- Global site tag (gtag.js) - Google Analytics -->

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>

	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}

		gtag('js', new Date());



		gtag('config', 'UA-23581568-13');
	</script>
	<script src="js/sketch.js"></script>

	<script src="lang/jquery.signfield-en.min.js"></script>

	<script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script src="js/jquery.signfield.js"></script>
	<script src="js/customtest.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
	<script>
		$(function() {
			$('select[name=position]').find('option.hospice_jb').hide();
			$('select[name=position]').find('option.both_jb,option.hm_jb,option.bothh_jb').hide();

			$('select[name=company_applying]').on('change', function() {
				var val = $(this).val();
				if (val == 'Hospice') {
					$('select[name=position]').find('option.hospice_jb,option.both_jb').show();
					$('select[name=position]').find('option.hm_jb,option.bothh_jb').hide();
				}
				if (val == 'Home Health') {
					$('select[name=position]').find('option.hospice_jb,option.bothh_jb').hide();
					$('select[name=position]').find('option.hm_jb,option.both_jb').show();

				}

				if (val == 'Both') {
					$('select[name=position]').find('option.hospice_jb,option.hm_jb').hide();
					$('select[name=position]').find('option.both_jb,option.bothh_jb').show();
				}
			});
			$('select.employee_name_class').select2();
			$('input,select').removeAttr('required');
			$('fieldset#waived_test').find('input,select').attr('required', 'required');

			// Only submit the active certificate section (avoids wrong staff from hidden dropdowns).
			$('form.contact100-form').on('submit', function() {
				var $activeFieldset = $(document.activeElement).closest('fieldset');
				if ($activeFieldset.length) {
					$('fieldset').not($activeFieldset).find('input, select, textarea').prop('disabled', true);
				}
			});
			$('.progressbar8 li').on('click', function() {
				var idref = $(this).attr('id');
				$('.progressbar8 li').removeClass('active');
				$(this).addClass('active');
				console.log(idref);
				$('fieldset').fadeOut();
				$('input,select').removeAttr('required');
				$('fieldset.' + idref).find('input,select').attr('required', 'required');
				$('.' + idref).show();
			});

			$('input[name=is_waived_prefilled]').on('change', function() {
				var val = $('input[name=is_waived_prefilled]:checked').val();
				var akey = ["true", "true", "b", "true", "c", "a", "a", "b", "d", "d"];

				if (val == 'yes') {
					for (x = 1; x <= 10; x++) {
						console.log(akey[x]);
						$('input[name=wave_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=wave_]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_hepab_prefilled]').on('change', function() {
				var val = $('input[name=is_hepab_prefilled]:checked').val();
				var akey = ["false", "true", "false", "false", "true", "false", "false", "false", "true", "false", "false"];

				if (val == 'yes') {
					for (x = 1; x <= 11; x++) {
						console.log(akey[x]);
						$('input[name=hepab_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=hepab_]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_harass_prefilled]').on('change', function() {
				var val = $('input[name=is_harass_prefilled]:checked').val();
				var akey = ["false", "false", "false", "false", "false", "false", "true", "false", "true", "true", "true", "true", "true", "true"];

				if (val == 'yes') {
					for (x = 1; x <= 14; x++) {
						console.log(akey[x]);
						$('input[name=harass_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=harass_q]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_handhygiene_prefilled]').on('change', function() {
				var val = $('input[name=is_handhygiene_prefilled]:checked').val();
				var akey = ["d", "c", "c", "e", "false", "c", "c"];

				if (val == 'yes') {
					for (x = 1; x <= 7; x++) {
						console.log(akey[x]);
						$('input[name=hh_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=hh_q]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_emergency_prefilled]').on('change', function() {
				var val = $('input[name=is_emergency_prefilled]:checked').val();
				var akey = ["a", "b", "b", "false", "true", "true"];

				if (val == 'yes') {
					for (x = 1; x <= 6; x++) {
						console.log(akey[x]);
						$('input[name=emerg_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=emerg_q]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_covid_prefilled]').on('change', function() {
				var val = $('input[name=is_covid_prefilled]:checked').val();
				var akey = ["false", "true", "true", "false", "true", "true", "true"];

				if (val == 'yes') {
					for (x = 1; x <= 7; x++) {
						console.log(akey[x]);
						$('input[name=covid_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=covid_q]').prop('checked', false);;
				}
				// console.log(val);
			});


			$('input[name=is_bloodpatho_prefilled]').on('change', function() {
				var val = $('input[name=is_bloodpatho_prefilled]:checked').val();
				var akey = ["false", "false", "true", "false", "a", "b", "true", "b", "c", "true", "false", "b", "false", "false", "true", "false", "true", "false", "false", "true"];

				if (val == 'yes') {
					for (x = 1; x <= 20; x++) {
						console.log(akey[x]);
						$('input[name=bp_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=bp_q]').prop('checked', false);;
				}
				// console.log(val);
			});

			$('input[name=is_gluco_prefilled]').on('change', function() {
				var val = $('input[name=is_gluco_prefilled]:checked').val();
				var akey = ["true", "true", "true", "true", "true", "true", "true", "true", "true", "true", "true", "c", "d", "e", "f", "b", "a"];

				if (val == 'yes') {
					for (x = 1; x <= 17; x++) {
						console.log(akey[x]);
						$('input[name=gluco_q' + x + '][value="' + akey[x - 1] + '"]').prop('checked', 'checked');
					}
				} else {
					$('input[name^=gluco_q]').prop('checked', false);;
				}
				// console.log(val);
			});



		})
	</script>
	<script src="cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>