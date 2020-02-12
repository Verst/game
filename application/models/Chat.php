<?php
class Chat extends CI_Model {

    function getObshChat(){
         //Определяем фильтр на выборку
        if (!$this->session->userdata('upd')) {
            //Если игрок только вошел в игру
            $this->db->limit(5);
        } else if ($this->uri->segment(3) == 'chloc') {
            //Если запрос на смену локи,
            //выбираем 5 посл. сообщений этой локи
            $this->db->limit(5);
        } else {
            //Иначе выбираем с последнего
            //запомненного ID сообщения
            $this->db->where('id >=', $this->session->userdata('upd'));
        }

        //Отправляем запрос к БД на выборку сообщений
        $this->db->order_by("id", "desc");
        // $this->db->where("loc", $loc);
        //$this->db->or_where($this->db->like('mess','%private [%'));

        if ($chatindc == 0) {
            $where = "(loc = '" . $loc . "' OR mess LIKE '%private [%')";
            $this->db->where($where);
        } else {
            $this->db->where("loc", $loc);
        }

       return $this->db->get('g_chat');
        
        // $query->result();
    }

}