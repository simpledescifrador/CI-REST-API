<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Report extends REST_Controller
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
    private function notification_process($item_id, $ids)
    {
        if ($ids != false) {
            $item_data = $this->item->get(array('id' => $item_id));
            $report_type = $item_data['report_type'];
            switch ($report_type) {
                case 'Personal Thing':
                    $found_item = $this->found_item->get(array('id' => $item_data['item_id']));
                    foreach ($ids as $key => $id) {
                        $lost_item = $this->lost_item->get(array('id' => $id));
                        $location_info = $this->item_location->get(array('id' => $found_item['location_id']));
                        /* Save Notification to the database */
                        $notif['title'] = "This item might yours";
                        $notif['content'] = $found_item['item_name'] . " found at " . $location_info['name'];
                        $notif['image_url'] = 'uploads/found/' . $found_item['item_image'];
                        $notif['type'] = "Matchmaking";
                        $notif['ref_id'] = $item_id;
                        $notif['account_id'] = $lost_item['account_id'];
                        $result_insert[$key] = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                    }
                    /* Send Notification to account */
                    foreach ($result_insert as $key => $id) {
                        $notif_row[$key] = $this->notification_model->get(array('id' => $id));
                        $total_notif = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id']
                            )
                        ));
                        $token = $this->account->registered_token($notif_row[$key]['account_id']);

                        $payloads[$key] = array(
                            "to" => $token['token'],
                            "notification" => array(
                                "title" => $notif_row[$key]['title'],
                                "body" => $notif_row[$key]['content'],
                                "click_action" => "Item Detail"
                            ),
                            "data" => array(
                                "id" => $notif_row[$key]['id'],
                                "title" => $notif_row[$key]['title'],
                                "content" => $notif_row[$key]['content'],
                                "image_url" => $notif_row[$key]['image_url'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0
                            )
                        );
                        $this->send_notification($payloads[$key]); /* Send Notification */
                    }
                    break;
                case 'Person':
                    $found_person = $this->person_model->get(array('id' => $item_data['item_id']));
                    foreach ($ids as $key => $id) {
                        $lost_person = $this->person_model->get(array('id' => $id));
                        $location_info = $this->item_location->get(array('id' => $found_person['location_id']));
                        /* Save Notification to the database */
                        $notif['title'] = "This missing person was found";
                        $notif['content'] = $found_person['first_name'] . " " . $found_person['last_name'] . " " . " found at " . $location_info['name'];
                        $notif['image_url'] = 'uploads/found/persons/' . $found_person['person_image'];
                        $notif['type'] = "Matchmaking";
                        $notif['ref_id'] = $item_id;
                        $notif['account_id'] = $lost_person['account_id'];
                        $result_insert[$key] = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                    }
                    foreach ($result_insert as $key => $id) {
                        $notif_row[$key] = $this->notification_model->get(array('id' => $id));
                        $total_notif = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id']
                            )
                        ));
                        $token = $this->account->registered_token($notif_row[$key]['account_id']);
                        $payloads[$key] = array(
                            "to" => $token['token'],
                            "notification" => array(
                                "title" => $notif_row[$key]['title'],
                                "body" => $notif_row[$key]['content'],
                                "click_action" => "Item Detail"
                            ),
                            "data" => array(
                                "id" => $notif_row[$key]['id'],
                                "title" => $notif_row[$key]['title'],
                                "content" => $notif_row[$key]['content'],
                                "image_url" => $notif_row[$key]['image_url'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0
                            )
                        );
                        $this->send_notification($payloads[$key]); /* Send Notification */
                    }
                    break;
                case 'Pet':
                    $found_pet = $this->pet_model->get(array('id' => $item_data['item_id']));
                    foreach ($ids as $key => $id) {
                        $lost_pet = $this->pet_model->get(array('id' => $id));
                        $location_info = $this->item_location->get(array('id' => $found_pet['location_id']));
                        /* Save Notification to the database */
                        $notif['title'] = "This missing pet was found";
                        $notif['content'] = $found_pet['breed'] . " " . $found_pet['type'] . " " . " found at " . $location_info['name'];
                        $notif['image_url'] = 'uploads/found/pets/' . $found_pet['pet_image'];
                        $notif['type'] = "Matchmaking";
                        $notif['ref_id'] = $item_id;
                        $notif['account_id'] = $lost_pet['account_id'];
                        $result_insert[$key] = $this->notification_model->add_notification($notif); /* Save the notification in the database */
                    }

                    foreach ($result_insert as $key => $id) {
                        $notif_row[$key] = $this->notification_model->get(array('id' => $id));
                        $total_notif = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id']
                            )
                        ));
                        $token = $this->account->registered_token($notif_row[$key]['account_id']);
                        $payloads[$key] = array(
                            "to" => $token['token'],
                            "notification" => array(
                                "title" => $notif_row[$key]['title'],
                                "body" => $notif_row[$key]['content'],
                                "click_action" => "Item Detail"
                            ),
                            "data" => array(
                                "id" => $notif_row[$key]['id'],
                                "title" => $notif_row[$key]['title'],
                                "content" => $notif_row[$key]['content'],
                                "image_url" => $notif_row[$key]['image_url'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0
                            )
                        );
                        $this->send_notification($payloads[$key]); /* Send Notification */
                    }
                    break;
            }
        }
    }
    public function matcher_get()
    {
            // $result = $this->item_matchmaking(array(
            //     'Bsjajsjdshfgsf',
            //     'PC / Tablets / Accessories',
            //     'GREEN'
            // ), "Personal Thing");

            // echo $result['total_match'];
            ;
            // $ma = $this->match_making_process(48, 11);
            // print_r($ma);
            // $this->notification_process(48 ,$ma);
    }

    function match_making_process($item_id, $account_id)
    {
        /* Set the Criteria for matchmaking process */
        $thing_criteria = array(
            '1ST' => 'item_name',
            '2ND' => 'item_category',
            '3RD' => 'item_color',
            '4TH' => 'brand'
        );
        $person_criteria = array(
            '1ST' => 'name',
            '3RD' => 'age_group',
            '4TH' => 'sex',
        );
        $pet_criteria = array(
            '1ST' => 'color',
            '2ND' => 'type',
            '3RD' => 'breed',
        );


        /* Get the item data */
        $item_data = $this->item->get(array('id' => $item_id));
        $report_type = $item_data['report_type'];
        $report_id = $item_data['item_id'];

        $points = array();
        $top_similar_item = array();
        $match_item_count = 0;

        /* Get total valid lost item to be check */
        $row_count = $this->item->valid_matchmaking_rows_count($report_type, $account_id);
        $row_ids = $this->item->valid_matchmaking_item_id($report_type, $account_id);

        switch ($report_type) {
            case 'Personal Thing':
                /* Get the newly reported found item data */
                $found_item = $this->found_item->get(array('id' => $report_id));
                for ($i=0; $i < $row_count; $i++) {
                    $id = $row_ids[$i]['item_id'];
                    $lost_item = $this->lost_item->get(array('id', $id));
                    $points[$id] = 0;

                    // $l_item_name_words = explode(" ",$lost_item[$i][$thing_criteria['1ST']]);
                    // $f_item_name_words = explode(" ", $found_item[$thing_criteria['1ST']]);
                    // $item_name_points = 0;
                    // for ($x=0; $x < count($l_item_name_words) ; $x++) {
                    //     for ($z=0; $z < count($f_item_name_words); $z++) {
                    //         if (strtolower($l_item_name_words[$x]) == strtolower($f_item_name_words[$z])) {
                    //             $item_name_points++;
                    //         }
                    //     }
                    // }

                    /* 2ND Criteria by Item Category*/
                    if ($lost_item[$i][$thing_criteria['2ND']] == $found_item[$thing_criteria['2ND']]) {
                        $points[$id]++;
                    }

                    /* 3RD Criteria bt Item color */
                    if (strtolower($lost_item[$i][$thing_criteria['3RD']]) == strtolower($found_item[$thing_criteria['3RD']])) {
                        $points[$id]++;
                    }

                    /* 4TH Criteria bt Item brand */
                    if (strtolower($lost_item[$i][$thing_criteria['4TH']]) == strtolower($found_item[$thing_criteria['4TH']])) {
                        $points[$id]++;
                    }
                }

                /* Arranging Top Similar Items */
                foreach ($points as $key => $value) {
                    if ($value > 2 && $match_item_count < 4) {
                        /* Get Max of Three */
                        $top_similar_item[$match_item_count] = $key;
                        $match_item_count++;
                    }
                }
                // foreach ($top_similar_item as $key => $value) {
                //     $item[$key] = $this->item->get(array('conditions' => array(
                //         'type' => 'Lost',
                //         'status' => 'New',
                //         'report_type' => 'Personal Thing',
                //         'account_id !=' => $account_id,
                //         'item_id' => $value
                //     )));
                //     $match_item[$key] = $item[$key][0]['id'];
                // }

                return $top_similar_item? $top_similar_item : false;
                break;
            case 'Person':
                $found_person = $this->person_model->get(array('id' => $report_id));
                for ($i=0; $i < $row_count; $i++) {
                    $id = $row_ids[$i]['item_id']; /* Get the lost person id */
                    $lost_person = $this->person_model->get(array('id' => $id));

                    $points[$id] = 0; /* Reset Points */

                    /* 1st Person Criteria */
                    if (strtolower($lost_person[$person_criteria['1ST']]) == strtolower($found_person[$person_criteria['1ST']])) {
                        $points[$id]++;
                    }

                    // /* 2nd Person Criteria */
                    // if (strtolower($lost_person[$person_criteria['2ND']]) == strtolower($found_person[$person_criteria['2ND']])) {
                    //     $points[$id]++;
                    // }

                    /* 3rd Person Criteria */
                    if ($lost_person[$person_criteria['3RD']] == $found_person[$person_criteria['3RD']]) {
                        $points[$id]++;
                    } else {
                        $points[$id] = 0;
                    }

                    /* 4th Person Criteria */
                    if ($lost_person[$person_criteria['4TH']] == $found_person[$person_criteria['4TH']]) {
                        $points[$id]++;
                    } else {
                        $points[$id] = 0;
                    }

                }
                /* Arranging Top Similar Items */
                foreach ($points as $key => $value) {
                    if ($value > 2 && $match_item_count < 4) {
                        /* Get Max of Three */
                        $top_similar_item[$match_item_count] = $key;
                        $match_item_count++;
                    }
                }
                return $top_similar_item? $top_similar_item : false;
                break;
            case 'Pet':
                $found_pet = $this->pet_model->get(array('id' => $report_id));
                for ($i=0; $i < $row_count; $i++) {
                    $id = $row_ids[$i]['item_id']; /* Get the lost pet id */
                    $lost_pet = $this->pet_model->get(array('id' => $id));

                    $points[$id] = 0; /* Reset Points */

                    // /* 1st Pet Criteria */
                    // if (strtolower($lost_pet[$pet_criteria['1ST']]) == strtolower($found_pet[$pet_criteria['1ST']])) {
                    //     $points[$id]++;
                    // }

                    /* 2nd Pet Criteria */
                    if ($lost_pet[$pet_criteria['2ND']] == $found_pet[$pet_criteria['2ND']]) {
                        $points[$id]++;
                    } else {
                        $points[$id] = 0; /* This new found is not match */
                    }

                    // /* 3RD Pet Criteria */
                    if (strtolower($lost_pet[$pet_criteria['3RD']]) == strtolower($found_pet[$pet_criteria['3RD']])) {
                        $points[$id]++;
                    }
                }

                /* Arranging Top Similar Items */
                foreach ($points as $key => $value) {
                    if ($value > 1 && $match_item_count < 4) {
                        /* Get Max of Three */
                        $top_similar_item[$match_item_count] = $key;
                        $match_item_count++;
                    }
                }
                return $top_similar_item? $top_similar_item : false;
                break;

        }
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
                        'report_type' => 'Personal Thing',
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

                        //Redirect to item matchmaking process
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
                        'report_type' => 'Personal Thing',
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
                        $match_results = $this->match_making_process($item_id, $found_item['account_id']);
                        $this->notification_process($item_id, $match_results); // Save and Send notification
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

        if ($report_type == "Lost") {
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
                            'report_type' => 'Pet',
                            'account_id' => $pet_data['account_id']
                        );
                        $item_id = $this->item->insert($item); // If insert success returns the insert id else false

                        //check if the location exist
                        $location_exist = $this->item_location->get(array('id' => $location_info['id']));
                        if (!$location_exist) {
                            $this->item_location->insert($location_info); //Insert new location if not on location table
                        }


                        if ($item_id == true) {
                            if ($report_type = "Found") {
                                $match_results = $this->match_making_process($item_id, $pet_data['account_id']);
                                $this->notification_process($item_id, $match_results); // Save and Send notification
                            }
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

        $person_data['name'] = $this->post('name');
        $person_data['age_group'] = $this->post('age_group');
        $person_data['age_range'] = $this->post('age_range');
        $person_data['sex'] = $this->post('sex');
        $person_data['date'] = $this->post('date');
        $person_data['description'] = $this->post('description');

        if ($report_type == "Lost") {
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
                            'report_type' => 'Person',
                            'account_id' => $person_data['account_id']
                        );
                        $item_id = $this->item->insert($item); // If insert success returns the insert id else false

                        //check if the location exist
                        $location_exist = $this->item_location->get(array('id' => $location_info['id']));
                        if (!$location_exist) {
                            $this->item_location->insert($location_info); //Insert new location if not on location table
                        }


                        if ($item_id == true) {
                            if ($report_type = "Found") {
                                $match_results = $this->match_making_process($item_id, $person_data['account_id']);
                                $this->notification_process($item_id, $match_results); // Save and Send notification
                            }
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
                        $this->response("Report Failed", REST_Controller::HTTP_BAD_REQUEST);
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
