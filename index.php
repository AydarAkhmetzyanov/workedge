<?php

function timeMeasure()
{
    list($msec, $sec) = explode(chr(32), microtime());
    return ($sec+$msec);
}
define('TIMESTART', timeMeasure());

function getAppDir(){
$nurl = $_SERVER['PHP_SELF'];
$nurl = str_replace('index.php', '', $nurl);
return $nurl;
}

function getAppURLDir(){
    if((empty($_SERVER["HTTPS"])) or ($_SERVER["HTTPS"]=='off')) {
        $nurl = 'http://' . $_SERVER['HTTP_HOST'] . getAppDir();
		return $nurl;
    } else {
        $nurl = 'https://' . $_SERVER['HTTP_HOST'] . getAppDir();	    
		return $nurl;
    } 
}

define('APPDIR', getAppURLDir());
define('APPURLDIR', getAppURLDir());
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)));

require_once (ROOT . DS . 'config' . DS . 'main.php');
require_once (ROOT . DS . 'config' . DS . 'db.php');
require_once (ROOT . DS . 'core' . DS . 'bootstrap.php');

//echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';