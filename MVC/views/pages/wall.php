<div class="container mainPage">
<div class="row">
<div class="span12">
          <div class="row">
		  <div class="span3"><br />
		      <img src="/data/avatar/<?=$initWall?>/big.jpg" class="img-rounded <?php if($initWall==$_SESSION['id']) echo 'pointer';?>" onclick="$('#avatarForm').show('slow');"><br /><br />
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
            <a class="btn btn-small disabled" id="coWorkerFilterStatus" cid="0" href="/company">Все сотрудники</a>
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
	<?php
  Wall::render();
  ?>
    </div>
		<?php
	if($user['id']==$_SESSION['id']){ ?>
	<div class="tab-pane" id="tabProfile">
	
	<form method="POST" class="form-horizontal">
	<legend>Персональная информация</legend>
  <div class="control-group">
    <label class="control-label" for="inputPhone">Контактный телефон</label>
    <div class="controls">
      <input type="text" name="inputPhone" id="inputPhone" placeholder="Телефон" value="<?=$user['phoneM']?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputWork">Сфера деятельности</label>
    <div class="controls">
      <textarea rows="2" name="inputWork" id="inputWork" placeholder="Прогрммирование, страхование, дизайн..."><?=$user['work']?></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputEdu">Образование</label>
    <div class="controls">
      <textarea rows="2" name="inputEdu" id="inputEdu" placeholder="Научная степень, знание языков..."><?=$user['education']?></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputAbout">О себе</label>
    <div class="controls">
      <textarea rows="2" name="inputAbout" id="inputAbout" placeholder="Люблю хорошие фильмы, спорт, горные лыжи..."><?=$user['about']?></textarea>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Сохранить изменения</button>
    </div>
  </div>
</form>
    </div>
	<div class="tab-pane" id="tabSettings">

	<form id="passCheckForm" class="form-horizontal">
	<legend>Для доступа введите ваш пароль</legend>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Пароль</label>
    <div class="controls">
	  <input type="hidden" id="olddmd5" value="<?=md5($user['md5'])?>">
	  <input type="hidden" id="oldsalt" value="<?=$user['salt']?>">
      <input type="password" onkeyup="checkPass()" id="checkdmd5" placeholder="" value="">
	  <span id="passCheckHelp" style="display:none;" class="help-inline">Пароль не верен</span>
    </div>
  </div>
</form>

	<div id="pSettingsForms" style="display:none;">
	
	<form method="POST" onSubmit="return emailFormCheck()" class="form-horizontal">
	<legend>Смена почты</legend>
  <div class="control-group <?php if($user['emailStatus']=='0') echo 'warning';?>">
    <label class="control-label" for="inputEmail">Адрес почты</label>
    <div class="controls">
	  <input type="hidden" name="oldEmail" id="oldEmail" value="<?=$user['email']?>">
	  <input type="hidden" name="passInputEmail" id="passInputEmail" value="">
      <input name="email" type="email" id="inputEmail" placeholder="имя@домен" value="<?=$user['email']?>">
	  <span class="help-inline"><?php if($user['emailStatus']=='0') echo 'Почта не проверена';?></span>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="send" class="btn btn-danger">Изменить почту</button>
	  <?php if($user['emailStatus']=='0') echo '<button type="submit" name="reSend" class="btn">Повторно отправить письмо проверки</button>';?>
    </div>
  </div>
</form>
	
	<form method="POST" onSubmit="return passFormCheck()"  class="form-horizontal">
	<input type="hidden" name="passInputPass" id="passInputPass" value="">
	<legend>Смена пароля</legend>
  <div id="inputPasswordCG" class="control-group">
    <label class="control-label" for="inputPassword">Новый пароль</label>
    <div class="controls">
      <input name="inputPassword" onkeyup="checkNewPass()" type="password" id="inputPassword" placeholder="" value="">
	  <span id="inputPasswordHelp" class="help-inline">Более 5 символов</span>
    </div>
  </div>
  <div id="checkPasswordCG" class="control-group">
    <label class="control-label" for="checkPassword">Повторите ввод</label>
    <div class="controls">
      <input type="password" onkeyup="checkNewPassConfirm()" id="checkPassword" placeholder="" value="">
	  <span id="checkPasswordHelp" class="help-inline">Пароли должны совпадать</span>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-danger">Изменить пароль</button>
    </div>
  </div>
</form>
	</div>
    </div>
	<?php } ?>
  </div>
		  </div>
		  
		  </div>
		  
        </div>
      </div>
</div>