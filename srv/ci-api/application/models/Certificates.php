<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Certificates extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->cert_table = 'certificates';
    }

    function certificate_validate($params = array()) {
        $this->db->select('cert_id');
        $this->db->from($this->cert_table);
        $this->db->where("cert_name", $params["conditions"]["cert_name"]);
        $this->db->where("levels", $params["conditions"]["levels"]);
        $query=$this->db->get();
        $res=$query->row_array();
        // print_r($res);exit;
        return $res;
    }

    function checkcertname($cert_name, $levels, $cert_id){
        $this->db->select('cert_id');
        $this->db->from($this->cert_table);
        $this->db->where("cert_id!=", $cert_id);
        $this->db->where("cert_name", $cert_name);
        $this->db->where("levels", $levels);
        $query=$this->db->get();
        $res=$query->row_array();
        // print_r($res);exit;
        return $res;
    }

    function insert($params=array()) {
        $insert = $this->db->insert($this->cert_table, $params);
        return $insert?$this->db->insert_id():false;
    }

    function fetch($status) {
        $this->db->select('cert_id, cert_name, levels, active_status, description, references');
        $this->db->from($this->cert_table);
        $this->db->where("active_status", $status);
        $query=$this->db->get();
        $res=$query->result();
        return $res;
    }

    function fetchsingle($cert_id) {
        $this->db->select('cert_id, cert_name, levels, description, references');
        $this->db->from($this->cert_table);
        $this->db->where("cert_id", $cert_id);
        $query=$this->db->get();
        $res=$query->row_array();
        return $res;
    }

    // function fetchdeleted() {
    //     $this->db->select('cert_id, cert_name, levels, active_status, description, references');
    //     $this->db->from($this->cert_table);
    //     $this->db->where("active_status", 0);
    //     $query=$this->db->get();
    //     $res=$query->result();
    //     return $res;
    // }

    function update($params=array(), $cert_id) {
        $this->db->where("cert_id", $cert_id);
        return $this->db->update($this->cert_table, $params);
    }
    function delete($cert_id, $active_status) {
        $this->db->where("cert_id", $cert_id);
        return $this->db->update($this->cert_table, $active_status);
    }
}