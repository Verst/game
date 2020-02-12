<?
class Loc_model extends CI_Model {


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

    function changeLoc($loc){
    	$data = array(
                'location' => $loc
            );
        $this->db->where('nik', $this->session->userdata('nik'));
        $this->db->update('g_users', $data);
    }
}