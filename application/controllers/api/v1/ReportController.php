<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ReportController extends REST_Controller
{
    /**
     * Initialize/Load all configurations and models
     */
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
        $this->load->model('barangay');


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
            //Item Images
            $item_images = $this->item->get_item_images($item_id);
            switch ($report_type) {
                case 'Personal Thing':
                    $found_item = $this->found_item->get(array('id' => $item_data['item_id']));
                    foreach ($ids as $key => $id) {
                        $lost_item = $this->lost_item->get(array('id' => $id));
                        $location_info = $this->item_location->get(array('id' => $found_item['location_id']));
                        /* Save Notification to the database */
                        $notif['title'] = "This item might yours";
                        $notif['content'] = $found_item['item_name'] . " found at " . $location_info['name'];
                        $notif['image_url'] = /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'];
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

                        $total_unviewed = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id'],
                                'is_read' => 'No'
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
                                "image_url" => /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0,
                                "total_unviewed_notifications" => (int) isset($total_unviewed)? $total_unviewed: 0
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
                        $notif['image_url'] = /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'];
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
                        $total_unviewed = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id'],
                                'is_read' => 'No'
                            )
                        ));
                        $token = $this->account->registered_token($notif_row[$key]['account_id']);
                        //Item Images
                        $item_images = $this->item->get_item_images($notif_row[$key]['ref_id']);

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
                                "image_url" => /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0,
                                "total_unviewed_notifications" => (int) isset($total_unviewed)? $total_unviewed: 0
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
                        $notif['image_url'] = /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'];
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
                        $total_unviewed = $this->notification_model->get(array(
                            'returnType' => 'count',
                            'conditions' => array(
                                'account_id' => $notif_row[$key]['account_id'],
                                'is_read' => 'No'
                            )
                        ));
                        $token = $this->account->registered_token($notif_row[$key]['account_id']);
                        //Item Images
                        $item_images = $this->item->get_item_images($notif_row[$key]['ref_id']);

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
                                "image_url" => /* base_url() */ 'http://192.168.43.35/makahanap/' . $item_images[0]['file_path'],
                                "created_at" => $notif_row[$key]['created_at'],
                                "viewed" => $notif_row[$key]['is_read'],
                                "type" => "Matchmaking",
                                "ref_id" => (int) $notif_row[$key]['ref_id'],
                                "account_id" => (int) $notif_row[$key]['account_id'],
                                "total_notifications" => (int) isset($total_notif)? $total_notif : 0,
                                "total_unviewed_notifications" => (int) isset($total_unviewed)? $total_unviewed: 0
                            )
                        );
                        $this->send_notification($payloads[$key]); /* Send Notification */
                    }
                    break;
            }
        }
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

    /**
     * Report Lost/Found Personal Things
     * HTTP Request Method: POST
     * Lost/Found Personal Item Details is Required
     * URL Route: api/v1/report/pt
     */
    public function report_item_pt_post()
    {
        //Location info
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $type = $this->post('type');

        $location_brgy = $this->post('location_brgy');

        switch ($type) {
            case "Lost":
                /*IF LOST ITEM*/
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
                $lost_item['additional_location_info'] = $this->post('additional_location_info');

                $id = '';
                $reported_by = '';
                $brgy_user_id = $this->post('brgy_user_id');
                if (isset($brgy_user_id )) {
                    $valid_account = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id ));
                    $id = $brgy_user_id;
                    $reported_by = 2;
                    $lost_item['account_id'] = $brgy_user_id;
                } else {
                    $valid_account = $this->account->get(array('id' => $this->post('account_id')));
                    $id = $this->post('account_id');
                    $reported_by = 1;
                    $lost_item['account_id'] = $this->post('account_id');
                }
                if ($valid_account) {
                    $upload_result = $this->do_image_upload("item_images", "uploads/lost");

                    if ($upload_result) {
                        $images_details = array();
                        $insert_result = $this->lost_item->insert($lost_item); //Insert New Lost Item
                        $item = array(
                            'item_id' => $insert_result,
                            'type' => $type,
                            'location_brgy_covered' => $location_brgy,
                            'status' => 'New',
                            'report_type' => 'Personal Thing',
                            'reported_by' => $reported_by,
                            'account_id' => $id
                        );

                        $item_id = $this->item->insert($item);

                        for ($i = 0; $i < count($upload_result); $i++) {
                            $images_details[$i]['item_id'] = $item_id;
                            $images_details[$i]['file_name'] = $upload_result[$i]['file_name'];
                            $images_details[$i]['file_path'] = 'uploads/lost/' . $upload_result[$i]['file_name'];
                        }

                        $this->item->insert_item_images($images_details);

                        $con['id'] = $location_info['id'];
                        $location_exist = $this->item_location->get($con);
                        if (!$location_exist) {
                            $this->item_location->insert($location_info);
                        }

                    } else {
                        $this->response("Image Upload Error Occurred", REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    //Account Not Found
                    $this->response("Account Not Found", REST_Controller::HTTP_BAD_REQUEST);
                }
                break;
            case "Found":
                /*IF FOUND ITEM */
                $found_item['item_name'] = $this->post('item_name');
                $found_item['date_found'] = $this->post('date_found');
                $found_item['item_category'] = $this->post('item_category');
                $found_item['location_id'] = $this->post('location_id');
                //Nullable
                $found_item['brand'] = $this->post('brand') != null ? $this->post('brand') : "";
                $found_item['item_color'] = $this->post('item_color') != null ? $this->post('item_color') : "";
                $found_item['item_description'] = $this->post('item_description') != null ? $this->post('item_description') : "";
                $found_item['additional_location_info'] = $this->post('additional_location_info');

                $id = '';
                $reported_by = '';
                $brgy_user_id = $this->post('brgy_user_id');
                if (isset($brgy_user_id )) {
                    $valid_account = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id ));
                    $id = $brgy_user_id;
                    $reported_by = 2;
                    $found_item['account_id'] = $brgy_user_id;
                } else {
                    $valid_account = $this->account->get(array('id' => $this->post('account_id')));
                    $id = $this->post('account_id');
                    $reported_by = 1;
                    $found_item['account_id'] = $this->post('account_id');
                }

                if ($valid_account) {
                    $upload_result = $this->do_image_upload("item_images", "uploads/found");
                    if ($upload_result) {
                        $images_details = array();
                        $insert_result = $this->found_item->insert($found_item); //Insert New Lost Item
                        $item = array(
                            'item_id' => $insert_result,
                            'type' => $type,
                            'location_brgy_covered' => $location_brgy,
                            'status' => 'New',
                            'report_type' => 'Personal Thing',
                            'reported_by' => $reported_by,
                            'account_id' => $id
                        );

                        $item_id = $this->item->insert($item);

                        for ($i = 0; $i < count($upload_result); $i++) {
                            $images_details[$i]['item_id'] = $item_id;
                            $images_details[$i]['file_name'] = $upload_result[$i]['file_name'];
                            $images_details[$i]['file_path'] = 'uploads/found/' . $upload_result[$i]['file_name'];
                        }

                        $this->item->insert_item_images($images_details);

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
                        $match_results = $this->match_making_process($item_id, $found_item['account_id']);
                        $this->notification_process($item_id, $match_results); // Save and Send notification

                    } else {
                        $this->response("Image Upload Error Occurred", REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    //Account Not Found
                    $this->response("Account Not Found", REST_Controller::HTTP_BAD_REQUEST);
                }
                break;
        }
    }

    private function do_image_upload($key_file, $upload_path)
    {
        $config['upload_path'] = './' . $upload_path;
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $files = $_FILES;
        $cpt = count($_FILES[$key_file]['name']);

        $success_count = 0;
        $uploaded_data = array();
        for ($i = 0; $i < $cpt; $i++) {
            $_FILES[$key_file]['name'] = $files[$key_file]['name'][$i];
            $_FILES[$key_file]['type'] = $files[$key_file]['type'][$i];
            $_FILES[$key_file]['tmp_name'] = $files[$key_file]['tmp_name'][$i];
            $_FILES[$key_file]['error'] = $files[$key_file]['error'][$i];
            $_FILES[$key_file]['size'] = $files[$key_file]['size'][$i];

            $upload = $this->upload->do_upload($key_file);
            $uploaded_data[$i] = $this->upload->data();
            $success_count = $upload == true ? ($success_count + 1) : $success_count;
        }
        return $success_count == $cpt ? $uploaded_data : false;
    }

    /**
     * Report Lost/Found Pet
     * HTTP Request Method: POST
     * Lost/Found Pet Details is Required
     * URL Route: api/v1/report/pet
     */
    public function report_item_pet_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $type = $this->post('type');

        $location_brgy = $this->post('location_brgy');

        $pet_data['pet_name'] = $this->post('pet_name');
        $pet_data['type'] = $this->post('pet_type');
        $pet_data['pet_condition'] = $this->post('pet_condition');
        $pet_data['description'] = $this->post('pet_description');

        $pet_data['date'] = $this->post('date');
        $pet_data['location_id'] = $location_info['id'];
        // $pet_data['account_id'] = $this->post('account_id');
        $pet_data['additional_location_info'] = $this->post('additional_location_info');
        $pet_data['breed'] = $this->post('pet_breed'); //Optional
        $breed = $this->post('pet_breed');
        if ($breed === "Select Breed") {
            $pet_data['breed'] = "";
        } else {
            $pet_data['breed'] = $this->post('pet_breed'); //Optional
        }


        if ($type == "Lost") {
            $pet_data['reward'] = $this->post('reward');
        } else {
            $pet_data['reward'] = NULL;
        }

        $id = '';
        $reported_by = '';
        $brgy_user_id = $this->post('brgy_user_id');
        if (isset($brgy_user_id )) {
            $valid_account = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id ));
            $id = $brgy_user_id;
            $reported_by = 2;
            $pet_data['account_id'] = $brgy_user_id;
        } else {
            $valid_account = $this->account->get(array('id' => $this->post('account_id')));
            $id = $this->post('account_id');
            $reported_by = 1;
            $pet_data['account_id'] = $this->post('account_id');
        }

        if ($valid_account) {
            $upload_result = $this->do_image_upload("pet_images", 'uploads/' . strtolower($type) . '/pets/');
            if ($upload_result) {
                $images_details = array();
                $result = $this->pet_model->add_reported_pet($pet_data); // If insert success returns the insert id else false
                $item = array(
                    'item_id' => $result,
                    'type' => $type,
                    'location_brgy_covered' => $location_brgy,
                    'status' => 'New',
                    'report_type' => 'Pet',
                    'reported_by' => $reported_by,
                    'account_id' => $id
                );

                $item_id = $this->item->insert($item);

                for ($i = 0; $i < count($upload_result); $i++) {
                    $images_details[$i]['item_id'] = $item_id;
                    $images_details[$i]['file_name'] = $upload_result[$i]['file_name'];
                    $images_details[$i]['file_path'] = 'uploads/' . strtolower($type) . '/pets/' . $upload_result[$i]['file_name'];
                }

                $this->item->insert_item_images($images_details);

                $con['id'] = $location_info['id'];
                $location_exist = $this->item_location->get($con);
                if (!$location_exist) {
                    $this->item_location->insert($location_info);
                }

                if ($type == "Found") {
                    $match_results = $this->match_making_process($item_id, $pet_data['account_id']);
                    $this->notification_process($item_id, $match_results); // Save and Send notification
                }
            } else {
                $this->response("Image Upload Error", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Invalid Account ID", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Report Lost/Found Person
     * HTTP Request Method: POST
     * Lost/Found Person Details is Required
     * URL Route: api/v1/report/person
     */
    public function report_item_person_post()
    {
        $location_info['address'] = $this->post('location_address');
        $location_info['name'] = $this->post('location_name');
        $location_info['id'] = $this->post('location_id');
        $location_info['latitude'] = $this->post('location_latitude');
        $location_info['longitude'] = $this->post('location_longitude');

        $type = $this->post('type');

        $location_brgy = $this->post('location_brgy');

        $person_data['name'] = $this->post('name');
        $person_data['age_group'] = $this->post('age_group');
        $person_data['age_range'] = $this->post('age_range');
        $person_data['sex'] = $this->post('sex');
        $person_data['date'] = $this->post('date');
        $person_data['description'] = $this->post('description');

        if ($type == "Lost") {
            $person_data['reward'] = $this->post('reward');
        } else {
            $person_data['reward'] = NULL;
        }

        $person_data['location_id'] = $location_info['id'];
        $person_data['additional_location_info'] = $this->post('additional_location_info');

        $id = '';
        $reported_by = '';
        $brgy_user_id = $this->post('brgy_user_id');
        if (isset($brgy_user_id )) {
            $valid_account = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id ));
            $id = $brgy_user_id;
            $reported_by = 2;
            $person_data['account_id'] = $brgy_user_id;
        } else {
            $valid_account = $this->account->get(array('id' => $this->post('account_id')));
            $id = $this->post('account_id');
            $reported_by = 1;
            $person_data['account_id'] = $this->post('account_id');
        }

        if ($valid_account) {
            $upload_result = $this->do_image_upload("person_images", 'uploads/' . strtolower($type) . '/persons/');
            if ($upload_result) {
                $images_details = array();
                $result = $this->person_model->add_reported_person($person_data); // If insert success returns the insert id else false
                $item = array(
                    'item_id' => $result,
                    'type' => $type,
                    'location_brgy_covered' => $location_brgy,
                    'status' => 'New',
                    'report_type' => 'Person',
                    'reported_by' => $reported_by,
                    'account_id' => $id
                );

                $item_id = $this->item->insert($item);

                for ($i = 0; $i < count($upload_result); $i++) {
                    $images_details[$i]['item_id'] = $item_id;
                    $images_details[$i]['file_name'] = $upload_result[$i]['file_name'];
                    $images_details[$i]['file_path'] = 'uploads/' . strtolower($type) . '/persons/' . $upload_result[$i]['file_name'];
                }

                $this->item->insert_item_images($images_details);

                $con['id'] = $location_info['id'];
                $location_exist = $this->item_location->get($con);
                if (!$location_exist) {
                    $this->item_location->insert($location_info);
                }

                if ($type == "Found") {
                    $match_results = $this->match_making_process($item_id, $person_data['account_id']);
                    $this->notification_process($item_id, $match_results); // Save and Send notification
                }
            } else {
                $this->response("Image Upload Error", REST_Controller::HTTP_BAD_REQUEST);

            }
        } else {
            $this->response("Invalid Account", REST_Controller::HTTP_BAD_REQUEST);
        }
    }


}