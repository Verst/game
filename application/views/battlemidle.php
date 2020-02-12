<div id="battlPanel" style="float:left;width:calc(100% - 520px);text-align:center;">
	<?
		if(isset($enemy)){			
	?>
	<table>
	<tr>
	<td>
		Атака:
		<ul>
			<li><input type="radio" name="atack" value="1" checked> В голову</li>
			<li><input type="radio" name="atack" value="2"> В грудь</li>
			<li><input type="radio" name="atack" value="3"> В живот</li>
			<li><input type="radio" name="atack" value="4"> В ноги</li>
		</ul>
		</td><td>
		Защита:
		<ul>
			<li><input type="radio" name="zah" value="1" > Голова</li>
			<li><input type="radio" name="zah" value="2" checked> Грудь</li>
			<li><input type="radio" name="zah" value="3"> Живот</li>
			<li><input type="radio" name="zah" value="4"> Ноги</li>
		</ul>
		</td></tr>
	<tr>
	<td colspan="2">
		<input type="radio" name="tact" value="1" checked> Атакующая
		<input type="radio" name="tact" value="2"> Защитная
	</td>
	</tr>
	<tr>
	<td colspan="2">
			<input type="hidden" id="enemy" name="enemy" value="<?=$enemy;?>">
		
			<input type="submit" onclick="attack();" value="Удар">
		
		
	</td>
	</tr>
	</table>	

	<?}?>
	<div id="battleLog">
		<div>
			<?=$dop_log;?>
		</div>
		<div>
			<?
			for($r=0;$r<count($team1_pers);$r++){
	    		if($team1_pers[$r]->alive=="true"){
		    		echo "<b>".$team1_pers[$r]->nik."</b> ";
		    	}else{
		    		echo "<span style='color:gray;'>".$team1_pers[$r]->nik."</span>";
		    	}
	    	}?>
	    	против
	    	<?
	    	for($r=0;$r<count($team2_pers);$r++){
	    		if($team2_pers[$r]->alive=="true"){
		    		echo " <b>".$team2_pers[$r]->nik."</b>";
		    	}else{
		    		echo "<span style='color:gray;'>".$team2_pers[$r]->nik."</span>";
		    	}
	    	}

			?>
		</div>
		<div>
			<?=$log;?>
		</div>
	</div>
	
	Вами нанесено урона: <span id="yronpl">
	<?
	if($yron->yron > 0){
		echo $yron->yron;
	}else{
		echo "0";
	}
	?></span>
</div>