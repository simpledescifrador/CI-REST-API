<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model
{
    private $table_name;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "person";
    }

    function get($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->table_name);
        //fetch data by conditions
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

        //return fetched data
        return $result;
    }

    function add_reported_person($person_data)
    {
        $query_result = $this->db->insert($this->table_name, $person_data);

        //return the status
        return $query_result ? $this->db->insert_id() : false;
    }

    // admin functions
 
}
