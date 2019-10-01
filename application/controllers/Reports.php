<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('barangay');
		$this->load->model('item');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])){
			$data['page_title'] = 'MakaHanap | Admin Reports';
			$month = date('m');
			$d = date('Y') . '-' . $month . '-01 00:00:00';
			//Get Total Lost Reported In Mobile
			$lcon['returnType'] = 'count';
			$lcon['conditions'] = array(
				'type' => 'Lost',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['total_lost_count'] = $this->item->get($lcon);

			//Get Total Found Reported In Mobile
			$fcon['returnType'] = 'count';
			$fcon['conditions'] = array(
				'type' => 'Found',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['total_found_count'] = $this->item->get($lcon);

			//Total Lost Pet
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Lost',
				'report_type' => 'Pet',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['lost_pet_count'] = $this->item->get($con);

			//Total Lost Person
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Lost',
				'report_type' => 'Person',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['lost_person_count'] = $this->item->get($con);

			//Total Lost Personal Thing
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Lost',
				'report_type' => 'Personal Thing',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['lost_pt_count'] = $this->item->get($con);

			//Total Found Pet
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Found',
				'report_type' => 'Pet',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['found_pet_count'] = $this->item->get($con);

			//Total Found Person
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Found',
				'report_type' => 'Person',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['found_person_count'] = $this->item->get($con);

			//Total Found Personal Thing
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'type' => 'Found',
				'report_type' => 'Personal Thing',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);
			$data['found_pt_count'] = $this->item->get($con);

			//Total Return Pet
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'report_type' => 'Pet',
				'status' => 'Returned',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['return_pet_count'] = $this->item->get($con);

			//Total Return Person
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'report_type' => 'Person',
				'status' => 'Returned',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['return_person_count'] = $this->item->get($con);

			//Total Return Person
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'report_type' => 'Personal Thing',
				'status' => 'Returned',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['return_pt_count'] = $this->item->get($con);

			//Total Mobile Reported
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'reported_by' => 'Mobile User',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['total_mobile_report_count'] = $this->item->get($con);

			//Total Brgy Reported
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'reported_by' => 'Brgy User',
				'published_at >=' => $d,
				'published_at <=' => date('Y-m-d H:i:s')
			);

			$data['total_brgy_report_count'] = $this->item->get($con);

			$this->load->view('templates/header', $data);
            $this->load->view('pages/reports',$data);
            $this->load->view('templates/footer');
		}
		else{
			redirect('/','refresh');
		}
	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */