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
    }

    public function lost_get()
    {
        $id = $this->get('id');
        $limit = $this->get('limit');

        //Return Single Item if ID is provided else all items returned
        if (isset($id)) {
            //TODO Get lost item by id
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
        $items = $this->item->get();
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
                                $feed_items[$i] = array(
                                    "id" => $items[$i]['id'],
                                    "type" => "Lost",
                                    "name" => $lost['item_name'],
                                    "description" => $lost['item_description'],
                                    "category" => $lost['item_category'],
                                    "date" => $lost['date_lost'],
                                    "location" => $lost['location_lost'],
                                    "reward" => $lost['reward'],
                                    "image_url" => 'uploads/lost/' . $lost['item_image'],
                                    "published_at" => $items[$i]['published_at'],
                                    "account" => array(
                                        "id" => $account_data['id'],
                                        "username" => $account_data['username'],
                                        "name" => $account_data['name']
                                    )

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
                                $feed_items[$i] = array(
                                    "id" => $items[$i]['id'],
                                    "type" => "Found",
                                    "name" => $found['item_name'],
                                    "description" => $found['item_description'],
                                    "category" => $found['item_category'],
                                    "date" => $found['date_found'],
                                    "brand" => $found['brand'],
                                    "image_url" => 'uploads/found/' . $found['item_image'],
                                    "published_at" => $items[$i]['published_at'],
                                    "item_surrendered" => $repo['item_received'] == "Yes"? true : false ,
                                    "brgy_id" => $repo['brgy_id'] != null? $repo['brgy_id']: "",
                                    "account" => array(
                                        "id" => $account_data['id'],
                                        "username" => $account_data['username'],
                                        "name" => $account_data['name']
                                    ),
                                    "location_info" => array(
                                        "id" => $location_info['id'],
                                        "name" => $location_info['name'],
                                        "address" => $location_info['address'],
                                        "latitude" => $location_info['latitude'],
                                        "longitude" => $location_info['longitude']
                                    )

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
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Lost",
                            "name" => $lost['item_name'],
                            "description" => $lost['item_description'],
                            "category" => $lost['item_category'],
                            "date" => $lost['date_lost'],
                            "location" => $lost['location_lost'],
                            "reward" => $lost['reward'],
                            "image_url" => 'uploads/lost/' . $lost['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "account" => array(
                                "id" => $account_data['id'],
                                "username" => $account_data['username'],
                                "name" => $account_data['name']
                            )

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
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Found",
                            "name" => $found['item_name'],
                            "description" => $found['item_description'],
                            "category" => $found['item_category'],
                            "date" => $found['date_found'],
                            "brand" => $found['brand'],
                            "image_url" => 'uploads/found/' . $found['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "item_surrendered" => $repo['item_received'] == "Yes"? true : false ,
                            "brgy_id" => $repo['brgy_id'] != null? $repo['brgy_id']: "",
                            "account" => array(
                                "id" => $account_data['id'],
                                "username" => $account_data['username'],
                                "name" => $account_data['name']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            )

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
                    if ($items[$i]['item_id'] == $lost['id'] && $items[$i]['type'] == "Lost") {
                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Lost",
                            "name" => $lost['item_name'],
                            "description" => $lost['item_description'],
                            "category" => $lost['item_category'],
                            "date" => $lost['date_lost'],
                            "location" => $lost['location_lost'],
                            "reward" => $lost['reward'],
                            "image_url" => 'uploads/lost/' . $lost['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "account" => array(
                                "id" => $account_data['id'],
                                "username" => $account_data['username'],
                                "name" => $account_data['name']
                            )

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

                        $feed_items[$i] = array(
                            "id" => $items[$i]['id'],
                            "type" => "Found",
                            "name" => $found['item_name'],
                            "description" => $found['item_description'],
                            "category" => $found['item_category'],
                            "date" => $found['date_found'],
                            "brand" => $found['brand'],
                            "image_url" => 'uploads/found/' . $found['item_image'],
                            "published_at" => $items[$i]['published_at'],
                            "item_surrendered" => $repo['item_received'] == "Yes"? true : false ,
                            "brgy_id" => $repo['brgy_id'] != null? $repo['brgy_id']: "",
                            "account" => array(
                                "id" => $account_data['id'],
                                "username" => $account_data['username'],
                                "name" => $account_data['name']
                            ),
                            "location_info" => array(
                                "id" => $location_info['id'],
                                "name" => $location_info['name'],
                                "address" => $location_info['address'],
                                "latitude" => $location_info['latitude'],
                                "longitude" => $location_info['longitude']
                            )

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
}