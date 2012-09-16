<div class="container mainPage">
<div class="row">
<div class="span12">
          <div class="row">
		  <div class="span3"><br />
		      <img src="/data/avatar/<?=$initWall?>/big.jpg<?php if((isset($uploadError))and($uploadError==0)){ echo '?'.rand(1,100);}?>" class="img-rounded <?php if($initWall==$_SESSION['id']) echo 'pointer';?>" onclick="$('#avatarForm').show('slow');"><br /><br />
			  <?php
			  if((isset($uploadError))and($uploadError!=0)){
			  echo $uploadError;
			  }
			  ?>
			  <?php if($initWall==$_SESSION['id']){ 
			  ?>
			  <form style="display:none;" id="avatarForm" method="post" enctype="multipart/form-data">Загрузка фотографии
              <input onchange="document.forms['avatarForm'].submit();" type="file" name="avatar" id="avatarInput" />
			  </form>
			  <?php } ?>
		  </div>
		  <div class="span7">
    <h2 id="wallHeader" wallId="<?=$initWall?>"><?=$user['firstName']?> <?=$user['secondName']?></h2>
  <dl class="dl-horizontal">
  <?php if($user['phoneM']!='') echo "<dt>Телефон</dt><dd>".$user['phoneM']."</dd>";?>
  <dt>E-mail</dt><dd><?=$user['email']?></dd>
  <br />
  <dt>Страна</dt><dd><?=$user['country']?></dd>
  <dt>Город</dt><dd><?=$user['city']?></dd>
  <br />
  <?php if($user['work']!='') echo '<dt>Сфера работы</dt><dd>'.$user['work'].'</dd>';?>
  <?php if($user['education']!='') echo '<dt>Образование</dt><dd>'.$user['education'].'</dd>';?>
  <?php if($user['about']!='') echo '<dt>О себе</dt><dd>'.$user['about'].'</dd>';?>
</dl>
		  </div>
		  <div class="span2"><br /><br />
		      <?php
			  if($user['lastOnline']>10){
			      echo '<blockquote class="pull-right offlineBorder"><p>Offline</p></blockquote>';
			  } else {
			      echo '<blockquote class="pull-right onlineBorder"><p>Online</p></blockquote>';
			  }
			  ?>
			  <blockquote class="pull-right"><p><a>Сообщение</a> <i class="icon-pencil"></i></p></blockquote>
			  <blockquote class="pull-right"><p><a onclick="taskFromWall()" data-toggle="modal" href="#addTaskModal">Задача</a> <i class="icon-tasks"></i></p></blockquote>
		  </div>
		  </div>
		  
		  <br /><div class="row">
		  <div class="span5">
    <ul class="nav nav-tabs">
	
	<?php if($_SESSION['companyMembershipCount']>1){ ?>
	<li style="margin-top:4px;"><div class="btn-group pull-right dropdown" style="margin-left:5px;">
            <a class="btn btn-small" id="coWorkerFilterStatus" cid="0" href="/company/1">Все сотрудники</a>
			<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
			<ul class="dropdown-menu">
						<li><a class="coWorkerFilter" cid="0">Все сотрудники</a></li>
			<li class="divider"></li><li class="nav-header">Сотрудники компании</li>
			<?php
			while($row = $MembershipList->fetch()) {
		      echo '<li><a class="coWorkerFilter" cid="'.$row['companyId'].'"> '.$row['name'] . '</a></li>';
			  }
			  ?>
			</ul>
          </div></li>
		  <?php } ?>
		  
	<li class="active pull-right"><a href="tabCoWorkers" data-toggle="tab">Сотрудники</a></li>
  </ul>
  <div class="tab-content">
  <div id="emptyCoWorkersAlert" style="display:none; " class="alert">
            <strong>Нет сотрудников </strong> 
            <br />
			<p>Вы можете пригласить сотрудников на стене компании </p> 
              <a id="addCoWorkers" href="/company/"> <i class="icon-plus"></i> Добавить сотрудников</a>
            
          </div>
 <div class="tab-pane active" id="tabCoWorkers">
	<div class="row">
	<div style="float:left;"><img style="margin-left:40px;" class="img-rounded" src="/data/avatar/1/small.jpg"></div>
	<div><blockquote class="pull-right offlineBorder"><p>Ахметзянов Айдар</p><small>Генеральный директор <a>CreativeStripe</a></small></blockquote></div>
	</div>
	<div class="row">
	<div style="float:left;">
	<img style="margin-left:40px;" class="img-rounded" src="/data/avatar/1/small.jpg"></div>
	<div><blockquote class="pull-right offlineBorder"><p>Руслан Палатов</p>
<small>Операционный директор <a>CreativeStripe</a></small></blockquote></div>
	</div>
	<div class="row">
	<div style="float:left;">
	<img style="margin-left:40px;" class="img-rounded" src="/data/avatar/1/small.jpg"></div>
	<div><blockquote class="pull-right onlineBorder"><p>Дмитрий Алексеев</p>
<small>Временный работник <a>CreativeStripe</a></small></blockquote></div>
	</div>
    </div>
  </div>
		  </div>
		  <div class="span7">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tabWall" data-toggle="tab">Стена</a></li>
	<?php
	if($user['id']==$_SESSION['id']){ ?>
	<li class="pull-right"><a href="#tabSettings" data-toggle="tab"><i class="icon-cog"></i></a></li>
	<li class="pull-right"><a href="#tabProfile" data-toggle="tab"><i class="icon-user"></i></a></li>
	<?php } ?>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tabWall">
	<div class="row" style="
    margin-left: 0px;
">
<blockquote class="pull-right">
<p>Офигеть я создал задачу</p>
<small>Айдар Ахметзянов</small>
</blockquote></div>
<div class="row" style="
    margin-left: 0px;
"><blockquote>
<p>Тут так удобно)</p>
<small>Василий Нестеров</small>
</blockquote></div>
<div class="row" style="
    margin-left: 0px;
"><blockquote>
<p>Попробуйте создать задачу</p>
<small>Василий Нестеров</small>
</blockquote></div>
<div class="row" style="
    margin-left: 0px;
"><blockquote class="pull-right">
<p>Ну так</p>
<small>Руслан Палатов</small>
</blockquote></div>
<div class="row" style="
    margin-left: 0px;
"><blockquote>
<p>Пацаны вы тут сидите?</p>
<small>Айдар Ахметзянов</small>
</blockquote></div>
    </div>
	<div class="tab-pane" id="tabProfile">
      <p>tabProfile</p>
    </div>
	<div class="tab-pane" id="tabSettings">
      <p>tabSettings</p>
    </div>
  </div>
		  </div>
		  
		  </div>
		  
        </div>
      </div>
</div>