<?php

class Barangay_home extends CI_Controller{
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('repository');
        $this->load->model('lost_item');
    }
    

    public function home(){
        
        $data['page_title'] = 'Makahanap | Barangay';

        if(isset($this->session->userdata['b_logged_in']))
		{

            $this->load->view('baranggay/templates/header',$data);
            $this->load->view('baranggay/pages/home', $data);
            $this->load->view('baranggay/templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}

    }


}