<?php

  require_once('database.php');
   $s = (!empty($_GET['s']) && isset($_GET['s'])) ? $_GET['s'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $conn = $db->Conn();
    $record_details = [];
    if(isset($_GET['ref']) && !empty($_GET['ref'])){
    	$ref_rec= base64_decode($_GET['ref']);
	    $sql = "SELECT * FROM `tbl_inservice_logs`  where id='".$ref_rec."'";
		$result_logged = $conn->query($sql);
		$record_details= $result_logged->fetch_assoc();
    }
    
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

 
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<title>Service Log</title>

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

	<style>
		/* main.css fixes .wrap-contact100 at 900px and .contact100-form uses 60px side padding — override on this page only */
		.container-contact100 .wrap-contact100 {
			width: 100%;
			max-width: 1240px;
			border-color: #e2e8f0;
		}
		.service-log-form.contact100-form {
			width: 100%;
			max-width: none;
			padding: 1.25rem 1.25rem 2rem;
			box-sizing: border-box;
			justify-content: flex-start;
		}
		@media (min-width: 768px) {
			.service-log-form.contact100-form { padding: 1.5rem 2rem 2.5rem; }
		}
		@media (max-width: 576px) {
			.service-log-form.contact100-form { padding: 1rem 1rem 1.75rem; }
		}
		/* Service log — layout & polish */
		.service-log-form { width: 100%; max-width: none; margin: 0; }
		.service-log-form .form-card,
		.service-log-form .eval_class.form-card {
			background: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08);
			border: 1px solid rgba(15, 23, 42, 0.06);
			padding: 1.75rem 1.5rem 2rem;
			margin-bottom: 2rem;
			text-align: left;
		}
		@media (min-width: 768px) {
			.service-log-form .form-card,
			.service-log-form .eval_class.form-card { padding: 2rem 2.25rem 2.25rem; }
		}
		.service-log-page-head {
			margin-bottom: 1.25rem;
			padding-bottom: 1rem;
			border-bottom: 1px solid #e9ecef;
			max-width: none;
			text-align: center;
		}
		.service-log-page-head h1 {
			font-size: 1.5rem;
			font-weight: 700;
			color: #1a2332;
			letter-spacing: -0.02em;
			margin: 0 0 0.35rem 0;
			text-align: center;
		}
		.service-log-page-head p {
			margin: 0 auto;
			font-size: 0.95rem;
			color: #6c757d;
			text-align: center;
			max-width: 40rem;
		}
		.service-log-form .section-title {
			font-size: 1.05rem;
			font-weight: 600;
			color: #1e293b;
			margin: 0 0 0.4rem 0;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		.service-log-form .section-title .fa {
			width: 2rem;
			height: 2rem;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
			color: #fff;
			border-radius: 8px;
			font-size: 0.95rem;
		}
		.service-log-form .topics-wrap .section-title .fa { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); }
		.service-log-form .section-desc {
			font-size: 0.875rem;
			color: #64748b;
			line-height: 1.5;
			margin: 0 0 1.25rem 0;
			max-width: none;
		}
		.service-log-form .employee-wrap {
			background: #f1f5f9;
			border-radius: 10px;
			padding: 1.25rem 1.35rem;
			margin-bottom: 1.5rem;
			border: 1px solid #e2e8f0;
		}
		.service-log-form .employee-wrap .section-title .fa { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
		.service-log-form .employee-wrap .label-input100 {
			font-weight: 600;
			color: #334155;
			margin-bottom: 0.5rem;
			display: block;
			white-space: nowrap;
		}
		.service-log-form .employee-wrap .employee-field-grid { width: 100%; }
		.service-log-form .employee-wrap .employee-field-col {
			width: 100%;
			max-width: 100%;
		}
		.service-log-form .employee-wrap .wrap-input100 { width: 100%; max-width: 100%; }
		.sl-select-wrap .select2-container { width: 100% !important; }
		.sl-select-wrap .select2-container--default .select2-selection--single {
			height: 42px; border: 1px solid #cbd5e1; border-radius: 8px;
			padding: 4px 8px; background: #fff;
		}
		.sl-select-wrap .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 32px; color: #1e293b; }
		.sl-select-wrap .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px; }
		.service-log-form .topics-wrap {
			background: #f1f5f9;
			border-radius: 10px;
			padding: 1.25rem 1.35rem 1.5rem;
			margin-bottom: 0;
			border: 1px solid #e2e8f0;
		}
		.service-log-form .topic-rows-list { display: flex; flex-direction: column; gap: 0.5rem; }
		.service-log-form .topic-row {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 0.75rem 1rem;
			padding: 0.85rem 1rem;
			background: #fff;
			border: 1px solid #e2e8f0;
			border-radius: 10px;
			box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
			transition: border-color 0.15s ease, box-shadow 0.15s ease;
		}
		.service-log-form .topic-row:hover {
			border-color: #cbd5e1;
			box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
		}
		.service-log-form .topic-row-header {
			background: #1e293b;
			color: #fff;
			border: none;
			box-shadow: none;
			padding: 0.65rem 1rem;
			margin-bottom: 0.15rem;
		}
		.service-log-form .topic-row-header:hover { border-color: transparent; box-shadow: none; }
		.service-log-form .topic-row-header .sl-col-heading {
			font-size: 0.7rem;
			font-weight: 700;
			text-transform: uppercase;
			letter-spacing: 0.06em;
			color: rgba(255,255,255,0.92);
		}
		.service-log-form .topic-row-header .topic-col .sl-col-heading { color: rgba(255,255,255,0.92); }
		.service-log-form .topic-row .topic-col {
			flex: 1 1 260px;
			min-width: 0;
			padding-right: 0;
		}
		.service-log-form .topic-row .topic-col .label-input100 {
			font-size: 0.9rem;
			font-weight: 500;
			color: #334155;
			line-height: 1.45;
			white-space: normal;
		}
		.service-log-form .topic-row .date-col,
		.service-log-form .topic-row .duration-col { position: relative; }
		.service-log-form .topic-row .date-col { width: 200px; flex-shrink: 0; }
		.service-log-form .topic-row .duration-col { width: 148px; flex-shrink: 0; }
		.service-log-form .sl-control {
			width: 100%;
			box-sizing: border-box;
			border-radius: 8px;
			border: 1px solid #cbd5e1;
			font-size: 0.9rem;
			height: 42px;
			padding: 0.375rem 0.65rem;
			color: #1e293b;
			transition: border-color 0.15s, box-shadow 0.15s;
		}
		.service-log-form .sl-control:focus {
			border-color: #3b82f6;
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
			outline: none;
		}
		.service-log-form input[type="date"].sl-control { min-height: 42px; line-height: 1.25; }
		.sl-sr-only {
			position: absolute;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			white-space: nowrap;
			border: 0;
		}
		.service-log-semi-panel {
			margin-top: 1.25rem;
			display: flex;
			flex-direction: column;
			gap: 0.5rem;
		}
		.service-log-submit-wrap {
			margin-top: 1.75rem;
			padding-top: 1.25rem;
			border-top: 1px solid #e2e8f0;
			text-align: center;
		}
		.service-log-submit-wrap .btn-primary {
			min-width: 200px;
			padding: 0.65rem 2rem;
			font-weight: 600;
			font-size: 1rem;
			border-radius: 10px;
			box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
			border: none;
		}
		.service-log-submit-wrap .btn-primary:hover {
			transform: translateY(-1px);
			box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
		}
		@media (max-width: 767px) {
			.service-log-form .topic-row .date-col,
			.service-log-form .topic-row .duration-col { width: 100%; flex: 1 1 100%; }
			.service-log-form .topic-row-header { display: none; }
			.service-log-form .sl-sr-only {
				position: static; width: auto; height: auto; margin: 0 0 4px 0;
				clip: auto; overflow: visible; white-space: normal;
				font-size: 0.8rem; color: #64748b; font-weight: 500;
			}
		}
	</style>

</head>

<body>





	<div class="container-contact100">

		<div class="contact100-map" id="google_map" data-map-x="40.722047" data-map-y="-73.986422" data-pin="images/icons/map-marker.png" data-scrollwhell="0" data-draggable="1"></div>



		<div class="wrap-contact100">

			<div class="contact100-form-title">

			

			</div>
	<?php
			if(isset($_GET['e']) && !empty($_GET['e']) && $_GET['e'] == "2"){
				
			
			?>
			<div class="badge-md mt-4 m-4 badge-danger">

					&nbsp;&nbsp;&nbsp;Employee Name is required.		

			</div>



		<?php  }?>
		<?php if (isset($_GET['e']) && $_GET['e'] === 'archived') { ?>
		<div class="badge-md mt-4 m-4 badge-danger">
			&nbsp;&nbsp;&nbsp;In-service log processing is not available for archived employees.
		</div>
		<?php } ?>
			<?php
			if(isset($_GET['s']) && !empty($_GET['s'])){
				
			
			?>
			<div class="badge-md mt-4 m-4 badge-success">

					&nbsp;&nbsp;&nbsp;Form was successfully submitted!

			</div>



		<?php exit; }?>
			<div class="service-log-page-head">
				<h1>Annual in-service / education log</h1>
			</div>
			<form class="contact100-form validate-form service-log-form" method="POST" enctype="multipart/form-data" action="process_service_log.php">

                <fieldset>
                	<div class="eval_class form-card">
                		<div class="employee-wrap">
                			<div class="section-title"><i class="fa fa-user"></i> Employee</div>
                			<div class="employee-field-grid">
	                		<div class="employee-field-col">
	                				<div class="wrap-input100 validatez-input" data-validate="Employee Name is required">
										<span class="label-input100">Employee&nbsp;name</span>
										<div class="sl-select-wrap">
										<select name="employee_name" class="select100 employee_name_class form-control" required>
											<option value="">Select Employee Name</option>
											<?php foreach($employee_records as $emp_id=>$emp_rec){ 

												?>
												<option value="<?=$emp_id?>" <?=((isset($record_details['id']) && $emp_id== $record_details['employee_id']) ? 'selected':'')  ?>><?=$emp_rec?></option>
										<!-- <input class="input100 ml-2 mt-2" type="date" name="date_filled" placeholder="Enter Date" required> -->

									<?php }?></select>
										</div>
										<span class="focus-input100"></span>
									</div>
	                		</div>
	                			</div>
	                		</div>
	                		<div class="topics-wrap">
	                			<div class="section-title"><i class="fa fa-book"></i> Topics &amp; Training</div>
	                			<div class="section-desc">Enter the date when each topic was completed. Duration defaults to 1 hour; change as needed.</div>
	                		<div class="topic-row topic-row-header">
	                			<div class="topic-col"><span class="sl-col-heading">Training topic</span></div>
	                			<div class="date-col"><span class="sl-col-heading">Date completed</span></div>
	                			<div class="duration-col"><span class="sl-col-heading">Duration</span></div>
	                		</div>
	                		<div class="topic-rows-list">
	                		<div class="topic-row">
	                				<div class="topic-col">
	                					<span class="label-input100">How to handle grievances/complaints</span>
	                				</div>
	                				<div class="date-col">
	                					<span class="label-input100 sl-sr-only">Date completed</span>
	                					<input type="date" name="q_1" value="<?=((isset($record_details['q_1'])) ? $record_details['q_1']:'')  ?>" class="form-control sl-control">
	                				</div>
	                				<div class="duration-col">
	                					<span class="label-input100 sl-sr-only">Duration</span>
	                					<input type="text" name="duration_1" value="<?= isset($record_details['duration_1']) && $record_details['duration_1'] !== '' ? htmlspecialchars($record_details['duration_1']) : '1 hour' ?>" placeholder="1 hour" class="form-control sl-control">
	                				</div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col">
	                					<span class="label-input100">Infection Control Training</span>
	                				</div>
	                				<div class="date-col">
	                					<span class="label-input100 sl-sr-only">Date completed</span>
	                					<input type="date" name="q_2" value="<?=((isset($record_details['q_2'])) ? $record_details['q_2']:'')  ?>" class="form-control sl-control">
	                				</div>
	                				<div class="duration-col">
	                					<span class="label-input100 sl-sr-only">Duration</span>
	                					<input type="text" name="duration_2" value="<?= isset($record_details['duration_2']) && $record_details['duration_2'] !== '' ? htmlspecialchars($record_details['duration_2']) : '1 hour' ?>" placeholder="1 hour" class="form-control sl-control">
	                				</div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Cultural Diversity</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_3" value="<?= (isset($record_details['q_3']) ? $record_details['q_3'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_3" value="<?= (isset($record_details['duration_3']) && $record_details['duration_3'] !== '' ? htmlspecialchars($record_details['duration_3']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Communication Barriers</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_4" value="<?= (isset($record_details['q_4']) ? $record_details['q_4'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_4" value="<?= (isset($record_details['duration_4']) && $record_details['duration_4'] !== '' ? htmlspecialchars($record_details['duration_4']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Ethics Training</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_5" value="<?= (isset($record_details['q_5']) ? $record_details['q_5'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_5" value="<?= (isset($record_details['duration_5']) && $record_details['duration_5'] !== '' ? htmlspecialchars($record_details['duration_5']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Workplace (OSHA) and patient safety</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_6" value="<?= (isset($record_details['q_6']) ? $record_details['q_6'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_6" value="<?= (isset($record_details['duration_6']) && $record_details['duration_6'] !== '' ? htmlspecialchars($record_details['duration_6']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Patients' Rights &amp; Responsibilities</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_7" value="<?= (isset($record_details['q_7']) ? $record_details['q_7'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_7" value="<?= (isset($record_details['duration_7']) && $record_details['duration_7'] !== '' ? htmlspecialchars($record_details['duration_7']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Compliance Program</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_8" value="<?= (isset($record_details['q_8']) ? $record_details['q_8'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_8" value="<?= (isset($record_details['duration_8']) && $record_details['duration_8'] !== '' ? htmlspecialchars($record_details['duration_8']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Methods for coping with work related issues of grief, loss and change</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_9" value="<?= (isset($record_details['q_9']) ? $record_details['q_9'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_9" value="<?= (isset($record_details['duration_9']) && $record_details['duration_9'] !== '' ? htmlspecialchars($record_details['duration_9']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Pain and Symptom Management</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_10" value="<?= (isset($record_details['q_10']) ? $record_details['q_10'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_10" value="<?= (isset($record_details['duration_10']) && $record_details['duration_10'] !== '' ? htmlspecialchars($record_details['duration_10']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Infection Control/Hand Hygiene</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_11" value="<?= (isset($record_details['q_11']) ? $record_details['q_11'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_11" value="<?= (isset($record_details['duration_11']) && $record_details['duration_11'] !== '' ? htmlspecialchars($record_details['duration_11']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Patient Safety</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="q_12" value="<?= (isset($record_details['q_12']) ? $record_details['q_12'] : '') ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="duration_12" value="<?= (isset($record_details['duration_12']) && $record_details['duration_12'] !== '' ? htmlspecialchars($record_details['duration_12']) : '1 hour') ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="service-log-semi-panel">
	                			<div class="section-title"><i class="fa fa-book"></i> Semi-annual Emergency Training</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Semi-Annual Emergency Training 1st</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="semi_emergency_1" value="<?= isset($record_details['semi_emergency_1']) ? htmlspecialchars($record_details['semi_emergency_1']) : '' ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="semi_duration_1" value="<?= isset($record_details['semi_duration_1']) && $record_details['semi_duration_1'] !== '' ? htmlspecialchars($record_details['semi_duration_1']) : '1 hour' ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		<div class="topic-row">
	                				<div class="topic-col"><span class="label-input100">Semi-Annual Emergency Training 2nd</span></div>
	                				<div class="date-col"><span class="label-input100 sl-sr-only">Date completed</span><input type="date" name="semi_emergency_2" value="<?= isset($record_details['semi_emergency_2']) ? htmlspecialchars($record_details['semi_emergency_2']) : '' ?>" class="form-control sl-control"></div>
	                				<div class="duration-col"><span class="label-input100 sl-sr-only">Duration</span><input type="text" name="semi_duration_2" value="<?= isset($record_details['semi_duration_2']) && $record_details['semi_duration_2'] !== '' ? htmlspecialchars($record_details['semi_duration_2']) : '1 hour' ?>" placeholder="1 hour" class="form-control sl-control"></div>
	                		</div>
	                		</div>
	                		</div>
						<div class="service-log-submit-wrap submit-wrap">
							<button type="submit" name="submit_waive" class="btn btn-primary">Submit</button>
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

<!--===============================================================================================--></script>

	<script src="js/map-custom.js"></script>
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

