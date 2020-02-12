<?php

class Enter extends CI_Controller {

    function login() {
        $this->output->enable_profiler(TRUE);
        $this->load->library('form_validation');
        // if (!$this->session->userdata('nik')) {
        $this->form_validation->set_rules('nik', 'Логин', 'trim|required');
        $this->form_validation->set_rules('pass', 'Пароль', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('myform1');
        } else {
            $this->load->model('reg_model');
            if ($this->reg_model->validation()) {
                $this->load->model('userinfo');
                
                $row = $this->userinfo->getInfo($this->input->post('nik'));

                $this->session->set_userdata('nik', $row->nik);
                $this->session->set_userdata('user_id', $row->id);
                $this->session->set_userdata('loc', $row->location);
                redirect('main');
            } else {
                $this->load->view('myform2');
            }
        }
        /* } else {
          redirect('');
          } */
    }

    function logout() {
        $data_up = array(
            'in_game' => 0
        );

        $this->db->where('nik', $this->session->userdata('nik'));
        $this->db->update('g_users', $data_up);

        $this->session->sess_destroy();
        redirect('indp');
    }

}