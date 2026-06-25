<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Users_model extends CI_Model {



    /**

     * Index Page for this controller.

     *

     * Maps to the following URL

     *      http://example.com/index.php/welcome

     *  - or -

     *      http://example.com/index.php/welcome/index

     *  - or -

     * Since this controller is set as the default controller in

     * config/routes.php, it's displayed at http://example.com/

     *

     * So any other public methods not prefixed with an underscore will

     * map to /index.php/welcome/<method_name>

     * @see https://codeigniter.com/user_guide/general/urls.html

     */

    public function __construct()

    {

                // Call the CI_Model constructor

        parent::__construct();

    }



    public function check_user()

    {

        $username = $this->input->post('username');

        $password = sha1($this->input->post('password'));

        //echo $password;die();
        
        // check in email first
        $result = $this->get_where('tbl_admin', array('username' => $username,'password'=>$password));
        // echo $this->db->last_query();die();
        //check in mobile
      

        $response = false;
// echo "<pre>",print_r($result),"</pre>";


        if(count($result) > 0){

            $this->logged_user($result[0]);

            $response = true;

        }



        return $response;

        

    }


    public function check_username($username=null,$id=null){

        $this->db->select("id");

        $this->db->from('tbl_admin');

        $this->db->where('username',$username);



        if(!empty($id)){

          $this->db->where('id<>',$id);

        }



        $query = $this->db->get();

        $response = $query->result();

       

        return $response;



    }





    public function logged_user($data){

        // if(!isset($_SESSION)){
        //     session_start();

        // }

        // $_SESSION['user_id'] = $data->id;
        // $_SESSION['user_name'] = $data->username;
        // $_SESSION['name'] = $name;
        $this->session->set_userdata('user_id',$data->id);

        // $this->session->set_userdata('user_role',$data->role);

        $this->session->set_userdata('user_name',$data->username);

        $this->session->set_userdata('name',$data->name);



    }





/***UNIVERSAL***/

    public function get_where($tbl=null,$arr=null){

        $query = $this->db->get_where($tbl, $arr);



        return $query->result();



    }





    public function get($tbl=null){

        if($tbl == 'tbl_staff'){
              $this->db->order_by('staff_id','DESC');
         $query = $this->db->get($tbl);
        }elseif($tbl != 'tbl_admin'){

         $this->db->order_by('id','DESC');
         $query = $this->db->get($tbl);

        }else{

          $query = $this->db->get_where($tbl, array('id<>'=>'1'));

        }

        return $query->result();



    }



    



    public function update($data, $id , $table){

   //     print_r($data);die();

        if(isset($data['password'])){

            $data['password'] = sha1($data['password']);

        }



        $tbl = 'tbl_'.$table;

        if($tbl=='tbl_staff'){
                    $this->db->where('staff_id', $id);

        }else{

        $this->db->where('id', $id);
        }

        $query  = $this->db->update($tbl, $data); 

        return $query;

    }


 public function get_certificates($id=NULL){
  
        $this->db->select("tbl_test_certificates.*, CONCAT(`tbl_job_applications`.first_name,' ',`tbl_job_applications`.last_name) as employee_name");

        $this->db->from('tbl_test_certificates');

        $this->db->join('tbl_job_applications',"tbl_test_certificates.employee_id = tbl_job_applications.id","LEFT");
        // $this->db->where('username',$username);



        if(!empty($id)){

          $this->db->where('tbl_test_certificates.id',$id);

        }



        $query = $this->db->get();

        $response = $query->result();

       // echo $this->db->last_query();die();

        return $response;



    }






}

