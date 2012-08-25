<?php

require_once (ROOT . DS . 'core' . DS . 'autoloader.class.php');
require_once (ROOT . DS . 'core' . DS . 'controller.class.php');
require_once (ROOT . DS . 'core' . DS . 'model.class.php');

spl_autoload_register(array('Autoloader', 'loadLibrary'));
spl_autoload_register(array('Autoloader', 'loadModel'));

function renderView($template_name, $_templateData=array()){
    if(stristr($template_name, '.php') === FALSE){
        $template_name=$template_name . '.php';
	}
	$template_name = ROOT . DS . 'MVC' . DS . 'views' . DS . $template_name;
	extract($_templateData, EXTR_OVERWRITE);
    if(file_exists($template_name)){
        require($template_name);
		return true;
	} else {
	    exit('View not found');
		return false;
	}
}

function redirect($target){
	$nurl = APPURLDIR . $target;
    header ("Location: $nurl");
}

function loadController($pathArray, $lastSegments){
	$realPath=implode(DS, $pathArray);
	require_once (ROOT . DS . 'MVC' . DS . 'controllers' . DS . strtolower($realPath) . '.php');
	define('CONTROLLER', end($pathArray));
    $controllerClassName = ucwords(CONTROLLER). 'Controller';
    $controllerObject = new $controllerClassName();
	$action='index';
	if(count($lastSegments)!=0){
	    if(method_exists($controllerObject, $lastSegments[0])){
			call_user_func_array(array($controllerObject, array_shift($lastSegments)),$lastSegments);
		} else {
		    call_user_func_array(array($controllerObject, $action),$lastSegments);
		}
	} else {
	    call_user_func_array(array($controllerObject, $action),$lastSegments);
	}
}

function route() {
	if (isset($_GET['url'])){
        $url = $_GET['url'];
		$urlArray = array();
	    $urlArray = explode("/", $url);
	    foreach($urlArray as $key => $segment){
            if (empty($segment)){
                unset($urlArray[$key]);
            }
        }
	    if (count($urlArray)==0){
	        loadController(explode("/",DEFAULT_CONTROLLER_PATH), array());
	    } else {
	        $controllerPath=$urlArray;
	    	$lastSegments=array();
	        while (!(file_exists(ROOT . DS . 'MVC' . DS . 'controllers' . DS . strtolower(implode(DS, $controllerPath)) . '.php')) and (count($controllerPath)!=0)){
	    	    $last=array_pop($controllerPath);
	    	    array_unshift($lastSegments, $last);
	    	}
		    if(count($controllerPath)==0){
		    	loadController(explode("/", DEFAULT_CONTROLLER_PATH), $lastSegments);
	    	} else {
	    		loadController($controllerPath, $lastSegments);
	    	}
	    }
    } else {
	    loadController(explode("/",DEFAULT_CONTROLLER_PATH), array());
	}
}

route();
