<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller
{

    private $header;
    private $url;

    public function __construct()
    {
        parent::__construct();
        define("API_KEY", "AAAAm7UpDxU:APA91bGskkta6mEUO6g5wnugf2YZtuK96d1EujnahqUBEH2Ou_LdQsrFSI-VNJBw0dDaPMGN06UNkJ5p2fZDyYXl-2D40lEvsVBQSLJX_i8zJ4JBmWviFq6h118qwnS9EGpX7dsi3FtJ");

        $this->url = "https://fcm.googleapis.com/fcm/send";
        $this->header = array(
            'Content-Type:application/json',
            'Authorization:key=' . API_KEY
        );

    }

    public function send_notification($payloads)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloads));

        $result= curl_exec($ch);

        if ($result === FALSE) {
            die("Curl Failed" . curl_error($ch));
        }
         curl_close($ch);
         return $result;
    }

    public function email_verification()
    {
        $token = $this->input->get('token');
        $id = $this->input->get('id');

        if (isset($token, $id)) {
            //Verify Email
            $this->load->model('authentication_model');

            $result = $this->authentication_model->verify_email($id);
            $data = $this->authentication_model->get_email_verifications(array('id' => $id));


            if ($result) {
                echo "<h3 align='center'>" . $data['email'] . " is successfully verified!</h3>";
                //Send Notification to the mobile
                $payloads = array(
                    "to" => $token,
                    "notification" => array(
                        "title" => 'Email Verification',
                        "body" => $data['email'] . ' was successfully verified!',
                        "click_action" => "Email Verification"
                    ),
                    "data" => array(
                        'id' => $id,
                        'code' => $data['code'],
                        'email' => $data['email']
                    )
                );
                $this->send_notification($payloads); /* Send the notification */
            } else {
                echo "<h3 align='center'>Failed to verify your email. Please Try Again</h3>";
            }

        }

    }
}