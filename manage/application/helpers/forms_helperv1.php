<?php
	function createTable($fields = array(), $tbl_name='' , $data = array(), $cur_page='' ){
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
		$content .= "<div id = 'modal'><button id='create' class='btn btn-block btn-primary fifty'><i class='fa fa-plus'></i> Create</button></div>";

		$content .= "<table id='".$tbl_name."' name='". $tbl_name."' class='table table-bordered table-striped'>
                <thead><tr>";

//echo "<pre>",print_r($fields),"</pre>";
        foreach($fields as $k=>$v){
        	extract($v);
        	if(!empty($label)){
        		$content .= "<th>$label</th>";

        	}

        }        			
		$content .= "<th width='12%'></th>";
        $content .= '</tr></thead>';
        $content .= '<tbody>';
//echo "<pre>",print_r($data),"</pre>";die();

     foreach($data as $k=>$v){
         $content .= "<tr ref= ".$v->id .">";
          
          foreach($fields as $kf=>$vf){
            extract($vf);
            if(!empty($label)){
              if($kf == 'role'){
                 if($v->$kf == '2'){
                  $role = 'Project Leader';
                 }else if($v->$kf == '3'){
                  $role = 'Project Member';
                 }else{
                   $role = 'Admin';
                 }
                 $content .= "<td name='$kf'>".$role."</td>";

              }else if($kf == 'password'){
                $content .= "<td name='$kf'>********</td>";

              }else{
                 $content .= "<td name='$kf'>".ucwords($v->$kf)."</td>";
              }
          }


          }
         // $content .= "<td name='name'>".ucwords($v->name)."</td>";
         // $content .= "<td>".ucwords($v->create_date)."</td>";
         $content .= "<td><button id='edit' class='pads btn btn-block btn-success btn-sm'><span id='edit'><i class='fa fa-edit'></i></span></button><button id='remove'  class='pads btn btn-block btn-success btn-sm'><span><i class='fa fa-times'></i></span></button></td>";

         $content .= "</tr>";
      }   

 		// foreach($data as $k=>$v){
   //     		$content .= "<tr ref= ".$v->id .">";
   //      	$content .= "<td name='name'>".ucwords($v->name)."</td>";
   //      	$content .= "<td>".ucwords($v->create_date)."</td>";
   //      	$content .= "<td><button id='edit' class='pads btn btn-block btn-success btn-sm'><span id='edit'><i class='fa fa-edit'></i></span></button><button id='remove'  class='pads btn btn-block btn-success btn-sm'><span><i class='fa fa-times'></i></span></button></td>";

   //      	$content .= "</tr>";
   //      }   
 
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

      $content .= "<div class='modal-body'><form name='form_modal' method='POST' action= '".base_url()."manage/add'>";
      $content .= "<div class='error' style='display:none'></div>";

   		 foreach($fields as $k=>$v){
        	extract($v);
        	if(!empty($label) && $k != 'create_date' && $k != 'update_date'){
        		$content .= "<div class='form-group'>";
        		$content .= "<label for='".$k."' class='control-label'>$label</label>";
            if($k == 'role'){
              $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";
              $content .= "<option value='2'>Project Leader</option>";
              $content .= "<option value='3'>Project Member</option>";
              $content .= "</select>";
            }else{
              if($type == 'textarea'){
                $content .= "<textarea name='".$k."' id='".$k."' class='form-control required' placeholder='".$placeholder."'></textarea>";
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

         $content .= "<div class='modal-body'><form name='form_edit_modal' method='POST' action= '".base_url()."manage/update'>";
               $content .= "<div class='error' style='display:none'></div>";

                 foreach($fields as $k=>$v){
                    extract($v);
                    if(!empty($label) && $k != 'create_date' && $k != 'update_date'){
                        $content .= "<div class='form-group'>";
                        $content .= "<label for='".$k."' class='control-label'>$label</label>";
                        if($k == 'role'){
                          $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";
                          $content .= "<option value='2'>Project Leader</option>";
                          $content .= "<option value='3'>Project Member</option>";
                          $content .= "</select>";
                        }else{
                           if($type == 'textarea'){
                             $content .= "<textarea name='".$k."' id='".$k."' class='form-control required' placeholder='".$placeholder."'></textarea>";
                            }else{
                             $content .= "<input type=".$type." name='".$k."' class='form-control required'  id='".$k."' placeholder='".$placeholder."'>";
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



    function manageTable($fields = array(), $tbl_name='' , $data = array(), $list_users = array() , $empty_projects = array() , $cur_page='' ){
 
        $get = $_GET;
        $display = 'none';
        $message = '';
         $lists = json_decode($list_users,'true');
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
        $content .= "<div id = 'modal'><button id='create' class='btn btn-block btn-primary fifty'><i class='fa fa-plus'></i> Create</button></div>";
        $content .= "<table id='".$tbl_name."' name='". $tbl_name."' class='table table-bordered table-striped'>
                    <thead><tr>";

    //echo "<pre>",print_r($fields),"</pre>";
            foreach($fields as $k=>$v){
              extract($v);
              if(!empty($label)){
                $content .= "<th>$label</th>";

              }

            }             
        $content .= "<th width='12%'></th>";

            $content .= '</tr></thead>';
            $content .= '<tbody>';
    //echo "<pre>",print_r($data),"</pre>";die();

         foreach($data as $k=>$v){          
            $content .= "<tr ref= ".$k .">";
              foreach($fields as $kf=>$vf){
                extract($vf);

                if(!empty($label)){
        
                  if($kf != 'users'){
                    $content .= "<td name='$kf'>".ucwords($v[$kf])."</td>";
                  }else{
                  //  echo"<pre>",print_r($users),"</pre>";
                      $members = '<p>Project Members:</p>';
                       $leaders = '<p>Project Leaders:</p>';
                       $users = $v[$kf];
                    if(isset($users) && !empty($users)){
                      foreach($users as $mems){
                        extract($mems);
                        if($user_role == 'Project Member'){
                          $members .= "<p> - $name</p>";
                        }else{
                          $leaders .= "<p> - $name</p>";
                        }

                      }
                     //  $content .= "<input type='hidden' name='assigned' value=".json_encode($v[$kf]).">";

                    }
                    $content .= "<td name='$kf'>$leaders $members<input type='hidden' name='assigned' value='".json_encode($v[$kf])."'></td>";

                  }

                }


              }
             // $content .= "<td name='name'>".ucwords($v->name)."</td>";
             // $content .= "<td>".ucwords($v->create_date)."</td>";
             $content .= "<td><button id='proj_man_edit' class='pads btn btn-block btn-success btn-sm'><span id='edit'><i class='fa fa-edit'></i></span></button></td>";

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
           $content .= "<div class='modal-body'>";
          if(!empty($empty_projects)){
             

              $content .= "<form name='form_modal' method='POST' action= '".base_url()."manage/proj_manage_add'>";
                   $content .= "<div class='error' style='display:none'></div>";


             
                    $content .= "<div class='form-group'>";
                    $content .= "<label for='Project' class='control-label'>Project Name</label>";
                      
                      $content .= "<select name='project_id' class='form-control required' id='project_id'  style='width:50%;'>";
                      foreach($empty_projects as $pr){
                      $content .= "<option value='".$pr->id."'>".$pr->name."</option>";
                      }

                      $content .= "</select>";
                      $content .= "</div>";
                     $content .= "<div class='form-group'>";
                     $content .= "<label for='Users' class='control-label'>Personnel</label>";
                     $content .= "<select name='user' class='form-control required' id='user'  style='width:50%;'>";

                                foreach($lists as $user){
                            
                                  $role = ($user['role'] == '2') ? 'Leader' : 'Member';
                                  $content .= "<option value=".$user['id']." role=".$user['role'].">$role : ".$user['name']."</option>";
                                }
                              $content .= "</select>";
                              $content .= "<button type='button' class='btn-primary' id='add_personnel'>add</button>";

                    $content .= "</div>";
                    $content .= "<div class='error' style='display:none;'></div>";
                    

                $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";
                $content .= "<input type='hidden' class='form-control' name='process' value='".$tbl_name."' >";
               
                $content .='</form>';
                $content .='</div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="btnprojadd" class="btn btn-primary btnsave">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>';

         }else{
            $content .= "<p>Projects were all managed</p>";
            $content .='</div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>';
         }

            
               
        $content .= '<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4></h4>
                      </div>';
             $content .= "<div class='modal-body'><form name='form_edit_modal' method='POST' action= '".base_url()."manage/proj_manage_update'>";
                   $content .= "<div class='error' style='display:none'></div>";

                     foreach($fields as $k=>$v){
                        extract($v);
                        if(!empty($label) && $k != 'create_date'){
                            $content .= "<div class='form-group'>";
                            $content .= "<label for='".$k."' class='control-label'>$label</label>";
                            if($k == 'users'){
                              $content .= "<select  name='user' class='form-control required' id='".$k."'>";

                              // $content .= "<option value='2'>Project Leader</option>";
                              // $content .= "<option value='3'>Project Member</option>";
                                foreach($lists as $user){
                                //  echo $user['id'];
                                  //                          echo"<pre>",print_r($user['id']),"</pre>";die();

                                  $role = ($user['role'] == '2') ? 'Leader' : 'Member';
                                  $content .= "<option value=".$user['id']." role=".$user['role'].">$role : ".$user['name']."</option>";
                                }
                              $content .= "</select>";
                              $content .= "<button type='button' class='btn-primary' id='add_personnel'>add</button>";

                            }else{
                              $content .= "<input type=".$type." name='".$k."' class='form-control required' id='".$k."' readonly>";
                            }                        
                            $content .= "</div>";

                        }

                     }       
                    $content .= "<div class='error' style='display:none;'></div>";


                    $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";
                    $content .= "<input type='hidden' class='form-control' name='process' value='".$tbl_name."' >"; 
                    $content .= "<input type='hidden' class='form-control' name='project_id' value='' >";

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

  function add_budget_form($response, $sponsors,$cur_page){
    $get = $_GET;
    $display = 'none';
    $message = '';
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
    $content = "<div class='row'>";
    $content .= "<div class='col-md-6'>";

    $content .= "<div class='box box-info'>";
    $content .= "<div class='box-header with-border'>
                  <h3 class='box-title'>Add Budget Line</h3>
                </div>";
    $content .= "<div class='success' style='display:$display'>$message</div>";

    $content .= "<form name='add_budget' method='POST'  action='add_budget_db' ";
    $content .= "<div class='box-body'>";

        $content .= "<div class='form-group'>";
        $content .= "<label for='project name' class='control-label'>Project Name: </label>";
        $content .= "<select name='project_id' class='form-control' required>";
        $content .= "<option value=''></option>";
        foreach($response as $rk=>$rv){
              //  echo "<pre>",print_r($rv),"</pre>";die();

          $content .= "<option value=".$rv['project_id']." ref='".json_encode($rv['users'])."'>".$rv['project_name']."</option>";
        }
        $content .= "</select>";
        $content .= "</div>";

      $content .= "<div class='form-group'>";
        $content .= "<label for='project leader' class='control-label'>Project Leader: </label>";
        $content .= "<select name='project_leader' class='form-control' required>";

        // foreach($leaders as $lk=>$lv){
        //   $content .= "<option value=".$lv->id.">".$lv->name."</option>";


        // }
        $content .= "</select>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='project leader' class='control-label'>Project Fund: </label>";
        $content .= "<select name='sponsor_id' class='form-control' required>";

        foreach($sponsors as $sk=>$sv){
          $content .= "<option value=".$sv->id.">".$sv->name."</option>";
        }
        $content .= "</select></div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='Line Item' class='control-label'>Line Item: </label>";
        $content .= "<input type='text' name='line_item' value='' class='form-control' placeholder='Food Allowance, Transportation , etc.' required>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='cost' class='control-label'>Budget Top up: </label>";
        $content .= "<input type='number' step='any' name='cost' value='' class='form-control' required>";
        $content .= "</div>";

        $content .= "<div class='form-group'>";
        $content .= "<input type='submit' class='btn btn-primary' name='submit' value='Submit'>";
        $content .= "</div>";
    $content .= "</div>";
    $content .= "</form>";
 $content .= "</div>";
    $content .= "</div>";
    return $content;

  }

  function request_budget_form($response,$projects, $sponsors, $line_item,$cur_page){
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
                  <h3 class='box-title'>Request Budget Line</h3>
                </div>";
    $content .= "<div class='success' style='display:$display'>$message</div>";
    $content .= "<div class='error' style='display:none'></div>";

    $content .= "<form name='request_budget' method='POST'  action='request_budget_db' ";
    $content .= "<div class='box-body'>";

        $content .= "<div class='form-group'>";
        $content .= "<label for='project name' class='control-label'>Project Name: </label>";
        $content .= "<select name='b_project_id' class='form-control' required>";
        $content .= "<option value=''></option>";
        foreach($projects as $rk=>$rv){
              //  echo "<pre>",print_r($rv),"</pre>";die();

          $content .= "<option value=".$rk." ref='".json_encode($sponsors[$rk])."'>".$rv."</option>";
        }
        $content .= "</select>";
        $content .= "</div>";

      $content .= "<div class='form-group'>";
        $content .= "<label for='project sponsor' class='control-label'>Project Sponsor: </label>";
        $content .= "<select name='b_project_sponsors' class='form-control' required>";
        $content .= "<option value=''></option>";

        // foreach($leaders as $lk=>$lv){
        //   $content .= "<option value=".$lv->id.">".$lv->name."</option>";


        // }
        $content .= "</select>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='line item' class='control-label'>Line Item: </label>";
        $content .= "<input name='list_line_item' class='form-control' type='hidden' value='".json_encode($line_item)."'>";

        $content .= "<select name='b_line_item' class='form-control' required>";
        $content .= "<option value=''></option>";

        // foreach($sponsors as $sk=>$sv){
        //   $content .= "<option value=".$sv->id.">".$sv->name."</option>";
        // }
        $content .= "</select></div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='Available Budget' class='control-label'>Available Budget: </label>";
        $content .= "<input type='text' name='available_budget' value='' class='form-control' readonly>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='cost' class='control-label'>Request Budget: </label>";
        $content .= "<input type='number' step='any' name='cost' value='' class='form-control' required>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='remarks' class='control-label'>Remarks: </label>";
        $content .= "<textarea step='any' name='remarks' value='' class='form-control' ></textarea>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='upload_document' class='control-label'>Upload Document: </label>";
        $content .= "<input type='file' name='file[]' value='' class='form-control' >";
        $content .= "</div>";


        $content .= "<div class='form-group'>";
        $content .= "<input type='submit' class='btn btn-primary' name='request_budget_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</form>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

    function request_budget_form2($response,$projects, $sponsors, $line_item,$cur_page){
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
       $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='error' style='display:none'></div>";

      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";

    $content .= "<table name='request_budget'  class='table table-bordered table-striped'>";
    $content .= "<thead>
                      <tr>
                        <th width='15%'>Project Name</th>
                        <th width='15%'>Project Sponsor</th>
                        <th width='15%'>Line Item</th>
                        <th width='10%'>Available Budget</th>
                        <th width='10%' >Request Budget</th>
                        <th width='15%'>Remarks</th>
                        <th width='10%'>Upload Document</th>
                        <th width='10%'></th>

                      </tr>
                   </thead>";
    $content .= "<tbody>";
    $content .= "<tr>";

    
       $content .= "<td>";
          $content .= "<select name='b_project_id' class='form-control' required>";
          $content .= "<option value=''></option>";
          foreach($projects as $rk=>$rv){
                //  echo "<pre>",print_r($rv),"</pre>";die();

            $content .= "<option value=".$rk." ref='".json_encode($sponsors[$rk])."'>".$rv."</option>";
          }
          $content .= "</select>";  
        $content .= "</td>";


        $content .= "<td>";
          $content .= "<select name='b_project_sponsors' class='form-control' required>";
          $content .= "<option value=''></option>";
          $content .= "</select>";
        $content .= "</td>";
               



        $content .= "<td>";
         $content .= "<input name='list_line_item' class='form-control' type='hidden' value='".json_encode($line_item)."'>";

          $content .= "<select name='b_line_item' class='form-control' required>";
          $content .= "<option value=''></option>";
          $content .= "</select>";
        $content .= "</td>";

        $content .= "<td>";
          $content .= "<input type='text' name='available_budget' value='' class='form-control' readonly>";
       $content .= "</td>";

        $content .= "<td>";
          $content .= "<input type='number' step='any' name='cost' value='' class='form-control' required>";
        $content .= "</td>";
       
        $content .= "<td>";
          $content .= "<textarea step='any' name='remarks' value='' class='form-control' ></textarea>";
        $content .= "</td>";

        $content .= "<td>";
          $content .= "<input type='file' step='any' name='file[]' value='' class='form-control' required>";
        $content .= "</td>";
       $content .= "<td>";
          $content .= "<input type='button' step='any' name='add_tr' value='+' class='btn btn-success' >";
        $content .= "</td>";
       
        $content .= "</div>";
        $content .= "</tr>";

        $content .= "</tbody>";

        $content .= "</table>";
        $content .= "<div class='form-group'>";
        $content .= "<input type='submit' class='btn btn-primary' name='request_budget_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

   function manageRequestsTable($response,$cur_page){
      $get = $_GET;
      $display = 'none';
      $message = '';
      if(isset($get) && !empty($get)){
        extract($get);
        if(isset($s) && $s == '1'){
          $display = 'block';
          $message = 'Successfully approved.';
        }else if(isset($s) && $s == '2'){
          $display = 'block';
          $message = 'Successfully rejected.';
        }else{
          $display = 'none';
          $message = '';
        }
      }
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";
      $content .= "<table id='budget_requests' name='budget_requests' class='table table-bordered table-striped'>";
      $content .= "<thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Sponsor</th>
                        <th>Project Leader</th>
                        <th>Line Item</th>
                        <th>Request</th>
                        <th>Remarks</th>
                        <th>Date Requested</th>
                        <th></th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->sponsor_name."</td>";
                   $content .= "<td>".$v->name."</td>";
                   $content .= "<td>".$v->line_item."</td>";
                   $content .= "<td width='8%'>".$v->cost."</td>";
                  $content .= "<td>".$v->remarks."</td>";
                   $content .= "<td>".$v->create_date."</td>";
                   if($v->is_granted == '0'){
                      $content .= "<td><button class='btn btn-block btn-info' ref=".$v->id." id='budget_approve'>Approved</button><button class='btn btn-block btn-danger' ref=".$v->id." id='budget_reject'>Reject</button></td>";
                   }elseif($v->is_granted == '1'){
                      $content .= "<td>Approved</td>";
                   }else{
                     $content .= "<td>Rejected</td>";
                   }
                   $content .= "</tr>";
              }

      $content .= "<tbody>";
      $content .= "</table>";

      $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

      $content .= "</div>";
      $content .= "</div>";


      $content .= "</div>";
      $content .= "</div>";
      return $content;
  }

   function manageProjectsTable($response,$cur_page){
      $get = $_GET;
      $display = 'none';
      $message = '';

      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";
      $content .= "<table id='budget_requests' name='budget_requests' class='table table-bordered table-striped'>";
      $content .= "<thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Role</th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->role_name."</td>";              
                   $content .= "</tr>";
              }

      $content .= "<tbody>";
      $content .= "</table>";

      $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

      $content .= "</div>";
      $content .= "</div>";


      $content .= "</div>";
      $content .= "</div>";
      return $content;
  }

  //Budget History Table
     function budgetHistoryTable($response,$cur_page){
      $get = $_GET;
      $display = 'none';
      $message = '';
      if(isset($get) && !empty($get)){
        extract($get);
        if(isset($s) && $s == '1'){
          $display = 'block';
          $message = 'Successfully approved.';
        }else if(isset($s) && $s == '2'){
          $display = 'block';
          $message = 'Successfully rejected.';
        }else{
          $display = 'none';
          $message = '';
        }
      }
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";
      $content .= "<table id='budget_requests' name='budget_requests' class='table table-bordered table-striped'>";
      $content .= "<thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Sponsor</th>
                        <th>Line Item</th>
                        <th>Request</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->sponsor_name."</td>";
                   $content .= "<td>".$v->line_item."</td>";
                   $content .= "<td width='8%'>".$v->cost."</td>";
                   $content .= "<td>".$v->create_date."</td>";
                   if($v->is_granted == '0'){
                      $content .= "<td>Pending</td>";
                   }elseif($v->is_granted == '1'){
                      $content .= "<td>Approved</td>";
                   }else{
                     $content .= "<td>Rejected</td>";
                   }
                   $content .= "</tr>";
              }

      $content .= "<tbody>";
      $content .= "</table>";

      $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

      $content .= "</div>";
      $content .= "</div>";


      $content .= "</div>";
      $content .= "</div>";
      return $content;
  }

  //Available Budget Table
     function availableBudgetTable($response,$cur_page){
      $get = $_GET;
      $display = 'none';
      $message = '';
      if(isset($get) && !empty($get)){
        extract($get);
        if(isset($s) && $s == '1'){
          $display = 'block';
          $message = 'Successfully approved.';
        }else if(isset($s) && $s == '2'){
          $display = 'block';
          $message = 'Successfully rejected.';
        }else{
          $display = 'none';
          $message = '';
        }
      }
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";
      $content .= "<table id='budget_requests' name='budget_requests' class='table table-bordered table-striped'>";
      $content .= "<thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Sponsor</th>
                        <th>Line Item</th>
                        <th>Available Budget</th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

 
              foreach($response as $k=>$v){
                   //   echo "<pre>",print_r($v),"</pre>";die();

                   $content .= "<tr>";
                   $content .= "<td>".$v['project_name']."</td>";
                   $content .= "<td>".$v['sponsor_name']."</td>";
                   $content .= "<td>".$v['line_item']."</td>";
                   $content .= "<td width='8%'> $ ".$v['balance']."</td>";
                   $content .= "</tr>";
              }

      $content .= "<tbody>";
      $content .= "</table>";

      $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

      $content .= "</div>";
      $content .= "</div>";


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


        $content .= "<div class='form-group'>";
        $content .= "<input type='hidden' class='' name='pwd' value='".$response->password."'>";
        $content .= "<input type='hidden' class='' name='cur_page' value='".$cur_page."'>";
        $content .= "<input type='submit' class='btn btn-primary' name='settings_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</form>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

  //Transaction Logs Table
   function transactionLogsTable($response,$cur_page){
      $get = $_GET;
      $display = 'none';
      $message = '';
      if(isset($get) && !empty($get)){
        extract($get);
        if(isset($s) && $s == '1'){
          $display = 'block';
          $message = 'Successfully approved.';
        }else if(isset($s) && $s == '2'){
          $display = 'block';
          $message = 'Successfully rejected.';
        }else{
          $display = 'none';
          $message = '';
        }
      }
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='row'>";
      $content .= "<div class='col-sm-12'>";
      $content .= "<table id='budget_requests' name='budget_requests' class='table table-bordered table-striped'>";
      $content .= "<thead>
                      <tr>
                        <th>Project Name</th>
                        <th>Sponsor</th>
                        <th>Line Item</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->sponsor_name."</td>";
                   $content .= "<td>".$v->line_item."</td>";
                   $content .= "<td width='8%'>".$v->cost."</td>";
                   $content .= "<td>".$v->type."</td>";
                   $content .= "<td>".$v->trans_date."</td>";
                   $content .= "</tr>";
              }

      $content .= "<tbody>";
      $content .= "</table>";

      $content .= "<input type='hidden' class='form-control' name='current_page' value='".$cur_page."' >";

      $content .= "</div>";
      $content .= "</div>";


      $content .= "</div>";
      $content .= "</div>";
      return $content;
  }

  function deduct_budget_form($response,$projects, $sponsors, $line_item,$cur_page){
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
                  <h3 class='box-title'>Deduct on Budget Line</h3>
                </div>";
    $content .= "<div class='success' style='display:$display'>$message</div>";
    $content .= "<div class='error' style='display:none'></div>";

    $content .= "<form name='request_budget' method='POST'  action='request_budget_db' ";
    $content .= "<div class='box-body'>";

        $content .= "<div class='form-group'>";
        $content .= "<label for='project name' class='control-label'>Project Name: </label>";
        $content .= "<select name='b_project_id' class='form-control' required>";
        $content .= "<option value=''></option>";
        foreach($projects as $rk=>$rv){
              //  echo "<pre>",print_r($rv),"</pre>";die();

          $content .= "<option value=".$rk." ref='".json_encode($sponsors[$rk])."'>".$rv."</option>";
        }
        $content .= "</select>";
        $content .= "</div>";

      $content .= "<div class='form-group'>";
        $content .= "<label for='project sponsor' class='control-label'>Project Sponsor: </label>";
        $content .= "<select name='b_project_sponsors' class='form-control' required>";
        $content .= "<option value=''></option>";

        // foreach($leaders as $lk=>$lv){
        //   $content .= "<option value=".$lv->id.">".$lv->name."</option>";


        // }
        $content .= "</select>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='line item' class='control-label'>Line Item: </label>";
        $content .= "<input name='list_line_item' class='form-control' type='hidden' value='".json_encode($line_item)."'>";

        $content .= "<select name='b_line_item' class='form-control' required>";
        $content .= "<option value=''></option>";

        // foreach($sponsors as $sk=>$sv){
        //   $content .= "<option value=".$sv->id.">".$sv->name."</option>";
        // }
        $content .= "</select></div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='Available Budget' class='control-label'>Available Budget: </label>";
        $content .= "<input type='text' name='available_budget' value='' class='form-control' readonly>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='cost' class='control-label'>Deduct Budget: </label>";
        $content .= "<input type='number' step='any' name='cost' value='' class='form-control' required>";
        $content .= "</div>";
     


        $content .= "<div class='form-group'>";
        $content .= "<input type='submit' class='btn btn-primary' name='request_budget_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</form>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

    //Transaction Logs Table
   function createNewsFeed($response,$cur_page){
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


        $content .= "<div class='row'>";
        $content .= "<div class='col-sm-12'>";
        

        $content .=  "<ul id='mainNewsWidget'>";

        foreach($response as $val){
          $content .= " <li data-title='".$val->title."' data-date='12-2-2013'  data-image='images/img/1.jpg' >".$val->description."</li>";

        }

        // $content .= " <li data-title='Press on Read More to Open' data-date='12-2-2013'  data-image='images/img/1.jpg' >
        //         <li data-title='Links can be direct or as Read More buttons inside the News Reader' data-date='12-2-2013'  data-image='images/img/2.jpg'  data-link='http://google.com' data-link-type='readmore'>Links can be 2 types <strong>'readmore'</strong> links and <strong>'direct'</strong> links. <br/> The readmore type will add a Continue reading button at the end of the article however the direct type will open the article in a new tab (can be self).
        //         <li data-title='This item is an external link' data-date='12-2-2013'  data-image='images/img/2.jpg'  data-link='http://google.com' >When this is pressed, the user will be redirected to a link predefined. You can set the target.</li>
        //          <li data-title='Custome Link Text, hover when chosen to check.' data-date='12-2-2013'  data-link-text='View ' data-title-in-link='after'>
        //               <div class='cssCustomization'>
        //                   <h3>You can add custom link text to any specific item.</h3> 
        //                     You can also choose to show the title or not, and where.<br/><br/>
        //                     Add to any news item the following code and viola!: <br/><br/>
        //                     <pre>data-link-text='CUSTOM LINK TEXT!' <br/>data-title-in-link='none'</pre><br/>
        //                  <p><span>data-title-in-link</span>: Control whether the title is included in the custom link text. 
        //                   Values: <span>'before'</span>, <span>'after'</span> or <span>'none'</span></p>
        //                    </div>
                                
        //             </li>
                
                
                
        //         <li data-title='8 Different Arrow Layouts' data-date='12-2-2013' >The plugin includes 8 different Arrow layouts including: <ul style='margin-left:290px; list-style:square'><li>left </li><li>right </li><li>sides </li><li>top-left </li><li>top-right </li><li>bottom-left </li><li>bottom-right </li><li>top/bottom </li></ul><br/><br/><img src='images/img/arrows.jpg' width='500'/> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</li>
                
                
                
        //         <li data-title='Supports RSS Feeds!' data-date='12-2-2013'>The plugin supports external/internal RSS Feeds. You can set the number of items to load. You must use a proxy to load external rss feeds, i included one. It is a basic one. Prefferable to use a more advanced and secure one. Google links to many.<br/><br/>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</li>
                
                
        //         <li data-title='Set Height or Set Number of News' data-date='10-1-2013'  data-image='images/img/5.jpg' >The plugin is smart. You can either set the height of the plugin and it will calcualte the number of news to initially display on screen. If you prefer to choose them yourself, you can! Simply set the numberOfNews option to any number and the plugin will calculate the new height! </li>
                
                
        //         <li data-title='Multiple Animations Included' data-date='17-11-2012'  data-image='images/img/girl.jpg' ><h2>You can customize all animations and control all their aspects.</h2><br/> You can choose how the widget appears, how the article shows, how it closes and how the items react to your hovers. You can also set teh animations duration, delay and easing. <br/><br/>I've included 10 animations: <ul style='list-style:square; margin:20px; margin-left:100px;'><li>left </li><li>right </li><li>sides </li><li>top-left </li><li>top-right </li><li>bottom-left </li><li>bottom-right </li><li>top/bottom </li></ul>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</li>
                
              
        //         <li data-title='Image with Overrided options' data-date='12-2-2013'  data-image='images/img/girl.jpg' data-image-cropping='false'>A Sexy Girl.</li>
                
                
                
        //         <li data-title='Title of the News' data-date='12-2-2013'  data-image='images/img/1.jpg' >Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</li>
                
                
        //         <li data-title='Easy Styling using Css.' data-date='12-2-2013'  data-image='images/img/2.jpg' >You can dramatically change everything using css. You can edit the sizes, colors,  animtions and the whole feel. You can also add custom style to the News Readers. All documented.<br/><br/>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</li>
                
            
            
            
        //      </ul>";
        $content .= "</ul>";
        $content .= "</div>";
        $content .= "</div>";
      $content .= "</div>";
      $content .= "</div>";


      return $content;
  }
?>