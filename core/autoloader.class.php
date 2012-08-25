<?php

class Autoloader
{
    public static function loadLibrary($className)
    {
        if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		    require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
		}
    }
	
	public static function loadModel($className)
    {
        if (file_exists(ROOT . DS . 'MVC' . DS . 'models' . DS . strtolower($className) . '.php')) {
		    require_once(ROOT . DS . 'MVC' . DS . 'models' . DS . strtolower($className) . '.php');
		}
    }
	
}
