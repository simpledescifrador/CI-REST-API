<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matched extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('item');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in']))
		{	
			$data['page_title'] = 'Maka-Hanap Admin | Matched Items';
			$data['matched_items'] = $this->item->get_matched_items();
			$data['matched_pets'] = $this->item->get_matched_pets();
			$data['matched_persons'] = $this->item->get_matched_persons();

			$this->load->view('templates/header', $data);
            $this->load->view('pages/matched_items');
            $this->load->view('templates/footer');
		}
		else{
			redirect('/','refresh');
		}
	}

}

/* End of file Matched.php */
/* Location: ./application/controllers/Matched.php */