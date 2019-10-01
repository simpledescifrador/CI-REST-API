<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class TransactionController extends REST_Controller
{
    private $header;
    private $url;

    public function __construct()
    {
        parent::__construct();
        define("API_KEY", "AAAAm7UpDxU:APA91bGskkta6mEUO6g5wnugf2YZtuK96d1EujnahqUBEH2Ou_LdQsrFSI-VNJBw0dDaPMGN06UNkJ5p2fZDyYXl-2D40lEvsVBQSLJX_i8zJ4JBmWviFq6h118qwnS9EGpX7dsi3FtJ");

        $this->url = "https://fcm.googleapis.com/fcm/send";
        $this->header = array(
            'Content-Type:application/json',
            'Authorization:key=' . API_KEY
        );
        $this->load->model('lost_item');
        $this->load->model('found_item');
        $this->load->model('account');
        // Load Item Model
        $this->load->model('item');
        $this->load->model('item_location');
        $this->load->model('repository');
        $this->load->model('pet_model');
        $this->load->model('person_model');

        $this->load->model('notification_model');
        $this->load->model('transaction_model');
        $this->load->model('chat_model');


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

    public function confirm_item_returned_put()
    {
        $transaction_id = $this->put('transaction_id');
        if (isset($transaction_id)) {
            //Change Transaction ID status
            $trans_data = $this->transaction_model->update_status($transaction_id, 'Accepted');
            if ($trans_data) {
                //Update Item Status to returned
                $update_item = $this->item->update(array('status' => 'Returned'), $trans_data['item_id']);
                // $item_data = $this->item->get(array('id' => $trans_data['item_id']));
                if ($update_item) {
                    //Send notifcation to item owner
                    // $this->send_notification($payloads);
                    $item_data = $this->item->get(array('id' => $trans_data['item_id']));
                    $account_data = $this->account->get(array('id' => $item_data['account_id']));
                    $this->response(array(
                        'updated' => true,
                        'account_id' => (int)$item_data['account_id'],
                        'account_name' => $account_data['first_name'] . ' ' . $account_data['last_name'],
                        'profile_image' => $account_data['image']
                    ), REST_Controller::HTTP_OK);
                } else {
                    //Rollback changes
                    $this->transaction_model->update_status($transaction_id, 'Pending');
                    $this->response(array(
                        'updated' => false
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response('Update Failed', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Transaction ID is required', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function denied_item_returned_put()
    {
        $transaction_id = $this->put('transaction_id');
        if (isset($transaction_id)) {
            //Change Transaction ID status
            $trans_data = $this->transaction_model->update_status($transaction_id, 'Denied');
            if ($trans_data) {
                //Update Item Status to returned
                $update_item = $this->item->update(array('status' => 'Returned'), $trans_data['item_id']);
                if ($update_item) {

                    $item_data = $this->item->get(array('id' => $trans_data['item_id']));
                    $account_data = $this->account->get(array('id' => $item_data['account_id']));
                    $this->response(array(
                        'updated' => true,
                        'account_id' => (int)$item_data['account_id'],
                        'account_name' => $account_data['first_name'] . ' ' . $account_data['last_name'],
                        'profile_image' => $account_data['image']
                    ), REST_Controller::HTTP_OK);
                } else {
                    //Rollback changes
                    $this->transaction_model->update_status($transaction_id, 'Denied');
                    $this->response(array(
                        'updated' => false
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response('Transaction ID is required', REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }


    public function check_item_return_status_get($item_id)
    {
        if (isset($item_id)) {
            $tcon['returnType'] = 'single';
            $tcon['conditions'] = array(
                'item_id' => $item_id
            );
            $tconfirmed_data = $this->transaction_model->get_transaction_confirmed($tcon);
            $item_data = $this->item->get(array('id' => $tconfirmed_data['item_id']));

            if ($tconfirmed_data) {
                $mcon['returnType'] = 'single';
                $mcon['conditions'] = array(
                    'transaction_id' => $tconfirmed_data['id'],
                    'meetup_confirmation' => 'Accepted'
                );
                $meet_data = $this->transaction_model->get_transaction_meetup($mcon);

                if ($meet_data) {
                    $rcon['returnType'] = 'single';
                    $rcon['conditions'] = array(
                        'item_id' => $item_id
                    );
                    $return_transaction = $this->transaction_model->get_transaction($rcon);

                    if ($return_transaction) {
                        $this->response(array(
                            'return_valid' => false,
                            'meetup_id' => (int) $meet_data['id'],
                            'account_id' => (int) $item_data['account_id'],
                            'return_transaction_id' => (int) $return_transaction['id']
                        ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(array(
                            'return_valid' => true,
                            'account_id' => (int) $item_data['account_id'],
                            'meetup_id' => (int) $meet_data['id']
                        ), REST_Controller::HTTP_OK);
                    }



                } else {
                    $this->response(array(
                        'return_valid' => false
                    ), REST_Controller::HTTP_OK);
                }

            } else {
                $this->response(array(
                    'return_valid' => false
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response('Item id is required', REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function check_pending_trans_get($item_id, $account_id)
    {
        if (isset($item_id)) {
            //Check if item was return transaction
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'transfer_to' => $account_id,
                'item_id' => $item_id,
                'status' => 'Pending'
            );
            $result = $this->transaction_model->get_transaction($con);

            if ($result) {
                $this->response(array(
                    'returned' => true,
                    'return_transaction_id' => (int)$result['id']
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'returned' => false
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response('Item not exist', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function return_item_transaction_post()
    {
        $meet_id = $this->post('meetup_id');
        $item_id = $this->post('item_id');

        if (isset($meet_id, $item_id)) {
            $meet_data = $this->transaction_model->get_transaction_meetup(array('id' => $meet_id));

            if ($meet_data) {
                $location_id = $meet_data['meetup_location'];
                $date = $meet_data['meetup_date'];

                $transaction_data = $this->transaction_model->get_transaction_confirmed(array('id' => $meet_data['transaction_id']));
                //Validate account
                $valid_account = $this->account->get(array('id' => $transaction_data['owner_id']));

                $location_info = $this->item_location->get(array('id' => $location_id));


                $config['upload_path'] = './uploads/transaction_images';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                if ($valid_account) {
                    $new_transaction['transfer_to'] = $valid_account['id'];
                    $new_transaction['return_location_id'] = $location_id;
                    $new_transaction['return_date'] = date('Y-m-d', strtotime($date));
                    $new_transaction['return_time'] = date('h:i:s', strtotime($date));
                    $new_transaction['item_id'] = $item_id;
                    $new_transaction['status'] = 'Pending';

                    if ($this->upload->do_upload('meetup_image')) {
                        $data = array('upload_data' => $this->upload->data());
                        //TODO insert transcation
                        $new_transaction['image'] = $data['upload_data']['file_name'];
                        $insert_result = $this->transaction_model->insert_transaction($new_transaction);

                        $transaction_data = $this->transaction_model->get_transaction(array('id' => $insert_result));
                        $item_data = $this->item->get(array('id' => $transaction_data['item_id']));
                        $token = $this->account->registered_token($valid_account['id']);

                        $item_images = $this->item->get_item_images($item_data['id']);

                        switch ($item_data['report_type']) {
                            case 'Personal Thing':
                                $data = $this->found_item->get(array('id' => $item_data['item_id']));
                                /* Save Notification to the database */
                                $notif['title'] = "This personal thing was return to you";
                                $notif['content'] = $data['item_name'];
                                $notif['image_url'] = $item_images[0]['file_path'];
                                $notif['type'] = "Transaction";
                                $notif['ref_id'] = $item_data['id'];
                                $notif['account_id'] = $valid_account['id'];
                                $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                                break;
                            case 'Person':
                                $data = $this->person_model->get(array('id' => $item_data['item_id']));
                                $notif['title'] = "This person was return to you";
                                $notif['content'] = $data['sex'] . " " . $data['age_range'] . " years old";
                                $notif['image_url'] = $item_images[0]['file_path'];
                                $notif['type'] = "Transaction";
                                $notif['ref_id'] = $item_data['id'];
                                $notif['account_id'] = $valid_account['id'];
                                $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                                break;
                            case 'Pet':
                                $data = $this->pet_model->get(array('id' => $item_data['item_id']));
                                $notif['title'] = "This pet was return to you";
                                $notif['content'] = $data['breed'] . " " . $data['type'];
                                $notif['image_url'] = $item_images[0]['file_path'];
                                $notif['type'] = "Transaction";
                                $notif['ref_id'] = $item_data['id'];
                                $notif['account_id'] = $valid_account['id'];
                                $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                                break;
                        }

                        $notif_data = $this->notification_model->get(array('id' => $notif_id));

                        $unviewed_notification_count = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_data['account_id'],
                                'is_read' => "No"
                            )));

                        $total_notif = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $valid_account['id']
                            )
                        ));
                        $payloads = array(
                            "to" => $token['token'],
                            "notification" => array(
                                "title" => $notif_data['title'],
                                "body" => $notif_data['content'],
                                "click_action" => "Item Detail"
                            ),
                            "data" => array(
                                "id" => $notif_data['id'],
                                "title" => $notif_data['title'],
                                "content" => $notif_data['content'],
                                "image_url" => $notif_data['image_url'],
                                "created_at" => $notif_data['created_at'],
                                "viewed" => $notif_data['is_read'],
                                "type" => $notif_data['type'],
                                "ref_id" => (int) $notif_data['ref_id'],
                                "account_id" => (int) $notif_data['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0,
                                "total_unviewed_notifications" => (int) $unviewed_notification_count
                            )
                        );
                        if ($insert_result) {
                            /* Send conformation Notification on who accept the found item */
                             $this->send_notification($payloads);
                            $this->response(array(
                                'success' => true,
                                'transaction_id' => $insert_result
                            ), REST_Controller::HTTP_OK);
                        } else {
                            $this->response('Failed to insert new transaction', REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                } else {
                }


            } else {
                $this->response("Meeting Transaction Not Found", REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->response("Meetup id and item id is required", REST_Controller::HTTP_BAD_REQUEST);
        }


    }

    public function meetup_confirmation_put()
    {
        $id = $this->put('id');
        $confirmation = $this->put('confirmation');

        if (isset($id, $confirmation)) {
            $data = array(
                'meetup_confirmation' => $confirmation
            );
            $result = $this->transaction_model->update_transaction_meetup($data, $id);

            if ($result) {
                $this->response(array(
                    'confirmation' => true
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'confirmation' => false
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response("Id and Confirmation is required", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function meetup_details_get($id)
    {
        if (isset($id)) {
            $details = $this->transaction_model->get_transaction_meetup(array('id' => $id));
            if ($details) {
                $location_id = $details['meetup_location'];
                $location_data = $this->item_location->get(array('id' => $location_id));
                $data = array(
                    'id' => (int) $details['id'],
                    'transaction_id' => (int) $details['transaction_id'],
                    'meetup_place' => $location_data['name'],
                    'meetup_date' =>  $details['meetup_date']
                );
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response("Meet Details Not Found", REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->response("Meet Id is required", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function setup_meetup_post()
    {
        //Location info
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');
        $date = $this->post('date');
        $transaction_id = $this->post('transaction_id');

        if (isset($date, $transaction_id, $location_info['id'])) {
            //Get Details Need for notification
            $confirmation_transaction_details = $this->transaction_model->get_transaction_confirmed(array('id' => $transaction_id));
            $item_data = $this->item->get(array('id' => $confirmation_transaction_details['item_id']));

            //Receiver Account Details
            $account_data = $this->account->get(array('id' => $confirmation_transaction_details['owner_id']));
            /* Get the receiver token */
            $token = $this->account->registered_token($account_data['id']);

            /* Check if the participants has already have chat room */
            $account1_result = $this->chat_model->get_chat_participants(array(
                'conditions' => array(
                    'account_id' => $confirmation_transaction_details['owner_id']
                )
            ));

            $account2_result = $this->chat_model->get_chat_participants(array(
                'conditions' => array(
                    'account_id' => $item_data['account_id']
                )
            ));
            $result1 = $account1_result != null? count($account1_result) : 0;
            $result2 = $account2_result != null? count($account2_result) : 0;

            for ($x=0; $x < $result1; $x++) {
                for ($z=0; $z < $result2; $z++) {
                    if ($account1_result[$x]['chat_room_id'] === $account2_result[$z]['chat_room_id']) {
                        $chat_room_id = $account1_result[$x]['chat_room_id'];
                        break;
                    }
                }
            }


            //check if have existing meetup
            $con['conditions'] = array(
                'transaction_id' => $transaction_id
            );

            $result = $this->transaction_model->get_transaction_meetup($con);



            if (!$result) {
                $data = array(
                    'meetup_date' => $date,
                    'transaction_id' => $transaction_id,
                    'meetup_location' => $location_info['id'],
                    'date_created' => date('y-m-d h:i:s')
                );
                $meetup_result = $this->transaction_model->insert_transaction_meetup($data);
                //Check if location exist
                $tcon['id'] = $location_info['id'];
                $location_exist = $this->item_location->get($tcon);
                if (!$location_exist) {
                    $this->item_location->insert($location_info);
                }
            } else {
                $data = array(
                    'meetup_date' => $date,
                    'meetup_location' => $location_info['id']
                );
                $meetup_result = $this->transaction_model->update_transaction_meetup($data, $transaction_id);
                //Check if location exist
                $tcon['id'] = $location_info['id'];
                $location_exist = $this->item_location->get($tcon);
                if (!$location_exist) {
                    $this->item_location->insert($location_info);
                }
            }
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'transaction_id' => $transaction_id
            );

            $result = $this->transaction_model->get_transaction_meetup($con);

            /* Save Notification to the database */
            $notif['title'] = "You have a scheduled meet-up";
            $notif['content'] = "Tap to see details";
            $notif['image_url'] = '';
            $notif['type'] = "Transaction";
            $notif['ref_id'] = $chat_room_id;
            $notif['transaction_id'] = $transaction_id;
            $notif['account_id'] = $account_data['id'];
            $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */

            if ($meetup_result) {
                $notif_data = $this->notification_model->get(array('id' => $notif_id));

                $total_notif = $this->notification_model->get(array(
                    'returnType' => 'count',
                    'conditions' => array(
                        'account_id' => $account_data['id']
                    )
                ));

                $unviewed_notification_count = $this->notification_model->get(array(
                    'returnType' => 'count',
                    'conditions' => array(
                        'account_id' => $notif_data['account_id'],
                        'is_read' => "No"
                    )));

                $payloads = array(
                    "to" => $token['token'],
                    "notification" => array(
                        "title" => $notif_data['title'],
                        "body" => $notif_data['content'],
                        "click_action" => "Meetup"
                    ),
                    "data" => array(
                        "id" => $notif_data['id'],
                        "title" => $notif_data['title'],
                        "content" => $notif_data['content'],
                        "image_url" => $notif_data['image_url'],
                        "created_at" => $notif_data['created_at'],
                        "viewed" => $notif_data['is_read'],
                        "type" => $notif_data['type'],
                        "ref_id" => (int) $notif_data['ref_id'],
                        "account_id" => (int) $notif_data['account_id'],
                        'chat_room_id' => (int) $chat_room_id,
                        "item_id" => (int) $confirmation_transaction_details['item_id'],
                        "meetup_id" => (int)$result['id'],
                        'sender_id' => $account_data['id'],
                        'location_lat' => $location_info['latitude'],
                        'location_lng' => $location_info['longitude'],
                        'sender_name' => $account_data['first_name'] . " " . $account_data['last_name'],
                        "total_notifications" => (int) isset($total_notif)? $total_notif : 0,
                        "total_unviewed_notifications" => (int) $unviewed_notification_count
                    )
                );

                $this->send_notification($payloads);
                $this->response(array(
                    'status' => true,
                    'meetup_id' => (int) $result['id']
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response('Failed to setup new meetup', REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->response('Location, Date and Transaction ID is required', REST_Controller::HTTP_BAD_REQUEST);
        }

    }



    public function check_transaction_status_get()
    {
        $item_id = $this->input->get('item_id');
        $account_id = $this->input->get('account_id');

        if (isset($item_id, $account_id)) {
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'item_id' => $item_id,
                'owner_id' => $account_id,
                'cancelled' => 'No'
            );
            $result = $this->transaction_model->get_transaction_confirmed($con);
            if ($result) {
                $meet_con['returnType'] = 'single';
                $meet_con['conditions'] = array(
                    'transaction_id' => $result['id']
                );
                $meet_data = $this->transaction_model->get_transaction_meetup($meet_con);

                if ($meet_data) {
                    $rcon['returnType'] = 'count';
                    $rcon['conditions'] = array(
                        'item_id' => $item_id
                    );
                    $isReturned = $this->transaction_model->get_transaction($rcon);

                    if ($isReturned) {
                        $this->response(array(
                            'transaction_id' => (int) $result['id'],
                            'meetup_id' => (int) $meet_data['id'],
                            'confirmation' => $meet_data['meetup_confirmation'],
                            'return' => true
                        ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(array(
                            'transaction_id' => (int) $result['id'],
                            'meetup_id' => (int) $meet_data['id'],
                            'confirmation' => $meet_data['meetup_confirmation']
                        ), REST_Controller::HTTP_OK);
                    }


                    $this->response(array(
                        'transaction_id' => (int) $result['id'],
                        'meetup_id' => (int) $meet_data['id'],
                        'confirmation' => $meet_data['meetup_confirmation']
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'transaction_id' => (int) $result['id']
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'item_id' => $item_id,
                    'cancelled' => 'No'
                );
                $result = $this->transaction_model->get_transaction_confirmed($con);

                if ($result) {
                    $this->response(array(
                        'already_confirmed' => true,
                        'transaction_id' => (int) $result['id']
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'already_confirmed' => false
                    ), REST_Controller::HTTP_OK);
                }

            }

        } else {
            $this->response('Item Id and Account ID is required', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function transaction_confirmation_status_get($item_id)
    {
        if (isset($item_id)) {
            $con['conditions'] = array(
                'item_id' => $item_id
            );

            $result = $this->transaction_model->get_transaction_confirmed($con);

            if (!$result) {
                $this->response(array(
                    'confirmed' => false
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'confirmed' => true
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response('Item Id required', REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function item_transaction_confirm_post()
    {
        $item_id = $this->post('item_id');
        $account_id = $this->post('account_id');

        if (isset($item_id, $account_id)) {

            //Check if the item is already confirmed
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'item_id' => $item_id
            );

            $result = $this->transaction_model->get_transaction_confirmed($con);

            if (!$result) {
                $data = array(
                    'item_id' => $item_id,
                    'date_confirmed' => date('y-m-d h:i:s'),
                    'owner_id' => $account_id
                );

                $insert_id = $this->transaction_model->insert_confirmed_transaction($data);
                $details = $this->transaction_model->get_transaction_confirmed(array('id' => $insert_id));
                if ($details) {
                    $this->response(array(
                        'already_confirmed' => false,
                        'transaction_id' => (int) $details['id']
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response('Failed to confirmed', REST_Controller::HTTP_BAD_REQUEST);
                }

            } else {
                //Check if the item with account_id is already confirmed
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'item_id' => $item_id,
                    'owner_id' => $account_id
                );

                $result = $this->transaction_model->get_transaction_confirmed($con);

                if ($result) {
                    $this->response(array(
                        'already_confirmed' => true,
                        'transaction_id' => (int) $result['id']
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'already_confirmed' => true
                    ), REST_Controller::HTTP_OK);
                }
            }


        } else {
            $this->response('Item Id and Account ID is required', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}