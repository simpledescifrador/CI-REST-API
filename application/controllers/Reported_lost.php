<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reported_lost extends CI_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('lost_item');
        $this->load->helper('url_helper');
    }

    public function index(){

        $data['lost_item'] = $this->lost_item->get();

        $data['page_title'] = 'MakaHanap | Admin Dashboard/Lost Items';

        if(isset($this->session->userdata['logged_in']))
		{	
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/lost_items');
            $this->load->view('modals/add_found_item');
            $this->load->view('modals/add_lost_item');
            $this->load->view('templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}
    }
    
}