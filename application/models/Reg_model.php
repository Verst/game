<?php

class Reg_model extends CI_Model {

    function nik_chek($param, $str) {
        $this->db->where($param, $str);
        $query = $this->db->get('g_users');
        if ($query->num_rows == 0) {
            return true;
        }
    }

    function add_user() {
        $insert_data = array(
            'nik' => $this->input->post('nik'),
            'pass' => md5($this->input->post('pass')),
            'email' => $this->input->post('email'),
            'sex' => $this->input->post('sex'),
            'timereg' => time()
        );
        $insert = $this->db->insert('g_users', $insert_data);
        return $insert;
    }

    function validation(){
        $this->db->where('nik', $this->input->post('nik'));
        $this->db->where('pass', md5($this->input->post('pass')));
        $query = $this->db->get('g_users');
        if ($query->num_rows() == 1) {            
            return true;
        }
    }

}