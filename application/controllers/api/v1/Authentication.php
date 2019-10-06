<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Authentication extends REST_Controller
{

    private $client;
    /**
     * Initialize/Load all configurations and models
     */
    public function __construct()
    {
        parent::__construct();

        // Load the account model
        $this->load->model('account');
        $this->load->model('authentication_model');
        $basic = new Nexmo\Client\Credentials\Basic('33a25745', 'vnYjbZVuRBHqy6R6');
        $this->client = new Nexmo\Client($basic);
    }

    /**
     * Login Validation
     * HTTP Request Method: POST
     * Required Fields: Makatizen Number and Password
     * URL Route: api/v1/auth/login
     */
    public function request_login_post()
    {
//        $card_number = $this->post('card_number');
        $makatizen_number = $this->post('makatizen_number');
        $password = $this->post('password');

        if (!empty($makatizen_number) && !empty($password)) {

            $result = $this->account->validate_account_with_makatizen_num($makatizen_number, $password);

            if ($result != false) {
                //Account Valid
                $this->response(array(
                    'valid' => true,
                    'message' => 'Login Successful',
                    'account_id' => (int)$result['id'] /* Account ID */
                ), REST_Controller::HTTP_OK);
            } else {
                //Account not valid
                $this->response(array(
                    'valid' => false,
                    'message' => 'Login Credentials is Invalid'
                ), REST_Controller::HTTP_OK);
            }
        } else {
            // Set the response and exit
            $this->response("Provide makatizen number and password.", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Account Registration
     * HTTP Request Method: POST
     * Required Fields: Makatizen Data and Password
     * URL Route: api/v1/auth/register
     */
    public function register_account_post()
    {
//        $new_account['card_number'] = $this->post('card_number');
        $new_account['makatizen_number'] = $this->post('makatizen_number');
        $new_account['password'] = md5($this->post('password'));
        $new_account['first_name'] = $this->post('first_name');
        $new_account['middle_name'] = $this->post('middle_name');
        $new_account['last_name'] = $this->post('last_name');
        $new_account['age'] = $this->post('age');
        $new_account['sex'] = $this->post('sex');
        $new_account['address'] = $this->post('address');
        $new_account['contact_number'] = $this->post('contact_number');
        $new_account['civil_status'] = $this->post('civil_status');
        $new_account['email_address'] = $this->post('email_address');
        $new_account['image'] = $this->post('profile_image_url');
        $new_account['status'] = 1; //new account

        $account_exist = $this->account->get(array('returnType' => 'count', 'conditions' => array('makatizen_number' => $new_account['makatizen_number'])));

        if (!$account_exist) {
            $account_id = $this->account->insert($new_account); //Insert new account
            $account_data = $this->account->get(array('id' => $account_id)); //get account data

            if ($account_data) {
                $this->response(array(
                    'successful' => true,
                    'message' => 'Registration Successful',
                    'account_id' => (int)$account_data['id']
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'successful' => false,
                    'message' => 'Registration failed'
                ), REST_Controller::HTTP_OK);
            }
        } else {
            $this->response(array(
                'successful' => false,
                'message' => 'Makatizen number is already used'
            ), REST_Controller::HTTP_OK);
        }
    }

    public function check_makatizen_get()
    {
        $makatizen_number = $this->get('makatizen_number');
        if (isset($makatizen_number)) {
            //Check if the makatizen id if already registered
            $result = $this->account->get(array(
                'returnType' => 'single',
                'conditions' => array(
                    'makatizen_number' => $makatizen_number
                )
            ));

            if ($result) {
                $this->response(array(
                    'status' => 1,
                    'message' => "Makatizen Number is registered",
                    'email' => $result['email_address'],
                    'phone' => $result['contact_number']
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    'status' => 0,
                    'message' => 'Makatizen Number not yet registered'
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response("Makatizen Number is required!", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function reset_password_post()
    {
        $makatizen_number = $this->post('makatizen_number');
        $new_password = $this->post('password');

        if (isset($makatizen_number, $new_password)) {
            //Change Password
            $data = array(
                'password' => md5($new_password)
            );

            //Get the account ID using makatizen_number
            $account_data = $this->account->get(array(
                'returnType' => 'single',
                'conditions' => array(
                    'makatizen_number' => $makatizen_number
                )
            ));

            if ($account_data) {
                $result = $this->account->update($data, $account_data['id']);
                if ($result) {
                    $this->response(array(
                        'status' => 1,
                        'message' => 'Change Password Successful'
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'status' => 0,
                        'message' => 'Failed to Change Password'
                    ), REST_Controller::HTTP_OK);
                }
            } else {
            $this->response("Account Not found!. Database Error Occurred.", REST_Controller::HTTP_BAD_REQUEST);

            }

        } else {
            $this->response("Makatizen Number & New Password is required!", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

    public function change_password_post()
    {
        $accountId = $this->post('account_id');
        $newPassword = $this->post('new_password');
        $oldPassword = $this->post('old_password');

        if (isset($accountId, $newPassword, $oldPassword)) {
            //Check if the old password is correct
            $result = $this->account->get(array(
                'returnType' => 'single',
                'conditions' => array(
                    'id' => $accountId,
                    'password' => md5($oldPassword)
                )
            ));

            if ($result) {
                $result = $this->account->update(array(
                    'password' => md5($newPassword)
                ), $accountId);

                if ($result) {
                    $this->response(array(
                        'status' => 1,
                        'message' => 'Change Password Successful'
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'status' => 2,
                        'message' => 'Failed to Change Password'
                    ), REST_Controller::HTTP_OK);
                }

            } else {
                $this->response(array(
                    'status' => 0,
                    'message' => 'Invalid Old Password'
                ), REST_Controller::HTTP_OK);
            }

        } else {
            $this->response("Account Id, New Password and Old Password is required", REST_Controller::HTTP_BAD_REQUEST);
        }

    }

   public function send_email_verification_post()
   {
        $email = $this->post('email');
        $token = $this->post('token');

        if (isset($email, $token)) {
            //Generate Random Code
            $this->load->helper('string');
            $random_code = strtoupper(random_string('alnum', 6));
            $this->load->model('authentication_model');


            $insert_result = $this->authentication_model->insert_email_verification($email, $random_code, $token);

            if ($insert_result) {
                //Send the code to email
                $config['mailtype'] = 'html';
                $this->load->library('email', $config);
                $data['code'] = $random_code;
                $data['link'] = base_url() . 'auth/verify_email?token=' . $token . '&id=' . $insert_result;


                $this->email->set_newline("\r\n");
                $this->email->from('makahana@makahanap.x10host.com', 'Maka-Hanap');
                $this->email->to($email);
                $this->email->subject('Makatizen Email Verification');
                $this->email->message($this->load->view('templates/email_verification_format', $data, TRUE));
                $result = $this->email->send();
                if ($result) {
                    $this->response(array(
                        'email_sent' => true
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'email_sent' => false
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response('Database Error Occurred', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Email and Token is required', REST_Controller::HTTP_BAD_REQUEST);
        }
   }

   public function verify_code_post()
   {
       $email = $this->post('email');
       $code = $this->post('code');

       if (isset($email, $code)) {
            $verified = $this->authentication_model->verify_code($code, $email);

            if ($verified) {

                $date = $verified['date_generated'];

                if (strtotime($date) > strtotime("-5 minutes")) {
                    $this->authentication_model->verify_email($verified['id']);
                    $this->response(array(
                        'valid' => true,
                        'expired' => false
                    ), REST_Controller::HTTP_OK);

                } else {
                    //Expired code
                    $this->response(array(
                        'valid' => false,
                        'expired' => true
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response(array(
                        'valid' => false,
                        'expired' => false,
                    ), REST_Controller::HTTP_OK);
            }

       } else {
        $this->response('Email and Code is required', REST_Controller::HTTP_BAD_REQUEST);
       }
   }


   public function send_sms_request_post()
   {
        $number = $this->post('number');

        //Make a Request
        $verification = $this->client->verify()->start([
            'number' => $number,
            'brand'  => 'Maka-Hanap',
            'code_length'  => '4']);

        if ($verification->getRequestId()) {
            $this->response(array(
                'sms_sent' => true,
                'request_id' => $verification->getRequestId()
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                'sms_sent' => false,
                'request_id' => ''
            ), REST_Controller::HTTP_OK);
        }
   }

   public function check_sms_request_get()
   {
        $request_id = $this->get('request_id');
        $code = $this->get('code');

        $verification = new \Nexmo\Verify\Verification($request_id);

        try {
            $result = $this->client->verify()->check($verification, $code);
            $this->response(array(
                'verified' => true
            ), REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->response(array(
                'verified' => false
            ), REST_Controller::HTTP_OK);
        }
   }

   public function cancel_sms_request_get()
   {

        $request_id = $this->get('request_id');
        try {
            $result = $this->client->verify()->cancel($request_id);
            $this->response(array(
                'cancelled' => true
            ), REST_Controller::HTTP_OK);
        }
        catch(Exception $e) {
            $this->response(array(
                'cancelled' => false
            ), REST_Controller::HTTP_OK);
        }
   }

   public function request_password_reset_post()
   {
        $email = $this->post('email');

        if (isset($email)) {
            //Generate 6-Alphanumeric Random Code
            $this->load->helper('string');
            $random_code = strtoupper(random_string('alnum', 6));
            $this->load->model('authentication_model');

            $insert_success = $this->authentication_model->insert_email_verification($email, $random_code, "");

            if ($insert_success) {
                //Send the code to email
                $config['mailtype'] = 'html';
                $this->load->library('email', $config);
                $data['code'] = $random_code;

                $this->email->set_newline("\r\n");
                $this->email->from('makahana@makahanap.x10host.com', 'Maka-Hanap');
                $this->email->to($email);
                $this->email->subject('Password Reset');
                $this->email->message($this->load->view('templates/reset_pass_email_format.php', $data, TRUE));
                $result = $this->email->send();
                if ($result) {
                    $this->response(array(
                        'email_sent' => true
                    ), REST_Controller::HTTP_OK);
                } else {
                    $this->response(array(
                        'email_sent' => false
                    ), REST_Controller::HTTP_OK);
                }
            } else {
                $this->response('Database Error Occurred', REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            //Return Response 404 Bad Request
            $this->response("Email is required!", REST_Controller::HTTP_BAD_REQUEST);
        }

   }
}