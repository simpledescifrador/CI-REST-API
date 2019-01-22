<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class AccountController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('account');
    }

    public function searchAccount_get()
    {
        $id = $this->get("id");
        //Set condition
        $con['returnType'] = 'single';
        if (isset($id)) {
            $con['id'] = $id; //Pass ID value to condition params
            $account_data = $this->account->get($con);

            if ($account_data) { //data is available
                //Set response
                $this->response($account_data, REST_Controller::HTTP_OK);
            }
        } else {
            $this->response("ID is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function updateAccountById_put($id)
    {
        //Data to be updated
        $status = $this->put("status");
        //Check if ID
        if (isset($id)) {
            $new_data = array(
                "status" => $status
            );
            $update_result = $this->account->update($new_data, $id);
            if ($update_result) {
                $this->response("Account updated successfully", REST_Controller::HTTP_OK);
            } else {
                $this->response("Account update failed", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Account id is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //FIXME 404 not found this method
    public function deleteAccountById_delete($id)
    {
        if (isset($id)) {
            $delete_result = $this->account->delete($id);
            if ($delete_result) {
                $this->response("Account deleted", REST_Controller::HTTP_OK);
            } else {
                $this->response("Account failed to delete", REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response("Account id is required", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}