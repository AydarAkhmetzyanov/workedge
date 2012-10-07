<?php

class Library_wall_posts extends Model {
	
	public static function addPost($target, $child){
	    global $db;
		$sql='INSERT INTO `'.$target.'wallposts`(`childId`, `userId`, `desc`) VALUES (:childId,:userId,:desc)';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'childId' => $child,
			'userId' => $_SESSION['id'],
			'desc' => htmlspecialchars($_POST['postText'])
		));
		$addId=$db->lastInsertId();
		return $addId;
	}
	
	public static function getPostsJSON($target, $child){
	    
	}
	
	public static function addFile($target, $child){
	    
	}
	
}