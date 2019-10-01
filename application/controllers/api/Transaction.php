<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Transaction extends REST_Controller
{
    private $header;
    private $url;

    public function __construct()
    {
        parent::__construct();
        define("API_KEY", "AAAAAkQ0gvI:APA91bEfH-G9z8HQur-sE8Y3XGjZbBH3aXqAI92t5FTuwvmDK1iItMfsx--tdmiv-YeRp4_CqHoye2g67dUZaXLmCgxZIxsHKHyZUxR2kgEpWwEecbzfSjXrToeDmmrDZsmN6f_T1SRn");

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

        $result = curl_exec($ch);

        if ($result === FALSE) {
            die("Curl Failed" . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function return_transaction_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $new_transaction['return_location_id'] = $this->post('location_id');
        $new_transaction['return_date'] = $this->post('return_date');
        $new_transaction['return_time'] = $this->post('return_time');
        $new_transaction['item_id'] = $this->post('item_id');
        $new_transaction['status'] = 'Pending';

        if (isset($new_transaction['item_id'])) {

            $account_name = explode(" ", $this->post('account_name'));
            $first_name = $account_name[0];
            $middle_initial = substr($account_name[1], 0, 1);
            $last_name = $account_name[2];

            /* Check Account if exist */
            $valid_account = $this->account->check_account_by_name($first_name, $middle_initial, $last_name);
            $config['upload_path'] = './uploads/transaction_images';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if ($valid_account) {
                $new_transaction['transfer_to'] = $valid_account['id'];
                if ($this->upload->do_upload('transaction_image')) {
                    $data = array('upload_data' => $this->upload->data());
                    //TODO insert transcation
                    $new_transaction['image'] = $data['upload_data']['file_name'];
                    $insert_result = $this->transaction_model->insert_transaction($new_transaction);
                    //Check if location exist
                    $con['id'] = $location_info['id'];
                    $location_exist = $this->item_location->get($con);
                    if (!$location_exist) {
                        $this->item_location->insert($location_info);
                    }
                    $transaction_data = $this->transaction_model->get_transaction(array('id' => $insert_result));
                    $item_data = $this->item->get(array('id' => $transaction_data['item_id']));
                    $token = $this->account->registered_token($valid_account['id']);

                    switch ($item_data['report_type']) {
                        case 'Personal Thing':
                            $data = $this->found_item->get(array('id' => $item_data['item_id']));
                            /* Save Notification to the database */
                            $notif['title'] = "This personal thing was return to you";
                            $notif['content'] = $data['item_name'];
                            $notif['image_url'] = 'uploads/found/' . $data['item_image'];
                            $notif['type'] = "Transaction";
                            $notif['ref_id'] = $item_data['id'];
                            $notif['account_id'] = $valid_account['id'];
                            $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                            break;
                        case 'Person':
                            $data = $this->person_model->get(array('id' => $item_data['item_id']));
                            $notif['title'] = "This person was return to you";
                            $notif['content'] = $data['sex'] . " " . $data['age_range'] . " years old";
                            $notif['image_url'] = 'uploads/found/persons/' . $data['person_image'];
                            $notif['type'] = "Transaction";
                            $notif['ref_id'] = $item_data['id'];
                            $notif['account_id'] = $valid_account['id'];
                            $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                            break;
                        case 'Pet':
                            $data = $this->pet_model->get(array('id' => $item_data['item_id']));
                            $notif['title'] = "This pet was return to you";
                            $notif['content'] = $data['breed'] . " " . $data['type'];
                            $notif['image_url'] = 'uploads/found/pets/' . $data['pet_image'];
                            $notif['type'] = "Transaction";
                            $notif['ref_id'] = $item_data['id'];
                            $notif['account_id'] = $valid_account['id'];
                            $notif_id = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                            break;
                    }

                    $notif_data = $this->notification_model->get(array('id' => $notif_id));

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
                            "total_notifications" => (int) isset($total_notif)? $total_notif : 0
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
                $this->response('Invalid Account', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Put all required data', REST_Controller::HTTP_BAD_REQUEST);
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
            $location_id = $result['return_location_id'];
            $location_data = $this->item_location->get(array('id' => $location_id));


            if ($result) {
                $this->response(array(
                    'returned' => true,
                    'transaction_details' => array(
                        'id' => $result['id'],
                        'transfer_to' => $result['transfer_to'],
                        'return_location' => $location_data,
                        'return_date' => $result['return_date'],
                        'return_image' => 'uploads/transaction_images/' . $result['image'],
                        'item_id' => $result['item_id'],
                        'status' => $result['status']

                    )
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'returned' => false,
                    'transaction_details' => array()
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response('Item not exist', REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function confirm_item_returned_put()
    {
        $transaction_id = $this->post('transaction_id');
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
                    $this->response(array(
                        'updated' => true,
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
        $transaction_id = $this->post('transaction_id');
        if (isset($transaction_id)) {
            //Change Transaction ID status
            $trans_data = $this->transaction_model->update_status($transaction_id, 'Denied');
            if ($trans_data) {
                //Update Item Status to returned
                $update_item = $this->item->update(array('status' => 'Returned'), $trans_data['item_id']);
                if ($update_item) {
                    $this->response(array(
                        'updated' => true
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

}