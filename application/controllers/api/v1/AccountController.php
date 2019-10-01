<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class AccountController extends REST_Controller {

    /**
     * Initialize/Load all configurations and models
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('account');
        $this->load->model('notification_model');
        $this->load->model('transaction_model');
    }

    /**
     * Account Data
     * HTTP Request Method: GET
     * Required Params: $id -> account id
     * URL Route: api/v1/account/{account_id}
     */
    public function account_get($id)
    {
        if (isset($id)) {
            $account_data = $this->account->get(array('id' => $id)); //Getting Account Data

            if ($account_data) { //Check account data
                $this->response(array(
                    'id' => (int) $account_data['id'],
                    'makatizen_number' => $account_data['makatizen_number'],
                    'first_name' => $account_data['first_name'],
                    'middle_name' => $account_data['middle_name'],
                    'last_name' => $account_data['last_name'],
                    'age' => (int) $account_data['age'],
                    'address' => $account_data['address'],
                    'sex' => $account_data['sex'],
                    'civil_status' => $account_data['civil_status'],
                    'contact_number' => $account_data['contact_number'],
                    'email_address' => $account_data['email_address'],
                    'profile_image_url' => $account_data['image'],
                    'date_created' => $account_data['date_created'],
                    'status' => $account_data['status']
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response(array(),REST_Controller::HTTP_OK); //No Account Details Found
            }

        } else {
            $this->response("Provide Account ID",REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function type_counts_get($account_id)
    {
        $type = $this->get('type');

        if (isset($type, $account_id)) {
            $condition['returnType'] = 'count';
            $condition['conditions'] = array(
                'type' => $type,
                'account_id' => $account_id
            );

            $this->load->model('item');

            $result_count = $this->item->get($condition);
            $this->response(array(
                'count' => $result_count
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response("Account ID and type not found",REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function status_counts_get($account_id)
    {
        $status = $this->get('status');
        if (isset($account_id)) {
            $condition['returnType'] = 'count';
            $condition['conditions'] = array(
                'status' => $status,
                'account_id' => $account_id
            );
            $this->load->model('item');
            $result_count = $this->item->get($condition);
            $this->response(array(
                'count' => $result_count
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response("Account ID not found",REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function new_rating_post()
    {
         $rated_to = $this->post('rated_to');
         $feedback = $this->post('feed_back');
         $rating = $this->post('rating');
         $rated_by = $this->post('rated_by');
         if (isset($rated_to, $rating)) {
             $data = array(
                 'rated_to' => $rated_to,
                 'feed_back' => $feedback,
                 'rating' => $rating,
                 'rated_by' => $rated_by
             );
             $rating_id = $this->account->add_rating($data);

             if ($rating_id == true) {
                 $this->response("", REST_Controller::HTTP_OK);
             } else {
                 $this->response('Failed to add new rating', REST_Controller::HTTP_BAD_REQUEST);
             }
         } else {
             $this->response('Account id and Rating is required!', REST_Controller::HTTP_BAD_REQUEST);
         }
    }

    public function average_rating_get($account_id)
    {
         if (isset($account_id)) {
             $result = $this->account->rating($account_id);
             if ($result) {
                 $total_weight = 0;
                 $total_reviews = 0;
                 foreach ($result as $ratings) {
                     $weight_multiplied = $ratings['rating'] * $ratings['count'];
                     $total_weight += $weight_multiplied;
                     $total_reviews += $ratings['count'];
                 }
                 $rating = round($total_weight/$total_reviews, 1);
                 $this->response(array(
                     'total_reviews' => (int) $total_reviews,
                     'average_rating' => $rating
                 ), REST_Controller::HTTP_OK);
             } else {
                 $this->response(array(
                     'total_reviews' => 0,
                     'average_rating' => 0
                 ), REST_Controller::HTTP_OK);
             }
         } else {
             $this->response('Account ID is required', REST_Controller::HTTP_BAD_REQUEST);
         }
    }

}