<?php
    require_once('database.php');

 $ref = (!empty($_GET['ref']) && isset($_GET['ref'])) ? $_GET['ref'] : '';
    $display = (empty($s)) ? 'none' : 'block';
    $db = new Database;
    $conn = $db->Conn();
    $sql = "SELECT * FROM `tbl_influenza_forms` where id='".$ref."' ";
    // echo $sql;die();
    $result_logged = $conn->query($sql);
    $record_details= $result_logged->fetch_assoc();
    // $record_array = array()
  
  // echo "<pre>",print_r($record_details),"</pre>";die();  

?>

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
  <style>
    .consent_class,.decline{
      display:block!important;
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
			<form class="contact100-form validate-form" method="POST" enctype="multipart/form-data"  action="influenza_form_admin_process.php" >

				  
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
                           
                            <span class="label-input100 col-md-12" style="text-align:justify;">I have been informed about and offered the opportunity to receive the influenza vaccine, at no charge to myself. I understand that it is my
                        responsibility to schedule to have the vaccination with either my healthcare provider or with the healthcare facility prior to any direct contact with
                        patients. As with any medical treatment, there is no guarantee that I will become immune or that I will not experience any adverse side effect from
                        the vaccine. The vaccine takes about two weeks to reach maximum protection. Therefore, I will not be fully protected from catching the flu until that
                        time</span>
                        <span class="focus-input100 col-md-2"></span>
                      </div>
                   </div>
                

               <div class="col-md-6  ">
                <div class="wrap-input100 " data-validate="Consent">
                  <span class="label-input100">Name:</span>
                  <div class="input100 mt-2"  >
                    <?= ucwords($record_details['name']) ?>
                  </div>
                  <span class="focus-input100"></span>
                </div>

              </div>
           
         

           
                
                      <div class="col-md-6 ">
                <div class="wrap-input100" data-validate="Consent" >
                  <span class="label-input100">Date:</span>
                     <div class="input100 mt-2"  >
                    <?=date('F d, Y',strtotime($record_details['date_signed']))?>
                  </div>
                  <span class="focus-input100"></span>
                </div>
              </div>
              <?php if($record_details['accept'] == '1' ){ ?>
              	     	<div class="col-md-6 consent_class">
								<div class="wrap-input100 validate-input" data-validate="Date Signed is required" >
									<span class="label-input100">Date Signed:</span>
									<input class="input100" type="date" name="date_signed" placeholder="Enter Route" value="<?=$record_details['date_signed']?>">
									<span class="focus-input100"></span>
								</div>
							</div>
	           	<div class="col-md-6 consent_class">
								<div class="wrap-input100 validate-input" data-validate="Route is required" >
									<span class="label-input100">Route:</span>
									<input class="input100" type="text" name="route" placeholder="Enter Route" >
									<span class="focus-input100"></span>
								</div>
							</div>
                <div class="col-md-6 consent_class">
                <div class="wrap-input100 validate-input" data-validate="Manufacturer is required">
                  <span class="label-input100">Manufacturer:</span>
                  <input class="input100" type="text" name="Manufacturer" placeholder="Enter Manufacturer" >
                  <span class="focus-input100"></span>
                </div>
              </div>
                <div class="col-md-6 consent_class">
                <div class="wrap-input100 validate-input" data-validate="Lot No  is required">
                  <span class="label-input100">Lot No.:</span>
                  <input class="input100" type="text" name="lot_no" placeholder="Enter Lot No" >
                  <span class="focus-input100"></span>
                </div>
              </div>
                <div class="col-md-4 consent_class">
                <div class="wrap-input100 validate-input" data-validate="Site of Administration is required">
                  <span class="label-input100">Site of Administration:</span>
                  <input class="input100" type="text" name="site" placeholder="Enter Site of Administration" >
                  <span class="focus-input100"></span>
                </div>
              </div>
              <div class="col-md-4 consent_class">
                <div class="wrap-input100 validate-input" data-validate="Date Vaccination is required">
                  <span class="label-input100">Date Vaccination Given:</span>
                  <input class="input100" type="date" name="vaccination_date" placeholder="Enter Date Vaccination" >
                  <span class="focus-input100"></span>
                </div>
              </div>
              <div class="col-md-4 consent_class">
                <div class="wrap-input100 validate-input" data-validate="Administered By is required">
                  <span class="label-input100">Administered By:</span>
                  <input class="input100" type="text" name="administered_by" placeholder="Administered by:" >
                  <span class="focus-input100"></span>
                </div>
              </div>
              
            <?php } ?>

                		</div>
                		
			
					<div class="row">
						<div class="col-md-12">
              <input type="hidden" name="ref" value="<?=$_GET['ref']?>">
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

	<script src="js/in_main_admin.js"></script>



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

