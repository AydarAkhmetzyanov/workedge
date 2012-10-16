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
	
	public static function filePath($target, $fileId){
	    
		
	}
	
	public static function deletePost($target, $postId){
	    
	}
	
	public static function getPostsJSON($target, $child, $lastId = 0){
	    global $db;
		if($lastId==0){
		    $sql='SELECT main.`id`, main.`childId`, main.`postTime`, main.`userId`, main.`desc`, main.`files` , user.`firstName` , user.`secondName`, TIMESTAMPDIFF( MINUTE ,user.`lastAccessTime`,NOW()) AS `lastOnline` 
		    FROM `'.$target.'wallposts` main, `users` user 
		    WHERE user.`id`=main.`userId` AND main.`childId`=:childId ORDER BY main.`id` DESC LIMIT 10';
			$stmt = $db->prepare($sql);
		    $stmt->execute( array(
		    'childId' => $child
		    ));
		} else {
            $sql='SELECT main.`id`, main.`childId`, main.`postTime`, main.`userId`, main.`desc`, main.`files` , user.`firstName` , user.`secondName`
		    FROM `'.$target.'wallposts` main, `users` user 
		    WHERE user.`id`=main.`userId` AND main.`childId`=:childId AND main.`id`<:lastId ORDER BY main.`id` DESC LIMIT 10';
			$stmt = $db->prepare($sql);
		    $stmt->execute( array(
		    'childId' => $child,
			'lastId' => $lastId 
		    ));
		}
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return json_encode($stmt->fetchAll());
	}
	
	public static function addFile($target, $child, $fileName){
	    global $db;
		$sql='SELECT `id`, `files` FROM `'.$target.'wallposts` WHERE `childId`=:childId AND `userId`=:userId ORDER BY `id` DESC LIMIT 1';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'childId' => $child,
			'userId' => $_SESSION['id']
		));
		$wallPost = $stmt->fetch();
		$sql='INSERT INTO `'.$target.'wallfiles`(`childId`, `name`, `userId`) VALUES (:childId,:name,:userId)';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'childId' => $child,
			'name' => $fileName,
			'userId' => $_SESSION['id']
		));
		$fileId=$db->lastInsertId();
		$newFile = array($fileId => $fileName);
		if($wallPost['files'] == ''){
		    $files = $newFile;
		}else{
		    $files = json_decode($wallPost['files']);
			$newFileJSON=json_encode($newFile);
			$newFileObject=json_decode($newFileJSON);
			$files = array_merge((array)$files, (array)$newFileObject);
		}
		$sql='UPDATE `'.$target.'wallposts` SET `files`=:files WHERE `id`=:id';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'id' => $wallPost['id'],
			'files' => json_encode($files)
		));
	    return $fileId;
	}
	
}