$(document).ready(function() {
    $('.date').datepicker();
	
	$('#addTaskModal').on('shown', function () {
        $('#addTaskName').focus();
    })
	
});

function taskOptions(){
	if($('#addTaskOptions').is(':visible')){
		$('#addDescription').attr("value",'');
		$('.memberTask').remove();
	} else {
		
	}
	$('#addTaskOptions').toggle();
	$('#addDescription').focus();
}

function addMember(item){
    var appendhtml='<li class="memberTask" uId="'+$("#newMemberInput").attr("uId")+'"><i style="cursor: pointer;" onclick="$(this).parent().remove();" class="icon-minus"></i> '+item+'</li>';
    $("#memberList").append(appendhtml);
	$("#newMemberInput").attr("value",'');
	$("#newMemberInput").focus();
}

function addTaskSubmit(){
    var memberListArray = [];
	$('.memberTask').each(function(key, value) { 
	    memberListArray.push($(value).attr('uId'));
    });
	var memberListString=memberListArray.join(',');
    $.post(
        "/tasks_ajax/addTask",
        { 
		options: $('#addTaskOptions').is(':visible'),
		linkType: $('#addTaskLink').attr("linkType"),
		linkId: $('#addTaskLink').attr("linkId"),
		addTaskName: $('#addTaskName').attr("value"),
		addTaskResponsibleId: $('#addTaskResponsible').attr("uId"),
		addDeadLine: $('#addDeadLine').attr("value"),
		addDescription: $('#addDescription').attr("value"),
		memberList: memberListString
		},
        taskAdded,
        "text"
    );
	return false;
}

function taskAdded(rawData){
    var data=jQuery.parseJSON(rawData);
	var appendhtml='<tr><td><a href="/tasks/'+data.id+'">'+$('#addTaskName').attr("value")+'</a></td><td><a href="/wall/'+$('#addTaskResponsible').attr("uId")+'">'+$('#addTaskResponsible').attr("value")+'</a></td><td>'+$('#addDeadLine').attr("value")+'</td></tr>';
	$("#addedTasksTable").append(appendhtml);
	$("#addedTasksTableDiv").show();
	$('#addTaskName').attr("value",'');
	$("#addTaskName").focus();
}