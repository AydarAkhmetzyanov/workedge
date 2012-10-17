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
	
	public static function fileName($target, $child, $fileId){
	    global $db;
		$sql='SELECT `name` FROM `'.$target.'wallfiles` WHERE `id`=:fileId';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'fileId' => $fileId 
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		return $table['name'];
	}
	
	public static function deletePost($target, $child, $postId){
		global $db;
		$sql='SELECT `id`,`files` FROM `'.$target.'wallposts` WHERE `userId`=:userId and `id`=:id';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'userId' => $_SESSION['id'],
			'id' => $postId 
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		if($table['files']!=''){
		    $sqlDeleteFile='DELETE FROM `'.$target.'wallfiles` WHERE `userId`=:userId and `id`=:id';
			$stmt = $db->prepare($sqlDeleteFile);
		    $files = json_decode($table['files']);
			foreach ($files as $key => $value){
			    echo $key.' '.$value;
				$stmt->execute( array(
		            'userId' => $_SESSION['id'],
			        'id' => $key 
		        ));
			    unlink(ROOT.DS.'data'.DS.'files'.DS.$target.DS.$child.DS.$key.'.upload');
			}
		}
		$sql='DELETE FROM `'.$target.'wallposts` WHERE `userId`=:userId and `id`=:id';
		$stmt = $db->prepare($sql);
		$stmt->execute( array(
		    'userId' => $_SESSION['id'],
			'id' => $postId 
		));
			
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
            $sql='SELECT main.`id`, main.`childId`, main.`postTime`, main.`userId`, main.`desc`, main.`files` , user.`firstName` , user.`secondName`, TIMESTAMPDIFF( MINUTE ,user.`lastAccessTime`,NOW()) AS `lastOnline` 
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