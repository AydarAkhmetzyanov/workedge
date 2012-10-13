var engine = {

	posts : [],
	target : null,
	busy : false,
	count : 5,

	render : function(obj){
		var xhtml = '<div class="post" id=post_'+obj.id+'>';
		if (obj.title) {
			xhtml += '<h2>'+obj.title+'</h2>';
		}
		if (obj.posted_at) {
			xhtml += '<div class="posted_at">Posted on: '+obj.posted_at+'</div>';
		}
		if (obj.comments_count) {
			xhtml += '<div class="comments_count">Comments: ' + obj.comments_count + '</div>';
		}
		xhtml += '<div class="content">' + obj.content + '</div>';
		xhtml += '</div>';

		return xhtml;
	},

	init : function(posts, target){

		if (!target)
			return;

		this.target = $(target);

		this.append(posts);

		var that = this;
		$(window).scroll(function(){
			if ($(document).height() - $(window).height() <= $(window).scrollTop() + 50) {
				that.scrollPosition = $(window).scrollTop();
				that.get();
			}
		});
	},

	append : function(posts){
		posts = (posts instanceof Array) ? posts : [];
		this.posts = this.posts.concat(posts);

		for (var i=0, len = posts.length; i<len; i++) {
			this.target.append(this.render(posts[i]));
		}

		if (this.scrollPosition !== undefined && this.scrollPosition !== null) {
			$(window).scrollTop(this.scrollPosition);
		}
	},

	get : function() {

		if (!this.target || this.busy) return;

		if (this.posts && this.posts.length) {
			var lastId = this.posts[this.posts.length-1].id;
		} else {
			var lastId = 0;
		}

		this.setBusy(true);
		var that = this;

		$.getJSON('getposts.php', {count:this.count, last:lastId},
			function(data){
				if (data.length > 0) {
					that.append(data);
				}
				that.setBusy(false);
			}
		);
	},

	showLoading : function(bState){
		var loading = $('#loading');

		if (bState) {
			$(this.target).append(loading);
			loading.show('slow');
		} else {
			$('#loading').hide();
		}
	},

	setBusy : function(bState){
		this.showLoading(this.busy = bState);
	}
};

$(document).ready(function() {

    

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
		    alert('onComplete '+id+fileName+' '+JSON.stringify(responseJSON));
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
 
