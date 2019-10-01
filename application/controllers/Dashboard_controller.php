<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard_controller extends CI_Controller{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('login_model');
        $this->load->model('item');
        $this->load->model('user');
        $this->load->model('lost_item');
        $this->load->model('found_item');
        $this->load->model('transaction_model');
        date_default_timezone_set('Asia/Manila');
    }


    public function home(){
        if(isset($this->session->userdata['logged_in']))
		{

            //display lost graph data
            $lost = array();
            $found = array();
            for ($i=0; $i < 10 ; $i++) { 
                $date = Date('Y-m-d', strtotime("-". $i ." days"));

                $lost_count = $this->item->lost_graph_data($date);
                $found_count = $this->item->found_graph_data($date);

                $lost[] = array(
                        't' => $date,
                        'y' => $lost_count
                );
                $found[] = array(
                        't' => $date,
                        'y' => $found_count
                );
            }
            $data['lost_graph_data'] = json_encode($lost);
            $data['found_graph_data'] = json_encode($found);

            // Pie Chart Data
            $data['dnnt_petCounts'] = $this->item->count_pets();
            $data['dnnt_personCounts'] = $this->item->count_persons();
            $data['dnnt_personalThingCounts'] = $this->item->count_personal_items();
            // END Pie Chart Data


            $data['page_title'] = 'Maka-Hanap | Admin Dashboard';
            $data['get_items'] = $this->item->get_items();
            $data['alert_message'] = $this->session->flashdata('alert_message');
            $data['alert_type'] = $this->session->flashdata('alert_type');

            $data['active_users'] = $this->user->getActiveUsers();
            $data['reported_users'] = $this->user->getReportedUsers();
            $data['blocked_users'] = $this->user->getBlockedUsers();
            $data['recent_transactions_items'] = $this->transaction_model->recent_transactions_items();
            $data['recent_transactions_pets'] = $this->transaction_model->recent_transactions_pets();
            $data['recent_transactions_persons'] = $this->transaction_model->recent_transactions_persons();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/dashboard',$data);
            $this->load->view('modals/add_brgy_account');
            $this->load->view('templates/footer');
		}
		else
		{

            redirect('/','refresh');

		}
    }

    public function dashboard_data(){
        $data['lost_count'] = $this->item->count_lost();
        $data['found_count'] = $this->item->count_found();
        $data['returned_count'] = $this->item->count_returned();
        $data['cound_matched'] = $this->item->count_matched();
        echo json_encode($data);
    }

    public function newBrgyUser(){
        #initialize everything--------------------------------------------------------------------
        $config['upload_path'] = 'uploads/barangay/profile';
        $config['allowed_types'] = 'jpg|png|svg|bmp';


        $this->load->library('upload',$config);
        $this->upload->do_upload('file_name');
        $file_name =$this->upload->data();

        $datetime = date("Y-m-d") ." ".date('H:i:sa');
        $fname = $this->input->post('f_name');
        $mname = $this->input->post('m_name');
        $lname = $this->input->post('l_name');
        $email = $this->input->post('email');
        $assign = $this->input->post('assign');
        $job = $this->input->post('job_title');
        $address = $this->input->post('address');

        $name = $fname . " " . $lname;
        $username = strtolower($fname.".".$lname."@makahanap");
        $password = strtolower(substr($fname, 0,3)) . strtolower(substr($lname, 0,3)) .rand(1000,9999);
        #--------------------------------------------------------------------------------------------

        $data = array(
            'name' =>  $name,
            'username' => str_replace(' ', '', $username),
            'password' => str_replace(' ', '',$password),
            'type' => 2,
            'brgy_id' => $assign
        );
        $test_reg = $this->user->test_register($data);
        if ($test_reg == 0) {
            $this->user->insertBrgyUser($data);
            $data =array(
                'name'=> $name,
                'username'=> str_replace(' ', '', $username)
            );
            $reg_id = $this->user->getB_id($data);

            foreach ($reg_id as $row) {
                $account_id = $row['id'];
            }
            $data =array(
                'barangay_id' => $assign,
                'first_name' => $fname,
                'middle_name' => $mname,
                'last_name' => $lname,
                'email' => $email,
                'job' => $job,
                'address' => $address,
                'image' => $file_name['file_name'],
                'date_created' => $datetime
            );
            $this->user->insertB_User($data);
            $data = array(
                'brgy_account_id'=>$account_id,
                'email'=>$email
                );
            $this->user->updateB_id($data);

            $this->load->library('email'/*, $mail_config*/);
            $this->email->set_newline("\r\n"); 
            $this->email->from('makahana@makahanap.x10host.com', 'MakaHanap Makati City');
            $this->email->to($email);
            $this->email->subject('MakaHanap Account Details');
            $this->email->message('Hi, this is an auto generated message. See the details below,'.'
             
             Username: '.str_replace(' ', '', $username).' 
             Password: '.str_replace(' ', '', $password).'

NOTICE: Do not share your account username and/or password to other people. You must be the only user that can access your account, therefore it is recommended to change your account password immediately');
            if ($this->email->send()) {
                $alert_message = "New barangay account was added. Account details wast sent to the client's email.";
                $alert_type = 'alert-success';
                $data['details'] = "Username = ". str_replace(' ', '', $username) . " Password = ".str_replace(' ', '',$password);
                $this->session->set_flashdata('alert_message', $alert_message);
                $this->session->set_flashdata('alert_type', $alert_type);
                redirect('brgy_account','refresh'); 
            }
            else{
                $alert_message = 'Please provide an existing email address.';
                $alert_type = 'alert-danger';

                redirect('brgy_account','refresh'); 
            }
            
            
        }
        else{
            $alert_message = 'Opps, this account already exists.';
            $alert_type = 'alert-warning';
            $this->session->set_flashdata('alert_message', $alert_message);
            $this->session->set_flashdata('alert_type', $alert_type);
            redirect('brgy_account','refresh');
        }
        
    }
}
