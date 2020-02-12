<div>
Вы сейчас в: <? echo getLoc($this->session->userdata('loc'));?><br />
<?
$locs = [1,2,3,4,5];
if(in_array($this->session->userdata('loc'), $locs)){
?>
<img src="https://img.getbg.net/upload/full/12/www.GetBg.net_Fantasy_Beautiful_castle_fantasy_093893_.jpg" width="600"><br>
Перейти: <a href="#" onclick="chageLoc(1);">Первый зал</a> <a href="#" onclick="chageLoc(2);">Второй зал</a> <a href="#" onclick="chageLoc(4);">Третий зал</a> <a href="#" onclick="chageLoc(5);">Четвертый зал</a><br>
	<? if($this->session->userdata('loc') != 3){?>
	<a href="#" onclick="chageLoc(3);">Выйти в главный коридор замка</a>
	<?}?>
<?}?>

<? if($this->session->userdata('loc') == 3){?>
<a href="#" onclick="chageLoc(6);">Центральная площадь</a>
<?}?>


<? if($this->session->userdata('loc') == 6){?>
<img src="https://archived.moe/files/qst/image/1490/57/1490570651811.jpg" width="600"><br>
<a href="#" onclick="chageLoc(3);">Замок</a> <a href="#" onclick="chageLoc(7);">Магазин</a>


<?}?>
</div>