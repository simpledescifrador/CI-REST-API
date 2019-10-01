<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ChatController extends REST_Controller
{
    private $header;
    private $url;

    public function __construct() {
        parent::__construct();
        define("API_KEY", "AAAAAkQ0gvI:APA91bEfH-G9z8HQur-sE8Y3XGjZbBH3aXqAI92t5FTuwvmDK1iItMfsx--tdmiv-YeRp4_CqHoye2g67dUZaXLmCgxZIxsHKHyZUxR2kgEpWwEecbzfSjXrToeDmmrDZsmN6f_T1SRn");

        $this->url = "https://fcm.googleapis.com/fcm/send";
        $this->header = array(
            'Content-Type:application/json',
            'Authorization:key=' . API_KEY
        );

        /* Load all required models and libraries here */
        $this->load->model('chat_model');
        $this->load->model('account');

    }
    public function create_chat_room_post()
    {
        $account1 = $this->post('account1_id');
        $account2 = $this->post('account2_id');
        $participants = array($account1, $account2);
        $type = $this->post('type');

        if (isset($account1, $account2, $type)) {
            switch ($type) {
                case 'Single':
                    $is_chat_room_exist = false;
                    /* Check if the participants has already have chat room */
                    $account1_result = $this->chat_model->get_chat_participants(array(
                        'conditions' => array(
                            'account_id' => $account1
                        )
                    ));
                    $account2_result = $this->chat_model->get_chat_participants(array(
                        'conditions' => array(
                            'account_id' => $account2
                        )
                    ));
                    $result1 = $account1_result != null? count($account1_result) : 0;
                    $result2 = $account2_result != null? count($account2_result) : 0;

                    for ($x=0; $x < $result1; $x++) {
                        for ($z=0; $z < $result2; $z++) {
                            if ($account1_result[$x]['chat_room_id'] === $account2_result[$z]['chat_room_id']) {
                                $is_chat_room_exist = true;
                                $chat_room_id = $account1_result[$x]['chat_room_id'];
                                break;
                            }
                        }
                    }

                    if (!$is_chat_room_exist) {
                        /* Create new chat room */
                        $chat_room_id =  $this->chat_model->add_chat_room($type);
                        if ($chat_room_id) {
                            $insert_success = false;
                            foreach ($participants as $account_id) {
                                $result = $this->chat_model->add_chat_participant($account_id, $chat_room_id);

                                if ($result == true) {
                                    $insert_success = true;
                                }
                            }

                            if ($insert_success == true) {
                                $chat_room_data = $this->chat_model->get_chat_rooms(array('id' => $chat_room_id));
                                $this->response(array(
                                    'success' => true,
                                    'chat_room_data' => $chat_room_data
                                ), REST_Controller::HTTP_OK);
                            }
                        } else {
                            $this->response("Failed to create a chat room", REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        //TODO Get Chat Room data
                        $chat_room_data = $this->chat_model->get_chat_rooms(array('id' => $chat_room_id));
                        $this->response(array(
                            'success' => true,
                            'chat_room_data' => $chat_room_data
                        ), REST_Controller::HTTP_OK);
                    }
                    break;
                case 'Group':
                    /* for future  */
                    break;
            }
        } else {
            $this->response("Account Participants is required and chat type", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function add_message_post()
    {
        $chat_room_id = $this->post('chat_room_id');
        $sender_id = $this->post('account_id');
        $message = $this->post('message');
        if (isset($chat_room_id, $sender_id, $message)) {
            /* Check if the sender is chat room participants */
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'chat_room_id' => $chat_room_id,
                'account_id' => $sender_id
            );
            $is_participant = $this->chat_model->get_chat_participants($con);

            if ($is_participant) {
                /* The sender is participant */
                $result_success = $this->chat_model->add_chat_message($chat_room_id, $sender_id, $message);

                if ($result_success) {
                    /* Successfully add message now send it to the participants of chat_room */
                    // Check the chat room  type
                    $chat_room_data = $this->chat_model->get_chat_rooms(array('id' => $chat_room_id));
                    switch ($chat_room_data['type']) {
                        case 'Single':
                            $con['returnType'] = 'single';
                            $con['conditions'] = array(
                                'chat_room_id' => $chat_room_id,
                                'account_id !=' => $sender_id
                            );
                            $receiver = $this->chat_model->get_chat_participants($con);
                            $receiver_data = $this->account->get(array('id' => $receiver['account_id']));
                            /* Get the receiver token */
                            $token = $this->account->registered_token($receiver['account_id']);
                            /* Get Message Data */
                            $message_data = $this->chat_model->get_chat_messages(array('id' => $result_success));

                            if (isset($token, $message_data['id'])) {
                                /* Prepare the payloads for notification */
                                $sender_data = $this->account->get(array('id' => $sender_id));
                                $notif['title'] = $sender_data['first_name'] . " " . $sender_data['last_name'] . " send a message";
                                $notif['content'] = $message_data['message'];
                                $payloads = array(
                                    "to" => $token['token'],
                                    "notification" => array(
                                        "title" => $notif['title'],
                                        "body" => $notif['content'],
                                        "click_action" => "ChatMessage"
                                    ),
                                    "data" => array(
                                        "title" => $notif['title'],
                                        "content" => $notif['content'],
                                        'message_id' => $message_data['id'],
                                        'chat_room_id' => $message_data['chat_room_id'],
                                        'sender_id' => $message_data['account_id'],
                                        'sender_name' => $sender_data['first_name'] . " " . $sender_data['last_name'],
                                        'message' => $message_data['message'],
                                        'message_time' => $message_data['created_at'],
                                        'receiver_id' => $receiver['account_id'],
                                        'receiver_name' => $receiver_data['first_name'] . " " . $receiver_data['last_name'],
                                        'account_image' => $sender_data['image']
                                    )
                                );

                                $this->send_notification($payloads); /* Send the notification */
                                $this->response(array(
                                    'message_sent' => true,
                                    'message_time' => $message_data['created_at']
                                ), REST_Controller::HTTP_OK);
                            }
                            break;
                        case 'Group':
                            /* For Future Capabilities of Chat */
                            break;
                    }
                } else {
                    $this->response('Something wrong with inserting with the database.', REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response('The sender does not belong to the chat room', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Chat_room, Sender, Ids and messages is required!', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function chat_rooms_get()
    {
        $account_id = $this->get('account_id');
        $chat_room_id = $this->get('id');
        if (isset($account_id)) {
            $chat_rooms = array();
            /* Get Account Chat Rooms */
            $account_chat_rooms = $this->chat_model->get_chat_participants(array(
                'conditions' => array(
                    'account_id' => $account_id
                )
            ));
            if ($account_chat_rooms) {
                foreach ($account_chat_rooms as $x => $value) {
                    // echo $value['chat_room_id'] . "<br />";
                    $chat_participants = $this->chat_model->get_chat_participants(array(
                        'conditions' => array(
                            'chat_room_id' => $value['chat_room_id']
                        )
                    ));
                    foreach ($chat_participants as $z => $value) {
                        // echo $value['account_id'] . "<br />";
                        $row = $this->account->get(array('id' => $value['account_id']));
                        $account_data = array(
                            'id' => $row['id'],
                            'first_name' => $row['first_name'],
                            'last_name' => $row['last_name'],
                            'image_url' => $row['image'],
                            'status' => $row['status']
                        );
                        $chat_rooms[$x]['participants'][$z] = $account_data;
                        $chat_rooms[$x]['id'] = $value['chat_room_id'];
                    }
                }
                foreach ($chat_rooms as $key => $value) {
                    $row = $this->chat_model->get_chat_rooms(array('id' => $value['id']));
                    $row1 = $this->chat_model->chat_room_last_message($value['id']);
                    $message = array(
                        'id' => $row1['id'],
                        'account_id' => $row1['account_id'],
                        'message' => $row1['message'],
                        'created_at' => $row1['created_at']
                    );
                    $chat_rooms[$key]['type'] = $row['type'];
                    $chat_rooms[$key]['status'] = $row['status'];
                    $chat_rooms[$key]['created_at'] = $row['created_at'];
                    $chat_rooms[$key]['lastest_message'] = $message? $message : array();
                }

                $this->response(array(
                    'total_chat_rooms' => count($chat_rooms),
                    "chat_rooms" => $chat_rooms
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'total_chat_rooms' => 0,
                    'chat_rooms' => null
                ), REST_Controller::HTTP_OK);
            }
        } else if ($chat_room_id) {

        } else {

        }
    }

    public function chat_room_messages_get($chat_room_id)
    {
        if (isset($chat_room_id)) {
            /* Get chat room messages */
            $messages = $this->chat_model->get_chat_messages(array(
                'conditions' => array(
                    'chat_room_id' => $chat_room_id
                )
            ));
            if ($messages == true) {
                $this->response(array(
                    "total_messages" => count($messages),
                    "messages" => $messages
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "total_messages" => 0,
                    "messages" => null
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response('Chat room id is required', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function delete_chat_room_put($chat_room_id)
    {
        if (isset($chat_room_id)) {

        } else {

        }
    }

    public function send_notification($payloads)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloads));

        $result= curl_exec($ch);

        if ($result === FALSE) {
            die("Curl Failed" . curl_error($ch));
        }
         curl_close($ch);
         return $result;
    }
}