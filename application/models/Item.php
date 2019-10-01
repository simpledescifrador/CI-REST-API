<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Model
{
    private $table_name;
    private $time_zone;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "item";
        $this->load->helper('date');
        $this->time_zone = 'Asia/Manila';
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

    public function insert($data)
    {
        $data['published_at'] = date("Y-m-d H:i:s");
        $data['date_modified'] = date("Y-m-d H:i:s");
        $insert = $this->db->insert($this->table_name, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function insert_item_images($image_details)
    {
        $this->db->insert_batch("item_images", $image_details);
    }

    public function update($data, $id)
    {
        $data['date_modified'] = date("Y-m-d H:i:s");
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

    public function update_status($id, $new_status)
    {
        $data = array('status' => $new_status, 'date_modified' => date("Y-m-d H:i:s")); //set new value
        $this->db->where('id', $id); //set condition
        $update_result = $this->db->update($this->table_name, $data); //update table

        return $update_result ? true : false;
    }

    public function valid_matchmaking_rows_count($report_type, $account_id)
    {
        if (isset($report_type, $account_id)) {
            $this->db->where(array(
                'type' => 'Lost',
                'status' => 'New',
                'report_type' => $report_type,
                'account_id !=' => $account_id
            ));
            $this->db->from($this->table_name);
            /* Return number of rows */
            return $this->db->count_all_results();
        }
        return false;
    }

    public function valid_matchmaking_item_id($report_type, $account_id)
    {
        if (isset($report_type, $account_id)) {
            $this->db->select('item_id');
            $this->db->where(array(
                'type' => 'Lost',
                'status' => 'New',
                'report_type' => $report_type,
                'account_id !=' => $account_id
            ));
            $this->db->from($this->table_name);
            $query = $this->db->get();


            return ($query->num_rows() > 0) ? $query->result_array() : false;
        }
    }

    function get_item_id($conditions)
    {
        $this->db->select('id');
        $this->db->where($conditions);
        $this->db->from($this->table_name);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : false;
    }

    function register_item_id_qrcode($itemId)
    {
        $data['item_id'] = $itemId;
        $data['generated_code'] = md5(date("Y-m-d H:i:s"));
        $data['date_generated'] = date("Y-m-d H:i:s");
        $query = $this->db->insert('item_qrcode', $data);
        return $query ? $data['generated_code'] : false;
    }

    function get_item_data_with_qrcode($qrcode)
    {
        if (isset($qrcode)) {
            $this->db->select('*');
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $this->db->from('item_qrcode');
            $this->db->where('generated_code', $qrcode);
            $query = $this->db->get();

            return $query ? $query->row_array() : false;
        }
    }

    function get_recent_posts($limit)
    {
        $sql = "SELECT * FROM `item` WHERE `status` = 'New' ORDER BY `id` DESC LIMIT {$limit}";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : 0;
    }

    function fetch_lost_pt($keyword, $data)
    {
        $this->db->select("*");
        $this->db->from('view_lost_pt');

        if (array_key_exists('conditions', $data)) {
            foreach ($data['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //set start and limit
        if (array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit'], $data['start']);
        } elseif (!array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit']);
        }

        if ($keyword != '') {
            $this->db->like('pt_name', $keyword);
            $this->db->or_like('pt_category', $keyword);
            $this->db->or_like('pt_brand', $keyword);
            $this->db->or_like('pt_color', $keyword);
            $this->db->or_like('pt_description', $keyword);
        } else {

        }
        $query = $this->db->get();

        return $query->result_array();

    }

    function fetch_found_pt($keyword, $data)
    {

        $this->db->select("*");
        $this->db->from('view_found_pt');
        if (array_key_exists('conditions', $data)) {
            foreach ($data['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //set start and limit
        if (array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit'], $data['start']);
        } elseif (!array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit']);
        }

        if ($keyword != '') {
            $this->db->like('pt_name', $keyword);
            $this->db->or_like('pt_category', $keyword);
            $this->db->or_like('pt_brand', $keyword);
            $this->db->or_like('pt_color', $keyword);
            $this->db->or_like('pt_description', $keyword);
        } else {

        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function fetch_pets($keyword, $data)
    {
        $this->db->select("*");
        $this->db->from('view_pets');
        if (array_key_exists('conditions', $data)) {
            foreach ($data['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //set start and limit
        if (array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit'], $data['start']);
        } elseif (!array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit']);
        }

        if ($keyword != '') {
            $this->db->like('pet_breed', $keyword);
            $this->db->or_like('pet_type', $keyword);
            $this->db->or_like('pet_description', $keyword);
            $this->db->or_like('pet_name', $keyword);
        } else {

        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function fetch_persons($keyword, $data)
    {
        $this->db->select("*");
        $this->db->from('view_persons');
        if (array_key_exists('conditions', $data)) {
            foreach ($data['conditions'] as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //set start and limit
        if (array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit'], $data['start']);
        } elseif (!array_key_exists("start", $data) && array_key_exists("limit", $data)) {
            $this->db->limit($data['limit']);
        }

        if ($keyword != '') {
            $this->db->like('person_age_group', $keyword);
            $this->db->or_like('person_age_range', $keyword);
            $this->db->or_like('person_description', $keyword);
            $this->db->or_like('person_name', $keyword);
        } else {

        }
        $query = $this->db->get();
        return $query->result_array();

    }

    function get_item_images($itemId) {
        $this->db->select("*");
        $this->db->from('item_images');
        $this->db->where('item_id', $itemId);
        $query = $this->db->get();
        return $query->result_array();
    }

    //admin functions
    public function count_lost(){
        $query = $this->db->query("SELECT * FROM item WHERE type = 'lost' AND status = 'New'");

        return $query->num_rows();
    }
    public function count_found(){
        $query = $this->db->query("SELECT * FROM item WHERE type = 'found' AND status = 'New'");

        return $query->num_rows();
    }
    public function count_matched(){
        $query = $this->db->query("SELECT * FROM mobile_notifications WHERE type = 'Matchmaking'");

        return $query->num_rows();
    }
    public function count_returned(){
        $query = $this->db->query("SELECT * FROM item WHERE type = 'found' AND status = 'returned'");

        return $query->num_rows();
    }
    public function get_items(){
        $this->db->select('*');
        $this->db->from('item');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_losts(){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('type = "Lost"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function count_pets(){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('report_type LIKE "Pet"');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_persons(){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('report_type LIKE "Person"');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_personal_items(){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('report_type LIKE "Personal Thing"');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_found(){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('type = "Found"');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_specific_item($item_id){
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('id LIKE', $item_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function lost_graph_data($date){
        $sql = "SELECT * FROM item WHERE published_at LIKE '".$date."%' AND type LIKE 'lost'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function found_graph_data($date){
        $sql = "SELECT * FROM item WHERE published_at LIKE '".$date."%' AND type LIKE 'found'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    public function get_matched_items(){
        $sql = "SELECT\n"
                . "*\n"
                . "FROM\n"
                . "mobile_notifications a \n"
                . "JOIN v_founditems b ON(a.ref_id = b.item_id)\n"
                . "WHERE a.type = \"Matchmaking\"";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_matched_pets(){
        $sql = "SELECT\n"
                . "*\n"
                . "FROM\n"
                . "mobile_notifications a \n"
                . "JOIN v_pets b ON(a.ref_id = b.item_id)\n"
                . "WHERE a.type = \"Matchmaking\" AND b.type = \"Found\"";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_matched_persons(){
        $sql = "SELECT\n"
                . "*\n"
                . "FROM\n"
                . "mobile_notifications a \n"
                . "JOIN v_person b ON(a.ref_id = b.item_id)\n"
                . "WHERE a.type = \"Matchmaking\" AND b.item_type = \"Found\"";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_lost_brgy_items()
    {
        $sql = "SELECT * FROM `item` WHERE `reported_by` = 'Brgy User' AND `type` = 'Lost'";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_found_brgy_items()
    {
        $sql = "SELECT * FROM `item` WHERE `reported_by` = 'Brgy User' AND `type` = 'Found'";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_brgy_lost_check($date, $item_id)
    {
        $sql = "SELECT * FROM `item` WHERE `id` = " . $item_id . " AND `published_at` LIKE '". $date ."%'  AND `type` = 'Lost' AND `reported_by` = 'Brgy User'";

        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    function get_brgy_found_check($date, $item_id)
    {
        $sql = "SELECT * FROM `item` WHERE `id` = " . $item_id . " AND  `published_at` LIKE '". $date ."%'  AND `type` = 'Found' AND `reported_by` = 'Brgy User'";

        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    function item_date_check($date, $item_id)
    {
        $sql = "SELECT * FROM `item` WHERE `id` = " . $item_id . " AND  `published_at` LIKE '". $date ."%'";
        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    function item_date_week_check($start_date, $end_date, $item_id, $type)
    {
        $sql = "SELECT * FROM `item` WHERE `id` = " . $item_id . " AND `type` = '". $type ."' AND  `published_at` BETWEEN '". $start_date ."'  AND '". $end_date ."'";

        $query = $this->db->query($sql);

        return $query->num_rows();
    }

    function date_week_check($start_date, $end_date, $item_id)
    {
        $sql = "SELECT * FROM `item` WHERE `id` = " . $item_id . " AND `published_at` BETWEEN '". $start_date ."' AND '". $end_date ."'";

        $query = $this->db->query($sql);

        return $query->num_rows();
    }

}

/* End of file .php */
