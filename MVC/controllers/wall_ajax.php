<?php

class Tasks_ajaxController extends Controller {
    
	public function loadTable(){
	    if(User::isAuth()){
		    echo TaskList::getMainListJSON();
		}
	}
	
	public function loadTask(){
	    if(User::isAuth()){
		    echo Task::getJSON($_POST['id']);
		}
	}
	
	public function makeComplete(){
	    if(User::isAuth() and isset($_POST['taskId'])){
		    Task::makeComplete($_POST['taskId']);
		}
	}
	
	public function makeUnComplete(){
	    if(User::isAuth() and isset($_POST['taskId'])){
		    Task::makeUnComplete($_POST['taskId']);
		}
	}
	
	public function deleteTask(){
	    if(User::isAuth() and isset($_POST['taskId'])){
		    Task::deleteTask($_POST['taskId']);
		}
	}
	
	public function addTask(){
	    if(isset($_POST['options']) and 
		   isset($_POST['linkType']) and 
		   isset($_POST['linkId']) and 
		   isset($_POST['addTaskName']) and 
		   isset($_POST['addTaskResponsibleId']) and 
		   isset($_POST['addDeadLine']) and 
		   isset($_POST['addDescription']) and 
		   isset($_POST['memberList']) and 
		   ($_POST['options']!='') and
		   ($_POST['linkType']!='') and
		   ($_POST['addTaskName']!='') and
		   ($_POST['addTaskResponsibleId']!='') and
		   ($_POST['addDeadLine']!='')
		   )
		   {
	        if(User::isAuth()){
			    $arr = array('id' => Task::addTask(), 'post' => $_POST);       
		        echo json_encode($arr);
		    }
		}
	}
	
}