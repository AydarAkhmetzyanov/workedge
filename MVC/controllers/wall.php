<?php

class WallController extends Controller {
	
	public function index($initWall = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
		    $data = array();
			$data['MembershipList'] = User::getMembershipList();
			if($initWall==0){ $initWall=$_SESSION['id']; }
		    $data['initWall'] = $initWall;	    
		    if(isset($_POST['inputPhone']) and isset($_POST['inputWork']) and isset($_POST['inputEdu']) and isset($_POST['inputAbout'])){ User::updatePersonalSettings(); }
			
			
			Header::render();
			
			if($initWall==$_SESSION['id']){ $data['uploadError'] = User::updateAvatar(); }
			$data['user'] = User::getUserForWall($initWall);
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}
    
	
	
}