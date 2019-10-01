<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class SearchController extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('lost_item');
        $this->load->model('found_item');
        $this->load->model('account');
        $this->load->model('item_location');
        $this->load->model('item');
        $this->load->model('repository');
        $this->load->model('barangay');
        $this->load->model('pet_model');
        $this->load->model('person_model');

    }

    public function search_items_get()
    {
        $query = $this->get('q');
        $skips = $this->get('skips');
        $limit = $this->get('limit');
        $filter_value = $this->get('filter');
        $match_items = array();
        if (isset($query) && !isset($filter_value)) { //Get All Items matched by keyword
            $con['limit'] = $limit;
            $lost_pt_result = $this->item->fetch_lost_pt($query, array());
            $found_pt_result = $this->item->fetch_found_pt($query, array());
            $pets_result = $this->item->fetch_pets($query, array());
            $persons_result = $this->item->fetch_persons($query, array());

            if (count($lost_pt_result) > 0) {
                foreach ($lost_pt_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pt_id'],
                        'type' => 'Lost',
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Personal Thing',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "lost_pt_data" => array(
                            "item_name" => ucwords(strtolower($row['pt_name'])),
                            "date" => $row['pt_date'],
                            "category" => $row['pt_category'],
                            "reward" => (double)$row['pt_reward'],
                            "brand" => ucfirst($row['pt_brand']),
                            "color" => ucfirst($row['pt_color']),
                            "description" => ucfirst($row['pt_description']),
                            "item_image" => 'uploads/lost/' . $row['pt_image'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),

                    );
                }
            }

            if (count($found_pt_result) > 0) {
                foreach ($found_pt_result as $row) {
                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'item_id' => $row['pt_id']
                    );
                    $repo = $this->repository->get($con);
                    $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));

                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pt_id'],
                        'type' => 'Found',
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Personal Thing',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "found_pt_data" => array(
                            "item_name" => ucwords(strtolower($row['pt_name'])),
                            "date" => $row['pt_date'],
                            "category" => $row['pt_category'],
                            "brand" => ucfirst($row['pt_brand']),
                            "color" => ucfirst($row['pt_color']),
                            "description" => ucfirst($row['pt_description']),
                            "item_image" => 'uploads/found/' . $row['pt_image'],
                            "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                            "date_surrendered" => $repo['date_item_received'],
                            "barangay_info" => array(
                                "id" => (int)$barangay  ['id'],
                                "name" => ucwords(strtolower($barangay['name'])),
                                "address" => $barangay['address'],
                                "district_no" => (int)$barangay['district_no'],
                                "latitude" => $barangay['latitude'],
                                "longitude" => $barangay['longitude']
                            ),
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }

            if (count($pets_result) > 0) {
                foreach ($pets_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pet_id'],
                        'type' => $row['item_type'],
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Pet',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "pet_data" => array(
                            "name" => ucfirst($row['pet_name']),
                            "type" => $row['pet_type'],
                            "breed" => $row['pet_breed'],
                            "date" => $row['pet_date'],
                            "condition" => $row['pet_condition'],
                            "description" => $row['pet_description'],
                            "pet_image" => 'uploads/found/pets/' . $row['pet_image'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }

            if (count($persons_result) > 0) {
                foreach ($persons_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['person_id'],
                        'type' => $row['item_type'],
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Person',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "person_data" => array(
                            "name" => $row['person_name'],
                            "age_group" => $row['person_age_group'],
                            "age_range" => $row['person_age_range'],
                            "sex" => $row['person_sex'],
                            "date" => $row['person_date'],
                            "reward" => (double)$row['person_reward'],
                            "person_image" => 'uploads/lost/persons/' . $row['person_image'],
                            "description" => $row['person_description'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }
        } else if (isset($filter_value)) {
            $chunks = array_chunk(preg_split('/(:|,)/', $filter_value), 2);
            $filter_con = array_combine(str_replace(" ", "_", array_column($chunks, 0)), array_column($chunks, 1));

            $con['conditions'] = $filter_con;
            $lost_pt_result = $this->item->fetch_lost_pt($query, $con);
            $found_pt_result = $this->item->fetch_found_pt($query, $con);
            $pets_result = $this->item->fetch_pets($query, $con);
            $persons_result = $this->item->fetch_persons($query, $con);

            if (count($lost_pt_result) > 0) {
                foreach ($lost_pt_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pt_id'],
                        'type' => 'Lost',
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Personal Thing',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "lost_pt_data" => array(
                            "item_name" => ucwords(strtolower($row['pt_name'])),
                            "date" => $row['pt_date'],
                            "category" => $row['pt_category'],
                            "reward" => (double)$row['pt_reward'],
                            "brand" => ucfirst($row['pt_brand']),
                            "color" => ucfirst($row['pt_color']),
                            "description" => ucfirst($row['pt_description']),
                            "item_image" => 'uploads/lost/' . $row['pt_image'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),

                    );
                }
            }

            if (count($found_pt_result) > 0) {
                foreach ($found_pt_result as $row) {
                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'item_id' => $row['pt_id']
                    );
                    $repo = $this->repository->get($con);
                    $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));

                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pt_id'],
                        'type' => 'Found',
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Personal Thing',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "found_pt_data" => array(
                            "item_name" => ucwords(strtolower($row['pt_name'])),
                            "date" => $row['pt_date'],
                            "category" => $row['pt_category'],
                            "brand" => ucfirst($row['pt_brand']),
                            "color" => ucfirst($row['pt_color']),
                            "description" => ucfirst($row['pt_description']),
                            "item_image" => 'uploads/found/' . $row['pt_image'],
                            "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                            "date_surrendered" => $repo['date_item_received'],
                            "barangay_info" => array(
                                "id" => (int)$barangay  ['id'],
                                "name" => ucwords(strtolower($barangay['name'])),
                                "address" => $barangay['address'],
                                "district_no" => (int)$barangay['district_no'],
                                "latitude" => $barangay['latitude'],
                                "longitude" => $barangay['longitude']
                            ),
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }

            if (count($pets_result) > 0) {
                foreach ($pets_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['pet_id'],
                        'type' => $row['item_type'],
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Pet',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "pet_data" => array(
                            "name" => ucfirst($row['pet_name']),
                            "type" => $row['pet_type'],
                            "breed" => $row['pet_breed'],
                            "date" => $row['pet_date'],
                            "condition" => $row['pet_condition'],
                            "description" => $row['pet_description'],
                            "pet_image" => 'uploads/found/pets/' . $row['pet_image'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }

            if (count($persons_result) > 0) {
                foreach ($persons_result as $row) {
                    $match_items[] = array(
                        'id' => $row['id'],
                        'item_id' => $row['person_id'],
                        'type' => $row['item_type'],
                        'published_date' => $row['item_published_date'],
                        'modified_date' => $row['item_modified_date'],
                        'report_type' => 'Person',
                        'status' => $row['item_status'],
                        "account_info" => array(
                            "id" => $row['account_id'],
                            "first_name" => $row['account_fname'],
                            'last_name' => $row['account_lname'],
                            'image_url' => $row['account_image']
                        ),
                        "person_data" => array(
                            "name" => $row['person_name'],
                            "age_group" => $row['person_age_group'],
                            "age_range" => $row['person_age_range'],
                            "sex" => $row['person_sex'],
                            "date" => $row['person_date'],
                            "reward" => (double)$row['person_reward'],
                            "person_image" => 'uploads/lost/persons/' . $row['person_image'],
                            "description" => $row['person_description'],
                            "location_info" => array(
                                "id" => $row['location_id'],
                                "name" => $row['location_name'],
                                "address" => $row['location_address'],
                                "latitude" => $row['location_latitude'],
                                "longitude" => $row['location_longitude']
                            )
                        ),
                    );
                }
            }
        }
        else {

        }
        if (count($match_items) > 0) {
            $this->response(array(
                'total_results' => count($match_items),
                'match_items' => $match_items
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'total_results' => 0,
                'match_items' => $match_items
            ), REST_Controller::HTTP_OK);
        }

    }
}