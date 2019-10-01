<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

// Load the Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class BarangayController extends REST_Controller {

    /**
     * Initialize/Load all configurations and models
     */
    public function __construct()
    {
        parent::__construct();
        //Load Barangay Model
        $this->load->model('barangay');
    }

    /**
     * All Available Barangay
     * HTTP Request Method: GET
     * No Fields or Params Required
     * URL Route: api/v1/barangay
     */
    public function all_barangay_get()
    {
        $barangay_rows = $this->barangay->get();
        for ($i = 0; $i < count($barangay_rows); $i++) {
            $data[$i] = array(
                'id' => (int)$barangay_rows[$i]['id'],
                'name' => ucwords(strtolower($barangay_rows[$i]['name'])),
                'address' => $barangay_rows[$i]['address'],
                'district_no' => (int)$barangay_rows[$i]['district_no'],
                'latitude' => $barangay_rows[$i]['latitude'],
                'longitude' => $barangay_rows[$i]['longitude']
            );
        }
        if ($barangay_rows) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response("No barangay", REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Barangay Data
     * HTTP Request Method: GET
     * Required Params: $id -> barangay id
     * URL Route: api/v1/barangay/{barangay_id}
     */
    public function barangay_get($id)
    {
        $barangay = $this->barangay->get(array('id' => $id));
        $data = array(
            'id' => (int)$barangay['id'],
            'name' => ucwords(strtolower($barangay['name'])),
            'address' => $barangay['address'],
            'district_no' => (int)$barangay['district_no'],
            'latitude' => $barangay['latitude'],
            'longitude' => $barangay['longitude']
        );

        if ($barangay) {
            $data['status'] = true;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response("No barangay", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}