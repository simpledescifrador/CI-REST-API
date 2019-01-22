<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Model
{
    private $table_name;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "item";
        $this->load->helper('date');
    }

    public function get($params = null)
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

    public function insert($data)
    {
//        $format = 'DATE_RFC822';
//        $data['published_at'] = date($format, time());
        $insert = $this->db->insert($this->table_name, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id)
    {
        //update user data in users table
        $update = $this->db->update($this->table_name, $data, array('id' => $id));

        //return the status
        return $update ? true : false;
    }

    public function delete($id)
    {
        $delete = $this->db->delete($this->table_name, array('id' => $id));
        //return the status
        return $delete? true : false;
    }

}

/* End of file .php */