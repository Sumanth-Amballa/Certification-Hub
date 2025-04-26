<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class EmployeeModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
   
    function fetchcertificatesofuser($user_id) {
        $this->db->select('c.cert_id,c.cert_name,c.description,c.references,c_status,c.levels,e.e_id');
        $this->db->from('certificates c');
        $this->db->join('employee_certificate e', 'c.cert_id = e.c_id','left');
        $this->db->where("c.active_status",1);
        // $this->db->where('e_id',$user_id);
        $query = $this->db->get();
        $res=$query->result();
        // print_r($this->db->last_query());
        return $res;
    }

    public function getEmployeeDetails($params = array()){
        $this->db->select('username,phonenumber,dob,image');
        $this->db->from('user_profile');
        $this->db->where('user_id', $params["conditions"]["id"]);
        $query = $this->db->get();
        $res = $query->row_array();
        return $res;
    }
    
    public function updateUserDetails($params = array()){
        $res=$this->db->update('user_profile',$params["update"],$params["conditions"]);
       return $res;
    }
    public function getCertificateDetails($params = array()){
        $this->db->select('users.id,employee_certificate.c_id,certificates.cert_name,employee_certificate.attachment, certificates.references,certificates.levels');
        $this->db->from('users');
        $this->db->join('employee_certificate', 'users.id = employee_certificate.e_id','inner');
        $this->db->join('certificates', 'certificates.cert_id = employee_certificate.c_id','inner');
        $this->db->where('users.manager_id', $params["conditions"]["m_id"]);
        $this->db->where('employee_certificate.c_status', $params["conditions"]["c_status"]);
        $query = $this->db->get();
        $res = $query->result();
        return $res;
    }

    public function updateCertificateStatus($params = array()){
     
        
      $res=$this->db->update('employee_certificate',$params["update"],$params["conditions"]);
   
       return $res;
       
    }
    public function insertIntoEmpCert($params = array()){
        $data = array(
            "e_id" => $params['conditions']["e_id"],
            "c_id" =>$params['conditions']["c_id"],
            "c_status" => $params["update"]["c_status"]
        );
        $res=$this->db->insert('employee_certificate',$data);
       
        return $res;
    }

}