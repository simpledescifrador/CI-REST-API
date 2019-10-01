<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('login_model');
		$this->load->model('user');
		$this->load->library('form_validation');
	}
	public function index() {
		$data['page_title'] = 'Login | Makahanap: Lost and Found';
		if(isset($this->session->userdata['logged_in']))
		{

			redirect('dashboard', 'refresh');
		}
		else if(isset($this->session->userdata['b_logged_in']))
		{

			redirect('barangay', 'refresh');
		}
		else
		{

			$this->load->view('login', $data);

		}
	}

	public function login_validation(){ //check if the username or/& pw is correct
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('validate_msg', validation_errors());
			redirect('/');

		} else {
			# code...
			//getting value from the login form
			$data['username'] = $this->input->post('username');
			$data['password'] = $this->input->post('password');
			$result = $this->login_model->login_test($data);//get data from login model

			if($result)
			{
				$username = $this->input->post('username');
				$result = $this->login_model->readAdminInfo($username);

				if($result){

					$results = $this->user->user_type($data);

					foreach ($results as $row) {
						$data['type'] = $row->type;
						$data['name'] = $row->name;
						$data['brgy_id'] = $row->brgy_id;
						$data['user_id'] = $row->id;
					}

					if($data['type'] != 'barangay'){
						$session_data = array(
							'username' => ucfirst($username)
						);
						$this->session->set_userdata('logged_in', $session_data);
						$this->session->set_flashdata('alert_message', '<b class="white icon-checkmark22"></b>
							&ensp;Welcome back,  '.ucfirst($data['name']));
						$this->session->set_flashdata('alert_type', 'alert-success');
						redirect('dashboard');
					}
					else{
						$session_data = array(
							'curr_user' => ucfirst($username),
							'brgy_id' => $data['brgy_id'],
							'user_id' => $data['user_id']
						);
						$this->session->set_userdata('b_logged_in', $session_data);

						redirect('barangay');
					}

				}
			}else
				{
					$data['error_msg'] = 'Invalid Username or Password';
					$this->session->set_flashdata('error_msg', $data['error_msg']);
					redirect('/');
				}
		}
		}


	public function logout(){ //logout function for admin
			// Removing session data
			$sess_array = array(
				'username' => ''
			);
			$this->session->unset_userdata('logged_in', $sess_array);
			$data['display_msg'] = 'Successfully Logout';
			$this->session->set_flashdata('display_msg', $data['display_msg']);
			redirect('/');
	}
	public function b_logout(){ //logout_function for barangay
		// Removing session data
		$sess_array = array(
			'username' => ''
		);
		$this->session->unset_userdata('b_logged_in', $sess_array);
		$data['display_msg'] = 'Successfully Logout';
		$this->session->set_flashdata('display_msg', $data['display_msg']);
		redirect('/');
}
}
