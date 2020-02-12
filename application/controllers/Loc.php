<?php

class Loc extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
        $this->load->model('loc_model');
    }

    function index(){
        if($this->session->userdata('loc')==7){
            redirect('shop');
        }
    	 $this->load->view('pers/loc');
    }

    function changeLoc(){
        $loc = $this->input->post('loc');
        $this->session->set_userdata('loc', $loc);
        $this->loc_model->changeLoc($loc);
        redirect('loc');
    }
}
?>