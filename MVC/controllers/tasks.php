<?php

class TasksController extends Controller {
    
	public function index($initTask = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
			Header::render();
			$data = array();
			$data['initTask']=$initTask;
		    renderView('pages/tasks',$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}