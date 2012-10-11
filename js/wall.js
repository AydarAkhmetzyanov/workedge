$(document).ready(function() {

    var engine = {
	    posts : [],
	    target : null,//wallPosts
	    busy : false,
	    count : 5
		
		
    }

    var fileUploader = new qq.FileUploaderBasic({
        action: '/library_wall_ajax/wallAddFile/'+$('#wallType').attr("wallType")+'/'+$('#wallType').attr("childId"),
		autoUpload: false,
		sizeLimit: 20000000,
		button: document.getElementById('includeFile'),
		onSubmit: function(id, fileName) {
			var appendhtml;
			appendhtml='<tr fId="'+id+'"><td><i class="icon-file"></i></td><td>';
			appendhtml+=fileName;
			appendhtml+='</td></tr>';
			$("#storedFiles").append(appendhtml);
		},
		onError: function(id, fileName, errorReason) { 
		    alert('onError '+errorReason+' '+fileName); 
		},
		onComplete: function(id, fileName, responseJSON) { 
		    alert('onComplete '+fileName+' '+JSON.stringify(responseJSON));
			//add file to last post
			//delete thisId stored file
			
			if($("#storedFiles").html()==''){
	            $('#sendMessage').button('toggle');
		        $('#includeFile').button('toggle');
	        }
		}
    });
	
	$('#includeFile').click(function() {
	    uploadCount=0;
        fileUploader.clearStoredFiles();
		$("#storedFiles").html('');
    });
	
	$('#sendMessage').click(function() {
	    if(!$('#sendMessage').hasClass('active')){
		    if($(".postTextArea").val().length != 0) {
		        $('#sendMessage').button('toggle');
				$('#includeFile').button('toggle');
			    $.post(
                '/library_wall_ajax/wallPost/'+$('#wallType').attr("wallType")+'/'+$('#wallType').attr("childId"),
                { 
		            postText: $(".postTextArea").attr("value"),
		        },
                postSent, 
                "text"
                );	
			} else {
				$(".postTextArea").focus();
			}
		}
        return false;		
    });

	function postSent(data){
	alert(data);
    //renderTaskPost();
	    if($("#storedFiles").html()==''){
	        $('#sendMessage').button('toggle');
		    $('#includeFile').button('toggle');
	    } else {
            fileUploader.uploadStoredFiles();
	    }	
    }
	
  });
 
