setInterval (loadLog, 5000);
setInterval (userOnline, 5000);
setInterval (updHp, 11000);

var intervalId0 = 0;
var intervalId1 = 0;
var intervalId4 = 0;
// jQuery Document

var chatInd = 0;

$(document).ready(function(){
    loadLog();
    userOnline();
	openPage("pers");

    //Вешам событие на отправку сообещния в чат
    $('#formsubm').submit(function() {
        var clientmsg = $("#usermsg").val();
        $.post("chat/send", {
            text: clientmsg,
            chatind: chatInd
        });
        $("#usermsg").attr("value", "");
        setTimeout(loadLog,1000);
        $("#usermsg").focus();       
        return false;
    });

    //Выход из игры
    $("#exit").click(function(){
        var exit = confirm("Вы точно хотите выйти?");
        if(exit==true){
            window.location = 'enter/logout';
        }
    });
	
	
	$("#block").mousemove(		
		  
	   
	   ).mouseleave(function() {
			$("#floatingmes").hide();  
	}); 
   
});


function showInfo(txt){ 
	$("#floatingmes").html(txt);
	$("#floatingmes").show(); 	
	$("#floatingmes").css('left',(event.pageX+15)+'px').css('top',(event.pageY-35)+'px'); 	

}

function hideInfo(){
	$("#floatingmes").hide(); 	
}

function loadLog(chgLoc){
    var oldscrollHeight = $("#tabs-0").attr("scrollHeight") - 20; //Scroll height before the request
    var oldscrollHeight2 = $("#tabs-1").attr("scrollHeight") - 20;
    var oldscrollHeight4 = $("#tabs-4").attr("scrollHeight") - 20;
    var oldscrollHeight3 = $("#tabs-3").attr("scrollHeight") - 20;


    
    if(chgLoc == 'changeLoc'){

        var pChgLoc = 1;
    }else{
        var pChgLoc = 0;

    }
    
	$.ajax({
        type: "POST",
        url: "chat/update",
        dataType : "json",
        cache: false,
        data: "chatindc="+chatInd+"&pChgLoc="+pChgLoc,
        success: function(html){

            if(html==null){
                return;
            }
            var sound = -1;
            var blink_0 = 0;
            var blink_1 = 0;
            var blink_4 = 0;
            $.each(html, function(i, val) {    // обрабатываем полученные данные
                    $("#"+i).append(val);  

                    if(i=='sound-0' && val==1){
                        sound = 0;
                    }
                    if(i=='sound-1' && val==1){
                        sound = 1;
                    }
                    if(i=='sound-4' && val==1){
                        sound = 4;
                    }

                    if(i=='tabs-0' && val!=''){   
                        blink_0 = 1; 
                   }
                    if(i=='tabs-1' && val!=''){
                        blink_1 = 1; 
                   }
                    if(i=='tabs-4' && val!=''){
                        blink_4 = 1; 
                   }
            });

            if(sound >= 0){
                $("#message3").trigger("play");
            }

            if(sound == 0 && blink_0==1){
                var disp = $("#tabs-0").css("display");
                        if(disp == 'none'){
                            intervalId0 = setInterval(blink, 1000, 0);
                        }
            }
            if(sound == 1 && blink_1==1){
                var disp = $("#tabs-1").css("display");
                        if(disp == 'none'){
                            intervalId1 = setInterval(blink, 1000, 1);
                        }
            }
            if(sound == 4 && blink_4==1){
                var disp = $("#tabs-4").css("display");
                        if(disp == 'none'){
                            intervalId4 = setInterval(blink, 1000, 4);
                        }
            }
            
			
            //Auto-scroll tab1
            
			var newscrollHeight = $("#tabs-0").attr("scrollHeight") - 20; //Scroll height after the request            
			$("#tabs-0").scrollTop(newscrollHeight);
			if(newscrollHeight > oldscrollHeight){				
                $("#tabs-0").animate({
                    scrollTop: newscrollHeight
                }, 'normal'); //Autoscroll to bottom of div
            }			
			
            //Auto-scroll tab2
            var newscrollHeight2 = $("#tabs-1").attr("scrollHeight") - 20; //Scroll height after the request
            $("#tabs-1").scrollTop(newscrollHeight2);
            if(newscrollHeight2 > oldscrollHeight2){
                $("#tabs-1").animate({  
                    scrollTop: newscrollHeight2
                }, 'normal'); //Autoscroll to bottom of div
            }

            //Auto-scroll tab2
            var newscrollHeight4 = $("#tabs-4").attr("scrollHeight") - 20; //Scroll height after the request
            $("#tabs-4").scrollTop(newscrollHeight4);
            if(newscrollHeight4 > oldscrollHeight4){
                $("#tabs-4").animate({  
                    scrollTop: newscrollHeight4
                }, 'normal'); //Autoscroll to bottom of div
            }

            //Auto-scroll tab2
            var newscrollHeight3 = $("#tabs-3").attr("scrollHeight") - 20; //Scroll height after the request
            $("#tabs-3").scrollTop(newscrollHeight3);
            if(newscrollHeight3 > oldscrollHeight3){
                $("#tabs-3").animate({  
                    scrollTop: newscrollHeight3
                }, 'normal'); //Autoscroll to bottom of div
            }

        }
    });
}

function blink(blink){
   
    var cl = $("#chatTab"+blink).css("color");
    if(cl == 'red'){
        $("#chatTab"+blink).css("color","black");
    }else{
        $("#chatTab"+blink).css("color","red");
        
    }    
}

function userOnline(){
    $.ajax({
        type: "POST",
        url: "chat/users",
        cache: false,
        success: function(html){
            $("#users").html(html); //Insert chat log into the #chatbox div
        }
    });
}


function send(nick, param){
    var tt;
    var text_i = $("#usermsg").val();
    var nick_t="to ["+nick+'] ';
    var nick_p="private ["+nick+'] ';

    if(text_i.indexOf(nick_t)>-1){
        var tt=text_i.replace(nick_t, nick_p);
        $("#usermsg").val(tt);
        return;
    }

    if(text_i.indexOf(nick_p)>-1){
        var tt=text_i.replace(nick_p, nick_t);
        $("#usermsg").val(tt);
        return;
    }
    
    if(param=='to'){
        tt = "to ["+nick+"] "+$("#usermsg").val();
    }

    if(param=='priv'){
        tt = "private ["+nick+"] "+$("#usermsg").val();
    }
    
    $("#usermsg").val(tt);
    $("#usermsg").focus();
}

function chageLoc(loc){
     $.ajax({
        type: "POST",
        url: "loc/changeLoc",
        cache: false,
        data: "loc="+loc,
        success: function(html){
            $("#tabs-0").html('');
            loadLog('changeLoc');
            userOnline();
            $("#datablock").html(html); //Insert chat log into the #chatbox div
        }
    });
}

function locat(loc){
    $("#tabs-0").html('');

   var oldscrollHeight = $("#tabs-0").attr("scrollHeight") - 20; //Scroll height before the request
    var oldscrollHeight2 = $("#tabs-1").attr("scrollHeight") - 20;
    $.ajax({
        type: "POST",
        url: "chat/update/chloc",
         dataType : "json",
        cache: false,
        data: "loc="+loc+"&chatindc="+chatInd,
        success: function(html){
             $.each(html, function(i, val) {    // обрабатываем полученные данные
               if(i=='tabs-0'){
                   $("#"+i).append(val);
               }
            });

              var newscrollHeight = $("#tabs-0").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#tabs-0").animate({
                    scrollTop: newscrollHeight
                }, 'normal'); //Autoscroll to bottom of div
            }

            //Auto-scroll tab2
            var newscrollHeight2 = $("#tabs-1").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight2 > oldscrollHeight2){
                $("#tabs-1").animate({
                    scrollTop: newscrollHeight
                }, 'normal'); //Autoscroll to bottom of div
            }
        }
    });
    // setTimeout(userOnline,1000);
    userOnline();
}

function chatTab(ind){
	//alert("111");
	$("#tabs-"+chatInd).css('display','none');
	$("#chatTab"+chatInd).css('font-weight','normal');
	$("#tabs-"+ind).css('display','block'); 
	$("#chatTab"+ind).css('font-weight','bold'); 
	chatInd=ind;
    if(ind == 0){
         clearInterval(intervalId0);
         intervalId0=0;
         $("#chatTab0").css("color","black")
    }
    if(ind == 1){
         clearInterval(intervalId1);
         intervalId1=0;
         $("#chatTab1").css("color","black")
    }
	if(ind == 4){
         clearInterval(intervalId4);
         intervalId4=0;
         $("#chatTab4").css("color","black")
    }
}


function openPage(page){
	$.ajax({
        type: "POST",
        url: "openpage/"+page,
        cache: false,
        //data: "loc="+loc+"&chatindc="+chatInd,
        success: function(html){
           $('#datablock').html(html);
        }
    });
}

/*Функции БОЯ*/

//Нападение на бота

function battleBot(){
	$.ajax({
        type: "POST",
        url: "battle/attackBot",
        cache: false,
        //data: "bot=1",
        success: function(html){
           $('#datablock').html(html);
        }
    });
}

function attackPers(){
    var attack = $("#name_attack").val();
    $.ajax({
        type: "POST",
        url: "battle/attack",
        cache: false,
        data: "attack="+attack,
        success: function(html){
            if(html=='err-1'){
                $('#err-msg').html('Напасть нелья. Цель в бою.');
            }else if(html=='err-2'){
                $('#err-msg').html('Напасть нелья. Цель не в игре.');
            }else if(html=='err-2'){
                $('#err-msg').html('Напасть нелья. У цели мало HP.');
            }else if(html=='err-2'){
                $('#err-msg').html('Напасть нелья. Вы в разных локах.');
            }else{
               $('#datablock').html(html);
           }
        }
    });
}

function makeBattle(){
    var team1 = $("#team1").val();
    var team2 = $("#team2").val();
    $.ajax({
        type: "POST",
        url: "battle/makeBattle",
        cache: false,
        data: "team1="+team1+"&team2="+team2,
        success: function(html){
           $('#datablock').html(html);
        }
    });
}

function exitBattle(){
    $.ajax({
        type: "POST",
        url: "battle/exitBattle",
        cache: false,
        success: function(html){
           $('#datablock').html(html);
        }
    });
}

//Удар противника
function attack(){
	var attack = $(":radio[name=atack]").filter(":checked").val();
	var zah = $(":radio[name=zah]").filter(":checked").val();
	var tact = $(":radio[name=tact]").filter(":checked").val();
	var enemy = $("#enemy").val();
	//$('#battleLog').html(attack+':'+zah+':'+tact);
	
	$.ajax({
        type: "POST",
        url: "battle",
        cache: false,
		//dataType: "json",
        data: "attack="+attack+"&zah="+zah+"&tact="+tact+"&enemy="+enemy,
        success: function(html){
            $('#datablock').html(html);
			/*var tt = $('#battleLog').html();
			$('#battleLog').html(obj.mess+tt);
			$('#plhp').css('width',obj.plhp+'%');
			$('#hpbot').css('width',obj.bothp+'%');
			$('#plhph').html(obj.plhpH);
			$('#bothph').html(obj.bothpH);
			$('#plhp').attr('title',obj.plhpH);
			$('#yronpl').html(obj.yron);
			
			if(obj.battend==1){
				$('#battlPanel').css('display','none');
				$('#goback').css('display','block');
			}*/
            //openPage('inv');
        }
    });
		
}

function updHp(){
	$.ajax({
        type: "POST",
        url: "main/updHp",
		dataType: "json",
        cache: false,
        success: function(obj){
           $('#hpPr').css('width',obj.hpPr+'%');
		   $('#plhph').html(obj.hp);	
           $('#plhphtop').html(obj.hp);
           if(obj.battle>0){
                openPage('battle');
           }	   
        }
    });
}


function putOn(id){
	$.ajax({
        type: "POST",
        url: "inv/putOn",
		dataType: "json",
        cache: false,
		data: "id="+id,
        success: function(obj){
            if(obj.res=='yes'){
                updHp();
				openPage('inv');
			}else{
				alert('В этом слоте одет предмет!')
			}
        }
    });
}

function removeItem(id){
	$.ajax({
        type: "POST",
        url: "inv/removeItem",
		dataType: "json",
        cache: false,
		data: "id="+id,
        success: function(obj){
            if(obj.res=='yes'){
                updHp();
				openPage('inv');
			}else{
				alert('Не снять')
			}
        }
    });
}

function paramAdd(param){
    $.ajax({
        type: "POST",
        url: "inv/paramAdd",
        cache: false,
        data: "param="+param,
        success: function(html){
            $('#datablock').html(html);
        }
    });
}

function shopShowShmot(cat){
    $.ajax({
        type: "POST",
        url: "shop",
        cache: false,
        data: "cat="+cat,
        success: function(html){
            $('#datablock').html(html);
        }
    });
}

function buyShmot(id){
    $.ajax({
        type: "POST",
        url: "shop/buyShmot",
        cache: false,
        data: "id="+id,
        success: function(html){
            if(html == 'err1'){
                $("#shopErr").html('Не хватает денег.');
            }else{
                $('#datablock').html(html);
            }
        }
    });
}