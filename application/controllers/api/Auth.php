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

    public function registration_post()
    {
        //Get Post Data
        $card_number = $this->post('card_number');
//        $username = strip_tags($this->post('username'));
        $password = $this->post('password');
        $name = $this->post('name');
        $age = $this->post('age');
        $address = $this->post('address');
        $contact_number = $this->post('contact_number');
        $civil_status = $this->post('civil_status');

        //Validate Post Data
        if (isset($card_number, $password, $name, $age, $address, $contact_number, $civil_status)) {
            // Check if the given card_number already exists
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'card_number' => $card_number,
            );

            $account_count = $this->account->get($con);

            if ($account_count > 0) {
                // Set the response and exit
                $this->response("The given card number already exists", REST_Controller::HTTP_CONFLICT);
            } else {

                // Insert Account Data
                $account_data = array(
                    'card_number' => $card_number,
                    'password' => md5($password),
                    'name' => $name,
                    'age' => $age,
                    'address' => $address,
                    'contact_number' => $contact_number,
                    'civil_status' => $civil_status
                );

                $account_insert_id = $this->account->insert($account_data);

                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'card_number' => $card_number,
                    'password' => md5($password)
                );

                $account = $this->account->get($con);

                if ($account_insert_id) {
                    // Set the response and exit
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'The account has been added successfully.',
                        'account_data' => $account
                    ), REST_Controller::HTTP_CREATED);
                } else {
                    // Set the response and exit
                    $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
                }
            }

        } else {
            // Set the response and exit
            $this->response("Provide account details", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function login_post()
    {
        //Get username and password
//        $username = $this->post('username');
        $card_number = $this->post('card_number');
        $password = $this->post('password');

        //Validate data
        if (isset($card_number, $password)) {
            //do login verification here
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'card_number' => $card_number,
                'password' => md5($password)
            );

            $account_data = $this->account->get($con);
            if ($account_data) {
                if ($account_data['status'] != 'Banned') {
                    //set response and exit 
                    $this->response(array(
                        'status' => TRUE,
                        'message' => 'Account Verified',
                        'account_data' => $account_data
                    ), REST_Controller::HTTP_ACCEPTED);
                } else {
                    //inform account is banned from the system
                    //set response
                    $this->response(array(
                        'message' => 'Account is banned'
                    ), REST_Controller::HTTP_UNAUTHORIZED);
                }
            } else {
                // Set the response and exit
                //Not found (404) being the HTTP response code
                $this->response(array(
                    'message' => 'Wrong card number or password'
                ), REST_Controller::HTTP_NOT_FOUND);
            }

        } else {
            // Set the response and exit
            $this->response("Provide card_number and password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}