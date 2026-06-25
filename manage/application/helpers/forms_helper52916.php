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

              }elseif($kf == 'sponsor_id'){
                 $sponsors = json_decode($ref,true);
                 $sname = $sponsors[$v->sponsor_id]['name'];
                 $content .= "<td name='$kf' ref='$v->sponsor_id'>".ucwords($sname)."</td>";

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
            }elseif($k == 'sponsor_id'){
                $sponsors = json_decode($ref,true);
                $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";
                $content .= "<option value=''></option>";
                if(!empty($sponsors)){
                  foreach($sponsors as $sk=>$sv){
                    $content .= "<option value='".$sv['id']."'>".$sv['name']."</option>";
                  }
                }

                $content .= "</select>";

                // echo "<pre>",print_r($sponsors),"</pre>";die();


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
                        }elseif($k == 'sponsor_id'){
                          $sponsors = json_decode($ref,true);
                          $content .= "<select type=".$type." name='".$k."' class='form-control required' id='".$k."'>";
                          $content .= "<option value=''></option>";
                          if(!empty($sponsors)){
                            foreach($sponsors as $sk=>$sv){
                              $content .= "<option value='".$sv['id']."'>".$sv['name']."</option>";
                            }
                          }

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


  function add_budget_form($response = array(), $sponsors = array(), $line_items=array(), $grants = array() ,$cur_page){
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
          $content .= "<option value='' ></option>";

        foreach($sponsors as $sk=>$sv){

          // print_r($sv);die();
          if(isset($grants[$sv->id])){
            $encode =  json_encode($grants[$sv->id]);
          }else{
            $encode =  json_encode(array());

          }
          $content .= "<option value='".$sv->id."' ref= '".$encode."'>".$sv->name."</option>";
        }
        $content .= "</select></div>";

         $content .= "<div class='form-group'>";
        $content .= "<label for='sponsor grant' class='control-label'>Grant Names: </label>";
        $content .= "<select name='grant_id' class='form-control' required>";

        $content .= "</select></div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='Line Item' class='control-label'>Line Item: </label>";
      //  $content .= "<input type='text' name='line_item' value='' class='form-control' placeholder='Food Allowance, Transportation , etc.' required>";
        $content .= "<select name='line_item' class='form-control' required>";
        $content .= "<option value=''></option>";
    //    echo "<pre>",print_r($line_items),"</pre>";die();
        foreach($line_items as $lk=>$lv){
               // echo "<pre>",print_r($lv),"</pre>";die();
          $content .= "<option value='".$lv->line_item."' >".$lv->line_item."</option>";
        }
        $content .= "</select>";
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='cost' class='control-label'>Budget Top up: </label>";
        $content .= "<input type='number' step='any' name='cost' value='' class='form-control' required>";
        $content .= "</div>";

        $content .= "<div class='form-group'>";
        $content .= "<label for='remarks' class='control-label'>Remarks: </label>";
        $content .= "<textarea name='remarks' value='' class='form-control' required></textarea>";
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

  function upload_document_form($id,$cur_page){
    $get = $_GET;
    $display = 'none';
    $message = '';
    if(isset($get) && !empty($get)){
      extract($get);
      if(isset($s) && $s == '1'){
        $display = 'block';
        $message = 'Successfully uploaded.';
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
                  <h3 class='box-title'>Upload Document</h3>
                </div>";
    $content .= "<div class='success' style='display:$display'>$message</div>";
    $content .= "<div class='error' style='display:none'></div>";

    $content .= "<form name='upload_document' method='POST'  action='upload_document_db' enctype='multipart/form-data'>";
    $content .= "<div class='box-body'>";

        $content .= "<div class='form-group docs'>";
        $content .= "<label for='upload_document' class='control-label'>Upload Document: </label>";
        $content .= "<input type='file' name='file[]' value='' class='form-control' required >";
        $content .= "<input type='hidden'  name='budget_request_id' value='".$id."' class='form-control' >";

        $content .= "</div>";

        $content .= "<div class='form-group'>";
          $content .= "<label for='upload_document' class='control-label'> </label>";
          $content .= "<button id='add_more' type='button' class='btn btn-warning'>Add More</button>";
        $content .= "</div>";


        $content .= "<div class='form-group'>";
        $content .= "<input type='submit' class='btn btn-primary' name='upload_document_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</form>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

    function request_budget_form2($response,$projects, $sponsors, $line_item, $grant_list= array(), $user_id = '', $cur_page){
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
                        <th width='12%'>Grant Names</th>
                        <th width='10%'>Line Item</th>
                        <th width='8%'>Available Budget</th>
                        <th width='8%' >Request Budget</th>
                        <th width='4%'>Reimbursement?</th>
                        <th width='15%'>Remarks</th>
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
        $content .= "<input name='grant_list' class='form-control' type='hidden' value='".json_encode($grant_list)."'>";
        $content .= "<select name='b_grant_id' class='form-control' required>";
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
          $content .= "<input type='checkbox' step='any' name='is_reimburse' value='1' >";
        $content .= "</td>";
       
        $content .= "<td>";
          $content .= "<form name='requests[]' >";
          $content .= "<input name='project_id' value='' type='hidden'>";
          $content .= "<input name='project_sponsor' value='' type='hidden'>";
          $content .= "<input name='line_item' value='' type='hidden'>";
          $content .= "<input name='cost_r' value='' type='hidden'>";
          $content .= "<input name='grant_id' value='' type='hidden'>";
          $content .= "<input name='is_reimbursement' value='' type='hidden'>";


          $content .= "<textarea step='any' name='remarks' value='' class='form-control' ></textarea>";
          $content .= "</form>";
        $content .= "</td>";

       $content .= "<td>";
          $content .= "<input type='button' step='any' name='add_tr' value='+' class='btn btn-success' >";
        $content .= "</td>";
       
        $content .= "</div>";
        $content .= "</tr>";

        $content .= "</tbody>";

        $content .= "</table>";
        $content .= "<div class='form-group'>";
        $content .= "<input type='hidden' name='user_id' value='".$user_id."'>";
        $content .= "<input type='submit' class='btn btn-primary' name='request_budget_submit' value='Submit'>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</div>";
    
        return $content;
  }

   function manageRequestsTable($response,$documents,$cur_page){
      $get = $_GET;
      $display = 'none';
      $display_err = 'none';
      $message = '';
      if(isset($get) && !empty($get)){
        extract($get);
        if(isset($s) && $s == '1'){
          $display = 'block';
          $message = 'Successfully approved.';
        }else if(isset($s) && $s == '2'){
          $display = 'block';
          $message = 'Successfully rejected.';
        }else if(isset($s) && $s == '3'){
          $display = 'block';
          $message = 'Successfully requested for more info.';
        }else{
          $display = 'none';
          $message = '';
        }

         if(isset($e) && $e == '1'){
            $display_err = 'block';
         }else{
          $display_err = 'none';
        }
      }
      $content = "<div class='box'>";
      $content .= "<div class='box-body'>";


      $content .= "<div class='success' style='display:$display'>$message</div>";
      $content .= "<div class='error' style='display:$display_err'>The requested budget has insufficient funds and therefore rejected.</div>";

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
                        <th>Supporting Docs</th>
                        <th></th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){

                  if($v->is_reimbursement == '1'){
                    $v->remarks = 'Reimbursement - '.$v->remarks;
                  }
                   $attached = '';
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->sponsor_name."</td>";
                   $content .= "<td>".$v->name."</td>";
                   $content .= "<td>".$v->line_item."</td>";
                   $content .= "<td width='8%'>".$v->cost."</td>";
                   $content .= "<td>".$v->remarks."</td>";
                   $content .= "<td>".$v->create_date."</td>";

                   if(isset($documents[$v->id]) && !empty($documents[$v->id])){
                      foreach($documents[$v->id] as $dk => $dv){
                        $ext = explode("/",$dv->filename);
                        $filename = end($ext);
                        $attached .= "<p><a href='".base_url()."support_documents/".$dv->filename."' download>$filename</a></p>";
                      }
                   }

                   $content .= "<td>".$attached."</td>";

                   if($v->is_granted == '0'){
                      $content .= "<td><button class='btn btn-block btn-info' ref=".$v->id." id='budget_approve'>Approved</button><button class='btn btn-block btn-danger' ref=".$v->id." id='budget_reject'>Reject</button><button class='btn btn-block btn-warning' ref=".$v->id." id='budget_request_info'>Request Info</button></td>";
                   }elseif($v->is_granted == '1'){
                      $content .= "<td>Approved</td>";
                   }elseif($v->is_granted == '3'){
                     $content .= "<td>Insufficient funds</td>";
                   }elseif($v->is_granted == '4'){
                     $content .= "<td>Waiting for more info</td>";
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
     function budgetHistoryTable($response,$documents,$cur_page){
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
        }else if(isset($s) && $s == '3'){
          $display = 'block';
          $message = 'Successfully requested for more info.';
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
                        <th>Attachments</th>
                        <th width='10%'>Upload Document</th>

                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $attached = '';
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
                   }elseif($v->is_granted == '3'){
                     $content .= "<td>Insufficient funds</td>";
                   }elseif($v->is_granted == '4'){
                     $content .= "<td>Requesting for more info. Email at ".EMAIL_INFO."</td>";
                   }else{
                     $content .= "<td>Rejected</td>";
                   }

                    $content .= "<td>";

                   if(isset($documents[$v->id]) && !empty($documents[$v->id])){
                      $content .= '<table>';
                      foreach($documents[$v->id] as $dk => $dv){
                        $ext = explode("/",$dv->filename);
                        $filename = end($ext);
                        $content .= "<tr ref='".$dv->id."'><td width='80%'><a href='".base_url()."support_documents/".$dv->filename."' download>$filename</a></td><td width='20%'><button type='button' id='rem_attach' ref='".$dv->id."' path='".$dv->filename."'><i class='fa fa-remove'></i></button></td></tr>";
                      }
                        $content .= '</table>';

                   }
                   $content .= "</td>";

                   $content .= "<td><a href='upload_document?ref=".$v->id."'><button class='btn btn-primary fa arrow-up'><span class='fa-arrow-up'></span></button></a></td>";

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
                        <th>Remarks</th>
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
                   $content .= "<td>".$v->remarks."</td>";
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

  function deduct_budget_form($response,$projects, $sponsors, $project_leader, $line_item_l, $line_item, $grant_list, $user_id ,$cur_page){
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

    $content .= "<form name='request_budget' method='POST'  action='deduct_budget_db' ";
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
        $content .= "<label for='sponsor grant' class='control-label'>Grant Names: </label>";
        $content .= "<input name='grant_list' class='form-control' type='hidden' value='".json_encode($grant_list)."'>";
        $content .= "<select name='b_grant_id' class='form-control' required>";
        $content .= "<option value=''></option>";

        $content .= "</select></div>";

      $content .= "<div class='form-group'>";
        $content .= "<label for='project leader' class='control-label'>Project Leader: </label>";
        $content .= "<input name='project_leader_list' class='form-control' type='hidden' value='".json_encode($project_leader)."'>";

        $content .= "<select name='b_project_leader' class='form-control' required>";
        $content .= "<option value=''></option>";

        // foreach($leaders as $lk=>$lv){
        //   $content .= "<option value=".$lv->id.">".$lv->name."</option>";


        // }
        $content .= "</select>";
        
        $content .= "</div>";
        $content .= "<div class='form-group'>";
        $content .= "<label for='line item' class='control-label'>Line Item: </label>";
        $content .= "<input name='list_line_item' class='form-control' type='hidden' value='".json_encode($line_item_l)."'>";

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
        $content .= "<label for='cost' class='control-label'>Remarks: </label>";
        $content .= "<textarea name='remarks' value='' class='form-control' required></textarea>";
        $content .= "</div>";

     


        $content .= "<div class='form-group'>";
        $content .= "<input type='hidden' name='user_id' value='".$user_id."' class='form-control'>";

        $content .= "<input type='submit' class='btn btn-primary' name='deduct_budget_submit' value='Submit'>";
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
        $content .= "<h3 class='announce'>Announcements</h3>";

        $content .=  "<ul id='mainNewsWidget'>";

        foreach($response as $val){
          if(!empty($val->update_date)){
            $date = date('j-n-Y',strtotime($val->update_date . ' - 1 month'));
          }else{
             $date = date('j-n-Y',strtotime($val->create_date. ' - 1 month'));
          }

          $content .= " <li data-title='".$val->title."' data-date='".$date."'  data-image='images/img/1.jpg' >".$val->description."</li>";
        //  $content .= " <li data-title='".$val->title."' data-date='".$date."'  data-image='images/img/1.jpg' >".$val->description."</li>";

        }

        $content .= "</ul>";
        $content .= "</div>";
        $content .= "</div>";
      $content .= "</div>";
      $content .= "</div>";


      return $content;
  }

   //All Transaction Logs Table
   function allTransactionLogsTable($response,$cur_page){
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
                        <th>Grant Name </th>
                        <th>Line Item</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Remarks</th>
                        <th>Date</th>
                      </tr>
                   </thead>";
      $content .= "<tbody>";

              foreach($response as $k=>$v){
                   $content .= "<tr>";
                   $content .= "<td>".$v->project_name."</td>";
                   $content .= "<td>".$v->sponsor_name."</td>";
                   $content .= "<td>".$v->project_leader_name."</td>";
                   $content .= "<td>".$v->grant_name."</td>";
                   $content .= "<td>".$v->line_item."</td>";
                   $content .= "<td width='8%'>".$v->cost."</td>";
                   $content .= "<td>".$v->type."</td>";
                   $content .= "<td>".$v->remarks."</td>";
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

?>