<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
	<!--<script src="http://malsup.github.com/jquery.form.js"></script>-->
	
	<?php 
	$controllersWithWall = array('tasks', 'wall', 'company');
    if (in_array(CONTROLLER, $controllersWithWall)) {
        echo HTML::includeJS('fileuploader');
		echo HTML::includeJS('wall');
    }
	?>
	
	<?= HTML::includeJS('bootstrap.min');?>
	<?= HTML::includeJS('bootstrap-datepicker');?>
    <?= HTML::includeJS('main');?>
	<?= HTML::includeJS('addTask');?>
	<?= HTML::includeJS("pages/".CONTROLLER);?>
	
	<?= HTML::includeCSS('bootstrap.min');?>
	<?= HTML::includeCSS('bootstrap-responsive.min');?>
	<?= HTML::includeCSS('datepicker');?>
	<?= HTML::includeCSS('main');?>
	
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>