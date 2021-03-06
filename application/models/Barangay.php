<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangay extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table_name = "barangay";
	}

    public function get_brgyuser_details($params = null)
    {
        $this->db->select('*');
        $this->db->from("brgy_users");
        if ($params != null) {
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
                } else{
                    $query = $this->db->get();
                    $result = ($query->num_rows() > 0)?$query->result_array():false;
                }
            }
        } else {
            //get all found item
            $query = $this->db->get();
            $result = $query->result_array();
        }


        //return fetched data
        return $result;
    }
    public function get($params = null) {
        $this->db->select('*');
        $this->db->from($this->table_name);
        if ($params != null) {
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
                } else{
                    $query = $this->db->get();
                    $result = ($query->num_rows() > 0)?$query->result_array():false;
                }
            }
        } else {
            //get all found item
            $query = $this->db->get();
            $result = $query->result_array();
        }


        //return fetched data
        return $result;
    }
    public function insert($item)
    {
        //insert lost item ata to lost item table
        $insert = $this->db->insert($this->table_name, $item);

        //return the status
        return $insert?$this->db->insert_id():false;
    }
    public function update($data, $id)
    {
        $update = $this->db->update($this->table_name, $data, array('id' => $id));

        //return the status
        return $update ? true : false;
    }
    public function delete($id)
    {
        $delete = $this->db->delete($this->table_name, array('id' => $id));
        //return the status
        return $delete ? true : false;
    }
     //admin functions
    public function get_brgy($d_number){
        $this->db->select("*");
        $this->db->from("barangay");
        $this->db->where('district_no = ', $d_number);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function get_bDetails($brgy_id){
        $this->db->select("*");
        $this->db->from("barangay");
        $this->db->where('id = ', $brgy_id);
        $query = $this->db->get();

        return $query->result_array();
    }
}

/* End of file Barangay.php */
/* Location: ./application/models/Barangay.php */
