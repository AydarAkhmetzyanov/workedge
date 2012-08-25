<div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container-fluid">
		<div class="dropdown">
          <a class="brand dropdown-toggle" data-toggle="dropdown" href="#"><?=$_SESSION['name']?> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
		  <?php
		  while($row = $MembershipList->fetch()) {
		      echo '<li><a href="/company/'.$row['companyId'].'"> '.$row['name'] . '</a></li>';
			  }
			  ?>
              <li class="divider"></li>
			  <?php
			  if ($_SESSION['maxAccess']>199){
			  echo '<li><a href="/ownermanage"><i class="icon-th-list"></i> Аналитика</a></li>';
			  }
			  ?>
			  <?php
			  if ($_SESSION['access']>149){
			  echo '<li><a href="/manage"><i class="icon-cog"></i> Управление предприятием</a></li>';
			  }
			  ?>
            </ul>
			</div>
		  <ul class="nav">
  <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="<?=$menuIcon?>"></i> <?=$menuPage?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
				<li><a href="/coworkers"><i class="icon-user"></i> Сотрудники</a></li>
				<li><a href="/projects"><i class="icon-th-large"></i> Проекты</a></li>
				<li><a href="/supports"><i class="icon-th"></i> Поддержка</a></li>
				<li><a href="/contacts"><i class="icon-book"></i> Контакты</a></li>
              </ul>
            </li>
			<li class="divider-vertical"></li>
  <?=$menuActions?>
</ul>
          <div class="btn-group pull-right dropdown" style="margin-left:5px;">
            <a class="btn btn-small" href="/wall"><i class="icon-user"></i> <?=$_SESSION['firstName']?> <?=$_SESSION['secondName']?></a>
			<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/profile"><i class="icon-user"></i> Профиль</a></li>
              <li class="divider"></li>
              <li><a style="cursor: pointer;" onclick="logOut()"><i class="icon-off"></i> Выйти</a></li>
            </ul>
          </div>
		  <div class="btn-group pull-right">
            <a class="btn btn-small <?=$tasksButton?>" href="/tasks">
              <i class="icon-tasks"></i> <?=$activeTasks?>
            </a>
			<a class="btn btn-small <?=$tasksButton?>" data-toggle="modal" href="#addTaskModal"><i class="icon-plus"></i></a>
          </div>
		  <div class="btn-group pull-right">
            <a class="btn btn-small <? if($newMessages >0){ echo 'btn-success'; } else { echo ''; }?>" href="/messages">
              <i class="icon-envelope"></i> <?=$newMessages?>
            </a>
          </div>
        </div>
      </div>
    </div>