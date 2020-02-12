<?php

class Shop extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
        if ($this->session->userdata('loc')!=7) {
        	die();
        }

        $this->load->model('shop_model');
    }

    function index(){
    	if($this->input->post('cat')){
    		$cat = $this->input->post('cat');
    	}else{
    		$cat = 'helm';
    	}
    	$data['shmot'] = $this->shop_model->getRazdel($cat);
    	$data['persinfo'] = $this->userinfo->getInfo();
    	$this->load->view('shop',$data);
    }

    function buyShmot(){
    	if($this->input->post('id')){
    		$id = $this->input->post('id');
    		$shmotka = $this->shop_model->getSmotka($id);    
    		$persinfo = $this->userinfo->getInfo();	
			
			if($persinfo->money>=$shmotka->price){
		    	$data = array(
		            'shmot_id' => $id,
		            'user_id' => $this->session->userdata('user_id'),
					'dolg_min' => 0,
					'dolg_max' => $shmotka->dolgovehnost,
					'odet' => 0
		        );
		       $this->shop_model->buyShmotka($data);

		       $dataPers = array('money' => $persinfo->money-$shmotka->price);
		       $this->shop_model->updPers($persinfo->id,$dataPers);
		       redirect('shop');
		    }else{
		    	echo 'err1';
		    }
	        
    	}
    }
}
?>