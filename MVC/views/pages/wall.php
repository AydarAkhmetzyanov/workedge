<div class="container mainPage">
<div class="row">
<div class="span12">
          <div class="row">
		  <div class="span3"><br />
		      <img src="/data/avatar/<?=$initWall?>/big.jpg" class="img-rounded">
		  </div>
		  <div class="span7">
    <h2><?=$user['firstName']?> <?=$user['secondName']?></h2>
  <dl class="dl-horizontal">
  <?php if($user['phoneM']!='') echo '<dt>Телефон</dt><dd>+7 (951) 066-51-33</dd>';?>
  <dt>E-mail</dt><dd>aydar@creatiestripe.ru</dd>
  <br />
  <dt>Город</dt><dd>Казань</dd>
  <dt>День рождения</dt><dd>20 ноября 1992</dd>
  <br />
  <dt>Образование</dt><dd><a>КГФЭИ Рынок Ценных Бумаг</a></dd>
  <dt>О себе</dt><dd style="max-width: 400px;">Занимаюсь бегом, катаюсь на велосипеде, сноуборде. Увлекаюсь всем свзяанным с IT, особенно облачными технологиями, веб программированием, нейронными сетями, сетевой безопасностью. CEO CreativeStripe.com WorkEdge.org</dd>
</dl>
		  </div>
		  <div class="span2"><br /><br />
		      <blockquote class="pull-right offlineBorder"><p>Offline</p></blockquote>
			  <blockquote class="pull-right"><p><a>Сообщение</a> <i class="icon-pencil"></i></p></blockquote>
			  <blockquote class="pull-right"><p><a>Задача</a> <i class="icon-tasks"></i></p></blockquote>
		  </div>
		  </div>
		  
		  <div class="row">
		  
		  <div class="span8">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tabWall" data-toggle="tab">Стена</a></li>
	<li class="pull-right"><a href="#tabProfile" data-toggle="tab"><i class="icon-user"></i></a></li>
	<li class="pull-right"><a href="#tabSettings" data-toggle="tab"><i class="icon-cog"></i></a></li>
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
		  <div class="span4">
    <ul class="nav nav-tabs">
	<li class="active pull-right"><a href="tabCoWorkers" data-toggle="tab">Сотрудники</a></li>
  </ul>
  <div class="tab-content">
 <div class="tab-pane active" id="tabCoWorkers">
	сотрудники
    </div>
  </div>
		  </div>
		  </div>
		  
        </div>
      </div>
</div>