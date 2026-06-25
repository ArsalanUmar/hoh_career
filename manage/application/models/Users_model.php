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
  
        $this->db->select("tbl_test_certificates.*, CONCAT(`tbl_job_applications`.first_name,' ',`tbl_job_applications`.last_name) as employee_name,tbl_job_applications.id as employee_id,tbl_test_certificates.employee_id as test_cert_employee , tbl_custom_certificates.employee_id as custom_cert_employee,tbl_custom_certificates.cert_name");

        $this->db->from('tbl_test_certificates');

        $this->db->join('tbl_job_applications',"tbl_test_certificates.employee_id = tbl_job_applications.id","LEFT");

        $this->db->join('tbl_custom_certificates',"tbl_custom_certificates.employee_id = tbl_job_applications.id","LEFT");
        $this->db->where('status != "mark_to_arch"',NULL, false);
        $this->db->where('status != "archived"',NULL, false);
        $this->db->where('(tbl_custom_certificates.employee_id IS NOT NULL OR tbl_test_certificates.employee_id IS NOT NULL)',NULL, false);


        if(!empty($id)){

          $this->db->where('tbl_job_applications.id',$id);

        }

          $this->db->group_by('tbl_job_applications.id');

        $query = $this->db->get();

        $response = $query->result();
          // echo "<pre>",print_r()
       // echo $this->db->last_query();die();

        return $response;



    }


 public function get_custom_certificates($id=NULL){
  
        $this->db->select("tbl_custom_certificates.*, CONCAT(`tbl_job_applications`.first_name,' ',`tbl_job_applications`.last_name) as employee_name");

        $this->db->from('tbl_custom_certificates');

        $this->db->join('tbl_job_applications',"tbl_custom_certificates.employee_id = tbl_job_applications.id","LEFT");
        $this->db->where('tbl_job_applications.status !="mark_to_arch"',NULL,false);



        if(!empty($id)){

          $this->db->where('tbl_custom_certificates.employee_id',$id);

        }
          $this->db->order_by('tbl_custom_certificates.id','DESC');
          $this->db->group_by('tbl_custom_certificates.id');

        $query = $this->db->get();

        $response = $query->result();

       // echo $this->db->last_query();die();

        return $response;



    }

    public function get_service_logs($id=NULL){
  
        $this->db->select("tbl_inservice_logs.*, CONCAT(`tbl_job_applications`.first_name,' ',`tbl_job_applications`.last_name) as employee_name, DATE_FORMAT(tbl_inservice_logs.date_added, '%M %Y') as month");

        $this->db->from('tbl_inservice_logs');

        $this->db->join('tbl_job_applications',"tbl_inservice_logs.employee_id = tbl_job_applications.id","LEFT");
        $this->db->where('tbl_job_applications.status !="mark_to_arch"',NULL,false);



        if(!empty($id)){

          $this->db->where('tbl_inservice_logs.id',$id);

        }
          $this->db->order_by('tbl_inservice_logs.id','DESC');
          $this->db->group_by('tbl_inservice_logs.id');

        $query = $this->db->get();

        $response = $query->result();

        $topic_labels = array(
            1 => 'Grievances/Complaints',
            2 => 'Infection Control Training',
            3 => 'Cultural Diversity',
            4 => 'Communication Barriers',
            5 => 'Ethics Training',
            6 => 'Workplace (OSHA) & Patient Safety',
            7 => 'Patients\' Rights & Responsibilities',
            8 => 'Compliance Program',
            9 => 'Grief, Loss and Change',
            10 => 'Pain and Symptom Management',
            11 => 'Infection Control/Hand Hygiene',
            12 => 'Patient Safety'
        );

        foreach ($response as $row) {
            // Format date_added as MM-DD-YYYY and time (e.g. 03-11-2026 02:30 PM)
            if (!empty($row->date_added) && $row->date_added !== '0000-00-00 00:00:00') {
                $ts_added = strtotime($row->date_added);
                if ($ts_added !== false) {
                    $row->date_added = date('m-d-Y h:i A', $ts_added);
                }
            }

            $topics = array();
            $topic_duration_pairs = array();
            for ($i = 1; $i <= 12; $i++) {
                $q_key = 'q_' . $i;
                $dur_key = 'duration_' . $i;
                $date_val = isset($row->$q_key) ? trim($row->$q_key) : '';
                $is_filled = ($date_val !== '' && $date_val !== '0000-00-00' && strpos($date_val, '0000-00-00') !== 0);
                if ($is_filled) {
                    $topics[] = $topic_labels[$i];
                    $dur_val = isset($row->$dur_key) && $row->$dur_key !== '' ? $row->$dur_key : '1 hour';
                    $ts = strtotime($date_val);
                    $month_name = ($ts !== false) ? date('F', $ts) : '-';
                    $topic_duration_pairs[] = array(
                        'index' => $i,
                        'month' => $month_name,
                        'topic' => $topic_labels[$i],
                        'duration' => htmlspecialchars($dur_val, ENT_QUOTES, 'UTF-8')
                    );
                }
            }
            foreach (array(
                array('date' => 'semi_emergency_1', 'dur' => 'semi_duration_1', 'label' => 'Semi-Annual Emergency Training 1', 'index' => 13),
                array('date' => 'semi_emergency_2', 'dur' => 'semi_duration_2', 'label' => 'Semi-Annual Emergency Training 2', 'index' => 14),
            ) as $semi) {
                $df = $semi['date'];
                $date_val = isset($row->$df) ? trim((string) $row->$df) : '';
                $is_filled = ($date_val !== '' && $date_val !== '0000-00-00' && strpos($date_val, '0000-00-00') !== 0);
                if ($is_filled) {
                    $ts = strtotime($date_val);
                    $month_name = ($ts !== false) ? date('F', $ts) : '-';
                    $dk = $semi['dur'];
                    $dur_val = isset($row->$dk) && $row->$dk !== '' ? $row->$dk : '1 hour';
                    $topics[] = $semi['label'];
                    $topic_duration_pairs[] = array(
                        'index' => (int) $semi['index'],
                        'month' => $month_name,
                        'topic' => $semi['label'],
                        'duration' => htmlspecialchars($dur_val, ENT_QUOTES, 'UTF-8'),
                    );
                }
            }
            $row->topic = implode('<br>', $topics);
            $row->duration = implode('<br>', array_map(function ($p) { return $p['topic'] . ' → ' . $p['duration']; }, $topic_duration_pairs));
            $row->topic_duration = $this->_build_topic_duration_table($topic_duration_pairs, $row->employee_id);
            $topic_indexes = array_map(function ($p) {
                return isset($p['index']) ? (int) $p['index'] : 0;
            }, $topic_duration_pairs);
            $topic_indexes = array_values(array_filter(array_unique($topic_indexes), function ($idx) {
                return $idx >= 1 && $idx <= 14;
            }));
            $row->bulk_certificate_url = '../generate_training_certificate.php?employee_id=' . urlencode($row->employee_id) . '&topics=' . urlencode(implode(',', $topic_indexes)) . '&bulk=1';
        }

        return $response;



    }

    private function _build_topic_duration_table($pairs, $employee_id) {
        if (empty($pairs)) {
            return '';
        }
        $html = '<table class="service-log-inner-table" style="width:100%; border-collapse:collapse; font-size:0.85em;">';
        $html .= '<thead><tr style="border-bottom:1px solid #ddd; background:#f5f5f5;">';
        $html .= '<th style="padding:4px 8px; text-align:left; font-weight:600; white-space:nowrap;">Month</th>';
        $html .= '<th style="padding:4px 8px; text-align:left; font-weight:600;">Topic</th>';
        $html .= '<th style="padding:4px 8px; text-align:left; font-weight:600; white-space:nowrap;">Duration</th>';
        $html .= '<th style="padding:4px 8px; text-align:left; font-weight:600; white-space:nowrap;">Certificate</th>';
        $html .= '</tr></thead><tbody>';
        foreach ($pairs as $p) {
            $topic_index = isset($p['index']) ? (int) $p['index'] : 0;
            // Topics 1–12 + semi-annual 13–14 map to generate_training_certificate.php
            $cert_url = ($topic_index >= 1 && $topic_index <= 14)
                ? '../generate_training_certificate.php?employee_id=' . urlencode($employee_id) . '&topic=' . $topic_index
                : '#';
            $html .= '<tr style="border-bottom:1px solid #eee;">';
            $html .= '<td style="padding:4px 8px;">' . htmlspecialchars($p['month'], ENT_QUOTES, 'UTF-8') . '</td>';
            $html .= '<td style="padding:4px 8px;">' . htmlspecialchars($p['topic'], ENT_QUOTES, 'UTF-8') . '</td>';
            $html .= '<td style="padding:4px 8px;">' . $p['duration'] . '</td>';
            $html .= '<td style="padding:4px 8px; white-space:nowrap;">';
            if ($topic_index >= 1 && $topic_index <= 14) {
                $html .= '<a href="' . $cert_url . '" target="_blank" class="btn btn-xs btn-primary">Certificate</a>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }


 public function get_applications(){

        $this->db->select("*");

        $this->db->from('tbl_job_applications');

        // $this->db->where('username',$username);




          $this->db->where('status','active');
          $this->db->where('email is NOT NULL',NULL, false);
            $this->db->where('date_of_birth is NOT NULL',NULL, false);
            $this->db->where('sss_number is NOT NULL',NULL, false);
          $this->db->where('prof_ref_company_1 !="google"',NULL, false);

        



        $query = $this->db->get();

        $response = $query->result();

       // echo $this->db->last_query();die();

        return $response;

 }


 public function get_manual_applications(){

        $this->db->select("*");

        $this->db->from('tbl_job_applications');

        // $this->db->where('username',$username);



          $this->db->where('middle_initial is  NULL',NULL, false);
            $this->db->where('date_of_birth is NULL',NULL, false);
            $this->db->where('sss_number is  NULL',NULL, false);
            $this->db->where('status','active');

        



        $query = $this->db->get();

        $response = $query->result();

       // echo $this->db->last_query();die();

        return $response;

 }


 public function get_archived_applications(){

        $this->db->select("*");

        $this->db->from('tbl_job_applications');

        // $this->db->where('username',$username);



            $this->db->where('status','mark_to_arch');

        



        $query = $this->db->get();

        $response = $query->result();

       // echo $this->db->last_query();die();

        return $response;

 }


}

