<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        // $this->dept_table = 'department';
    }

    function departmentdetails($status){
        $this->db->select('d_id,d_name');
            $this->db->from('department');
            $this->db->where('d_id!=',1);
            $this->db->where('active_status',$status);
            $query=$this->db->get();
            $res=$query->result_array();
            return $res;
        // if($rol==1){
        //     $this->db->select('d_id,d_name');
        //     $this->db->from('department');
        //     $this->db->where('active_status',1);
        //     $query=$this->db->get();
        //     $res=$query->result_array();
        //     return $res;
        // }
        // else if($rol==3){
        //     $this->db->select('d_id,d_name');
        //     $this->db->from('department');
        //     $this->db->where('d_id!=',1);
        //     $this->db->where('active_status',1);
        //     $query=$this->db->get();
        //     $res=$query->result_array();
        //     return $res;
        // }
    }

    function adddepartment($data){
        $this->db->insert('department',$data);
        return $this->db->insert_id();
    }

    function deletedepartment($id, $deletedTime){
        $data=[
            'active_status'=>0,
            'modify_time'=>$deletedTime
        ];
        return $this->db->update('department',$data,array('d_id'=>$id));
    }

    function departmentdetail($id){
        $this->db->select('d_id,d_name');
        $this->db->from('department');
        $this->db->where("d_id", $id);
        $query=$this->db->get();
        $res=$query->row_array();
        return $res;
    }

    function checkdeptname($d_name){
        $this->db->select('d_id');
        $this->db->from('department');
        $this->db->where("d_name", $d_name);
        $query=$this->db->get();
        $res=$query->row_array();
        // print_r($res);exit;
        return $res;
    }

    function updatedepartment($id,$data){
        // print_r($data['manager_id']);
        
        return $this->db->update('department',$data,array('d_id'=>$id));
    }
}