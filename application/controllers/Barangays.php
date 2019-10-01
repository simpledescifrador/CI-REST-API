<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangays extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('barangay');
		$this->load->model('user');
		$this->load->model('repository');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in']))
		{	
		   $data['d_number'] = $this->input->get('d_number');
           $data['page_title'] = "Makahanap Admin | Barangay";
           $data['barangay'] = $this->barangay->get_brgy($data['d_number']);

           //load views aka html page ui
           $this->load->view('templates/header', $data);
           $this->load->view('pages/barangays', $data);
           $this->load->view('templates/footer');
		}
		else
		{ 
            redirect('/','refresh');
		}
	}
	public function brgy_details(){
		if(isset($this->session->userdata['logged_in']))
		{	
           $data['page_title'] = "Makahanap Admin | Barangay";
           $data['brgy_id'] = $this->input->get('brgy_id');
           $data['brgy_details'] = $this->barangay->get_bDetails($data['brgy_id']);
           $data['brgy_turnovers'] = $this->repository->get_received_brgy($data['brgy_id']);
           $data['brgy_pending_items'] = $this->repository->get_turnovers_brgy($data['brgy_id']);
           $data['users'] = $this->user->getUsers($data['brgy_id']);

           //load views (html page ui)
           $this->load->view('templates/header', $data);
           $this->load->view('pages/brgy_details', $data);
           $this->load->view('modals/add_brgy_account', $data);
           $this->load->view('templates/footer');
		}
		else
		{ 
            redirect('/','refresh');
		}
	}

}

/* End of file Barangays.php */
/* Location: ./application/controllers/Barangays.php */