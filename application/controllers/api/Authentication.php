<?php
use Restserver\Libraries\REST_Controller;
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Authentication extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
    }
    
    public function login_post() {
        // Get the post data
        $email = $this->post('email');
        $password = $this->post('password');
        
        // Validate the post data
        if(!empty($email) && !empty($password)){
        
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'password' => md5($password),
                'status' => 1
            );
            $user = $this->user->getRows($con);
            
            if($user){
                
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User login successful.',
                    'data' => $user
                ], REST_Controller::HTTP_OK);
            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response("Wrong email or password.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            // Set the response and exit
            $this->response("Provide email and password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function registration_post() {
        // Get the post data
        $username = strip_tags($this->post('username'));
        $email = strip_tags($this->post('email'));
        $password = $this->post('password');
        
        // Validate the post data
        if(!empty($name) && !empty($email) && !empty($password)){
            
            // Check if the given email already exists
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'email' => $email,
            );
            $userCount = $this->user->getRows($con);
            
            if($userCount > 0){
                // Set the response and exit
                $this->response("The given email already exists.", REST_Controller::HTTP_BAD_REQUEST);
            }else{
                // Insert user data
                $userData = array(
                    'username' => $name,
                    'email' => $email,
                    'password' => md5($password)
                );
                $insert = $this->user->insert($userData);
                
                // Check if the user data is inserted
                if($insert){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'The user has been added successfully.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }else{
            // Set the response and exit
            $this->response("Provide complete user info to add.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}