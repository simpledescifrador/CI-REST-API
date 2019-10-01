<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returned extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('item');
		$this->load->model('found_item');
		$this->load->model('person_model');
		$this->load->model('pet_model');
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in']))
		{	
			$data['page_title'] = "Maka-Hanap Admin | Returned Items";
			$data['returned_items'] = $this->found_item->view_returnedItems();
			$data['success_transactions'] = $this->found_item->view_successTransactions();
			$data['item_type'] = 'matched';

			$this->load->view('templates/header', $data);
            $this->load->view('pages/returned_items',$data);
            $this->load->view('templates/footer');
		}
		else{
			redirect('/','refresh');
		}
	}

}

/* End of file Returned.php */
/* Location: ./application/controllers/Returned.php */