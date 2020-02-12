<?php

class Chat extends CI_Controller {

    function chekto($nik, $str, $send) {
        $nik = strtoupper($nik);
        $str = strtoupper($str);
        $send = strtoupper($send);
        $piv = strtoupper('to [' . $nik . ']');

        if ($send == $nik) {
            return true;
        } elseif (strpos($str, $piv) > -1) {
            return true;
        } else {
            return false;
        }
    }

    function chekpriv($nik, $str, $send) {
        $nik = strtoupper($nik);
        $str = strtoupper($str);
        $send = strtoupper($send);
        $piv = strtoupper('private [' . $nik . ']');

        if ($send == $nik) {
            return true;
        } elseif (strpos($str, $piv) > -1) {
            return true;
        } else {
            return false;   
        }
    }

    ///^PRIVATE +\[(.*)\] +(.*)$/i

    function chek_onl_priv($str) {
        $str = strtoupper($str);
        $priv = strtoupper('private');

        if (preg_match("/^PRIVATE +\[(.*)\]/", $str, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    function chek_onl_to($str) {
        $str = strtoupper($str);
        $priv = strtoupper('to');

        if (preg_match("/^TO +\[(.*)\]/", $str, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    function send() {
        $text = $this->input->post('text');
        $chatind = $this->input->post('chatind');
        $text = trim($text);
        $nik = $this->session->userdata('nik');

        if ($text != '') {
            //Общий чат
            if (($chatind == 0 || $this->chek_onl_to($text) == true) && $this->chek_onl_priv($text) == false) {
                $data = array(
                    'time' => time(),
                    'nik' => $nik,
                    'mess' => $text,
                    'loc' => $this->session->userdata('loc')
                );

                $this->db->insert('g_chat', $data);
            }elseif($this->chek_onl_priv($text) == true){
                $data = array(
                    'time' => time(),
                    'nik' => $nik,
                    'mess' => $text
                );

                $this->db->insert('g_chat_privat', $data);
            } elseif ($chatind == 1) {
                //Торговый
                $data = array(
                    'time' => time(),
                    'nik' => $nik,
                    'mess' => $text
                );

                $this->db->insert('g_chat_torg', $data);
            }
        }
    }

    function update() {
        //$this->output->enable_profiler(TRUE);
        $nik = $this->session->userdata('nik');
        $chatindc = $this->input->post('chatindc');
        $pChgLoc = $this->input->post('pChgLoc');
         $sound = -1;

        //Получаем в какой локе перс

        //$loc = $this->userinfo->getLocInfo();
         $loc = $this->session->userdata('loc');

        //Определяем фильтр на выборку
        if (!$this->session->userdata('upd')) {
            //Если игрок только вошел в игру
            $this->db->limit(5);
        } else if ($pChgLoc==1) {
            //Если запрос на смену локи,
            //выбираем 5 посл. сообщений этой локи
            $this->db->limit(5);
            //$where = "(loc = '" . $loc . "')";
        } else {
            //Иначе выбираем с последнего
            //запомненного ID сообщения
            $this->db->where('id >=', $this->session->userdata('upd'));
            
        }

        //Отправляем запрос к БД на выборку сообщений
        $this->db->order_by("id", "desc");
        // $this->db->where("loc", $loc);
        //$this->db->or_where($this->db->like('mess','%private [%'));

        /*if ($chatindc == 0) {*/
            

            //$where = "(loc = '" . $loc . "' OR mess LIKE '%private [%')";
            $where = "(loc = '" . $loc . "')";
            $this->db->where($where);
        /*} else {
            $this->db->where("loc", $loc);
        }*/

        $query = $this->db->get('g_chat');
        $sess = $this->session->userdata('upd');
       
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();

            $rows_n = array_reverse($rows);
            $data = '';
            /*
            $data_priv = '';*/
            foreach ($rows_n as $row) {



                /*if ($this->chek_onl_priv($row['mess'])) {

                    if ($this->chekpriv($nik, $row['mess'], $row['nik'])) {

                        $messcont = $row['mess'];
                        $mess = '';

                        do {
                            $pos1 = mb_strpos($messcont, "private [") + 9;
                            $pos12 = mb_strpos($messcont, "]", $pos1);
                            $nikchat = mb_substr($messcont, $pos1, $pos12 - $pos1);

                            $mess.="<a class=\"nonea\" onclick=\"send('" . $nikchat . "', 'priv');\"><b>private [" . $nikchat . "]</b></a> ";

                            $messcont = mb_substr($messcont, $pos12 + 1);
                        } while (mb_strpos($messcont, "private [") > -1);
                        $mess.=$messcont;


                        $data_priv.="<div class=\"msglnpriv\">" . date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'priv');\">" . $row['nik'] . "</a></b>: " . $mess . "</div>";
                        unset($mess, $messcont);

                        if($row['nik'] != $nik){
                            $json_data['sound-4'] = 1;
                        }
                    }
                }*//* elseif ($row['act'] != 0) {

                  if ($row['act'] == 1) {
                  $nikdat = " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "');\">" . $row['nik'] . "</a></b> вошел в чат";
                  } elseif ($row['act'] == 2) {
                  $nikdat = " <b>" . $row['nik'] . "</b> вышел из чата";
                  }

                  $data.='<div class=\"msgln\"><i>' . date("H:i:s", $row['time']) . $nikdat . "</i></div>";
                  } else*/ if ($this->chek_onl_to($row['mess'])) {
                    //Если в сообщение есть личное сообщение
                    if ($this->chekto($nik, $row['mess'], $row['nik'])) {
                        $data.="<div class=\"msglnto\">";
                        if($row['nik'] != $nik){
                            $json_data['sound-0'] = 1;
                        }
                    } else {
                        $data.="<div class=\"msgln\">";
                    }

                    $messcont = $row['mess'];
                    $mess = '';

                    do {
                        $pos1 = mb_strpos($messcont, "to [") + 4;
                        $pos12 = mb_strpos($messcont, "]", $pos1);
                        $nikchat = mb_substr($messcont, $pos1, $pos12 - $pos1);

                        $mess.="<a class=\"nonea\" onclick=\"send('" . $nikchat . "', 'to');\"><b>to [" . $nikchat . "]</b></a> ";

                        $messcont = mb_substr($messcont, $pos12 + 1);
                    } while (mb_strpos($messcont, "private [") > -1);
                    $mess.=$messcont;

                    $data.=date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'to');\">" . $row['nik'] . "</a></b>: " . $mess . "</div>";
                    unset($mess, $messcont);
                    
                } else {
                    //Остальные сообщения
                    if ($row['nik'] == $nik) {
                        $data.="<div class=\"msglnm\">";
                    } else {
                        $data.="<div class=\"msgln\">";
                    }
                    $data.=date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'to');\">" . $row['nik'] . "</a></b>: " . $row['mess'] . "</div>";
                }
            }
            //echo $data;
            $json_data['tabs-0'] = $data;
           

        }

        $this->db->select('id');
        $this->db->limit(1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get('g_chat');
        $row = $query->row();
        $upd = $row->id + 1;
        $this->session->set_userdata('upd', $upd);

        //------------Торговый чат-----------
        $upd_torg = $this->session->userdata('upd_torg');

       /* if ($chatindc == 1) {
            $query = $this->db->query("(SELECT id, nik, mess, time FROM g_chat_torg WHERE id >=" . $upd_torg . ") UNION ALL (SELECT id, nik, mess, time FROM g_chat WHERE id >=" . $sess . " AND (nik='" . $nik . "' OR mess LIKE '%private [" . $nik . "]%') ) ORDER BY id");
        } else {*/
            if (!$this->session->userdata('upd_torg')) {
                //Если игрок только вошел в игру
                $this->db->limit(5);
            } else {
                //Иначе выбираем с последнего
                //запомненного ID сообщения
                $this->db->where('id >=', $this->session->userdata('upd_torg'));
            }
            $this->db->order_by("id", "desc");
            $query = $this->db->get('g_chat_torg');
        /*}*/
        if ($query->num_rows() > 0) {

            $rows1 = $query->result_array();
            $rows_nt = array_reverse($rows1);

            $data_torg = '';
            $data_torg_priv = '';
            foreach ($rows_nt as $row) {

                /*if ($this->chek_onl_priv($row['mess']) == true) {
                    //Если в сообщении есть приват
                    if ($this->chekpriv($nik, $row['mess'], $row['nik'])) {

                        $messcont = $row['mess'];
                        $mess = '';

                        do {
                            $pos1 = mb_strpos($messcont, "private [") + 9;
                            $pos12 = mb_strpos($messcont, "]", $pos1);
                            $nikchat = mb_substr($messcont, $pos1, $pos12 - $pos1);

                            $mess.="<a class=\"nonea\" onclick=\"send('" . $nikchat . "', 'priv');\"><b>private [" . $nikchat . "]</b></a> ";

                            $messcont = mb_substr($messcont, $pos12 + 1);
                        } while (mb_strpos($messcont, "private [") > -1);
                        $mess.=$messcont;


                        $data_torg_priv.="<div class=\"msglnpriv\">" . date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'priv');\">" . $row['nik'] . "</a></b>: " . $mess . "</div>";
                        unset($mess, $messcont);
                        if($row['nik'] != $nik){
                            $sound = 1;
                        }
                    }
                } else {*/

                if ($this->chek_onl_to($row['mess'])) {
                    //Если в сообщение есть личное сообщение
                    if ($this->chekto($nik, $row['mess'], $row['nik'])) {
                       $data_torg.="<div class=\"msglnto\">";
                        if($row['nik'] != $nik){
                            $json_data['sound-1'] = 1;
                        }
                    } else {
                        $data_torg.="<div class=\"msgln\">";
                    }

                    $messcont = $row['mess'];
                    $mess = '';

                    do {
                        $pos1 = mb_strpos($messcont, "to [") + 4;
                        $pos12 = mb_strpos($messcont, "]", $pos1);
                        $nikchat = mb_substr($messcont, $pos1, $pos12 - $pos1);

                        $mess.="<a class=\"nonea\" onclick=\"send('" . $nikchat . "', 'to');\"><b>to [" . $nikchat . "]</b></a> ";

                        $messcont = mb_substr($messcont, $pos12 + 1);
                    } while (mb_strpos($messcont, "private [") > -1);
                    $mess.=$messcont;

                    $data_torg.=date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'to');\">" . $row['nik'] . "</a></b>: " . $mess . "</div>";
                    unset($mess, $messcont);
                    
                } else {

                    if ($row['nik'] == $nik) {
                        $data_torg.="<div class=\"msglnm\">";
                    } else {
                        $data_torg.="<div class=\"msgln\">";
                    }
                    $data_torg.=date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'to');\">" . $row['nik'] . "</a></b>: " . $row['mess'] . "</div>";
                }
            }

            $upd = $rows1[0]['id'] + 1;
            $this->session->set_userdata('upd_torg', $upd);
            $json_data['tabs-1'] = $data_torg;
        }



        /*------личный чат-------*/
        if (!$this->session->userdata('upd_priv')) {
            //Если игрок только вошел в игру
            $this->db->limit(1);       
        } else {
            //Иначе выбираем с последнего
            //запомненного ID сообщения
            $this->db->where('id >=', $this->session->userdata('upd_priv'));
            $where = "(mess LIKE '%private [%')";
        }

        //Отправляем запрос к БД на выборку сообщений
        $this->db->order_by("id", "desc");
        $query = $this->db->get('g_chat_privat');

        if ($query->num_rows() > 0) {
            $rows = $query->result_array();

            $rows_n = array_reverse($rows);

            $data = '';
                $data_priv = '';
            if ($this->session->userdata('upd_priv')) {
                
                foreach ($rows_n as $row) {

                    //$data.=$row['mess'].'<br>';

                    if ($this->chek_onl_priv($row['mess'])) {
                        //Если в сообщении есть приват
                        if ($this->chekpriv($nik, $row['mess'], $row['nik'])) {

                            $messcont = $row['mess'];
                            $mess = '';

                            do {
                                $pos1 = mb_strpos($messcont, "private [") + 9;
                                $pos12 = mb_strpos($messcont, "]", $pos1);
                                $nikchat = mb_substr($messcont, $pos1, $pos12 - $pos1);

                                $mess.="<a class=\"nonea\" onclick=\"send('" . $nikchat . "', 'priv');\"><b>private [" . $nikchat . "]</b></a> ";

                                $messcont = mb_substr($messcont, $pos12 + 1);
                            } while (mb_strpos($messcont, "private [") > -1);
                            $mess.=$messcont;


                            $data_priv.="<div class=\"msglnpriv\">" . date("H:i:s", $row['time']) . " <b><a class=\"nonea\" onclick=\"send('" . $row['nik'] . "', 'priv');\">" . $row['nik'] . "</a></b>: " . $mess . "</div>";
                            unset($mess, $messcont);

                            if($row['nik'] != $nik){
                                $json_data['sound-4'] = 1;
                            }
                        }
                    }
                }
            }

            $upd = $rows[0]['id'] + 1;
            $this->session->set_userdata('upd_priv', $upd);
            $json_data['tabs-4'] = $data_priv;
        }        





        /*------системный чат-------*/
        if (!$this->session->userdata('upd_sys')) {
            //Если игрок только вошел в игру
            $this->db->limit(1);       
        } else {
            //Иначе выбираем с последнего
            //запомненного ID сообщения
            $this->db->where('id >=', $this->session->userdata('upd_sys'));
            $this->db->where('nik', $nik);
        }

        //Отправляем запрос к БД на выборку сообщений
        $this->db->order_by("id", "desc");
        $query = $this->db->get('g_chat_system');

        if ($query->num_rows() > 0) {
            $rows1 = $query->result_array();
            $rows_nt = array_reverse($rows1);

            $data_sys = '';
            if ($this->session->userdata('upd_sys')) {
                foreach ($rows_nt as $row) {
                        $data_sys.="<div class=\"msgln\">".date("H:i:s", $row['time']) . " " . $row['mess'] . "</div>";
                }
            }
            $upd = $rows1[0]['id'] + 1;
            $this->session->set_userdata('upd_sys', $upd);
            $json_data['tabs-3'] = $data_sys;
        }        

        //$json_data = array('obsh' => $data, 'torg' => $data_torg);
        if (!empty($json_data)) {
            echo json_encode($json_data);
        }

        /* $this->db->select('id');
          $this->db->order_by("id", "desc");
          $query = $this->db->get('g_chat');

          if ($query->num_rows() == 1) {
          $rowid = $query->row();
          $upd = $rowid->id + 1;
          $this->session->set_userdata('upd', $upd);
          }

          echo 'sess: ' . $this->session->userdata('upd').'<br>'; */
    }

    function users() {
        $time = time();
        $timeout = "5";
        $elapsedtime = $time - ($timeout * 60);
        $nik = $this->session->userdata('nik');
        $loc = $this->session->userdata('loc');

        //Записываем в БД о активности игрока
        $data = array(
            'last_act' => time(),
            'in_game' => 1
        );
        $this->db->where('nik', $nik);
        $this->db->update('g_users', $data);

        //Ставим 0 в активности тем кто не в сети более 5 мин
        $data_up = array(
            'in_game' => 0
        );

        $this->db->where('last_act <', $elapsedtime);
        $this->db->update('g_users', $data_up);


        $this->db->distinct();
        $this->db->order_by("nik", "desc");
        $this->db->where('location', $loc); //заменить
        $this->db->where('in_game', 1);
        $query = $this->db->get('g_users');

        $data = getLoc($loc) . ' (' . $query->num_rows() . ')<br />';

        foreach ($query->result() as $row) {
            $inbattle = '';
            if($row->battleid>0){
                $inbattle = 'style="color:red;"';
            }
            $data.="<a class=\"nonea\" onclick=\"send('" . $row->nik . "','to');\" ".$inbattle.">" . $row->nik . '</a> ['.$row->lvl.'] <a target="blank" href="/info/login/'.$row->nik.'"><img src="http://img.carnage.ru/i/infM.gif"></a><br />';
        }
        echo $data;
    }

    function cmp($a, $b) {
        return strcmp($a["time"], $b["time"]);
    }

}