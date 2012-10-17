<?php

class WallController extends Controller {
    
	public function index($initWall = 0){
	    if(!(User::isAuth())){
		    redirect('login');
		} else {
			Header::render();
			$data = array();
			$data['MembershipList'] = User::getMembershipList();
			if($initWall==0){ $initWall=$_SESSION['id']; }
		    $data['initWall'] = $initWall;
			if($initWall==$_SESSION['id']){
			
			    if( (isset($_FILES["avatar"]["tmp_name"])) and (is_uploaded_file($_FILES["avatar"]["tmp_name"])) ){
				    if($_FILES["avatar"]["size"] > 1024*5*1024){
					    $data['uploadError'] = 'Файл должен быть меньше 5 мегабайт';
					} else {
					    list($txt, $ext) = explode(".", $_FILES['avatar']['name']);
						$valid_formats = array('jpg', 'png', 'gif', 'jpeg');
						if(!in_array($ext,$valid_formats)){
						    $data['uploadError'] = 'Фотография должна быть в формате jpg,png,jpeg или gif';
						} else {
						    $imageinfo = getimagesize ( $_FILES['avatar']['tmp_name'] );
							if($imageinfo["mime"] != "image/gif" && $imageinfo["mime"] != "image/jpeg" && $imageinfo["mime"] != "image/png") {
							    $data['uploadError'] = 'Фотография должна быть в формате jpg,png или gif';
							} else {
							    $img = new AcResizeImage($_FILES['avatar']['tmp_name']);
                                $big = $img->cropSquare()->resize(250, 250)->save(ROOT.DS.'data'.DS.'avatar'.DS.$_SESSION['id'].DS, 'big', 'jpg', true, 100);
								$img = new AcResizeImage($_FILES['avatar']['tmp_name']);
                                $big = $img->cropSquare()->resize(48, 48)->save(ROOT.DS.'data'.DS.'avatar'.DS.$_SESSION['id'].DS, 'small', 'jpg', true, 100);
								$data['uploadError'] = 0;
								echo '<script language="javascript">window.location.reload(true);</script>';
							}
						}
					}
				}
				
			}	
				
			$data['user'] = User::getUserForWall($initWall);
		    renderView('pages/'.CONTROLLER,$data);
		    renderView('footer');
			echo '<!--'.round(timeMeasure()-TIMESTART, 6).' sec. -->';
		}
	}

	
}