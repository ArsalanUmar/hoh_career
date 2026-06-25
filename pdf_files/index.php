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

					&nbsp;&nbsp;&nbsp;Form was successfully submitted!

			</div>



		<?php exit; }?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;JOB APPLICATION
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="process.php" >

				    <ul id="progressbar">
                        <li class="active" id="account"><strong>Legal Consent</strong></li>
                        <li id="personal"><strong>Personal Data</strong></li>
                        <li id="applicant_release"><strong>Applicant's Signature</strong></li>
                        <li id="hepa_b"><strong>Vaccine Consent</strong></li>
                        <li id="confirm"><strong>Finish</strong></li>
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
                		<div class="col-2 col-md-1 " >
	   				 				<input type="checkbox" name="legal_consent_agree" required >
	   				 	</div>
	   				 	<div class="col-10">
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
                </fieldset>
                <fieldset class="job_sheet">
                	<div class="form-card">
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Personal Information</h5>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="First Name is required">
									<span class="label-input100">First Name:</span>
									<input class="input100" type="text" name="first_name" placeholder="Enter First Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Last Name is required">
									<span class="label-input100">Last Name:</span>
									<input class="input100" type="text" name="last_name" placeholder="Enter Last Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">Middle Initial:</span>
									<input class="input100" type="text" name="mi_name" placeholder="Enter Middle Initial" >
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Date of Birth is required">
									<span class="label-input100">Date of Birth:</span>
									<input class="input100" type="date" name="date_of_birth" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Social Security Number is required">
									<span class="label-input100 f14">Social Security Number:</span>
									<input class="input100" type="text" name="sss_number" placeholder="Enter Social Security Number" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Email Address is required">
									<span class="label-input100">Email:</span>
									<input class="input100" type="email" name="email" placeholder="Enter Email Address" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Telephone No. is required">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="tel_no" placeholder="Enter Telephone Number" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Street Address is required">
									<span class="label-input100">Street Address:</span>
									<input class="input100" type="text" name="street_address" placeholder="Enter Street Address" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="City is required" >
									<span class="label-input100 f14">City:</span>
									<input class="input100" type="text" name="city" placeholder="Enter City" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="State is required">
									<span class="label-input100">State:</span>
									<input class="input100" type="text" name="state" placeholder="Enter State" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Zip Code is required">
									<span class="label-input100">Zip Code:</span>
									<input class="input100" type="text" name="zip_code" placeholder="Enter Zip Code" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Driver License is required">
									<span class="label-input100">Driver License No:</span>
									<input class="input100" type="text" name="driver_license_no" placeholder="Enter Driver License Number" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="State is required" >
									<span class="label-input100">State:</span>
									<input class="input100" type="text" name="dl_state" placeholder="Enter State" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Expiration is required">
									<span class="label-input100">Expiration:</span>
									<input class="input100" type="date" name="dl_expiration" placeholder="" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Applying For is required">
									<span class="label-input100">Applying For:</span>
									<select class="input100 select100 " name="company_applying" required>
										<option value="">Select organization applying for</option>
										<option value="Hospice">Hospice</option>
										<option value="Home Health">Home Health</option>
										<option value="Both">Both</option>
									</select>
									<!-- <input class="input100" type="text" name="driver_license_no" placeholder="Enter driver license number"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
	                		<div class="col-md-4">
				                <div class="wrap-input100 validate-input" data-validate="Position is required">
				                  <span class="label-input100">Position</span>
				                  <select class="input100 select100 " name="position" required>
				                    <option class="both_jb" value="">Select position applying for</option>
				                    <option class="hospice_jb" value="Bereavement Coordinator">Bereavement Coordinator</option>
				                    <option class="hospice_jb" value="Chaplain">Chaplain</option>
				                    <option class="both_jb" value="Clinical Supervisor/Nursing Supervisor">Clinical Supervisor/Nursing Supervisor</option>
				                    <option  class="both_jb" value="Clinical Director/Director of Patient Care Services">Clinical Director/Director of Patient Care Services</option>
				                    <option class="hm_jb" value="Social Health Aid">Home Health Aide</option>
				                    <option class="both_jb" value="Human Resources">Human Resources</option>
				                    <option class="both_jb" value="Licensed Vocational Nurse">Licensed Vocational Nurse</option>
				                    <option class="hospice_jb" value="Managed Care Coordinator">Managed Care Coordinator</option>
				                      <option class="hospice_jb" value="Medical Director">Medical Director</option>

				                      <option class="hospice_jb" value="Medical Social Worker">Medical Social Worker</option>
				                    <option class="both_jb" value="Office Manager">Office Manager</option>
				                    <option class="hospice_jb" value="Referral/Intake Supervisor">Referral/Intake Supervisor</option>
				                    <option class="both_jb" value="Registered Nurse">Registered Nurse</option>
				                    <option class="both_jb" value="Secretary/Receptionist">Secretary/Receptionist</option>
				                      <option class="hospice_jb" value="Social Services Supervisor">Social Services Supervisor</option>
				                       <option class="hospice_jb" value="Volunteer">Volunteer</option>
				                  </select>
				                  <!-- <input class="input100" type="text" name="driver_license_no" placeholder="Enter driver license number"> -->
				                  <span class="focus-input100"></span>
				                </div>
				              </div>

							
                		</div>
                	
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Education</h5>
                			</div>

                		</div>
                		<div class="row educ_class_1">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input " data-validate="School or University is required" >
									<span class="label-input100">School or University:</span>
									<input class="input100" type="text" name="school_1" placeholder="School or University" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Major/Degree is required">
									<span class="label-input100">Major/Degree:</span>
									<select class="input100 select100" name="major_degree_1" placeholder="Enter Major/Degree" required>
										<option value="">Select Major/Degree</option>
										<option value="Associate's">Associate's</option>
										<option value="Bachelor's">Bachelor's</option>
										<option value="Doctorate">Doctorate</option>
										<option value="High School">High School</option>
										<option value="Master's">Master's</option>
										<option value="Medical Degree">Medical Degree</option>
										<option value="None">None</option>
										<option value="Technical Diploma">Technical Diploma</option>
									</select>
									<!-- <input class="input100" type="text" name="major_degree_1" placeholder="Enter Major/Degree"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Field of Study is required" >
									<span class="label-input100 f14">Field of Study:</span>
									<input class="input100" type="text" name="certificate_1" placeholder="Enter Field of Study" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 validate-input" data-validate="From Year is required">
									<span class="label-input100">From:</span>
									<input class="input100" type="text" name="years_from_1" placeholder="From Year" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 validate-input" data-validate="To is required">
									<span class="label-input100">To (Actual or Expected):</span>
									<input class="input100" type="text" name="years_to_1" placeholder="To Year" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>

                		<div class="row educ_class_1" style="display:none">
                			<div class="col-md-12">
                						<hr />
                				</div>
                				<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<input class="input100" type="text" name="school_2" placeholder="School or University">
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Major/Degree:</span>
									<select class="select100" name="major_degree_2" placeholder="Enter Major/Degree">
										<option value="">Select Major/Degree</option>
										<option value="Associate's">Associate's</option>
										<option value="Bachelor's">Bachelor's</option>
										<option value="Doctorate">Doctorate</option>
										<option value="High School">High School</option>
										<option value="Master's">Master's</option>
										<option value="Medical Degree">Medical Degree</option>
										<option value="None">None</option>
										<option value="Technical Diploma">Technical Diploma</option>
									</select>
									<!-- <input class="input100" type="text" name="major_degree_1" placeholder="Enter Major/Degree"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<input class="input100" type="text" name="certificate_2" placeholder="Enter Field of Study">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<input class="input100" type="text" name="years_from_2" placeholder="From Year">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<input class="input100" type="text" name="years_to_2" placeholder="To Year">
									<span class="focus-input100"></span>
								</div>
							</div>
							
                		</div>
                		<div class="row educ_class_1" style="display:none;">
                			<div class="col-md-12">
                						<hr />
                			</div>
                				<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<input class="input100" type="text" name="school_3" placeholder="School or University">
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " data-validate="Major/Degree is required">
									<span class="label-input100">Major/Degree:</span>
									<select class="select100   " name="major_degree_3" placeholder="Enter Major/Degree">
										<option value="">Select Major/Degree</option>
										<option value="Associate's">Associate's</option>
										<option value="Bachelor's">Bachelor's</option>
										<option value="Doctorate">Doctorate</option>
										<option value="High School">High School</option>
										<option value="Master's">Master's</option>
										<option value="Medical Degree">Medical Degree</option>
										<option value="None">None</option>
										<option value="Technical Diploma">Technical Diploma</option>
									</select>
									<!-- <input class="input100" type="text" name="major_degree_1" placeholder="Enter Major/Degree"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<input class="input100" type="text" name="certificate_3" placeholder="Enter Field of Study">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<input class="input100" type="text" name="years_from_3" placeholder="From Year">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<input class="input100" type="text" name="years_to_3" placeholder="To Year">
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
								<button class="btn btn-primary btn_add_educ" type="button"><span><i class="fa fa-plus"></i> Add educational background</span></button>
							</div>
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Emergency Contact</h5>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Name is required">
									<span class="label-input100">Name:</span>
									<input class="input100" type="text" name="emergency_name_1" placeholder="Enter Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Relationship is required" >
									<span class="label-input100 f14">Relationship:</span>
									<input class="input100" type="text" name="emergency_relationship_1" placeholder="Enter relationship" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="emergency_no_1" placeholder="Enter Telephone No." required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Work Experience</h5>
                			</div>
                		</div>
                			<div class="row work_row">

								<div class="col-md-4">
									<div class="wrap-input100 validate-input" data-validate="Job Title is required">
										<span class="label-input100 f14"  >Job Title:</span>
										<input class="input100" type="text" name="work_job_title_1" placeholder="Enter Job Title" required>
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 validate-input" data-validate="Company Name is required">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_1" placeholder="Enter Company Name" required>
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 validate-input" data-validate="State is required">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_1" placeholder="Enter Location" required>
										<span class="focus-input100"></span>
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 validate-input" data-validate="Date From is required">
										<span class="label-input100">Date of Employment From:</span>
									    <input class="input100" type="date" name="work_date_from_1" placeholder="Enter Date of Employment" required>
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_1">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_1" placeholder="Enter Date of Employment">
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
										<div class="col-md-2 pr-0">
											<input type="checkbox" name="work_currently_chk_1" value="1"> 
										</div>
										<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1 validate-input" data-validate="Role Description is required">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text" rows="2" wrap="hard" name="work_duties_1" placeholder="Describe Your Most Recent Job Duties And Accomplishments" required></textarea>
										<span class="focus-input100"></span>
									</div>
								</div>
								

                			</div>
                			<div class="row work_row" style="display:none;">
                				<div class="col-md-12">
                						<hr />
                				</div>
	                				<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14">Job Title:</span>
										<input class="input100" type="text" name="work_job_title_2" placeholder="Enter Job Title">
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_2" placeholder="Enter Company Name">
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_2" placeholder="Enter Location">
										<span class="focus-input100"></span>
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Date of Employment From:</span>
									    <input class="input100" type="date" name="work_date_from_2" placeholder="Enter Date of Employment">
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_2">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_2" placeholder="Enter Date of Employment">
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
										<div class="col-md-2 pr-0">
											<input type="checkbox" name="work_currently_chk_2" value="1"> 
										</div>
										<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text"  rows="2" wrap="hard" name="work_duties_2" placeholder="Describe Your Most Recent Job Duties And Accomplishments"></textarea>
										<span class="focus-input100"></span>
									</div>
								</div>

                			</div>
                			<div class="row work_row"  style="display:none;">
                					<div class="col-md-12">
                						<hr />
                				</div>
	                				<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14">Job Title:</span>
										<input class="input100" type="text" name="work_job_title_3" placeholder="Enter Job Title">
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_3" placeholder="Enter Company Name">
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_3" placeholder="Enter Location">
										<span class="focus-input100"></span>
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Date of Employment From:</span>
									    <input class="input100" type="date" name="work_date_from_3" placeholder="Enter Date of Employment">
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_3">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_3" placeholder="Enter Date of Employment">
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
											<div class="col-md-2 pr-0">
												<input type="checkbox" name="work_currently_chk_3" value="1"> 
											</div>
											<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text"  rows="2" wrap="hard" name="work_duties_3" placeholder="Describe Your Most Recent Job Duties And Accomplishments"></textarea>
										<span class="focus-input100"></span>
									</div>
								</div>
                			</div>
                			<div class="row">
	                			<div class="col-md-12">
									<button class="btn btn-primary btn_add_prof" type="button"><span><i class="fa fa-plus"></i> Add another professional experience</span></button>
								</div>
                			</div>
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>General Questions</h5>
                				<p>All fields are required.</p>
                			</div>
                			<div class="wrap-input100 col-md-12 row ml-1 validate-input" data-validate="This field is required">
                					<div class="col-md-8">
                					<span class="label-input100">Are you legally authorized to work in the United States for any employer?</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_usa" value="yes" placeholder="" required> Yes
										<input class="radio_input" type="radio" name="gq_usa" value="no" placeholder="" > No
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class="wrap-input100 col-md-12 row ml-1  mt-1 validate-input" data-validate="This field is required">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been excluded, sanctioned, or otherwise restricted from participation in any federal or state health care program (including Medicare or Medicaid)? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any exclusion, sanction or other restriction (past, present, or future) from participation in any federal or state health care program (including Medicare or Medicaid) to the HR Department. Please note that any exclusion, sanction, or restriction will not necessarily disqualify an application for employment?</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_health" value="yes" placeholder="" required> Yes
										<input class="radio_input" type="radio" name="gq_health" value="no" placeholder=""> No
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class=" wrap-input100 col-md-12 row ml-1 mt-1 validate-input" data-validate="This field is required">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been the subject of any disciplinary or adverse action taken by a regulatory, licensing or government agency? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any disciplinary or adverse action taken (past, present, or future) by a regulatory, licensing and government agency to the HR Department. (Examples of regulatory, licensing and government agencies include, but are not limited to, Centers for Medicare and Medicaid Services (CMS), state Medicaid programs, Department of Health and Human Services (DHHS), Office of Inspector General (OIG), and any medical or nursing boards). Please note that disciplinary or adverse action will not necessarily disqualify an application for employment.</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_license" value="yes" placeholder="" required> Yes
										<input class="radio_input" type="radio" name="gq_license" value="no" placeholder=""> No
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                	<!-- 		<div class="col-md-12 row">
                					<div class="col-md-8">
                					<span class="label-input100">Are you able to perform the tasks according to the job description without accommodation?</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_accommodation" value="yes" placeholder=""> Yes
										<input class="radio_input" type="radio" name="gq_accommodation" value="no" placeholder=""> No
									</div>
									<div class="col-md-4">
									</div> 
                			</div> -->
                		</div>
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Professional References</h5>
                			</div>
                		</div>
                		<div class="row prof_ref_1 validate-input" data-validate="This field is required">
                			<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Name:</span>
									<input class="input100" type="text" name="prof_name_1" placeholder="Enter Reference Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Company:</span>
									<input class="input100" type="text" name="prof_company_1" placeholder="Enter Company Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
						
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="prof_telno_1" placeholder="Enter Telephone No." required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
                		</div>
                		<div class="row prof_ref_1"  >
                			<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 ">
									<span class="label-input100">Name:</span>
									<input class="input100" type="text" name="prof_name_2" placeholder="Enter Reference Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Company:</span>
									<input class="input100" type="text" name="prof_company_2" placeholder="Enter Company Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="This field is required">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="prof_telno_2" placeholder="Enter Telephone No." required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
                		</div>
                		<!-- <div class="row prof_ref_1"  style="display:none;">
                			<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Name:</span>
									<input class="input100" type="text" name="prof_name_3" placeholder="Enter Reference Name">
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Company:</span>
									<input class="input100" type="text" name="prof_company_3" placeholder="Enter Company Name">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Title:</span>
									<input class="input100" type="text" name="prof_title_3" placeholder="Enter Title">
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="prof_telno_3" placeholder="Enter Telephone No.">
									<span class="focus-input100"></span>
								</div>
							</div>
							
                		</div> -->
                	<!-- 	<div class="row">
	                			<div class="col-md-12">
									<button class="btn btn-primary btn_add_ref" type="button"><span><i class="fa fa-plus"></i> Add another professional reference</span></button>
								</div>
                			</div> -->
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Resume</h5>
                			</div>
                		</div>
                		<div class="row ">
                			<div class="col-md-12">
                				<input type="file" name="resume" >
                			</div>
                		</div>
                	<!-- 	 -->
						<div class="row">
							<div class="col-md-12">
							   <input type="button" name="next" class="next action-button" value="Next"/>
                       			 <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
						</div>
                	</div>
                </fieldset>
                <fieldset>
                	<div class="form-card">
                		<div class="row">
                			
                			<div class="col-md-10">
                				I hereby certify, under penalty of perjury, that I have not knowingly withheld any information that might
adversely affect my chances for employment and that the answers given by me are true and correct to the best of my
knowledge. I further certify that I, the undersigned applicant, have personally completed this application. I understand
that any omission or misstatement of material fact on this application or on any document used to secure employment
shall be grounds for rejection of this application or for immediate discharge if I am employed, regardless of the time
elapsed before discovery.
                			</div>
                		</div>
                		<div class="row mt-3">
                		
                			<div class="col-md-10">
                				 I hereby authorize the Agency to thoroughly investigate my references, work record, education and other matters
related to my suitability for employment and, further, authorize the references I have listed to disclose to the Agency any
and all letters, reports and other information related to my work records. In addition, I hereby release the company, my
former employers and all other persons, corporations, partnerships and associations from any and all claims, demands or
liabilities arising out of or in any way related to such investigation or disclosure. 
                			</div>
                		</div>
                		<div class="row mt-3">
                		
                			<div class="col-md-10">
                				I understand that nothing contained in the application, or conveyed during any interview which may be granted
or during my employment, if hired, is intended to create an employment contract between me and the Agency. In addition,
I expressly agree and understand that, if employed, my employment, having no specific term, is based upon mutual
consent and may be terminated at will, with or without cause or notice, by either party (the company or me). I also
understand that this aspect of my employment, which includes the Agency’s right to demote or otherwise discipline with
or without cause or notice, may not be changed, modified, amended or rescinded except by an individual written
agreement signed by both me and the administrator of the agency. 
                			</div>
                		</div>
                		<div class="row mt-3">
                			
                			<div class="col-md-10">
                			 I understand that any offer of employment regarding certain job positions may be conditioned upon satisfactory
completion of a medical examination and/or a drug and alcohol screen. I agree to sign a release of medical information
authorization form and to submit to a medical examination and/or drug and alcohol screen should the Agency condition
my offer of employment upon successful completion of such an examination or screening.

                			</div>
                		</div>
                		<div class="row mt-3">
                			
                			<div class="col-md-10">
                			 I understand that a consumer report or an investigative consumer report may be obtained from a Consumer
Reporting Agency for the purpose of evaluating you for employment, promotion, reassignment or retention as an
employee. This report may contain information bearing on your credit worthiness, credit standing, credit capacity,
character, general reputation, personal characteristics, or mode of living from public record sources or through personal
interviews with your neighbors, friends or associates. You may also have a right to request additional disclosures
regarding the nature and scope of the investigation.
                			</div>
                		</div>
                		<div class="row mt-3">
                			
                			<div class="col-md-10">
                			I acknowledge that I have read all of the above statements and that I understand them. In addition, the statements
above supersede and replace any prior understandings or discussions I have had with the Agency and set forth the
complete agreement between me and the Agency regarding these matters.
                			</div>
                		</div>
                	 <div class="row">
                			<div class="col-md-12">
						<div class="wrap-input100 validate-input" data-validate = "Client Signature is required">

							<span class="label-input100 f13">Applicant Signature:</span>
			 			 <div id="mySignature2" data-name="mySignature2" data-width="600"    data-height="210" 	  data-max-size="2048" 
			             data-pen-tickness="3" data-pen-color="black" 
			             class="sign-field"></div>

								<span class="focus-input100"></span>

							</div>
						</div>
					</div>
						

				<!-- 
						<div class="container-contact100-form-btn">

							<button class="contact100-form-btn btn-primary" disabled="">

								<span>

									Submit

									<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>

								</span>

							</button>

						</div> -->
					</div>
                	<div class="row">
							<div class="col-md-12">
							   <input type="button" name="next" class="next action-button" value="Next"/>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
						</div>
                </fieldset>

				 <fieldset>
				 			<div class="form-card">
                		<div class="row">
                			<div class="col-md-12">
                				<div>	<h5><u>Hepatitis B</u></h5></div>
                				<div>
                					Hepatitis B virus causes inflammation of the liver. Symptoms may include jaundice (yellow skin), nausea, loss of appetite, fatigue and
weakness. About 10% of infected people will develop chronic hepatitis, which can lead to cirrhosis and, infrequently, the acute illness
can be fatal. The time from infection to symptoms is 2-5 months.
                				</div>
									<div>
                					Hepatitis B virus is found in blood and many other body fluids. The infection is spread through sexual contact or by blood or other fluids
of an infected person coming into contact with blood or mucous membranes (eyes and mouth) of another person.
                				</div>
                			</div>
                			<div class="col-md-12 mt-2">
                				<div>	<h5><u>Immunization</u></h5></div>
                				<div>
                					Hepatitis B vaccine is recommended for all persons who are at increased risk of infection with Hepatitis B virus, including health care
workers who may be exposed to blood or body substances. Hepatitis B vaccine does not contain human serum and cannot transmit any
infection. One cannot develop hepatitis, AIDS or any other viral illness from receiving the vaccine. After a series of 3 doses of the vaccine
injected into the upper arm over 6 months, about 90% of healthy adults develop antibodies which protect against development of Hepatitis
B. This protection is long lasting so boosters are not routinely recommended.
                				</div>
									
                			</div>
                			<div class="col-md-12 mt-2">
                				<div>	<h5><u>Side Effects</u></h5></div>
                				<div>
                					Among recipients of Hepatitis B virus vaccine, soreness and redness at the injection site have occasionally been seen. Flu-like symptoms
and low grade fever are rare. Other side effects have been reported; however, they do not occur at a rate higher than in the general,
unvaccinated population. Hypersensitivity has not been reported. Safety of the vaccine for the developing fetus is not known, but because
it is non-infectious, the risk to the fetus from the vaccine should be negligible. However, Hepatitis B infection (which can be prevented by
this vaccination) in a pregnant woman may result in severe disease for the newborn. If you are pregnant, we recommend discussing all
vaccines and medications with your health provider.
                				</div>
									
                			</div>
                			<div class="col-md-12 mt-2">
                				<div>	<h5><u>Procedure</u></h5></div>
                				<div>
                					After signing the consent below, you will be scheduled to receive the immunization in three doses (dose 1 - now, dose 2 - one month
from now, dose 3 -six months from now). After the immunization series is completed, you will have a blood test for antibody to Hepatitis
B virus. This blood test and the immunization injections are done without charge to you. If the blood test indicates you are not yet immune,
additional doses may be given. If you will not be employed at this institution for the next 6 months, it is recommended that you complete
the vaccine elsewhere
                				</div>
									
                			</div>
                		</div>
                		
                		<div class="row">
                		<div class="col-2 col-md-1 mt-2">
                					<input type="checkbox" name="hepa_agree" >
                			</div>
                			<div class="col-10 col-md-10">
                				<div class="mt-2"><h5><u>I ACCEPT THE HEPATITIS B VACCINATION</u></h5></div>
                				<div class="mt-2">I have been informed of the biological hazards that exist in my workplace, and I understand the risks of exposure to
blood or other potentially infectious materials involved with my job. I understand that I may be at risk of acquiring
hepatitis B virus (HBV) infection. I acknowledge that I have been provided information on the hepatitis B vaccine,
including information on its effectiveness, safety, method of administration and the benefits of being vaccinated. I have
been given the opportunity to be vaccinated with the hepatitis B vaccine at no charge to myself. <br>I understand that I am responsible for scheduling and keeping my appointments to receive the Hepatitis B vaccine in
accordance with the recommended series (three vaccination series; second vaccine one month after first vaccine; and
third vaccine within five months of second vaccine</div>
                			</div>
                		</div>
                		<div class="row">
                		<div class="col-2 col-md-1 mt-2">
                					<input type="checkbox" name="hepa_disagree" >
                			</div>
                			<div class=" col-10 col-md-10">
                				<div class="mt-2"><h5><u>I DECLINE THE HEPATITIS B VACCINATION</u></h5></div>
                				<div class="mt-2">I understand that due to my occupational exposure to blood or other potentially infectious materials I may be at risk of acquiring
hepatitis B (HBV) infection. I have been given the opportunity to be vaccinated with hepatitis B vaccine, at no charge to myself.
However, I decline hepatitis B vaccination at this time. I understand that by declining this vaccine, I continue to be at risk of acquiring
hepatitis B, a serious disease. If in the future I continue to have occupational exposure to blood or other potentially infectious materials
and I want to be vaccinated with hepatitis B vaccine, I can receive the vaccination series at no charge to me</div>
                			</div>
                		</div>
                		
                	 <div class="row">
                			<div class="col-md-12">
						<div class="wrap-input100 validate-input" data-validate = "Client Signature is required">

							<span class="label-input100 f13">Applicant Signature:</span>
			 			 <div id="mySignature3" data-name="mySignature3" data-width="600"    data-height="210" 	  data-max-size="2048" 
			             data-pen-tickness="3" data-pen-color="black" 
			             class="sign-field"></div>

								<span class="focus-input100"></span>

							</div>
						</div>
					</div>
						

				<!-- 
						<div class="container-contact100-form-btn">

							<button class="contact100-form-btn btn-primary" disabled="">

								<span>

									Submit

									<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>

								</span>

							</button>

						</div> -->
					</div>
                	<div class="row">
							<div class="col-md-12">
							   <input type="button" name="next" class="next action-button" value="Next"/>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        	</div>
						</div>
				 </fieldset>

				 <fieldset>
				 	<div class="form-card">

				 		<div class="row">
                			<div class="col-md-12">
                				<h5>Personal Information</h5>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100">
									<span class="label-input100">First Name:</span>
									<label class="input100" name="l_first_name"></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">Last Name:</span>
									<label class="input100"  name="l_last_name" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Middle Initial:</span>
									<label class="input100"  name="l_mi_name" ></label>
									
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Date of Birth:</span>
									<label class="input100"  name="l_date_of_birth" ></label>
									
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Social Security Number:</span>
									<label class="input100"  name="l_sss_number" ></label>
									
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Email:</span>
									<label class="input100"  name="l_email" ></label>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<label class="input100"  name="l_tel_no" ></label>
								
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Street Address:</span>
									<label class="input100"  name="l_street_address" ></label>
								
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">City:</span>
									<label class="input100"  name="l_city" ></label>
									
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">State:</span>
									<label class="input100"  name="l_state" ></label>
								
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 ">
									<span class="label-input100">Zip Code:</span>
									<label class="input100"  name="l_zip_code" ></label>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Driver License No:</span>
									<label class="input100"  name="l_driver_license_no" ></label>
								
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">State:</span>
									<label class="input100"  name="l_dl_state" ></label>
								
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Expiration:</span>
										<label class="input100"  name="l_dl_expiration" ></label>
									
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Position</span>
										<label class="input100"  name="l_position" ></label>
								
								</div>
							</div>

                		</div>
                		
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Education</h5>
                			</div>

                		</div>
                		<div class="row div_educ_class_1">
                			<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<label class="input100"  name="l_school_1" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Major/Degree:</span>
									<label class="input100"  name="l_major_degree_1" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<label class="input100"  name="l_certificate_1" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<label class="input100"  name="l_years_from_1" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<label class="input100"  name="l_years_to_1" ></label>
								
								</div>
							</div>
							
                		</div>

                		<div class="row div_educ_class_1" style="display:none">
                			<div class="col-md-12">
                						<hr />
                				</div>
                					<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<label class="input100"  name="l_school_2" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Major/Degree:</span>
									<label class="input100"  name="l_major_degree_2" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<label class="input100"  name="l_certificate_2" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<label class="input100"  name="l_years_from_2" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<label class="input100"  name="l_years_to_2" ></label>
								
								</div>
							</div>
							
                		</div>
                		<div class="row div_educ_class_1" style="display:none;">
                			<div class="col-md-12">
                						<hr />
                				</div>
                					<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<label class="input100"  name="l_school_3" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Major/Degree:</span>
									<label class="input100"  name="l_major_degree_3" ></label>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<label class="input100"  name="l_certificate_3" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<label class="input100"  name="l_years_from_3" ></label>
									
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<label class="input100"  name="l_years_to_3" ></label>
								
								</div>
							</div>
							
                		</div>
                		
                		<div class="row mt-3">
                			<div class="col-md-12">
                				<h5>Emergency Contact</h5>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Name:</span>
									<label class="input100"  name="l_emergency_name_1" ></label>
								
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Relationship:</span>
										<label class="input100"  name="l_emergency_relationship_1" ></label>
									
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
										<label class="input100"  name="l_emergency_no_1" ></label>
									
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Work Experience</h5>
                			</div>
                		</div>
                		 <div class="row div_work_row">
                		 	    <div class="col-md-12">
                						<hr />
                				</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14"  >Job Title:</span>
										<label class="input100"  name="l_work_job_title_1" ></label>
									
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Company Name:</span>
										<label class="input100"  name="l_work_company_name_1" ></label>
										
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Location:</span>
										<label class="input100"  name="l_work_location_1" ></label>
									
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 " >
										<span class="label-input100">Date of Employment From:</span>
										<label class="input100"  name="l_work_date_from_1" ></label>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_1">
											<span class="label-input100">Date of Employment To:</span>
											<label class="input100"  name="l_work_date_to_1" ></label>
									     	<label class="input100"  name="l_work_currently_chk_1" style="display:none;" >Currently employed here</label>
										</div>
									</div>
									
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1 " >
										<span class="label-input100">Role Description</span>
										<label class="input100"  name="l_work_duties_1" ></label>

									</div>
								</div>
                			</div>
                			<div class="row div_work_row" style="display:none;" >
                				<div class="col-md-12">
                						<hr />
                				</div>
                					<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14"  >Job Title:</span>
										<label class="input100"  name="l_work_job_title_2" ></label>
									
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100">Company Name:</span>
										<label class="input100"  name="l_work_company_name_2" ></label>
										
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100">Location:</span>
										<label class="input100"  name="l_work_location_2" ></label>
									
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 " >
										<span class="label-input100">Date of Employment From:</span>
										<label class="input100"  name="l_work_date_from_2" ></label>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_2">
											<span class="label-input100">Date of Employment To:</span>
											<label class="input100"  name="l_work_date_to_2" ></label>
									     	<label class="input100"  name="l_work_currently_chk_2" style="display:none;" > Currently employed here</label>
										</div>
									</div>
									
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1" >
										<span class="label-input100">Role Description</span>
										<label class="input100"  name="l_work_duties_2" ></label>

									</div>
								</div>
                			</div>
                			<div class="row div_work_row"  style="display:none;">
                				<div class="col-md-12">
                						<hr />
                				</div>
	                				<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100 f14"  >Job Title:</span>
										<label class="input100"  name="l_work_job_title_3" ></label>
									
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 "">
										<span class="label-input100">Company Name:</span>
										<label class="input100"  name="l_work_company_name_3" ></label>
										
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100">Location:</span>
										<label class="input100"  name="l_work_location_3" ></label>
									
									</div>
								</div>
							<!-- 	<div class="col-md-6">
									<div class="wrap-input100 ">
										<span class="label-input100">Supervisor:</span>
										<input class="input100" type="text" name="work_supervisor_1" placeholder="Enter Supervisor 1">
										<span class="focus-input100"></span>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="wrap-input100 " >
										<span class="label-input100">Date of Employment From:</span>
										<label class="input100"  name="l_work_date_from_3" ></label>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_3">
											<span class="label-input100">Date of Employment To:</span>
											<label class="input100"  name="l_work_date_to_3" ></label>
									     	<label class="input100"  name="l_work_currently_chk_3" style="display:none;" >Currently employed here</label>
										</div>
									</div>
									
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1" >
										<span class="label-input100">Role Description</span>
										<label class="input100"  name="l_work_duties_3" ></label>

									</div>
								</div>

                			</div>
                		
                		<div class="row">
                			<div class="col-md-12">
                				<h5>General Questions</h5>
                			</div>
                			<div class="col-md-12 row">
                					<div class="col-md-8">
                					<span class="label-input100">Are you legally authorized to work in the United States for any employer?</span>
                					</div>
                					<div class="col-md-4">
											<label class="input100"  name="l_gq_usa" ></label>
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class="col-md-12 row">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been excluded, sanctioned, or otherwise restricted from participation in any federal or state health care program (including Medicare or Medicaid)? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any exclusion, sanction or other restriction (past, present, or future) from participation in any federal or state health care program (including Medicare or Medicaid) to the HR Department. Please note that any exclusion, sanction, or restriction will not necessarily disqualify an application for employment?</span>
                					</div>
                					<div class="col-md-4">
											<label class="input100"  name="l_gq_health" ></label>
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class="col-md-12 row">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been the subject of any disciplinary or adverse action taken by a regulatory, licensing or government agency? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any disciplinary or adverse action taken (past, present, or future) by a regulatory, licensing and government agency to the HR Department. (Examples of regulatory, licensing and government agencies include, but are not limited to, Centers for Medicare and Medicaid Services (CMS), state Medicaid programs, Department of Health and Human Services (DHHS), Office of Inspector General (OIG), and any medical or nursing boards). Please note that disciplinary or adverse action will not necessarily disqualify an application for employment.</span>
                					</div>
                					<div class="col-md-4">
											<label class="input100"  name="l_gq_license" ></label>
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			
                	</div>
                		<div class="col-md-12 div_i_accept" style="display:none;">
                				<h5 >I ACCEPT THE HEPATITIS B VACCINATION</h5>
                		</div>
                			<div class="col-md-12 div_i_decline"  style="display:none;">
                				<h5 >I DECLINE THE HEPATITIS B VACCINATION</h5>
                		</div>
                		<div class="col-md-12e"  style="display:none;">
                				<div>
                						I agree and understand that by signing the Electronic Signature Acknowledgment and Consent Form, that all electronic signatures are the legal equivalent of my manual/handwritten signature and I consent to be legally bound to this agreement. I further agree my signature on this document is as valid as if I signed the document in writing. This is to be used in conjunction with the use of electronic signatures on all forms regarding any and all future documentation with a signature requirement, should I elect to have signed electronically. Under penalty of perjury, I herewith affirm that my electronic signature, and all future electronic signatures, were signed by myself with full knowledge and consent and am legally bound to these terms and conditions.
                				</div>
                		</div>
				 		<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="validate_input" value="" required>
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
    <script src="js/custom.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
    	$(function(){
          $('select[name=position]').find('option.hospice_jb').hide();
          $('select[name=position]').find('option.both_jb,option.hm_jb').hide();

          $('select[name=company_applying]').on('change',function(){
            var val = $(this).val();
            if(val == 'Hospice'){
              $('select[name=position]').find('option.hospice_jb,option.both_jb').show();
               $('select[name=position]').find('option.hm_jb').hide();
            }
            if(val == 'Home Health' ){
              $('select[name=position]').find('option.hospice_jb').hide();
                             $('select[name=position]').find('option.hm_jb').show();

            }

            if( val== 'Both'){
                    $('select[name=position]').find('option.hospice_jb,option.hm_jb').hide();
                             $('select[name=position]').find('option.both_jb').show();
            }
          })
        })
    </script>

</body>

</html>

