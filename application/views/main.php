<html>
    <head>
        <title>Моя игра</title>
        <meta charset="utf-8">
		<link rel="stylesheet" href="css/style.css">		
		<link type="text/css" rel="stylesheet" href="js/layout-default-latest.css" />
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-latest.js"></script>
		<SCRIPT type="text/javascript" src="js/jquery.layout-latest.js"></SCRIPT>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
        
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.4.custom.css">
		<SCRIPT type="text/javascript">
var outerLayout, middleLayout, innerLayout; 
	$(document).ready(function () { 
		outerLayout = $('body').layout({ 
		center__paneSelector:	".outer-center"
		
		,	spacing_open:			8 // ALL panes
		,	spacing_closed:			12 // ALL panes		
		,	north__resizable:		false	// OVERRIDE the pane-default of 'resizable=true'
		,	north__spacing_open:	0		// no resizer-bar when open (zero height)
		,	north__spacing_closed:	20		// big resizer-bar when open (zero height)
		, 	north__size: 			50
		
		,	south__resizable:		false	// OVERRIDE the pane-default of 'resizable=true'
		,	south__spacing_open:	0		// no resizer-bar when open (zero height)
		,	south__spacing_closed:	20		// big resizer-bar when open (zero height)
		, 	south__size: 			40
		,	north__maxSize:			200
		}); 
		
		middleLayout = $('div.outer-center').layout({ 
			center__paneSelector:	".middle-center" 
		,	south__paneSelector:	".middle-south" 
		,	south__size:			200
		,	east__size:				200 
		,	spacing_open:			8  // ALL panes
		,	spacing_closed:			12 // ALL panes
		}); 
		
		
		
		innerLayout = $('div.middle-south').layout({ 
			center__paneSelector:	".inner-center" 
		,	east__paneSelector:		".inner-east" 
		,	east__size:				200 
		,	spacing_open:			8  // ALL panes
		,	spacing_closed:			8  // ALL panes
		,	west__spacing_closed:	12
		,	east__spacing_closed:	12
		}); 

}); 




</SCRIPT>
    </head>
    <body>
      <div class="outer-center">
		<div class="middle-center">	
			<div id="datablock">
                     
            </div>
		</div> 		
	<div class="middle-south">
		<div class="inner-center">
			<div id="chatTabs">
				<ul>
					<li><a onclick="chatTab(0);" id="chatTab0" style="font-weight:bold;">Общий</a></li>
					<li><a onclick="chatTab(4);" id="chatTab4">Личный</a></li> 
                    <li><a onclick="chatTab(1);" id="chatTab1">Торговый</a></li> 
                    <li><a onclick="chatTab(2);" id="chatTab2">Клан</a></li>
                    <li><a id="chatTab3">Системный</a></li>
                </ul>
			</div>
			<div style="width:100%;height: 100%;display:  block;">
				<div id="tabs-0" class="tabsCss" ></div>
	            <div id="tabs-1" class="tabsCss" style="display:none"></div>
	            <div id="tabs-2" class="tabsCss" style="display:none"></div>
	            <div id="tabs-4" class="tabsCss" style="display:none"></div> 
	            <div id="tabs-3" class="tabsCss" style="width: 30%;float: left;"></div> 
	            
	        </div>
		</div> 
		
		<div class="inner-east"><div id="users">
                                     
                                 </div></div>	
	</div> 
</div> 

<div class="ui-layout-north">
	<div style="display: inline-block;float:left;padding:10px;">
		<a onclick="openPage('pers');">Персонаж</a> || <a onclick="openPage('inv');">Инвентарь</a> || <a onclick="openPage('loc');">Локация</a> || <a onclick="openPage('arena');">Поединки</a>
	</div>
	<div style="display: inline-block;float: right;padding:10px;">
		<b><?=$persinfo->nik;?> [<?=$persinfo->lvl;?>] <img src="<?
  	if($persinfo->sex==1){
  		echo "http://img.carnage.ru/i/infM.gif";
  	}else{
  		echo "http://img.carnage.ru/i/infF.gif";
  	}
  ?>
  	"> (<span id="plhphtop"><?=$persinfo->hp_now;?>/<?=$persinfo->hp_max;?></span>)</b>
	</div>
</div> 
<div class="ui-layout-south"><form name="message" method="post" action="" id="formsubm" onsubmit="return false;">
                                    <input name="usermsg" type="text" id="usermsg" size="63" />
                                    <input name="submitmsg" type="submit"  id="submitmsg" value="Отправить" />
                                </form> <a id="exit" href="#">Выйти</a></div> 
<audio id='message3' controls='false' preload='none' style='display: none;' src='/sounds/message.mp3'></audio>
    </body>
</html>