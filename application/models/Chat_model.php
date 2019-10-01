<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    private $tbl_chat_rooms;
    private $tbl_chat_participants;
    private $tbl_chat_messages;

    public function __construct()
    {
        parent::__construct();
        $this->tbl_chat_rooms = "chat_rooms";
        $this->tbl_chat_participants = "chat_participants";
        $this->tbl_chat_messages = "chat_messages";
    }

    function get_chat_rooms($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->tbl_chat_rooms);
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
    function add_chat_room($type)
    {

        $insert= $this->db->insert($this->tbl_chat_rooms, array('type' => $type, 'created_at' => date('Y-m-d H:i:s')));
        return $insert? $this->db->insert_id() : false; /* Return Insert ID */
    }

    function add_item_chat_room($item_id)
    {

        $insert= $this->db->insert($this->tbl_chat_rooms, array('item_id' => $item_id, 'type' => 'Single', 'created_at' => date('Y-m-d H:i:s')));
        return $insert? $this->db->insert_id() : false; /* Return Insert ID */
    }

    function get_chat_participants($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->tbl_chat_participants);
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
            $query = $this->db->get();
            $result = $query->result_array();
        }
        //return fetched data
        return $result;
    }
    function add_chat_participant($account_id, $chat_room_id)
    {
        $data = array(
            'account_id' => $account_id ,
            'chat_room_id' => $chat_room_id
        );

        $insert= $this->db->insert($this->tbl_chat_participants, $data);
        return $insert? $this->db->insert_id() : false; /* Return Insert ID */
    }
    function get_chat_messages($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->tbl_chat_messages);
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

    function add_chat_message($chat_room_id, $sender_id, $message)
    {
        $data = array(
            'chat_room_id' => $chat_room_id,
            'account_id' => $sender_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert= $this->db->insert($this->tbl_chat_messages, $data);
        return $insert? $this->db->insert_id() : false; /* Return Insert ID */
    }

    function chat_room_last_message($chat_room_id)
    {
        $sql = "SELECT * FROM `chat_messages` WHERE `chat_room_id` = {$chat_room_id} ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query? $query->row_array() : false;
    }



}