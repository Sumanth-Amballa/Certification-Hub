<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require ( APPPATH . '/libraries/REST_Controller.php' );

class Departmentget extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model("Departments");        
    }

    function department_get($var){

        if($var=='active'){
            $status=1;
            $res=$this->Departments->departmentdetails($status);
        }
        else if($var=='inactive'){
            $status=0;
            $res=$this->Departments->departmentdetails($status);
        }
        else{
            $res=$this->Departments->departmentdetail($var);
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
}    