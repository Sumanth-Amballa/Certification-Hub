<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require ( APPPATH . '/libraries/REST_Controller_Session.php' );

class employee extends REST_Controller_Session {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model("EmployeeModel");
        $this->load->model("Users");
    }
   
    function empcertificates_get(){
        $res = $this->EmployeeModel->fetchcertificatesofuser($this->u_id);
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Fetched Employee Certificates',
                'code' => 200,
                'data' => $res,
                'uid' => $this->u_id
            ], SUCCESS_OK);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Failed to retrieve data from the database',
                'code' => 401,
                'data' => []
            ], SUCCESS_OK);
        }
    }
    function userdetails_get()
    {
        $con['conditions'] = array(
            'id' => $this->u_id
        );
        
        $data = $this->EmployeeModel->getEmployeeDetails($con);
        $name = $data['image'];
        $file="./application/assets/profileImages/".$name.".jpg";
        $data["image"]=file_get_contents($file);
        if(!(empty($data))){
            $this->response(
                array(
                    "status" => "SUCCESS",
                    "message" => "Successfully retrieved",
                    "code" => 200,
                    "errors" => [],
                    "data" => $data
                )
            );
        }
        else{
        $this->response(
                array(
                    "status" => "SUCCESS",
                    "message" => "No records found",
                    "code" => 204,
                    "errors" => [],
                    "data" => $data
                )
            );
        }
    }
    function userdetails_put()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $username = $_POST['username'];
        $phonenumber = $_POST['phonenumber'];

        $dob =$_POST['dob'];
        $t=time();
        $img =$_POST['image'];
        $name=$this->u_id."-".$t;
        $file="./application/assets/profileImages/".$name.".jpg";
        $myfile=fopen($file,'w');
        fwrite($myfile,$img);
        fclose($myfile);
        $image=$name;
        $con['conditions'] = array(
                'user_id' => $this->u_id
            );
    $con['update'] = array(
                'username' => $username,
                'dob' => $dob,
                'phonenumber' => $phonenumber,
                'image' => $image
            );
    
        $data = $this->EmployeeModel->updateUserDetails($con);
        if($data==TRUE){
        $this->response(
            array(
                "status" => "SUCCESS",
                "message" => "Successfully updated",
                "code" => 200,
                "errors" => [],
                "data" => []
            )
        );
        }
        else{
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Updation failed",
                    "code" => 401,
                    "errors" => [],
                    "data" => []
                )
            );
        }
    }

    function certificatebystatus_post($c_status)
    {
    
        $_POST = json_decode(file_get_contents('php://input'), true);
        $m_id = $this->u_id;
        
        $con['conditions'] = array(
                'm_id' => $m_id,
                'c_status' => $c_status
            );
        
        $data = $this->EmployeeModel->getCertificateDetails($con);
        if(!(empty($data))){
        $this->response(
            array(
                "status" => "SUCCESS",
                "message" => "Successfully retrieved",
                "code" => 200,
                "errors" => [],
                "data" => $data
            )
        );
    }
    else{
        $this->response(
            array(
                "status" => "SUCCESS",
                "message" => "No records found",
                "code" => 204,
                "errors" => [],
                "data" => $data
            )
        );
    }

    }

    function changecertificatestatus_post()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $e_id = $_POST['id'];
        $c_status = $_POST['c_status'];
        $c_id =$_POST['c_id'];
        $con['conditions'] = array(
                'e_id' => $e_id,
                'c_id' => $c_id
            );
    $con['update'] = array(
                'c_status' => $c_status
            );
        if($c_status==0){
            $data = $this->EmployeeModel->insertIntoEmpCert($con);
        }
        else{
        $data = $this->EmployeeModel->updateCertificateStatus($con);
        }
        if($data==TRUE){
        $this->response(
            array(
                "status" => "SUCCESS",
                "message" => "Successfully updated",
                "code" => 200,
                "errors" => [],
                "data" => []
            )
        );
        }
        else{
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Updation failed",
                    "code" => 401,
                    "errors" => [],
                    "data" => []
                )
            );
        }

    }

    function changepassword_post(){
        $_POST = json_decode(file_get_contents('php://input'), true);
        $oldpassword = md5($_POST['oldpassword']);
        $res = $this->Users->checkoldpassword($this->u_id, $oldpassword);

        // $mail = array_values($email)[0];
        if($res){
            $this->response(
                array(
                    "status" => "SUCCESS_OK",
                    "message" => "Old password matched",
                    "code" => 200,
                    "errors" => [],
                    "data" => $res
                )
            );
        }
        else{
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Old password not matched",
                    "code" => 401,
                    "errors" => []
                )
            );
        }
    }
}