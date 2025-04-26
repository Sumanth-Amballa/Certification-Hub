<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require ( APPPATH . '/libraries/REST_Controller.php' );

class Registration extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model("Users");
        $this->load->model("Sessions");
    }

    function signup_post() {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $manager_id = $_POST['manager_id'];
        $dept_id = $_POST['dept_id'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role_id='3';
        if($manager_id==adminManagerId){
            $role_id='1';
        }
        else if($manager_id==managerManagerId){
            $role_id='2';
        }
        $plainEmail = $_POST['email'];
        if(!empty($plainEmail) && !empty($manager_id) && !empty($dept_id) && !empty($password) && !empty($confirm_password)){
            $usersExist = $this->Users->registration_validate($plainEmail);
            if($usersExist){
                $this->response([
                    'status' => 'FAILED',
                    'message' => 'Email already exists!',
                    'code' => 409,
                    'data' => []
                ]);
            }
            else{
                $res = $this->Users->insert($plainEmail, $manager_id, $dept_id, $password, $role_id, $curr_date);
                if($res){
                    $this->response([
                        'status' => 'SUCCESS_OK',
                        'message' => 'Registration successful',
                        'code' => 200,
                        'userprofiledata' => $result,
                        'data' => []
                    ]);
                }
                else{
                    $this->response([
                        'status' => 'FAILED',
                        'message' => 'Signup failed',
                        'code' => 400,
                        'data' => []
                    ]);
                }
            }
        }
        else {
            $this->response([
                'status' => 'FAILED',
                'message' => 'Enter valid data',
                'code' => 400,
                'data' => []
            ]);
        }
    }

    function login_post() {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        if(!empty($email) && !empty($password)) {
            $result = $this->Users->login_validate($email,$password);
            if (!$result) {
                $this->response(
                    array(
                        "status" => "FAILED",
                        "message" => "Unauthorized",
                        "code" => 401,
                        "errors" => []
                    )
                );
            }
            else {
                $id = $result[1];
                $role = $result[0];
                $token = $this->Sessions->session_row_insert($id, $role, $curr_date);
                if($token){
                    $this->response(
                        array(
                            "status" => "SUCCESS_OK",
                            "message" => "Logged in successfully",
                            "code" => 200,
                            "errors" => [],
                            "data" => $token,
                            "role" => $role
                        )
                    );
                }
                else{
                    $this->response(
                        array(
                            "status" => "FAILED",
                            "message" => "Session failed",
                            "code" => 401,
                            "errors" => []
                        )
                    );
                }
                // $secret_key = jwtSecretKey;
                // $issuer_claim = "THE_ISSUER";
                // $audience_claim = "THE_AUDIENCE";
                // $issuedat_claim = time();
                // $notbefore_claim = $issuedat_claim + 10;
                // $expire_claim = $issuedat_claim + 3600;
                // $token = array(
                //     "iss" => $issuer_claim,
                //     "aud" => $audience_claim,
                //     "iat" => $issuedat_claim,
                //     "nbf" => $notbefore_claim,
                //     "exp" => $expire_claim,
                //     "data" => array("id" => $id, "role" => $role)
                // );
                
                // $jwt = JWT::encode($token, $secret_key);
                // print_r($jwt);
                
            }
        }
        else {
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Fields empty",
                    "code" => 400,
                    "errors" => []
                )
            );
        }
    }

    function forgotpassword_post(){
        $_POST = json_decode(file_get_contents('php://input'), true);
        $email = $_POST['email'];
        if(!empty($email)){
            $result = $this->Users->forgotpassword($email);
            if (empty($result)) {
                $this->response(
                    array(
                        "status" => "FAILED",
                        "message" => "Invalid email or user not registered",
                        "code" => 401,
                        "errors" => [],
                        "data" => []
                    )
                );
            } else {
                $this->response(
                    array(
                        "status" => "SUCCESS_OK",
                        "message" => "Reset your password",
                        "code" => 200,
                        "errors" => [],
                        "data" => [$email]
                    )
                );
            }        }
        else {
            $this->response(
                array(
                    "status" => "FAILED",
                    "message" => "Please enter email",
                    "code" => 401,
                    "errors" => [],
                    "data" => []
                )
            );
        }
    }

    function resetpassword_post(){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $email = $_POST["email"];
        $password=$_POST["password"];
        $password=md5($password);
        if(!empty($email) && !empty($password)){
            $result = $this->Users->updatepassword($email,$password, $curr_date);
            if (!$result) {
                $this->response(
                    array(
                        "status" => "FAILED",
                        "message" => "Password updation failed",
                        "code" => 401,
                        "errors" => [],
                        "data" => []
                    )
                );
            }
            else {
                $this->response(
                    array(
                        "status" => "SUCCESS_OK",
                        "message" => "Password is updated",
                        "code" => 200,
                        "errors" => [],
                        "data" => []
                    )
                );
            }
        }
        else{
            $this->response(
                array(
                    "status"=>"FAILED",
                    "message"=>"Data is insufficient mail or password is incorrect",
                    "code"=>401,
                    "errors"=>[],
                    "data"=>[]
                )
            );
        }
     }

     function landingPageDetails_get(){
        $res = $this->Users->getDetails();
        if($res){
            $this->response([
                'status' => 'SUCCESS',
                'message' => 'Fetched landing page details',
                'code' => 200,
                'data' => $res
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
}