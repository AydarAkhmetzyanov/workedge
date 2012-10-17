  <div class="control-group" id="wallType" wallType="<?=CONTROLLER?>">
      <img style="margin-top:1px;" class="img-rounded" src="/data/avatar/1/small.jpg">
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
  
	<div id="wallPosts">
	
<blockquote id="1" class="pull-right onlineBorder row chatPost">
<div class="floatRight">
<div class="floatLeft">
<p><a href="/wall/3">Айдар Ахметзянов</a></p>
<small><i class="icon-trash pointer deletePost"></i> 20.11.1992</small>
</div>
<img class="img-rounded chatImgRight floatRight" src="/data/avatar/1/small.jpg">
</div>
<div>
<p class="postDesc floatRight">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно.
</p>
<table class="tablePostFiles floatRight table table-condensed table-bordered">
                
            </table>
</div>
</blockquote>

<blockquote id="1" class="pull-left offlineBorder row chatPost">
<div class="floatLeft">
<img class="floatLeft img-rounded chatImgLeft" src="/data/avatar/1/small.jpg">
<div class="floatRight">
<p>Айдар Ахметзянов</p>
<small>20.11.1992 <i class="icon-trash pointer"></i></small>
</div>
</div>
<div>
<p class="postDesc floatLeft">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно.
</p>
<table class="tablePostFiles floatLeft table table-condensed table-bordered">
              
            </table>
</div>
</blockquote>


    </div>
	<div><button id="loadMore" class="btn btn-large btn-block" data-loading-text="Загрузка..." type="button">Загрузить еще</button></div>