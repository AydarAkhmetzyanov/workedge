<?php

class Login_ajaxController extends Controller {
    
	public function login(){
	    if(isset($_POST['email']) && isset($_POST['password'])){
		    $arr = User::checkLoginData($_POST['email'], $_POST['password']);
        } else {
            $arr = array('error' => 3, 'uid' => 0, 'password' => 0);       
        }
		echo json_encode($arr);
	}
	
	public function logOut(){
	    User::logOut();
	}
	
}