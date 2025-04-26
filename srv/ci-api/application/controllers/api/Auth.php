<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require ( APPPATH . '/libraries/REST_Controller_Session.php' );

class auth extends REST_Controller_Session {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model("Users");
        $this->load->model("Sessions");
    }

    function rolecheck_get() {
        $this->response(
            array(
                "status" => "SUCCESS_OK",
                "message" => "Role is present",
                "code" => 200,
                "errors" => [],
                "role" => $this->role
            )
        );
    }

    function logout_post() {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $cipher = "AES-256-CBC";
        $secret = encrypt_key;
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));
        $decryptedVal = openssl_decrypt($this->token, $cipher, $secret, $options, $iv);
        $dataObj = unserialize($decryptedVal);
        $id = $dataObj->session_id;
        $res = $this->Sessions->updateLogout($id, $curr_date);
        if(res){
            $this->response(
                array(
                    "status" => "SUCCESS_OK",
                    "message" => "Logout successful",
                    "code" => 200,
                    "errors" => []
                )
            );
        }
        else{
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Logout failed",
                    "code" => 401,
                    "errors" => []
                )
            );
        }
    }

    
}