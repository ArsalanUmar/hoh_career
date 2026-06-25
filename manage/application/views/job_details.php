<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

       Job Application of <?= ucwords($details->first_name." ".$details->last_name) ?> as <?=ucwords($details->position)?>

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?=base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active"><?=$page?></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-7">
            <div class="box box-info">
                <div class="box-header with-border">

                  <h3 class="box-title">Application Details</h3>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">

                        <dl class="row">
                           <dt class="col-sm-4  mt-2">Name:</dt>
                            <dd class="col-sm-8  mt-2"> <?= ucwords($details->first_name." ".$details->last_name) ?></dd>
                            <dt class="col-sm-4 mt-2">Address:</dt>
                            <dd class="col-sm-8  mt-2"> <?= $details->street_address." ".$details->city." ".$details->state." ".$details->zip_code ?></dd>
                            <dt class="col-sm-4 mt-2">Email:</dt>
                            <dd class="col-sm-8  mt-2"><?= $details->email ?></dd>
                            <dt class="col-sm-4  mt-2">Telephone:</dt>
                            <dd class="col-sm-8  mt-2"><?=$details->telephone_no ?></dd>
                            <dt class="col-sm-4  mt-2">Social Security Number:</dt>
                            <dd class="col-sm-8  mt-2"><?= $details->sss_number ?> </dd>
                            <dt class="col-sm-4  mt-2 ">Drivers License No:</dt>
                            <dd class="col-sm-8  mt-2 "><?= $details->drivers_license ?> </dd>
                             <dt class="col-sm-4  mt-2">Date Application Submitted:</dt>
                            <dd class="col-sm-8  mt-2"><?=date('F d, Y',strtotime($details->date_filled)) ?> </dd>

                          <dt class="col-sm-4  mt-2">Has Employment Agreement Already?:</dt>
                            <?php if($details->has_agreement_job=='true'){ ?>
                            <dd class="col-sm-8  mt-2"><label class="label label-success">Submitted</label> </dd>

                            <?php  }else{ ?>
                                <dd class="col-sm-8  mt-2"><label class="label label-danger">Incomplete</label> </dd>

                              <?php } ?>
                             <!--  <dt class="col-sm-4  mt-2">View Full Job Application:</dt>
                            <dd class="col-sm-8  mt-2"></dd> -->
                        </dl>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <a class="btn  btn-info" href="<?=base_url().'../view_job_application_pdf.php?ref='.$ref?>" target="_blank" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;"> <span><i class="fa fa-eye"></i></span> &nbsp;View Full Job Application </a>
                  </div>
                   <div class="col-md-12 mt-2">
                    <a class="btn  btn-primary" href="<?=base_url().'../job_application_edit_form.php?ref='.$ref?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;"> <span><i class="fa fa-edit"></i></span> &nbsp;Edit Job Application </a>
                  </div>
                    <?php if(empty($details->pdf_file_with_reference_path)){ ?>
                  <div class="col-md-12 mt-2">
                  <a class="btn  btn-warning" href="<?=base_url().'../rc_form.php?ref='.$ref?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;"> <span><i class="fa fa-edit"></i></span> &nbsp;Update References Check (staff) </a>
                  </div>
                <?php }?>

                   <?php if(!empty($details->hh_file_path)){
                      if(strpos($details->hh_file_path, '_SIGNED_') === false){
                    ?>
                 <div class="col-md-12 mt-2">
                    <a class="btn  btn-warning" href="<?=base_url().'../stf_pao_form.php?ref='.$ref?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;"> <span><i class="fa fa-edit"></i></span> &nbsp;Sign Health Orientation (staff) </a>
                  </div> 
                <?php }
                  }
                ?>
                    <div class="col-md-12 mt-2">
                       <a class=" btn btn-warning" href="<?=base_url().'../pchk_form.php?ref='.$ref?>"  id="send_orientation_btn" type="button" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;font-size:12px;"> <span><i class="fa fa-plus"></i></span> &nbsp;Create Orientation  Checklist</a>
                  <!-- </div> -->
                 <!--  <a class="btn  btn-warning" href="<?=base_url().'form1'?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;"> <span><i class="fa fa-edit"></i></span> &nbsp;Fill Personnel Checklist (staff) </a> -->
                  </div>
                      <?php if($details->has_agreement_job=='false'){ ?>
                    <div class="col-md-12 mt-2">
                  <button class=" btn btn-success" ref="<?=$details->id?>" id="send_employment_btn" type="button" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;font-size:12px;"> <span><i class="fa fa-paper-plane"></i></span> &nbsp;Send Employment Agreement & Job Description</button>
                  </div>
                     <!-- <div class="col-md-12 mt-2">
                  <button class=" btn btn-danger" ref="<?=$details->id?>" id="autosign_employment_btn" type="button" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;font-size:12px;"> <span><i class="fa fa-check"></i></span> &nbsp;Automatically Sign Agreement & Job Description</button>
                  </div> -->

                  <?php  }//echo "<pre>",print_r($details),"</pre>"; ?>
                </div>
            </div>
          </div>
          <div class="col-md-5">
             <div class="box box-info">
                <div class="box-header with-border">
                         <h3 class="box-title">Application Files</h3>
                        <hr>
                       
                        <dl class="row">
                           <dt class="col-sm-5  mt-2">Resume :</dt>
                            <dd class="col-sm-7  mt-2">   <?php if(empty($details->resume_file_path)){ ?>
                              No Resume Attached    

                      <?php }else{ 

                           if(!empty($details->resume_file_path)){ 
                      
                        ?>
                        <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../resume_files/'.$details->resume_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Resume </a>
                          </div>
                        </div>
                          <?php }else{ ?>
                            <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../resume_files/'.$details->resume_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Resume </a>
                          </div>
                        </div>
                      <?php } }?></dd>
                      <dt class="col-sm-5  mt-2">HBV Form :</dt>
                            <dd class="col-sm-7  mt-2">   <?php if(file_exists(str_replace('pdf_files/', 'pdf_files/HBV_', $details->pdf_file_path))){ ?>
                              No Resume Attached

                      <?php }else{ 
                        $hbv_path =str_replace('pdf_files/', 'pdf_files/HBV_', $details->pdf_file_path)  ;
                        ?>
                        <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$hbv_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download HBV Consent </a>
                          </div>
                        </div>
                      <?php }?></dd>
                    <?php if(!empty($details->legal_consent_path)){ ?>
                     <dt class="col-sm-5  mt-2">Legal Consent:</dt>
                       <dd class="col-sm-7  mt-2">
                    <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->legal_consent_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Legal Consent </a>
                          </div>
                        </div>
                      </dd>
                     <?php  }?>
                       <?php if($details->has_agreement_job=='true'){ ?>
                     <dt class="col-sm-5  mt-2">Job Description:</dt>
                       <dd class="col-sm-7  mt-2">
                    <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->jo_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Job Description </a>
                          </div>
                             <?php if($details->organization == 'Both'){ 
                              $jo_2_file = str_replace("JO_", "JO_2_", $details->jo_file_path);

                              if(file_exists('../'.$jo_2_file)){
                            ?>
                              <div class="col-md-12 mt-2" >
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$jo_2_file?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Job Description </a>
                          </div>


                          <?php } 
                        }
                        ?>
                         <?php if($details->organization == 'Both' || $details->organization == 'Hospice'){ 
                              $jo_3_file = str_replace("JO_", "JO_3_", $details->jo_file_path);
                                 $jo_4_file = str_replace("JO_", "JO_4_", $details->jo_file_path);
                              if(file_exists('../'.$jo_3_file)){
                            ?>
                              <div class="col-md-12 mt-2" >
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$jo_3_file?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Job Description </a>
                          </div>


                          <?php } 

                            if(file_exists('../'.$jo_4_file)){
                           ?>
                              <div class="col-md-12 mt-2" >
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$jo_4_file?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Job Description </a>
                          </div>
                           <?php
                         }

                        }
                        ?>
                        </div>
                      </dd>
                     <?php  }?>

                      <?php if($details->has_agreement_job=='true'){ ?>
                     <dt class="col-sm-5  mt-2">Job Agreement:</dt>
                       <dd class="col-sm-7  mt-2">
                    <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->jo_agreement_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Job Agreement </a>
                          </div>

                        
                        </div>
                      </dd>
                     <?php  }?>

                      <?php
                      // Orientation Topics Covered file is generated as JO_ORIENTATION_TOPICS_...
                      if(!empty($details->jo_file_path)){
                        if(stripos($details->jo_file_path, 'JO_SIGNED_') !== FALSE){
                          $orientation_topics_path = str_replace("JO_SIGNED_", "JO_ORIENTATION_TOPICS_", $details->jo_file_path);
                        }else{
                          $orientation_topics_path = str_replace("JO_", "JO_ORIENTATION_TOPICS_", $details->jo_file_path);
                        }
                        if(file_exists('../'.$orientation_topics_path)){
                      ?>
                      <dt class="col-sm-5 mt-2" style="font-size: 13px;">Orientation Topics:</dt>
                      <dd class="col-sm-7 mt-2">
                        <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$orientation_topics_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Orientation Topics Covered </a>
                          </div>
                        </div>
                      </dd>
                      <?php
                        }
                      }
                      ?>

                      <?php  
                       if(!empty($details->hh_file_path)){ 
                      
                        ?>
                        <dt class="col-sm-5  mt-2" style="font-size: 13px;">Orientation Acknowledgement:</dt>
                       <dd class="col-sm-7  mt-2">
                        <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->hh_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Orientation Acknowledgement </a>
                          </div>
                          <?php if($details->organization == 'Both'){ 
                              if(stripos($details->hh_file_path, 'SIGNED') !== FALSE){

                               $hh_2_file = str_replace("HH_SIGNED_", "HH_2_SIGNED_", $details->hh_file_path);
                              }else{
                                 $hh_2_file = str_replace("HH_", "HH_2_", $details->hh_file_path);
                              }

                              if(file_exists('../'.$hh_2_file)){
                            ?>
                              <div class="col-md-12 mt-2" >
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$hh_2_file?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Orientation Acknowledgement 2</a>
                          </div>


                          <?php } }?>
                          <?php if($details->organization == 'Both' || $details->organization == 'Hospice'){ 
                             if(stripos($details->hh_file_path, 'SIGNED') !== FALSE){

                               $hh_3_file = str_replace("HH_SIGNED_", "HH_3_SIGNED_", $details->hh_file_path);
                              }else{
                                $hh_3_file = str_replace("HH_", "HH_3_", $details->hh_file_path);
                              }
                              if(file_exists('../'.$hh_3_file)){
                            ?>
                              <div class="col-md-12 mt-2" >
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$hh_3_file?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Orientation Acknowledgement 3</a>
                          </div>


                          <?php } }?>
                        </div>
                         </dd>
                          <?php } ?>

                           <?php  
                       if(!empty($details->pdf_file_with_reference_path)){ 
                      
                        ?>
                        <dt class="col-sm-5  mt-2" style="font-size: 13px;">Reference Check:</dt>
                       <dd class="col-sm-7  mt-2">
                        <div class="row">
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->pdf_file_with_reference_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Reference Check</a>
                          </div>
                        </div>
                         </dd>
                          <?php } ?>

                               <?php  
                       if(!empty($details->pcklist_file_path)){ 
                      
                        ?>
                        <dt class="col-sm-5  mt-2">Orientation Checklist:</dt>
                       <dd class="col-sm-7  mt-2">
                        <div class="row">
                            <?php if(strpos($details->pcklist_file_path, "**,**") !== false) { 
                                $file_chck = explode("**,**", $details->pcklist_file_path);
                                $chk_file_1 = $file_chck[0];
                                 $chk_file_2 = $file_chck[1];
                              ?>
                          <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$chk_file_1?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Checklist Hospice </a>
                          </div>
                           <div class="col-md-12" style="margin-top:6px;">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$chk_file_2?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Checklist Home Health </a>
                          </div>
                        <?php }else{ ?>   
                               <div class="col-md-12">
                               <a class="btn btn-sm btn-primary" href="<?=base_url().'../'.$details->pcklist_file_path?>" style=" max-width: 280px!important;
    margin: 0 auto;
    display: block;" download> <span><i class="fa fa-download"></i></span>   &nbsp;Download Orientation Checklist </a>
                          </div>

                        <?php  } ?>
                        </div>
                         </dd>
                          <?php } ?>
                    </dl>
                </div>
              </div>
          </div>
        </div>
  

      <!-- /.row -->

      <!-- /.row (main row) -->



    </section>

    <!-- /.content -->

  </div>

       <script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
