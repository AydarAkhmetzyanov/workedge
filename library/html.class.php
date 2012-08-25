<?php

class HTML
{

    public static function includeJS($fileName) {
		$data = '<script src="'. APPDIR .'js/'.$fileName.'.js"></script>';
		return $data;
	}

	public static function includeCSS($fileName) {
		$data = '<link href="'. APPDIR .'css/'.$fileName.'.css" rel="stylesheet">';
		return $data;
	}
	
}