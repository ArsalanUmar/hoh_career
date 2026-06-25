<!DOCTYPE html>

<html lang="en">

<head>

	<title>Employee Digital Signature Form</title>

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

					&nbsp;&nbsp;EMPLOYEE REGISTRATION
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="employee_register_process.php" >

				  
                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
                <fieldset>
                	<div class="eval_class form-card">

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
								<div class="wrap-input100 validate-input" data-validate="Email Address is required">
									<span class="label-input100">Email:</span>
									<input class="input100" type="email" name="email" placeholder="Enter Email Address" required>
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
														   <input type="submit" name="submit" class="next action-button" value="Submit"/>

							<!-- <input type="button" name="next" class="btn btn-primary next action-button" value="Next"> -->
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
          })
        })
    </script>
</body>

</html>

