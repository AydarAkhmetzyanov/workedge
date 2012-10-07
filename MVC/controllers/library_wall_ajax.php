<?php

class Library_wall_ajaxController extends Controller {
    
	public function wallPost($target, $child){
	    if(isset($_POST['postText']) and ($_POST['postText']!='') and isset($target) and ($target!='') and isset($child) and ($child!='')){
	        if(User::isAuth()){
			    $valid_tables = array('tasks', 'wall');
				if(in_array($target,$valid_tables)){
			        echo Library_wall_posts::addPost($target, $child);
				}
		    }
		}
	}
	
	public function wallAddFile($target, $child){
	    if(isset($target) and ($target!='') and isset($child) and ($child!='')){
	        if(User::isAuth()){
			    echo json_encode($_FILES);
		    }
		}
	}
	
}