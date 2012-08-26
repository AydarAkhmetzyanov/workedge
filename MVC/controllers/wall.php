<?php

class WallController extends Controller {
    
	public function index($initWall = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
			Header::render();
			$data = array();
			$data['initWall']=$initWall;
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}