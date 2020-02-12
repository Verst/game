<?php

class Inv_model extends CI_Model {

    function getShmot($userId) {	   
	   $query = $this->db->query('SELECT t.*, r.*, t.id AS gid FROM g_smot_pers t, g_shmot r WHERE  r.id=t.shmot_id AND t.odet=0 AND t.user_id='.$userId);	   
       $row = $query->result();
       return $row;
    }
	
	function getShmotInfo($id){
		/*$this->db->where('id', $id);
		$query = $this->db->get('g_smot_pers');
		$row = $query->row();
		return $row;*/
		
		
		
		$query = $this->db->query('SELECT t.*, r.*, t.id AS gid FROM g_smot_pers t, g_shmot r WHERE  r.id=t.shmot_id AND t.id='.$id);	   
		$row = $query->row();
		return $row;
	}
	
	function putOnIt($persInfo,$shmotInfo){
		$arr_shmot=explode(":", $persInfo->shmot);				
		
		
		if($shmotInfo->cat_id == 12){
			if($arr_shmot[12]==0){
				$arrI=12;
			}elseif($arr_shmot[13]==0){
				$arrI=13;
			}else{
				$arrI=14;
			}
		}else{
			$arrI = $shmotInfo->cat_id; 
		}
		
		if($arr_shmot[$arrI]==0){
			$arr_shmot[$arrI]=$shmotInfo->gid;
			$shmot = '';
			
			for($i=0;$i<count($arr_shmot);$i++){
				$shmot.=$arr_shmot[$i];
				if($i<count($arr_shmot)-1){
					$shmot.=':';
				}
			}
			
			$data = array(
				   'shmot' => $shmot,
				   'sila_shmot' => $persInfo->sila_shmot + $shmotInfo->sila_stat,
				   'lovk_shmot' => $persInfo->lovk_shmot + $shmotInfo->lovk_stat,
				   'inta_shmot' => $persInfo->inta_shmot + $shmotInfo->inta_stat,				   
				   'sv_hp' => $persInfo->sv_hp + $shmotInfo->hp,
				   'sv_vinos' => $persInfo->sv_vinos + $shmotInfo->vinos,
				   'damage_min' => $persInfo->damage_min + $shmotInfo->damage_min,
				   'damage_max' => $persInfo->damage_max + $shmotInfo->damage_max,
				   'head_armor' => $persInfo->head_armor + $shmotInfo->head_armor,
				   'body_armor' => $persInfo->body_armor + $shmotInfo->body_armor,
				   'armor_belt' => $persInfo->armor_belt + $shmotInfo->armor_belt,
				   'legs_armor' => $persInfo->legs_armor + $shmotInfo->legs_armor,
				   'crit' => $persInfo->crit + $shmotInfo->crit,
				   'anti_crit' => $persInfo->anti_crit+ $shmotInfo->anti_crit,
				   'yvorot' => $persInfo->yvorot + $shmotInfo->yvorot,
				   'anti_yvorot' => $persInfo->anti_yvorot + $shmotInfo->anti_yvorot,
				   'hp_max' => $persInfo->hp_max + $shmotInfo->hp
			);
			$this->db->where('id', $persInfo->id);
			$this->db->update('g_users', $data); 
			
			$data_pl = array(
				   'odet' => 1
			);
			$this->db->where('id', $shmotInfo->gid);
			$this->db->update('g_smot_pers', $data_pl); 
			
			echo json_encode(array('res' => 'yes'));
		}else{
			echo json_encode(array('res' => 'no'));
		}
	}
	
	
	function putOnShmot($id){		
		$query = $this->db->query('SELECT t.*, r.*, t.id AS gid FROM g_smot_pers t, g_shmot r WHERE  r.id=t.shmot_id AND t.odet=1 AND t.user_id='.$id);	   
		$row = $query->result();
		return $row;
	}
	
	function removeItem($persInfo,$shmotInfo){
		$arr_shmot=explode(":", $persInfo->shmot);
		
		if($shmotInfo->cat_id == 12){
			if($arr_shmot[12]==$shmotInfo->gid){
				$arrI=12;
			}elseif($arr_shmot[13]==$shmotInfo->gid){ 
				$arrI=13;
			}elseif($arr_shmot[14]==$shmotInfo->gid){
				$arrI=14;
			}
			
		}else{
			$arrI = $shmotInfo->cat_id; 
		}
		
		if($arr_shmot[$arrI]==$shmotInfo->gid){
			$arr_shmot[$arrI]=0;
			$shmot = '';
			
			for($i=0;$i<count($arr_shmot);$i++){
				$shmot.=$arr_shmot[$i];
				if($i<count($arr_shmot)-1){
					$shmot.=':';
				}
			}
			//$mm = $persInfo->hp_max - $shmotInfo->hp;
			if($persInfo->hp_max - $shmotInfo->hp < $persInfo->hp_now){
				$tt=$persInfo->hp_max - $shmotInfo->hp;
			}else{
				$tt=$persInfo->hp_now;
			}

			
			
			$data = array(
				   'shmot' => $shmot,
				   'sila_shmot' => $persInfo->sila_shmot - $shmotInfo->sila_stat,
				   'lovk_shmot' => $persInfo->lovk_shmot - $shmotInfo->lovk_stat,
				   'inta_shmot' => $persInfo->inta_shmot - $shmotInfo->inta_stat,				   
				   'sv_hp' => $persInfo->sv_hp - $shmotInfo->hp,
				   'sv_vinos' => $persInfo->sv_vinos - $shmotInfo->vinos,
				   'damage_min' => $persInfo->damage_min - $shmotInfo->damage_min,
				   'damage_max' => $persInfo->damage_max - $shmotInfo->damage_max,
				   'head_armor' => $persInfo->head_armor - $shmotInfo->head_armor,
				   'body_armor' => $persInfo->body_armor - $shmotInfo->body_armor,
				   'armor_belt' => $persInfo->armor_belt - $shmotInfo->armor_belt,
				   'legs_armor' => $persInfo->legs_armor - $shmotInfo->legs_armor,
				   'crit' => $persInfo->crit - $shmotInfo->crit,
				   'anti_crit' => $persInfo->anti_crit - $shmotInfo->anti_crit,
				   'yvorot' => $persInfo->yvorot - $shmotInfo->yvorot,
				   'anti_yvorot' => $persInfo->anti_yvorot - $shmotInfo->anti_yvorot,
				   'hp_max' => $persInfo->hp_max - $shmotInfo->hp,
				   'hp_now' => $tt
			);
			$this->db->where('id', $persInfo->id);
			$this->db->update('g_users', $data); 
			
			$data_pl = array(
				   'odet' => 0
			);
			$this->db->where('id', $shmotInfo->gid);
			$this->db->update('g_smot_pers', $data_pl); 
			
			echo json_encode(array('res' => 'yes'));
		}else{
			echo json_encode(array('res' => 'no'));
		}
	
	}


	function updateParam($data,$id){
		$this->db->where('id', $id);
		$this->db->update('g_users',$data);
	}
}