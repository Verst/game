<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perslib {

	protected $CI;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model('inv_model');
	}

	public function show_pers($nik=null)
	{
		$data['persinfo'] = $this->CI->userinfo->getInfo($nik);
		$data['persinfo']->hpP=100/$data['persinfo']->hp_max*$data['persinfo']->hp_now;	
		
		
		$arr=$this->CI->inv_model->putOnShmot($data['persinfo']->id);
		
		$arr_shmot=explode(":", $data['persinfo']->shmot);
		
		$shmot_arr = array();
		for($i=0;$i<count($arr_shmot);$i++){			
			for($n=0;$n<count($arr);$n++){
				if($arr_shmot[$i] == $arr[$n]->gid){					
					$shmot_arr[$i+1] = $arr[$n];
				}
			}
		}
		
		$data['putOnShmot']=$shmot_arr;
		
		$this->CI->load->view('pers/inv', $data);
	}

	public function show_shmot()
	{
		$data['persinfo'] = $this->CI->userinfo->getInfo();
		$data['shmot']=$this->CI->inv_model->getShmot($data['persinfo']->id);
		$this->CI->load->view('pers/shmot', $data);
	}

	public function show_modif($nik=null,$info=null)
	{
		$data['persinfo'] = $this->CI->userinfo->getInfo($nik);
		$data['show_full'] = $info;
		$this->CI->load->view('pers/modif', $data);
	}

	public function show_loc()
	{		
		$this->CI->load->view('pers/loc');
	}
}