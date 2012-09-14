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
		filterCompany: $("#coWorkerFilterStatus").attr("cid") 
		},
        coWorkersLoaded, 
        "text"
    );
}

function coWorkersLoaded(data){
alert(data);
	if (data=='0'){
	    $('#tabCoWorkers').hide();
	    $('#emptyCoWorkersAlert').show("slow");
	} else {
        renderCoWorkers(jQuery.parseJSON(data));
		$('#tabCoWorkers').show("slow");
	    $('#emptyCoWorkersAlert').hide();
	}
}

function renderCoWorkers(coWorkers){
    $("#tabCoWorkers").html('');
	var appendhtml;
	var dubs=[];
	$.each(coWorkers, function(key, value) {
	    if(!in_array(value.taskId, dubs)){
		dubs.push(value.taskId);
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
    }});
	
}
