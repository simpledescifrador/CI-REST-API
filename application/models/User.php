<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

        $this->userTbl = 'users';
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->userTbl);
        //fetch data by conditions
        if(array_key_exists('conditions',$params)){
            foreach($params['conditions'] as $key => $value){
                $this->db->where($key,$value);
            }
        }

        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }

            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():false;
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():false;
            }
        }

        //return fetched data
        return $result;
    }

    /*
     * Insert user data
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }

        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        return $insert?$this->db->insert_id():false;
    }

    /*
     * Update user data
     */
    public function update($data, $id){
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id'=>$id));

        //return the status
        return $update?true:false;
    }

    /*
     * Delete user data
     */
    public function delete($id){
        //update user from users table

        $delete = $this->db->delete('users',array('id'=>$id));
        //return the status
        return $delete?true:false;
    }


    /***** getting the type of user */
    public function user_type($data = array())
    {
        $condition = "username =" . "'" . $data['username'] ."'";
			$this->db->select('*');
			$this->db->from($this->user);
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
   //admin functions
    public function getUsers($brgy_id){
            $this->db->select("*");
            $this->db->from("users");
            $this->db->where('brgy_id = ', $brgy_id);
            $query = $this->db->get();
            return $query->result_array();
    }

    public function getActiveUsers(){
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('status LIKE "new"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function countActiveUsers(){
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('status LIKE "new"');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getReportedUsers(){
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('status LIKE "reported"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getBlockedUsers(){
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('status LIKE "banned"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function mobileUsers(){
        $this->db->select('*');
        $this->db->from('account');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function mobileUserDetail($id){
        $this->db->select('*');
        $this->db->from('account');
        $this->db->where('id = ', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function mobileUserRating($id){
        $this->db->select('*');
        $this->db->from('account_ratings');
        $this->db->where('rated_to = ', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function mobileUserPosts($id){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('account_id = ', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function test_register($data){ //test if the account being registered returns an existing data
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('name LIKE "'.$data['name'].'" AND username LIKE "'. $data['username'].'"');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function insertBrgyUser($data){
        $this->db->insert('users', $data);
    }
    public function insertB_User($data_b){
        $this->db->insert('brgy_users', $data_b);
    }
    public function getB_id($data){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('name LIKE "'.$data['name'].'" AND username LIKE "'. $data['username'].'"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function updateB_id($data){
        $this->db->where('email LIKE "'.$data['email'].'"');
        $this->db->update('brgy_users', array('brgy_account_id'=>$data['brgy_account_id']));

    }
    public function deleteBrgy_user($data){
        $this->db->delete('users');
        $this->db->where('id = "'.$data.'"');
    }
    public function recentBrgyActs(){
        $this->db->select('*');
        $this->db->from('brgy_users');
        $this->db->where('date_created LIKE "'.date('Y-m-d').'%"');
        $this->db->order_by('date_created', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

}
