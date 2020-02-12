<?php
class Indp extends CI_Controller{

    function index(){
		$this->db->where('in_game', 1);
        $query = $this->db->get('g_users');
		$data['online'] = $query->num_rows();
        $this->load->view('indp',$data);
    }

}