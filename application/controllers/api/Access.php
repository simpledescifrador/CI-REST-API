<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Access extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        //load user model
        $this->load->model('user');
        
    }
    
    public function user_get() {
        $id = $this->get('id');
        $username = $this->get('username');

        if (isset($username)) {
            // Get User by username
            $users = $this->user->getRows(array('username' => $username));
        }
        if (isset($id)) {
            // Get user by id
            $users = $this->user->getRows(array('id' => $id));
        }
        //check if the user data exists
        if(!empty($users)){
            //set the response and exit
            $this->response($users, REST_Controller::HTTP_OK);
        }else{
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function users_get() {
        $users = $this->user->getRows();
        //check if the user data exists
        if(!empty($users)){
            //set the response and exit
            $this->response($users, REST_Controller::HTTP_OK);
        }else{
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function user_post() {
        $userData = array();
        $userData['name'] = $this->post('name');
        $userData['username'] = $this->post('username');
        $userData['password'] = $this->encrypt_pass($this->post('password'));
        $userData['email'] = $this->post('email');
        $userData['phone'] = $this->post('phone');

        if(!empty($userData['name']) && !empty($userData['username']) && ($userData['password']) &&!empty($userData['email']) && !empty($userData['phone'])){

            // Check if user exist
            if (!$this->user->getRows(array('username' => $userData['username']))) {
                //insert user data
                $insert = $this->user->insert($userData);
                //check if the user data inserted
                if($insert){
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User has been added successfully.'
                    ], REST_Controller::HTTP_OK);
                }else{
                    //set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'User is already exist.'
                ], REST_Controller::HTTP_CONFLICT);
            }

            
        }else{
            //set the response and exit
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function user_put($id) {
        $userData = array();
        $userData['name'] = $this->put('name');
        $userData['username'] = $this->put('username');
        $userData['password'] = $this->encrypt_pass($this->post('password'));
        $userData['email'] = $this->put('email');
        $userData['phone'] = $this->put('phone');
        if(!empty($id) && !empty($userData['name']) && !empty($userData['username']) && ($userData['password']) &&!empty($userData['email']) && !empty($userData['phone'])){
            //update user data
            $update = $this->user->update($userData, $id);
            
            //check if the user data updated
            if($update){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response("Provide complete user information to update.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    public function user_delete($id){
        //check whether post id is not empty
        if($id){
            //delete post
            $delete = $this->user->delete($id);
            
            if($delete){
                //set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User has been removed successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                //set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    private function encrypt_pass($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

}

?>