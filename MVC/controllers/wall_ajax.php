<?php

class Wall_ajaxController extends Controller {
    
	public function loadCoWorkers(){
	    if(User::isAuth()){
		    echo User::getCoWorkersJSON();
		}
	}
	
	
}