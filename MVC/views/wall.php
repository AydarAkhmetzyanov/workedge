  <?=HTML::includeJS('wall');?>
  <div class="control-group" id="wallType" wallType="<?=CONTROLLER?>" childId="93">
      <img style="margin-top:1px;" class="img-rounded" src="/data/avatar/1/small.jpg">
      <textarea required class="postTextArea info" rows="2"></textarea>
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
<blockquote class="pull-right onlineBorder row chatPost">
<div class="floatRight">
<div class="floatLeft">
<p>Айдар Ахметзянов</p>
<small><i class="icon-trash pointer"></i> 20.11.1992</small>
</div>
<div class="floatRight">
<img class="img-rounded chatImgRight" src="/data/avatar/1/small.jpg">
</div>
</div>
<div>
<p class="postDesc floatRight">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно.
</p>
<table class="tablePostFiles floatRight table table-condensed table-bordered">
              <tbody>
                <tr>
                  <td><i class="icon-file"></i></td>
                  <td>library.docx</td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td><a target="_blank" href="/123">presentation.pptx</a></td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td>presentationAlpha.pptx</td>
                </tr>
              </tbody>
            </table>
</div>
</blockquote>

<blockquote class="pull-left offlineBorder row chatPost">
<div class="floatLeft">
<div class="floatLeft">
<img class="img-rounded chatImgLeft" src="/data/avatar/1/small.jpg">
</div>
<div class="floatRight">
<p>Айдар Ахметзянов</p>
<small>20.11.1992 <i class="icon-trash pointer"></i></small>
</div>
</div>
<div>
<p class="postDesc floatLeft">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно.
</p>
<table class="tablePostFiles floatLeft table table-condensed table-bordered">
              <tbody>
                <tr>
                  <td><i class="icon-file"></i></td>
                  <td>library.docx</td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td><a target="_blank" href="/123">presentation.pptx</a></td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td>presentationAlpha.pptx</td>
                </tr>
              </tbody>
            </table>
</div>
</blockquote>


    </div>
	<div><button id="loadMore" class="btn btn-large btn-block" type="button">Загрузить еще...</button></div>