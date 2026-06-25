<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

   require_once FCPATH."../phpmailer/Exception.php";

      require_once  FCPATH."../phpmailer/PHPMailer.php";
       require_once  FCPATH."../phpmailer/SMTP.php";
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {



	/**

	 * Index Page for this controller.

	 *

	 * Maps to the following URL

	 * 		http://example.com/index.php/welcome

	 *	- or -

	 * 		http://example.com/index.php/welcome/index

	 *	- or -

	 * Since this controller is set as the default controller in

	 * config/routes.php, it's displayed at http://example.com/

	 *

	 * So any other public methods not prefixed with an underscore will

	 * map to /index.php/welcome/<method_name>

	 * @see https://codeigniter.com/user_guide/general/urls.html

	 */



	function __construct()

    {

        parent::__construct();

        $this->load->model('users_model','umodel');

       

    }



	public function index()

	{



		$this->login();

	}



	public function login()

	{



		if($this->check_token()){

			// echo "aa";die();

			redirect('signatures','refresh');



		}

		$data['logged_in'] = false;

		$this->load->view('header');

		$this->load->view('login');

		$this->load->view('sidenav', $data);

		$this->load->view('footer');

	}







	public function manage_profile(){
		// echo "<pre>",print_r($this->input->post()),"</pre>";die();
		if(!$this->check_token()){

			//header('Location: login');//die();

			redirect('login','refresh');

		}





		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = '';

 		$data['current_page'] = 'manage_profile';
 		$data['content'] = '';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');




		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('account', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}



	public function view_job_details($ref=""){
		if(!empty($ref)){
			$ref_decode = base64_decode($ref);
			$details = $this->umodel->get_where('tbl_job_applications',array('id'=>$ref_decode));
			// echo "<pre>",print_r($details),"</pre>";die();
			if(!empty($details)){
				if(!$this->check_token()){

					//header('Location: login');//die();

					redirect('login','refresh');

				}





				$data['logged_in'] = true;

		 		$data['user'] = ucwords($this->session->userdata('name'));
		 		$data['page'] = '';
		 		$data['ref'] = base64_encode($details[0]->id);
		 		$data['current_page'] = 'manage_profile';
		 		$data['content'] = '';
		 		$data['details'] = $details[0];
		 		$nav = $this->side_nav();

		 		$data['nav'] = $nav;

		 		$role = $this->session->userdata('user_role');




				$this->load->view('header');

				$this->load->view('sidenav', $data);

				$this->load->view('job_details', $data);

				$this->load->view('footer');

			}else{
				redirect('/');
			}
		}
	}



	public function check_user()

	{

		

		$response = $this->umodel->check_user();

		// echo "<pre>",print_r($response),"</pre>";die();

		if($response){
			$role = $this->session->userdata('user_id');
			
			    redirect('signatures','refresh');
			

			// header('Location: users/smanage_profile');

		}else{

			redirect('login?e=1','refresh');

		}

	}

	public function  send_agreement_form(){
		$ref =  $this->input->post('ref');
		$ref_decode = base64_encode($ref);
		$details = $this->umodel->get_where('tbl_job_applications',array('id'=>$ref));
		if(!empty($details)){
			$email = $details[0]->email;
			$first_name =  ucwords($details[0]->first_name);
			$name = ucwords($details[0]->first_name." ".$details[0]->last_name);
			$unique_link = base_url().'../jo_form.php?ref='.$ref_decode;
			$subject = "Employment Agreement for ".$name;

			$message = "Hello ".$first_name.",";
			$message .= "<p>Congratulations!</p><br>";
			$message .= "<p>This email contains a link which will redirect you to the final step of onboarding. Please click this <a href='".$unique_link."'>link</a> to view and complete.</p>";

			$message .="<br><br>";

			$message .="Regards,<br>";
			$message .="Admin<br>";
			$message .="<p style='font-size:10px'>This is an automatically generated email, please do not reply to it. </p>";
			$this->send_system_email($email,$subject,$message);
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}

		// echo "<pre>",print_r($details),"</pre>";die();

	}

	public function  send_orientation_form(){
		$ref =  $this->input->post('ref');
		$ref_decode = base64_encode($ref);
		$details = $this->umodel->get_where('tbl_job_applications',array('id'=>$ref));
		if(!empty($details)){
			$email = $details[0]->email;
			$first_name =  ucwords($details[0]->first_name);
			$name = ucwords($details[0]->first_name." ".$details[0]->last_name);
			$ack_unique_link = base_url().'../pao_form.php?ref='.$ref_decode;
			$chk_unique_link = base_url().'../pchk_form.php?ref='.$ref_decode;
			$subject = "Orientation Acknowledgement for ".$name;

			$message = "Hello ".$first_name.",";
			$message .= "<p>This email contains a link which will redirect you to a form where you can sign the orientation acknowledgement. Please click this <a href='".$ack_unique_link."'>link</a> to view</p><br><br>";
			$message .= "<p>For orientation checklist form. Please click this <a href='".$chk_unique_link."'>link</a> to view</p>";
			$message .="<br><br>";

			$message .="Regards,<br>";
			$message .="Admin Staff";
			$this->send_system_email($email,$subject,$message);
			echo json_encode(array('success'=>true));
		}else{
			echo json_encode(array('success'=>false));
		}

		// echo "<pre>",print_r($details),"</pre>";die();

	}


	public function send_system_email($email="",$subject="",$message="")

	{
		$user_id = $this->session->userdata('user_id');

		try {

	    $mail = new PHPMailer(true);

	    //From email address and name
		$mail->IsSMTP();
		 // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//smtp_secure; 
		$mail->Host = SMTP_HOST;
		$mail->Port = SMTP_PORT;  
		$mail->Username = SMTP_USERNAME;  
		$mail->Password = SMTP_PASS;   
					
		$mail->addAddress($email);
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body = $message;
	    $mail->setFrom('noreply@hohcareers.com', 'Careers');
	
		// echo $email;die();

		$mail->send();
		 // $logs_arr = array('email_address'=>$email,'sent_by'=>$user_id,'subject'=>$subject,'message'=>$message,'status'=>'Sent');
		 // $this->db->insert('tbl_mail_logs',$post);
		} catch (Exception $e) {
		  echo $e->getMessage(); 
		   // $logs_arr = array('email_address'=>$email,'sent_by'=>$user_id,'subject'=>$subject,'message'=>$message,'status'=>'Unsent','status_msg'=> $e->getMessage());
		   // $this->db->insert('tbl_mail_logs',$post);
		}



	}


	public function mail_logs(){


		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Mail Logs';

 		$data['current_page'] = 'mail_logs';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');



 	 	$fields = array(	'id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 	 						'email_address'=>array('type'=>'text','placeholder'=>'Email','label' => 'Email'),
	 						'subject'=>array('type'=>'password','placeholder'=>'Subject','label' => 'Subject'),
	 	 					'message'=>array('type'=>'text','placeholder'=>'message','label' => 'Message'),
	 	 					'status'=>array('type'=>'email','placeholder'=>'Status','label' => 'Status'),
	 	 					'status_msg'=>array('type'=>'email','placeholder'=>'Status','label' => 'Status Info'),
 	 				
 					);

 		$table_name= 'mail_logs';

// echo $_GET['q'];die();



 		$filter = false;

 		if(isset($_GET['q'])) {

 			$response = $this->umodel->get_where('tbl_mail_logs',array('name'=>$this->input->get('q')));

 			$filter = true;

 		}else{

 			$response = $this->umodel->get('tbl_mail_logs');

 			

 		}

// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],$filter);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');


	}


	public function update_record()

	{

		$tbl = $this->input->post('process');		

		$cur_page = $this->input->post('current_page');	

		$id = $this->input->post('ref');	

		$post = $this->input->post();	

		

		unset($post['process']);

		unset($post['current_page']);

		// unset($post['ref']);

          if($tbl=='tbl_staff'){
          	// echo "<pre>",print_r($_FILES),"</pre>";

          	// die();
	     		// $id = $this->db->insert($tbl,array('staff_name'=>$post['staff_name']));
		    	$inserted_id = $this->db->insert_id();
		    	$file_name=NULL;
		    	if(!empty($_FILES['signature_path']['name'])){

		     	    $file = $_FILES['signature_path'];
					  $fileName = $_FILES['signature_path']['name'];
					  $fileTmpName = $_FILES['signature_path']['tmp_name'];

					  $fileSize = $_FILES['signature_path']['size'];
					  $fileError = $_FILES['signature_path']['error'];
					  $fileType = $_FILES['signature_path']['type'];

				 	 $file_name_with_extenstion = $file['name'];

						$extension = pathinfo($file_name_with_extenstion, PATHINFO_EXTENSION);

						$file = explode(".", $_FILES['signature_path']['name']);
						$file_ext = end($file);
						  $filename = str_replace(" ", "_", $_FILES['signature_path']['name']) ;

						  // echo $filename;die();
						$upload_name = "staff_".$id."_".$filename;//.time().".$extension";
						$file_name =    '../staff_signatures/'.$upload_name;//"profile" . $id . "." . $extension;// "profile" .pathinfo($file_name_with_extenstion, PATHINFO_FILENAME);
						// echo $upload_name." ".$file_name;die();
						$config['upload_path'] = FCPATH.'../staff_signatures/';
						// echo FCPATH.'staff_signatures/';die();
						// echo $config['upload_path'];die();
						$config['file_name'] = $upload_name;// "profile" . $id . "." . $extension;
						$config['allowed_types'] = '*';
						$config['overwrite'] = TRUE;
						// $config['max_size'] = 1024;
						// $config['max_width'] = 1024;
						// $config['max_height'] = 768;
			// echo "<pre>",print_r($config),"</pre>";die();
						$this->load->library('upload', $config);//Load the libary with the configuration

						if(!$this->upload->do_upload('signature_path')){
							$error = true;
							// echo $this->upload->display_errors();die();
						    // $error_msg  = $this->upload->display_errors();//validation error will be printed
						    // echo json_encode(array('success'=>false,'msg'=>'',));
						}
		    	}

		    	    if(!empty($file_name)){

						$send = array("signature_path"=>$file_name,'staff_name'=>$post['staff_name']); 
		    	    }else{
		    	    	$send = array('staff_name'=>$post['staff_name']); 
		    	    }
					$this->umodel->update($send,$post['ref'],'staff');
					if($tbl =='tbl_staff'){

						redirect(base_url().'staff?s=1','refresh');
					}else{

						redirect($cur_page.'?s=1','refresh');
					}

	     
		}elseif($tbl=='tbl_job_applications'){
          	// echo "<pre>",print_r($_FILES),"</pre>";

          	// die();
	     		// $id = $this->db->insert($tbl,array('staff_name'=>$post['staff_name']));
		    	$inserted_id = $this->db->insert_id();
		    	$file_name=NULL;
		    	if(!empty($_FILES['signature_path']['name'])){

		     	    $file = $_FILES['signature_path'];
					  $fileName = $_FILES['signature_path']['name'];
					  $fileTmpName = $_FILES['signature_path']['tmp_name'];

					  $fileSize = $_FILES['signature_path']['size'];
					  $fileError = $_FILES['signature_path']['error'];
					  $fileType = $_FILES['signature_path']['type'];

				 	 $file_name_with_extenstion = $file['name'];

						$extension = pathinfo($file_name_with_extenstion, PATHINFO_EXTENSION);

						$file = explode(".", $_FILES['signature_path']['name']);
						$file_ext = end($file);
						  $filename = str_replace(" ", "_", $_FILES['signature_path']['name']) ;

						  // echo $filename;die();
						$upload_name = "staff_".$id."_".$filename;//.time().".$extension";
						$file_name =    '../signatures/'.$upload_name;//"profile" . $id . "." . $extension;// "profile" .pathinfo($file_name_with_extenstion, PATHINFO_FILENAME);
						// echo $upload_name." ".$file_name;die();
						$config['upload_path'] = FCPATH.'../signatures/';
						// echo FCPATH.'staff_signatures/';die();
						// echo $config['upload_path'];die();
						$config['file_name'] = $upload_name;// "profile" . $id . "." . $extension;
						$config['allowed_types'] = '*';
						$config['overwrite'] = TRUE;
						// $config['max_size'] = 1024;
						// $config['max_width'] = 1024;
						// $config['max_height'] = 768;
			// echo "<pre>",print_r($config),"</pre>";die();
						$this->load->library('upload', $config);//Load the libary with the configuration

						if(!$this->upload->do_upload('signature_path')){
							$error = true;
							// echo $this->upload->display_errors();die();
						    // $error_msg  = $this->upload->display_errors();//validation error will be printed
						    // echo json_encode(array('success'=>false,'msg'=>'',));
						}
		    	}

		    	    if(!empty($file_name)){

						$send = array("signature_path"=>$file_name,'first_name'=>$post['first_name'],'last_name'=>$post['last_name'],'email'=>$post['email']); 
		    	    }else{
		    	    	$send = array('first_name'=>$post['first_name'],'last_name'=>$post['last_name'],'email'=>$post['email']); 
		    	    }
					$this->umodel->update($send,$post['ref'],'job_applications');
					if($tbl =='tbl_job_applications'){

						redirect(base_url().'signatures?s=1','refresh');
					}else{

						redirect($cur_page.'?s=1','refresh');
					}

	     
		}else{

		$response = $this->umodel->update($post,$id,$tbl);
		}
       




		if($response){

			redirect('users/'.$cur_page.'?s=2','refresh');

		}



	}





	public function remove()

	{	

		$tbl = $this->input->post('process');		

		$cur_page = $this->input->post('current_page');	

		$id = $this->input->post('ref');	

		// echo "<pre>",print_r($this->input->post()),"</pre>";die();
         if($tbl=='tbl_staff'){
			$send = array("status"=>'archived'); 
			$this->umodel->update($send,$id,'staff');
			// $this->db->delete($tbl , array('id' => $id)); 
         }
 if($tbl=='tbl_job_applications'){
 		$send = array("status"=>'archived'); 
			$this->umodel->update($send,$id,'job_applications');
 }
   if($tbl=='tbl_test_certificates'){
			// $send = array("status"=>'archived'); 
			// $this->umodel->update($send,$id,'staff');
			$this->db->delete($tbl , array('id' => $id)); 
         }
		// redirect('users/'.$cur_page.'?s=3','refresh');



		echo true;



	}



	



	public function check_token()

	{

		$user = $this->session->userdata('name');

		// var_dump($user);die();

		if(!empty($user)){

			return true;

		}else{

			return false;

		}



	}



	public function logout()

	{

		$this->session->sess_destroy();

		redirect('login','refresh');

	}



	public function side_nav(){

		$role = $this->session->userdata('user_id');
			// echo $role;die();
		$nav = array();




			$nav = array(

			


						 'Manage Job Applications' => array("icon"=> "fa fa-users" , "url" => "signatures"),
						 'Manage Staff' => array("icon"=> "fa fa-user" , "url" => "staff"),
						 'Manage Tests' => array("icon"=> "fa fa-book" , "url" => "certificates"),
						  'Manage Influenza Forms' => array("icon"=> "fa fa-book" , "url" => "influenza_forms"),
						  'Create Certificate' => array("icon"=> "fa fa-certificate" , "url" => "../certificates.php"),
						   'Staff Sign Link' => array("icon"=> "fa fa-edit" , "url" => "../staff_sign.php"),
						    'Employee Sign Link' => array("icon"=> "fa fa-edit" , "url" => "../employee_sign.php"),
 								'Influenza Sign Form Link' => array("icon"=> "fa fa-edit" , "url" => "../influenza_form.php"),
						 // 'Config'  => array("icon"=> "fa fa-gear" , "url" => "users/config"),

						 'Account Settings'  => array("icon"=> "fa fa-gear" , "url" => "users/settings")

			);


		return $nav;

	}





	public function counselors(){

		// if(!$this->check_token()){

		// 	//header('Location: login');//die();

		// 	redirect('b_login','refresh');

		// }

		// $role = $this->session->userdata('user_role');

 		// var_dump($data);

		// if($role !== '1'){

 	// 		show_404();

 	// 	} 



		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Counselors Management';

 		$data['current_page'] = 'counselors';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');



 	 	$fields = array(	'id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 	 		'username'=>array('type'=>'text','placeholder'=>'Username','label' => 'Username'),
 						'password'=>array('type'=>'password','placeholder'=>'Password','label' => 'Password'),
 	 					'name'=>array('type'=>'text','placeholder'=>'Name','label' => 'Name'),
 	 					'email'=>array('type'=>'email','placeholder'=>'Email','label' => 'Email'),
 	 					

 						// 'date_added'=> array('type'=>'date','placeholder'=>date('Y-m-d'),'label' => '', 'data-date-format'=>'yy-mm-dd' ),

 						// 'id'=>array('type'=>'hidden','placeholder'=>'id','label' => '')
 					);

 		$table_name= 'admin';

// echo $_GET['q'];die();



 		$filter = false;

 		if(isset($_GET['q'])) {

 			$response = $this->umodel->get_where('tbl_admin',array('name'=>$this->input->get('q')));

 			$filter = true;

 		}else{

 			$response = $this->umodel->get('tbl_admin');

 			

 		}

// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],$filter);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}

	public function signatures(){
			// echo "<pre>",print_r($_SESSION),"</pre>";die();
		if(!$this->check_token()){

			// header('Location: login');//die();

			redirect('login','refresh');

		}


		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Job Applications';

 		$data['current_page'] = 'signatures';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');
 		// $group_sheets = $this->umodel->get_group_sheet();
		// var_dump('loop');die();


 	 	$fields = array(	'id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 						'first_name'=>array('type'=>'text','placeholder'=>'Surname','label' => 'First Name'),
 						'last_name'=>array('type'=>'text','placeholder'=>'First Name','label' => 'Surname'),
 						'email'=>array('type'=>'text','placeholder'=>'Email Address','label' => 'Email Address'),
 						'position'=>array('type'=>'text','placeholder'=>'Position','label' => 'Position'),
 						 						

 						'pdf_file_path'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 1','label' => ''),
 						'signature_path'=>array('type'=>'file','placeholder'=>'Signature','label' => 'Signature'),
 						'create_date'=>array('type'=>'text','placeholder'=>'Date Submitted','label' => 'Date Submitted'),


 	 			 // 	 	'pdf_file2'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 2','label' => 'PDF Term 2'),
 	 			 // 	 	'signature_file'=>array('type'=>'signature_path','placeholder'=>'Signature File','label' => 'Signature'),

 						// 'date_added'=> array('type'=>'date','placeholder'=>date('Y-m-d'),'label' => '', 'data-date-format'=>'yy-mm-dd' ),

 						// 'id'=>array('type'=>'hidden','placeholder'=>'id','label' => '')
 					);

 		$table_name= 'tbl_job_applications';

// echo $_GET['q'];die();

// var_dump('test');die();

 		$filter = false;

 		// if(isset($_GET['q'])) {

 		// $response = $this->umodel->get_group_sheet();

 		// 	$filter = true;

 		// }else{
// 
 			$response = $this->umodel->get_where('tbl_job_applications',array('status'=>'active'));

 			

 		// }
 		if(!empty($response)){
 			foreach($response as $k_resp=>$resp){
 				if(!file_exists('../'.$resp->pdf_file_path)){
 						unset($response[$k_resp]);
 				}
 			}
 		}
// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],$filter);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}

	public function staff(){
			// echo "<pre>",print_r($_SESSION),"</pre>";die();
		if(!$this->check_token()){

			// header('Location: login');//die();

			redirect('login','refresh');

		}


		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Manage Staff';

 		$data['current_page'] = 'staff';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');
 		// $group_sheets = $this->umodel->get_group_sheet();
		// var_dump('loop');die();


 	 	$fields = array(	'staff_id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 						'staff_name'=>array('type'=>'text','placeholder'=>'Staff Name','label' => 'Staff Name'),
 						'signature_path'=>array('type'=>'file','placeholder'=>'Signature','label' => 'Signature File'),
 					

 						// 'pdf_file_path'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 1','label' => 'Job PDF Form'),
 						'date_created'=>array('type'=>'text','placeholder'=>'Date Added','label' => ''),


 	 			 // 	 	'pdf_file2'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 2','label' => 'PDF Term 2'),
 	 			 // 	 	'signature_file'=>array('type'=>'signature_path','placeholder'=>'Signature File','label' => 'Signature'),

 						// 'date_added'=> array('type'=>'date','placeholder'=>date('Y-m-d'),'label' => '', 'data-date-format'=>'yy-mm-dd' ),

 						// 'id'=>array('type'=>'hidden','placeholder'=>'id','label' => '')
 					);

 		$table_name= 'tbl_staff';

// echo $_GET['q'];die();

// var_dump('test');die();

 		$filter = false;

 		// if(isset($_GET['q'])) {

 		// $response = $this->umodel->get_group_sheet();

 		// 	$filter = true;

 		// }else{
// 
 			$response = $this->umodel->get_where('tbl_staff',array('status'=>'active'));

 			

 		// }

// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],$filter);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}
   
   public function certificates(){
			// echo "<pre>",print_r($_SESSION),"</pre>";die();
		if(!$this->check_token()){

			// header('Location: login');//die();

			redirect('login','refresh');

		}


		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Manage Certificates';

 		$data['current_page'] = 'certificates';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');
 		// $group_sheets = $this->umodel->get_group_sheet();
		// var_dump('loop');die();


 	 	$fields = array(	'id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 						'employee_name'=>array('type'=>'text','placeholder'=>'Employee Name','label' => 'Employee Name'),
 						// 'signature_path'=>array('type'=>'file','placeholder'=>'Signature','label' => 'Signature File'),
 					

 						// // 'pdf_file_path'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 1','label' => 'Job PDF Form'),
 						// 'date_created'=>array('type'=>'text','placeholder'=>'Date Added','label' => ''),


 	 			 // 	 	'pdf_file2'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 2','label' => 'PDF Term 2'),
 	 			 // 	 	'signature_file'=>array('type'=>'signature_path','placeholder'=>'Signature File','label' => 'Signature'),

 						// 'date_added'=> array('type'=>'date','placeholder'=>date('Y-m-d'),'label' => '', 'data-date-format'=>'yy-mm-dd' ),

 						// 'id'=>array('type'=>'hidden','placeholder'=>'id','label' => '')
 					);

 		$table_name= 'tbl_test_certificates';

// echo $_GET['q'];die();

// var_dump('test');die();

 		$filter = false;

 		// if(isset($_GET['q'])) {

 		$response = $this->umodel->get_certificates();

 		// 	$filter = true;

 		// }else{
// 
 			// $response = $this->umodel->get_where('tbl_staff',array('status'=>'active'));

 			

 		// }

// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],$filter);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}

	 public function influenza_forms(){
			// echo "<pre>",print_r($_SESSION),"</pre>";die();
		if(!$this->check_token()){

			// header('Location: login');//die();

			redirect('login','refresh');

		}


		$data['logged_in'] = true;

 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Manage Influenza Fprms';

 		$data['current_page'] = 'influenza_forms';

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$role = $this->session->userdata('user_role');
 		// $group_sheets = $this->umodel->get_group_sheet();
		// var_dump('loop');die();


 	 	$fields = array(	'id'=>array('type'=>'text','placeholder'=>'ID','label' => 'Control ID'),

 						'name'=>array('type'=>'text','placeholder'=>'Employee Name','label' => 'Employee Name'),
 						'date_signed'=>array('type'=>'text','placeholder'=>'Date Signed','label' => 'Date Signed'),
 						'accept'=>array('type'=>'condition','placeholder'=>'Agree to Vaccinate','label' => 'Agree to Vaccinate'),
 						'reason'=>array('type'=>'text','placeholder'=>'Decline Reason','label' => 'Decline Reason'),
 						'vaccination_date'=>array('type'=>'text','placeholder'=>'Vaccination Date','label' => 'Vaccination Date'),
 						'route'=>array('type'=>'text','placeholder'=>'Route','label' => 'Route'),	
 						'manufacturer'=>array('type'=>'text','placeholder'=>'Manufacturer','label' => 'Manufacturer'),	
 						'site'=>array('type'=>'text','placeholder'=>'Site','label' => 'Site'),	
 						'lot_no'=>array('type'=>'text','placeholder'=>'Lot','label' => 'Lot'),	
 						// 'signature_path'=>array('type'=>'file','placeholder'=>'Signature','label' => 'Signature File'),
 					

 						'pdf_path'=>array('type'=>'pdf_file_path','placeholder'=>'PDF Term 1','label' => 'Influenza PDF Form'),
 						// 'date_created'=>array('type'=>'text','placeholder'=>'Date Added','label' => ''),


 	 			 // 	 	'pdf_file2'=>array('type'=>'pdf_path','placeholder'=>'PDF Term 2','label' => 'PDF Term 2'),
 	 			 // 	 	'signature_file'=>array('type'=>'signature_path','placeholder'=>'Signature File','label' => 'Signature'),

 						// 'date_added'=> array('type'=>'date','placeholder'=>date('Y-m-d'),'label' => '', 'data-date-format'=>'yy-mm-dd' ),

 						// 'id'=>array('type'=>'hidden','placeholder'=>'id','label' => '')
 					);

 		$table_name= 'tbl_influenza_forms';
 			$response = $this->umodel->get($table_name);

 				// echo "<pre>",print_r($response),"</pre>";

 		// 	$filter = true;

 		// }else{
// 
 			// $response = $this->umodel->get_where('tbl_staff',array('status'=>'active'));

 			

 		// }

// echo "<pre>",print_r($response),"</pre>";die();

 		$data['content'] = createTable($fields,$table_name,$response,$data['current_page'],NULL);



		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



		//print_r($nav);die();

	}



	public function view_docs(){

		
		$raw = $this->input->get('l');
		$id = str_replace(" ", "+", $raw);
		$this->load->library('encrypt');
		
  		 $decoded =   $this->encrypt->decode(urldecode($id),'Vesenc');
  		 // var_dump($decoded);
  		 if(!$decoded){
  		 	 $decoded =   $this->encrypt->decode(trim($id),'Vesenc');
  		 }
  		 // echo $decoded;die();
  		 $response = $this->umodel->get_where('tbl_signatures',array('id'=>$decoded));
  		 // echo "<pre>",print_r($response),"</pre>";die();
  		 if(isset($response[0]->status) && $response[0]->status=='Signed'){

			show_404();
  		 }
// error_404();
 		$user_id = ucwords($this->session->userdata('user_id'));



		$data['logged_in'] = true;



 		$data['data'] = $response;// ucwords($this->session->userdata('name'));

 		$data['page'] = 'Document View';

 		$data['current_page'] = 'view_docs';

 		// $response = $this->umodel->get_where('tbl_config', array('id'=>1));

        // $parse = json_decode($response,true);

// echo "<pre>",print_r($response),"</pre>";die();

 		// $nav = $this->side_nav();

 		// $data['nav'] = $nav;

 		

 		// $data['content'] = config_form($response[0],$data['current_page']);

		// $this->load->view('header');

		// $this->load->view('sidenav', $data);

		$this->load->view('signup_form', $data);

		// $this->load->view('footer');

	



	}


 	public function check_username()

	{

		$data = $this->input->post();

		extract($data);

		$id = (isset($id))  ? $id :null;

		$response = $this->umodel->check_username($username,$id);

		// echo $this->db->last_query();die();



		echo count($response);

	}

	public function doc_views($ref=NULL){

		$reference = base64_decode($ref);
		$response = $this->umodel->get_where('sign_forms',array('id'=>$ref));

		$data['logged_in'] = true;
 		$data['page'] = 'Signature Detail';
	$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$data['user'] = ucwords($this->session->userdata('name'));
		if(!empty($response)){
			$doc_info = $response[0];
			// echo "<pre>",print_r($doc_info),"</pre>";die();
			 		$data['content'] = view_form($response[0],'doc_views/'.$ref);

		}else{
			redirect("login","refresh");die();
		}
	    $this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');
	}

	public function employee_certificates($ref=NULL){

		$reference = base64_decode($ref);
		$response =  $this->umodel->get_certificates($reference);//$this->umodel->get_where('sign_forms',array('id'=>$ref));
		// echo $response;die();
		$data['logged_in'] = true;
 		$data['page'] = 'Certificates Detail';

	     $nav = $this->side_nav();

 		$data['nav'] = $nav;

 		$data['user'] = ucwords($this->session->userdata('name'));
		if(!empty($response)){
			$doc_info = $response[0];
			// echo "<pre>",print_r($response),"</pre>";die();
			 		$data['content'] = view_certificates($response[0],'employee_certificates/'.$ref);

		}else{
			redirect("login","refresh");die();
		}
	    $this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');
	}




	public function settings(){

		if(!$this->check_token()){

			//header('Location: login');//die();

			redirect('login','refresh');

		}

 		$user_id = $this->session->userdata('user_id');

//print_r($this->session->userdata());die();

 	// /	echo $user_id;die();



		$data['logged_in'] = true;



 		$data['user'] = ucwords($this->session->userdata('name'));

 		$data['page'] = 'Settings';

 		$data['current_page'] = 'users/settings';

 		$response = $this->umodel->get_where('tbl_admin', array('id'=>$user_id));

        // $parse = json_decode($response,true);

// echo "<pre>",print_r($response),"</pre>";die();

 		$nav = $this->side_nav();

 		$data['nav'] = $nav;

 		

 		$data['content'] = settings_form($response[0],$data['current_page']);

		$this->load->view('header');

		$this->load->view('sidenav', $data);

		$this->load->view('body', $data);

		$this->load->view('footer');

	



	}

	public function settings_db(){
		$post = $this->input->post();	
		 		$user_id = $this->session->userdata('user_id');

		// echo "<pre>",print_r($post),"</pre>";die();

 		$tbl = 'admin';
		$err = 0;
		$err_msg = '';
		$posts = array();
		foreach($post['form'] as $k=>$v){
			if($v['name'] != 'cur_page' && $v['name'] != 'mySignature' && $v['name'] !='mySignature-type' && $v['name'] !='mySignature-dpi'){
				$posts[$v['name']] = $v['value'];
			}

			if($v['name'] == 'mySignature'){
				 		$user_id = ucwords($this->session->userdata('user_id'));
					$response = $this->base64_to_jpeg($v['value'],$user_id.'_counselor.jpg');
			        sleep(5);
			}
			if(empty($v['value'])){
				$err++;
				$err_msg .= "Please fill in all fields. <br> ";
			}


		}
		extract($posts);
		if(sha1($current_pwd) != $pwd){
			$err++;
			$err_msg .= "Current password is incorrect. <br>";
		}

		if($new_pwd != $conf_pwd){
			$err++;
			$err_msg .= "	New password does not match.";
		}

				// echo"<pre>",print_r($posts),"</pre>";die();

		if($err == 0){
			$this->session->set_userdata('name',$name);
			$send = array("name"=>$name,"password"=> $new_pwd); 
			$this->umodel->update($send,$user_id,$tbl);
		}
		
		$arr = json_encode(array("err" => $err , "err_msg" => $err_msg));

		echo $arr;

		// $batch = array();
		// $post['type'] = 'Debit';
		// unset($post['submit']);

		// $id = $this->db->insert('tbl_trans',$post);

		// redirect('add_budget?s=1','refresh');
	}	

	public function form1(){
		echo "Under development";
	}


	public function add()

	{

		

		$tbl = $this->input->post('process');		

		$cur_page = $this->input->post('current_page');	

		$post = $this->input->post();	

		$user_id = $this->session->userdata('user_id');

		if(isset($post['password'])){

			$post['password'] = sha1($post['password']);

		}

		unset($post['process']);

		unset($post['current_page']);
// echo $tbl;die();
			// die();
			// echo "<pre>",print_r($post),"</pre>";
						// echo "<pre>",print_r($_FILES),"</pre>";
// die();

	     if($tbl=='tbl_staff'){
	     		$id = $this->db->insert($tbl,array('staff_name'=>$post['staff_name']));
		    	$inserted_id = $this->db->insert_id();
	     	    $file = $_FILES['signature_path'];
				  $fileName = $_FILES['signature_path']['name'];
				  $fileTmpName = $_FILES['signature_path']['tmp_name'];

				  $fileSize = $_FILES['signature_path']['size'];
				  $fileError = $_FILES['signature_path']['error'];
				  $fileType = $_FILES['signature_path']['type'];

			 	 $file_name_with_extenstion = $file['name'];

					$extension = pathinfo($file_name_with_extenstion, PATHINFO_EXTENSION);

					$file = explode(".", $_FILES['signature_path']['name']);
					$file_ext = end($file);
					  $filename = str_replace(" ", "_", $_FILES['signature_path']['name']) ;

					  // echo $filename;die();
					$upload_name = "staff_".$id."_".$filename;//.time().".$extension";
					$file_name =    '../staff_signatures/'.$upload_name;//"profile" . $id . "." . $extension;// "profile" .pathinfo($file_name_with_extenstion, PATHINFO_FILENAME);
					// echo $upload_name." ".$file_name;die();
					$config['upload_path'] = FCPATH.'../staff_signatures/';
					// echo FCPATH.'staff_signatures/';die();
					// echo $config['upload_path'];die();
					$config['file_name'] = $upload_name;// "profile" . $id . "." . $extension;
					$config['allowed_types'] = '*';
					$config['overwrite'] = TRUE;
					// $config['max_size'] = 1024;
					// $config['max_width'] = 1024;
					// $config['max_height'] = 768;
		// echo "<pre>",print_r($config),"</pre>";die();
					$this->load->library('upload', $config);//Load the libary with the configuration

					if(!$this->upload->do_upload('signature_path')){
						$error = true;
						// echo $this->upload->display_errors();die();
					    // $error_msg  = $this->upload->display_errors();//validation error will be printed
					    // echo json_encode(array('success'=>false,'msg'=>'',));
					}
					$send = array("signature_path"=>$file_name); 
					$this->umodel->update($send,$inserted_id,'staff');
					if($tbl =='tbl_staff'){

						redirect(base_url().'staff?s=1','refresh');
					}else{

						redirect($cur_page.'?s=1','refresh');
					}

	     
		}elseif($tbl=='tbl_job_applications'){
				$id = $this->db->insert($tbl,array('first_name'=>$post['first_name'],'last_name'=>$post['last_name'],'email'=>$post['email']));
		    	$inserted_id = $this->db->insert_id();
	     	    $file = $_FILES['signature_path'];
				  $fileName = $_FILES['signature_path']['name'];
				  $fileTmpName = $_FILES['signature_path']['tmp_name'];

				  $fileSize = $_FILES['signature_path']['size'];
				  $fileError = $_FILES['signature_path']['error'];
				  $fileType = $_FILES['signature_path']['type'];

			 	 $file_name_with_extenstion = $file['name'];

					$extension = pathinfo($file_name_with_extenstion, PATHINFO_EXTENSION);

					$file = explode(".", $_FILES['signature_path']['name']);
					$file_ext = end($file);
					  $filename = str_replace(" ", "_", $_FILES['signature_path']['name']) ;

					  // echo $filename;die();
					$upload_name = "employee_".$id."_".$filename;//.time().".$extension";
					$file_name =    '../signatures/'.$upload_name;//"profile" . $id . "." . $extension;// "profile" .pathinfo($file_name_with_extenstion, PATHINFO_FILENAME);
					// echo $upload_name." ".$file_name;die();
					$config['upload_path'] = FCPATH.'../signatures/';
					// echo FCPATH.'staff_signatures/';die();
					// echo $config['upload_path'];die();
					$config['file_name'] = $upload_name;// "profile" . $id . "." . $extension;
					$config['allowed_types'] = '*';
					$config['overwrite'] = TRUE;
					// $config['max_size'] = 1024;
					// $config['max_width'] = 1024;
					// $config['max_height'] = 768;
		// echo "<pre>",print_r($config),"</pre>";die();
					$this->load->library('upload', $config);//Load the libary with the configuration

					if(!$this->upload->do_upload('signature_path')){
						$error = true;
						echo $this->upload->display_errors();die();
					    // $error_msg  = $this->upload->display_errors();//validation error will be printed
					    // echo json_encode(array('success'=>false,'msg'=>'',));
					}
					$send = array("signature_path"=>$file_name); 
					$this->umodel->update($send,$inserted_id,'job_applications');
					// echo $this->db->last_query();die();
					if($tbl =='tbl_staff'){

						redirect(base_url().'staff?s=1','refresh');
					}else{

						redirect($cur_page.'?s=1','refresh');
					}
			// echo "asd";die();
		}else{
			$id = $this->db->insert('tbl_'.$tbl,$post);

		}






		// echo $this->db->last_query();die();

		



		redirect(base_url().'manage_staff?s=1','refresh');



	}


	public function regenerate_certificate(){
		$post = $this->input->post();	
		 		$user_id = $this->session->userdata('user_id');

		// echo "<pre>",print_r($post),"</pre>";die();

 		// $tbl = 'admin';
		$err = 0;
		$err_msg = '';
		$posts = array();
		foreach($post['form'] as $k=>$v){
			if($v['name'] != 'cur_page' && $v['name'] != 'mySignature' && $v['name'] !='mySignature-type' && $v['name'] !='mySignature-dpi'){
				$posts[$v['name']] = $v['value'];
			}

			if($v['name'] == 'mySignature'){
				 		$user_id = ucwords($this->session->userdata('user_id'));
					$response = $this->base64_to_jpeg($v['value'],$user_id.'_counselor.jpg');
			        sleep(5);
			}
			if(empty($v['value'])){
				$err++;
				$err_msg .= "Please fill in all fields. <br> ";
			}


		}
		extract($posts);
		if(sha1($current_pwd) != $pwd){
			$err++;
			$err_msg .= "Current password is incorrect. <br>";
		}

		if($new_pwd != $conf_pwd){
			$err++;
			$err_msg .= "	New password does not match.";
		}

				// echo"<pre>",print_r($posts),"</pre>";die();

		if($err == 0){
			$this->session->set_userdata('name',$name);
			$send = array("name"=>$name,"password"=> $new_pwd); 
			$this->umodel->update($send,$user_id,$tbl);
		}
		
		$arr = json_encode(array("err" => $err , "err_msg" => $err_msg));

		echo $arr;

		// $batch = array();
		// $post['type'] = 'Debit';
		// unset($post['submit']);

		// $id = $this->db->insert('tbl_trans',$post);

		// redirect('add_budget?s=1','refresh');
	}	



}

