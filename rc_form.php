<?php

 require_once('database.php');
   $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $conn = $db->Conn();
    if(isset($_GET['ref']) && !empty($_GET['ref'])){

    		$ref = base64_decode($_GET['ref']);
     		$sql = "SELECT * FROM `tbl_job_applications` where id='".$ref."' ";
		  $result_logged = $conn->query($sql);
		  $record_details= $result_logged->fetch_assoc();
		  if(!empty($record_details)){
		  	$name = strtoupper($record_details['first_name']." ".$record_details['last_name']);
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

		  }else{
		  		echo "Unauthorized Access";exit;
		  }
		  // echo "<pre>",print_r($record_details),"</pre>";die();
    }else{
    		echo "Unauthorized Access";exit;
    }
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Reference Check Form</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->

	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

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


</head>

<body>





	<div class="container-contact100">

		<div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>



		<div class="wrap-contact100">

			<div class="contact100-form-title">

			

			</div>

			<?php
			if(isset($_GET['s']) && !empty($_GET['s'])){
				
			
			?>
			<div class="badge-md mt-4 m-4 badge-success">

					&nbsp;&nbsp;&nbsp;Form was successfully submitted! Click <a href="<?='manage/view/'.base64_encode($ref)?>">here</a> to view generated file.

			</div>



		<?php exit;} ?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;REFERENCE CHECK FOR <?=$name?>
			</div>

			<hr>

			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="rc_process.php" >

				    
                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
              
                <fieldset class="jo">
                	<div class="form-card">
                	
						<div class="row">
                			<div class="col-md-12">
                				<h5>Reference 1:</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                			   <div class="col-md-4">
                					<p>Reference Name: <?=$record_details['prof_ref_name_1']?></p>
                				</div>
                				<div class="col-md-4">
                					<p>Telephone: <?=$record_details['prof_ref_tel_1']?></p>
                				</div>
                				<div class="col-md-4">
                					<p>Company: <?=$record_details['prof_ref_company_1']?></p>
                				</div>
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Checked Date is required">
									<span class="label-input100">Checked Date:</span>
									<input class="input100" type="date" name="date_filled_1" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Reference Checked is required">
									<span class="label-input100">Reference Checked By:</span>
									<input class="input100" type="text" name="reference_checked_name_1" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Reference Checked is required">
									<span class="label-input100">Title:</span>
									<input class="input100" type="text" name="reference_title_1" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>	
                		<div class="row mt-3">	
                			<div class="col-md-12">
                				<p>CRITERIA:</p>

                			</div>
                			<div class="col-md-12">

								<div class="wrap-input100 validate-input mb-0" data-validate="Expiration is required">
									<span class="label-input100">Attendance:</span><br>
									<input class="radio_input" type="radio" name="ref_attendance_1" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_attendance_1" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_attendance_1" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_attendance_1" value="Unsatisfactory" placeholder="" required> Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Attitude:</span><br>
									<input class="radio_input" type="radio" name="ref_attitude_1" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_attitude_1" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_attitude_1" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_attitude_1" value="Unsatisfactory" placeholder="" required> Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Job Performance:</span><br>
									<input class="radio_input" type="radio" name="ref_job_performance_1" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_job_performance_1" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_job_performance_1" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_job_performance_1" value="Unsatisfactory" placeholder="" required> Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Job Knowledge:</span><br>
									<input class="radio_input" type="radio" name="ref_job_knowledge_1" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_job_knowledge_1" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_job_knowledge_1" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_job_knowledge_1" value="Unsatisfactory" placeholder="" required> Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Quality of Work:</span><br>
									<input class="radio_input" type="radio" name="ref_quality_work_1" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_quality_work_1" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_quality_work_1" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_quality_work_1" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>				
                		
					</div>

					<div class="form-card">
                	
						<div class="row">
                			<div class="col-md-12">
                				<h5>Reference 2:</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                			   <div class="col-md-4">
                					<p>Reference Name: <?=$record_details['prof_ref_name_2']?></p>
                				</div>
                				<div class="col-md-4">
                					<p>Telephone: <?=$record_details['prof_ref_tel_2']?></p>
                				</div>
                				<div class="col-md-4">
                					<p>Company: <?=$record_details['prof_ref_company_2']?></p>
                				</div>
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Checked Date is required">
									<span class="label-input100">Checked Date:</span>
									<input class="input100" type="date" name="date_filled_2" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Reference Checked is required">
									<span class="label-input100">Reference Checked By:</span>
									<input class="input100" type="text" name="reference_checked_name_2" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Reference Checked is required">
									<span class="label-input100">Title:</span>
									<input class="input100" type="text" name="reference_title_2" placeholder="" >
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>	
                		<div class="row mt-3">	
                			<div class="col-md-12">
                				<p>CRITERIA:</p>

                			</div>
                			<div class="col-md-12">

								<div class="wrap-input100 validate-input mb-0" data-validate="Expiration is required">
									<span class="label-input100">Attendance:</span><br>
									<input class="radio_input" type="radio" name="ref_attendance_2" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_attendance_2" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_attendance_2" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_attendance_2" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Attitude:</span><br>
									<input class="radio_input" type="radio" name="ref_attitude_2" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_attitude_2" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_attitude_2" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_attitude_2" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Job Performance:</span><br>
									<input class="radio_input" type="radio" name="ref_job_performance_2" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_job_performance_2" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_job_performance_2" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_job_performance_2" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Job Knowledge:</span><br>
									<input class="radio_input" type="radio" name="ref_job_knowledge_2" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_job_knowledge_2" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_job_knowledge_2" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_job_knowledge_2" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
								<hr>
							</div>
							<div class="col-md-12">
								<div class="wrap-input100 validate-input  mb-0 mt-0" data-validate="Expiration is required">
									<span class="label-input100">Quality of Work:</span><br>
									<input class="radio_input" type="radio" name="ref_quality_work_2" value="outstanding" placeholder="" required> Outstanding
									<input class="radio_input" type="radio" name="ref_quality_work_2" value="good" placeholder="" > Good
									<input class="radio_input" type="radio" name="ref_quality_work_2" value="needs improvement" placeholder="" > Needs Improvement
									<input class="radio_input" type="radio" name="ref_quality_work_2" value="Unsatisfactory" placeholder="" > Unsatisfactory
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>				
                		
					</div>
                	<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="ref" value="<?=$ref?>" required>
							   <input type="submit" name="submit" class="next action-button" value="Submit"/>
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

	  function gtag(){dataLayer.push(arguments);}

	  gtag('js', new Date());



	  gtag('config', 'UA-23581568-13');

	</script>
 <script src="js/sketch.js"></script>

    <script src="lang/jquery.signfield-en.min.js"></script>

             <script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="js/jquery.signfield.js"></script>
    <!-- <script src="js/custom3.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>

    </script>

</body>

</html>

