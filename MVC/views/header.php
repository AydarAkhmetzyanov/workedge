<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
	<?= HTML::includeJS("pages/".CONTROLLER);?>
	<?= HTML::includeJS('bootstrap.min');?>
	<?= HTML::includeJS('bootstrap-datepicker');?>
	<?= HTML::includeJS('fileuploader');?>
    <?= HTML::includeJS('main');?>
	<?= HTML::includeJS('addTask');?>
	
	<?= HTML::includeCSS('bootstrap.min');?>
	<?= HTML::includeCSS('bootstrap-responsive.min');?>
	<?= HTML::includeCSS('datepicker');?>
	<?= HTML::includeCSS('main');?>
	
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>