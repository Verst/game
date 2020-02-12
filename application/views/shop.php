<div style="float:left; width:300px">
	<ul>
		<li><span onclick="shopShowShmot('helm')">Шлемы</span></li>
		<li><span onclick="shopShowShmot('sw')">Мечи</span></li>
		<li><span onclick="shopShowShmot('armor')">Броня</span></li>
		<li><span onclick="shopShowShmot('pants')">Штаны</span></li>
		<li><span onclick="shopShowShmot('ear')">Серьги</span></li>
		<li><span onclick="shopShowShmot('neck')">Ожерелье</span></li>
		<li><span onclick="shopShowShmot('shoulder')">Наплечники</span></li>
		<li><span onclick="shopShowShmot('bracelet')">Наручи</span></li>
		<li><span onclick="shopShowShmot('glov')">Перчи</span></li>
		<li><span onclick="shopShowShmot('shield')">Щиты</span></li>
		<li><span onclick="shopShowShmot('belt')">Пояса</span></li>
		<li><span onclick="shopShowShmot('boot')">Ботинки</span></li>
		<li><span onclick="shopShowShmot('ring')">Кольца</span></li>
	</ul>
	<a href="#" onclick="chageLoc(6);">Центральная улица</a>
</div>
<div id="shopShow" style="float:left; width: calc(100% - 300px);">
	<div id="shopErr" style="color:red;"></div>
	<table width="100%">
		<?
		foreach($shmot as $row){
			echo "<tr><td align=\"center\" width=\"200\" valign=\"top\" style=\"border:1px solid #CCC;\">";
			echo '<img src="/img/'.$row->img.'">';
			echo "<br>";
			echo '<span onclick="buyShmot(\''.$row->id.'\');">Купить</span>';
			echo "</td><td width=\"100%\" valign=\"top\" style=\"border:1px solid #CCC;\">";
			echo "<b>".$row->name."</b>";
			echo "<br><br>";
			
			if($persinfo->money<$row->price){
				echo "<span style='color:red;'>Цена: ".$row->price."</span>";
			}else{
				echo "Цена: ".$row->price;
			}

			echo "<br><br>";

			echo "Требования:";
			echo "<br>";
			if($persinfo->lvl<$row->lvl){				
				echo "<span style='color:red;'>Уровень: ".$row->lvl."</span>";
			}else{
				echo "Уровень: ".$row->lvl;
			}			
			echo "<br>";
			if($persinfo->sila+$persinfo->sila_shmot<$row->sila){				
				echo "<span style='color:red;'>Сила: ".$row->sila."</span>";
			}else{
				echo "Сила: ".$row->sila;
			}			
			echo "<br>";
			if($persinfo->lovk+$persinfo->lovk_shmot<$row->lovk){				
				echo "<span style='color:red;'>Ловкость: ".$row->lovk."</span>";
			}else{
				echo "Ловкость: ".$row->lovk;
			}	
			echo "<br>";	
			if($persinfo->inta+$persinfo->inta_shmot<$row->inta){				
				echo "<span style='color:red;'>Интуиция: ".$row->inta."</span>";
			}else{
				echo "Интуиция: ".$row->inta;
			}	
			echo "<br>";
			if($persinfo->vinos<$row->inta){				
				echo "<span style='color:red;'>Жизнеспособность: ".$row->jizn."</span>";
			}else{
				echo "Жизнеспособность: ".$row->jizn;
			}
			echo "<br><br>";
			echo "Свойства:";
			echo "<br>";	
			echo "Длговечность:" .$row->dolgovehnost;
			echo "<br>";
			if($row->hp!=0){
				echo "Уровень жизни: +".$row->hp;
				echo "<br>";
			}
			if($row->vinos!=0){
				echo "Уровень выносливости: +".$row->vinos;
				echo "<br>";
			}
			if($row->damage_min!=0 && $row->damage_max!=0){
				echo "Урон: ".$row->damage_min."-".$row->damage_max;
				echo "<br>";
			}
			if($row->head_armor!=0){
				echo "Броня головы: +".$row->head_armor;
				echo "<br>";
			}
			if($row->body_armor!=0){
				echo "Броня корпуса: +".$row->body_armor;
				echo "<br>";
			}
			if($row->armor_belt!=0){
				echo "Броня пояса: +".$row->armor_belt;
				echo "<br>";
			}
			if($row->legs_armor!=0){
				echo "Броня ног: +".$row->legs_armor;
				echo "<br>";
			}
			if($row->crit!=0){
				echo "Критический удар: +".$row->crit;
				echo "<br>";
			}
			if($row->anti_crit!=0){
				echo "Защита от критического удара: +".$row->anti_crit;
				echo "<br>";
			}
			if($row->yvorot!=0){
				echo "Уворот: +".$row->yvorot;
				echo "<br>";
			}
			if($row->anti_yvorot!=0){
				echo "Против уворота: +".$row->anti_yvorot;
				echo "<br>";
			}
			if($row->sila_stat!=0){
				echo "Сила: +".$row->sila_stat;
				echo "<br>";
			}
			if($row->lovk_stat!=0){
				echo "Ловкость: +".$row->lovk_stat;
				echo "<br>";
			}
			if($row->inta_stat!=0){
				echo "Интуиция: +".$row->inta_stat;
				echo "<br>";
			}
			echo "</td></tr>";
		}
	?>	
	</table>

</div>