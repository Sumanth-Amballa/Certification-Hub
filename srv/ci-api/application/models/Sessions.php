<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sessions extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->session_table = 'user_session';
    }

    function session_row_insert($id, $role, $curr_date) {
        $this->db->set('user_id', $id);
        // $this->db->set('login_time', $curr_date);
        $insert = $this->db->insert($this->session_table);
        $session_id = $this->db->insert_id();
        $arr=array("id"=>$id, "session_id"=>$session_id, "role"=>$role);
        $dataObj=(object)$arr;
        $serializedData = serialize($dataObj);
        $cipher = "AES-256-CBC";
        $secret = encrypt_key;
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));
        $encryptedVal = openssl_encrypt($serializedData, $cipher, $secret, $options, $iv);
        // $decryptedVal = openssl_decrypt($encryptedVal, $cipher, $secret, $options, $iv);
        // $val = unserialize($decryptedVal);
        $tokenData = [
            'token' => $encryptedVal,
            'login_time'=> $curr_date
        ];
        $res = $this->db->update($this->session_table,$tokenData,array('id'=>$session_id));
        return $encryptedVal;
    }

    function updateLogout($id, $curr_date) {
        $res = $this->db->update($this->session_table,['logout_time' => $curr_date],array('id'=>$id));
        return res;
    }

    function checkSession($id) {
        $this->db->select('id');
        $this->db->from($this->session_table);
        $this->db->where("id",$id);
        $query=$this->db->get();
        $res=$query->row_array();
        // print_r($res[id]);exit;
        return $res[id];
    }
}