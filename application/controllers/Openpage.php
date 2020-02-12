<?php

class Openpage extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
		
		$data['persinfo'] = $this->userinfo->getInfo();
		if($data['persinfo']->battleid>0){
			redirect('battle');
		}
    }

    function pers() {
    	redirect('pers');
    }
	
	function inv() {
		redirect('inv');
		
    }
	
	function loc() {
		/*$this->perslib->show_pers();
		$this->perslib->show_loc();*/
        redirect('loc');
    }

    function arena(){
    	$this->load->view('arena');
    }
    function battle(){
        redirect('battle');
    }
}