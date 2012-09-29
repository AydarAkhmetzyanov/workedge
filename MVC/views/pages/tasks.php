<div class="container-fluid mainPage">
    <div class="row-fluid">
	   <div id="taskList" class="span12">
		<div class="btn-toolbar">
		<div class="btn-group" data-toggle="buttons-checkbox">
  <button id="filterOwner" onclick="$(this).toggleClass('active');loadTable();$(this).toggleClass('active');" class="btn btn-small">Я постановщик</button>
  <button id="filterResponsible" onclick="$(this).toggleClass('active');loadTable();$(this).toggleClass('active');" class="btn btn-small">Я ответственный</button>
  <button id="filterMember" onclick="$(this).toggleClass('active');loadTable();$(this).toggleClass('active');" class="btn btn-small">Я участник</button>
</div>
<div class="btn-group">
<button id="filterCompete" onclick="$(this).toggleClass('active');loadTable();$(this).toggleClass('active');" class="btn btn-small" data-toggle="button">Завершенные</button>
</div>
</div>
   <table class="table table-hover">
        <thead>
          <tr>
		    <th width="15px"></th>
			<th width="15px"></th>
            <th>Задача</th>
            <th>Постановщик</th>
			<th>Ответственный</th>
            <th>Время</th>
          </tr>
        </thead>
        <tbody id="tasksTable">
        
		</tbody>
      </table>
	  <div id="emptyAlert" style="display:none; " class="alert">
            <strong>Нет задач </strong> 
            <br />
              <a data-toggle="modal" href="#addTaskModal"> <i class="icon-plus"></i> Добавить задачу</a>
            
          </div>
       </div>
	   <div id="0" iid="<?=$initTask?>" class="span6 task" style="display:none;">
    <button onclick="closeTask();" class="close">&times;</button>
	<h2><span id="taskName"></span><br />
	<small>
	Создана: <span id="taskCreated"></span> Срок: <span id="taskDeadLine"></span>
	</small></h2>
	<div id="taskToolBar" class="btn-toolbar">
	<div class="btn-group"><button id="changeTaskStatus" onclick="makeComplete($('.task').attr('id')); $(this).hide(); $('#changeTaskStatusToUncomplete').show();" class="btn btn-success btn-small"><i class="icon-ok-circle"></i> Выполнено!</button></div>
	<div class="btn-group"><button id="changeTaskStatusToUncomplete" onclick="makeUnComplete($('.task').attr('id')); $(this).hide(); $('#changeTaskStatus').show();" class="btn btn-warning btn-small"><i class="icon-ok-sign"></i> Начать заново</button></div>
	<div class="btn-group" id="taskOwnerToolBar"><button style="display:none;" class="btn btn-warning btn-small"><i class="icon-pencil"></i> Изменить</button><button onclick="deleteTask($('.task').attr('id')); $(this).attr('disabled','disabled');" id="deleteButton" class="btn btn-small btn-danger"><i class="icon-trash"></i></button></div>
	</div>
  <table class="table table-bordered">
        <tbody>
		  <tr>
            <td>Статус</td>
            <td id="taskStatus"></td>
          </tr>
		  <tr>
            <td id="taskLinkTypeP">Связь</td>
            <td><a id="taskLink" href=""></a></td>
          </tr>
          <tr>
            <td>Создатель</td>
            <td><a id="taskOwner" href=""></a></td>
          </tr>
		  <tr id="taskResponsibeRow">
            <td>Ответственный</td>
            <td><a id="taskResponsibe" href=""></a></td>
          </tr>
		  </tbody>
		  <tbody id="taskMembersList">
		  
        </tbody>
      </table>
	  <div id="descriptionWell" class="well">
  <p id="taskDescription"></p>
  </div>
  
  
  
  
  <div class="">
      <img style="margin-top:1px;" class="img-rounded" src="/data/avatar/1/small.jpg">
      <textarea class="span10" rows="2"></textarea>
      <div style="margin-top:0px;" class="btn-toolbar">
              <div class="btn-group">
                <a class="btn btn-primary" onclick="$('#sendMessage').button('toggle');$('#includeFile').button('toggle');" id="sendMessage" href="#">Отправить</a>
                <a class="btn" id="includeFile" href="#"><i class="icon-file"></i><span id="taskFileUploadProgress"> 85%</span></a>
              </div>
            </div>
			<div id="file-uploader-list">
			<table class="table table-condensed">
              <tbody>
                <tr>
                  <td><i class="icon-file"></i></td>
                  <td>C:\Users\Aydar\Desktop\8.5\root\workedge\library</td>
				  <td><i class="icon-minus pointer"></i></td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td>C:\Users\Aydar\Desktop\8.5\root\workedge\library</td>
				  <td><i class="icon-minus pointer"></i></td>
                </tr>
				<tr>
                  <td><i class="icon-file"></i></td>
                  <td>C:\Users\Aydar\Desktop\8.5\root\workedge\library</td>
				  <td><i class="icon-minus pointer"></i></td>
                </tr>
              </tbody>
            </table>
			</div>
  </div> 
  
	<div class="" id="">
	

	<div class="row chatPost">
<blockquote class="pull-right onlineBorder">
<div style="float:left;">
<p style="width: 80%;float:right;">Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
</p>
<small>Айдар Ахметзянов</small>
</div>
<div style="float:right;">
<img class="img-rounded" src="/data/avatar/1/small.jpg">
</div>
</blockquote>
</div>




    </div>
  
       </div>
   </div>
</div>