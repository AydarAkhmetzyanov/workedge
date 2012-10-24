$(document).ready(function() {
	$(".coWorkerFilter").click(function() {
	    if($("#coWorkerFilterStatus").attr("cid") != $(this).attr("cid")){
		    $("#coWorkerFilterStatus").attr("cid",$(this).attr("cid"));
			$("#coWorkerFilterStatus").html($(this).html());
			$("#coWorkerFilterStatus").attr("href","/company/"+$(this).attr("cid"));
			if($(this).attr("cid")==0){
			    $("#coWorkerFilterStatus").removeClass("disabled").addClass("disabled");
			}else{
			    $("#coWorkerFilterStatus").removeClass("disabled");
			}
			loadCoWorkers();
		}
    });
	
	
	loadCoWorkers();
	updateWall($('#wallHeader').attr('wallid'));
});

function taskFromWall(){
    $('#addTaskResponsible').attr("uId",$('#wallHeader').attr("wallId"));
	$('#addTaskResponsible').attr("value",$('#wallHeader').html());
}

function loadCoWorkers(){
    $('#tabCoWorkers').hide();
	$.post(
        "/wall_ajax/loadCoWorkers",
        { 
		filterCompany: $("#coWorkerFilterStatus").attr("cid"),
		wallId: $('#wallHeader').attr("wallId")
		},
        coWorkersLoaded, 
        "text"
    );
}

function coWorkersLoaded(data){
dataObject=jQuery.parseJSON(data);
	if (data=='0'){
	    $('#tabCoWorkers').hide();
	    $('#emptyCoWorkersAlert').show("slow");
	} else {
        renderCoWorkers(dataObject);
		$('#tabCoWorkers').show("slow");
	    $('#emptyCoWorkersAlert').hide();
	}
}

function renderCoWorkers(coWorkers){
    $("#tabCoWorkers").html('');
	var appendhtml;
	$.each(coWorkers, function(key, value) {
	    appendhtml='<div class="row"><div style="float:left;"><a href="/wall/'+value.userId+'"><img style="margin-left:40px;" class="img-rounded" src="/data/avatar/'+value.userId;
		appendhtml+='/small.jpg"></a></div><div><blockquote class="pull-right ';
		if(value.lastOnline > 10){ 
		    appendhtml+='offline';
		} else {
		    appendhtml+='online';
		}
		appendhtml+='Border"><p><a href="/wall/'+value.userId+'">'+value.firstName+' '+value.secondName+'</a>';
		appendhtml+='</p><small>'+value.position+' <a href="/company/'+value.companyId+'">'+value.name+'</a></small></blockquote></div></div>';
		$("#tabCoWorkers").append(appendhtml);
    });
	
}

function checkPass(){
    $('#passCheckHelp').show('slow');
	var oldhash=$('#olddmd5').attr('value');
	var newhash=md5(md5(md5($('#checkdmd5').attr('value'))+$('#oldsalt').attr('value')));
	if(oldhash==newhash){
	    $('#passInputPass').attr('value',$('#checkdmd5').attr('value'))
		$('#passInputEmail').attr('value',$('#checkdmd5').attr('value'))
		$('#passCheckForm').hide();
		$('#pSettingsForms').show('slow');
	}
}

var lvl=1;
function checkNewPass(){
    if($('#inputPassword').attr('value').length > 5){
        lvl=checkPassStrength($('#inputPassword').attr('value'));
	} else {
	    lvl=1;
	}
	if(lvl>2){
	    $('#inputPasswordCG').addClass('success');
		$('#inputPasswordCG').removeClass('error');
	} else {
	    $('#inputPasswordCG').removeClass('success');
		$('#inputPasswordCG').addClass('error');
	}
	$('#inputPasswordHelp').html('Сложность пароля: '+lvl+'/5');
}

function checkNewPassConfirm(){
    if($('#inputPassword').attr('value')==$('#checkPassword').attr('value')){
	    $('#checkPasswordHelp').html('');
		$('#checkPasswordCG').addClass('success');
		$('#checkPasswordCG').removeClass('error');
	} else {
	    $('#checkPasswordHelp').html('Пароли не совпадают');
		$('#checkPasswordCG').removeClass('success');
		$('#checkPasswordCG').addClass('error');
	}
}

function passFormCheck(){
    if(lvl<3){
	    alert('Уровень сложности пароля должен быть больше двух');
		return false;
	} else {
	    if($('#inputPassword').attr('value')==$('#checkPassword').attr('value')){
		    alert('Пароль изменен');
		    return true;
		} else {
		    alert('Подтвердите ввод пароля');
		    return false;
		}
	}
    
}

function emailFormCheck(){
    if($('#inputEmail').attr('value')==$('#oldEmail').attr('value')){
	    alert('Email должен отличатся от предыдущего');
		return false;
	} else {
	    if(validateEmail($('#inputEmail').attr('value'))){
		    alert('На новую почту отправлено письмо с подтверждением');
		    return true;
		} else {
		    alert('Неверный формат email');
		    return false;
		}
	}
}