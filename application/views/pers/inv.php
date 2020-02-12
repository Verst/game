<div style="float:left;display:inline-block;">
<table width="200" border="0">
  <tr>
	<td width="250" valign="top">
  <b><?=$persinfo->nik;?> [<?=$persinfo->lvl;?>] <a target="blank" href="/info/login/<?=$persinfo->nik;?>"><img src="<?
  	if($persinfo->sex==1){
  		echo "http://img.carnage.ru/i/infM.gif";
  	}else{
  		echo "http://img.carnage.ru/i/infF.gif";
  	}
  ?>
  	"></a> (<span id="plhph"><?=$persinfo->hp_now;?>/<?=$persinfo->hp_max;?></span>)</b><br />
                        
						<div class="char-container">
		<div id="char-overlay">&nbsp;</div>
		
	<div class="hp-pw">
		<div class="hp-tooltip">
	    	<div id="hpPr" class="hp" style="width: <?=$persinfo->hpP;?>%; background-image: url(http://img.carnage.ru/i/hp1.gif); " title="<?=$persinfo->hp_now;?>/<?=$persinfo->hp_max;?>"><!-- --></div>
		</div>
		<div class="pw-tooltip">
	    	<div class="pw" style="width: 100%; background-image: url(http://img.carnage.ru/i/pw1.gif); "><!-- --></div>
		</div>
	</div>	
	<div id="floatingmes"></div>
	<ul class="char-items">
		<li class="avatar">
				<img alt="Аватар" src="<?
				if($persinfo->sex==1){
				echo 'http://img.carnage.ru/i/obraz/0_0_M000.jpg';}else{echo 'http://img.carnage.ru/i/obraz/0_0_F000.jpg';}?>
				" title="<?=$persinfo->nik;?>">
		</li>				
		<li class="slot slot-1 helmet helmet-empty tooltip">
		<?
		if(!empty($putOnShmot[1])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[1]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[1]->gid."\")' src='/img/".$putOnShmot[1]->img."'>";
		}
		?>
		</li>					
		<li class="slot slot-10 ring ring-empty tooltip">
		<?
		if(!empty($putOnShmot[13])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[13]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[13]->gid."\")' src='/img/".$putOnShmot[13]->img."'>";
		}
		?>
		</li>
		<li class="slot slot-11 ring ring-empty tooltip">
		<?
		if(!empty($putOnShmot[14])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[14]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[14]->gid."\")' src='/img/".$putOnShmot[14]->img."'>";
		}
		?>
		</li>
		<li class="slot slot-12 ring ring-empty tooltip">
		<?
		if(!empty($putOnShmot[15])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[15]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[15]->gid."\")' src='/img/".$putOnShmot[15]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-14 bracelet bracelet-empty tooltip">
		<?
		if(!empty($putOnShmot[8])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[8]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[8]->gid."\")' src='/img/".$putOnShmot[8]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-15 pants pants-empty tooltip">
		<?
		if(!empty($putOnShmot[4])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[4]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[4]->gid."\")' src='/img/".$putOnShmot[4]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-16 shoulder shoulder-empty tooltip">
		<?
		if(!empty($putOnShmot[7])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[7]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[7]->gid."\")' src='/img/".$putOnShmot[7]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-2 armor armor-empty tooltip">
		<?
		if(!empty($putOnShmot[3])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[3]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[3]->gid."\")' src='/img/".$putOnShmot[3]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-3 weapon weapon-empty tooltip">
		<?
		if(!empty($putOnShmot[2])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[2]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[2]->gid."\")' src='/img/".$putOnShmot[2]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-4 gloves gloves-empty tooltip">
		<?
		if(!empty($putOnShmot[9])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[9]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[9]->gid."\")' src='/img/".$putOnShmot[9]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-40 rune rune-empty tooltip"></li>		
		<li class="slot slot-41 rune rune-empty tooltip"></li>		
		<li class="slot slot-42 rune rune-empty tooltip"></li>		
		<li class="slot slot-43 rune rune-empty tooltip"></li>		
		<li class="slot slot-44 rune rune-empty tooltip"></li>		
		<li class="slot slot-45 rune rune-empty tooltip"></li>	
		
		<li class="slot slot-5 shoes shoes-empty tooltip">
		<?
		if(!empty($putOnShmot[12])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[12]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[12]->gid."\")' src='/img/".$putOnShmot[12]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-6 belt belt-empty tooltip">
		<?
		if(!empty($putOnShmot[11])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[11]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[11]->gid."\")' src='/img/".$putOnShmot[11]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-7 shield shield-empty tooltip">
		<?
		if(!empty($putOnShmot[10])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[10]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[10]->gid."\")' src='/img/".$putOnShmot[10]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-8 necklace necklace-empty tooltip">
		<?
		if(!empty($putOnShmot[6])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[6]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[6]->gid."\")' src='/img/".$putOnShmot[6]->img."'>";
		}
		?>
		</li>		
		<li class="slot slot-9 earring earring-empty tooltip">
		<?
		if(!empty($putOnShmot[5])){
			echo "<img onmousemove='showInfo(\"".$putOnShmot[5]->name."\")' onmouseout='hideInfo()' onclick='removeItem(\"".$putOnShmot[5]->gid."\")' src='/img/".$putOnShmot[5]->img."'>";
		}
		?>
		</li>			
	</ul>

	</div>
	</td>
	
</tr>
</table>
</div>