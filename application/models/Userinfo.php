<?php

class Userinfo extends CI_Model {

    function getInfo($nik = null) {
    	if($nik == null){
	    	$this->db->where('nik', $this->session->userdata('nik'));   	
        }else{
        	$this->db->where('nik', $nik);
        }
        $query = $this->db->get('g_users');
        $row = $query->row();
        return $row;
    }

    function getLocInfo() {
        //Если пришел запрос на смену локации
        if ($this->input->post('loc')) {
            $this->session->set_userdata('loc', $this->input->post('loc'));
            $data = array(
                'location' => $this->input->post('loc')
            );
            $this->db->where('nik', $this->session->userdata('nik'));
            $this->db->update('g_users', $data);
        } else if (!$this->session->userdata('loc')) {
            //Если в сессии нету данных, получаем ее из БД
            //$this->load->model('userinfo');
            $row = $this->userinfo->getInfo();
            $this->session->set_userdata('loc', $row->location);
        }
        return $this->session->userdata('loc');
    }
	
	function updHp(){
		$nik = $this->session->userdata('nik');
		$this->db->where('nik', $nik);
        $query = $this->db->get('g_users');
        $row = $query->row();	
		
		$time=time();
			
		$hp = 	$row->hp_now;
		
		if($row->battleid==0){	
			if($hp<$row->hp_max){		
				if($time-$row->last_upd_hp>=10){
					$hp = ceil($row->hp_now + $row->hp_max/20); 
					
					if($hp>$row->hp_max){
						$hp=$row->hp_max;
					}
					
					$data = array(
						'hp_now' => $hp,
						'last_upd_hp' => time()
					);
					$this->db->where('nik', $nik);
					$this->db->update('g_users', $data);
				}
			}
			
			if($hp>$row->hp_max){
				$data = array(
						'hp_now' => $row->hp_max,
					);
				$this->db->where('nik', $nik);
				$this->db->update('g_users', $data);
			}
		}
		
		$hpPr = 100/$row->hp_max*$hp;


		
		return json_encode(array('hp' => $hp.'/'.$row->hp_max,'hpPr' => $hpPr, 'battle' => $row->battleid));
		
	}

}