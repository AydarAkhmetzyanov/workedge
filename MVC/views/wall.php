  <div class="control-group" id="wallType" wallType="<?=CONTROLLER?>">
      <img style="margin-top:1px;" class="img-rounded" src="/data/avatar/<?=$_SESSION['id']?>/small.jpg">
      <textarea required class="postTextArea info" rows="2" onkeypress="if(event.keyCode==10||(event.ctrlKey && event.keyCode==13))$('#sendMessage').click();"></textarea>
      <div style="margin-top:0px;" class="btn-toolbar">
              <div class="btn-group">
                <a class="btn btn-primary" id="sendMessage" href="#">Отправить</a>
                <a class="btn" id="includeFile" href="#"><i class="icon-file"></i></a>
              </div>
            </div>
			<div id="file-uploader-list">
			<table class="table table-condensed">
              <tbody id="storedFiles"></tbody>
            </table>
			</div>
  </div>
  
	<div id="wallPosts" style="display:none;"></div>
	<div><button id="loadMore" class="btn btn-large btn-block" data-loading-text="Загрузка..." type="button">Загрузить еще</button></div>