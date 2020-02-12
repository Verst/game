<?php

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
    }

    function index() {
        $data['persinfo'] = $this->userinfo->getInfo();
		$data['persinfo']->hpP=100/$data['persinfo']->hp_max*$data['persinfo']->hp_now; 
        $this->load->view('main',$data);
    }
	
	function updHp(){
		echo $this->userinfo->updHp();
	}

}