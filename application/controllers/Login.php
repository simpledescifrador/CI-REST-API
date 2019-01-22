<?php

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    public function index() {
        $data['title'] = "Makahanap | Admin Login";
        if (!isset($this->session->userdata['logged_in']))
        {
            $this->load->view('login_view', $data);
        }
        else
        {
            redirect('admin', 'refresh');
        }
    }

    public function validation() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');

        if ($this->form_validation->run() == TRUE) {
            //TODO go to admin page
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            redirect('admin', 'refresh');
        } else {
            # code...
            $this->session->set_flashdata('validation_msg', validation_errors());;
            redirect('login', 'refresh');
        }
    }
}