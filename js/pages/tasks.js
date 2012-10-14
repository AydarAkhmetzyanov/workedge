$(document).ready(function() {
    $('#filterOwner').button('toggle');
	$('#filterResponsible').button('toggle');
	$('#filterMember').button('toggle');
	if($('.task').attr('iid') != "0"){
	    $('.task').attr('id',$('.task').attr('iid'));
	    $.post(
        "/tasks_ajax/loadTask",
        { 
		    id: $('.task').attr('id')
		},
        taskLoaded, 
        "text"
        );
	}
	loadTable();
});

function makeCompleted(taskInTable){
    if($(taskInTable).hasClass('makeDone')){
        $(taskInTable).children('i').toggleClass('icon-ok-sign');
		$(taskInTable).toggleClass('makeDone');
	}
}

function closeTask(){
    $('tr').removeClass('success');
    $(".task").hide();
    $("#taskList").removeClass("span6").addClass("span12");
}

function loadTable(){
    $('#tasksTable').hide();
	$.post(
        "/tasks_ajax/loadTable",
        { 
		filterOwner: $('#filterOwner').hasClass('active'),
		filterResponsible: $('#filterResponsible').hasClass('active'),
		filterMember: $('#filterMember').hasClass('active'),
		filterCompete: $('#filterCompete').hasClass('active') 
		},
        tableLoaded, 
        "text"  //html if errors
    );
}

function tableLoaded(data){
	if (data=='0'){
	    $('#tasksTable').parent().hide();
		$('#emptyAlert').show("slow");
	} else {
	    $('#emptyAlert').hide();
	    $('#tasksTable').parent().show();
        renderTasksTable(jQuery.parseJSON(data));
		$('#tasksTable').show("slow");
		$('tr#'+$('.task').attr('iid')).addClass('success');
		$('.showTask').click(function() {
		    if(!$(this).parent().hasClass('success')){
			    $(this).parent().removeClass('info');
				$('tr').removeClass('success');
				$(this).parent().addClass('success');
     	        $(".task").hide();
				$(".task").attr("id",$(this).parent().attr("id"));
			    $.post(
                    "/tasks_ajax/loadTask",
                    { 
		                id: $(this).parent().attr("id"),
		            },
                    taskLoaded, 
                    "text"
                );
			}
   	    });
	
		$('.makeDone').click(function() {
    	    if($(this).hasClass('makeDone')){
      	        $(this).children('i').toggleClass('icon-ok-sign');
			    $(this).toggleClass('makeDone');
				$(this).parent().children('#stat').html('');
		 	 	makeComplete($(this).parent().attr("id"));
	    	}
        });
	
	 	$('.makeDone').mouseover(function() {
         	if($(this).hasClass('makeDone')){
         	    $(this).children('i').toggleClass('icon-ok-circle'); 
		 		$(this).children('i').toggleClass('icon-check');
	   	 	}
    	});
	
	 	$('.makeDone').mouseout(function() {
            if($(this).hasClass('makeDone')){
                $(this).children('i').toggleClass('icon-ok-circle');
		    	$(this).children('i').toggleClass('icon-check');
	    	}
     	});
		
	}
	
}

function taskLoaded(data){
    renderTask(jQuery.parseJSON(data));
    $("#taskList").removeClass("span12").addClass("span6");
    $(".task").show("slow");
	location.hash='';
	location.hash='taskName';
}

function renderTasksTable(tasks){
    $("#tasksTable").html('');
	var appendhtml;
	$.each(tasks, function(key, value) {
	    appendhtml='<tr id="'+value.taskId;
		appendhtml+='" ';
		if(value.updated == '1'){
			    appendhtml+='class="info"';
   		}
		appendhtml+='><td ';
		if(value.status == '3'){
			appendhtml+='></td><td><i class="icon-ok-sign"></i>';
   		} else {
		    if(value.role == '3'){
			    appendhtml+='></td><td><i class="';
			} else {
			    appendhtml+='class="pointer makeDone"><i class="icon-ok-circle"></i></td><td id="stat"><i class="';
			}
			if(value.status == '1'){
			    appendhtml+='icon-time';
			} else {
			    appendhtml+='icon-play-circle';
			}
			appendhtml+='"></i>';
		}
	    appendhtml+='</td><td class="pointer showTask"><a>'+value.name+'</a></td><td><a href="/wall/'+value.oId+'">'+value.oFirstName+' '+value.oSecondName+'</a></td><td>';
		
		appendhtml+='<a href="/wall/'+value.rId+'">'+value.rFirstName+' '+value.rSecondName+'</a>';
		
		appendhtml+='</td><td><div class="progress ';
		var percent=100;
		var color;
		if(value.status=='3'){
		    if(value.difDF <= 0){
				color='progress-success';
			}else{
			    color='progress-danger';
			}
		} else {
		    if(value.difDN <= 0){
			    percent=(value.difCD-value.difDN)/value.difCD;
				percent*=100;
				if(percent>70){
				    color='progress-warning';
				}else{
				    color='';
				}
			}else{
			    percent=(value.difDN*(-1))/value.difCD;
				percent*=100;
				if(percent>99){
				    percent=100;
				}
				color='progress-danger';
			}
		}
		appendhtml+=color+'"><div class="bar" style="width: '+percent.toFixed()+'%;"></div></div></td></tr>';
		$("#tasksTable").append(appendhtml);
    });
}

function renderTask(task){
    switch(task.myRole)
    {
        case '1':
		    $("#taskToolBar").show();
			$("#taskOwnerToolBar").show();
        break;
        case '2':
            $("#taskToolBar").show();
			$("#taskOwnerToolBar").hide();
        break;
        case '3':
            $("#taskToolBar").hide();
			$("#taskOwnerToolBar").hide();
        break;
    }
    switch(task.task.status)
    {
        case '1':
			$('#changeTaskStatusToUncomplete').hide();
			$('#changeTaskStatus').show();
		    $('#taskStatus').html('<i class="icon-time"></i> Не рассмотрена');
        break;
        case '2':
		    $('#changeTaskStatusToUncomplete').hide();
			$('#changeTaskStatus').show();
            $('#taskStatus').html('<i class="icon-play-circle"></i> Активна');
        break;
        case '3':
		    $('#changeTaskStatusToUncomplete').show();
			$('#changeTaskStatus').hide();
            $('#taskStatus').html('<i class="icon-ok-sign"></i> Выполнена');
        break;
    }
    switch(task.task.linkType)
    {
        case '0':
		    $("#taskLinkTypeP").html('Компания');
		    $("#taskLink").html(task.taskLinkName.name);
			$("#taskLink").attr("href",'/company/'+task.task.link);
        break;
        case '1':
		    
			
        break;
    }
	$("#taskOwner").html(task.owner.firstName + ' ' +task.owner.secondName);
	$("#taskOwner").attr("href",'/wall/'+task.owner.userId);
	if(task.responsible.firstName==undefined){
	$("#taskResponsibeRow").hide();
	} else {
	$("#taskResponsibeRow").show();
	$("#taskResponsibe").html(task.responsible.firstName + ' ' +task.responsible.secondName);
	$("#taskResponsibe").attr("href",'/wall/'+task.responsible.userId);
	}
	if(task.task.description==''){
	    $("#descriptionWell").hide();
	} else {
	    $("#descriptionWell").show();
	    $("#taskDescription").html(task.task.description);
	}
	if(task.task.description==''){
	    $('descriptionWell').hide();
	} else {
	    $("#taskDescription").html(task.task.description);
		$('descriptionWell').show();
	}
	$("#taskName").html(task.task.name);
	$("#taskCreated").html(task.task.timeCreate);
	$("#taskDeadLine").html(task.task.timeDeadLine);
	$("#taskMembersList").html('');
	$.each(task.members, function(key, value) {
	    $("#taskMembersList").append('<tr><td></td><td><a href="/wall/'+value.userId+'">'+value.firstName+' '+value.secondName+'</a></td></tr>');
    });
	$('#deleteButton').removeAttr('disabled');
	updateWall(task.task.id);
}

function makeComplete(taskId){
    $.post("/tasks_ajax/makeComplete",{ taskId: taskId });
}

function makeUnComplete(taskId){
    $.post("/tasks_ajax/makeUnComplete",{ taskId: taskId });
}

function deleteTask(taskId){
    $('tr#'+$('.task').attr('id')).remove();
    $.post("/tasks_ajax/deleteTask",{ taskId: taskId });
}