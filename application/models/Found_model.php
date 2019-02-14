<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Found_model extends CI_Model {

    



/* End of file ModelName.php */

    public function count_found(){

        $query = $this->db->query('SELECT * FROM found_item');    
        return $query->num_rows();
    }
}



?>