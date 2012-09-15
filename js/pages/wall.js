$(document).ready(function() {
    
	$(".coWorkerFilter").click(function() {
	    if($("#coWorkerFilterStatus").attr("cid") != $(this).attr("cid")){
		    $("#coWorkerFilterStatus").attr("cid",$(this).attr("cid"));
			$("#coWorkerFilterStatus").html($(this).html());
			$("#coWorkerFilterStatus").attr("href","/company/"+$(this).attr("cid"));
			loadCoWorkers();
		}
    });
	
	
	loadCoWorkers();
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
	var dubs=[];
	$.each(coWorkers, function(key, value) {
	    if((!in_array(value.userId, dubs))&&(value.userId != $('#wallHeader').attr("wallId"))){
		dubs.push(value.userId);
	    appendhtml='<div class="row"><div style="float:left;"><img style="margin-left:40px;" class="img-rounded" src="/data/avatar/'+value.userId;
		appendhtml+='/small.jpg"></div><div><blockquote class="pull-right ';
		if(value.lastOnline > 10){ 
		    appendhtml+='offline';
		} else {
		    appendhtml+='online';
		}
		appendhtml+='Border"><p><a href="/wall/'+value.userId+'">'+value.firstName+' '+value.secondName;
		appendhtml+='</a></p><small>'+value.position+' <a href="/company/'+value.companyId+'">'+value.name+'</a></small></blockquote></div></div>';
		$("#tabCoWorkers").append(appendhtml);
    }});
	
}
