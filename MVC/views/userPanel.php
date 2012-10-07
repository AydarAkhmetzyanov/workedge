<div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <img class="panelAvatar img-rounded" src="/data/avatar/<?=$_SESSION['id']?>/small.jpg" />
		  <a class="brand" href="/wall"><?=$_SESSION['firstName']?> <?=$_SESSION['secondName']?></a>
		  <ul class="nav">
			
  <?=$menuActions?>
</ul>
            <div style="margin-left:5px;" class="btn-group pull-right">
            <a class="btn" onclick="logOut();" href="#">
              <i class="icon-off"></i></a>
          </div>
          <div class="btn-group pull-right dropdown" style="margin-left:5px;">
            <a class="btn" href="/company"><i class="icon-briefcase"></i> <?=$_SESSION['name']?></a>
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
			<ul class="dropdown-menu">
			<?php
			if($_SESSION['access']>=100){
			?>
			<li><a href="/coworkers"><i class="icon-user"></i> Сотрудники</a></li>
			<li><a href="/projects"><i class="icon-th-large"></i> Проекты</a></li>
			<li><a href="/supports"><i class="icon-th"></i> Поддержка</a></li>
			<li><a href="/contacts"><i class="icon-book"></i> Контакты</a></li>
			<?php
			}
			  if ($_SESSION['maxAccess']>199){
			  echo '<li class="divider"></li>';
			  echo '<li><a href="/ownermanage"><i class="icon-th-list"></i> Аналитика</a></li>';
			  }
			  echo '<li class="divider"></li><li class="nav-header">перейти в компанию</li>';
		      while($row = $MembershipList->fetch()) {
		      echo '<li><a href="/company/'.$row['companyId'].'"> '.$row['name'] . '</a></li>';
			  }
			  ?>
            </ul>
          </div>
		  <div class="btn-group pull-right">
            <a class="btn <?=$tasksButton?>" href="/tasks">
              <i class="icon-tasks"></i> <?=$activeTasks?>
            </a>
			<a class="btn <?=$tasksButton?>" data-toggle="modal" href="#addTaskModal"><i class="icon-plus"></i></a>
          </div>
		  <div style="display:none;" class="btn-group pull-right">
            <a class="btn <? if($newMessages >0){ echo 'btn-success'; } else { echo ''; }?>" href="/messages">
              <i class="icon-envelope"></i> <?=$newMessages?>
            </a>
          </div>
        </div>
      </div>
    </div>