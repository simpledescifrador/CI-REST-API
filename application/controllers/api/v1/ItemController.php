<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ItemController extends REST_Controller
{
    /**
     * Initialize/Load all configurations and models
     */
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
        $this->load->model('barangay');
        $this->load->model('pet_model');
        $this->load->model('person_model');
        $this->load->model('user');


        $this->load->model('notification_model');
    }

    /**
     * GET Item Details
     * HTTP Request Method: GET
     * Item ID
     * URL Route:
     */
    public function item_details_get($item_id)
    {
        $item = $this->item->get(array('id' => $item_id));

        //Check the item reported by
        $reported_by = $item['reported_by'];
        $postedBy = "";
        $accountImage = "";
        if ($reported_by == "Mobile User") {
            $account_data = $this->account->get(array("id" => $item['account_id'])); //get account_data
            $postedBy = $account_data['first_name'] . " " . $account_data['last_name'];
            $accountImage = "http://makatizen.x10host.com/" . $account_data['image'];
        } else {
            $account_data = $this->barangay->get_brgyuser_details(array("id" => $item['account_id']));
            $user_data = $this->user->getRows(array('id' => $account_data['brgy_account_id']));

            //Get Barangay Details
            $barangayData = $this->barangay->get(array('id' => $user_data['brgy_id']));
            $accountImage = base_url() . $barangayData['logo'];
            $postedBy = "Brgy. " . ucwords(strtolower($barangayData['name']));
        }

        switch ($item['report_type']) {
            case "Personal Thing":
                if ($item['type'] == "Lost") {
                    $lost_item_id = $item['item_id'];
                    $lost_item = $this->lost_item->get(array("id" => $lost_item_id));
                    $location_data = $this->item_location->get(array("id" => $lost_item['location_id']));
                    $item_images = $this->item->get_item_images($item['id']);
                    $images = array();

                    foreach ($item_images as $key => $value) {
                        $images[] = $value['file_path'];
                    }

                    $this->response(array(
                        "title" => $lost_item['item_name'],
                        "type" => $item['type'],
                        "report_type" => $item['report_type'],
                        "reported_by" => $item['reported_by'],
                        "created_at" => $item['published_at'],
                        "location_data" => $location_data,
                        "account_data" => array(
                            "id" => $account_data['id'],
                            "first_name" => $postedBy,
                            "last_name" => "",
                            "profile_image_url" =>  $accountImage
                        ),
                        "pt_data" => array(
                            "category" => ucwords(strtolower($lost_item['item_category'])),
                            "date" => $lost_item['date_lost'],
                            "description" => $lost_item['item_description'],
                            "brand" => $lost_item['brand'],
                            "color" => $lost_item['item_color'],
                            "reward" => (double)$lost_item['reward'],
                            "item_images" => $images,
                            "additional_location_info" => $lost_item['additional_location_info']
                        )
                    ), REST_Controller::HTTP_OK);
                } else {
                    $found_item_id = $item['item_id'];
                    $found_item = $this->found_item->get(array('id' => $found_item_id));
                    $location_data = $this->item_location->get(array("id" => $found_item['location_id']));

                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'item_id' => $item['id']
                    );
                    $repo = $this->repository->get($con);
                    $barangay = $this->barangay->get(array('id' => $repo['brgy_id']));

                    $item_images = $this->item->get_item_images($item['id']);
                    $images = array();

                    foreach ($item_images as $key => $value) {
                        $images[] = $value['file_path'];
                    }
                    $this->response(array(
                        "title" => $found_item['item_name'],
                        "type" => $item['type'],
                        "report_type" => $item['report_type'],
                        "reported_by" => $item['reported_by'],
                        "created_at" => $item['published_at'],
                        "location_data" => $location_data,
                        "account_data" => array(
                            "id" => $account_data['id'],
                            "first_name" => $postedBy,
                            "last_name" => "",
                            "profile_image_url" =>  $accountImage
                        ),
                        "pt_data" => array(
                            "category" => ucwords(strtolower($found_item['item_category'])),
                            "date" => $found_item['date_found'],
                            "description" => $found_item['item_description'],
                            "brand" => $found_item['brand'],
                            "color" => $found_item['item_color'],
                            "item_images" => $images,
                            "additional_location_info" => $found_item['additional_location_info'],
                            "item_surrendered" => $repo['item_received'] == "Yes" ? true : false,
                            "date_surrendered" => $repo['date_item_received'],
                            "barangay_data" => array(
                                "id" => (int)$barangay['id'],
                                "name" => ucwords(strtolower($barangay['name'])),
                                "address" => $barangay['address'],
                                "district_no" => (int)$barangay['district_no'],
                                "latitude" => $barangay['latitude'],
                                "longitude" => $barangay['longitude']
                            )
                        )
                    ), REST_Controller::HTTP_OK);
                }
                break;
            case "Pet":
                $pet_item = $this->pet_model->get(array('id' => $item['item_id']));
                $location_data = $this->item_location->get(array("id" => $pet_item['location_id']));
                $item_images = $this->item->get_item_images($item['id']);
                $images = array();

                foreach ($item_images as $key => $value) {
                    $images[] = $value['file_path'];
                }
                $this->response(array(
                    "title" => $pet_item['breed'] . " " . ucfirst(strtolower($pet_item['type'])),
                    "type" => $item['type'],
                    "report_type" => $item['report_type'],
                    "reported_by" => $item['reported_by'],
                    "created_at" => $item['published_at'],
                    "location_data" => $location_data,
                    "account_data" => array(
                        "id" => $account_data['id'],
                        "first_name" => $postedBy,
                        "last_name" => "",
                        "profile_image_url" =>  $accountImage
                    ),
                    "pet_data" => array(
                        "name" => ucfirst(strtolower($pet_item['pet_name'])),
                        "pet_type" => ucfirst(strtolower($pet_item['type'])),
                        "breed" => $pet_item['breed'],
                        "condition" => $pet_item['pet_condition'],
                        "description" => $pet_item['description'],
                        "date" => $pet_item['date'],
                        "pet_images" => $images,
                        "additional_location_info" => $pet_item['additional_location_info'],
                        "reward" => (double)$pet_item['reward'],
                    )
                ), REST_Controller::HTTP_OK);
                break;
            case "Person":
                $person_item = $this->person_model->get(array('id' => $item['item_id']));
                $location_data = $this->item_location->get(array("id" => $person_item['location_id']));
                $item_images = $this->item->get_item_images($item['id']);
                $images = array();

                foreach ($item_images as $key => $value) {
                    $images[] = $value['file_path'];
                }
                $this->response(array(
                    "title" => $person_item['sex'] . " " . $person_item['age_group'] . " " . $person_item['age_range'] . " years old",
                    "type" => $item['type'],
                    "report_type" => $item['report_type'],
                    "reported_by" => $item['reported_by'],
                    "created_at" => $item['published_at'],
                    "location_data" => $location_data,
                    "account_data" => array(
                        "id" => $account_data['id'],
                        "first_name" => $postedBy,
                        "last_name" => "",
                        "profile_image_url" =>  $accountImage
                    ),
                    "person_data" => array(
                        "name" => $person_item['name'],
                        "age_group" => $person_item['age_group'],
                        "age_range" => $person_item['age_range'],
                        "sex" => $person_item['sex'],
                        "date" => $person_item['date'],
                        "person_images" => $images,
                        "description" => $person_item['description'],
                        "additional_location_info" => $person_item['additional_location_info'],
                        "reward" => (double)$person_item['reward'],
                    )
                ), REST_Controller::HTTP_OK);
                break;
        }

    }

    /**
     * GET Account Item Images
     * HTTP Request Method: GET
     * Account ID
     * URL Route: api/v1/accounts/($account_id)/images
     */
    public function account_item_images_get($account_id){
        $images = array();
        if (!empty($account_id)) {
            $items = $this->item->get(
                array(
                    'conditions' => array(
                        'account_id' => $account_id
                    )
                )
            );
            if ($items) {
                foreach ($items as $key => $value) {
                    // echo $value['id'] . "\n";
                    $item_images = $this->item->get_item_images($value['id']);
                    for ($i=0; $i < count($item_images); $i++) {
                        // echo $item_images[$i]['file_path'] . "\n";
                        $images[] = $item_images[$i]['file_path'];
                    }
                }

                $this->response($images, REST_Controller::HTTP_OK);
            } else {
                $this->response(array(), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response("Account id is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * GET Item Images
     * HTTP Request Method: GET
     * Item ID
     * URL Route: api/v1/items/($item_id)/images
     */
    public function item_images_get($item_id)
    {
        if (!empty($item_id)) {
            $item_images = $this->item->get_item_images($item_id);
            $images_url = array();
            if ($item_images) {
                for ($i = 0; $i < count($item_images); $i++) {
                    $images_url[$i] = $item_images[$i]['file_path'];
                }
                $this->response($images_url, REST_Controller::HTTP_OK);
            } else {
                $this->response("Retrieving images error", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Item id is required", REST_Controller::HTTP_BAD_REQUEST);
        }


    }

    /**
     * GET Latest Account Reports/Feed Items
     * HTTP Request Method: GET
     * Account ID is requred
     * URL Route: api/v1/accounts/($account_id)/items
     */
    public function account_latest_feed_get($account_id){
        $lost_item = $this->lost_item->get();
        $found_item = $this->found_item->get();
        $pet = $this->pet_model->get();
        $person = $this->person_model->get();
        $items = $this->item->get(
            array(
                'conditions' => array(
                    'account_id' => $account_id
                )
            )
        );

        $feed_items = array();
        //null array fix
        $lost_item = $lost_item != NULL ? $lost_item : array();
        $found_item = $found_item != NULL ? $found_item : array();
        $pet = $pet != NULL ? $pet : array();
        $person = $person != NULL ? $person : array();

        $item_count = $items == null? 0: count($items);

        for ($i = 0; $i <$item_count; $i++) {
            //do the magic here get all the data from items and make a response
            $account_data = $this->account->get(array("id" => $items[$i]['account_id'])); //get account_data
            foreach ($lost_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Lost" && $items[$i]['report_type'] == "Personal Thing") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);

                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $account_data['first_name'] . " " . $account_data['last_name'],
                        "account_image_url" => $account_data['image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['item_name'])),
                        "item_description" => ucfirst($row['item_description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );
                }
            }

            foreach ($found_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Found" && $items[$i]['report_type'] == "Personal Thing") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $account_data['first_name'] . " " . $account_data['last_name'],
                        "account_image_url" => $account_data['image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['item_name'])),
                        "item_description" => ucfirst($row['item_description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );
                }
            }

            foreach ($pet as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['report_type'] == "Pet") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $account_data['first_name'] . " " . $account_data['last_name'],
                        "account_image_url" => $account_data['image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => $row['breed'] . " " . $row['type'],
                        "item_description" => ucfirst($row['description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );
                }
            }

            foreach ($person as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['report_type'] == "Person") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $account_data['first_name'] . " " . $account_data['last_name'],
                        "account_image_url" => $account_data['image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['sex'] . " " . $row['age_group'] . " " . $row['age_range'])) . " years old",
                        "item_description" => ucfirst($row['description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );
                }
            }
        }

        if ($feed_items) {
            $this->response(array(
                "total_results" => count($feed_items),
                "feed_items" => $feed_items
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "total_results" => 0,
                "feed_items" => array()
            ), REST_Controller::HTTP_OK);
        }
    }

    /**
     * GET Latest Feed Items
     * HTTP Request Method: GET
     * No Required Params
     * URL Route: api/v1/items
     */
    public function latest_feed_get()
    {

        $w_latlng = (bool) $this->get('wlatlng');


        $lost_item = $this->lost_item->get();
        $found_item = $this->found_item->get();
        $pet = $this->pet_model->get();
        $person = $this->person_model->get();

        $items_con['conditions'] = array(
            'status' => 'New'
        );
        $items = $this->item->get($items_con);
        $feed_items = array();
        //null array fix
        $lost_item = $lost_item != NULL ? $lost_item : array();
        $found_item = $found_item != NULL ? $found_item : array();
        $pet = $pet != NULL ? $pet : array();
        $person = $person != NULL ? $person : array();

        $item_count = $items == null? 0: count($items);
        for ($i = 0; $i < $item_count; $i++) {

            //Check the item reported by
            $reported_by = $items[$i]['reported_by'];
            $postedBy = "";
            $accountImage = "";
            if ($reported_by == "Mobile User") {
                $account_data = $this->account->get(array("id" => $items[$i]['account_id'])); //get account_data
                $postedBy = $account_data['first_name'] . " " . $account_data['last_name'];
                $accountImage = "http://makatizen.x10host.com/" . $account_data['image'];
            } else {
                $account_data = $this->barangay->get_brgyuser_details(array("id" => $items[$i]['account_id']));
                $user_data = $this->user->getRows(array('id' => $account_data['brgy_account_id']));

                //Get Barangay Details
                $barangayData = $this->barangay->get(array('id' => $user_data['brgy_id']));
                $accountImage = base_url() . $barangayData['logo'];
                $postedBy = "Brgy. " . ucwords(strtolower($barangayData['name']));
            }

            foreach ($lost_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Lost" && $items[$i]['report_type'] == "Personal Thing") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);

                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $postedBy,
                        "account_image_url" => $accountImage,
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['item_name'])),
                        "item_description" => ucfirst($row['item_description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );

                    if ($w_latlng) {
                        $feed_items[$i]['location_latlng'] = array(
                            'latitude'   => (double) $location_data['latitude'],
                            'longitude' => (double)$location_data['longitude']
                        );
                    }

                }
            }

            foreach ($found_item as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['type'] == "Found" && $items[$i]['report_type'] == "Personal Thing") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $postedBy,
                        "account_image_url" => $accountImage,
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['item_name'])),
                        "item_description" => ucfirst($row['item_description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );

                    if ($w_latlng) {
                        $feed_items[$i]['location_latlng'] = array(
                            'latitude'   => (double) $location_data['latitude'],
                            'longitude' => (double)$location_data['longitude']
                        );
                    }
                }
            }

            foreach ($pet as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['report_type'] == "Pet") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $postedBy,
                        "account_image_url" => $accountImage,
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => $row['breed'] . " " . $row['type'],
                        "item_description" => ucfirst($row['description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );

                    if ($w_latlng) {
                        $feed_items[$i]['location_latlng'] = array(
                            'latitude'   => (double) $location_data['latitude'],
                            'longitude' => (double)$location_data['longitude']
                        );
                    }
                }
            }

            foreach ($person as $row) {
                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                if ($items[$i]['item_id'] == $row['id'] && $items[$i]['report_type'] == "Person") {
                    $item_images = $this->item->get_item_images($items[$i]['id']);
                    $feed_items[$i] = array(
                        "item_id" => (int)$items[$i]['id'],
                        "item_type" => $items[$i]['type'],
                        "item_created_at" => $items[$i]['published_at'],
                        "item_status" => $items[$i]['status'],
                        "account_name" => $postedBy,
                        "account_image_url" => $accountImage,
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['sex'] . " " . $row['age_group'] . " " . $row['age_range'])) . " years old",
                        "item_description" => ucfirst($row['description']),
                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                    );

                    if ($w_latlng) {
                        $feed_items[$i]['location_latlng'] = array(
                            'latitude'   => (double) $location_data['latitude'],
                            'longitude' => (double)$location_data['longitude']
                        );
                    }
                }
            }
        }

        if ($feed_items) {
            $this->response(array(
                "total_results" => count($feed_items),
                "feed_items" => $feed_items
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "total_results" => 0,
                "feed_items" => array()
            ), REST_Controller::HTTP_OK);
        }
    }

    public function map_items_get()
    {
        $data = array();

        //Get Item Locations
        $locations = $this->item_location->get();

        if ($locations) {
            for ($i=0; $i < count($locations); $i++) {
                $id = $locations[$i]['id'];
                $name = $locations[$i]['name'];
                $address = $locations[$i]['address'];
                $lat = $locations[$i]['latitude'];
                $lng = $locations[$i]['longitude'];

                $item_id_holder = array();

                //Check for lost Item;
                $lost_data = $this->lost_item->get(array(
                    'conditions' => array(
                        'location_id' => $id
                    )
                ));

                if ($lost_data) {
                    foreach ($lost_data as $key => $value) {
                        //Check if the item is valid
                        $valid_item = $this->item->get(array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'status' => 'New',
                                'type' => 'Lost',
                                'report_type' => 'Personal Thing',
                                'item_id' => $value['id']
                            )
                        ));

                        if ($valid_item) {
                            $item_id_holder[] = $valid_item['id'];
                        }
                    }
                }

                //Check for found Item;
                $found_data = $this->found_item->get(array(
                    'conditions' => array(
                        'location_id' => $id
                    )
                ));

                if ($found_data) {
                    foreach ($found_data as $key => $value) {
                        //Check if the item is valid
                        $valid_item = $this->item->get(array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'status' => 'New',
                                'type' => 'Found',
                                'report_type' => 'Personal Thing',
                                'item_id' => $value['id']
                            )
                        ));

                        if ($valid_item) {
                            $item_id_holder[] = $valid_item['id'];
                        }
                    }
                }

                //Check for pet;
                $pet_data = $this->pet_model->get(array(
                    'conditions' => array(
                        'location_id' => $id
                    )
                ));

                if ($pet_data) {
                    foreach ($pet_data as $key => $value) {
                        //Check if the item is valid
                        $valid_item = $this->item->get(array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'status' => 'New',
                                'report_type' => 'Pet',
                                'item_id' => $value['id']
                            )
                        ));

                        if ($valid_item) {
                            $item_id_holder[] = $valid_item['id'];
                        }
                    }
                }

                //Check for person;
                $person_data = $this->person_model->get(array(
                    'conditions' => array(
                        'location_id' => $id
                    )
                ));

                if ($person_data) {
                    foreach ($person_data as $key => $value) {
                        //Check if the item is valid
                        $valid_item = $this->item->get(array(
                            'returnType' => 'single',
                            'conditions' => array(
                                'status' => 'New',
                                'report_type' => 'Person',
                                'item_id' => $value['id']
                            )
                        ));

                        if ($valid_item) {
                            $item_id_holder[] = $valid_item['id'];
                        }
                    }
                }


                if (count($item_id_holder) > 0) {
                    $feed_items = array();
                    //Get The Item Details
                    foreach ($item_id_holder as $key => $value) {
                        $item = $this->item->get(array('id' => $value));

                        //Check the item reported by
                        $reported_by = $item['reported_by'];
                        $postedBy = "";
                        $accountImage = "";
                        if ($reported_by == "Mobile User") {
                            $account_data = $this->account->get(array("id" => $item['account_id'])); //get account_data
                            $postedBy = $account_data['first_name'] . " " . $account_data['last_name'];
                            $accountImage = "http://makatizen.x10host.com/" . $account_data['image'];
                        } else {
                            $account_data = $this->barangay->get_brgyuser_details(array("id" => $item['account_id']));
                            $user_data = $this->user->getRows(array('id' => $account_data['brgy_account_id']));

                            //Get Barangay Details
                            $barangayData = $this->barangay->get(array('id' => $user_data['brgy_id']));
                            $accountImage = base_url() . $barangayData['logo'];
                            $postedBy = "Brgy. " . ucwords(strtolower($barangayData['name']));
                        }

                        switch ($item['report_type']) {
                            case 'Personal Thing':
                                if ($item['type'] == 'Lost') {
                                    $row = $this->lost_item->get(array('id' => $item['item_id']));
                                    $location_data = $this->item_location->get(array("id" => $row['location_id']));
                                    $item_images = $this->item->get_item_images($item['id']);

                                    if ($row['location_id'] != $id) {
                                        continue;
                                    }

                                    $feed_items[] = array(
                                        "item_id" => (int)$item['id'],
                                        "item_type" => $item['type'],
                                        "item_created_at" => $item['published_at'],
                                        "item_status" => $item['status'],
                                        "account_name" => $postedBy,
                                        "account_image_url" => $accountImage,
                                        "item_image_url" => $item_images[0]['file_path'],
                                        "item_title" => ucfirst(strtolower($row['item_name'])),
                                        "item_description" => ucfirst($row['item_description']),
                                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                                    );

                                } else {
                                    $row = $this->found_item->get(array('id' => $item['item_id']));
                                    $location_data = $this->item_location->get(array("id" => $row['location_id']));
                                    $item_images = $this->item->get_item_images($item['id']);
                                    if ($row['location_id'] != $id) {
                                        continue;
                                    }
                                    $feed_items[] = array(
                                        "item_id" => (int)$item['id'],
                                        "item_type" => $item['type'],
                                        "item_created_at" => $item['published_at'],
                                        "item_status" => $item['status'],
                                        "account_name" => $postedBy,
                                        "account_image_url" => $accountImage,
                                        "item_image_url" => $item_images[0]['file_path'],
                                        "item_title" => ucfirst(strtolower($row['item_name'])),
                                        "item_description" => ucfirst($row['item_description']),
                                        "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                                    );
                                }
                                break;
                            case 'Pet':
                                $row = $this->pet_model->get(array('id' => $item['item_id']));
                                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                                $item_images = $this->item->get_item_images($item['id']);
                                if ($row['location_id'] != $id) {
                                    continue;
                                }
                                $feed_items[] = array(
                                    "item_id" => (int)$item['id'],
                                    "item_type" => $item['type'],
                                    "item_created_at" => $item['published_at'],
                                    "item_status" => $item['status'],
                                    "account_name" => $postedBy,
                                    "account_image_url" => $accountImage,
                                    "item_image_url" => $item_images[0]['file_path'],
                                    "item_title" => $row['breed'] . " " . $row['type'],
                                    "item_description" => ucfirst($row['description']),
                                    "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                                );
                                break;
                            case 'Person':
                                $row = $this->person_model->get(array('id' => $item['item_id']));
                                $location_data = $this->item_location->get(array("id" => $row['location_id']));
                                $item_images = $this->item->get_item_images($item['id']);
                                if ($row['location_id'] != $id) {
                                    continue;
                                }
                                $feed_items[] = array(
                                    "item_id" => (int)$item['id'],
                                    "item_type" => $item['type'],
                                    "item_created_at" => $item['published_at'],
                                    "item_status" => $item['status'],
                                    "account_name" => $postedBy,
                                    "account_image_url" => $accountImage,
                                    "item_image_url" => $item_images[0]['file_path'],
                                    "item_title" => ucfirst(strtolower($row['sex'] . " " . $row['age_group'] . " " . $row['age_range'])) . " years old",
                                    "item_description" => ucfirst($row['description']),
                                    "item_location" => $row['additional_location_info'] . " " . $location_data['name'],
                                );
                                break;
                        }


                    }

                    if (count($feed_items) > 0) {
                        $data[] = array(
                            'id' => $id,
                            'title' => $name,
                            'address' => $address,
                            'lat' => $lat,
                            'lng' => $lng,
                            'data' => $feed_items
                        );
                    }
                }

            }

            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response($data, REST_Controller::HTTP_OK);
        }

    }

    public function report_item_post()
    {
        $item_id = $this->post('item_id');
        $reported_by = $this->post('reported_by');
        $reason = $this->post('reason');

        if (isset($item_id, $reported_by, $reason)) {
            //Check if the item exists
            $item_exists = $this->item->get(array(
                'id' => $item_id
            ));

            if ($item_exists) {
                //insert new item report
                $insert_result = $this->item->add_item_report(array(
                    'item_id' => $item_id,
                    'reported_by' => $reported_by,
                    'reason' => $reason,
                    'date_reported' => date("Y-m-d H:i:s")
                ));

                if ($insert_result) {
                    $this->response(array(
                        'status' => 1,
                        'message' => 'Successfully Reported'
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'status' => 0,
                        'message' => 'Failed to report. Database Error Occured'
                    ), REST_Controller::HTTP_OK);
                }

            } else {
                $this->response("Item not found", REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->response("Item Id, Reported by and Reason are required!", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function check_reported_item_get()
    {
        $item_id = $this->get('item_id');
        $account_id = $this->get('account_id');

        if (isset($item_id, $account_id)) {
            //Check if item was already reported
            $result = $this->item->get_item_reports(array(
                'returnType' => 'count',
                'conditions' => array(
                    'item_id' => $item_id,
                    'reported_by' => $account_id
                )
            ));

            if ($result) {
                $this->response(array(
                    'status' => 1,
                    'message' => 'Already Reported'
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'status' => 0,
                    'message' => 'No report found'
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response("Item Id and Account are required!", REST_Controller::HTTP_BAD_REQUEST);
        }

    }
}