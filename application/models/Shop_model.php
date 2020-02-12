<?php

class Shop_model extends CI_Model {

	function getRazdel($name){
		$this->db->where('cat', $name);
		$this->db->order_by("lvl", "asc");
		$query = $this->db->get('g_shmot');
		$row = $query->result();
       	return $row;
	}


	function getSmotka($id){
		$this->db->where('id', $id);		
		$query = $this->db->get('g_shmot');
		return $query->row();
	}

	function buyShmotka($data){
		$this->db->insert('g_smot_pers', $data);
	}

	function updPers($plid,$data_pl){
		$this->db->where('id', $plid);
		$this->db->update('g_users', $data_pl); 
	}
}?>