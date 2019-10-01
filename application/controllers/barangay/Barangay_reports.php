<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangay_reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('repository');
		$this->load->model('lost_item');
		$this->load->model('user');
		$this->load->model('login_model');
		$this->load->model('found_item');

		$this->load->model('account');
		// Load Item Model
		$this->load->model('item');
		$this->load->model('item_location');
		$this->load->model('repository');
		$this->load->model('barangay');
		$this->load->model('pet_model');
		$this->load->model('person_model');
	}

	public function get_items()
	{
		$query = $this->input->get('q');
        $skips = $this->input->get('skips');
        $limit = $this->input->get('limit');
        $filter_value = $this->input->get('filter');

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

		echo json_encode($match_items);

	}

	public function index()
	{
		if(isset($this->session->userdata['b_logged_in'])) {
			$data['page_title'] = 'Makahanap | Barangay';
            $brgy_id = $this->session->userdata['b_logged_in']['brgy_id'];
            $user_id = $this->session->userdata['b_logged_in']['user_id'];

            //Get Brgy USer Data
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'brgy_account_id' => $user_id
            );

            $user_data = $this->barangay->get_brgyuser_details($con);


            $data['username'] = $user_data['first_name'] . ' ' . substr($user_data['last_name'], 0, 1) . '.';
			$data['barangay'] = $this->login_model->user_info($this->session->userdata['b_logged_in']['brgy_id']);
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
                    $accountImage = $account_data['image'];
                } else {
                    $account_data = $this->barangay->get_brgyuser_details(array("id" => $items[$i]['account_id']));
                    $user_data = $this->user->getRows(array('id' => $account_data['brgy_account_id']));

                    //Get Barangay Details
                    $barangayData = $this->barangay->get(array('id' => $user_data['brgy_id']));
                    $accountImage = base_url() .  $barangayData['logo'];
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
					}
				}
			}

			$data['items'] = array_reverse($feed_items);
            $this->load->view('barangay/templates/header',$data);
            $this->load->view('barangay/modals/home_modals', $data);
			$this->load->view('barangay/pages/reports', $data);
			$this->load->view('barangay/templates/footer');
			$this->load->view('barangay/pages/reports_footer', $data);
		}
		else{
			redirect('/','refresh');
		}
	}
}


/* End of file Barangay_reports.php */
/* Location: ./application/controllers/barangay/Barangay_reports.php */