<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
  public function index()
  {
    $data['title'] = 'Admin Dashboard';
    $this->load->view('templates/header', $data);
    $this->load->view('admin_dashboard', $data);
    $this->load->view('/templates/footer');
  }
}