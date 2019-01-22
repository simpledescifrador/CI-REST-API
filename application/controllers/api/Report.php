<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Report extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('lost_item');
        $this->load->model('found_item');
        $this->load->model('account');
        // Load Item Model
        $this->load->model('item');
        $this->load->model('item_location');
        $this->load->model('repository');
    }

    public function lost_post()
    {
        //Get post input from client
        $item_name = $this->post('item_name');
        $date_lost = $this->post('date_lost');
        $location_lost = $this->post('location_lost');
        $reward = $this->post('reward');
        $item_color = $this->post('item_color');
        $item_description = $this->post('item_description');
        $item_category = $this->post('item_category');
        $address = $this->post('address');
        $contact_number = $this->post('contact_number');
        $account_id = $this->post('account_id');
        //check if not empty
        if (isset($item_name, $date_lost, $location_lost, $reward, $item_color, $item_description, $item_category, $address, $contact_number, $account_id)) {
            //Insert process of lost found item starts here

            $check_account = $this->account->get(array('id' => $account_id));

            //FIXME add validation for duplication of lost item
            if ($check_account) {

                $config['upload_path'] = './uploads/lost/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('item_image')) {
                    $data = array('upload_data' => $this->upload->data());

                    $lost_item = array(
                        'item_name' => $item_name,
                        'date_lost' => $date_lost,
                        'location_lost' => $location_lost,
                        'reward' => $reward,
                        'item_color' => $item_color,
                        'item_description' => $item_description,
                        'item_image' => $data['upload_data']['file_name'],
                        'item_category' => $item_category,
                        'address' => $address,
                        'contact_number' => $contact_number,
                        'account_id' => $account_id
                    );

                    $insert_lost = $this->lost_item->insert($lost_item);

                    $item = array(
                        'item_id' => $insert_lost,
                        'type' => 1,
                        'account_id' => $account_id
                    );

                    $this->item->insert($item);
                }
                if ($insert_lost) {
                    //successful lost item

                    //update account status to active account
                    $this->account->update(array('status' => 'active'), $account_id);

                    $this->response(array(
                        'message' => 'Successfully Inserted',
                        'lost_item_id' => $insert_lost
                    ), REST_Controller::HTTP_OK);
                } else {
                    //unsuccessful
                    $this->response(array(
                        'message' => 'Failed to insert'
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response("Account doesn't exist", REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->response("Please provide all required lost item information", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function found_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $found_item['item_name'] = $this->post('item_name');
        $found_item['date_found'] = $this->post('date_found');
        $found_item['item_category'] = $this->post('item_category');
        $found_item['location_id'] = $this->post('location_id');
        $found_item['brand'] = $this->post('brand');
        $found_item['item_color'] = $this->post('item_color');
        $found_item['item_description'] = $this->post('item_description');
        $found_item['account_id'] = $this->post('account_id');


        if ($location_info != null) {
            $valid_account = $this->account->get(array('id' => $found_item['account_id']));
            if ($valid_account) {
                $config['upload_path'] = './uploads/found/';
                $config['allowed_types'] = 'gif|jpg|png';


                $this->load->library('upload', $config);

                if ($this->upload->do_upload('item_image')) {
                    $data = array('upload_data' => $this->upload->data());
                    $found_item['item_image'] = $data['upload_data']['file_name'];
                    $insert_result = $this->found_item->insert($found_item);
                    $item = array(
                        'item_id' => $insert_result,
                        'type' => 2,
                        'account_id' => $found_item['account_id']
                    );
                    $item_id = $this->item->insert($item);
                    //FIXME do not insert again if already in the location table
                    $con['id'] = $location_info['id'];
                    $location_exist = $this->item_location->get($con);
                    if (!$location_exist) {
                        $this->item_location->insert($location_info);

                    }
                    //Add to repository if the item is go be surrendered to brgy
                    $is_surrendered = $this->post('s');
                    if ($is_surrendered) {
                        $repository['brgy_id'] = $this->post('barangay_id');
                        $repository['item_id'] = $item_id;
                        $repository['item_received'] = 2; // Value = No
                        $this->repository->insert($repository);
                    }

                    if ($insert_result) {
                        //update account status to active account
                        $this->account->update(array('status' => 'active'), $found_item['account_id']);
                        $this->response(array(
                            "successful" => true,
                            "item_id" => $item_id
                        ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(array(
                            "successful" => false,
                            "item_id" => $item_id
                        ), REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response("Item image is required", REST_Controller::HTTP_BAD_REQUEST);
                }

            }
        } else {
            $this->response("Found items is null", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

//    public function found_post()
//    {
//        //Get post input from client
//        $item_name = $this->post('item_name');
//        $date_lost = $this->post('date_found');
//        $location_lost = $this->post('location_found');
//        $item_color = $this->post('item_color');
//        $item_description = $this->post('item_description');
//        $item_category = $this->post('item_category');
//        $address = $this->post('address');
//        $contact_number = $this->post('contact_number');
//        $account_id = $this->post('account_id');
//
//        //check if not empty
//        if (isset($item_name, $date_lost, $location_lost, $item_color, $item_description, $item_category, $address, $contact_number, $account_id)) {
//            //Insert process of lost found item starts here
//            $check_account = $this->account->get(array('id' => $account_id));
//            //FIXME add validation for duplication of lost item
//            if ($check_account) {
//
//                $config['upload_path'] = './uploads/found/';
//                $config['allowed_types'] = 'gif|jpg|png|jpeg';
//                $this->load->library('upload', $config);
//
//                if ($this->upload->do_upload('item_image')) {
//                    $data = array('upload_data' => $this->upload->data());
//
//                    $found_item = array(
//                        'item_name' => $item_name,
//                        'date_found' => $date_lost,
//                        'location_found' => $location_lost,
//                        'item_color' => $item_color,
//                        'item_description' => $item_description,
//                        'item_image' => $data['upload_data']['file_name'],
//                        'item_category' => $item_category,
//                        'address' => $address,
//                        'contact_number' => $contact_number,
//                        'account_id' => $account_id
//                    );
//
//                    $insert_found = $this->found_item->insert($found_item);
//                    $item = array(
//                        'item_id' => $insert_found,
//                        'type' => 2,
//                        'account_id' => $account_id
//                    );
//
//                    $this->item->insert($item);
//                }
//                if ($insert_found) {
//                    //successful lost item
//
//                    //update account status to active account
//                    $this->account->update(array('status' => 'active'), $account_id);
//
//                    $this->response(array(
//                        'message' => 'Successfully Inserted',
//                        'found_item_id' => $insert_found
//                    ), REST_Controller::HTTP_OK);
//                } else {
//                    //unsuccessful
//                    $this->response(array(
//                        'message' => 'Failed to insert'
//                    ), REST_Controller::HTTP_OK);
//                }
//            } else {
//                $this->response("Account doesn't exist", REST_Controller::HTTP_BAD_REQUEST);
//            }
//        } else {
//            $this->response("Please provide all required lost item information", REST_Controller::HTTP_BAD_REQUEST);
//        }
//    }
}