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
			if(isset($_POST['inputPassword']) and isset($_POST['passInputPass'])){ User::changePassword($_POST['inputPassword'],$_POST['passInputPass']); }
			if(isset($_POST['email']) and isset($_POST['passInputEmail']) and isset($_POST['send'])){ User::changeEmail($_POST['email'],$_POST['passInputEmail']); }
			if(isset($_POST['oldEmail']) and isset($_POST['passInputEmail']) and isset($_POST['reSend'])){ User::reSendEmailValidation($_POST['oldEmail'],$_POST['passInputEmail']); }
			
			Header::render();
			
			if($initWall==$_SESSION['id']){ $data['uploadError'] = User::updateAvatar(); }
			$data['user'] = User::getUserForWall($initWall);
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}
    
	
	
}