<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lost_item extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        // Load the database library
        $this->load->database();
        $this->table_name = 'lost_item';
    }

    public function get($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        if ($params != null) {
            if (array_key_exists('conditions', $params)) {
                foreach ($params['conditions'] as $key => $value) {
                    $this->db->where($key, $value);
                }
            }

            if (array_key_exists("id", $params)) {
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            } else {
                //set start and limit
                if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                    $this->db->limit($params['limit'], $params['start']);
                } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                    $this->db->limit($params['limit']);
                }

                if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
                    $result = $this->db->count_all_results();
                } elseif (array_key_exists("returnType", $params) && $params['returnType'] == 'single') {
                    $query = $this->db->get();
                    $result = ($query->num_rows() > 0) ? $query->row_array() : false;
                } else {
                    $query = $this->db->get();
                    $result = ($query->num_rows() > 0) ? $query->result_array() : false;
                }
            }
        } else {
            //get all lost item
            $query = $this->db->get();
            $result = $query->result_array();
        }
        //return fetched data
        return $result;
    }

    public function insert($item)
    {
        $item['date_created'] = date("Y-m-d H:i:s");
        $item['date_modified'] = date("Y-m-d H:i:s");
        //insert lost item ata to lost item table
        $insert = $this->db->insert($this->table_name, $item);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id)
    {
        $item['date_modified'] = date("Y-m-d H:i:s");

        //update user data in users table
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


    
    // barangay custom model
    public function view_lost(){ #view all lost items
        $this->db->select("*");
        $this->db->from("v_lostitems");
        $this->db->where("post_status = 'New'");
        $query = $this->db->get();

        return $query->result_array();
    }

    public function recently_lost(){
        $this->db->select("*");
        $this->db->from("v_lostitems");
        $this->db->where("post_status = 'New'");
        $this->db->order_by('date_created', 'desc');
        $this->db->limit(9);
        $query = $this->db->get();

        return $query->result_array();
    }
    public function lost_details($item_id){
            $this->db->select("*");
            $this->db->from("v_lostitems");
            $this->db->where('item_id = ', $item_id);
            $query = $this->db->get();

            return $query->result_array();
    }

    //admin custom model
    public function lost_pets(){ //get newly posted lost pets
        $this->db->select("*");
        $this->db->from("v_pets");
        $this->db->where("type = 'Lost' AND post_status = 'New'");

        $query = $this->db->get();

        return $query->result_array();
    }

    public function lost_pet_details($item_id){
            $this->db->select("*");
            $this->db->from("v_pets");
            $this->db->where('item_id = ', $item_id);
            $query = $this->db->get();

            return $query->result_array();
    }
    public function lost_person_details($item_id){
            $this->db->select("*");
            $this->db->from("v_person");
            $this->db->where('item_id = ', $item_id);
            $query = $this->db->get();

            return $query->result_array();
    }

    public function lost_person(){ //get newly posted lost persons
        $this->db->select("*");
        $this->db->from("v_person");
        $this->db->where("report_type = 'Lost' AND item_status = 'New'");
        $query = $this->db->get();

        return $query->result_array();
    }

}

/* End of file .php */
