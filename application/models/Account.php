<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        // Load the database library
        $this->load->database();

        $this->userTbl = 'account';
    }

    /*
       * Get rows from the Account table
       */
    function get($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->userTbl);
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

    /*
     * Insert user data
     */
    public function insert($data)
    {
        //add created and modified date if not exists
        if (!array_key_exists("created", $data)) {
            $data['date_created'] = date("Y-m-d H:i:s");
        }

        //insert user data to account table
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    /*
 * Update Account data
 */
    public function update($data, $id)
    {
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id' => $id));

        //return the status
        return $update ? true : false;
    }

    /*
     * Delete Account data
     */
    public function delete($id)
    {
        //update user from account table

        $delete = $this->db->delete($this->userTbl, array('id' => $id));
        //return the status
        return $delete ? true : false;
    }

    function validate_account_with_card_num($card_number, $password)
    {
        $this->db->select('id');
        $this->db->where(array(
            'card_number' => $card_number,
            'password' => md5($password)
        ));

        $query = $this->db->get($this->userTbl);

        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }

    function validate_account_with_makatizen_num($makatizen_num, $password) {
        $this->db->select('id');
        $this->db->where(array(
            'makatizen_number' => $makatizen_num,
            'password' => md5($password)
        ));

        $query = $this->db->get($this->userTbl);

        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }

    function add_token($token, $account_id)
    {
        $data['token'] = $token;
        $data['account_id'] = $account_id;

        if ($this->isAccountRegisterToken($account_id)) {
            $update = $this->db->update("registered_token", $data, array('account_id' => $account_id));
            return $update ? true : false;
        } else {
            $insert = $this->db->insert("registered_token", $data);
            return $insert ? true : false;
        }
    }

    function isAccountRegisterToken($account_id)
    {
        $this->db->select("*");
        $this->db->from("registered_token");
        $this->db->where('account_id', $account_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? true : false;
    }

    function registered_token($account_id)
    {
        if (isset($account_id)) {
            $this->db->select('token');
            $this->db->where('account_id', $account_id);
            $query = $this->db->get('registered_token');

            return ($query->num_rows() > 0) ? $query->row_array() : false;
        }
    }

    function add_rating($data)
    {
        $data['date_created'] = date('Y-m-d H:i:s');
        $insert_result = $this->db->insert('account_ratings', $data);
        return $insert_result ? $this->db->insert_id() : false;
    }

    function rating($account_id)
    {
        $sql = "SELECT rating, COUNT(*) as count FROM `account_ratings` WHERE rated_to = {$account_id} GROUP BY rating";
        $query = $this->db->query($sql);
        return $query ? $query->result_array() : false;
    }

    function check_account_by_name($f_name, $m_initial, $l_name)
    {
        $sql = "SELECT * FROM `account` WHERE `first_name` LIKE \"{$f_name}\" AND `middle_name` LIKE \"{$m_initial}%\" AND `last_name` LIKE \"$l_name\"";
        $query = $this->db->query($sql);
        return $query ? $query->row_array() : false;
    }
}
