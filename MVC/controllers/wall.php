<?php

class WallController extends Controller {
    
	public function index($initWall = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
			Header::render();
			$data = array();
			
			if($initWall==0){ $initWall=$_SESSION['id']; }
		    $data['initWall'] = $initWall;
			$data['user'] = User::getUserByIdForWall($initWall);
			
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}