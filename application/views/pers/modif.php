<div style="float:left;display:inline-block;">
<table width="250" border="0">
  <tr>
<td width="250" valign="top">
		Бои:<br>
		- Побед: <?=$persinfo->bat_win;?><br>
		- Поражений:<?=$persinfo->bat_loss;?><br>
		- Ничьи:<?=$persinfo->bat_draw;?><br>
		<br>
		<?if($show_full!='false'){?>

		Опыт: <?=$persinfo->exp;?>/<?=$persinfo->exp_up;?> (уровень: <?=$persinfo->exp_lvl;?>)<br>
		Денег: <?=$persinfo->money;?><br>
		<?}?>
		<br>
		<?if($show_full!='false'){?>
		Параметры персонажа:<br> 
		- Сила: <?=$persinfo->sila+$persinfo->sila_shmot;?> (<?=$persinfo->sila;?> + <?=$persinfo->sila_shmot;?>) <?if($persinfo->free_params>0){?><span onclick="paramAdd('sila');">+</span><?}?><br>
		- Ловкость: <?=$persinfo->lovk+$persinfo->lovk_shmot;?> (<?=$persinfo->lovk;?> + <?=$persinfo->lovk_shmot;?>) <?if($persinfo->free_params>0){?><span onclick="paramAdd('lovk');">+</span><?}?><br>
		- Интуиция: <?=$persinfo->inta+$persinfo->inta_shmot;?> (<?=$persinfo->inta;?> + <?=$persinfo->inta_shmot;?>) <?if($persinfo->free_params>0){?><span onclick="paramAdd('inta');">+</span><?}?><br>
		- Жизнеспособность: <?=$persinfo->vinos;?> <?if($persinfo->free_params>0){?><span onclick="paramAdd('vinos');">+</span><?}?><br><br>
		
		<?if($persinfo->free_params > 0){?>Свободные параметры: <?=$persinfo->free_params;?><br><br><?}?>
		Параметры: <br>
		Уровень жизни:	+<?=$persinfo->sv_hp;?><br>
		Уровень выносливости:	+<?=$persinfo->sv_vinos;?><br>
		Урон:	<?=$persinfo->damage_min;?> - <?=$persinfo->damage_max;?><br>
		Броня головы:	+<?=$persinfo->head_armor;?><br>
		Броня корпуса:	+<?=$persinfo->body_armor;?><br>
		Броня пояса:	+<?=$persinfo->armor_belt;?><br>
		Броня ног:	+<?=$persinfo->legs_armor;?><br>
		Критический удар:	<?=$persinfo->crit;?><br>
		Против критич-го удара:	+<?=$persinfo->anti_crit;?><br>
		Увертывание:	+<?=$persinfo->yvorot;?><br>
		Против увертывания:	+<?=$persinfo->anti_yvorot;?><br>
		<?}?>

		<?if($show_full=='false'){?>
		Параметры персонажа:<br> 
		- Сила: <?=$persinfo->sila+$persinfo->sila_shmot;?> (<?=$persinfo->sila;?> + <?=$persinfo->sila_shmot;?>) <br>
		- Ловкость: <?=$persinfo->lovk+$persinfo->lovk_shmot;?> (<?=$persinfo->lovk;?> + <?=$persinfo->lovk_shmot;?>) <br>
		- Интуиция: <?=$persinfo->inta+$persinfo->inta_shmot;?> (<?=$persinfo->inta;?> + <?=$persinfo->inta_shmot;?>) <br>
		- Жизнеспособность: <?=$persinfo->vinos;?><br><br>

		Дата регистрации: <?=date("d.m.Y",$persinfo->timereg);?>
		<?}?>
	</td>
</tr>
</table>
</div>