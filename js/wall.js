$(document).ready(function() {
      	var fileUploader = new qq.FileUploaderBasic({
        action: '/'+$('#wallType').attr("wallType")+'_ajax/post',
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
		    alert('error '+errorReason+fileName); 
		},
		onComplete: function(id, fileName, responseJSON) { 
		    alert('success '+fileName+' '+JSON.stringify(responseJSON));
			
		}
    });
	
	$('#sendMessage').click(function() {
        fileUploader.uploadStoredFiles();
    });
	
	document.getElementById('includeFile').onclick = function() {
        fileUploader.clearStoredFiles();
		$("#storedFiles").html('');
    };

	
  });
 
 