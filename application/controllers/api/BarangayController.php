<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class BarangayController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('barangay');
    }

    public function index_get()
    {
        $id = $this->get('id');


        if (isset($id)) {
            //TODO retrieve barangay info by ID
        } else {
            $barangay_info = $this->barangay->get();
            $barangay_size = $this->barangay->get(array('returnType' => 'count'));
            for ($i = 0; $i < $barangay_size; $i++) {
                $data['barangay'][$i] = array(
                    'id' => (int)$barangay_info[$i]['id'],
                    'name' => ucwords(strtolower($barangay_info[$i]['name'])),
                    'address' => $barangay_info[$i]['address'],
                    'district_no' => (int)$barangay_info[$i]['district_no'],
                    'latitude' => $barangay_info[$i]['latitude'],
                    'longitude' => $barangay_info[$i]['longitude']
                );
            }

            $data['total'] = $barangay_size;

        }

        if ($barangay_info) {
            $data['status'] = true;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response("No barangay", REST_Controller::HTTP_BAD_REQUEST);
        }

    }
}
/* End of file BarangayController.php */