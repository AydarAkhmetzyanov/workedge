$(document).ready(function() {
    
});

function taskFromWall(){
    alert($('#wallHeader').attr("wallId"));
    $('#addTaskResponsible').attr("uId",$('#wallHeader').attr("wallId"));
	$('#addTaskResponsible').attr("value",$('#wallHeader').html());
}