<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reported_found extends CI_Controller {


    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('found_item');
        $this->load->model('item');
    }

    public function index(){
        $data['page_title'] = 'Maka-Hanap | Admin Dashboard/Found Items';

        if(isset($this->session->userdata['logged_in']))
		{	

            $data['found_item'] = $this->found_item->view_foundItems();
            $data['found_person'] = $this->found_item->found_person();
            $data['found_pet'] = $this->found_item->found_pet();
            
            $this->load->view('templates/header', $data);
            $this->load->view('pages/found_items',$data);
            $this->load->view('templates/footer');
		}
		else
		{
            
            redirect('/','refresh');
        
		}
    }
    public function found_details(){

        if(isset($this->session->userdata['logged_in'])){
            $item_id = $this->input->get('token');
            $data['page_title'] = "Maka-Hanap Admin | Item Details";
            $data['report_type'] = $this->item->get_specific_item($item_id);

            //START making an active nav
            $data['lost_nav'] = '';
            $data['found_nav'] = 'active';
            $data['matched_nav'] = '';
            $data['returned_nav'] = '';
            //END making an active nav

            //START breadcrumbs
            $data['recent_page'] = '<a class="blue" href="javascript:history.back()">Found</a>';
            //END breadcrumbs
            

            $data['item_type'] = 'Found';
            $data['item_image'] = $this->item->get_item_images($item_id);
            $data['found_item_details'] = $this->found_item->view_fdetails($item_id);
            $data['found_person_details'] = $this->found_item->foundPerson_details($item_id);
            $data['found_pet_details'] = $this->found_item->foundPet_details($item_id);
            
            $this->load->view('templates/header',$data);
            $this->load->view('pages/item_details', $data);
            $this->load->view('templates/footer');
        }
        else{
            redirect('/','refresh');
        }
    }
    
}