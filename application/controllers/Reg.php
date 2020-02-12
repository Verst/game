<?php

class Reg extends CI_Controller {

    function index() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nik', 'Логин', 'trim|required|callback_nik_check');
        $this->form_validation->set_rules('pass', 'Пароль', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('passconf', 'Повторите пароль', 'trim|required|min_length[4]|max_length[32]|matches[pass]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('sex', 'E-mail', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('reg/regform');
        } else { 
            $this->load->model('reg_model');
            if ($this->reg_model->add_user()) {
                $this->session->set_userdata('nik', $this->input->post('nik'));
                $this->session->set_userdata('loc', 1);
                $this->load->view('reg/regsuccess');
            }
        }
    }

    function ajax_chek(){
        $this->load->model('reg_model');
        if ($this->reg_model->nik_chek('nik', $this->input->post('nik'))) {
            echo 'Логин свободен';
        } else {
            echo 'Такой Логин уже есть в игре';
        }
    }

    function nik_check($str) {
        $this->load->model('reg_model');
        if ($this->reg_model->nik_chek('nik', $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('nik_check', 'Такой Логин уже есть в игре');
            return FALSE;
        }
    }

    function email_check($str) {
        $this->load->model('reg_model');
        if ($this->reg_model->nik_chek('email', $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', 'Такой E-mail уже есть в базе');
            return FALSE;
        }
    }

}