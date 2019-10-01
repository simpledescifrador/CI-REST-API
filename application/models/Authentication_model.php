<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    function insert_email_verification($email, $code, $token)
    {

        // Delete if the email is existing
        $this->db->delete('email_verification', array('email' => $email));

        $data = array(
            'email' => $email,
            'code' => $code,
            'token' => $token,
            'date_generated' => date("Y-m-d H:i:s")
        );

        $insert = $this->db->insert('email_verification', $data);
        return $insert ? $this->db->insert_id() : false;
    }

    function verify_email($id)
    {
        //update user data in users table
        $update = $this->db->update('email_verification', array('verified' => 1), array('id' => $id));

        //return the status
        return $update ? true : false;
    }

    function verify_code($code, $email)
    {
        $this->db->select('*');
        $this->db->from('email_verification');
        $this->db->where('email', $email);
        $this->db->where('code', $code);

        $query = $this->db->get();
        return $query? $query->row_array() : false;
    }

    function get_email_verifications($params = array())
    {
        $this->db->select('*');
        $this->db->from('email_verification');
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
}
