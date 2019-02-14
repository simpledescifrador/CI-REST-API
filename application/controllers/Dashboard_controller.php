<?php

class Dashboard_controller extends CI_Controller{

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        
        $this->load->model('lost_item');
        $this->load->model('found_model');
        $this->load->model('login_model');
    }
    

    public function home(){

        $lost_item_count = $this->lost_item->count_lost_items();
        $found_item_count = $this->found_model->count_found();

        

        $data['page_title'] = 'MakaHanap | Admin Dashboard';
        $data['total_lost'] = $lost_item_count;
        $data['total_found'] = $found_item_count;

    
        if(isset($this->session->userdata['logged_in']))
		{	
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/dashboard',$data);
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
