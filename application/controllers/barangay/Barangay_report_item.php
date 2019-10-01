<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangay_report_item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('login_model');
		$this->load->model('barangay');

	}

	public function index()
	{
		if(isset($this->session->userdata['b_logged_in']))
		{
			$data['page_title']  = 'Maka-Hanap | Barangay';
			$data['barangay'] = $this->login_model->user_info($this->session->userdata['b_logged_in']['brgy_id']);
            $user_id = $this->session->userdata['b_logged_in']['user_id'];
            //Get Brgy USer Data
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'brgy_account_id' => $user_id
            );

            $user_data = $this->barangay->get_brgyuser_details($con);

			$data['brgy_user_id'] = $user_data['id'];

            $data['username'] = $user_data['first_name'] . ' ' . substr($user_data['last_name'], 0, 1) . '.';
			$data['token'] = $this->input->get('token'); # Get the report if its LOST or Found.
			$data['report_type'] = $this->input->get('type'); #If person, pet or personal thing.


			$this->load->view('barangay/templates/header',$data);
			$this->load->view('barangay/modals/home_modals', $data);
			$this->load->view('barangay/templates/footer', $data);
			$this->load->view('barangay/pages/report_form', $data);

		}
		else
		{
            redirect('/','refresh');
		}
	}
}
/* End of file Barangay_report_item.php */
/* Location: .//C/Users/Joffet/AppData/Local/Temp/fz3temp-2/Barangay_report_item.php */