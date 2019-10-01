<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_controller extends CI_Controller{

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
    }

    public function index(){
        $data['page_title'] = 'MakaHanap | Admin/Users';

        if(isset($this->session->userdata['logged_in']))
		{	
            $data['active_users'] = $this->user->getActiveUsers();
            $data['reported_users'] = $this->user->getReportedUsers();
            $data['blocked_users'] = $this->user->getBlockedUsers();

            $this->load->view('templates/header',$data);
            $this->load->view('pages/users', $data);
            $this->load->view('templates/footer');
		}
		else
		{
            redirect('/','refresh');
		}
    }

    public function UserProfile(){
        $data['page_title'] = 'MakaHanap | Admin/Users';
        

        if(isset($this->session->userdata['logged_in']))
        {   
            $id = $this->input->get('token');
            $data['mUser_details'] = $this->user->mobileUserDetail($id);
            $data['mUser_rating'] = $this->user->mobileUserRating($id);
            $data['mUser_posts'] = $this->user->mobileUserPosts($id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('pages/user_profile', $data);
            $this->load->view('templates/footer');
        }
        else
        {
            redirect('/','refresh');
        }
    }
    
}