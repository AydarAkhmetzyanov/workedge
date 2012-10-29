<div class="container mainPage">
<div class="row">
<div class="span12">
          <div class="row">
		  <div class="span6"><br />
		      <img src="/data/companylogo/<?=$companyId?>/big.jpg" class="img-rounded <?php if($_SESSION['access']>=150) echo 'pointer';?>" onclick="$('#companyLogoForm').show('slow');"><br /><br />
			  <?php
			  if((isset($uploadError))and($uploadError!=0)){
			  echo $uploadError;
			  }
			  if($_SESSION['access']>=150){ 
			  ?>
			  <form style="display:none;" id="companyLogoForm" method="post" enctype="multipart/form-data">Загрузка логотипа
              <input onchange="document.forms['avatarForm'].submit();" type="file" name="avatar" id="avatarInput" />
			  </form>
			  <?php } ?>
		  </div>
		  <div class="span6">
    <h2 id="companyHeader" companyId="<?=$_SESSION['companyId']?>"><?=$_SESSION['name']?></h2>
  <dl class="dl-horizontal">
  <?php if($company['description']!='') echo '<dt>О организации</dt><dd>'.$company['description'].'</dd>';?>
  <?php if($company['email']!='') echo '<dt>Email</dt><dd>'.$company['email'].'</dd>';?>
  <?php if($company['phone']!='') echo '<dt>Телефон</dt><dd>'.$company['phone'].'</dd>';?>
  <?php if($company['city']!='') echo '<dt>Город</dt><dd>'.$company['city'].'</dd>';?>
  <?php 
  if($_SESSION['access']>0){ 
      echo '<br /><dt>Ваша должность</dt><dd>'.$_SESSION['position'].'</dd>';
  }
  ?>
</dl>
		  </div>
		  </div>
		  <?php
		  if($_SESSION['access']>0){
		  ?>
		  <br /><div class="row">
		  <div class="span6">
		  <ul class="nav nav-tabs">
    <li class="active"><a href="#tabWall" data-toggle="tab">Сотрудники</a></li>
	<?php
	if($_SESSION['access']>=150){ ?>
	<li class="pull-right"><a href="#tabSettings" data-toggle="tab"><i class="icon-cog"></i></a></li>
	<li class="pull-right"><a href="#tabProfile" data-toggle="tab"><i class="icon-briefcase"></i></a></li>
	<?php } ?>
  </ul>
		  Сотрудники и управление
		  </div>
		  <div class="span6">
		  <ul class="nav nav-tabs">
    <li class="active"><a href="#tabWall" data-toggle="tab">Стена</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tabWall">
	<?php
  Wall::render();
  ?>
    </div>
  </div>
		  </div>
		  </div>
		  <?php
		  }
  ?>
		  
        </div>
      </div>
</div>