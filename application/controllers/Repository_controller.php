<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repository_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('repository');
    }

    public function index(){
        $data['page_title'] = 'MakaHanap | Admin Dashboard/Repository';

        if(isset($this->session->userdata['logged_in']))
		{	
            $data['repo_content'] = $this->repository->rpoView();

            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/repository',$data);
            $this->load->view('modals/add_brgy_account');
            $this->load->view('templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}
    }
    
}