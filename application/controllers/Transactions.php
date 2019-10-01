<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaction_model');
		$this->load->model('lost_item');
        $this->load->model('found_item');
        $this->load->model('account');
        $this->load->model('item_location');
        $this->load->model('item');
        $this->load->model('repository');
        $this->load->model('barangay');
        $this->load->model('pet_model');
        $this->load->model('person_model');
		//Do your magic here
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])){

			$confirmed_transaction = $this->transaction_model->get_confirmed_transaction();

			if ($confirmed_transaction) {
				foreach ($confirmed_transaction as $key => $value) {
					$type = $value['type'];
					$report_type = $value['report_type'];

					switch ($report_type) {
						case 'Personal Thing':
							if ($type == 'Found') {
								$found_details = $this->found_item->get(array('id' => $value['item_id']));

								//Get The Onwers Account Details
								$account1_details = $this->account->get(array('id'=> $value['owner_id']));
								//Get the finder account details
								$account2_details = $this->account->get(array('id' => $value['account_id']));

								$data['confirmed_transaction'][$key]['id'] = $value['id'];
								$data['confirmed_transaction'][$key]['item_title'] = $found_details['item_name'];
								$data['confirmed_transaction'][$key]['account1_name'] = $account1_details['first_name'] . ' ' . $account1_details['last_name'];
								$data['confirmed_transaction'][$key]['account2_name'] = $account2_details['first_name'] . ' ' . $account2_details['last_name'];
								$data['confirmed_transaction'][$key]['date_confirmed'] = $value['date_confirmed'];

								if ($value['cancelled'] == 'Yes') {
									$data['confirmed_transaction'][$key]['processing_status'] = 'failed';
								} else {
									$data['confirmed_transaction'][$key]['processing_status'] = 'active';
								}

								//Get Transaction Meetup Details
								$tcon['returnType'] = 'single';
								$tcon['conditions'] = array(
									'transaction_id' => $value['transaction_id']
								);

								$meetup_details = $this->transaction_model->get_transaction_meetup($tcon);

								if ($meetup_details) {
									if ($meetup_details['meetup_confirmation'] == 'accepted') {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'active';
									} else {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'failed';
									}
								} else {
									$data['confirmed_transaction'][$key]['meetup_status'] = '';
								}
								
								
							}
							
							break;
						case 'Pet':
							$pet_details = $this->pet_model->get(array('id' => $value['item_id']));

								//Get The Onwers Account Details
								$account1_details = $this->account->get(array('id'=> $value['owner_id']));
								//Get the finder account details
								$account2_details = $this->account->get(array('id' => $value['account_id']));

								$data['confirmed_transaction'][$key]['item_title'] = $pet_details['breed'] . ' ' . $pet_details['type'] ;
								$data['confirmed_transaction'][$key]['account1_name'] = $account1_details['first_name'] . ' ' . $account1_details['last_name'];
								$data['confirmed_transaction'][$key]['account2_name'] = $account2_details['first_name'] . ' ' . $account2_details['last_name'];
								$data['confirmed_transaction'][$key]['date_confirmed'] = $value['date_confirmed'];

								if ($value['cancelled'] == 'Yes') {
									$data['confirmed_transaction'][$key]['processing_status'] = 'failed';
								} else {
									$data['confirmed_transaction'][$key]['processing_status'] = 'active';
								}

								//Get Transaction Meetup Details
								$tcon['returnType'] = 'single';
								$tcon['conditions'] = array(
									'transaction_id' => $value['transaction_id']
								);

								$meetup_details = $this->transaction_model->get_transaction_meetup($tcon);

								if ($meetup_details) {
									if ($meetup_details['meetup_confirmation'] == 'accepted') {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'active';
									} else {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'failed';
									}
								} else {
									$data['confirmed_transaction'][$key]['meetup_status'] = '';
								}
							break;
						case 'Person':
							$person_details = $this->person_model->get(array('id' => $value['item_id']));

								//Get The Onwers Account Details
								$account1_details = $this->account->get(array('id'=> $value['owner_id']));
								//Get the finder account details
								$account2_details = $this->account->get(array('id' => $value['account_id']));

								$data['confirmed_transaction'][$key]['item_title'] = ucfirst(strtolower($person_details['sex'])) .
								' ' . $person_details['age_group'] . ' ' . $person_details['age_range'];
								$data['confirmed_transaction'][$key]['account1_name'] = $account1_details['first_name'] . ' ' . $account1_details['last_name'];
								$data['confirmed_transaction'][$key]['account2_name'] = $account2_details['first_name'] . ' ' . $account2_details['last_name'];
								$data['confirmed_transaction'][$key]['date_confirmed'] = $value['date_confirmed'];

								if ($value['cancelled'] == 'Yes') {
									$data['confirmed_transaction'][$key]['processing_status'] = 'failed';
								} else {
									$data['confirmed_transaction'][$key]['processing_status'] = 'active';
								}

								//Get Transaction Meetup Details
								$tcon['returnType'] = 'single';
								$tcon['conditions'] = array(
									'transaction_id' => $value['transaction_id']
								);

								$meetup_details = $this->transaction_model->get_transaction_meetup($tcon);

								if ($meetup_details) {
									if ($meetup_details['meetup_confirmation'] == 'accepted') {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'active';
									} else {
										$data['confirmed_transaction'][$key]['meetup_status'] = 'failed';
									}
								} else {
									$data['confirmed_transaction'][$key]['meetup_status'] = '';
								}
							break;
						
					}
				}
			} 
			else {
				$data['confirmed_transaction'] = array();

			}
			
			$data['get_transaction_meetup'] = $this->transaction_model->get_transaction_meetup();
 			$data['page_title']='Maka-Hanap Admin | Transactions';

		   $this->load->view('templates/header',$data);
           $this->load->view('pages/transactions', $data);
           $this->load->view('templates/footer');
		}
		else{
			redirect('/','refresh');
		}
	}

}

/* End of file Transactions.php */
/* Location: ./application/controllers/Transactions.php */