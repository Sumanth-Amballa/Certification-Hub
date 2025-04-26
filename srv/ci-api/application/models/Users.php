<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->users_table = 'users';
        $this->usersprofile_table = 'user_profile';
    }

    function getDetails()
   {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('active_status',1);
        $query = $this->db->get();
        $obj->user=count($query->result());
        $this->db->select('cert_id');
        $this->db->from('certificates');
        $this->db->where('active_status',1);
        $query = $this->db->get();
        $obj->courses=count($query->result());
        $this->db->distinct();
        $this->db->select('references');
        $this->db->from('certificates');
        $this->db->where('active_status',1);
        $query = $this->db->get();
        $obj->platforms=count($query->result());
        return $obj;
   }

    function login_validate($email,$password){
        $this->db->select("AES_DECRYPT(email, '".secret."'),password,role_id,id", FALSE);
        $this->db->from($this->users_table);
        $query=$this->db->get();
        $user=$query->result_array();
        foreach($user as $key => $value){
            $arr = array_values($value);
            $res = array($arr[2], $arr[3]);
            if($arr[0] == $email && $arr[1] == $password){
                // print_r($res);
                return $res;
            }
        }
        return 0;
    }
    function registration_validate($email){
        $this->db->select("AES_DECRYPT(email, '".secret."')", false);
        $this->db->from($this->users_table);
        $query=$this->db->get();
        $user=$query->result_array();
        foreach($user as $key => $value){
            $arr = array_values($value);
            if($arr[0] == $email){
                return 1;
            }
        }
        return 0;
    }

    function checkoldpassword($id, $oldpassword){
        $this->db->select("AES_DECRYPT(email, '".secret."') as email,password", FALSE);
        $this->db->from($this->users_table);
        $this->db->where("id", $id);
        $query=$this->db->get();
        $res=$query->row_array();
        if($res['password'] == $oldpassword){
            return $res['email'];
        }
        return 0;
    }

    function insert($plainEmail, $manager_id, $dept_id, $password, $role_id, $curr_date){
        $this->db->trans_begin();
        $this->db->set('email', "AES_ENCRYPT('". $plainEmail. "',". "'". secret . "')", false);
        $this->db->set('manager_id', $manager_id);
        $this->db->set('dept_id', $dept_id);
        $this->db->set('role_id', $role_id);
        $this->db->set('password', md5($password));
        $this->db->set('created_time', $curr_date);
        $insert = $this->db->insert($this->users_table);
        $u_id = $this->db->insert_id();
        $this->db->insert($this->usersprofile_table, array('user_id'=>$u_id));
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return 1;
        }
        else{
            $this->db->trans_rollback();
            return 0;
        }
    }
    
    
    function forgotpassword($email){
        $this->db->select("AES_DECRYPT(email, '".secret."')", false);
        $this->db->from($this->users_table);
        $query=$this->db->get();
        $user=$query->result_array();
        foreach($user as $key => $value){
            $arr = array_values($value);
            if($arr[0] == $email){
                return 1;
            }
        }
        return 0;
    }

    function updatepassword($email,$password, $curr_date){
        $data=array(
            'password'=>$password,
            'modify_time'=>$curr_date
        );
        $this->db->where('email',"AES_ENCRYPT('". $email. "',". "'". secret . "')", false);
        return $this->db->update($this->users_table,$data);

        
    }
    
    function employeedetails($status){
        $this->db->select("AES_DECRYPT(users.email, '".secret."') as email,users.id,users.manager_id,user_profile.username,user_profile.phonenumber,user_profile.dob,department.d_name", FALSE);
        $this->db->from('users');
        $this->db->join('user_profile','users.id=user_profile.user_id','inner');
        $this->db->join('department','users.dept_id=department.d_id','inner');
        $this->db->where("users.active_status",$status);
        $this->db->where("users.role_id !=",1);
        $query=$this->db->get();
        $res=$query->result();
        return $res;
    }
    function deleteemployee($id,$status,$curr_date){
        $this->db->trans_begin();
        $data=[
            'active_status'=>$status,
            'modify_time'=>$curr_date
        ];
        $updateuser= $this->db->update($this->users_table,$data,array('id'=>$id));
        $updateprofile=$this->db->update($this->usersprofile_table,$data,array('user_id'=>$id));
        if ($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return 1;
        }
        else{
            $this->db->trans_rollback();
            return 0;
        }
    }
    function updateemployee($data,$id,$profiledata){
        $this->db->trans_begin();
        $updateuser=$this->db->update($this->users_table,$data,array('id'=>$id));
        $updateprofile=$this->db->update($this->usersprofile_table,$profiledata,array('user_id'=>$id));
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return 1;
        }
        else{
            $this->db->trans_rollback();
            return 0;
        }
    }
    
    function getemployeedetail($id){
        $this->db->select("AES_DECRYPT(users.email, '".secret."') as email,users.manager_id,user_profile.username,user_profile.phonenumber,department.d_name", FALSE);
        $this->db->from('users');
        $this->db->join('user_profile','users.id=user_profile.user_id','inner');
        $this->db->join('department','users.dept_id=department.d_id','inner');
        $this->db->where("users.id", $id);
        $query=$this->db->get();
        $res=$query->row_array();
        return $res;
    }
}