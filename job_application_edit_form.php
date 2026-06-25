<?php

require_once('database.php');
   $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $conn = $db->Conn();
    $ref_decode = base64_decode($_GET['ref']);
    
    $sql = "SELECT * FROM `tbl_job_applications`  where id='".$ref_decode."'";
	$result_logged = $conn->query($sql);
	$record_details= $result_logged->fetch_assoc();
	$agreement_file = 'pdf/ho_template.pdf';
	$employee_records = array();
	$staff_records = array();
			// echo "<pre>",print_r($record_details),"</pre>";die();
	// if(!empty($record_details)){

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
<!--===============================================================================================-->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" />

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	
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

			<?php
			}elseif(isset($_GET['e']) && !empty($_GET['e'])){
				
			
			?>
			<div class="badge-md mt-4 m-4 badge-danger">

					&nbsp;&nbsp;&nbsp;Recaptcha image was not successfully completed or is incorrect.

			</div>

		<?php exit; }?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;JOB APPLICATION
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="jo_edit_process.php" >

                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
              
                <fieldset class="job_sheet">
                	<div class="eval_class form-card">
                		<div class="row">
	                		<div class="col-md-4 col-md-offset-8">
	                				<div class="wrap-input100 validate-input" data-validate="Date is required">
										<span class="label-input100">Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" value="<?= $record_details['date_filled'] ?>" required>
										<span class="focus-input100"></span>
									</div>
	                		</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                				<h5>Personal Information</h5>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="First Name is required">
									<span class="label-input100">First Name:</span>
									<input class="input100" type="text" name="first_name" placeholder="Enter First Name" value="<?=$record_details['first_name']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Last Name is required">
									<span class="label-input100">Last Name:</span>
									<input class="input100" type="text" name="last_name" placeholder="Enter Last Name" value="<?=$record_details['last_name']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">Middle Initial:</span>
									<input class="input100" type="text" name="mi_name" placeholder="Enter Middle Initial" value="<?=$record_details['middle_initial']?>" >
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Date of Birth is required">
									<span class="label-input100">Date of Birth:</span>
									<input class="input100" type="date" name="date_of_birth" placeholder="" value="<?=$record_details['date_of_birth']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Social Security Number is required">
									<span class="label-input100 f14">Social Security Number:</span>
									<input class="input100" type="text" name="sss_number" placeholder="Enter Social Security Number" value="<?=$record_details['sss_number']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Email Address is required">
									<span class="label-input100">Email:</span>
									<input class="input100" type="email" name="email" placeholder="Enter Email Address" value="<?=$record_details['email']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Telephone No. is required">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="tel_no" placeholder="Enter Telephone Number" value="<?=$record_details['telephone_no']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Street Address is required">
									<span class="label-input100">Street Address:</span>
									<input class="input100" type="text" name="street_address" placeholder="Enter Street Address" value="<?=$record_details['street_address']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="City is required" >
									<span class="label-input100 f14">City:</span>
									<input class="input100" type="text" name="city" placeholder="Enter City" value="<?=$record_details['city']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="State is required">
									<span class="label-input100">State:</span>
									<input class="input100" type="text" name="state" placeholder="Enter State" value="<?=$record_details['state']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-3">
								<div class="wrap-input100 validate-input" data-validate="Zip Code is required">
									<span class="label-input100">Zip Code:</span>
									<input class="input100" type="text" name="zip_code" placeholder="Enter Zip Code" value="<?=$record_details['zip_code']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
                			<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Driver License is required">
									<span class="label-input100">Driver License No:</span>
									<input class="input100" type="text" name="driver_license_no" placeholder="Enter Driver License Number" value="<?=$record_details['drivers_license']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="State is required" >
									<span class="label-input100">State:</span>
									<input class="input100" type="text" name="dl_state" placeholder="Enter State" value="<?=$record_details['dl_state']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Expiration is required">
									<span class="label-input100">Expiration:</span>
									<input class="input100" type="date" name="dl_expiration" placeholder="" value="<?=$record_details['dl_expiration_date']?>"  required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                		<div class="row">
	                	 <div class="col-md-4">
			                <div class="wrap-input100 validate-input" data-validate="Position is required">
			                          <span class="label-input100">Position</span>
			                         <select class="input100 select100 " name="position" required>
			                            <option value="" >Select position applying for</option>
			                            <option value="Administrator" <?=($record_details['position'] == 'Administrator' ) ?'selected' :''?>>Executive Director-Administrator</option>
			                            <option value="Clinical Supervisor/Nursing Supervisor" <?=($record_details['position'] == 'Clinical Supervisor/Nursing Supervisor' ) ?'selected' :''?>>Clinical Supervisor/Nursing Supervisor</option>
			                            <option value="Social Health Aid" <?=($record_details['position'] == 'Social Health Aid') ?'selected' :''?>>Home Health Aide</option>
			                            <option value="Human Resources" <?=($record_details['position'] == 'Human Resources') ?'selected' :''?>>Human Resources</option>
			                            <option value="Licensed Vocational Nurse" <?=($record_details['position'] == 'Licensed Vocational Nurse') ?'selected' :''?>>Licensed Vocational Nurse</option>
			                            <option value="Office Manager" <?=($record_details['position'] == 'Office Manager' ) ?'selected' :''?>>Office Manager</option>
			                            <option value="Registered Nurse" <?=($record_details['position'] == 'Registered Nurse') ?'selected' :''?>>Registered Nurse</option>
			                            <option value="Secretary/Receptionist" <?=($record_details['position'] == 'Secretary/Receptionist' ) ?'selected' :''?>>Secretary/Receptionist</option>
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
									<input class="input100" type="text" name="school_1" placeholder="School or University" value="<?=$record_details['school_name_1']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Major/Degree is required">
									<span class="label-input100">Major/Degree:</span>
									<select class="input100 select100" name="major_degree_1" placeholder="Enter Major/Degree" required>
										<option value="">Select Major/Degree</option>
										<option value="Associate's" <?=($record_details['school_major_1'] == "Associate's") ?'selected' :''?> >Associate's</option>
										<option value="Bachelor's"  <?=($record_details['school_major_1'] == "Bachelor's") ?'selected' :''?>>Bachelor's</option>
										<option value="Doctorate"  <?=($record_details['school_major_1'] == "Doctorate") ?'selected' :''?>>Doctorate</option>
										<option value="High School"  <?=($record_details['school_major_1'] == "High School") ?'selected' :''?>>High School</option>
										<option value="Master's"  <?=($record_details['school_major_1'] == "Master's") ?'selected' :''?>>Master's</option>
										<option value="Medical Degree"  <?=($record_details['school_major_1'] == "Medical Degree") ?'selected' :''?>>Medical Degree</option>
										<option value="None"  <?=($record_details['school_major_1'] == "None") ?'selected' :''?>>None</option>
										<option value="Technical Diploma"  <?=($record_details['school_major_1'] == "Technical Diploma") ?'selected' :''?>>Technical Diploma</option>
									</select>
									<!-- <input class="input100" type="text" name="major_degree_1" placeholder="Enter Major/Degree"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Field of Study is required" >
									<span class="label-input100 f14">Field of Study:</span>
									<input class="input100" type="text" name="certificate_1" placeholder="Enter Field of Study" value="<?=$record_details['school_field_1']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 validate-input" data-validate="From Year is required">
									<span class="label-input100">From:</span>
									<input class="input100" type="text" name="years_from_1" placeholder="From Year" value="<?=$record_details['school_from_1']?>"required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 validate-input" data-validate="To is required">
									<span class="label-input100">To (Actual or Expected):</span>
									<input class="input100" type="text" name="years_to_1" placeholder="To Year"  value="<?=$record_details['school_to_1']?>" required>
									<span class="focus-input100"></span>
								</div>
							</div>
                		</div>
                        <?php if(!empty($record_details['school_name_2'])){ 
                        		$display_school_2  = "";
                        		$display_school_2_btn = "display:none";
                        	}else{
                        		$display_school_2 = "display:none";
                        		$display_school_2_btn = "";
                        	}
                        	?>



                		<div class="row educ_class_1" style="<?=$display_school_2?>">
                			<div class="col-md-12">
                						<hr />
                				</div>
                				<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100">School or University:</span>
									<input class="input100" type="text" name="school_2" placeholder="School or University"  value="<?=$record_details['school_name_2']?>"> 
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Major/Degree:</span>
									<select class="select100" name="major_degree_2" placeholder="Enter Major/Degree">
										<option value="">Select Major/Degree</option>
										<option value="Associate's" <?=($record_details['school_major_2'] == "Associate's") ?'selected' :''?> >Associate's</option>
										<option value="Bachelor's"  <?=($record_details['school_major_2'] == "Bachelor's") ?'selected' :''?>>Bachelor's</option>
										<option value="Doctorate"  <?=($record_details['school_major_2'] == "Doctorate") ?'selected' :''?>>Doctorate</option>
										<option value="High School"  <?=($record_details['school_major_2'] == "High School") ?'selected' :''?>>High School</option>
										<option value="Master's"  <?=($record_details['school_major_2'] == "Master's") ?'selected' :''?>>Master's</option>
										<option value="Medical Degree"  <?=($record_details['school_major_2'] == "Medical Degree") ?'selected' :''?>>Medical Degree</option>
										<option value="None"  <?=($record_details['school_major_1'] == "None") ?'selected' :''?>>None</option>
										<option value="Technical Diploma"  <?=($record_details['school_major_2'] == "Technical Diploma") ?'selected' :''?>>Technical Diploma</option>
									</select>
									<!-- <input class="input100" type="text" name="major_degree_1" placeholder="Enter Major/Degree"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Field of Study:</span>
									<input class="input100" type="text" name="certificate_2" value="<?=$record_details['school_major_2']?>" placeholder="Enter Field of Study">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">From:</span>
									<input class="input100" type="text" name="years_from_2" value="<?=$record_details['school_from_2']?>" placeholder="From Year">
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="wrap-input100 ">
									<span class="label-input100">To (Actual or Expected):</span>
									<input class="input100" type="text" name="years_to_2"  value="<?=$record_details['school_to_2']?>" placeholder="To Year">
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
								<button class="btn btn-primary btn_add_educ" style="<?=$display_school_2_btn?>" type="button"><span><i class="fa fa-plus"></i> Add educational background</span></button>
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
									<input class="input100" type="text" name="emergency_name_1" value="<?=$record_details['emergency_name']?>" placeholder="Enter Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Relationship is required" >
									<span class="label-input100 f14">Relationship:</span>
									<input class="input100" type="text" name="emergency_relationship_1"  value="<?=$record_details['emergency_relationship']?>"placeholder="Enter relationship" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="emergency_no_1" value="<?=$record_details['emergency_telephone']?>" placeholder="Enter Telephone No." required>
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
										<input class="input100" type="text" name="work_job_title_1" placeholder="Enter Job Title" value="<?=$record_details['work_job_title_1']?>" required>
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 validate-input" data-validate="Company Name is required">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_1"  value="<?=$record_details['work_company_name_1']?>"  placeholder="Enter Company Name" required>
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 validate-input" data-validate="State is required">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_1"  value="<?=$record_details['work_location_1']?>"  placeholder="Enter Location" required>
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
									    <input class="input100" type="date" name="work_date_from_1" placeholder="Enter Date of Employment"  value="<?=$record_details['work_from_1']?>"  required>
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_1">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_1" placeholder="Enter Date of Employment"  value="<?=$record_details['work_to_1']?>" >
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
										<div class="col-md-2 pr-0">
											<input type="checkbox" name="work_currently_chk_1" value="1" <?=$record_details['work_is_currently_1'] == '1' ? 'checked' : '' ?>> 
										</div>
										<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1 validate-input" data-validate="Role Description is required">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text" rows="2" wrap="hard" name="work_duties_1" placeholder="Describe Your Most Recent Job Duties And Accomplishments"  value="<?=$record_details['work_role_1']?>"  required><?=$record_details['work_role_1']?></textarea>
										<span class="focus-input100"></span>
									</div>
								</div>
								

                			</div>

                			<?php 

                			if(!empty($record_details['work_company_name_2'])){
                				$work_2_display="";
                			}else{
                				$work_2_display="display:none;";
                			}		

                			?>
                			<div class="row work_row" style="<?=$work_2_display?>">
                				<div class="col-md-12">
                						<hr />
                				</div>
	                				<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14">Job Title:</span>
										<input class="input100" type="text" name="work_job_title_2" value="<?=$record_details['work_job_title_2']?>" placeholder="Enter Job Title">
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_2" value="<?=$record_details['work_company_name_2']?>" placeholder="Enter Company Name">
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_2" value="<?=$record_details['work_location_2']?>" placeholder="Enter Location">
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
									    <input class="input100" type="date" name="work_date_from_2" value="<?=$record_details['work_from_2']?>" placeholder="Enter Date of Employment">
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_2">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_2" value="<?=$record_details['work_to_2']?>" placeholder="Enter Date of Employment">
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
										<div class="col-md-2 pr-0">
											<input type="checkbox" name="work_currently_chk_2" value="1"  <?=$record_details['work_is_currently_2'] == '1' ? 'checked' : '' ?>> 
										</div>
										<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text"  rows="2" wrap="hard" name="work_duties_2" placeholder="Describe Your Most Recent Job Duties And Accomplishments" value="<?=$record_details['work_role_2']?>"><?=$record_details['work_role_2']?></textarea>
										<span class="focus-input100"></span>
									</div>
								</div>

                			</div>

                			<?php 

                			if(!empty($record_details['work_company_name_2'])){
                				$work_3_display="";
                			}else{
                				$work_3_display="display:none;";
                			}		

                			?>
                			<div class="row work_row"  style="<?=$work_3_display?>">
                					<div class="col-md-12">
                						<hr />
                				</div>
	                				<div class="col-md-4">
									<div class="wrap-input100 " >
										<span class="label-input100 f14">Job Title:</span>
										<input class="input100" type="text" name="work_job_title_3"  value="<?=$record_details['work_job_title_3']?>"  placeholder="Enter Job Title">
										<span class="focus-input100"></span>
									</div>
								</div>
	                			<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Company Name:</span>
										<input class="input100" type="text" name="work_company_name_3"  value="<?=$record_details['work_company_name_3']?>"  placeholder="Enter Company Name">
										<span class="focus-input100"></span>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="wrap-input100 ">
										<span class="label-input100">Location:</span>
										<input class="input100" type="text" name="work_location_3"  value="<?=$record_details['work_location_3']?>"  placeholder="Enter Location">
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
									    <input class="input100" type="date" name="work_date_from_3"  value="<?=$record_details['work_from_3']?>"  placeholder="Enter Date of Employment">
										<span class="focus-input100"></span>
									</div>
								</div>
								<div class="col-md-6 row">
									<div class="col-md-12 ">
										<div class="wrap-input100 work_employment_to_div_3">
											<span class="label-input100">Date of Employment To:</span>
												<input class="input100" type="date" name="work_date_to_3"  value="<?=$record_details['work_to_3']?>"  placeholder="Enter Date of Employment">
											<span class="focus-input100"></span>
										</div>
									</div>
									<div class="col-md-12 row ">
											<div class="col-md-2 pr-0">
												<input type="checkbox" name="work_currently_chk_3"  <?=$record_details['work_is_currently_3'] == '1' ? 'checked' : '' ?> value="1"> 
											</div>
											<div class="col-md-10">	I currently work here</div>
									</div>
								
								</div>
								<div class="col-md-12">
									<div class="wrap-input100 pl-1">
										<span class="label-input100">Role Description</span>
										<textarea class="input100" type="text"  rows="2" wrap="hard" name="work_duties_3" value="<?=$record_details['work_role_3']?>" placeholder="Describe Your Most Recent Job Duties And Accomplishments"><?=$record_details['work_role_3']?></textarea>
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
										<input class="radio_input" type="radio" name="gq_usa" value="yes" placeholder=""  <?=$record_details['gq_1'] == 'yes' ? 'checked' : '' ?> required> Yes
										<input class="radio_input" type="radio" name="gq_usa" value="no" placeholder=""  <?=$record_details['gq_1'] == 'no' ? 'checked' : '' ?> > No
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class="wrap-input100 col-md-12 row ml-1  mt-1 validate-input" data-validate="This field is required">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been excluded, sanctioned, or otherwise restricted from participation in any federal or state health care program (including Medicare or Medicaid)? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any exclusion, sanction or other restriction (past, present, or future) from participation in any federal or state health care program (including Medicare or Medicaid) to the HR Department. Please note that any exclusion, sanction, or restriction will not necessarily disqualify an application for employment?</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_health" value="yes" placeholder=""  <?=$record_details['gq_2'] == 'yes' ? 'checked' : '' ?>  required> Yes
										<input class="radio_input" type="radio" name="gq_health" value="no" placeholder="" <?=$record_details['gq_2'] == 'no' ? 'checked' : '' ?>  > No
									</div>
								<!-- 	<div class="col-md-4">
									</div> -->
                			</div>
                			<div class=" wrap-input100 col-md-12 row ml-1 mt-1 validate-input" data-validate="This field is required">
                					<div class="col-md-8">
                					<span class="label-input100">Have you ever been the subject of any disciplinary or adverse action taken by a regulatory, licensing or government agency? You have an affirmative duty as a condition of employment and/or staff privileges to immediately report any disciplinary or adverse action taken (past, present, or future) by a regulatory, licensing and government agency to the HR Department. (Examples of regulatory, licensing and government agencies include, but are not limited to, Centers for Medicare and Medicaid Services (CMS), state Medicaid programs, Department of Health and Human Services (DHHS), Office of Inspector General (OIG), and any medical or nursing boards). Please note that disciplinary or adverse action will not necessarily disqualify an application for employment.</span>
                					</div>
                					<div class="col-md-4">
										<input class="radio_input" type="radio" name="gq_license" value="yes" placeholder=""  <?=$record_details['gq_3'] == 'yes' ? 'checked' : '' ?>  required> Yes
										<input class="radio_input" type="radio" name="gq_license" value="no"  <?=($record_details['gq_3'] == 'no' || $record_details['gq_3'] =='dis') ? 'checked' : '' ?>  placeholder=""> No
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
									<input class="input100" type="text" name="prof_name_1" value="<?=$record_details['prof_ref_name_1']?>"  placeholder="Enter Reference Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Company:</span>
									<input class="input100" type="text" name="prof_company_1"  value="<?=$record_details['prof_ref_company_1']?>" placeholder="Enter Company Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
						
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 ">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="prof_telno_1"  value="<?=$record_details['prof_ref_tel_1']?>" placeholder="Enter Telephone No." required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
                		</div>
                		<div class="row prof_ref_1"  >
                			<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 ">
									<span class="label-input100">Name:</span>
									<input class="input100" type="text" name="prof_name_2"  value="<?=$record_details['prof_ref_name_2']?>" placeholder="Enter Reference Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							<div class="col-md-4 validate-input" data-validate="This field is required">
								<div class="wrap-input100 " >
									<span class="label-input100 f14">Company:</span>
									<input class="input100" type="text" name="prof_company_2"  value="<?=$record_details['prof_ref_company_2']?>" placeholder="Enter Company Name" required>
									<span class="focus-input100"></span>
								</div>
							</div>
							
							
							<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="This field is required">
									<span class="label-input100">Telephone No.:</span>
									<input class="input100" type="text" name="prof_telno_2" placeholder="Enter Telephone No."  value="<?=$record_details['prof_ref_tel_2']?>"  required>
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

								<input type="hidden" name="ref" value="<?=$_GET['ref']?>" >
													   <input type="submit" name="submit" class="next action-button" value="Submit"/>

                        	</div>
						</div>
                	</div>
                </fieldset>
    
						
			</form>

		</div>

	</div>







	<div id="dropDownSelect1"></div>
	<script>
 // Ensure this file doesn't include logic for dependent dropdowns.
document.addEventListener("DOMContentLoaded", () => {
    const positionDropdown = document.querySelector('select[name="position"]');

    if (positionDropdown) {
        // Optional: Highlight the dropdown if a value is selected
        if (positionDropdown.value) {
            positionDropdown.classList.add("selected");
        }
    }
});

    </script>



<!--===============================================================================================-->

	
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
 		 function refreshCaptcha(){
                var img = document.images['captcha_image'];
                img.src = img.src.substring(
                    0,img.src.lastIndexOf("?")
                    )+"?rand="+Math.random()*1000;
            }
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
</body>

</html>

