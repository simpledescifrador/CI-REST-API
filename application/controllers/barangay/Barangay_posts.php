<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangay_posts extends CI_Controller {

    public function __construct()
	{
        parent::__construct();
        $this->load->model('repository');
		$this->load->model('lost_item');
		$this->load->model('user');
		$this->load->model('login_model');
		$this->load->model('found_item');
    }

    public function index()
    {
        if(isset($this->session->userdata['b_logged_in'])) {
            $data['page_title'] = 'Makahanap | Report Item';
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

            $this->load->view('barangay/templates/header',$data);
            $this->load->view('barangay/modals/home_modals', $data);
            $this->load->view('barangay/pages/post_item_form', $data);
            $this->load->view('barangay/templates/footer');
        } else {
			redirect('/','refresh');
        }
    }
}