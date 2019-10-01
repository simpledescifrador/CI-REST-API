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
        $this->load->model('notification_model');
        $this->load->model('transaction_model');
    }
    public function all_account_names_get()
    {
        $result = $this->account->get();
        $names = array();
        for ($i=0; $i < count($result); $i++) {
            $names[$i] = $result[$i]['first_name'] . " " . substr($result[$i]['middle_name'], 0, 1) . ". " . $result[$i]['last_name'];
        }

        if (count($names) > 0) {
            $this->response(array(
                "total_account" => count($names),
                "account_names" => $names
            ), REST_Controller::HTTP_OK);
        } else {
            $this->response(array(
                "total_account" => count($names),
                "account_names" => $names
            ), REST_Controller::HTTP_OK);
        }
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
                $account = array(
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
                );
                $this->response($account, REST_Controller::HTTP_OK);
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
    public function load_notifications_get()
    {
        $account_id = $this->get('account_id');
        $notifications = array();
        if (isset($account_id)) {
            $result = $this->notification_model->get(array(
                'conditions' => array(
                    'account_id' => $account_id
                )));
            $result_count = $this->notification_model->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'account_id' => $account_id
                )));
            /* Pass the result into notifications array */
            for ($i=0; $i < $result_count; $i++) {
                $notifications[$i] = array(
                    'id' => (int) $result[$i]['id'],
                    'title' => ucfirst($result[$i]['title']),
                    'content' => ucfirst($result[$i]['content']),
                    'image_url' => $result[$i]['image_url'],
                    'created_at' => $result[$i]['created_at'],
                    'viewed' => (bool) ($result[$i]['is_read'] == "Yes")? true : false,
                    'type' => $result[$i]['type'],
                    'ref_id' => (int) $result[$i]['ref_id']
                );
            }
            if ($result) {
                $this->response(array(
                    'total_results' => $result_count,
                    'notifications' => $notifications
                ), REST_Controller:: HTTP_OK);
            } else {
                $this->response(array(
                    'total_results' => $result_count,
                    'notifications' => $notifications
                ), REST_Controller:: HTTP_OK);
            }
        }
    }

    public function total_notifications_get($account_id)
    {
        if (isset($account_id)) {
            $result_count = $this->notification_model->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'account_id' => $account_id
                )));

            if ($result_count) {
                $this->response(array(
                    "total_results" => (int) $result_count
                ),REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "total_results" => 0
                ),REST_Controller::HTTP_OK);
            }

        }
    }

    public function unread_notification_count_get($account_id)
    {
        if (isset($account_id)) {
            $result_count = $this->notification_model->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'account_id' => $account_id,
                    'is_read' => "No"
                )));

            if ($result_count) {
                $this->response(array(
                    "total_results" => (int) $result_count
                ),REST_Controller::HTTP_OK);
            } else {
                $this->response(array(
                    "total_results" => 0
                ),REST_Controller::HTTP_OK);
            }
        }

   }
   public function mark_notification_as_viewed_put($id)
   {
       if (isset($id)) { /* Check if $id value */
           /* Set the notification as read or viewed */
           $result = $this->notification_model->set_notification_read($id);

           if ($result == true) {
               /* Update Successful */
               $this->response(array(
                   'success' => true
               ),REST_Controller::HTTP_OK);
           } else {
               /* Update Failed */
               $this->response(array(
                   'success' => false
               ),REST_Controller::HTTP_OK);
           }
       } else {
           $this->response('Notification ID is required!', REST_Controller::HTTP_BAD_REQUEST);
       }
   }

   public function mark_notification_as_unviewed_put($id)
   {
       if (isset($id)) {/* Check if $id value */
           /* Set the notification as unread or unviewed */
           $result = $this->notification_model->set_notification_unread($id);

           if ($result == true) {
               /* Update Successful */
               $this->response(array(
                   'success' => true
               ),REST_Controller::HTTP_OK);
           } else {
               /* Update Failed */
               $this->response(array(
                   'success' => false
               ),REST_Controller::HTTP_OK);
           }
       } else {
           $this->response('Notification ID is required!', REST_Controller::HTTP_BAD_REQUEST);
       }
   }

   public function delete_notification_put($id)
   {
       if (isset($id)) {
           /* Delete notification */
           $result = $this->notification_model->delete_notification($id);

           if ($result == true) {
               /* Update Successful */
               $this->response(array(
                   'success' => true,
                   'notification_id' => (int) $id
               ),REST_Controller::HTTP_OK);
           } else {
               /* Update Failed */
               $this->response(array(
                   'success' => false,
                   'notification_id' => (int) $id
               ),REST_Controller::HTTP_OK);
           }
       } else {
           $this->response('Notification ID is required!', REST_Controller::HTTP_BAD_REQUEST);
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
                $this->response(array(
                    'success' => true,
                    'rating_id' => (int)$rating_id
                ), REST_Controller::HTTP_OK);
            } else {
                $this->response('Failed to add new rating',REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response('Account id and Rating is required!',REST_Controller::HTTP_BAD_REQUEST);
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
            $this->response('Account ID is required',REST_Controller::HTTP_BAD_REQUEST);
        }
   }

   public function account_transactions_get($account_id)
   {
       if (isset($account_id)) {
           $transactions = $this->transaction_model->account_transactions($account_id);
           if ($transactions) {
               $transaction_data = array();
               foreach ($transactions as $key => $value) {
                   $transaction_data[$key] = array(
                       'id' => $value['transaction_id'],
                       'transfer_to' => $value['transfer_to'],
                       'return_location' => array(
                           'id' => $value['return_location_id'],
                           'name' => $value['return_location_name'],
                           'address' => $value['return_location_address'],
                           'latitude' => $value['return_location_lat'],
                           'longitude' => $value['return_location_long'],
                       ),
                       'return_date' => $value['return_date'],
                       'return_image' => 'uploads/transaction_images/' . $value['transaction_image'],
                       'item_id' => $value['item_id'],
                       'status' => $value['transaction_status']
                   );
               }
               $this->response(array(
                   'total_results' => count($transaction_data),
                   'transaction_details' => $transaction_data
               ), REST_Controller::HTTP_OK);
           } else {
               $this->response(array(
                   'total_results' => 0,
                   'transaction_details' => array()
               ), REST_Controller::HTTP_OK);
           }
       } else {
           $this->response('Account ID is required', REST_Controller::HTTP_BAD_REQUEST);
       }
   }

}