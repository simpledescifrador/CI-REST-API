<?php

class Users_controller extends CI_Controller{

    
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['page_title'] = 'MakaHanap | Admin/Users';

        if(isset($this->session->userdata['logged_in']))
		{	
            
            $this->load->view('templates/header',$data);
            $this->load->view('pages/users');
            $this->load->view('templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}
    }
    
}