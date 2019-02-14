<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Found_item extends CI_Model
{
    private $table_name;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "found_item";
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
            //get all found item
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

    public function count_found()
    {

        $query = $this->db->query('SELECT * FROM found_item');
        return $query->num_rows();
    }
}

/* End of file .php */
