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
		// $employee_records = array();
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
		  	while ($details = $result_logged->fetch_assoc() ) {
				# code...
				$staff_records[$details['staff_id']] = ucwords(strtolower($details['staff_name']));
			}



		 $sql = "SELECT tc.*,tj.first_name,tj.last_name FROM `tbl_competencies` tc LEFT JOIN tbl_job_applications tj ON tc.employee_id = tj.id  WHERE tj.status='active' ORDER BY date_added ASC ";
		  $result_logged = $conn->query($sql);
		  $competencies = array();
		  	while ($details = $result_logged->fetch_assoc() ) {
				# code...
				$competencies[$details['employee_id']] = $details;
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
		  // echo "<pre>",print_r($competencies),"</pre>";//die();
 
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Competencies</title>

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
	     <link rel="stylesheet" href="manage/js/plugins/datatables/jquery.dataTables.min.css">

     <link rel="stylesheet" href="manage/js/plugins/datatables/dataTables.bootstrap.css">
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
			if(isset($_GET['s']) && !empty($_GET['s'])){
				
			
			?>
			<div class="badge-md mt-4 m-4 badge-success">

					&nbsp;&nbsp;&nbsp;Form was successfully submitted!

			</div>



		<?php exit; }?>
		<?php if (isset($_GET['e']) && $_GET['e'] === 'archived') { ?>
		<div class="badge-md mt-4 m-4 badge-danger">
			&nbsp;&nbsp;&nbsp;Competency generation is not available for archived employees.
		</div>
		<?php } ?>
		
		<?php
		// Display delete success/error messages
		if(isset($_GET['deleted']) && $_GET['deleted'] == '1'){
		?>
		<div class="badge-md mt-4 m-4 badge-success">
			&nbsp;&nbsp;&nbsp;Competency record deleted successfully!
		</div>
		<?php } ?>
		
		<?php
		if(isset($_GET['error'])){
			$error_msg = '';
			switch($_GET['error']){
				case 'invalid_ref':
					$error_msg = 'Invalid reference parameter.';
					break;
				case 'not_found':
					$error_msg = 'Competency record not found.';
					break;
				case 'delete_failed':
					$error_msg = 'Failed to delete competency record.';
					break;
				case 'no_ref':
					$error_msg = 'No reference parameter provided.';
					break;
				default:
					$error_msg = 'An error occurred while deleting.';
			}
		?>
		<div class="badge-md mt-4 m-4 badge-danger">
			&nbsp;&nbsp;&nbsp;Error: <?= $error_msg ?>
		</div>
		<?php } ?>
			<div class="mb-3 ml-4">
				<a href="manage/" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Manage</a>
			</div>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;Competency Forms
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="generate_competency.php" >

				    <ul id="progressbar" class="progressbar50">
                        <li class="active new_comp" id="new_competency"><strong>Generate New Competency</strong></li>
                        <li id="list_test" class="certs"><strong>List of Existing Competency</strong></li>
                      
                    </ul>
                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
                <fieldset id="waived_test" class="new_competency">
                	<div class="eval_class form-card">
                		<div class="row">
                		
	                		<div class="col-md-4 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
										<span class="label-input100">Employee Name:</span>
										<select name="employee_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
											<option value="">Select Employee Name</option>
											<?php foreach($employee_records as $emp_id=>$emp_rec){ ?>
												<option value="<?=$emp_id?>"><?=$emp_rec?></option>
										<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

									<?php }?></select>
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                			<div class="col-md-4 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Staff Name is required">
										<span class="label-input100">Staff Name:</span>
										<select name="staff_name" class="select100 ml-2 mt-2 employee_name_class" style="width:100%" required>
											<option value="">Select Staff Name</option>
											<?php foreach($staff_records as $staff_id=>$staff_rec){ ?>
												<option value="<?=$staff_id?>"><?=$staff_rec?></option>
										<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

									<?php }?></select>
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                		<div class="col-md-4">
								<div class="wrap-input100 validate-input" data-validate="Applying For is required">
									<span class="label-input100">Applying For:</span>
									<?php // Organization is Home Health only; Hospice not used ?>
									<select class="input100 select100 " name="company_applying" required>
										<option value="Home Health">Home Health</option>
									</select>
									<!-- <input class="input100" type="text" name="driver_license_no" placeholder="Enter driver license number"> -->
									<span class="focus-input100"></span>
								</div>
							</div>
						<div class="col-md-6">
			                <div class="wrap-input100 validate-input" data-validate="Position is required">
			                          <span class="label-input100">Position</span>
			                          <select class="input100 select100 " name="position" required>
			                            <option value="">Select position applying for</option>
			                            <option value="Home Health Aide">Home Health Aide</option>
			                            <option value="Licensed Vocational Nurse">Licensed Vocational Nurse</option>
			                            <option value="Registered Nurse">Registered Nurse</option>
			                            <!-- <option value="Office Manager">Office Manager</option> -->
			                          </select>
			                          <!-- <input class="input100" type="text" name="driver_license_no" placeholder="Enter driver license number"> -->
			                          <span class="focus-input100"></span>
			                        </div>
			              </div>
	                		<div class="col-md-6 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Date is required">
										<span class="label-input100">Employment Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="employment_date" placeholder="Enter Employment Date" required>
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                		<div class="col-md-6 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Date is required">
										<span class="label-input100">Generate from Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="generate_date" placeholder="Enter Date of From Generation" required>
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                		<div class="col-md-6 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Date is required">
										<span class="label-input100">Generate to Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="generate_to_date" placeholder="Enter Date to Generation" required>
										<span class="focus-input100"></span>
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
                <fieldset class="list_test">
                	<div class=" row">
                			<div class="col-12">
                					<table class="table table-responsive" id="competency_table">
                							<thead>
                								<tr>
                									<td>Employee Name</td>
                									<td>Company</td>
                									<td>Position</td>
                									<td>Employment Date</td>
                									<td>Generated Date</td>
                									<td>PDF File</td>
                								</tr>
                							</thead>
                							<tbody>
                									<?php foreach ($competencies as $k => $v) {
                										$encode_ref=  base64_encode($v['id']);
                										?>
                								<tr>
                									<td><?=ucwords($v['first_name']." ".$v['last_name'])?></td>
                									<td><?=ucwords($v['organization'])?></td>
                									<td><?=ucwords($v['position'])?></td>
                									<td><?=$v['employment_date']?></td>
                									<td><?=$v['generate_date']?></td>
                									<td><a href="<?='pdf_files/'.$v['pdf_file_path'] ?>" class="btn btn-sm btn-info" target="_blank">PDF File</a><br><a href="<?='delete_competency.php?ref='.$encode_ref?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Are you sure you want to delete this competency record? This action cannot be undone.');">Delete</a></td>
                								</tr>		
                								<?php 	} ?>
                 							</tbody>
                					</table>
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


             <script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    	      <script src="manage/js/plugins/datatables/jquery.dataTables.min.js"></script>

        <script src="manage/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
 <script>
  $(document).ready(function(){
  	$('.select100').select2();
          // Organization-dependent position filtering removed - only Home Health positions available
            $('li#list_test').bind('click',function(){
          	console.log('list test');
          	$('.new_comp').removeClass('active');
          	    $(this).addClass('active');

			    $('fieldset#waived_test').hide();
			    $('fieldset.list_test').show();

			});

           $('.new_comp').bind('click',function(){
          	$('#list_test').removeClass('active');
          	    $(this).addClass('active');

			    $('fieldset.list_test').hide();
			    $('fieldset#waived_test').show();

			});

    $('#competency_table').DataTable({

      "paging": true,

      "lengthChange": false,

      "searching": false,

      "ordering": true,

      "info": true,

      "autoWidth": false,

      "responsive":true,

    });

        });

    </script>

</body>

</html>

