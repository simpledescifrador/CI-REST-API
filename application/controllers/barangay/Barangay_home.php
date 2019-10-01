<?php

class Barangay_home extends CI_Controller{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('repository');
        $this->load->model('lost_item');
        $this->load->model('user');
        $this->load->model('login_model');
        $this->load->model('found_item');
        $this->load->model('barangay');

    }


    public function home(){



        if(isset($this->session->userdata['b_logged_in']))
		{
            $data['page_title'] = 'Makahanap | Barangay';
            $brgy_id = $this->session->userdata['b_logged_in']['brgy_id'];
            $user_id = $this->session->userdata['b_logged_in']['user_id'];

            //Get Brgy USer Data
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'brgy_account_id' => $user_id
            );

            $user_data = $this->barangay->get_brgyuser_details($con);

            //Get Barangay Data
            $barangay_data = $this->barangay->get(array('id' => $brgy_id));

            $data['brgy_name'] = "Barangay " . ucwords(strtolower($barangay_data['name']));
            $data['brgy_address'] = $barangay_data['address'];
            $data['brgy_logo'] = $barangay_data['logo'];
            $data['username'] = $user_data['first_name'] . ' ' . $user_data['last_name'];
            $data['barangay'] = $this->login_model->user_info($this->session->userdata['b_logged_in']['brgy_id']);
            $data['lost_items'] = $this->lost_item->recently_lost();
            $data['recent_found'] = $this->found_item->recently_found();

            $data['turnover_items'] = $this->repository->get_turnovers_brgy($this->session->userdata['b_logged_in']['brgy_id']);
            $data['received_items'] = $this->repository->get_received_brgy($this->session->userdata['b_logged_in']['brgy_id']);


            $lost = array();
            $found = array();
            $this->load->model('item');
            $max_count = 0;
            //Weekly Lost & Found Chart
            for ($i=0; $i < 7; $i++) {
                $date = Date('Y-m-d', strtotime("-" . $i . " days"));
                $lost_count = 0;
                $found_count = 0;

                $lost_items = $this->item->get_lost_brgy_items();
                $found_items = $this->item->get_found_brgy_items();

                //Check if posted in current brgy logged in
                if ($lost_items) {
                    foreach ($lost_items as $key => $value) {
                        $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                            'id' => $value['account_id']
                        ));

                        if ($brgy_user_data['barangay_id'] == $brgy_id) {
                            $result = $this->item->get_brgy_lost_check($date, $value['id']);

                            if ($result) {
                                $lost_count++;
                            }
                        }
                    }
                }

                if ($found_items) {
                    foreach ($found_items as $key => $value) {
                        $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                            'id' => $value['account_id']
                        ));

                        if ($brgy_user_data['barangay_id'] == $brgy_id) {
                            $result = $this->item->get_brgy_found_check($date, $value['id']);

                            if ($result) {
                                $found_count++;
                            }
                        }
                    }
                }

                $lost[] = array(
                    't' => $date,
                    'y' => $lost_count
                );

                $found[] = array(
                    't' => $date,
                    'y' => $found_count
                );

                if ($lost_count > $found_count) {
                    if ($lost_count > $max_count) {
                        $max_count = $lost_count;
                    }
                } else {
                    if ($found_count > $max_count) {
                        $max_count = $found_count;
                    }
                }

            }


            $data['lost_reports'] = json_encode($lost);
            $data['found_reports'] = json_encode($found);

            //Add Max count plus 5 or 6
            if ($max_count % 2 == 0) {
                $max_count += 4;
            } else {
                $max_count += 5;
            }
            $data['lf_max_count'] = $max_count;
            //Get Turnover & Received Reports
            $turnover = array();
            $received = array();
            $max_count = 0;
            for ($i=0; $i < 7; $i++) {
                $date = Date('Y-m-d', strtotime("-" . $i . " days"));
                $turnover_count = 0;
                $received_count = 0;

                $repo = $this->repository->get();

                if ($repo) {
                    foreach ($repo as $key => $value) {
                        $item_data = $this->item->get(array('id' => $value['item_id']));
                        if ($value['brgy_id'] == $brgy_id) {
                            if ($value['item_received'] == 'Yes') {
                                $check = $this->repository->received_date_check($date, $value['id']);

                                if ($check) {
                                    $received_count++;
                                }
                            } else {
                                $check = $this->item->item_date_check($date, $value['item_id']);
                                if ($check) {/* Match Date */
                                    $turnover_count++;
                                }
                            }
                        }

                    }
                }

                $turnover[] = array(
                    't' => $date,
                    'y' => $turnover_count
                );

                $received[] = array(
                    't' => $date,
                    'y' => $received_count
                );

                if ($turnover_count > $received_count) {
                    if ($turnover_count > $max_count) {
                        $max_count = $turnover_count;
                    }
                } else {
                    if ($received_count > $max_count) {
                        $max_count = $received_count;
                    }
                }
            }

            $data['turnover_requests'] = json_encode($turnover);
            $data['received_turnover_items'] = json_encode($received);
            //Add Max count plus 5 or 6
            if ($max_count % 2 == 0) {
                $max_count += 4;
            } else {
                $max_count += 5;
            }
            $data['tr_max_count'] = $max_count;


            //Get Total Counters
            //Total Turnover Request
            $total_turnover = $this->repository->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'brgy_id' => $brgy_id,
                    'item_received' => 'No'
                )
            ));

            $data['total_turnover_count'] = $total_turnover;

            //Total Received
            $total_received_items = $this->repository->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'brgy_id' => $brgy_id,
                    'item_received' => 'Yes'
                )
            ));

            $data['total_received_count'] = $total_received_items;


            //Get Total Reported Lost
            $total_lost_count = 0;
            $items = $this->item->get(array(
                'conditions' => array(
                    'type' => 'Lost',
                    'reported_by' => 'Brgy User'
                )
            ));

            if ($items) {
                foreach ($items as $key => $value) {
                    $brgy_user_id = $value['account_id'];
                    $brgy_user_data = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id));

                    if ($brgy_user_data['barangay_id'] == $brgy_id) {
                        $total_lost_count++;
                    }
                }
            }

            $data['total_lost_count'] = $total_lost_count;

            //Get Total Reported Found
            $total_found_count = 0;
            $items = $this->item->get(array(
                'conditions' => array(
                    'type' => 'Found',
                    'reported_by' => 'Brgy User'
                )
            ));

            if ($items) {
                foreach ($items as $key => $value) {
                    $brgy_user_id = $value['account_id'];
                    $brgy_user_data = $this->barangay->get_brgyuser_details(array('id' => $brgy_user_id));

                    if ($brgy_user_data['barangay_id'] == $brgy_id) {
                        $total_found_count++;
                    }
                }
            }

            $data['total_found_count'] = $total_found_count;

           $this->load->view('barangay/templates/header',$data);
           $this->load->view('barangay/pages/home', $data);
           $this->load->view('barangay/modals/home_modals', $data);
           $this->load->view('barangay/templates/footer');
           $this->load->view('barangay/pages/home_footer', $data);
		}
		else
		{
            redirect('/','refresh');
		}

    }

    public function receive_turnover_request($id)
    {
        //update repository
        $result = $this->repository->update(array(
            "item_received" => 1,
            "date_item_received" => date("Y-m-d H:i:s")
        ), $id);

        if ($result) {
            echo "Success";
        } else {
            echo "Failed";
        }

    }
    public function tr_chart_filter_date()
    {
        $type = $this->input->get('type');

        $brgy_id = $this->session->userdata['b_logged_in']['brgy_id'];

        $turnover = array();
        $received = array();

        $this->load->model('item');
        $max_count = 0;

        switch ($type) {
            case 'Daily':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y-m-d', strtotime("-" . $i . " days"));
                    $turnover_count = 0;
                    $received_count = 0;

                    $repo = $this->repository->get();

                    if ($repo) {
                        foreach ($repo as $key => $value) {
                            $item_data = $this->item->get(array('id' => $value['item_id']));
                            if ($value['brgy_id'] == $brgy_id) {
                                if ($value['item_received'] == 'Yes') {
                                    $check = $this->repository->received_date_check($date, $value['id']);

                                    if ($check) {
                                        $received_count++;
                                    }
                                } else {
                                    $check = $this->item->item_date_check($date, $value['item_id']);
                                    if ($check) {/* Match Date */
                                        $turnover_count++;
                                    }
                                }
                            }

                        }
                    }

                    $turnover[] = array(
                        't' => $date,
                        'y' => $turnover_count
                    );

                    $received[] = array(
                        't' => $date,
                        'y' => $received_count
                    );

                    if ($turnover_count > $received_count) {
                        if ($turnover_count > $max_count) {
                            $max_count = $turnover_count;
                        }
                    } else {
                        if ($received_count > $max_count) {
                            $max_count = $received_count;
                        }
                    }
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'tr_max_count' => $max_count,
                    'turnover_requests' => $turnover,
                    'received_items' => $received
                );

                echo json_encode($data);
                $turnover = array();
                $received = array();
                $data = array();
                break;
            case 'Weekly':
                $end_date = date('Y-m-d h:i:s');
                $date = date('Y-m-d', strtotime($end_date . ' - 1 day'));
                for ($i=0; $i < 7; $i++) {
                    $start_date = date('Y-m-d 00:00:00', strtotime($end_date . ' - 1 week'));
                    $turnover_count = 0;
                    $received_count = 0;

                    $repo = $this->repository->get();

                    if ($repo) {
                        foreach ($repo as $key => $value) {
                            $item_data = $this->item->get(array('id' => $value['item_id']));
                            if ($value['brgy_id'] == $brgy_id) {
                                if ($value['item_received'] == 'Yes') {
                                    $check = $this->repository->received_date_week_check($start_date, $end_date, $value['id']);

                                    if ($check) {
                                        $received_count++;
                                    }
                                } else {
                                    $check = $this->item->date_week_check($start_date, $end_date, $value['item_id']);
                                    if ($check) {/* Match Date */
                                        $turnover_count++;
                                    }
                                }
                            }

                        }
                    }

                    $turnover[] = array(
                        't' => $date,
                        'y' => $turnover_count
                    );

                    $received[] = array(
                        't' => $date,
                        'y' => $received_count
                    );

                    if ($turnover_count > $received_count) {
                        if ($turnover_count > $max_count) {
                            $max_count = $turnover_count;
                        }
                    } else {
                        if ($received_count > $max_count) {
                            $max_count = $received_count;
                        }
                    }

                    $end_date = $start_date;
                    $date = date('Y-m-d', strtotime($start_date . ' - 1 day'));
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'tr_max_count' => $max_count,
                    'turnover_requests' => $turnover,
                    'received_items' => $received
                );

                echo json_encode($data);
                $turnover = array();
                $received = array();
                $data = array();
                break;
            case 'Monthly':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y-m', strtotime("-" . $i . " month"));
                    $turnover_count = 0;
                    $received_count = 0;

                    $repo = $this->repository->get();

                    if ($repo) {
                        foreach ($repo as $key => $value) {
                            $item_data = $this->item->get(array('id' => $value['item_id']));
                            if ($value['brgy_id'] == $brgy_id) {
                                if ($value['item_received'] == 'Yes') {
                                    $check = $this->repository->received_date_check($date, $value['id']);

                                    if ($check) {
                                        $received_count++;
                                    }
                                } else {
                                    $check = $this->item->item_date_check($date, $value['item_id']);
                                    if ($check) {/* Match Date */
                                        $turnover_count++;
                                    }
                                }
                            }

                        }
                    }

                    $turnover[] = array(
                        't' => $date,
                        'y' => $turnover_count
                    );

                    $received[] = array(
                        't' => $date,
                        'y' => $received_count
                    );

                    if ($turnover_count > $received_count) {
                        if ($turnover_count > $max_count) {
                            $max_count = $turnover_count;
                        }
                    } else {
                        if ($received_count > $max_count) {
                            $max_count = $received_count;
                        }
                    }
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'tr_max_count' => $max_count,
                    'turnover_requests' => $turnover,
                    'received_items' => $received
                );

                echo json_encode($data);
                $turnover = array();
                $received = array();
                $data = array();
                break;
            case 'Yearly':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y', strtotime("-" . $i . " year"));
                    $turnover_count = 0;
                    $received_count = 0;

                    $repo = $this->repository->get();

                    if ($repo) {
                        foreach ($repo as $key => $value) {
                            $item_data = $this->item->get(array('id' => $value['item_id']));
                            if ($value['brgy_id'] == $brgy_id) {
                                if ($value['item_received'] == 'Yes') {
                                    $check = $this->repository->received_date_check($date, $value['id']);

                                    if ($check) {
                                        $received_count++;
                                    }
                                } else {
                                    $check = $this->item->item_date_check($date, $value['item_id']);
                                    if ($check) {/* Match Date */
                                        $turnover_count++;
                                    }
                                }
                            }

                        }
                    }

                    $turnover[] = array(
                        't' => $date,
                        'y' => $turnover_count
                    );

                    $received[] = array(
                        't' => $date,
                        'y' => $received_count
                    );

                    if ($turnover_count > $received_count) {
                        if ($turnover_count > $max_count) {
                            $max_count = $turnover_count;
                        }
                    } else {
                        if ($received_count > $max_count) {
                            $max_count = $received_count;
                        }
                    }
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'tr_max_count' => $max_count,
                    'turnover_requests' => $turnover,
                    'received_items' => $received
                );

                echo json_encode($data);
                $turnover = array();
                $received = array();
                $data = array();
                break;
        }

    }
    public function lf_chart_filter_date()
    {
        $type = $this->input->get('type');

        $brgy_id = $this->session->userdata['b_logged_in']['brgy_id'];

        $lost = array();
        $found = array();
        $this->load->model('item');
        $max_count = 0;

        switch ($type) {
            case 'Daily':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y-m-d', strtotime("-" . $i . " days"));
                    $lost_count = 0;
                    $found_count = 0;

                    $lost_items = $this->item->get_lost_brgy_items();
                    $found_items = $this->item->get_found_brgy_items();

                    //Check if posted in current brgy logged in
                    if ($lost_items) {
                        foreach ($lost_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_lost_check($date, $value['id']);

                                if ($result) {
                                    $lost_count++;
                                }
                            }
                        }
                    }

                    if ($found_items) {
                        foreach ($found_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_found_check($date, $value['id']);

                                if ($result) {
                                    $found_count++;
                                }
                            }
                        }
                    }

                    $lost[] = array(
                        't' => $date,
                        'y' => $lost_count
                    );

                    $found[] = array(
                        't' => $date,
                        'y' => $found_count
                    );

                    if ($lost_count > $found_count) {
                        if ($lost_count > $max_count) {
                            $max_count = $lost_count;
                        }
                    } else {
                        if ($found_count > $max_count) {
                            $max_count = $found_count;
                        }
                    }

                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'lf_max_count' => $max_count,
                    'lost_reports' => $lost,
                    'found_reports' => $found
                );

                echo json_encode($data);
                $lost = array();
                $found = array();
                $data = array();
                break;
            case 'Weekly':
                // $first_date = date('Y-m-01 00:00:00', strtotime(date('Y-m-d')));
                // $first_week = date('Y-m-01', strtotime(date('Y-m-d')));
                $end_date = date('Y-m-d h:i:s');
                $date = date('Y-m-d', strtotime($end_date . ' - 1 day'));
                for ($i=0; $i < 7; $i++) {
                    // $end_date = date('Y-m-d 00:00:00', strtotime($first_date . ' + 1 week'));
                    // $week_date = date('Y-m-d', strtotime($first_week . ' + 1 week'));
                    $start_date = date('Y-m-d 00:00:00', strtotime($end_date . ' - 1 week'));

                    $lost_count = 0;
                    $found_count = 0;

                    $lost_items = $this->item->get_lost_brgy_items();
                    $found_items = $this->item->get_found_brgy_items();

                    //Check if posted in current brgy logged in
                    if ($lost_items) {
                        foreach ($lost_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->item_date_week_check($start_date, $end_date, $value['id'], 'Lost');

                                if ($result) {
                                    $lost_count++;
                                }
                            }
                        }
                    }

                    if ($found_items) {
                        foreach ($found_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->item_date_week_check($start_date, $end_date, $value['id'], 'Found');

                                if ($result) {
                                    $found_count++;
                                }
                            }
                        }
                    }

                    $lost[] = array(
                        't' => $date,
                        'y' => $lost_count
                    );

                    $found[] = array(
                        't' => $date,
                        'y' => $found_count
                    );

                    if ($lost_count > $found_count) {
                        if ($lost_count > $max_count) {
                            $max_count = $lost_count;
                        }
                    } else {
                        if ($found_count > $max_count) {
                            $max_count = $found_count;
                        }
                    }

                    //Swap Dates
                    // $first_date = $end_date;
                    // $first_week = $week_date;
                    $end_date = $start_date;
                    $date = date('Y-m-d', strtotime($start_date . ' - 1 day'));
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'lf_max_count' => $max_count,
                    'lost_reports' => $lost,
                    'found_reports' => $found
                );

                echo json_encode($data);
                $lost = array();
                $found = array();
                $data = array();
                break;
            case 'Monthly':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y-m', strtotime("-" . $i . " month"));

                    $lost_count = 0;
                    $found_count = 0;

                    $lost_items = $this->item->get_lost_brgy_items();
                    $found_items = $this->item->get_found_brgy_items();

                    //Check if posted in current brgy logged in
                    if ($lost_items) {
                        foreach ($lost_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_lost_check($date, $value['id']);

                                if ($result) {
                                    $lost_count++;
                                }
                            }
                        }
                    }

                    if ($found_items) {
                        foreach ($found_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_found_check($date, $value['id']);

                                if ($result) {
                                    $found_count++;
                                }
                            }
                        }
                    }

                    $lost[] = array(
                        't' => $date,
                        'y' => $lost_count
                    );

                    $found[] = array(
                        't' => $date,
                        'y' => $found_count
                    );

                    if ($lost_count > $found_count) {
                        if ($lost_count > $max_count) {
                            $max_count = $lost_count;
                        }
                    } else {
                        if ($found_count > $max_count) {
                            $max_count = $found_count;
                        }
                    }
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'lf_max_count' => $max_count,
                    'lost_reports' => $lost,
                    'found_reports' => $found
                );

                echo json_encode($data);
                $lost = array();
                $found = array();
                $data = array();
                break;
            case 'Yearly':
                for ($i=0; $i < 7; $i++) {
                    $date = Date('Y', strtotime("-" . $i . " years"));

                    $lost_count = 0;
                    $found_count = 0;

                    $lost_items = $this->item->get_lost_brgy_items();
                    $found_items = $this->item->get_found_brgy_items();

                    //Check if posted in current brgy logged in
                    if ($lost_items) {
                        foreach ($lost_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_lost_check($date, $value['id']);

                                if ($result) {
                                    $lost_count++;
                                }
                            }
                        }
                    }

                    if ($found_items) {
                        foreach ($found_items as $key => $value) {
                            $brgy_user_data = $this->barangay->get_brgyuser_details(array(
                                'id' => $value['account_id']
                            ));

                            if ($brgy_user_data['barangay_id'] == $brgy_id) {
                                $result = $this->item->get_brgy_found_check($date, $value['id']);

                                if ($result) {
                                    $found_count++;
                                }
                            }
                        }
                    }

                    $lost[] = array(
                        't' => $date,
                        'y' => $lost_count
                    );

                    $found[] = array(
                        't' => $date,
                        'y' => $found_count
                    );

                    if ($lost_count > $found_count) {
                        if ($lost_count > $max_count) {
                            $max_count = $lost_count;
                        }
                    } else {
                        if ($found_count > $max_count) {
                            $max_count = $found_count;
                        }
                    }
                }

                // //Add Max count plus 5 or 6
                if ($max_count % 2 == 0) {
                    $max_count += 4;
                } else {
                    $max_count += 5;
                }

                $data = array(
                    'lf_max_count' => $max_count,
                    'lost_reports' => $lost,
                    'found_reports' => $found
                );

                echo json_encode($data);
                $lost = array();
                $found = array();
                $data = array();
                break;
        }
    }

    public function change_password()
    {
        $this->load->library('form_validation'); //Load Form Validation

        //Set Form Rules
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|callback_check_current_password');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]|callback_password_regex_validator|differs[password]');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim|required|matches[new_password]',
            array(
                'matches' => "The New Password not match!"
            )
        );

        if ($this->form_validation->run() == FALSE) {
            /* Failed Form Validation */
            echo validation_errors();
		} else {
            $user_id = $this->session->userdata['b_logged_in']['user_id'];

            //Get Brgy USer Data
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'brgy_account_id' => $user_id
            );

            $user_data = $this->barangay->get_brgyuser_details($con);
            $new_password = $this->input->post('new_password');
            $data = array(
                'password' => $new_password
            );

            $success = $this->user->update($data, $user_data['brgy_account_id']);

            if ($success) {
                echo 'Success';
            } else {
                echo 'Error';
            }

        }
    }

    public function check_current_password($password)
    {
        $user_id = $this->session->userdata['b_logged_in']['user_id'];

        //Get Brgy USer Data
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'brgy_account_id' => $user_id
        );

        $user_data = $this->barangay->get_brgyuser_details($con);

        $is_valid = $this->user->getRows(array(
            'returnType' => 'single',
            'conditions' => array(
                'id' => $user_data['brgy_account_id'],
                'password' => $password
            )
        ));

        if ($is_valid) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_current_password', 'The {field} is invalid');
            return FALSE;
        }
    }

    public function password_regex_validator($password)
    {
        if (!preg_match('#[0-9]#', $password))
        {
            $this->form_validation->set_message('password_regex_validator', 'The {field} is must have at least one number.');
            return FALSE;
        } else if (preg_match_all("/[!@#$%^&*()\-_=+{};:,<.>§~]/", $password) < 1) {
            $this->form_validation->set_message('password_regex_validator', 'The {field} is must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        } else if (!preg_match('/^\S{8,}$/', $password)) {
            $this->form_validation->set_message('password_regex_validator', 'The {field} is must not contain spaces.');
            return FALSE;
        } else{
          return TRUE;
        }
    }
}