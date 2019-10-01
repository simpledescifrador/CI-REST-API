<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model
{   private $tbl_transaction;
    public function __construct()
    {
        parent::__construct();
        $this->tbl_transaction = 'transaction';
    }
    function insert_transaction($data)
    {
        $insert = $this->db->insert($this->tbl_transaction, $data);
        return $insert? $this->db->insert_id() : false;
    }

    function get_transaction($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->tbl_transaction);
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

    function update_status($transaction_id, $status)
    {
        $this->db->where('id', $transaction_id);
        $update = $this->db->update($this->tbl_transaction, array('status' => $status));
        $sql = "SELECT `item_id` FROM `transaction` WHERE `id` = {$transaction_id}";
        if ($update) {
            $item_id = $this->db->query($sql);
        }
        return $update? $item_id->row_array() : false;
    }
    function account_transactions($account_id){
        $sql = "SELECT * FROM `view_transactions` WHERE `item_account_id` = {$account_id}";
        $query = $this->db->query($sql);
        return $query? $query->result_array() : 0;
    }

    //new Transaction functions
    function insert_confirmed_transaction($data)
    {
        $insert = $this->db->insert('transaction_confirmed', $data);
        return $insert? $this->db->insert_id() : false;
    }

    function get_transaction_confirmed($params = array())
    {
        $this->db->select('*');
        $this->db->from('transaction_confirmed');
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
    function get_transaction_meetup($params = array())
    {
        $this->db->select('*');
        $this->db->from('transaction_meetup');
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

    function insert_transaction_meetup($data)
    {
        $insert = $this->db->insert('transaction_meetup', $data);
        return $insert? $this->db->insert_id() : false;
    }

    function update_transaction_meetup($data, $id)
    {
        $update = $this->db->update('transaction_meetup', $data, array('id' => $id));

        //return the status
        return $update ? true : false;
    }

    //admin functions
    public function get_confirmed_transaction(){
        $this->db->select('*');
        $this->db->from('v_confirmed_tr');
        $query = $this->db->get();
        $result = $query->result_array();
    }
    public function recent_transactions_items(){
    $sql = "SELECT \n"
        . "a.id as transaction_id, a.item_id, a.date_confirmed as transaction_confirmed,\n"
        . "b.type as post_type, b.published_at as date_posted, b.report_type as item_type,\n"
        . "c.item_name, c.date_found, c.item_category, c.brand, c.item_color, c.item_description,c.location_id,\n"
        . "d.id as account_id, d.first_name, d.middle_name,d.last_name\n"
        . "FROM\n"
        . "transaction_confirmed a\n"
        . "JOIN item b ON(a.item_id = b.item_id)\n"
        . "JOIN found_item c ON(a.item_id = c.id)\n"
        . "JOIN account d ON(b.account_id = d.id)\n"
        . "WHERE b.type = 'Found'\n"
        . "ORDER BY a.date_confirmed DESC\n"
        . "LIMIT 3";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function recent_transactions_pets(){
    $sql = "SELECT \n"
        . "a.id as transaction_id, a.item_id, a.date_confirmed as transaction_confirmed,\n"
        . "b.type as post_type, b.published_at as date_posted, b.report_type as item_type,\n"
        . "c.pet_name, c.date as date_found, c.breed, c.pet_condition, c.description,c.location_id,\n"
        . "d.id as account_id, d.first_name, d.middle_name,d.last_name\n"
        . "FROM\n"
        . "transaction_confirmed a\n"
        . "JOIN item b ON(a.item_id = b.item_id)\n"
        . "JOIN pets c ON(a.item_id = c.id)\n"
        . "JOIN account d ON(b.account_id = d.id)\n"
        . "WHERE b.type = 'Found'\n"
        . "ORDER BY a.date_confirmed DESC\n"
        . " LIMIT 3";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function recent_transactions_persons(){
    $sql = "SELECT \n"
        . "a.id as transaction_id, a.item_id, a.date_confirmed as transaction_confirmed,\n"
        . "b.type as post_type, b.published_at as date_posted, b.report_type as item_type,\n"
        . "c.name, c.date as date_found, c.age_group, c.age_range,c.sex, c.description,c.location_id,\n"
        . "d.id as account_id, d.first_name, d.middle_name,d.last_name\n"
        . "FROM\n"
        . "transaction_confirmed a\n"
        . "JOIN item b ON(a.item_id = b.item_id)\n"
        . "JOIN person c ON(a.item_id = c.id)\n"
        . "JOIN account d ON(b.account_id = d.id)\n"
        . "WHERE b.type = 'Found'\n"
        . "ORDER BY a.date_confirmed DESC"
        . " LIMIT 3";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}