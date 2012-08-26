<?php

class CompanyController extends Controller {
    
	public function index($companyId = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
			Header::render();
			$data = array();
			$data['companyId']=$companyId;
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}