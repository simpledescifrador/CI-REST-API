<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller {

    public function __construct() { 
      parent::__construct();
      
      //load user model
      $this->load->model('user');
      
    }

    public function access_post(){
      //Create a array will hold post data from the client
      $userData = array();
      $userData['username'] = $this->post('username');
      $userData['password'] = $this->post('password');
      //Check if empty
      if(!empty($userData['username']) && !empty($userData['password'])) {
        //  TODO: Validate User Details
        $password_hash = $this->user->getPasswordHash($userData['username']);
        if (password_verify($userData['password'], $password_hash)) {
            $this->response([
              'status' => TRUE,
              'message' => 'User is registered'
          ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
              'status' => FALSE,
              'message' => 'User not found.'
          ], REST_Controller::HTTP_NOT_FOUND);
        }

      } else {
        //  Set Response and exit
        $this->response("Provide User Information for validation", REST_Controller::HTTP_BAD_REQUEST);
      }
      
    }
}