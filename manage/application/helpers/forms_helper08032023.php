<?php

  function createTable($fields = array(), $tbl_name='' , $data = array(), $cur_page='', $filter = false ){

    // $content = "<div id=".$tbl_name."><button id='create' class='btn btn-block btn-primary fifty'><i class='fa fa-plus'></i> Create</button></div>";

    $get = $_GET;

    $display = 'none';

    $message = '';

    //print_r($get);

    if(isset($get) && !empty($get)){

      extract($get);

      if(isset($s) && $s == '1'){

        $display = 'block';

        $message = 'Successfully added.';

      }else if(isset($s) && $s == '2'){

        $display = 'block';

        $message = 'Successfully updated.';

      }else if(isset($s) && $s == '3'){

        $display = 'block';

        $message = 'Successfully removed.';

      }else{

        $display = 'none';

        $message = '';

      }

    }

    

    $content = "<div class='box'>";

    $content .= "<div class='box-body'>";

    $content .= "<div class='success' style='display:$display'>$message</div>";

     if(isset($_GET['q'])){

          $content .= "<div id = 'modal'><button id='create' class='btn btn-block btn-primary fifty'><i class='fa fa-plus'></i> Create</button> &nbsp;&nbsp;";

          $content .= "<h4><b>Filtered by Ref. No.</b>: ".$_GET['q']."</h4>";

          $content .= "<a href='".base_url()."users/manage_content' class=''><button class='btn btn-block btn-danger btn-flat'>Remove Filter</button></a>";

          $content .= "</div>";

        }else{
          if($tbl_name=='tbl_staff' ){

          $content .= "<div id = 'modal'><button id='create' class='btn btn-block btn-primary fifty'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add</button></div>";
          }else if($tbl_name=='tbl_job_applications'){
              $content .= "<div id = 'modal'><button id='create' class='btn btn-block btn-primary fifty'  style='max-width:200px'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add Employee Signature</button></div>";
          }
          // elseif($tbl_name=='group_sheets'){
          //    $content .= "<div id = ''><a href='".base_url()."form_sheets/add' target='_blank'><button id='create_form' class='btn btn-block btn-primary fifty' type='button'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add</button></a></div>";

          // }


        }



    $content .= "<div class='table-responsive'><table id='".$tbl_name."' name='". $tbl_name."' class='table table-bordered table-striped'>

                <thead><tr>";


    // $content .= "<th width='12%'></th>";

    // echo "<pre>",print_r($fields),"</pre>";
// echo $tbl_name;die();
        foreach($fields as $k=>$v){

          extract($v);

          if(!empty($label)){
                if($tbl_name=='tbl_job_applications' && $label=='Signature'){

                }else{

                 $content .= "<th>$label</th>";
                }



          }



        }             
      if($tbl_name != 'tbl_influenza_forms'){

        $content .=  "<th>Action</th>";
      }

        $content .= '</thead>';

        $content .= '<tbody>';

    // echo "<pre>",print_r($fields),"</pre>";die();



     foreach($data as $k=>$v){
         if(isset($v->staff_id)){
          $v->id = $v->staff_id;
         }
         $content .= "<tr ref= ".$v->id .">";
         $base_encode = base64_encode($v->id);
          // if($tbl_name=='admin' ){

          //    $content .= "<td><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i></span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i></span></button></td>";
          // }elseif( $tbl_name='group_sheets'){
          //   $content .= "<td><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i></span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i></span></button><a href='".base_url().'views/'.$base_encode."'><button id=''  class='pads btn btn-block btn-primary btn-sm '><span><i class='fa fa-file-pdf-o'></i></span></button></a></td>";
          // }

          

          foreach($fields as $kf=>$vf){

            extract($vf);

            if(!empty($label)){

             if($kf == 'password'){

                $content .= "<td name='$kf'>********</td>";



              }elseif($kf=='id'){

                $content .= "<td name='$kf' style='text-align:center;'>".$v->$kf."</td>";



              }elseif($kf=='signature_file' || $kf=='signature_path'){

                if($kf=='signature_path'){
                  if($tbl_name=='tbl_staff'){
                     $content .= "<td name='$kf'><img width='200' src='".$v->$kf."'><a class='btn btn-xs btn-primary' target='_blank' href='".$v->$kf."' download>Download</a></td>";

                  }
                  // if(file_exists('staff_signatures/'.$v->$kf) && !empty(trim($v->$kf))){
                  // }else{

                    // $content.="<td>N/A</td>";
                  // }
                }else{

                  if(file_exists('signatures/'.$v->$kf) && !empty(trim($v->$kf))){
                     $content .= "<td name='$kf'><img width='200' src='".base_url().'signatures/'.$v->$kf."'><a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../signatures/".$v->$kf."' download>Download</a></td>";
                  }else{

                    $content.="<td>N/A</td>";
                  }
                }



              }elseif($kf=='accept'){
                if($v->$kf == '0'){

                  $content .= "<td name='$kf'><label class='label label-warning'>Decline</label></td>";
                }else{
                  $content .= "<td name='$kf'><label class='label label-success'>Consent</label></td>";

                }
              }elseif($kf=='pdf_file1' || $kf=='pdf_file2' || $kf=='pdf_file_path' || $kf== 'pdf_path'){

                if(!empty($v->$kf)){

                   $content .= "<td name='$kf'><a href='".base_url().'../'.$v->$kf."' target='_blank'><button id='view'  class='pads btn btn-block btn-success btn-sm'><span><i class='fa fa-file-o'></i></span></button></a></td>";
                }else{
                  if($tbl_name=='tbl_influenza_forms'){
                    $content .= "<td name='$kf'><a href='".base_url().'../influenza_form_admin.php?ref='.$v->id."'><button type='button' class='btn btn-warning  ' name='influenza_process_btn'>Process PDF</button></a></td>";
                  }else{
                    $content .="<td name='$kf'>N/A</td>";

                  }
                }



              }elseif($kf=='status'){
                if($v->$kf == 'Unsigned'){

                  $content .= "<td name='$kf'><label class='label label-warning'>Unsigned</label></td>";
                }elseif($v->$kf == 'Signed'){
                  $content .= "<td name='$kf'><label class='label label-success'>Signed</label></td>";

                }
              }elseif($kf == 'role'){

                      if($v->$kf == '1'){

                    $content .= "<td name='$kf'>Root Admin</td>";



                      }else{

                         $content .= "<td name='$kf'>Shopper Admin</td>";



                      }

                   

              }else{

                 $content .= "<td name='$kf'>".ucwords($v->$kf)."</td>";

              }

          }





          }

         // $content .= "<td name='name'>".ucwords($v->name)."</td>";

         // $content .= "<td>".ucwords($v->create_date)."</td>";
          // echo "<pre>",print_r($v),"</pre>";die();
          $base64_id_encode = base64_encode($v->id);
          // echo $tbl_name;die();

         if($tbl_name != 'tbl_influenza_forms' ){
          if($tbl_name=='tbl_job_applications' && !empty($v->zip_code)){
            $content .= "<td><a href='".base_url()."view/".$base64_id_encode."'><button id=''  class='pads btn btn-block btn-primary btn-sm'><span><i class='fa fa-eye'></i></span> View Details</button></a><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button></td>";
          }elseif($tbl_name=='tbl_test_certificates' ){
            $content .= "<td><a href='".base_url()."employee_certificates/".$base64_id_encode."'><button id=''  class='pads btn btn-block btn-primary btn-sm'><span><i class='fa fa-eye'></i></span> View Tests</button></a><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button></td>";
          }elseif($tbl_name=='tbl_staff' ){
             if (empty($v->legal_consent_path)){
               $content .= "<td>".$v->legal_consent_path." <a href='".base_url()."../staff_consent.php?ref=".$base64_id_encode."' target='_blank'><button id='gen_consent' class='pads btn btn-block btn-warning btn-sm ' style='    max-width: 120px;'><span ><i class='fa fa-refresh'></i> Generate Consent</span></button></a><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i> Edit</span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button><a href='".base_url().'views/'.$base_encode."'></td>";
              }else{
                   $content .= "<td><a href='".base_url().'../'.$v->legal_consent_path."' target='_blank' download><button id='gen_consent' class='pads btn btn-block btn-primary btn-sm ' style='    max-width: 120px;'><span ><i class='fa fa-download'></i> Download Consent</span></button></a><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i> Edit</span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button><a href='".base_url().'views/'.$base_encode."'></td>";
              }
          }else{
            if (empty($v->legal_consent_path)){
             $content .= "<td><a href='".base_url()."../employee_consent.php?ref=".$base64_id_encode."' target='_blank'><button id='gen_consent' class='pads btn btn-block btn-warning btn-sm ' style='    max-width: 120px;'><span ><i class='fa fa-refresh'></i> Generate Consent</span></button></a><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i> Edit</span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button><a href='".base_url().'views/'.$base_encode."'></td>";
            }else{
                $content .= "<td><a href='".base_url().'../'.$v->legal_consent_path."' target='_blank' download><button id='gen_consent' class='pads btn btn-block btn-primary btn-sm ' style='    max-width: 120px;'><span ><i class='fa fa-download'></i> Download Consent</span></button></a><button id='edit' class='pads btn btn-block btn-success btn-sm edit'><span id='edit'><i class='fa fa-edit'></i> Edit</span></button><button id='remove'  class='pads btn btn-block btn-danger btn-sm remove'><span><i class='fa fa-times'></i> Delete</span></button><a href='".base_url().'views/'.$base_encode."'></td>";
            }
          }
          }


         $content .= "</tr>";

      }   



        $content .= '</tbody>';

        $content .= '<tfoot><tr>';

       foreach($fields as $k=>$v){

          extract($v);

          if(!empty($label)){

            $content .= "<th>$label</th>";

          }



        }       

        $content .= '</tr></tfoot>';

        $content .= '</table>';

        $content .= '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

            <div class="modal-dialog" role="document">

              <div class="modal-content">

                <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4></h4>

      </div>';



      $content .= "<div class='modal-body'><form name='form_modal' method='POST' action= '".base_url()."add' enctype='multipart/form-data'>";

      $content .= "<div class='error' style='display:none'></div>";



       foreach($fields as $k=>$v){

          extract($v);

          if(!empty($label) && $k != 'create_date' && $k != 'update_date' && $k !='img_path' && $k != 'pdf_path' && $k !='status' && $k !='sign_link' && $k !='id' && $k !='staff_id'  && $k !='position' && $k !='co_facilitator_sign_url' && $k !='student_sign_url' && !in_array($k, array('client_1_email','client_2_email','client_3_email','client_4_email','client_5_email','client_6_email','client_7_email','client_8_email','client_9_email','client_10_email','client_11_email','client_12_email'))){

            $content .= "<div class='form-group'>";

            $content .= "<label for='".$k."' class='control-label'>$label</label>";

             if($k == 'account_type'){



                          $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";

                          $content .= "<option value='Current' ".($v == 'Current' ? 'selected' : '').">Current</option>";

                          $content .= "<option value='Savings'  ".($v == 'Savings' ? 'selected' : '').">Savings</option>";
                           $content .= "<option value='Transmission'  ".($v == 'Transmission' ? 'selected' : '').">Transmission</option>";
                          $content .= "</select>";

              }

              elseif($type == 'textarea'){

                $content .= "<textarea name='".$k."' id='".$k."' class='form-control required' placeholder='".$placeholder."'></textarea>";

              }else{
                if(in_array($k, array('signature'))){
                                 $content .= "<div><input type=".$type." accept='image/png, image/gif, image/jpeg' name='".$k."' class='form-control '  id='".$k."'></div>";
                                 // $content .= "<input type='email' name='".$k."_email' class='form-control '  id='".$k."' placeholder= 'Email' style='width:45%;float:left;margin-left:4px;'></div>";

                }else{

                   $content .= "<input type=".$type." name='".$k."' class='form-control required'  id='".$k."' placeholder='".$placeholder."'>";
                }


              }

            

            $content .= "</div>";

          }



         }       



        $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

        $content .= "<input type='hidden' class='form-control' name='process' value='".$tbl_name."' >";

       

        $content .='</form></div>

                          <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            <button type="submit" name="btnadd" class="btn btn-primary btnsave">Save changes</button>

                          </div>

                        </div>

                      </div>

                    </div>';



        $content .= '<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

                                  <div class="modal-dialog" role="document">

                                    <div class="modal-content">

                                      <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4></h4>

                  </div>';



         $content .= "<div class='modal-body'><form name='form_edit_modal' method='POST' action= '".base_url()."update' enctype='multipart/form-data'>";

               $content .= "<div class='error' style='display:none'></div>";



                 foreach($fields as $k=>$v){

                    extract($v);

                    if(!empty($label) && $k != 'create_date' && $k != 'update_date' && $k !='sign_link' && $k != 'pdf_path' && $k !='status' && $k!='id' && $k !='staff_id' && $k !='position' && $k !='co_facilitator_sign_url' && $k !='student_sign_url' && !in_array($k, array('client_1_email','client_2_email','client_3_email','client_4_email','client_5_email','client_6_email','client_7_email','client_8_email','client_9_email','client_10_email','client_11_email','client_12_email'))) {

                        $content .= "<div class='form-group'>";

                        $content .= "<label for='".$k."' class='control-label'>$label</label>";

                         if($k == 'account_type'){



                          $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";

                          $content .= "<option value='Current' ".($v == 'Current' ? 'selected' : '').">Current</option>";

                          $content .= "<option value='Savings'  ".($v == 'Savings' ? 'selected' : '').">Savings</option>";
                           $content .= "<option value='Transmission'  ".($v == 'Transmission' ? 'selected' : '').">Transmission</option>";
                          $content .= "</select>";

              }
else{

                           if($type == 'textarea'){

                             $content .= "<textarea name='".$k."' id='".$k."' class='form-control required' placeholder='".$placeholder."'></textarea>";

                            }else{
                                if(in_array($k, array('client_1','client_2','client_3','client_4','client_5','client_6','client_7','client_8','client_9','client_10','client_11','client_12'))){
                                 $content .= "<div><input type=".$type." name='".$k."' class='form-control '  id='".$k."' placeholder='Name' style='width:48%;float:left;'>";
                                 $content .= "<input type='email' name='".$k."_email' class='form-control '  id='".$k."' placeholder= 'Email' style='width:45%;float:left;margin-left:4px;'></div>";

                              }else{

                                 $content .= "<input type=".$type." name='".$k."' class='form-control required'  id='".$k."' placeholder='".$placeholder."'>";
                              }
                             // $content .= "<input type=".$type." name='".$k."' class='form-control required'  id='".$k."' placeholder='".$placeholder."' required>";

                            }                      

                        }                        

                        $content .= "</div>";

                    }



                 }       



                $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

                $content .= "<input type='hidden' class='form-control' name='process' value='".$tbl_name."' >";

                $content .= "<input type='hidden' class='form-control' name='ref' value='' >";



                $content .='</form></div>

                              <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                <button type="submit" name="btnupdate" class="btn btn-primary btnsave">Save Changes</button>

                              </div>

                            </div>

                          </div>

                        </div>';

                $content .= "</div>";

                $content .= "</div>";



    return $content;

  }










     

 function settings_form($response,$cur_page){

  // echo "<pre>",print_r($response),"</pre>";die();

    $get = $_GET;

    $display = 'none';

    $message = '';

    if(isset($get) && !empty($get)){

      extract($get);

      if(isset($s) && $s == '1'){

        $display = 'block';

        $message = 'Successfully submitted.';

      }else if(isset($s) && $s == '2'){

        $display = 'block';

        $message = 'Successfully updated.';

      }else if(isset($s) && $s == '3'){

        $display = 'block';

        $message = 'Successfully removed.';

      }else{

        $display = 'none';

        $message = '';

      }

    }

    $content = "<div class='row'>";

    $content .= "<div class='col-md-6'>";



    $content .= "<div class='box box-info'>";

    $content .= "<div class='box-header with-border'>

                  <h3 class='box-title'>Account Settings</h3>

                </div>";

    $content .= "<div class='success' style='display:$display'>$message</div>";

    $content .= "<div class='error' style='display:none'></div>";



    $content .= "<form name='settings' method='POST'  action='settings_db' ";

    $content .= "<div class='box-body'>";



        $content .= "<div class='form-group'>";

        $content .= "<h4>Username: ".ucwords($response->username)."</h4>";

      ;

        $content .= "</div>";



        

        $content .= "<div class='form-group'>";

        $content .= "<label for='Name' class='control-label'>Name: </label>";

        $content .= "<input type='text' name='name' value='".ucwords($response->name)."' class='form-control'  required>";

        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='name' class='control-label'>Current Password: </label>";

        $content .= "<input type='password' step='any' name='current_pwd' value='******' class='form-control' required>";

        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='name' class='control-label'>New Password: </label>";

        $content .= "<input type='password' step='any' name='new_pwd' value='******' class='form-control' required>";

        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='name' class='control-label'>Confirm New Password: </label>";

        $content .= "<input type='password' step='any' name='conf_pwd' value='******' class='form-control' required>";

        $content .= "</div>";
// var_dump(FCPATH.'../signatures/'.$response->id.'_counselor.jpg');die();
        if($response->id != '1'){
              if(file_exists(FCPATH.'../signatures/'.$response->id.'_counselor.jpg')){
                             $content .= "<div class='form-group'>";
        $content .= "<label for='name' class='control-label'>Current Signature: </label>";

                   $content .= "<div><img src='".base_url()."../signatures/".$response->id."_counselor.jpg' style='display:relative;width:200px;'></div>";
              $content .= "</div>";
              }
             $content .= "<div class='form-group' style='clear:both;'>";
              $content .= "<label for='name' class='control-label'>Signature: </label>";
          $content .="  <div id='mySignature' data-name='mySignature' data-max-size='2048' data-pen-tickness='3' data-pen-color='black' class='sign-field'></div>
          ";

          $content .= "</div>";
        }



        $content .= "<div class='form-group'>";

        $content .= "<input type='hidden' class='' name='pwd' value='".$response->password."'>";

        $content .= "<input type='hidden' class='' name='cur_page' value='".$cur_page."'>";

        $content .= "<input type='submit' class='btn btn-primary' name='settings_submit' value='Submit'>";

        $content .= "</div>";

        $content .= "</div>";

        $content .= "</form>";

        $content .= "</div>";

        $content .= "</div>";

        $content .= '         <script src="'.base_url().'js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="'.base_url().'../js/sketch.js"></script>  <script src="'.base_url().'../lang/jquery.signfield-en.min.js"></script>
    <script src="'.base_url().'../js/jquery.signfield.min.js"></script><script src="'.base_url().'../js/custom.js"></script>';
    $content .="    <script type=\"text/javascript\">$('.clear-canvas').prepend('<i class=\"fa fa-eraser\"></i>')</script>";

    

        return $content;

  }


 function view_form($response,$cur_page){

  // echo "<pre>",print_r($response),"</pre>";die();

    $get = $_GET;

    $display = 'none';

    $message = '';

    if(isset($get) && !empty($get)){

      extract($get);

      if(isset($s) && $s == '1'){

        $display = 'block';

        $message = 'Successfully submitted.';

      }else if(isset($s) && $s == '2'){

        $display = 'block';

        $message = 'Successfully updated.';

      }else if(isset($s) && $s == '3'){

        $display = 'block';

        $message = 'Successfully removed.';

      }else{

        $display = 'none';

        $message = '';

      }

    }

    $content = "<div class='row'>";

    $content .= "<div class='col-md-6'>";



    $content .= "<div class='box box-info'>";

    $content .= "<div class='box-header with-border'>

                  <h3 class='box-title'>Form Details</h3>

                </div>";

    $content .= "<div class='success' style='display:$display'>$message</div>";

    $content .= "<div class='error' style='display:none'></div>";




    $content .= "<div class='box-body'>";



        $content .= "<div class='form-group'>";

        // $content .= "<h4>Configuration</h4>";

      ;

        $content .= "</div>";

          // echo "<pre>",print_r($response),"</pre>";die();

        

        $content .= "<div class='form-group'>";

        $content .= "<label for='Name' class='control-label'>Name: </label> ".convert_chars(ucwords($response->surname." ".$response->firstname));


        $content .= "</div>";

      
        $content .= "<div class='form-group'>";

        $content .= "<label for='Email' class='control-label'>Email-Addresse: </label> ".convert_chars(ucwords($response->email));

        $content .= "</div>";


        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>Geburtsdatum: </label> ".convert_chars(ucwords($response->birthdate));


        $content .= "</div>";
       
        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>Ort: </label> ".convert_chars(ucwords($response->ort));


        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>Krankenversicherung: </label> ".convert_chars(ucwords($response->hospital));


        $content .= "</div>";
        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>Versicherten-Nr.: </label> ".convert_chars(ucwords($response->versicherten));


        $content .= "</div>";
        
        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'> Straßenname  Hausnumme: </label> ".convert_chars(ucwords($response->street_address));

        $content .= "</div>";
    
        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'> Postleitzahl Wohnort: </label> ".convert_chars(ucwords($response->zip_code));

        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>  IBAN: </label> ".ucwords($response->iban);

        $content .= "</div>";
         $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>  Bankinstitut: </label> ".convert_chars(ucwords($response->bank));

        $content .= "</div>";

         $content .= "<div class='form-group'>";

        $content .= "<label for='' class='control-label'>  GENERATED FILES: </label> ";

        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->pdf_file1."' target='_blank'>".$response->pdf_file1."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->pdf_file1."' download>Download</a></p>";
       
        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->pdf_file3."' target='_blank'>".$response->pdf_file3."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->pdf_file3."' download>Download</a></p>";  

        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->pdf_file4."' target='_blank'>".$response->pdf_file4."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->pdf_file4."' download>Download</a></p>";
        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->pdf_file5."' target='_blank'>".$response->pdf_file5."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->pdf_file5."' download>Download</a></p>";

       $content .= "<br><p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->pdf_file2."' target='_blank'>".$response->pdf_file2."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->pdf_file2."' download>Download</a></p>";

        $content .="<label class='control-label'>INVOICES</label>";
        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->invoice_file1."' target='_blank'>".$response->invoice_file1."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->invoice_file1."' download>Download</a></p>";
        $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->invoice_file2."' target='_blank'>".$response->invoice_file2."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->invoice_file2."' download>Download</a></p>";
         $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->invoice_file3."' target='_blank'>".$response->invoice_file3."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->invoice_file3."' download>Download</a></p>";
         $content .= "<p>&bull;&nbsp;<a href='".base_url()."../pdf_files/".$response->invoice_file4."' target='_blank'>".$response->invoice_file4."</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../pdf_files/".$response->invoice_file4."' download>Download</a></p>";
        $content .= "</div>";
         $content .= "<div><a href='".base_url()."/signatures'><button class='btn btn-default'>Go back to list</button></a></div>";

        $content .= "</div>";

        $content .= "</div>";

    

        return $content;

  }

 
 function view_certificates($response,$cur_page){

  // echo "<pre>",print_r($response),"</pre>";die();

    $get = $_GET;

    $display = 'none';

    $message = '';

    if(isset($get) && !empty($get)){

      extract($get);

      if(isset($s) && $s == '1'){

        $display = 'block';

        $message = 'Successfully regenerated.';

      }else if(isset($s) && $s == '2'){

        $display = 'block';

        $message = 'Successfully updated.';

      }else if(isset($s) && $s == '3'){

        $display = 'block';

        $message = 'Successfully removed.';

      }else{

        $display = 'none';

        $message = '';

      }

    }

    $content = "<div class='row'>";

    $content .= "<div class='col-md-8'>";



    $content .= "<div class='box box-info'>";

    $content .= "<div class='box-header with-border'>

                  <h3 class='box-title'>Certificate Available for ".convert_chars(ucwords($response->employee_name))."</h3>

                </div>";

    // $content .= "<div class='success' style='display:$display'>$message</div>";

    // $content .= "<div class='error' style='display:none'></div>";




    $content .= "<div class='box-body'>";



        $content .= "<div class='form-group'>";

        // $content .= "<h4>Configuration</h4>";

      ;

        $content .= "</div>";

          // echo "<pre>",print_r($response),"</pre>";die();

        

        // $content .= "<div class='form-group'>";

        // $content .= "<label for='Name' class='control-label'>Name: </label> ".convert_chars(ucwords($response->employee_name));


        // $content .= "</div>";

      
        $test_file_array = array();

         $content .= "<div class='form-group'>";

          $content .= "<label for='' class='control-label'>  GENERATED FILES: </label> ";
          if(!empty($response->waived_test_file_path)){
             $test_file_array['waive'] = 'Waive Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->waived_test_file_path."' target='_blank'>WAIVE TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->waived_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->waived_certificate_file_path."' target='_blank'>WAIVE CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->waived_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

           if(!empty($response->hepa_test_file_path)){
             $test_file_array['hepab'] = 'Hepatitis B Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->hepa_test_file_path."' target='_blank'>HEPATITIS B TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->hepa_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->hepa_certificate_file_path."' target='_blank'>HEPATITIS B CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->hepa_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

            if(!empty($response->harass_test_file_path)){
               $test_file_array['harass'] = 'Harassment Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->harass_test_file_path."' target='_blank'>HARASSMENT TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->harass_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->harass_certificate_file_path."' target='_blank'>HARASSMENT CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->harass_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }
            if(!empty($response->hygiene_test_file_path)){
               $test_file_array['handhygiene'] = 'Hand Hygiene Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->hygiene_test_file_path."' target='_blank'>HAND HYGIENE TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->hygiene_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->hygiene_certificate_file_path."' target='_blank'>HAND HYGIENE CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->hygiene_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

           if(!empty($response->emergency_test_file_path)){
             $test_file_array['emergency'] = 'Emergency Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->emergency_test_file_path."' target='_blank'> EMERGENCY TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->emergency_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->emergency_certificate_file_path."' target='_blank'> EMERGENCY  CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->emergency_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

          if(!empty($response->covid_test_file_path)){
             $test_file_array['covid'] = 'Covid Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->covid_test_file_path."' target='_blank'> COVID TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->covid_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->covid_certificate_file_path."' target='_blank'> COVID  CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->covid_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

           if(!empty($response->glucometer_test_file_path)){
             $test_file_array['glucometer'] = 'Glucometer Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->glucometer_test_file_path."' target='_blank'> GLUCOMETER TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->glucometer_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->glucometer_certificate_file_path."' target='_blank'> GLUCOMETER  CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->glucometer_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

            if(!empty($response->bloodpatho_test_file_path)){
               $test_file_array['bloodpatho'] = 'Blood Pathogen Test'; 
            $content .="<div class='row'>";
            $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->bloodpatho_test_file_path."' target='_blank'> BLOOD PATHOGEN TEST FILE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->bloodpatho_test_file_path."' download>Download</a></p>";
             $content .="</div>";
              $content .="<div class='col-md-6'>";
              $content .= "<p>&bull;&nbsp;<a href='".base_url()."../".$response->bloodpatho_certificate_file_path."' target='_blank'> BLOOD PATHOGEN  CERTIFICATE</a>&nbsp;&nbsp;<a class='btn btn-xs btn-primary' target='_blank' href='".base_url()."../".$response->bloodpatho_certificate_file_path."' download>Download</a></p>";
             $content .="</div>";

              $content .="</div>";
          }

      

        $content .= "</div>";


        $content .= "</div></div></div>";


      $content .= "<div class='col-md-4'>";



    $content .= "<div class='box box-info'>";

    $content .= "<div class='box-header with-border'>

                  <h3 class='box-title'>Regenerate Certificate</h3>

                </div>";

    $content .= "<div class='success' style='display:$display'>$message</div>";

    $content .= "<div class='error' style='display:none'></div>";



    $content .= "<form name='regenerate_cert' method='POST'  action='".base_url()."../regenerate_certificate.php' ";

    $content .= "<div class='box-body'>";



        



        

        $content .= "<div class='form-group'>";

        $content .= "<label for='Name' class='control-label'>Certificate: </label>";
        $content .= "<select name='test_type' class='form-control' required >";
        $content .= "<option value=''></option>";
        foreach($test_file_array as $test_type=>$test_label){
          $content .= "<option value='".$test_type."'>".ucwords($test_label)."</option>";
        }
        // $content .= "<input type='text' name='name' value='".ucwords($response->name)."' class='form-control'  required>";
        $content .="</select>";
        $content .= "</div>";

        $content .= "<div class='form-group'>";

        $content .= "<label for='name' class='control-label'>Date: </label>";

        $content .= "<input type='date'  name='date_filled' value='' class='form-control' required>";
        $content .= "<input type='hidden'  name='ref' value='".$response->id."' class='form-control' required>";

        $content .= "</div>";

        // $content .= "</div>";




        $content .= "<div class='form-group'>";


        $content .= "<input type='hidden' class='' name='cur_page' value='".$cur_page."'>";

        $content .= "<input type='submit' class='btn btn-primary' name='regenerate_submit' value='Submit'>";

        $content .= "</div>";

        $content .= "</div>";

        $content .= "</form>";

        $content .= "</div>";

        return $content;

  }





  function style(){

     $style = "



            <style>

            



      /*** Table Styles **/



      .table-fill {

        background: white;

        border-radius:3px;

        border-collapse: collapse;

        height: 320px;

        margin: auto;

        max-width: 600px;

        padding:5px;

        width: 100%;

        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);

        animation: float 5s infinite;

      }

       

      th {

        color:#D5DDE5;;

        background:#1b1e24;

        border-bottom:4px solid #9ea7af;

        border-right: 1px solid #343a45;

        font-size:16px;

        font-weight: 100;

        padding:10px;

        text-align:left;

        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);

        vertical-align:middle;

      }



      th:first-child {

        border-top-left-radius:3px;

      }

       

      th:last-child {

        border-top-right-radius:3px;

        border-right:none;

      }

        

      tr {

        border-top: 1px solid #C1C3D1;

        border-bottom-: 1px solid #C1C3D1;

        color:#666B85;

        font-size:16px;

        font-weight:normal;

        text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);

      }

       

      tr:hover td {

        background:#4E5066;

        color:#FFFFFF;

        border-top: 1px solid #22262e;

        border-bottom: 1px solid #22262e;

      }

       

      tr:first-child {

        border-top:none;

      }



      tr:last-child {

        border-bottom:none;

      }

       

      tr:nth-child(odd) td {

        background:#EBEBEB;

      }

       

      tr:nth-child(odd):hover td {

        background:#4E5066;

      }



      tr:last-child td:first-child {

        border-bottom-left-radius:3px;

      }

       

      tr:last-child td:last-child {

        border-bottom-right-radius:3px;

      }

       

      td {

        background:#FFFFFF;

        padding:10px;

        text-align:left;

        vertical-align:middle;

        font-weight:300;

        font-size:12px;

        border-right: 1px solid #C1C3D1;

      }



      td:last-child {

        border-right: 0px;

      }



      th.text-left {

        text-align: left;

      }



      th.text-center {

        text-align: center;

      }



      th.text-right {

        text-align: right;

      }



      td.text-left {

        text-align: left;

      }



      td.text-center {

        text-align: center;

      }



      td.text-right {

        text-align: right;

      }



      h2{

        color: white;

        background: #3e94ec;

        text-align:center;

        padding:4px;

      }



            </style>";

      return $style;

  }


 function convert_chars($input=""){
    $converted_char = "";
    $converted_char = str_ireplace("ß", "ss", $input);
    $converted_char = str_ireplace("ÃŸ", "ss", $converted_char);
    $converted_char = str_ireplace("ä", "ae", $converted_char);
   $converted_char = str_ireplace("ü", "ue", $converted_char);
    $converted_char = str_ireplace("ö", "oe", $converted_char);

    return $converted_char;
 }
    

?>