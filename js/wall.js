var engine = {

	posts : [],
	target : null,
	busy : false,
	getURL : "target/child",

	render : function(obj){
	    var that = this;
		var xhtml = '';
		var objIsOnlineSting;
		var files=false;
		var filesString="";
		if(obj.lastOnline < 11){
		    objIsOnlineSting="online";
		} else {
		    objIsOnlineSting="offline";
		}
		if(obj.files!=''){
		    files=jQuery.parseJSON(obj.files);
			jQuery.each(files, function(fileId, fileName) {
                filesString+='<tr><td><i class="icon-file"></i></td><td><a target="_blank" href="/library_wall_ajax/getFile/'+that.getURL+'/'+fileId+'">'+fileName+'</a></td></tr>';
            });
		}
		if(obj.userId==$('.brand').attr('id')){
			xhtml+='<blockquote id="'+obj.id+'" class="pull-right '+objIsOnlineSting+'Border row chatPost">';
			xhtml+='<div class="floatRight">';
			xhtml+='<div class="floatLeft"><p><a href="/wall/'+obj.userId+'">'+obj.firstName+' '+obj.secondName+'</a></p>';
			xhtml+='<small><i class="icon-trash pointer deletePost"></i> '+obj.postTime+'</small></div>';
			xhtml+='<img class="img-rounded chatImgRight floatRight" src="/data/avatar/'+obj.userId+'/small.jpg"></div><div>';
			xhtml+='<p class="postDesc floatRight">'+obj.desc+'</p>';
			if(filesString!=""){ xhtml+='<table class="tablePostFiles floatRight table table-condensed table-bordered">'+filesString+'</table>'; }
			xhtml+='</div></blockquote>';
		} else {
		    xhtml+='<blockquote id="'+obj.id+'" class="pull-left '+objIsOnlineSting+'Border row chatPost">';
			xhtml+='<div class="floatLeft">';
			xhtml+='<img class="floatLeft img-rounded chatImgLeft" src="/data/avatar/'+obj.userId+'/small.jpg"><div class="floatRight"><p>'+'<a href="/wall/'+obj.userId+'">'+obj.firstName+' '+obj.secondName+'</a>'+'</p>';
			xhtml+='<small>'+obj.postTime+'</small></div></div><div>';
			xhtml+='<p class="postDesc floatLeft">'+obj.desc+'</p>';
			if(filesString!=""){ xhtml+='<table class="tablePostFiles floatLeft table table-condensed table-bordered">'+filesString+'</table>'; }
			xhtml+='</div></blockquote>';
		}
		return xhtml;
	},

	init : function(target, getURL){
        $('#loadMore').show();
		this.target = $(target);
        this.getURL = getURL;
		$("#wallPosts").html('');
		
		this.get();

		var that = this;
		$(window).scroll(function(){
			if ($(document).height() - $(window).height() <= $(window).scrollTop() + 50) {
				that.scrollPosition = $(window).scrollTop();
				that.get();
			}
		});
	},
	
	reInit : function(getURL){
        $('#loadMore').show();
		this.getURL = getURL;
		$("#wallPosts").html('');
		this.posts=[];
		this.showLoading(this.busy = false);
		this.get();
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
		var lastPostId=$('.chatPost').last().attr('id');
		if(lastPostId==undefined){lastPostId='0'};
		$.getJSON('/library_wall_ajax/getPostsJSON/'+this.getURL+'/'+lastPostId,
			function(data){
				if (data.length > 0) {
					that.append(data);
					that.setBusy(false);
				} else {
				    $('#loadMore').hide();
				}
			}
		);
	},

	showLoading : function(bState){
		if (bState) {
		    $('#loadMore').button('reset');
			$('#loadMore').button('loading');
		} else {
			$('#loadMore').button('reset');
		}
	},

	setBusy : function(bState){
		this.showLoading(this.busy = bState);
	}
};


var fileUploader;
var gchildId;
function updateWall(childId){
gchildId=childId;
if(fileUploader==undefined){
        engine.init($("#wallPosts"),$('#wallType').attr("wallType")+'/'+childId);
	
        fileUploader = new qq.FileUploaderBasic({
        action: '/library_wall_ajax/wallAddFile/'+$('#wallType').attr("wallType")+'/'+childId,
		autoUpload: false,
		sizeLimit: 20000000,
		button: document.getElementById('includeFile'),
		onSubmit: function(id, fileName) {
			var appendhtml;
			appendhtml='<tr class="attachment" id="'+id+'"><td><i class="icon-file"></i></td><td>';
			appendhtml+=fileName;
			appendhtml+='</td></tr>';
			$("#storedFiles").append(appendhtml);
		},
		onError: function(id, fileName, errorReason) { 
		    alert('onError '+errorReason+' '+fileName); 
		},
		onComplete: function(id, fileName, responseJSON) { 
		    //alert('onComplete '+id+fileName+' '+JSON.stringify(responseJSON));
			//add file to last post
			$('.attachment#'+id).remove();
			if($("#storedFiles").html()==''){
	            $('#sendMessage').button('toggle');
		        $('#includeFile').button('toggle');
				$(".postTextArea").attr("value","");
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
                '/library_wall_ajax/wallPost/'+$('#wallType').attr("wallType")+'/'+gchildId,
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
	//alert(data);//lastID returns
    //renderTaskPost();
	    if($("#storedFiles").html()==''){
	        $('#sendMessage').button('toggle');
		    $('#includeFile').button('toggle');
			$(".postTextArea").attr("value","");
	    } else {
            fileUploader.uploadStoredFiles();
	    }	
    }
	
} else {
    engine.reInit($('#wallType').attr("wallType")+'/'+childId);
    fileUploader.action='/library_wall_ajax/wallAddFile/'+$('#wallType').attr("wallType")+'/'+childId;
	fileUploader.clearStoredFiles();
	$(".postTextArea").attr("value","");
	$('#storedFiles').html('');
	//delete engine posts
	
	
}
};