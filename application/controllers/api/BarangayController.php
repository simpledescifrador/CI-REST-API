<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class BarangayController extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('barangay');
    }

    public function index_get()
	{
	    $id = $this->get('id');


	}

}
/* End of file BarangayController.php */