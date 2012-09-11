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
				if($stmt->rowCount() > 0){
				    $stmt->setFetchMode(PDO::FETCH_ASSOC);
				    $table=$stmt->fetch();
				    $_SESSION['companyId'] = $table['companyId'];
					$_SESSION['access'] = $table['access'];
					$_SESSION['name'] = $table['name'];
					$_SESSION['maxAccess'] = $table['access'];
					$_SESSION['position'] = $table['position'];
					$_SESSION['plan'] = $table['plan'];
					$_SESSION['companyMembershipCount'] = $stmt->rowCount();
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
	
}