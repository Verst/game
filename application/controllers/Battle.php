<?php

class Battle extends CI_Controller { 

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('nik')) {
            redirect('');
        }
        $this->load->model('battle_model');
    }


    function attackBot(){
    	$bohp= 120+rand(5,40);
    	$name = "Бот 0 лвл";  

    	$team1[0]['nik']=$this->session->userdata('nik');
	    $team1[0]['alive']='true';
	    $team1_bd = json_encode($team1,JSON_UNESCAPED_UNICODE);

	    $team2[0]['nik']=$name;
	    $team2[0]['alive']='true';
	    $team2_bd = json_encode($team2,JSON_UNESCAPED_UNICODE);

        $battleid = $this->battle_model->madeBattle($team1_bd,$team2_bd,3,2);


        $bot = array(
            'nik' => $name,
            'lvl' => 0,
            'hp_now' => $bohp,
            'hp_max' => $bohp,
			'battleid' => $battleid
        );
        $this->battle_model->madeBot($bot);

        $merge_teams[] = $this->session->userdata('nik');
        $this->battle_model->setBattleUsers($merge_teams,$battleid);
        redirect('battle');
    }


    /*нападение/дуэль*/
    function attack(){
    	$attack = $this->input->post('attack');
    	$attack_info = $this->userinfo->getInfo($attack);    
    	$zahinhik = $this->userinfo->getInfo();    
    	if($attack_info->battleid==0 && $attack_info->in_game==1 && $attack_info->hp_now >= 20 && $attack_info->location==$zahinhik->location){
	    	$team1[0]['nik']=$this->session->userdata('nik');
	    	$team1[0]['alive']='true';

	    	$team2[0]['nik']=$attack;
	    	$team2[0]['alive']='true';

	    	$merge_teams[] = $this->session->userdata('nik');;
	    	$merge_teams[]=$attack;
	    	$this->initBattle($team1,$team2,$merge_teams);
    	}else{
    		if($attack_info->location!=$zahinhik->location){
    			$err = 'err-4';
    		}
    		if($attack_info->hp_now<20){
    			$err = 'err-3';
    		}
    		if($attack_info->battleid>0){
    			$err = 'err-1';
    		} 
    		if($attack_info->in_game==0){
    			$err = 'err-2';
    		}

    		echo $err;
    	}
    }


    /*командный/случайка*/
    function makeBattle(){
    	$team1 = $this->input->post('team1');
    	$team2 = $this->input->post('team2');

    	$team1_exp = explode(',', $team1);
    	$team2_exp = explode(',', $team2);

    	for($r=0;$r<count($team1_exp);$r++){
    		$team1_b[$r]['nik']=$team1_exp[$r];
	    	$team1_b[$r]['alive']='true';
	    	$merge_teams[] = $team1_exp[$r];
    	}
    	for($r=0;$r<count($team2_exp);$r++){
    		$team2_b[$r]['nik']=$team2_exp[$r];
	    	$team2_b[$r]['alive']='true';
	    	$merge_teams[] = $team2_exp[$r];
    	}
    	$this->initBattle($team1_b,$team2_b,$merge_teams);
    }


    /*инициализируем бой*/
    function initBattle($team1,$team2,$merge_teams){  	    	
    	$team1_bd = json_encode($team1,JSON_UNESCAPED_UNICODE);
    	$team2_bd = json_encode($team2,JSON_UNESCAPED_UNICODE);

    	//создаем бой, с записей состава команд
    	$battleid = $this->battle_model->madeBattle($team1_bd,$team2_bd,3,1);

    	print_r($merge_teams);

    	//прописываем персам id боя
    	$this->battle_model->setBattleUsers($merge_teams,$battleid);
    	redirect('battle');
    }


    function index(){
    	$data['persinfo'] = $this->userinfo->getInfo();
    	//$battleInfo = $this->battle_model->getBattleInfo($data['persinfo']->battleid);
    	if($data['persinfo']->battleid==0){
    		redirect('main');
    	}
    	$battleInfo = $this->battle_model->getBattleInfo($data['persinfo']->battleid);
    	if($battleInfo->type == 2){
    		$bot['bot'] = $this->battle_model->getBot($data['persinfo']->battleid); 
    		$bot['bot']->hpP=100/$bot['bot']->hp_max*$bot['bot']->hp_now;
    	}


    	$ydariOnMe = $this->battle_model->getAllYdariOnMe($data['persinfo']->nik,$data['persinfo']->battleid);
		$enemyA = array();
		if(count($ydariOnMe)>0){
			foreach ($ydariOnMe as $key) {
		    	$enemyA[] = $key->pers;
		    }
		}

    	$ydari = $this->battle_model->getAllYdari($data['persinfo']->nik,$data['persinfo']->battleid);
    	$enemyS = array();
		if(count($ydari)>0){
		    foreach ($ydari as $key) {
		    	$enemyS[] = $key->enemy;
		    }
		}

			
		if(!empty($enemyA)){
			for($t=0;$t<count($enemyA);$t++){				
				$sr = array_search($enemyA[$t],$enemyS);
				if($sr !== FALSE){
					$this->makeYdar($data['persinfo']->nik,$enemyS[$sr],$data['persinfo']->battleid); //Тут проходит расчет размена между персами
				}
			}
		}

    	/*обработка удара*/
    	if($this->input->post('enemy') !== null){
    		if(!in_array($this->input->post('enemy'), $enemyS)){
	    		$attack = $this->input->post('attack');
				$zah=$this->input->post('zah');
				$tact=$this->input->post('tact');
				$enemy=$this->input->post('enemy');
				$this->battle_model->writeYdar($data['persinfo']->nik,$enemy,$attack,$zah,$tact,$data['persinfo']->battleid,time());
				if($battleInfo->type == 2){
					$this->battle_model->writeYdar($bot['bot']->nik,$data['persinfo']->nik,rand(1,4),rand(1,4),rand(1,2),$data['persinfo']->battleid,time());
				}
				redirect('battle');    		
	    	}
    	}



    	/*вывод блоков боя после удара или при создании боя или обновлении страницы*/

    	if($data['persinfo']->hp_now>0){
	    	$this->perslib->show_pers();
	    }

    	
    	$team1_pers = json_decode($battleInfo->team1);
    	$team2_pers = json_decode($battleInfo->team2);
    	$data['team1_pers'] = $team1_pers;
    	$data['team2_pers'] = $team2_pers;    	

    	$noEnemy = 0;

    	$team1 = array();
    	for($r=0;$r<count($team1_pers);$r++){
    		if($team1_pers[$r]->alive=="true"){
	    		$team1[] = $team1_pers[$r]->nik;
	    	}
    	}
    	$team2 = array();
    	for($r=0;$r<count($team2_pers);$r++){
    		if($team2_pers[$r]->alive=="true"){
    			$team2[] = $team2_pers[$r]->nik;
    		}
    	}
    	

    	if(in_array($data['persinfo']->nik, $team1) || in_array($data['persinfo']->nik, $team2)){		
	    	if(!in_array($data['persinfo']->nik, $team1)){
	    		$del_enemys = array_diff ($team1, $enemyS);
	    		if(count($del_enemys)>0){
		    		$rand_enemy = array_rand($del_enemys);
		    		$data['enemy'] = $del_enemys[$rand_enemy];
	    		}else{
	    			$noEnemy = 1;
	    		}
	    	}

	    	if(!in_array($data['persinfo']->nik, $team2)){
	    		$del_enemys = array_diff ($team2, $enemyS);
	    		if(count($del_enemys)>0){
		    		$rand_enemy = array_rand($del_enemys);
		    		$data['enemy'] = $del_enemys[$rand_enemy];
	    		}else{
	    			$noEnemy = 1;
	    		}
	    	}
    	}else{
    		$noEnemy = 1;
    	}


    	


    	/*доп.лог боя*/
		$data['dop_log'] ='';
    	if($noEnemy==1 || $data['persinfo']->hp_now<=0){
    		if(count($team1)>=1 && count($team2)==0){
		    		$data['dop_log'] .= 'Победила команда 1<br>';
		    		$this->battle_model->setWin($data['persinfo']->battleid,1);
		    		$data['dop_log'] .= '<input type="button" value="Выйти из боя" onclick="exitBattle();">';
		    }elseif(count($team1)==0 && count($team2)>=1){
		    		$this->battle_model->setWin($data['persinfo']->battleid,2);
					$data['dop_log'] .= 'Победила команда 2<br>';
					$data['dop_log'] .= '<input type="button" value="Выйти из боя" onclick="exitBattle();">';
		    }elseif(count($team1)==0 && count($team2)==0){
		    		$this->battle_model->setWin($data['persinfo']->battleid,3);
		    		$data['dop_log'] .= 'Ничья<br>';
					$data['dop_log'] .= '<input type="button" value="Выйти из боя" onclick="exitBattle();">';
		    }else{
		    	if($data['persinfo']->hp_now>0){		    	
		    		$data['dop_log'] .= 'Ждите встречного удара';
			    }else{		    	
			    	$data['dop_log'] .= 'Вы мертвы. Ждите окончания боя';
			    }
		    }
    	}

    	



    	/*лог боя*/
    	$logB = $this->battle_model->getLog($data['persinfo']->battleid);
    	$logText = '';
    	foreach ($logB as $row)
		{
				$logText.= $row->text;
				$logText.="-----------------------------<br>";
		}
		$data['log'] = $logText;


		$data['yron'] = $this->battle_model->getYron($data['persinfo']->nik,$data['persinfo']->battleid);


    	$this->load->view('battlemidle',$data);

    	if($noEnemy==0 && $data['persinfo']->hp_now>0){	  
    		if($battleInfo->type == 2){
    			$this->load->view('bot',$bot);
    		}else{		    	
		    	$this->perslib->show_pers($data['enemy']);
		    }
    	}
    }

    function makeYdar($pers_one,$pers_two,$battleid){
    	$battleInfo = $this->battle_model->getBattleInfo($battleid);
    	
    	$pers_one_param = $this->userinfo->getInfo($pers_one);
    	$pers_one_ydar = $this->battle_model->getYdar($pers_one,$pers_two,$battleid);

    	if($battleInfo->type == 2){
    		$pers_two_param = $this->battle_model->getBot($battleid,$pers_two);
    		/*$pers_two_ydar = array(
    			'attack'=> rand(1,4),
    			'zah'=> rand(1,4),
    			'tact'=> rand(1,2)
    		);*/
    	}else{
    		$pers_two_param = $this->userinfo->getInfo($pers_two);
    		
    	}
		
		$pers_two_ydar = $this->battle_model->getYdar($pers_two,$pers_one,$battleid);
		
		

		$logbattle="";

		if($pers_one_ydar->zah == $pers_two_ydar->attack){
			$pers_one_yron = 0;
			$logbattle.=$pers_one_param->nik." блокировал удар ".$pers_two_param->nik." ".$pers_one_param->nik." (".$pers_one_param->hp_now."/".$pers_one_param->hp_max.")<br>";	
		}else{
			switch ($pers_two_ydar->attack) {
				case 1:
					$mesto='голову';
					break;
				case 2:
					$mesto='грудь';
					break;
				case 3:
					$mesto='живот';
					break;
				case 4:
					$mesto='ноги';
					break;			
			}

			$s_attack = "";
			if($pers_two_ydar->tact == 1){
				$pers_one_yron = rand(20,50)*2;
				$s_attack = "с атакой ";
			}else{
				$pers_one_yron = rand(20,50);
			}
			$pers_one_hp = $pers_one_param->hp_now - $pers_one_yron;
			if($pers_one_hp<=0){
				$pers_one_hp = 0;
			}

			$logbattle.=$pers_two_param->nik." ударил ".$s_attack.$pers_one_param->nik." в ".$mesto." на -".$pers_one_yron." ".$pers_one_param->nik." (".$pers_one_hp."/".$pers_one_param->hp_max.")<br>";	
		
		}

		

		/*прописываем обновление ХП первому персу*/
		$pers_one_hp = $pers_one_param->hp_now - $pers_one_yron;

		if($pers_one_hp<=0){
			$pers_one_hp = 0;
			$this->setPersDie($pers_one_param->nik,$battleid);
		}

		$this->battle_model->updPl($pers_one_param->id, $pers_one_hp); 


		if($pers_two_ydar->zah == $pers_one_ydar->attack){
			$pers_two_yron = 0;
			$logbattle.=$pers_two_param->nik." блокировал удар ".$pers_one_param->nik." ".$pers_two_param->nik." (".$pers_two_param->hp_now."/".$pers_two_param->hp_max.")<br>";	
		}else{
			switch ($pers_one_ydar->attack) {
				case 1:
					$mesto='голову';
					break;
				case 2:
					$mesto='грудь';
					break;
				case 3:
					$mesto='живот';
					break;
				case 4:
					$mesto='ноги';
					break;			
			}

			$s_attack = "";
			if($pers_one_ydar->tact == 1){
				$pers_two_yron = rand(20,50)*2;
				$s_attack = "с атакой ";
			}else{
				$pers_two_yron = rand(20,50);
			}
			$pers_two_hp = $pers_two_param->hp_now - $pers_two_yron;
			if($pers_two_hp<=0){
				$pers_two_hp = 0;
			}
			$logbattle.=$pers_two_param->nik." ударил ".$s_attack.$pers_one_param->nik." в ".$mesto." на -".$pers_two_yron." ".$pers_two_param->nik." (".$pers_two_hp."/".$pers_two_param->hp_max.")<br>";				
		}

		$this->battle_model->addLog($logbattle,$battleid);

		/*прописываем обновление ХП второму персу*/
		$pers_two_hp = $pers_two_param->hp_now - $pers_two_yron;

		if($pers_two_hp<=0){
			$pers_two_hp = 0;
			$this->setPersDie($pers_two_param->nik,$battleid);
		}

		if($battleInfo->type == 2){
			$this->battle_model->updBot($pers_two_param->id, $pers_two_hp);
		}else{
			$this->battle_model->updPl($pers_two_param->id, $pers_two_hp);
		}
		



		/*удалени ударов из бд*/

		//$this->battle_model->delYdar($pers_one,$pers_two,$battleid,$pers_one_ydar->id);
		//$this->battle_model->delYdar($pers_two,$pers_one,$battleid,$pers_two_ydar->id);

		$this->battle_model->updateYdar($pers_one,$pers_two,$battleid,$pers_one_ydar->id,$pers_two_yron);
		$this->battle_model->updateYdar($pers_two,$pers_one,$battleid,$pers_two_ydar->id,$pers_one_yron);



    	//echo "будет бой между ".$pers_one.' - '.$pers_one_hp." и ".$pers_two.' - '.$pers_two_hp;

    	redirect('battle');
    }


    function setPersDie($nik,$battleid){
    	$battleInfo = $this->battle_model->getBattleInfo($battleid);
    	$team1_pers = json_decode($battleInfo->team1);
    	$team2_pers = json_decode($battleInfo->team2);

    	for($r=0;$r<count($team1_pers);$r++){
    		if($team1_pers[$r]->nik == $nik){
    			$team1_pers[$r]->alive = "false";
    		}    		
    	}
    	for($r=0;$r<count($team2_pers);$r++){
    		if($team2_pers[$r]->nik == $nik){
    			$team2_pers[$r]->alive = "false";
    		}    		
    	}

    	$team1_bd = json_encode($team1_pers,JSON_UNESCAPED_UNICODE);
    	$team2_bd = json_encode($team2_pers,JSON_UNESCAPED_UNICODE);

    	$this->battle_model->updateBattle($team1_bd,$team2_bd,$battleid);
    }


    function exitBattle(){
    	$pers = $this->userinfo->getInfo();
    	$battleInfo = $this->battle_model->getBattleInfo($pers->battleid);
    	$team1_pers = json_decode($battleInfo->team1);
    	$team2_pers = json_decode($battleInfo->team2);

    	$pers_in_team = '';

    	for($r=0;$r<count($team1_pers);$r++){
    		if($team1_pers[$r]->nik == $pers->nik){
    			$pers_in_team = 1;
    		}    		
    	}
    	for($r=0;$r<count($team2_pers);$r++){
    		if($team2_pers[$r]->nik == $pers->nik){
    			$pers_in_team = 2;
    		}    		
    	}
    	$data = array();
    	$exp_get = 0;
    	$money = 0;
    	if($battleInfo->win == 3){    		
    		$data['bat_draw'] = $pers->bat_draw+1;
    	}elseif($battleInfo->win == $pers_in_team){  
    		/*расчет улучшений для перса*/  		
    		$data['bat_win'] = $pers->bat_win+1;
    		$exp_get = 5;
    		$exp = $pers->exp + $exp_get;
    		$data['exp'] = $exp;

    		$money = 5;
    		$data['money'] = $pers->money + $money;


    		if($exp >= $pers->exp_up){
    			$upParams = $this->battle_model->findUpParams($pers->exp_up);
    			$upParamsNext = $this->battle_model->findUpNextParams($upParams->id+1);
    			if($pers->lvl < $upParams->lvl){
    				$data['lvl'] = $upParams->lvl;
    				$upParamsNextLvl = $this->battle_model->findUpNextLvl($upParams->lvl+1);
    				$data['exp_lvl'] = $upParamsNextLvl->exp;

    				$text = $pers->nik.' взял '.$upParams->lvl.' уровень!';
    				$this->battle_model->persLvlUp($text,$pers->location);

    			}
    			$data['free_params'] = $pers->free_params + $upParams->plus_params;
    			$data['money'] = $pers->money + $upParams->money+$money;
    			$data['vinos'] = $pers->vinos + $upParams->vinos;
    			$data['hp_max'] = $pers->hp_max + 30;
    			$data['exp_up'] = $upParamsNext->exp;    			
    		}


    	}else{			
			$data['bat_loss'] = $pers->bat_loss+1;
    	}

    	if($money>0){
	    	$text_mess = "Вам начислено <b>".$money."</b> монет";
	    	$this->battle_model->systemMess($pers->nik,$text_mess);
	    }

    	$yron = $this->battle_model->getYron($pers->nik,$pers->battleid);

    	$text_mess = "Вами нанесено <b>".$yron->yron." hp</b> урона. Получено <b>".$exp_get."</b> опыта";
    	$this->battle_model->systemMess($pers->nik,$text_mess);
    	//print_r($this->db->queries);


    	$data['battleid'] = 0;
    	$this->battle_model->updatePersAfterBattle($pers->id,$data);
    	//redirect('arena');
    	$this->load->view('arena');
    }

















    function bot() {		
		$data['persinfo'] = $this->userinfo->getInfo();		
		$this->load->model('battle_model');
		
		//$data['persinfo']->hpP=100/$data['persinfo']->hp_max*$data['persinfo']->hp_now;
		
		if($data['persinfo']->battleid==0){			
			$data['botinfo'] = $this->battle_model->getBot($data['persinfo']->lvl);		
			$data['battleid'] = $this->battle_model->madeBattle($data['persinfo'], $data['botinfo']);	
			$data['yron'] = 0;
			$data['log'] = '';
		}else{
			$battleid = $data['persinfo']->battleid;
			$data['botinfo'] = $this->battle_model->getBotInfo($battleid);
			$data['battleid'] = $battleid;
			$data['yron'] = $this->battle_model->getYron($battleid,$data['persinfo']->id);
			$data['log'] = $this->battle_model->getLog($battleid);
		}
		
		$data['botinfo']->hpP=100/$data['botinfo']->hpmax*$data['botinfo']->hp;
		$this->perslib->show_pers();
		$this->load->view('battlebot', $data);
    }


    

	
	function botatt(){
		$data['persinfo'] = $this->userinfo->getInfo();	
	
		$attack = $this->input->post('attack');
		$zah=$this->input->post('zah');
		$tact=$this->input->post('tact');
		$battleid=$this->input->post('battleid');
		$yronPl =0;
		$ydarPl=0;
		$ydarBot=0;
		if($data['persinfo']->battleid==$battleid){		
			$this->load->model('battle_model');
			$data['botinfo'] = $this->battle_model->getBotInfo($battleid);
			
			$botattack = rand(1,4);
			$botzah = rand(1,4);
			$bottack = rand(1,2);
			$logbattle='';
			
			if($attack==1){
				$mesto='голову';
			}
			if($attack==2){
				$mesto='грудь';
			}
			if($attack==3){
				$mesto='живот';
			}
			if($attack==4){
				$mesto='ноги';
			}
			
			if($botattack==1){
				$botmesto='голову';
			}else if($botattack==2){
				$botmesto='грудь';
			}else if($botattack==3){
				$botmesto='живот';
			}else if($botattack==4){
				$botmesto='ноги';
			}
			$bothp=$data['botinfo']->hp;
			$plhp=$data['persinfo']->hp_now;
			if($attack!=$botzah){
				if($tact==1){
					$bothp=$data['botinfo']->hp-2;
					$ydar=2;
				}
				if($tact==2){
					$bothp=$data['botinfo']->hp-1;
					$ydar=1;
				}
				
				if($bothp<0){
					$bothp=0;
				}
				$ydarPl=$ydar;
				
				$this->battle_model->updBot($data['botinfo']->id, $bothp);		
				$logbattle.=$data['persinfo']->nik." ударил ".$data['botinfo']->name." в ".$mesto." на -".$ydar." ".$data['botinfo']->name." (".$bothp."/".$data['botinfo']->hpmax.")<br>";				
			}else{
				$logbattle.=$data['botinfo']->name." блокировал удар ".$data['persinfo']->nik." ".$data['botinfo']->name." (".$data['botinfo']->hp."/".$data['botinfo']->hpmax.")<br>";
			}
			
			if($botattack!=$zah){
				if($tact==1){
					$plhp=$data['persinfo']->hp_now-2;
					$ydar=2;
				}
				
				if($tact==2){
					$plhp=$data['persinfo']->hp_now-1;
					$ydar=1;
				}
				if($plhp<0){
					$plhp=0;
				}
				$ydarBot=$ydar;
				
				$this->battle_model->updPl($data['persinfo']->id, $plhp);	
				$logbattle.=$data['botinfo']->name." ударил ".$data['persinfo']->nik." в ".$botmesto." на -".$ydar." ".$data['persinfo']->nik." (".$plhp."/".$data['persinfo']->hp_max.")<br>";
			}else{
				$logbattle.=$data['persinfo']->nik." блокировал удар ".$data['botinfo']->name." ".$data['persinfo']->nik." (".$data['persinfo']->hp_now."/".$data['persinfo']->hp_max.")<br>";
			}	

			$yronPl = $this->battle_model->updYron($battleid,$data['persinfo']->id,$ydarPl,$data['botinfo']->id,$ydarBot);
			
			$this->battle_model->addLog($logbattle,$battleid);
			
			$logbattle.="-----------------------------<br>";
			$endbatt='';
			$battend=0;
			if($bothp==0 && $plhp>0){
				$endbatt="Бой закончен. Победа за ".$data['persinfo']->nik."<br>";
				$endbatt.="Нанесено урона: ".$yronPl."<br>";
				$endbatt.="-----------------------------<br>";
				$exp = $yronPl / 2; //начисление опыта при победе перса
				$money = $yronPl / 5; //начисление денег персу
				$this->battle_model->updPlEnd($data['persinfo'], 1, 0, 0,$battleid,$exp,$money);
				$this->battle_model->addLog($endbatt,$battleid);
				$battend=1;
			}
			
			if($bothp>0 && $plhp==0){
				$endbatt="Бой закончен. Победа за ".$data['botinfo']->name."<br>";
				$endbatt.="Нанесено урона: ".$yronPl."<br>";
				$endbatt.="-----------------------------<br>";
				$this->battle_model->updPlEnd($data['persinfo'], 0, 1, 0,$battleid,0,0);
				$this->battle_model->addLog($endbatt,$battleid);
				$battend=1;
			}
			
			if($bothp==0 && $plhp==0){
				$endbatt="Бой закончен. Ничья.<br>";
				$endbatt.="Нанесено урона: ".$yronPl."<br>";
				$endbatt.="-----------------------------<br>";
				$exp = $yronPl / 4; //начисление опыта при ничье перса
				$this->battle_model->updPlEnd($data['persinfo'], 0, 0, 1,$battleid,$exp,0);
				$this->battle_model->addLog($endbatt,$battleid);
				$battend=1;
			}
			
			$plhpProc = 100/$data['persinfo']->hp_max*$plhp;
			$bothpProc = 100/$data['botinfo']->hpmax*$bothp;
			
			echo json_encode(array('mess' => $endbatt.$logbattle,'plhp' => $plhpProc, 'bothp' => $bothpProc, 'plhpH'=>$plhp.'/'.$data['persinfo']->hp_max, 'bothpH'=>$bothp.'/'.$data['botinfo']->hpmax, 'yron'=>$yronPl, 'battend'=>$battend));
		}
	}

}