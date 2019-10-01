<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brgy_account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in']))
		{

			$data['alert_message'] = $this->session->flashdata('alert_message');
            $data['alert_type'] = $this->session->flashdata('alert_type');
            
			$data['page_title'] = "Maka-Hanap | Barangay Accounts";
			$this->load->view('templates/header', $data);
			$this->load->view('pages/brgy_accounts', $data);
			$this->load->view('templates/footer');
		}
		else{
			redirect('/','refresh');
		}
	}

}

/* End of file Brgy_account.php */
/* Location: .//C/Users/Joffet/AppData/Local/Temp/fz3temp-2/Brgy_account.php */