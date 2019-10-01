<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Deadlinks_controller extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
    }
    public function privacy_policy(){
        $this->load->view('deadlinks/privacy_policy');
    }
    
}