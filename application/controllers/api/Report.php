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
        $this->load->model('pet_model');
        $this->load->model('person_model');
    }

    public function lost_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $lost_item['item_name'] = $this->post('item_name');
        $lost_item['date_lost'] = $this->post('date_lost');
        $lost_item['item_category'] = $this->post('item_category');
        $lost_item['location_id'] = $this->post('location_id');
        $lost_item['account_id'] = $this->post('account_id');

        //Nullable
        $lost_item['brand'] = $this->post('brand') != null ? $this->post('brand') : "";
        $lost_item['item_color'] = $this->post('item_color') != null ? $this->post('item_color') : "";
        $lost_item['item_description'] = $this->post('item_description') != null ? $this->post('item_description') : "";
        $lost_item['reward'] = $this->post('reward') != null ? $this->post('reward') : 0;

        if (isset($location_info['id']) && isset($lost_item['account_id'])) {
            $valid_account = $this->account->get(array('id' => $lost_item['account_id']));
            if ($valid_account) {
                $config['upload_path'] = './uploads/lost/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('item_image')) {
                    $data = array('upload_data' => $this->upload->data());
                    $lost_item['item_image'] = $data['upload_data']['file_name'];
                    $insert_result = $this->lost_item->insert($lost_item);
                    $item = array(
                        'item_id' => $insert_result,
                        'type' => 'Lost',
                        'status' => 'New',
                        'account_id' => $lost_item['account_id']
                    );
                    $item_id = $this->item->insert($item);
                    $con['id'] = $location_info['id'];
                    $location_exist = $this->item_location->get($con);
                    if (!$location_exist) {
                        $this->item_location->insert($location_info);
                    }

                    if ($insert_result) {
                        //update account status to active account
                        $this->account->update(array('status' => 'active'), $lost_item['account_id']);
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
            } else {
                $this->response("Invalid Account", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Please Provide lost info and location", REST_Controller::HTTP_BAD_REQUEST);
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
        $found_item['account_id'] = $this->post('account_id');
        //Nullable
        $found_item['brand'] = $this->post('brand') != null ? $this->post('brand') : "";
        $found_item['item_color'] = $this->post('item_color') != null ? $this->post('item_color') : "";
        $found_item['item_description'] = $this->post('item_description') != null ? $this->post('item_description') : "";

        if (isset($location_info['id']) && isset($found_item['account_id'])) {
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
                        'type' => 'Found',
                        'status' => 'New',
                        'account_id' => $found_item['account_id']
                    );
                    $item_id = $this->item->insert($item);
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

            } else {
                $this->response("Invalid Account", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Found items is null", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function report_pet_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        //Get the report type if lost or found
        $report_type = $this->post('report_type');
        $account_id = $this->post('account_id');

        $pet_data['pet_name'] = $this->post('pet_name');
        $pet_data['breed'] = $this->post('pet_breed'); //Optional
        $pet_data['type'] = $this->post('pet_type');
        $pet_data['pet_condition'] = $this->post('pet_condition');
        $pet_data['description'] = $this->post('pet_description');

        if ($report_type == "lost") {
            $pet_data['reward'] = $this->post('reward');
        } else {
            $pet_data['reward'] = NULL;
        }

        $pet_data['date'] = $this->post('date');
        $pet_data['location_id'] = $location_info['id'];
        $pet_data['account_id'] = $account_id;


        if (isset($location_info['id']) && isset($account_id)) {
            //do the magic here
            $valid_account = $this->account->get(array('id' => $account_id)); // check if the account exist

            if ($valid_account == true) {

                $config['upload_path'] = './uploads/' . strtolower($report_type) . '/pets/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);


                if ($this->upload->do_upload('pet_image')) {
                    $data = array('upload_data' => $this->upload->data());
                    $pet_data['pet_image'] = $data['upload_data']['file_name'];
                    $result = $this->pet_model->add_reported_pet($pet_data); // If insert success returns the insert id else false

                    if ($result == true) {
                        $item = array(
                            'item_id' => $result,
                            'type' => $report_type,
                            'status' => 'New',
                            'account_id' => $pet_data['account_id']
                        );
                        $item_id = $this->item->insert($item); // If insert success returns the insert id else false

                        //check if the location exist
                        $location_exist = $this->item_location->get(array('id' => $location_info['id']));
                        if (!$location_exist) {
                            $this->item_location->insert($location_info); //Insert new location if not on location table
                        }


                        if ($item_id == true) {
                            $this->response(array(
                                "successful" => true,
                                "item_id" => $item_id
                            ), REST_Controller::HTTP_OK);
                        } else {
                            $this->response(array(
                                "successful" => false
                            ), REST_Controller::HTTP_OK);
                        }

                    } else {

                    }

                } else {
                    $this->response("No pet image found", REST_Controller::HTTP_BAD_REQUEST);
                }

            }

        } else {
            $this->response("Location and account id not found", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function report_person_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        //Get the report type if lost or found
        $report_type = $this->post('report_type');
        $account_id = $this->post('account_id');


        $person_data['first_name'] = $this->post('first_name');
        $person_data['middle_name'] = $this->post('middle_name');
        $person_data['last_name'] = $this->post('last_name');
        $person_data['age_group'] = $this->post('age_group');
        $person_data['sex'] = $this->post('sex');
        $person_data['date'] = $this->post('date');

        if ($report_type == "lost") {
            $person_data['reward'] = $this->post('reward');
        } else {
            $person_data['reward'] = NULL;
        }

        $person_data['location_id'] = $location_info['id'];
        $person_data['account_id'] = $account_id;


        if (isset($location_info['id']) && isset($account_id)) {
            //do the magic here
            $valid_account = $this->account->get(array('id' => $account_id)); // check if the account exist

            if ($valid_account == true) {

                $config['upload_path'] = './uploads/' . strtolower($report_type) . '/persons/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);


                if ($this->upload->do_upload('person_image')) {
                    $data = array('upload_data' => $this->upload->data());
                    $person_data['person_image'] = $data['upload_data']['file_name'];
                    $result = $this->person_model->add_reported_person($person_data); // If insert success returns the insert id else false

                    if ($result == true) {
                        $item = array(
                            'item_id' => $result,
                            'type' => $report_type,
                            'status' => 'New',
                            'account_id' => $person_data['account_id']
                        );
                        $item_id = $this->item->insert($item); // If insert success returns the insert id else false

                        //check if the location exist
                        $location_exist = $this->item_location->get(array('id' => $location_info['id']));
                        if (!$location_exist) {
                            $this->item_location->insert($location_info); //Insert new location if not on location table
                        }


                        if ($item_id == true) {
                            $this->response(array(
                                "successful" => true,
                                "item_id" => $item_id
                            ), REST_Controller::HTTP_OK);
                        } else {
                            $this->response(array(
                                "successful" => false
                            ), REST_Controller::HTTP_OK);
                        }

                    } else {

                    }

                } else {
                    $this->response("No person image found", REST_Controller::HTTP_BAD_REQUEST);
                }

            }
        } else {
            $this->response("Location and account id not found", REST_Controller::HTTP_BAD_REQUEST);
        }

    }
}
