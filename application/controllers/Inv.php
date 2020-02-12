<?php

class Inv extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
		
		$data['persinfo'] = $this->userinfo->getInfo();
		if($data['persinfo']->battleid>0){
			redirect('battle/bot');
		}
    }

    function index() {
    	$this->perslib->show_pers();
    	$this->perslib->show_modif();
    	$this->perslib->show_shmot();		
    }
	
	function putOn(){
		$id = $this->input->post('id');
		
		$this->load->model('inv_model');
		$shmotInfo = $this->inv_model->getShmotInfo($id);
		
		$data['persinfo'] = $this->userinfo->getInfo();
		
		if($data['persinfo']->id==$shmotInfo->user_id){
			return $this->inv_model->putOnIt($data['persinfo'],$shmotInfo);
		}
	}
	
	function removeItem(){
		$id = $this->input->post('id');
		
		$this->load->model('inv_model');
		$shmotInfo = $this->inv_model->getShmotInfo($id);
		$data['persinfo'] = $this->userinfo->getInfo();
		
		if($data['persinfo']->id==$shmotInfo->user_id){
			return $this->inv_model->removeItem($data['persinfo'],$shmotInfo);
		}
	}

	function paramAdd(){
		$param = $this->input->post('param');
		$data['persinfo'] = $this->userinfo->getInfo();

		if($data['persinfo']->free_params > 0){
			switch ($param) {
				case 'sila':
					$params['sila'] = $data['persinfo']->sila + 1;
					break;	
				case 'lovk':
					$params['lovk'] = $data['persinfo']->lovk + 1;
					break;
				case 'inta':
					$params['inta'] = $data['persinfo']->inta + 1;
					break;
				case 'vinos':
					$params['vinos'] = $data['persinfo']->vinos + 1;
					$params['hp_max'] = $data['persinfo']->hp_max + 30;
					break;						
			}
			$params['free_params'] = $data['persinfo']->free_params-1;

			$this->inv_model->updateParam($params,$data['persinfo']->id);
			redirect('pers');
		}		
	}

}