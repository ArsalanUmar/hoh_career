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
		  $agreement_file = $record_details['hh_file_path'];//'pdf/ho_template.pdf';

		  if(!empty($record_details)){
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



		<?php }?>
			<div class="contact100-form-title-2">

					&nbsp;&nbsp;STAFF: PERSONNEL ACKNOWLEDGEMENT OF ORIENTATION
			</div>

			<hr>

			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="stf_pao_process.php" >

				  
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
                		<div class="form-card">
	                	<!-- 	<div class="row">
	                			<div class="col-md-12">
	                				<h5>Personnel Acknowledement of Orientation</h5>
	                			</div>
	                		</div> -->
	                	
	                		<div class="row mt-3">
	                			<div class="col-md-12">
	                				  <embed src="<?=$agreement_file?>" width="100%" height="1200px"/>

								</div>
							
	                		</div>
                		</div>
                		
					<div class="row">
		   				 				
						<div class="col-md-12 wrap-input100 validate-input row " data-validate = "Service Provider Representative is required">
							<div class="col-md-12 text_left">
							<span class="label-input100 f13">Staff Signature:</span>
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
															<input type="hidden" name="ref" value="<?=$ref?>" required>

							<input type="submit" name="submit" class="btn btn-primary next action-button" value="Submit">
						</div>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
    	$(function(){
    		  sign("mySignature");
    		               $('input[name="mySignature-type"]').hide();
$('input[type=file]').hide();
  $('label.radio').hide();
function sign(canv=""){
        console.log(canv);
       if(canv!= ""){
         el = '#'+canv;
          var s = $(el).signField(). // Setup
          on('change', function(){ 
            var signature = $(this); // div

            if (signature.signField('errors').length == 0) {
              $('.btn-primary').removeAttr("disabled")
            } else $('.btn-primary').attr("disabled", "disabled")
          });
          btn = $('.btn_max').clone();
        $(el).append(btn);

        // $(el).each(function(){
          $(el).find('.btn_max').first().remove();

            $("div#mySignature").find("button.mySignature_btn").remove();

        // });
       }else{
   
        var s = $('.sign-field').signField(). // Setup
          on('change', function(){ 
            var signature = $(this); // div

            if (signature.signField('errors').length == 0) {
              $('.btn-primary').removeAttr("disabled")
            } else $('.btn-primary').attr("disabled", "disabled")
          });
          btn = $('.btn_max').clone();
        $('.sign-field').append(btn);

        // $('.sign-field').each(function(){
          $('#mySignature').find('.btn_max').first().remove();
       
            $("div#mySignature").find("button.mySignature_btn").remove();
        // });
        }
      }

      function clear_canvas (canv)
          {

            console.log(canv);
             $("#"+canv).html('');
             $('button.btn-primary').prop('disabled',true);
             sign(canv);
             // $('button.btn-max').remove();
             $('.radio').hide();
             $('input[type=file]').hide();
             $('input[name="mySignature-type"]').hide();
        }
    		$('form').on('submit',function(e){
	    			// console.log('asdsa');
    				var sign1 = $('input[name=mySignature]').val().length;
    					// console.log(sign1);
	    		if(sign1<=0){
	    			e.preventDefault();
			        swal({
			                            title: "Oops!",
			                            text: "Signature is required.",
			                            icon: "warning"
			                          });
    				return false;

			      }else{
			      	$('form').submit();
			      }
    		})
    		
    	})
    </script>
</body>

</html>

