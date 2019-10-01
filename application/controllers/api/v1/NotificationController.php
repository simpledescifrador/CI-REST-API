<?php

use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class NotificationController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('account');
        $this->load->model('notification_model');
        $this->load->model('transaction_model');
        $this->load->model('item');

    }

    public function load_notifications_get()
    {
        $account_id = $this->get('account_id');
        $notifications = array();
        if (isset($account_id)) {
            $result = $this->notification_model->get(array(
                'conditions' => array(
                    'account_id' => $account_id
                )
            ));
            $result_count = $this->notification_model->get(array(
                'returnType' => 'count',
                'conditions' => array(
                    'account_id' => $account_id
                )));
            /* Pass the result into notifications array */
            for ($i=0; $i < $result_count; $i++) {
                $transaction_id = $result[$i]['transaction_id'];

                if ($transaction_id != null) {
                    $mcon['returnType'] = 'single';
                    $mcon['conditions'] = array(
                        'transaction_id' => $transaction_id
                    );
                    $transaction_data = $this->transaction_model->get_transaction_confirmed(array('id' => $transaction_id));
                    $meetup_data = $this->transaction_model->get_transaction_meetup($mcon);
                    $item_data = $this->item->get(array('id' => $transaction_data['item_id']));
                    $account_data = $this->account->get(array('id' => $item_data['account_id']));
                    $notifications[$i] = array(
                        'id' => (int) $result[$i]['id'],
                        'title' => ucfirst($result[$i]['title']),
                        'content' => ucfirst($result[$i]['content']),
                        'image_url' => $result[$i]['image_url'],
                        'created_at' => $result[$i]['created_at'],
                        'viewed' => (bool) ($result[$i]['is_read'] == "Yes")? true : false,
                        'type' => $result[$i]['type'],
                        'ref_id' => (int) $result[$i]['ref_id'],
                        'meetup_id' => (int) $meetup_data['id'],
                        'item_id' => (int) $transaction_data['item_id'],
                        'sender_id' => (int) $account_data['id'],
                        'sender_name' => $account_data['first_name'] . ' ' . $account_data['last_name'],
                        'sender_image' => $account_data['image']
                    );
                } else {
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
}