<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Auth extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Load the user model
        $this->load->model('account');
    }

    public function register_post()
    {
        //$new_account['id'] = uniqid('A');
        $new_account['card_number'] = $this->post('card_number');
        $new_account['password'] = md5($this->post('password'));
        $new_account['first_name'] = $this->post('first_name');
        $new_account['middle_name'] = $this->post('middle_name');
        $new_account['last_name'] = $this->post('last_name');
        $new_account['age'] = $this->post('age');
        $new_account['sex'] = $this->post('sex');
        $new_account['address'] = $this->post('address');
        $new_account['contact_number'] = $this->post('contact_number');
        $new_account['civil_status'] = $this->post('civil_status');
        $new_account['image'] = $this->post('image_url');
        $new_account['status'] = 1; //new account
        $valid_account = false;
//       Validate new account
        foreach ($new_account as $account_data) {
            if (isset($account_data)) {
                $valid_account = true;
            }
        }

        if ($valid_account) {
            $account_exist = $this->account->get(array('returnType' => 'count', 'conditions' => array('card_number' => $new_account['card_number'])));
            if (!$account_exist) {
                $account_id = $this->account->insert($new_account); //Insert new account
                $account_data = $this->account->get(array('id' => $account_id)); //get account data
                if ($account_data) {
                    $this->response(array(
                        'status' => true,
                        'message' => 'Registration Success',
                        'account_data' => array(
							'id' => $account_data['id'],
                            'card_number' => $account_data['card_number'],
                            'first_name' => $account_data['first_name'],
                            'middle_name' => $account_data['middle_name'],
                            'last_name' => $account_data['last_name'],
                            'age' => (int)$account_data['age'],
                            'address' => $account_data['address'],
                            'sex' => $account_data['sex'],
                            'civil_status' => $account_data['civil_status'],
                            'contact_number' => $account_data['contact_number'],
                            'image_url' => $account_data['image'],
                            'date_created' => $account_data['date_created'],
                            'status' => $account_data['status']
                        )
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'status' => false,
                        'message' => 'Registration failed'
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response(array(
                    'status' => false,
                    'message' => 'Card number is already used'
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response("Invalid account", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function login_post()
    {
        $credentials['card_number'] = $this->post('card_number');
        $credentials['password'] = md5($this->post('password'));

        if (isset($credentials['card_number'], $credentials['password'])) {

            $result = $this->account->get(array(
                'returnType' => 'single',
                'conditions' => $credentials));
            if ($result) {
                $this->response(array(
                    'valid' => true,
                    'message' => "Login Successful",
                    "data" => array(
                        'id' => $result['id'],
                        'card_number' => $result['card_number'],
                        'first_name' => $result['first_name'],
                        'middle_name' => $result['middle_name'],
                        'last_name' => $result['last_name'],
                        'age' => (int) $result['age'],
                        'address' => $result['address'],
                        'sex' => $result['sex'],
                        'civil_status' => $result['civil_status'],
                        'contact_number' => $result['contact_number'],
                        'image_url' => $result['image'],
                        'date_created' => $result['date_created'],
                        'status' => $result['status']
                    )
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'valid' => false,
                    'message' => "Invalid card number or password"
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response("Card number and password is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function register_token_post()
    {
        $token = $this->post('token');
        $account_id = $this->post('account_id');

        if (isset($token, $account_id)) {
            $result = $this->account->add_token($token, $account_id);

            if ($result) { // Insert token Sucess
                $this->response(array(
                    "success" => true,
                    "message" => "Token Sucessfully Registered"
                ), REST_Controller::HTTP_OK);

            } else {
                $this->response('Token Failed to Register', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Token and account id is required', REST_Controller::HTTP_BAD_REQUEST);
        }

    }
}
