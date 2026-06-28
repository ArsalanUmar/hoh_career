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
	  	while ($details = $result_logged->fetch_assoc() ) {
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
		  // echo "<pre>",print_r($employee_records),"</pre>";die();
 
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Custom Certificates</title>

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
			&nbsp;&nbsp;&nbsp;Custom certificate generation is not available for archived employees.
		</div>
		<?php } ?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;Custom Certificates 
			<p class="ml-2 ">Fill up the following info: </p>
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="generate_custom_certificates.php" >

                <fieldset id="waived_test" class="waived_test">
                	<div class="eval_class form-card">
                		<div class="row">
                			<div class="col-md-4 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Position is required">
										<span class="label-input100">Certificate Name:</span>
										<input name="certificate_name" class="input100 ml-2 mt-2" >
										
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
	                				<div class="wrap-input100 validatez-input" data-validate="Position is required">
										<span class="label-input100">Position:</span>
										<input name="position" class="input100 ml-2 mt-2 employee_name_class" >
										
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                		<div class="col-md-4 ">
	                				<div class="wrap-input100 validatez-input" data-validate="Date is required">
										<span class="label-input100">Date:</span>
										<input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required>
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
	                		
                		</div>
                		
                	
	                			
                		</div>
	   				 	
						<div class="row">
							<div class="col-md-12">
								<input type="submit" name="submit_waive" class="btn btn-primary submit action-button" value="Submit">
							</div>
						</div>
					</div>
					
                </fieldset>
            

		
			
			</form>

		</div>

	</div>







	<!-- <script src="https://maps.googleapis.com/maps/api/

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

<!--===============================================================================================-->js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>

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
    <script src="js/customtest.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
       <script>
  $(function(){
          $('select[name=position]').find('option.hospice_jb').hide();
          $('select[name=position]').find('option.both_jb,option.hm_jb,option.bothh_jb').hide();

          $('select[name=company_applying]').on('change',function(){
            var val = $(this).val();
            if(val == 'Hospice'){
              $('select[name=position]').find('option.hospice_jb,option.both_jb').show();
               $('select[name=position]').find('option.hm_jb,option.bothh_jb').hide();
            }
            if(val == 'Home Health' ){
              $('select[name=position]').find('option.hospice_jb,option.bothh_jb').hide();
                             $('select[name=position]').find('option.hm_jb,option.both_jb').show();

            }

            if( val== 'Both'){
                    $('select[name=position]').find('option.hospice_jb,option.hm_jb').hide();
                             $('select[name=position]').find('option.both_jb,option.bothh_jb').show();
            }
          });
          $('select.employee_name_class').select2();
          $('input,select').removeAttr('required');
          $('fieldset#waived_test').find('input,select').attr('required','required');
          $('.progressbar8 li').on('click',function(){
          		var idref= $(this).attr('id');
          		$('.progressbar8 li').removeClass('active');
          		$(this).addClass('active');
          		console.log(idref);
          		$('fieldset').fadeOut();
          		$('input,select').removeAttr('required');
          $('fieldset.'+idref).find('input,select').attr('required','required');
          		$('.'+idref).show();
          });

          $('input[name=is_waived_prefilled]').on('change',function(){
          	 var val = $('input[name=is_waived_prefilled]:checked').val();
          	 var akey = ["true","true","b","true","c","a","a","b","d","d"];

          	 if(val=='yes'){
          	 	for(x=1;x<=10;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=wave_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=wave_]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

           $('input[name=is_hepab_prefilled]').on('change',function(){
          	 var val = $('input[name=is_hepab_prefilled]:checked').val();
          	 var akey = ["false","true","false","false","true","false","false","false","true","false","false"];

          	 if(val=='yes'){
          	 	for(x=1;x<=11;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=hepab_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=hepab_]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

             $('input[name=is_harass_prefilled]').on('change',function(){
          	 var val = $('input[name=is_harass_prefilled]:checked').val();
          	 var akey = ["false","false","false","false","false","false","true","false","true","true","true","true","true","true"];

          	 if(val=='yes'){
          	 	for(x=1;x<=14;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=harass_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=harass_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

           $('input[name=is_handhygiene_prefilled]').on('change',function(){
          	 var val = $('input[name=is_handhygiene_prefilled]:checked').val();
          	 var akey = ["d","c","c","e","false","c","c"];

          	 if(val=='yes'){
          	 	for(x=1;x<=7;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=hh_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=hh_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

            $('input[name=is_emergency_prefilled]').on('change',function(){
          	 var val = $('input[name=is_emergency_prefilled]:checked').val();
          	 var akey = ["a","b","b","false","true","true"];

          	 if(val=='yes'){
          	 	for(x=1;x<=6;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=emerg_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=emerg_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

             $('input[name=is_covid_prefilled]').on('change',function(){
          	 var val = $('input[name=is_covid_prefilled]:checked').val();
          	 var akey = ["false","true","true","false","true","true","true"];

          	 if(val=='yes'){
          	 	for(x=1;x<=7;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=covid_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=covid_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });


             $('input[name=is_bloodpatho_prefilled]').on('change',function(){
          	 var val = $('input[name=is_bloodpatho_prefilled]:checked').val();
          	 var akey = ["false","false","true","false","a","b","true","b","c","true","false","b","false","false","true","false","true","false","false","true"];

          	 if(val=='yes'){
          	 	for(x=1;x<=20;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=bp_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=bp_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });

             $('input[name=is_gluco_prefilled]').on('change',function(){
          	 var val = $('input[name=is_gluco_prefilled]:checked').val();
          	 var akey = ["true","true","true","true","true","true","true","true","true","true","true","c","d","e","f","b","a"];

          	 if(val=='yes'){
          	 	for(x=1;x<=17;x++){
          	 	console.log(akey[x]);
          	 	   $('input[name=gluco_q'+x+'][value="'+akey[x-1]+'"]').prop('checked','checked');
          		 }
          	 }else{
          	 	$('input[name^=gluco_q]').prop('checked', false); ;
          	 }
          	 // console.log(val);
          });



        })
    </script>
    <script src="cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>

