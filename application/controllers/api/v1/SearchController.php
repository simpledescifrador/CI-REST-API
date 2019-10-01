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
                    $item_images = $this->item->get_item_images($row['id']);

                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Lost',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['pt_name'])),
                        "item_description" => ucfirst($row['pt_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($found_pt_result) > 0) {
                foreach ($found_pt_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);

                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['pt_name'])),
                        "item_description" => ucfirst($row['pt_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($pets_result) > 0) {
                foreach ($pets_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);

                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => $row['pet_breed'] . " " . $row['pet_type'],
                        "item_description" => ucfirst($row['pet_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($persons_result) > 0) {
                foreach ($persons_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);

                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['person_sex'] . " " . $row['person_age_group'] . " " . $row['person_age_range'])) . " years old",
                        "item_description" => ucfirst($row['person_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }
        } else if (isset($filter_value)) {
            $chunks = array_chunk(preg_split('/(:|,)/', $filter_value), 2);
            $filter_con = array_combine(str_replace(" ", "_", array_column($chunks, 0)), array_column($chunks, 1));

            $con['conditions'] = $filter_con;
            $lost_pt_result = array();
            $found_pt_result = array();
            $pets_result = array();
            $persons_result = array();

            if (array_key_exists('report_type', $filter_con)) {
                switch ($filter_con['report_type']) {
                    case 'personal thing':
                        if (array_key_exists('item_type', $filter_con)) {
                            if ($filter_con['item_type'] == 'lost') {
                                $lost_pt_result = $this->item->fetch_lost_pt($query, $con);
                            } else {
                                $found_pt_result = $this->item->fetch_found_pt($query, $con);
                            }
                        } else {
                            $lost_pt_result = $this->item->fetch_lost_pt($query, $con);
                            $found_pt_result = $this->item->fetch_found_pt($query, $con);
                        }
                        break;
                    case 'pet':
                        $pets_result = $this->item->fetch_pets($query, $con);
                        break;
                    case 'person':
                        $persons_result = $this->item->fetch_persons($query, $con);
                        break;
                }
            } else {
                if (array_key_exists('item_type', $filter_con)) {
                    if ($filter_con['item_type'] == 'lost') {
                        $lost_pt_result = $this->item->fetch_lost_pt($query, $con);
                    } else {
                        $found_pt_result = $this->item->fetch_found_pt($query, $con);
                    }
                } else {
                    $lost_pt_result = $this->item->fetch_lost_pt($query, $con);
                    $found_pt_result = $this->item->fetch_found_pt($query, $con);
                }
                $pets_result = $this->item->fetch_pets($query, $con);
                $persons_result = $this->item->fetch_persons($query, $con);
            }

            if (count($lost_pt_result) > 0) {
                foreach ($lost_pt_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);
                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Lost',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['pt_name'])),
                        "item_description" => ucfirst($row['pt_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($found_pt_result) > 0) {
                foreach ($found_pt_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);
                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['pt_name'])),
                        "item_description" => ucfirst($row['pt_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($pets_result) > 0) {
                foreach ($pets_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);
                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => $row['pet_breed'] . " " . $row['pet_type'],
                        "item_description" => ucfirst($row['pet_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
                    );
                }
            }

            if (count($persons_result) > 0) {
                foreach ($persons_result as $row) {
                    $item_images = $this->item->get_item_images($row['id']);
                    $match_items[] = array(
                        "item_id" => (int)$row['id'],
                        "item_type" => 'Found',
                        "item_created_at" => $row['item_published_date'],
                        "item_status" => $row['item_status'],
                        "account_name" => $row['account_fname'] . " " . $row['account_lname'],
                        "account_image_url" => $row['account_image'],
                        "item_image_url" => $item_images[0]['file_path'],
                        "item_title" => ucfirst(strtolower($row['person_sex'] . " " . $row['person_age_group'] . " " . $row['person_age_range'])) . " years old",
                        "item_description" => ucfirst($row['person_description']),
                        "item_location" => ltrim($row['add_location_info']) . " " . $row['location_name'],
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