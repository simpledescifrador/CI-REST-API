<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repository extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index(){
        $data['page_title'] = 'MakaHanap | Admin Dashboard/Repository';

        if(isset($this->session->userdata['logged_in']))
		{	
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/repository');
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