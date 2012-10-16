<?php

class Library_wall_ajaxController extends Controller {
    
	public function getFile($target, $child, $fileId){
	    if(User::isAuth()){
	        $file=Library_wall_posts::filePath($target, $fileId);
	        if (file_exists($file)) {
                if (ob_get_level()) {
                    ob_end_clean();
                }
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            }
		}
	}
	
	public function wallPost($target, $child){
	    if(isset($_POST['postText']) and ($_POST['postText']!='') and isset($target) and ($target!='') and isset($child) and ($child!='')){
	        if(User::isAuth()){
			    $valid_tables = array('tasks', 'wall');
				if(in_array($target,$valid_tables)){
			        echo Library_wall_posts::addPost($target, $child);
				}
		    }
		}
	}
	
	public function deletePost($target, $postId){
	    if(User::isAuth()){
		    echo Library_wall_posts::deletePost($target, $postId);
		}
	}
	
	public function getPostsJSON($target, $child, $lastId = 0){
	    if(User::isAuth()){
		    echo Library_wall_posts::getPostsJSON($target, $child, $lastId);
		}
	}
	
    public function wallAddFile($target, $child, $fileName='0'){
	    if(isset($target) and ($target!='') and isset($child) and ($child!='')){
	        if(User::isAuth()){
			    $allowedExtensions = array();
                $sizeLimit = 20 * 1024 * 1024;
			    $uploader = new Qqfileuploader($allowedExtensions, $sizeLimit, $fileName);
				$fileId = Library_wall_posts::addFile($target, $child, $uploader->getName());
				if($fileId!='0'){
				    $filesDirectory = ROOT.DS.'data'.DS.'files'.DS.$target.DS.$child;
				    if(!(is_dir($filesDirectory))){ mkdir($filesDirectory,0777,true); }
				    $uploader->handleUpload($filesDirectory.DS.$fileId.'.upload',true,true);
					$result = array('success'=> true, 'result'=> $fileId);
				} else {
				    $result = array('error'=> 'Could not save uploaded file. Model error.'.$target. $child. $uploader->getName());
				}
				echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		    }
		}
	}
	
}