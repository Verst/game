<?php

class Info extends CI_Controller {

    function __construct() {
        parent::__construct();        
    }

    public function login($login){
    	$data['login'] = urldecode($login);
    	$this->load->view('info',$data);    	
    }
}