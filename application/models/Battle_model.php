<?php

class Battle_model extends CI_Model {


	function madeBattle($team1_bd,$team2_bd,$timeout,$type){
		$insert_data = array(
            'team1' => $team1_bd,
            'team2' => $team2_bd,
            'timeout' => $timeout,
            'time' => time(),
			'type' => $type
        );
        $insert = $this->db->insert('g_battles', $insert_data);
		$battleid = $this->db->insert_id();

		return $battleid;
	}

	function updateBattle($team1_bd,$team2_bd,$battleid){
		$insert_data = array(
            'team1' => $team1_bd,
            'team2' => $team2_bd
        );
        $this->db->where('id', $battleid);
        $insert = $this->db->update('g_battles', $insert_data);		
	}

	function setBattleUsers($merge_teams, $battleid){
		$data_pl = array(
               'battleid' => $battleid
        );

		for($i=0;$i<count($merge_teams);$i++){
			if($i==0){
				$this->db->where('nik', $merge_teams[$i]);
			}else{
				$this->db->or_where('nik', $merge_teams[$i]);
			}
		}
		$this->db->update('g_users', $data_pl); 		
	}


	function getBattleInfo($battleid){
    	$this->db->where('id', $battleid);
		$query = $this->db->get('g_battles');
		$row = $query->row();
       	return $row;
    }


    function writeYdar($nik,$enemy,$attack,$zah,$tact,$battleid,$time){
    	$insert_data = array(
            'pers' => $nik,
            'enemy' => $enemy,
            'attack' => $attack,
            'zah' => $zah,
			'tact' => $tact,
			'battleid' => $battleid,
			'time' => $time,
			'yron' => -1
        );
        $insert = $this->db->insert('g_battles_ydar', $insert_data);
		$battleid = $this->db->insert_id();
    }

    function getAllYdari($nik,$battleid){
    	$this->db->where('pers', $nik);
    	$this->db->where('battleid', $battleid);
    	$this->db->where('yron', -1);
		$query = $this->db->get('g_battles_ydar');
		$row = $query->result();
       	return $row;
    }


	function getAllYdariOnMe($nik,$battleid){
    	$this->db->where('enemy', $nik);
    	$this->db->where('battleid', $battleid);
    	$this->db->where('yron', -1);
		$query = $this->db->get('g_battles_ydar');
		$row = $query->result();
       	return $row;
    }

    function getYdar($pers_one,$pers_two,$battleid){
    	$this->db->where('pers', $pers_one);
    	$this->db->where('enemy', $pers_two);
    	$this->db->where('battleid', $battleid);
    	$this->db->where('yron', -1);
		$query = $this->db->get('g_battles_ydar');
		$row = $query->row();
       	return $row;
    }

	function updPl($plid,$hp){
		$data_pl = array(
               'hp_now' => $hp
            );

		$this->db->where('id', $plid);
		$this->db->update('g_users', $data_pl); 
	}

	function exitBattle($nik){
		$data_pl = array(
               'battleid' => 0
            );

		$this->db->where('nik', $nik);
		$this->db->update('g_users', $data_pl); 
	}

	function delYdar($pers_one,$pers_two,$battleid,$id){
		$this->db->where('pers', $pers_one);
    	$this->db->where('enemy', $pers_two);
    	$this->db->where('battleid', $battleid);
    	$this->db->where('id', $id);
		$this->db->delete('g_battles_ydar');
	}

	function updateYdar($pers_one,$pers_two,$battleid,$id,$yron){
		$data_pl = array(
               'yron' => $yron
            );
		$this->db->where('pers', $pers_one);
    	$this->db->where('enemy', $pers_two);
    	$this->db->where('battleid', $battleid);
    	$this->db->where('id', $id);
		$this->db->update('g_battles_ydar',$data_pl);
	}

	function addLog($text,$battleid){
		$dataLog = array(
            'battle_id' => $battleid,
            'time' => time(),
			'text' => $text
        );
        $insert = $this->db->insert('g_battle_log', $dataLog);
	}

	function getLog($battleid){
		$this->db->where('battle_id', $battleid);
		$this->db->order_by("time", "desc"); 
		$query = $this->db->get('g_battle_log');
		//$row = $query->result();
		
		return $query->result();

		$text='';	
			
	}

	function getYron($nik,$battleid){
		$this->db->where('battleid', $battleid);
		$this->db->where('pers', $nik);
		$this->db->where('yron !=', -1);
		$this->db->select_sum('yron');
		$query = $this->db->get('g_battles_ydar');

		return $query->row();
	}

	function setWin($battleid,$win){
		$data_pl = array(
               'win' => $win
            );

		$this->db->where('id', $battleid);
		$this->db->update('g_battles',$data_pl);
	}

	function updatePersAfterBattle($id,$data){
		$this->db->where('id', $id);
		$this->db->update('g_users',$data);
	}

	function madeBot($bot){		
        $insert = $this->db->insert('g_bots', $bot);
	}

	function getBot($battleid){
    	$this->db->where('battleid', $battleid);
    	/*$this->db->where('nik', $name);*/
		$query = $this->db->get('g_bots');
		$row = $query->row();
       	return $row;
    }

    function updBot($plid,$hp){
		$data_pl = array(
               'hp_now' => $hp
            );

		$this->db->where('id', $plid);
		$this->db->update('g_bots', $data_pl); 
	}


	function findUpParams($exp){
		$this->db->where('exp', $exp);
		$query = $this->db->get('g_table_opit');
		$row = $query->row();
       	return $row;
	}

	function findUpNextParams($id){
		$this->db->where('id', $id);
		$query = $this->db->get('g_table_opit');
		$row = $query->row();
       	return $row;
	}

	function findUpNextLvl($lvl){
		$this->db->where('lvl', $lvl);
		$this->db->order_by("id", "asc"); 
		$this->db->limit(1); 
		$query = $this->db->get('g_table_opit');
		$row = $query->row();
       	return $row;
	}


	function persLvlUp($text,$loc){
		$data = array(
                    'time' => time(),
                    'nik' => '',
                    'mess' => $text,
                    'loc' => $loc
                );

                $this->db->insert('g_chat', $data);
	}

	function systemMess($nik,$text){
		$data = array(
                    'time' => time(),
                    'nik' => $nik,
                    'mess' => $text
                );

                $this->db->insert('g_chat_system', $data);
	}








    /*function getBot($userlvl) {
       $this->db->where('lvl', $userlvl);
       $query = $this->db->get('g_bots');
       $row = $query->result();
	   $numm=rand(0,$query->num_rows()-1);	   
       return $row[$numm];
    }*/
	
	/*Создаем бой с ботом*/
	function madeBattle_old($player, $bot){
		$insert_data = array(
            'team1' => $player->nik,
            'team2' => $bot->name,
            'timeout' => 3,
            'time' => time(),
			'type' => 0
        );
        $insert = $this->db->insert('g_battles', $insert_data);
		$battleid = $this->db->insert_id();
		
		$data_bot = array(
               'battleid' => $battleid
        );

		$this->db->where('id', $bot->id);
		$this->db->update('g_bots', $data_bot); 
		
		
		$data_pl = array(
               'battleid' => $battleid
        );

		$this->db->where('id', $player->id);
		$this->db->update('g_users', $data_pl); 
		
		/*Создаем поле урона для игрока*/
		$insert_data_yron = array(
            'battleid' => $battleid,
            'user_id' => $player->id,
			'pl_or_bot' => 0,
            'yron' => 0
        );
        $insert = $this->db->insert('g_battles_log_yron', $insert_data_yron);
		
		/*Создаем поле урона для бота*/
		$insert_data_yronB = array(
            'battleid' => $battleid,
            'user_id' => $bot->id,
			'pl_or_bot' => 1,
            'yron' => 0
        );
        $insert = $this->db->insert('g_battles_log_yron', $insert_data_yronB);
		
        return $battleid;
	}
	
	/*Получаем данные о боте*/
	function getBotInfo($battleid) {
       $this->db->where('battleid', $battleid);
       $query = $this->db->get('g_bots');
       $row = $query->row();
       return $row;
    }
	
	/*Получаем урон*/
	
	/*function getYron($battleid,$plId){
		$this->db->where('battleid', $battleid);
		$this->db->where('user_id', $plId);
		$this->db->where('pl_or_bot', 0);
		$query = $this->db->get('g_battles_log_yron');
		$row = $query->row();		
		return $row->yron;	
	}*/
	
	function updYron($battleid,$plId,$ydarPl,$botId,$ydarBot){
		/*Обновляем урон у игрока*/
		$this->db->where('battleid', $battleid);
		$this->db->where('user_id', $plId);
		$this->db->where('pl_or_bot', 0);
		$query = $this->db->get('g_battles_log_yron');
		$row = $query->row();		
		$yron = $row->yron+$ydarPl; 
		
		$data_pl_y = array(
               'yron' => $yron
        );
		
		$this->db->where('battleid', $battleid);
		$this->db->where('user_id', $plId);
		$this->db->where('pl_or_bot', 0);
		$this->db->update('g_battles_log_yron', $data_pl_y); 
		
		/*Обновляем урон у бота*/
		$this->db->where('battleid', $battleid);
		$this->db->where('user_id', $botId);
		$this->db->where('pl_or_bot', 1);
		$query = $this->db->get('g_battles_log_yron');
		$row = $query->row();		
		
		$yronB = $row->yron+$ydarBot; 
		
		$data_pl_b = array(
               'yron' => $yronB
        );
		
		$this->db->where('battleid', $battleid);
		$this->db->where('user_id', $botId);
		$this->db->where('pl_or_bot', 1);
		$this->db->update('g_battles_log_yron', $data_pl_b); 
		
		return $yron;
	}
	
	/*function updBot($botid,$hp){
		$data_pl = array(
               'hp' => $hp
        );
		$this->db->where('id', $botid);
		$this->db->update('g_bots', $data_pl); 
	}*/
	
	
	
	function updPlEnd($pl, $win, $los, $neh, $battleid,$exp,$money){		
		$bot = $this->getBotInfo($battleid);		
		$data = array(
               'hp' => $bot->hpmax,
			   'battleid' => 0
        );
		$this->db->where('id', $bot->id);
		$this->db->update('g_bots', $data);
	
		$data_pl = array(
               'bat_win' => $pl->bat_win+$win,
			   'bat_loss' => $pl->bat_loss+$los,
			   'bat_draw' => $pl->bat_draw+$neh,
			   'battleid' => 0,	
			   'exp' => $pl->exp + $exp,
			   'money' => $pl->money + $money,
        );

		$this->db->where('id', $pl->id);
		$this->db->update('g_users', $data_pl); 	
	}
	
	
	
	
}