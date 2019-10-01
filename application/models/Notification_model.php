<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    private $tbl_notification;
    public function __construct()
    {
        parent::__construct();
        $this->tbl_notification = 'mobile_notifications';
    }
    function get($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->tbl_notification);
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

    function add_notification($data = null)
    {
        if ($data != null) {
            $data['created_at'] = date("Y-m-d H:i:s");
            $result = $this->db->insert($this->tbl_notification, $data);
            //return the status
            return $result ? $this->db->insert_id() : false;
        } else {
            return false;
        }
    }

    function set_notification_unread($id)
    {
        /* Check if required parameter have value */
        if (isset($id)) {

            $this->db->where('id', $id);
            $result_update = $this->db->update($this->tbl_notification, array('is_read' => 'No'));

            return $result_update? true : false;
        } else {
            return false;
        }
    }

    function set_notification_read($id)
    {
        /* Check if required parameter have value */
        if (isset($id)) {

            $this->db->where('id', $id);
            $result_update = $this->db->update($this->tbl_notification, array('is_read' => 'Yes'));

            return $result_update? true : false;

        } else {
            return false;
        }
    }

    function delete_notification($id)
    {
        if (isset($id)) {
            $this->db->where('id', $id);
            $result_delete = $this->db->delete($this->tbl_notification);
            return $result_delete? true : false;
        } else {
            return false;
        }
    }
}