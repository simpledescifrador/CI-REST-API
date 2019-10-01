<?php

class Login_model extends CI_model{


    public function __construct()
    {
        parent::__construct();
        $this->tbl_name = 'users';
    }

    public function login_test($data = array()){
        $query = $this->db->query("Select * from users WHERE username = '" . $data['username'] . "' AND password =  '" . $data['password'] . "';");

        if($query->num_rows() == 1 )
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function readAdminInfo($username)
		{
			$condition = "username =" . "'" . $username . "'";
			$this->db->select('*');
			$this->db->from($this->tbl_name);
			$this->db->where($condition);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() == 1)
			{
				return $query->result();
			} else
				{
					return FALSE;
				}
        }

    public function current_user(){
        //$query = "SELECT * FROM user WHERE username like ";
    }

    public function user_info($brgy_id){
        //$query = "SELECT * FROM user WHERE username like ";
         $this->db->select("*");
        $this->db->from("barangay");
        $this->db->where(array("id" => $brgy_id));

        $query = $this->db->get();

        return $query->result_array();
    }
}