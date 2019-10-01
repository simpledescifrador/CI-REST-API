<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reported_lost extends CI_Controller {


    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('lost_item');
        $this->load->helper('url_helper');
        $this->load->model('item');
    }

    public function index(){

        $data['lost_item'] = $this->lost_item->view_lost();
        $data['lost_pets'] = $this->lost_item->lost_pets();
        $data['lost_person'] = $this->lost_item->lost_person();

        $data['page_title'] = 'Maka-Hanap Admin | Lost Items';

        if(isset($this->session->userdata['logged_in']))
		{	
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/lost_items', $data);
            $this->load->view('templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}
    }
    public function lost_details(){

        if(isset($this->session->userdata['logged_in'])){
            $item_type = $this->input->get('type');
            $item_id = $this->input->get('token');
            $data['report_type'] = $this->item->get_specific_item($item_id);

            // START nav
            $data['lost_nav'] = 'active';
            $data['found_nav'] = '';
            $data['matched_nav'] = '';
            $data['returned_nav'] = '';
            // END nav

            //START breadcrumbs
            $data['recent_page'] = '<a class="blue" href="javascript:history.back()">Lost</a>';
            //END breadcrumbs

            $data['item_image'] = $this->item->get_item_images($item_id);
            $data['lost_item_details'] = $this->lost_item->lost_details($item_id);
            $data['lost_pet_details'] = $this->lost_item->lost_pet_details($item_id);
            $data['lost_person_details'] = $this->lost_item->lost_person_details($item_id);
            $data['item_type'] = 'Lost';
            $this->load->view('templates/header');
            $this->load->view('pages/item_details', $data);
            $this->load->view('templates/footer');
        }
        else{
            redirect('/','refresh');
        }
    }
    
}