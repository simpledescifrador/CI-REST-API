<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ItemController extends REST_Controller
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

    public function lost_get()
    {
        $id = $this->get('id');
        $limit = $this->get('limit');

        //Return Single Item if ID is provided else all items returned
        if (isset($id)) {
            $con['returnType'] = 'single';
            $con['id'] = $id;

            $lost_item = $this->lost_item->get($con);
            if ($lost_item) {
                $this->response($lost_item, REST_Controller::HTTP_OK);
            } else {
                $this->response("Lost Item not found", REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            //TODO Get all lost item
            $con['returnType'] = '';
            if (isset($limit)) {
                $con['limit'] = $limit;
            }
            $lost_item = $this->lost_item->get($con);
            if ($lost_item) {
                $this->response($lost_item, REST_Controller::HTTP_OK);
            } else {
                $this->response("No lost item exists", REST_Controller::HTTP_NO_CONTENT);
            }
        }
    }


    public function found_get()
    {
        $id = $this->get('id');
        $limit = $this->get('limit');

        //Return Single Item if ID is provided else all items returned
        if (isset($id)) {
            //TODO Get found item by id
            $con['returnType'] = 'single';
            $con['id'] = $id;

            $found_item = $this->found_item->get($con);
            if ($found_item) {
                $this->response($found_item, REST_Controller::HTTP_OK);
            } else {
                $this->response("Found item not found", REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            //TODO Get all found item
            $con['returnType'] = '';
            if (isset($limit)) {
                $con['limit'] = $limit;
            }
            $found_item = $this->found_item->get($con);

            if ($found_item) {
                $this->response($found_item, REST_Controller::HTTP_OK);
            } else {
                $this->response("No Found item exists", REST_Controller::HTTP_NO_CONTENT);
            }
        }
    }

    public function all_get()
    {
        //TODO Get All Lost and Found Items
        $limit = $this->get('limit');


        if (isset($limit)) {
            //Get all item with limit provided
            //
        } else {
            //Get all item
            $lost_item = $this->lost_item->get();
            $found_item = $this->found_item->get();

            if ($lost_item || $found_item) {
                $this->response(array(
                    'lost_item' => $lost_item,
                    'found_item' => $found_item
                ), REST_Controller::HTTP_OK);
            }
        }
    }

    public function feed_get()
    {
        //Get Filter Value from clients
        $filter = $this->get('filter');
        $account_id = $this->get('account_id');
        $lost_item = $this->lost_item->get();
        $found_item = $this->found_item->get();
        $items = $this->item->get(array('conditions' => array('status' => 'New')));
        $feed_items = array();

        if (isset($filter)) {
            //Check the filter value
            switch ($filter) {
                case "lost":
                    //Get All LOST ITEM only
                    for ($i = 0; $i < count($items); $i++) {
                        $account_data = $this->account->get(array("id" => $items[$i]['account_id']));
                        foreach ($lost_item as $lost) {
                            if ($items[$i]['item_id'] == $lost['id'] && $items[$i]['type'] == "Lost") {
                                $location_info = $this->item_location->get(array("id" => $lost['location_id']));
                                $feed_items[$i] = array(
                                    "id" => $items[$i]['id'],
                                    "type" => "Lost",
                                    "name" => ucwords(strtolower($lost['item_name'])),
                                    "description" => ucfirst(strtolower($lost['item_description'])),
                                    "category" => $lost['item_category'],
                                    "date" => $lost['date_lost'],
                                    "location" => $lost['location_lost'],
                                    "reward" => $lost['reward'],
                                    "image_url" => 'uploads/lost/' . $lost['item_image'],
                                    "published_at" => $items[$i]['published_at'],
                                    "account" => array(
                                        "id" => $account_data['id'],
                                        "first_name" => $account_data['first_name'],
                                        'middle_name' => $account_data['middle_name'],
                                        'last_name' => $account_data['last_name'],
                                        'image_url' => $account_data['image']
                                    ),
                                    "location_info" => array(
                                        "id" => $location_info['id'],
                                        "name" => $location_info['name'],
                                        "address" => $location_info['address'],
                                        "latitude" => $location_info['latitude'],
                                        "longitude" => $location_info['longitude']
                                    ),
                                    "item_status" => $items[$i]['status']


                                );
                                break;
                            }
                        }
                    }
                    break;
                case "found":
                    //Get All FOUND ITEM only
                    for ($i = 0; $i < count($items); $i++) {
                        $account_data = $this->account->get(array("id" => $items[$i]['account_id']));
                        foreach ($found_item as $found) {
                            if ($items[$i]['item_id'] == $found['id'] && $items[$i]['type'] == "Found") {
                                $location_info = $this->item_location->get(array("id" => $found['location_id']));
                                $con['returnType'] = 'single';
                                $con['conditions'] = array(
                                    'item_id' => $items[$i]['id']
                                );
                                $repo = $this->repository->get($con);
                                $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));
                                $feed_items[$i] = array(
                                    "id" => $items[$i]['id'],
                                    "type" => "Found",
                                    "name" => ucwords(strtolower($found['item_name'])),
                                    "description" => ucfirst(strtolower($found['item_description'])),
                                    "category" => $found['item_category'],
                                    "date" => $found['date_found'],
                                    "brand" => $found['brand'],
                                    "image_url" => 'uploads/found/' . $found['item_image'],
                                    "published_at" => $items[$i]['published_at'],
                                    "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                                    "date_surrendered" => $repo['date_item_received'],
                                    "barangay_info" => array(
                                        "id" => (int)$barangay['id'],
                                        "name" => ucwords(strtolower($barangay['name'])),
                                        "address" => $barangay['address'],
                                        "district_no" => (int)$barangay['district_no'],
                                        "latitude" => $barangay['latitude'],
                                        "longitude" => $barangay['longitude']
                                    ),
                                    "account" => array(
                                        "id" => $account_data['id'],
                                        "first_name" => $account_data['first_name'],
                                        'middle_name' => $account_data['middle_name'],
                                        'last_name' => $account_data['last_name'],
                                        'image_url' => $account_data['image']
                                    ),
                                    "location_info" => array(
                                        "id" => $location_info['id'],
                                        "name" => $location_info['name'],
                                        "address" => $location_info['address'],
                                        "latitude" => $location_info['latitude'],
                                        "longitude" => $location_info['longitude']
                                    ),
                                    "item_status" => $items[$i]['status']

                                );
                                break;
                            }
                        }
                    }
                    break;
            }
        } else if (isset($account_id)) {
            $con['conditions'] = array(
                "account_id" => $account_id
            );

            $items = $this->item->get($con);
            //Get all Item
            for ($i = 0; $i < count($items); $i++) {
                $account_data = $this->account->get(array("id" => $items[$i]['account_id']));
                foreach ($lost_item as $lost) {
                    if ($items[$i]['item_id'] == $lost['id'] && $items[$i]['type'] == "Lost") {
                        $location_info = $this->item_location->get(array("id" => $lost['location_id']));
                        $con['returnType'] = 'single';
                        $con['conditions'] = array(
                            'item_id' => $items[$i]['id']
                        );
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Lost",
                            "name" => ucwords(strtolower($lost['item_name'])),
                            "description" => ucfirst(strtolower($lost['item_description'])),
                            "category" => $lost['item_category'],
                            "date" => $lost['date_lost'],
                            "location" => $lost['location_id'],
                            "reward" => $lost['reward'],
                            "image_url" => 'uploads/lost/' . $lost['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "account" => array(
                                "id" => $account_data['id'],
                                "first_name" => $account_data['first_name'],
                                'middle_name' => $account_data['middle_name'],
                                'last_name' => $account_data['last_name'],
                                'image_url' => $account_data['image']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            ),
                            "item_status" => $items[$i]['status']

                        );
                        break;
                    }
                }
                foreach ($found_item as $found) {
                    if ($items[$i]['item_id'] == $found['id'] && $items[$i]['type'] == "Found") {
                        $location_info = $this->item_location->get(array("id" => $found['location_id']));
                        $con['returnType'] = 'single';
                        $con['conditions'] = array(
                            'item_id' => $items[$i]['id']
                        );
                        $repo = $this->repository->get($con);
                        $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Found",
                            "name" => ucwords(strtolower($found['item_name'])),
                            "description" => ucfirst(strtolower($found['item_description'])),
                            "category" => $found['item_category'],
                            "date" => $found['date_found'],
                            "brand" => $found['brand'],
                            "image_url" => 'uploads/found/' . $found['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                            "date_surrendered" => $repo['date_item_received'],
                            "barangay_info" => array(
                                "id" => (int)$barangay['id'],
                                "name" => ucwords(strtolower($barangay['name'])),
                                "address" => $barangay['address'],
                                "district_no" => (int)$barangay['district_no'],
                                "latitude" => $barangay['latitude'],
                                "longitude" => $barangay['longitude']
                            ),
                            "account" => array(
                                "id" => $account_data['id'],
                                "first_name" => $account_data['first_name'],
                                'middle_name' => $account_data['middle_name'],
                                'last_name' => $account_data['last_name'],
                                'image_url' => $account_data['image']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            ),
                            "item_status" => $items[$i]['status']

                        );
                        break;
                    }
                }
            }
        } else {

            //Get all Item
            for ($i = 0; $i < count($items); $i++) {
                $account_data = $this->account->get(array("id" => $items[$i]['account_id']));
                foreach ($lost_item as $lost) {
                    $location_info = $this->item_location->get(array("id" => $lost['location_id']));

                    if ($items[$i]['item_id'] == $lost['id'] && $items[$i]['type'] == "Lost") {
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Lost",
                            "name" => ucwords(strtolower($lost['item_name'])),
                            "description" => ucfirst(strtolower($lost['item_description'])),
                            "category" => $lost['item_category'],
                            "date" => $lost['date_lost'],
                            "brand" => $lost['brand'],
                            "reward" => (double)$lost['reward'],
                            "image_url" => 'uploads/lost/' . $lost['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "account" => array(
                                "id" => $account_data['id'],
                                "first_name" => $account_data['first_name'],
                                'middle_name' => $account_data['middle_name'],
                                'last_name' => $account_data['last_name'],
                                'image_url' => $account_data['image']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            ),
                            "item_status" => $items[$i]['status']

                        );
                        break;
                    }
                }
                foreach ($found_item as $found) {
                    if ($items[$i]['item_id'] == $found['id'] && $items[$i]['type'] == "Found") {
                        $location_info = $this->item_location->get(array("id" => $found['location_id']));
                        $con['returnType'] = 'single';
                        $con['conditions'] = array(
                            'item_id' => $items[$i]['id']
                        );
                        $repo = $this->repository->get($con);
                        $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));

                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Found",
                            "name" => ucwords(strtolower($found['item_name'])),
                            "description" => ucfirst(strtolower($found['item_description'])),
                            "category" => $found['item_category'],
                            "date" => $found['date_found'],
                            "brand" => $found['brand'],
                            "image_url" => 'uploads/found/' . $found['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                            "date_surrendered" => $repo['date_item_received'],
                            "barangay_info" => array(
                                "id" => (int)$barangay['id'],
                                "name" => ucwords(strtolower($barangay['name'])),
                                "address" => $barangay['address'],
                                "district_no" => (int)$barangay['district_no'],
                                "latitude" => $barangay['latitude'],
                                "longitude" => $barangay['longitude']
                            ),
                            "account" => array(
                                "id" => $account_data['id'],
                                "first_name" => $account_data['first_name'],
                                'middle_name' => $account_data['middle_name'],
                                'last_name' => $account_data['last_name'],
                                'image_url' => $account_data['image']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            ),
                            "item_status" => $items[$i]['status']

                        );
                        break;
                    }
                }
            }
        }

        // Combine lost item and found item and convert to feed items
        if ($feed_items) {
            $this->response(array(
                "status" => true,
                "total_results" => count($feed_items),
                "feed_items" => $feed_items
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "status" => false,
                "total_results" => count($feed_items),
                "feed_items" => array()
            ), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //add person and pet feed
    public function feed_v2_get()
    {
        //Get Filter Value from clients
        $filter = $this->get('filter');
        $account_id = $this->get('account_id');
        $lost_item = $this->lost_item->get();
        $found_item = $this->found_item->get();
        $pet = $this->pet_model->get();
        $person = $this->person_model->get();
        $items = $this->item->get(array('conditions' => array('status' => 'New')));
        $feed_items = array();


        //null array fix
        $lost_item = $lost_item != NULL ? $lost_item : array();
        $found_item = $found_item != NULL ? $found_item : array();
        $pet = $pet != NULL ? $pet : array();
        $person = $person != NULL ? $person : array();

//        echo count($items);
        //TODO Get All reported item like personal things, pets and person
        for ($i = 0; $i < count($items); $i++) {
            //do the magic here get all the data from items and make a response
            $account_data = $this->account->get(array("id" => $items[$i]['account_id'])); //get account_data

            foreach ($lost_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Lost") {
                    $feed_items[$i] = array(
                        "id" => $items[$i]['id'],
                        "item_id" => $items[$i]['item_id'],
                        "type" => $items[$i]['type'],
                        "published_at" => $items[$i]['published_at'],
                        "date_modified" => $items[$i]['date_modified'],
                        "status" => $items[$i]['status'],
                        "account_info" => array(
                            "id" => $account_data['id'],
                            "first_name" => $account_data['first_name'],
                            'middle_name' => $account_data['middle_name'],
                            'last_name' => $account_data['last_name'],
                            'image_url' => $account_data['image']
                        ),
                        "lost_item_data" => array(
                            "item_name" => ucwords(strtolower($row['item_name'])),
                            "date" => $row['date_lost'],
                            "category" => $row['item_category'],
                            "reward" => (double)$row['reward'],
                            "brand" => ucfirst($row['brand']),
                            "color" => ucfirst($row['item_color']),
                            "description" => ucfirst($row['item_description']),
                            "item_image" => 'uploads/lost/' . $row['item_image'],
                            "location_info" => array(
                                "id" => $location_data['id'],
                                "name" => $location_data['name'],
                                "address" => $location_data['address'],
                                "latitude" => $location_data['latitude'],
                                "longitude" => $location_data['longitude']
                            )
                        )
                    );
                }
            }
            foreach ($found_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Found") {
                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'item_id' => $items[$i]['id']
                    );
                    $repo = $this->repository->get($con);
                    $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));
                    $feed_items[$i] = array(
                        "id" => $items[$i]['id'],
                        "item_id" => $items[$i]['item_id'],
                        "type" => $items[$i]['type'],
                        "published_at" => $items[$i]['published_at'],
                        "date_modified" => $items[$i]['date_modified'],
                        "status" => $items[$i]['status'],
                        "account_info" => array(
                            "id" => $account_data['id'],
                            "first_name" => $account_data['first_name'],
                            'middle_name' => $account_data['middle_name'],
                            'last_name' => $account_data['last_name'],
                            'image_url' => $account_data['image']
                        ),
                        "found_item_data" => array(
                            "item_name" => ucwords(strtolower($row['item_name'])),
                            "date" => $row['date_found'],
                            "category" => $row['item_category'],
                            "brand" => ucfirst($row['brand']),
                            "color" => ucfirst($row['item_color']),
                            "description" => ucfirst($row['item_description']),
                            "item_image" => 'uploads/found/' . $row['item_image'],
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
                                "id" => $location_data['id'],
                                "name" => $location_data['name'],
                                "address" => $location_data['address'],
                                "latitude" => $location_data['latitude'],
                                "longitude" => $location_data['longitude']
                            )
                        )
                    );

                }
            }
            foreach ($pet as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id']) {
                    switch ($items[$i]['type']) {
                        case "Lost":
                            $feed_items[$i] = array(
                                "id" => $items[$i]['id'],
                                "item_id" => $items[$i]['item_id'],
                                "type" => $items[$i]['type'],
                                "published_at" => $items[$i]['published_at'],
                                "date_modified" => $items[$i]['date_modified'],
                                "status" => $items[$i]['status'],
                                "account_info" => array(
                                    "id" => $account_data['id'],
                                    "first_name" => $account_data['first_name'],
                                    'middle_name' => $account_data['middle_name'],
                                    'last_name' => $account_data['last_name'],
                                    'image_url' => $account_data['image']
                                ),
                                "pet_info" => array(
                                    "name" => ucfirst($row['pet_name']),
                                    "type" => $row['type'],
                                    "breed" => $row['breed'],
                                    "date" => $row['date'],
                                    "condition" => $row['pet_condition'],
                                    "description" => $row['description'],
                                    "pet_image" => 'uploads/lost/pets/' . $row['pet_image'],
                                    "reward" => (double)$row['reward'],
                                    "location_info" => array(
                                        "id" => $location_data['id'],
                                        "name" => $location_data['name'],
                                        "address" => $location_data['address'],
                                        "latitude" => $location_data['latitude'],
                                        "longitude" => $location_data['longitude']
                                    )
                                )
                            );
                            break;
                        case "Found":
                            $feed_items[$i] = array(
                                "id" => $items[$i]['id'],
                                "item_id" => $items[$i]['item_id'],
                                "type" => $items[$i]['type'],
                                "published_at" => $items[$i]['published_at'],
                                "date_modified" => $items[$i]['date_modified'],
                                "status" => $items[$i]['status'],
                                "account_info" => array(
                                    "id" => $account_data['id'],
                                    "first_name" => $account_data['first_name'],
                                    'middle_name' => $account_data['middle_name'],
                                    'last_name' => $account_data['last_name'],
                                    'image_url' => $account_data['image']
                                ),
                                "pet_info" => array(
                                    "name" => ucfirst($row['pet_name']),
                                    "type" => $row['type'],
                                    "breed" => $row['breed'],
                                    "date" => $row['date'],
                                    "condition" => $row['pet_condition'],
                                    "description" => $row['description'],
                                    "pet_image" => 'uploads/found/pets/' . $row['pet_image'],
                                    "location_info" => array(
                                        "id" => $location_data['id'],
                                        "name" => $location_data['name'],
                                        "address" => $location_data['address'],
                                        "latitude" => $location_data['latitude'],
                                        "longitude" => $location_data['longitude']
                                    )
                                )
                            );
                            break;
                    }


                }
            }
            foreach ($person as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id']) {
                    switch ($items[$i]['type']) {
                        case "Lost":
                            $feed_items[$i] = array(
                                "id" => $items[$i]['id'],
                                "item_id" => $items[$i]['item_id'],
                                "type" => $items[$i]['type'],
                                "published_at" => $items[$i]['published_at'],
                                "date_modified" => $items[$i]['date_modified'],
                                "status" => $items[$i]['status'],
                                "account_info" => array(
                                    "id" => $account_data['id'],
                                    "first_name" => $account_data['first_name'],
                                    'middle_name' => $account_data['middle_name'],
                                    'last_name' => $account_data['last_name'],
                                    'image_url' => $account_data['image']
                                ),
                                "person_info" => array(
                                    "first_name" => $row['first_name'],
                                    "middle_name" => $row['middle_name'],
                                    "last_name" => $row['last_name'],
                                    "age_group" => $row['age_group'],
                                    "sex" => $row['sex'],
                                    "date" => $row['date'],
                                    "reward" => (double)$row['reward'],
                                    "person_image" => 'uploads/lost/persons/' . $row['person_image'],
                                    "location_info" => array(
                                        "id" => $location_data['id'],
                                        "name" => $location_data['name'],
                                        "address" => $location_data['address'],
                                        "latitude" => $location_data['latitude'],
                                        "longitude" => $location_data['longitude']
                                    )
                                )
                            );
                            break;
                        case "Found":
                            $feed_items[$i] = array(
                                "id" => $items[$i]['id'],
                                "item_id" => $items[$i]['item_id'],
                                "type" => $items[$i]['type'],
                                "published_at" => $items[$i]['published_at'],
                                "date_modified" => $items[$i]['date_modified'],
                                "status" => $items[$i]['status'],
                                "account_info" => array(
                                    "id" => $account_data['id'],
                                    "first_name" => $account_data['first_name'],
                                    'middle_name' => $account_data['middle_name'],
                                    'last_name' => $account_data['last_name'],
                                    'image_url' => $account_data['image']
                                ),
                                "person_info" => array(
                                    "first_name" => $row['first_name'],
                                    "middle_name" => $row['middle_name'],
                                    "last_name" => $row['last_name'],
                                    "age_group" => $row['age_group'],
                                    "sex" => $row['sex'],
                                    "date" => $row['date'],
                                    "person_image" => 'uploads/found/persons/' . $row['person_image'],
                                    "location_info" => array(
                                        "id" => $location_data['id'],
                                        "name" => $location_data['name'],
                                        "address" => $location_data['address'],
                                        "latitude" => $location_data['latitude'],
                                        "longitude" => $location_data['longitude']
                                    )
                                )
                            );
                            break;

                    }
                }
            }

        }

        if ($feed_items) {
            $this->response(array(
                "error" => false,
                "total_results" => count($feed_items),
                "feed_items" => $feed_items
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "error" => true,
                "total_results" => count($feed_items)
            ), REST_Controller::HTTP_OK);
        }

    }

    public function total_get()
    {
        $account_id = $this->get('id');

        if (isset($account_id)) {
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                "account_id" => $account_id
            );

            $item_count = $this->item->get($con);
            $this->response(array(
                "status" => true,
                "total_count" => $item_count
            ), REST_Controller::HTTP_OK);

        }

    }

    public function deleteItem_delete($id)
    {
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            "id" => $id
        );
        $item_data = $this->item->get($con);
        if (isset($id)) {
            if ($item_data) {
                $delete_item = $this->item->delete($id);
                if ($delete_item) {
                    $item_type = $item_data['type'];
                    $item_id = $item_data['item_id'];
                    $account_id = $item_data['account_id'];
                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'id' => $item_id
                    );
                    $lost_data = $this->lost_item->get($con);
                    $found_data = $this->found_item->get($con);

                    if ($item_type == "Lost") {
                        //FIXME Delete image from uploads
                        $file_name_path = 'uploads/lost/' . $lost_data['item_image'];
                        echo $file_name_path;
                        if (file_exists($file_name_path)) {
                            chmod($file_name_path, 0777);
                            unlink($file_name_path);
                            $result = $this->lost_item->delete($item_id);
                        } else {
                            $this->response("No image found", REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $file_name_path = 'uploads/found/' . $found_data['item_image'];
                        if (file_exists($file_name_path)) {
                            chmod($file_name_path, 0777);
                            unlink($file_name_path);
                            $result = $this->found_item->delete($item_id);
                        } else {
                            $this->response("No image found", REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }

                    if ($result) {
                        $this->response(array(
                            "deleted" => true,
                            "message" => "Item Deleted",
                            "item_id" => $id,
                            "account_id" => $account_id
                        ), REST_Controller::HTTP_OK);
                    } else {
                        $this->response(array(
                            "deleted" => false,
                            "message" => "Item Not Deleted",
                            "item_id" => $id,
                            "account_id" => $account_id
                        ), REST_Controller::HTTP_OK);
                    }

                } else {
                    $this->response("Failed to Delete", REST_Controller::HTTP_BAD_REQUEST);
                }

            } else {
                $this->response("Item not found", REST_Controller::HTTP_BAD_REQUEST);

            }
        } else {
            $this->response("Please provide item id", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function updateLost_put($id)
    {

        $new_data['item_name'] = $this->put('item_name');
        $new_data['item_description'] = $this->put('item_description');
        $new_data['item_color'] = $this->put('item_color');
        $new_data['location_lost'] = $this->put('location_lost');
        $new_data['date_lost'] = $this->put('date_lost');
        $new_data['item_category'] = $this->put('category');
        $new_data['reward'] = $this->put('reward_amount');
        echo $this->put('item_name');

//        if (isset($id)) {
//            // If ID is found
//            $config['upload_path'] = './uploads/lost/';
//            $config['allowed_types'] = 'gif|jpg|png|jpeg';
//            $this->load->library('upload', $config);
//
//            if ($this->upload->do_upload('item_image')) {
//                $data = array('upload_data' => $this->upload->data());
//                $new_data['item_image'] = $data['upload_data']['file_name'];
//                $result = $this->lost_item->update($new_data, $id);
//                $con['id'] = $id;
//                $updated_data = $this->lost_item->get($con);
//                if ($result) {
//                    $this->response(array(
//                        'status' => true,
//                        'updated_data' => $updated_data
//                    ), REST_Controller::HTTP_OK);
//                } else {
//                    chmod($new_data['item_image'], 0777);
//                    unlink($new_data['item_image']);
//                }
//            } else {
//                $this->response("Failed to Update", REST_Controller::HTTP_BAD_REQUEST);
//            }
//        } else {
//            $this->response("ID are required", REST_Controller::HTTP_BAD_REQUEST);
//        }
    }

    public function updateFound_put($id)
    {
        $update_data['name'] = $this->put('item_name');
        $update_data['description'] = $this->put('item_description');
        $update_data['color'] = $this->put('item_color');
        $update_data['location'] = $this->put('location_found');
        $update_data['date'] = $this->put('date_found');
        $update_data['reward'] = $this->put('reward_amount');

        if (isset($id) && $update_data != null) {
            // If ID is found

        } else {
            $this->response("Found Items are required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function search_get()
    {
        $query = $this->get('q');


        if (isset($query)) {


        } else {


        }
    }

    public function update_item_status_put()
    {
        $new_status = $this->put('status'); //get the status value
        $id = $this->put('id'); //get item id
        //Check if status is not empty
        if (isset($new_status, $id)) {
            //Check first if item exist
            $is_item_exist = $this->item->get(array('id' => $id));
            //Validate Result
            if ($is_item_exist) {
                $result = $this->item->update_status($id, $new_status); //Execute status update
                //Check update result
                if ($result == true) {
                    $this->response(array(
                        'failed' => false,
                        'message' => 'Status update success'
                    ), REST_Controller::HTTP_OK);
                } else {
                    //set response OK but failed
                    $this->response(array(
                        'failed' => true,
                        'message' => 'Status update failed'
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                //set response OK but failed
                $this->response(array(
                    'failed' => true,
                    'message' => 'Item not found'
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response("Status and item id is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
