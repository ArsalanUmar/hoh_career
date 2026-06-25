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

		  // echo "<pre>",print_r($record_details),"</pre>";die();
          if(!empty($record_details)){
          	$organization = $record_details['organization'];
          	$position = $record_details['position'];
          	// Default organization when not provided to keep flow working
          	if (empty($organization)) {
          		$organization = 'Home Health';
          	}
          	$jo_pdf_file = '';
          	$jo_pdf_file_2 = "";
		        if($organization == 'Both'){

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
            }


            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file_2 = 'pdf/jo_hc_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file_2 = 'pdf/jo_hc_lvc.pdf';
            }else if($position == 'Medical Social Worker'){
              $jo_pdf_file_2 = 'pdf/jo_hc_medical_social_worker.pdf';
            }else if($position == 'Social Health Aid'){
              $jo_pdf_file_2 = 'pdf/jo_hc_hospital_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file_2 = 'pdf/jo_hc_registered_nurse.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file_2 = 'pdf/jo_hc_office_manager.pdf';
            }else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file_2 = 'pdf/jo_receptionist.pdf';
            }else if($position == 'Bereavement Coordinator'){
              $jo_pdf_file_2 = 'pdf/jo_hc_bereavement.pdf';
            }else if($position == 'Chaplain'){
              $jo_pdf_file_2 = 'pdf/jo_hc_chaplain.pdf';
            }else if($position == 'Referral/Intake Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_intake.pdf';
            }else if($position == 'Social Services Supervisor'){
              $jo_pdf_file_2 = 'pdf/jo_hc_social_service_supervisor.pdf';
            }else if($position == 'Volunteer'){
              $jo_pdf_file_2 = 'pdf/jo_hc_volunteer.pdf';
            }else if($position == 'Human Resources'){
              $jo_pdf_file_2 = 'pdf/jo_human_resource.pdf';
            }else if($position == 'Medical Director'){
              $jo_pdf_file_2 = 'pdf/jo_hc_medical_director.pdf';
            }else if($position == 'Managed Care Coordinator'){
              $jo_pdf_file_2 = 'pdf/jo_hc_managed_care.pdf';
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
            }
          }elseif($organization == 'Hospice'){

            if($position == 'Clinical Supervisor/Nursing Supervisor'){
              $jo_pdf_file = 'pdf/jo_hc_clinical_supervisor.pdf';
            }else if($position == 'Clinical Director/Director of Patient Care Services'){
              $jo_pdf_file = 'pdf/jo_hc_dpcs.pdf';
            }else if($position == 'Licensed Vocational Nurse'){
              $jo_pdf_file = 'pdf/jo_hc_lvc.pdf';
            }else if($position == 'Medical Social Worker'){
              $jo_pdf_file = 'pdf/jo_hc_medical_social_worker.pdf';
            }else if($position == 'Social Health Aid'){
              $jo_pdf_file = 'pdf/jo_hc_hospital_aide.pdf';
            }else if($position == 'Registered Nurse'){
              $jo_pdf_file = 'pdf/jo_hc_registered_nurse.pdf';
            }else if($position == 'Office Manager'){
              $jo_pdf_file = 'pdf/jo_hc_office_manager.pdf';
            }else if($position == 'Secretary/Receptionist'){
              $jo_pdf_file = 'pdf/jo_receptionist.pdf';
            }else if($position == 'Bereavement Coordinator'){
              $jo_pdf_file = 'pdf/jo_hc_bereavement.pdf';
            }else if($position == 'Chaplain'){
              $jo_pdf_file = 'pdf/jo_hc_chaplain.pdf';
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
            }else if($position == 'Managed Care Coordinator'){
              $jo_pdf_file = 'pdf/jo_hc_managed_care.pdf';
            }
          }

        }
      
		  
		  	$agreement_file = 'pdf/job_agreement.pdf';
		  	$orientation_file = 'pdf/Orientation Topics Covered.pdf';

		  }else{
		  		echo "Unauthorized Access";exit;
		  }
		  // echo "<pre>",print_r($record_details),"</pre>";die();
    }else{
    		echo "Unauthorized Access";exit;
    }
// 
    // echo $jo_pdf_file;die();
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Digital Signature Form</title>

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

	<link rel="stylesheet" type="text/css" href="css/careers-brand.css">
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

			<?php
				$_jo_handbook = __DIR__ . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . 'Employee_Handbook.pdf';
			?>
			<div class="badge-md mt-4 m-4 badge-success">

					&nbsp;&nbsp;&nbsp;Form was successfully submitted! A copy of accomplished form was sent to your registered email.
					<?php if (is_readable($_jo_handbook)) : ?>
						The <strong>Employee Handbook</strong> is also sent in a <strong>second email</strong> (Subject: Your Employee Handbook – Please Review and Retain).
					<?php endif; ?>

			</div>



		<?php exit; }?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;JOB EMPLOYMENT AGREEMENT
			</div>

			<hr>

			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="jo_process.php" >

                    <ul id="progressbar" class="progressbar5 jo-form-progressbar">
                        <li class="active" id="account"><strong>Legal consent</strong></li>
                        <li id="agreement"><strong>Employment<br>agreement</strong></li>
                        <li id="jo"><strong>Job<br>description</strong></li>
                        <li id="orientation_topics" class="orientation_topics"><strong>Orientation topics<br>covered</strong></li>
                        <li id="confirm"><strong>Orientation</strong></li>
                    </ul>
                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
                <fieldset>
                	<div class="eval_class form-card">
                		<div class="row">
	                		<div class="col-md-4 col-md-offset-8">
	                				<div class="wrap-input100 validate-input" data-validate="Date is required">
										<span class="label-input100">Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required>
										<span class="focus-input100"></span>
									</div>
	                		</div>
                		</div>
                		<div class="row">
                		<div class="col-2 col-md-1 pr-0" >
	   				 				<input type="checkbox" name="legal_consent_agree" required >
	   				 	</div>
	   				 	<div class="col-10 pl-0">
						I agree and understand that by signing the Electronic Signature Acknowledgment and Consent Form, that all electronic signatures are the legal equivalent of my manual/handwritten signature and I consent to be legally bound to this agreement. I further agree my signature on this document is as valid as if I signed the document in writing. This is to be used in conjunction with the use of electronic signatures on all forms regarding any and all future documentation with a signature requirement, should I elect to have signed electronically.
Under penalty of perjury, I herewith affirm that my electronic signature, and all future electronic signatures, were signed by myself with full knowledge and consent and am legally bound to these terms and conditions.
						</div>
					</div>
					<div class="row">
		   				 				
						<div class="col-md-12 wrap-input100 validate-input row " data-validate = "Service Provider Representative is required">
							<div class="col-md-12 text_left">
							<span class="label-input100 f13">Consent Signature:</span>
						</div>
					</div>
						<div class="col-md-12">
		 						 <div id="mySignature" data-name="mySignature" data-max-size="2048" data-width="600"    data-height="210" 	 data-pen-tickness="3" data-pen-color="black" 
		          				   class="sign-field"></div>

							<span class="focus-input100"></span>
						</div>

					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="button" name="next" class="btn btn-primary next action-button" value="Next">
						</div>
					</div>
						</div>
                </fieldset>
                <fieldset class="agreement">
                	<div class="form-card">
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Employment Agreement</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                				<div class="col-md-12">
                					<p>By signing the pad you have agreed in the document presented below the form or click this <a href ="<?=$agreement_file?>" class="a_blue" target="_blank">link</a> for better view. </p>
                				</div>
                		</div>
                	
	                	
	                	 <div class="row mt-3">
	                	 	<!--   <div class="col-md-4 col-md-offset-8">
	                	 	  	<div class="wrap-input100 validate-input" data-validate = "Initial is required">
	                	 	  			<span class="label-input100">Initial:</span>
									<input class="input100 " type="text" name="initial" placeholder="Enter Initials" required>
									<span class="focus-input100"></span>
								</div>
	                	 	  </div> -->
	                	   <div class="col-md-12">
							<div class="wrap-input100 validate-input" data-validate = "Signature is required">

								<span class="label-input100 f13"> Signature:</span>
				 			 <div id="mySignature2" data-name="mySignature2" data-width="600"    data-height="210" 	  data-max-size="2048" 
				             data-pen-tickness="3" data-pen-color="black" 
				             class="sign-field"></div>

									<span class="focus-input100"></span>

								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
							   <input type="button" name="next" class="next action-button" value="Next"/>
                       			 <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
						</div>

							<div class="row mt-3">
                			<div class="col-md-12 ">
                				  <!-- <embed src="<?=$agreement_file?>" width="100%" height="1200px"/> -->
                				  	 <embed src="<?=$agreement_file?>" width="100%" height="500px"/> 
                				  	     <!-- <embed src='<?=$agreement_file?>' type='application/pdf' width='300px' height='500px'></embed> -->
								
	
						
                		</div>
                	</div>
                </fieldset>
                <fieldset class="jo">
                	<div class="form-card">
                	
						<div class="row">
                			<div class="col-md-12">
                				<h5>Job Description</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                <div class="col-md-12">
                					<?php if (!empty($jo_pdf_file)) { ?>
                					<p>By signing the pad you have read and understood  the following document or click this <a href ="<?=$jo_pdf_file?>" class="a_blue" target="_blank">link</a> for better view. :</p>
                					<?php } else { ?>
                					<p>By signing the pad you have read and understood the following document. The job description PDF is currently unavailable.</p>
                					<?php } ?>
                				</div>
                		</div>
                						
                		 <div class="row mt-3">
	                	 	 
	                	   <div class="col-md-12">
							<div class="wrap-input100 validate-input" data-validate = "Signature is required">

								<span class="label-input100 f13"> Signature:</span>
				 			 <div id="mySignature3" data-name="mySignature3" data-width="600"    data-height="210" 	  data-max-size="2048" 
				             data-pen-tickness="3" data-pen-color="black" 
				             class="sign-field"></div>

									<span class="focus-input100"></span>

								</div>
							</div>
						</div>	
					</div>
                	<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="ref" value="<?=$ref?>" required>
							   <input type="button" name="next" class="next action-button" value="Next"/>
                       			 <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
				 	</div>

				 	<div class="row mt-3">
                			<div class="col-md-12">
                				  <?php if (!empty($jo_pdf_file)) { ?>
                				  <embed src="<?=$jo_pdf_file?>" width="100%" height="1200px"/>
                				  <?php } ?>

							</div>
						
                		</div>		
                </fieldset>

                <fieldset class="orientation_topics">
                	<div class="form-card">
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Orientation Topics Covered</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<p>By signing the pad you have read and understood the following document or click this <a href ="<?=$orientation_file?>" class="a_blue" target="_blank">link</a> for better view. :</p>
                			</div>
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<embed src="<?=$orientation_file?>" width="100%" height="1200px"/>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                			   <input type="button" name="next" class="next action-button" value="Next"/>
                       			 <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
				 		</div>
                	</div>
                </fieldset>

				  <fieldset class="orientatation">
                	<div class="form-card">
                	
						<div class="row">
                			<div class="col-md-12">
                				<h5>Orientation Acknowledgement</h5>
                			</div>
                		</div>
                		<div class="row mt-3">
                				<div class="col-md-12">
                					<p>By signing the pad you have read and understood  the following scope of orientation :</p>


                				</div>
                				<div class="col-md-12 mt-2">
                					<p>&nbsp;&nbsp;&bull; Review of the individuals job description and duties performed and their role in the Hospice.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Organizational chart.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Hospice philosophy.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Record keeping and reporting.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Confidentiality and privacy of Protected Health Information (PHI).</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Patients rights.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Conflict of interest.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Written policies and procedures.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Emergency Plan.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Training specific to job requirements.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Additional training for special populations, if applicable (e.g., pediatrics, disease processes with specialized substance abuse).</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Cultural diversity.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Communication barriers.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Ethical issues.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Professional boundaries.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Performance Improvement Plan.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Compliance Program.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Conveying of charges for care/service.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; OSHA requirements, safety and infection control.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Orientation to equipment, if applicable as outlined in job description.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Incident/variance reporting.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Handling of patient grievances/complaints.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Medicare Certified Hospice agencies required documentation in the orientation.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; AO number for grievances.</p>
                					<p class="mt-1">&nbsp;&nbsp;&bull; Infectious Disease orientation and COVID precautions.</p>
                				</div>
                		</div>
                						
                		 <div class="row mt-3">
	                	 	 
	                	   <div class="col-md-12">
							<div class="wrap-input100 validate-input" data-validate = "Signature is required">

								<span class="label-input100 f13"> Signature:</span>
				 			 <div id="mySignature4" data-name="mySignature4" data-width="600"    data-height="210" 	  data-max-size="2048" 
				             data-pen-tickness="3" data-pen-color="black" 
				             class="sign-field"></div>

									<span class="focus-input100"></span>

								</div>
							</div>
						</div>	
					</div>
                	<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="ref" value="<?=$ref?>" required>
							   <input type="submit" name="submit" class="next action-button" value="Submit"/>
                       			 <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
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
  
    <script src="js/custom2.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


</body>

</html>

