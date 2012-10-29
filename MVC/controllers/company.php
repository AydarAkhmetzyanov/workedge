<?php

class CompanyController extends Controller {
    
	public function index($companyId = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
		    $data = array();
			if($companyId==0){ 
			    $companyId=$_SESSION['companyId']; 
			} else {
			    if($companyId!=$_SESSION['companyId']){
				    User::changeCompany($companyId);
				}
			}
			
			
			$data['companyId']=$companyId;
			$data['company'] = Company::getCompany($companyId);
			
			Header::render();
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}