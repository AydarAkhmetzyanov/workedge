<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

session_start();
header("Content-type: text/html; charset=utf-8");

define ('DEVELOPMENT_ENVIRONMENT',true);
define ('DEFAULT_CONTROLLER_PATH','login');
