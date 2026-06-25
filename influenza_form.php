<!DOCTYPE html>

<html lang="en">

<head>

	<title>Annual Influenza Information & Consent Form </title>

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

					&nbsp;&nbsp;Annual Influenza Information & Consent Form
			</div>

			<hr>
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="influenza_form_process.php" >

				  
                    <!-- <div class="progress">
                    	<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                	</div> -->
                <fieldset>
                	<div class="eval_class form-card">

                		<div class="row">
                       <div class="col-md-12">
                          <div class="wrap-input100 validate-input row" data-validate="Consent">
                            <div class="col-md-12">
                                <h5>I consent</h5>
                            </div>
                            <input class="input col-md-2" type="radio" value="yes" name="i_consent" style="height:15px;margin-top:15px;" placeholder="I consent" required >
                            <span class="label-input100 col-md-10" style="text-align:justify;">I have been informed about and offered the opportunity to receive the influenza vaccine, at no charge to myself. I understand that it is my
                        responsibility to schedule to have the vaccination with either my healthcare provider or with the healthcare facility prior to any direct contact with
                        patients. As with any medical treatment, there is no guarantee that I will become immune or that I will not experience any adverse side effect from
                        the vaccine. The vaccine takes about two weeks to reach maximum protection. Therefore, I will not be fully protected from catching the flu until that
                        time</span>
                        <span class="focus-input100 col-md-2"></span>
                      </div>
                    </div>
                        <div class="col-md-12">
                          <div class="wrap-input100 validate-input row" data-validate="Consent">
                             <div class="col-md-12">
                                <h5>I decline</h5>
                            </div>
                            <input class="input col-md-2" type="radio" value="no" name="i_consent" style="height:15px;margin-top:15px;" placeholder="I consent" >
                            <span class="label-input100 col-md-10" style="text-align:justify;">I understand that due to my occupational exposure to respiratory illnesses, I may be at risk of acquiring Influenza infection. I have been given the opportunity to be vaccinated with the influenza vaccine, at no charge to me. I am aware that I cannot get the influenza disease from the influenza vaccine. I can be infected by the influenza virus but not feel ill for 24-48 hours before symptoms appear, and I can pass the virus to vulnerable patients who are at risk of complications or death from influenza. I can also pass the virus to my family, friends and co-workers. Influenza strains change every year and an immunization received in prior years does not usually provide immunity to this year’s strain of influenza.</span>
                        <span class="focus-input100 col-md-2"></span>
                      </div>
                    </div>

                 <div class="col-md-6 ">
                <div class="wrap-input100 validate-input" data-validate="Name is required">
                  <span class="label-input100">Name:</span>
                  <input class="input100" type="text" name="full_name" placeholder="Enter Full Name" >
                  <span class="focus-input100"></span>
                </div>
              </div>
                    <div class="col-md-6 " style=" max-width: 340px;">
                <div class="wrap-input100 validate-input" data-validate="Date is required" >
                  <span class="label-input100">Date:</span>
                  <input class="input100" type="date" name="date" placeholder="Date is required" >
                  <span class="focus-input100"></span>
                </div>
              </div>

						  <div class="col-md-6 decline">
                <div class="wrap-input100 validate-input" data-validate="Decline Reason is required"> 
                  <span class="label-input100">Reason for Decline:</span>
                  <select class="select100"  name="decline_reason" placeholder="Reason"  style="max-width:370px;">
                      <option value="">Select a reason</option>
                      <option value="opt_1">I have already received influenza vaccine.</option>
                        <option value="opt_2">I believe I will get the flu if I get the shot.</option>
                      <option value="opt_3">I do not like needles.</option>
                        <option value="opt_4">My philosophical or religious beliefs prohibit vaccination.</option>
                          <option value="opt_5">I have a medical contraindication to receiving the vaccine.</option>
                           <option value="opt_6">I do not wish to say why I decline.</option>
                       <option value="other">Other reason</option>
                  </select>
                  <span class="focus-input100"></span>
                </div>
              </div>
                <div class="col-md-6  other_reason_div">
                <div class="wrap-input100" data-validate="Other reason is required" >
              <span class="label-input100">Other Reason:</span>
                  <input class="input100" type="text" name="other_reason" placeholder="Other Reason" >
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
														   <input type="submit" name="submit" class=" action-button" value="Submit"/>

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

	<script src="js/in_main.js"></script>



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
       
$('.other_reason_div').hide();

          $('input[name=i_consent]').on('change',function(){
            var val = $(this).val();
            console.log(val);
            if(val == 'no'){
              $('div.consent_class').hide();
               $('div.decline').show();
               $('input[name=i_consent][value=yes]').prop('checked',false);
               $('div.consent_class').find('.wrap-input100').removeClass('validate-input');
                $('div.decline').find('.wrap-input100').addClass('validate-input');
            }

            if(val == 'yes'){
               $('div.decline').hide();
              $('div.consent_class').show();
               $('input[name=i_consent][value=no]').prop('checked',false);
                $('div.consent_class').find('.wrap-input100').addClass('validate-input');
                $('div.decline').find('.wrap-input100').removeClass('validate-input');
            }
          
          });

          $('select[name="decline_reason"]').on('change',function(){
            var reason = $(this).val();
            if(reason=='other'){
                 $('.other_reason_div').show();
                                               // $('div.other_reason_div').find('.wrap-input100').addClass('validate-input');

            
            }else{
              $('.other_reason_div').hide();
fb                              // $('div.other_reason_div').find('.wrap-input100').removeClass('validate-input');

            }
          })
        })
    </script>
</body>

</html>

