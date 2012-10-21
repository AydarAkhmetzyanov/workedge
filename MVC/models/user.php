<?php

class User extends Model
{
	
	public static function logOut(){
	    unset($_SESSION['id']);
	}
	
	public static function isAuth(){
	    if(isset($_SESSION['id'])){
		    return true;
		} else {
		    return false;
		}
	}
	
	public static function getCoWorkersTypeHead(){
	    global $db;
	    $stmt = $db->prepare("
			SELECT  `users`.`id` ,  `users`.`firstName` ,  `users`.`secondName` ,  `companymembership`.`position` 
			FROM  `companymembership` 
			INNER JOIN  `users` ON  `companymembership`.`userId` =  `users`.`id` 
			WHERE  `companymembership`.`companyId` = :companyId AND NOT(`companymembership`.`userId`=:userId)
			ORDER BY `userId`
		");
		$stmt->execute( array('companyId' => $_SESSION['companyId'],'userId' => $_SESSION['id']) );
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}
	
	public static function getCoWorkersTypeHeadId(){
	    global $db;
	    $stmt = $db->prepare("
			SELECT  `companymembership`.`userId` 
			FROM  `companymembership`
			WHERE  `companymembership`.`companyId` = :companyId AND NOT(`companymembership`.`userId`=:userId)
			ORDER BY `userId`
		");
		$stmt->execute( array('companyId' => $_SESSION['companyId'],'userId' => $_SESSION['id']) );
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}
	

	public static function checkLoginData($email, $password){
	    global $db;
		$stmt = $db->prepare("SELECT id, md5, salt, firstName, secondName FROM users WHERE email = :email LIMIT 1");
        $stmt->execute( array('email' => $email) );
		if($stmt->rowCount()==1){
		    $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $table=$stmt->fetch();
            if (md5(md5($password).$table['salt']) == $table['md5']) {
                $arr = array('error' => 0, 'uid' => $table['id'], 'password' => $table['md5']);
				$_SESSION['id'] = $table['id'];
				$_SESSION['firstName'] = $table['firstName'];
				$_SESSION['secondName'] = $table['secondName'];
				$stmt = $db->prepare("
					SELECT  `companymembership`.`companyId`, `companymembership`.`position`  ,  `companymembership`.`access` ,  `companies`.`name`,`companies`.`plan`
            	    FROM  `companymembership` 
            	    INNER JOIN  `companies` ON  `companymembership`.`companyId` =  `companies`.`id` 
            	    WHERE  `companymembership`.`userId` = :userId
					ORDER BY `companymembership`.`access` DESC
				");
				$stmt->execute( array('userId' => $table['id']) );
				$_SESSION['companyMembershipCount'] = $stmt->rowCount();
				if($stmt->rowCount() > 0){
				    $stmt->setFetchMode(PDO::FETCH_ASSOC);
				    $table=$stmt->fetch();
				    $_SESSION['companyId'] = $table['companyId'];
					$_SESSION['access'] = $table['access'];
					$_SESSION['name'] = $table['name'];
					$_SESSION['maxAccess'] = $table['access'];
					$_SESSION['position'] = $table['position'];
					$_SESSION['plan'] = $table['plan'];
				} else {
				    $_SESSION['access'] = 0;
				}
            } else {
                $arr = array('error' => 2, 'uid' => 0, 'password' => 0);
            }
        }else{
            $arr = array('error' => 1, 'uid' => 0, 'password' => 0);
        }
		return $arr;
	}
	
	public static function getMembershipList(){
	    global $db;
		$stmt = $db->prepare("
				SELECT  `companymembership`.`companyId` , `companies`.`name` 
                FROM  `companymembership` 
                LEFT JOIN  `companies` ON  `companymembership`.`companyId` =  `companies`.`id` 
                WHERE  `companymembership`.`userId` = :userId
				ORDER BY `companymembership`.`access` DESC
				");
		$stmt->execute( array('userId' => $_SESSION['id']) );
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}
	
	public static function getUserForWall($uid){
	    global $db;
		$stmt = $db->prepare("
				SELECT `users`.`id`, `users`.`email`, `users`.`firstName`, `users`.`secondName`, `users`.`phoneM`, `users`.`emailStatus`, TIMESTAMPDIFF( MINUTE ,`users`.`lastAccessTime`,NOW()) AS `lastOnline` , `city`.`name` AS `city`, `users`.`education`, `users`.`about`, `users`.`work`,`country`.`name` AS `country`
				FROM `users` 
				JOIN `city`, `country`
				WHERE `users`.`id`= :uid and `users`.`city`=`city`.`city_id` and `city`.`country_id` = `country`.`country_id`
				");
		$stmt->execute( array('uid' => $uid) );
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$user=$stmt->fetch();
		return $user;
	}
	
	public static function updatePersonalSettings(){
	    global $db;
		$stmt = $db->prepare("
				UPDATE `users` 
				SET `phoneM`=:inputPhone,`education`=:inputEdu,`about`=:inputAbout,`work`=:inputWork 
				WHERE `id`=:id
				");
		$stmt->execute( array(
		    'id' => $_SESSION['id'],
		    'inputPhone' => htmlspecialchars($_POST['inputPhone']),
			'inputWork' => htmlspecialchars($_POST['inputWork']),
			'inputEdu' => htmlspecialchars($_POST['inputEdu']),
			'inputAbout' => htmlspecialchars($_POST['inputAbout'])
		) );
	}
	
	public static function updateAvatar(){
	    $result='';
	    if( (isset($_FILES["avatar"]["tmp_name"])) and (is_uploaded_file($_FILES["avatar"]["tmp_name"])) ){
				    if($_FILES["avatar"]["size"] > 1024*5*1024){
					    $result = 'Файл должен быть меньше 5 мегабайт';
					} else {
					    list($txt, $ext) = explode(".", $_FILES['avatar']['name']);
						$valid_formats = array('jpg', 'png', 'gif', 'jpeg');
						if(!in_array($ext,$valid_formats)){
						    $result = 'Фотография должна быть в формате jpg,png,jpeg или gif';
						} else {
						    $imageinfo = getimagesize ( $_FILES['avatar']['tmp_name'] );
							if($imageinfo["mime"] != "image/gif" && $imageinfo["mime"] != "image/jpeg" && $imageinfo["mime"] != "image/png") {
							    $result = 'Фотография должна быть в формате jpg,png или gif';
							} else {
							    $img = new AcResizeImage($_FILES['avatar']['tmp_name']);
                                $big = $img->cropSquare()->resize(250, 250)->save(ROOT.DS.'data'.DS.'avatar'.DS.$_SESSION['id'].DS, 'big', 'jpg', true, 100);
								$img = new AcResizeImage($_FILES['avatar']['tmp_name']);
                                $big = $img->cropSquare()->resize(48, 48)->save(ROOT.DS.'data'.DS.'avatar'.DS.$_SESSION['id'].DS, 'small', 'jpg', true, 100);
								$result = 0;
								echo '<script language="javascript">window.location.reload(true);</script>';
							}
						}
					}
				}
		return $result;		
	}
	
	public static function updateOnlineStatus(){
	    global $db;
		$stmt = $db->prepare("
				UPDATE `users` SET `lastAccessTime`=NOW() WHERE `id` = :uid
				");
		$stmt->execute( array('uid' => $_SESSION['id']) );
	}
	
	public static function getCoWorkersJSON(){
	    global $db;
		if((!isset($_POST['filterCompany']))or($_POST['filterCompany']=='0')){
		    $stmt = $db->prepare("
				SELECT cm.`userId` ,cm.`companyId`,cm.`position`,us.`firstName`,us.`secondName`,cs.`name`,TIMESTAMPDIFF( MINUTE ,us.`lastAccessTime`,NOW()) AS `lastOnline`
				FROM `companymembership` cm,`users` us,`companies` cs
				WHERE cm.`companyId` IN (SELECT DISTINCT sq.`companyId` FROM `companymembership` sq WHERE sq.`userId` = :uid) AND cm.`userId`=us.`id` AND cm.`companyId` = cs.`id` AND NOT cm.`userId`=:uid
				GROUP BY cm.`userId`
				ORDER BY cm.`companyId`,cm.`position`
				");
				$stmt->execute( array('uid' => $_POST['wallId']) );
		} else {
		    $stmt = $db->prepare("
				SELECT cm.`userId` ,cm.`companyId`,cm.`position`,us.`firstName`,us.`secondName`,cs.`name`,TIMESTAMPDIFF( MINUTE ,us.`lastAccessTime`,NOW()) AS `lastOnline`
				FROM `companymembership` cm,`users` us,`companies` cs
				WHERE cm.`companyId`=:cid AND cm.`userId`=us.`id` AND cm.`companyId` = cs.`id` AND NOT cm.`userId`=:uid
				GROUP BY cm.`userId`
				ORDER BY cm.`companyId`,cm.`position`
				");
		    $stmt->execute( array('cid' => $_POST['filterCompany'],'uid' => $_POST['wallId']) );  
		}
        if($stmt->rowCount()>0){
		    $stmt->setFetchMode(PDO::FETCH_ASSOC);
		    return json_encode($stmt->fetchAll());
		} else {
		    return "0";
		}	
	}
	
	
}