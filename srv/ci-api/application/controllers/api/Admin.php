<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require ( APPPATH . '/libraries/REST_Controller_Session.php' );

class admin extends REST_Controller_Session {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model("Certificates");
        // $this->load->model("Departments");
        $this->load->model("Users");
        $this->load->model("Departments");
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        
    }

    function certificates_post($id) {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        // $cert_name = mysql_real_escape_string($this->input->post('cert_name'));
        $cert_name = $_POST['cert_name'];
        $levels = $_POST['levels'];
        $description = $_POST['description'];
        $references = $_POST['references'];

        if(!empty($cert_name) && !empty($levels) && !empty($description) && !empty($references)){
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'cert_name' => $cert_name,
                'levels' => $levels,
            );
            $certExist = $this->Certificates->certificate_validate($con);
            // print_r($certExist);exit;
            if($certExist){
                $this->response([
                    'status' => 'FAILED',
                    'message' => 'Certificate already exists!',
                    'code' => 409,
                    'data' => []
                ]);
            }
            else{
                $certData = [
                    'cert_name' => $cert_name,
                    'levels' => $levels,
                    'description' => $description,
                    'references' => $references,
                    'created_time'=>$curr_date
                ];
                $res = $this->Certificates->insert($certData);
                if($res){
                    $this->response([
                        'status' => 'SUCCESS_OK',
                        'message' => 'Certificate added successfully!',
                        'code' => 200,
                        // 'userprofiledata' => $result,
                        'data' => []
                    ]);
                }
                else{
                    $this->response([
                        'status' => 'FAILED',
                        'message' => 'Insertion failed',
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

    function certificates_get($var){
        if($var=='active'){
            $status=1;
            $res = $this->Certificates->fetch($status);
        }
        else if($var=='inactive'){
            $status=0;
            $res = $this->Certificates->fetch($status);
        }
        else{
            $res = $this->Certificates->fetchsingle($var);
        }
        
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Fetch successful',
                'code' => 200,
                'data' => $res
            ]);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Failed to retrieve data from the database',
                'code' => 500,
                'data' => []
            ]);
        } 
    }

    function certificates_put() {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $cert_id = $_POST['cert_id'];
        $cert_name = $_POST['cert_name'];
        $levels = $_POST['levels'];
        $description = $_POST['description'];
        $references = $_POST['references'];
        $authorization_status = $_POST['authorization_status'];

        if(!empty($cert_name) && !empty($levels) && !empty($description) && !empty($references)) {

            $val = $this->Certificates->checkcertname($cert_name, $levels, $cert_id);
            if($val){
                $this->response([
                    'status' => 'FAILED',
                    'message' => 'Certificate already exists!',
                    'code' => 409,
                    'data' => []
                ]);
            }
            else{
                $certData = [
                    'cert_name' => $cert_name,
                    'levels' => $levels,
                    'description' => $description,
                    'references' => $references,
                    'modify_time'=> $curr_date
                ];
    
                $res = $this->Certificates->update($certData, $cert_id);
                if($res){
                    $this->response([
                        'status' => 'SUCCESS_OK',
                        'message' => 'Updated successfully!',
                        'code' => 200,
                        'data' => []
                    ]);
                }
                else{
                    $this->response([
                        'status' => 'UPDATION FAILED',
                        'message' => 'Updation failed',
                        'code' => 400,
                        'data' => []
                    ]);
                }
            }
        }

        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Fields cannot be empty',
                'code' => 400,
                'data' => []
            ]);
        }
    }

    function certificates_delete($role) {
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $cert_id = $_POST['cert_id'];
        $active_status = 0;
        $certData = [
            'active_status' => $active_status,
            'modify_time'=> $curr_date

        ];
        $res = $this->Certificates->delete($cert_id, $certData);
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Updated successfully!',
                'code' => 200,
                'data' => []
            ]);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Updation failed',
                'code' => 400,
                'data' => []
            ]);
        }
    }

    function employee_get($var){

        if($var=='active'){
            $status=1;
            $res = $this->Users->employeedetails($status);
        }
        else if($var=='inactive'){
            $status=0;
            $res = $this->Users->employeedetails($status);
        }
        else{
            $res = $this->Users->getemployeedetail($var);
        }
        
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Fetch successful',
                'code' => 200,
                'data' => $res
            ]);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Failed to retrieve data from the database',
                'code' => 500,
                'data' => []
            ]);
        }
    }

    
    
    function employee_put($id){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $email = $_POST['email'];
        $manager_id=$_POST['manager_id'];
        $username=$_POST['username'];
        $dept_id=$_POST['dept_id'];
        
        $phonenumber=$_POST['phonenumber'];
        if(!empty($manager_id) && !empty($dept_id) && !empty($username) && !empty($phonenumber)){
            $role_id='3';
            if($manager_id==adminManagerId){
                $role_id='1';
            }
            else if($manager_id==managerManagerId){
                $role_id='2';
            }
        $userData = [ 
                    'manager_id' => $manager_id,
                    'dept_id' =>$dept_id,
                    'role_id'=>$role_id,
                    'modify_time'=>$curr_date
                ];
        $profiledata=[
                    'username'=>$username,
                    'phonenumber'=>$phonenumber,
                    'modify_time'=>$curr_date
        ];
        $res=$this->Users->updateemployee($userData,$id,$profiledata);
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'employee details updated succesfully',
                'code' => 200,
                'userprofiledata' => $result,
                'data' => []
            ], SUCCESS_OK);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'employee details not updated',
                'code' => 401,
                'data' => []
            ], SUCCESS_OK);
        }
        }
    }


    function employee_delete($var){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        if($var=='active'){
            $status=0;}
        if($var=='inactive'){
            $status=1;
        }
        $id=$_POST['id'];
        $res=$this->Users->deleteemployee($id,$status,$curr_date);
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Employee deleted succesfully',
                'code' => 200,
                'userprofiledata' => $result,
                'data' => [$res]
            ], SUCCESS_OK);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Employees is active',
                'code' => 401,
                'data' => []
            ], SUCCESS_OK);
        }
    }

    function department_post($rol){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        // $cert_name = mysql_real_escape_string($this->input->post('cert_name'));
        $d_name = $_POST['d_name'];

        if(!empty($d_name)){
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'd_name' => $d_name
            );
            $deptExist = $this->Departments->checkdeptname($d_name);
            if($deptExist){
                $this->response([
                    'status' => 'FAILED',
                    'message' => 'Department already exist, please activate.',
                    'code' => 409,
                    'data' => []
                ]);
            }
            else{
                $deptData = [
                    'd_name' => $d_name,
                    'created_time'=>$curr_date
                ];
                // print_r($deptData);exit;
                $res=$this->Departments->adddepartment($deptData);
                if($res){
                    $this->response([
                        'status' => 'SUCCESS_OK',
                        'message' => 'Department added successfully!',
                        'code' => 200,
                        'data' => []
                    ]);
                }
                else{
                    $this->response([
                        'status' => 'FAILED',
                        'message' => 'Insertion failed',
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

    function department_delete($rol){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $d_id=$_POST['d_id'];
        $res=$this->Departments->deletedepartment($d_id, $curr_date);
        if($res){
            $this->response([
                'status' => 'SUCCESS_OK',
                'message' => 'Department deleted  succesfully',
                'code' => 200,
                'userprofiledata' => $result,
                'data' => []
            ], SUCCESS_OK);
        }
        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Department doesnt deleted',
                'code' => 401,
                'data' => []
            ], SUCCESS_OK);
        }
    }

    function department_put($rol){
        date_default_timezone_set('Asia/Kolkata');
        $curr_date = date('y-m-d h:i:s T', time());
        $_POST = json_decode(file_get_contents('php://input'), true);
        $d_id=$_POST['d_id'];
        $d_name=$_POST['d_name'];

        if(!empty($d_id) && !empty($d_name)) {

            $val = $this->Departments->checkdeptname($d_name);
            if($val){
                $this->response([
                    'status' => 'FAILED',
                    'message' => 'Department already exist, please activate.',
                    'code' => 409,
                    'data' => []
                ]);
            }
            else{
                $deptData = [
                    'd_name' => $d_name,
                    'modify_time'=>$curr_date
                ];
    
                $res = $this->Departments->updatedepartment($d_id, $deptData);
                if($res){
                    $this->response([
                        'status' => 'SUCCESS_OK',
                        'message' => 'Updated successfully!',
                        'code' => 200,
                        'data' => []
                    ]);
                }
                else{
                    $this->response([
                        'status' => 'UPDATION FAILED',
                        'message' => 'Updation failed',
                        'code' => 400,
                        'data' => []
                    ]);
                }
            }
        }

        else{
            $this->response([
                'status' => 'FAILED',
                'message' => 'Fields cannot be empty',
                'code' => 400,
                'data' => []
            ]);
        }
    }
}
