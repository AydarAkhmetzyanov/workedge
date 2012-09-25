<?php

class Task extends Model
{
	
	public static function makeComplete($taskId){
	    global $db;
		$stmt = $db->prepare('
			SELECT `role`,`isDone`
			FROM  `taskmembership` 
			WHERE  `taskId` = :taskId
			AND  `userId` = :userId
			LIMIT 1
		');
        $stmt->execute( array(
		    'taskId' => $taskId, 
		    'userId' => $_SESSION['id']
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		$myRole=$table['role'];
		if(($stmt->rowCount()==1)and($myRole!=3)){   
			$stmtupt = $db->prepare('
			    UPDATE `tasks` SET `timeFinish`=NOW() ,`status`=3 WHERE `id`=:taskId
			');
			$stmtupt->execute( array(
		        'taskId' => $taskId
		    ));
			$stmtupm = $db->prepare('
			    UPDATE `taskmembership` SET `updated`=1 ,`isDone`=1 WHERE `taskId`=:taskId
			');
			$stmtupm->execute( array(
		        'taskId' => $taskId
		    ));
			$stmtupm2 = $db->prepare('
			    UPDATE `taskmembership` SET `updated`=0 WHERE `taskId`=:taskId and `userId`=:userId
			');
			$stmtupm2->execute( array(
		        'taskId' => $taskId,
				'userId' => $_SESSION['id']
		    ));
			
		}
	}
	
	public static function makeUnComplete($taskId){
	    global $db;
		$stmt = $db->prepare('
			SELECT `role`
			FROM  `taskmembership` 
			WHERE  `taskId` = :taskId
			AND  `userId` = :userId
			LIMIT 1
		');
        $stmt->execute( array(
		    'taskId' => $taskId, 
		    'userId' => $_SESSION['id']
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		$myRole=$table['role'];
		if(($stmt->rowCount()==1)and($myRole!=3)){
		    $stmtupt = $db->prepare('
			    UPDATE `tasks` SET `status`=:status WHERE `id`=:taskId
		    ');
			$stmtupm = $db->prepare('
			    UPDATE `taskmembership` SET `updated`=1 ,`isDone`=0 WHERE `taskId`=:taskId
			');
			$stmtupm->execute( array(
		        'taskId' => $taskId
		    ));
		    if($myRole==1){ 
			    $stmtupt->execute( array(
		        'taskId' => $taskId,
				'status' => 1
		        ));

			} else {
			    $stmtupt->execute( array(
		        'taskId' => $taskId,
				'status' => 2
		        ));
                $stmtupm = $db->prepare('
			    UPDATE `taskmembership` SET `updated`=0 WHERE `taskId`=:taskId and `userId`=:userId
			    ');
			    $stmtupm->execute( array(
		        'taskId' => $taskId,
				'userId' => $_SESSION['id']
		        ));
			}
		}	
	}
	
	public static function deleteTask($taskId){
	    global $db;
		$stmt = $db->prepare('
			SELECT `role`
			FROM  `taskmembership` 
			WHERE  `taskId` = :taskId
			AND  `userId` = :userId
			LIMIT 1
		');
        $stmt->execute( array(
		    'taskId' => $taskId, 
		    'userId' => $_SESSION['id']
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		$myRole=$table['role'];
		if(($stmt->rowCount()==1)and($myRole==1)){   
		   $stmtupt = $db->prepare('
			    DELETE FROM `tasks` WHERE `id`=:taskId
			');
			$stmtupt->execute( array(
		        'taskId' => $taskId
		    ));
			$stmtupm = $db->prepare('
			    DELETE FROM `taskmembership` WHERE `taskId`=:taskId
			');
			$stmtupm->execute( array(
		        'taskId' => $taskId
		    ));
		}
	}
	
	public static function addTask(){
	    global $db;
		if($_POST['linkType']=='0'){
		    $linkId=$_SESSION['companyId'];
		} else {
		    $linkId=$_POST['linkId'];
		}
			$stmt = $db->prepare('
			    INSERT INTO `tasks`(`name`, `description`,`link`, `linkType`, `timeDeadLine`,`status`) 
			    VALUES (:name,:description,:link,:linkType,:timeDeadLine,:status)
		    ');
			$stmtMembership = $db->prepare('
			    INSERT INTO `taskmembership`(`taskId`, `userId`, `role`, `updated`, `isDone`) 
				VALUES (:taskId,:userId,:role,:updated,0)
		    ');
		    try{
			$db -> beginTransaction ();
				if($_SESSION['id']!=$_POST['addTaskResponsibleId']){
					$stmt->execute( array(
		            'name' => htmlspecialchars($_POST['addTaskName']),
				    'description' => htmlspecialchars($_POST['addDescription']),
				    'link' => $linkId,
				    'linkType' => $_POST['linkType'],
		            'timeDeadLine' => $_POST['addDeadLine'],
					'status' => 1
				    ));
				    $addId=$db->lastInsertId();
				    $stmtMembership->execute( array(
		            'taskId' => $addId,
				    'userId' => $_SESSION['id'],
					'role' => 1,
					'updated' => 0
				    ));
				    $stmtMembership->execute( array(
		            'taskId' => $addId,
				    'userId' => $_POST['addTaskResponsibleId'],
					'role' => 2,
					'updated' => 1
				    ));
				} else {
				    $stmt->execute( array(
		            'name' => htmlspecialchars($_POST['addTaskName']),
				    'description' => htmlspecialchars($_POST['addDescription']),
				    'link' => $linkId,
				    'linkType' => $_POST['linkType'],
		            'timeDeadLine' => $_POST['addDeadLine'],
					'status' => 2
				    ));
				    $addId=$db->lastInsertId();
				    $stmtMembership->execute( array(
		            'taskId' => $addId,
				    'userId' => $_SESSION['id'],
					'role' => 1,
					'updated' => 0
				    ));
				    $stmtMembership->execute( array(
		            'taskId' => $addId,
				    'userId' => $_POST['addTaskResponsibleId'],
					'role' => 2,
					'updated' => 0
				    ));
				}
				if(($_POST['options']=='true')and($_POST['memberList']!='')){
				    $members=array_unique(explode(',',$_POST['memberList']));
					foreach ($members as $val) {
					    $stmtMembership->execute( array(
		        	  	    'taskId' => $addId,
					 	    'userId' => $val,
							'role' => 3,
					        'updated' => 1
				        ));
                    }
				}  
            $db -> commit();				
            }
            catch ( Exception $e ){ 
                $db -> rollBack(); 
                echo $e -> getMessage (); 
             }
		return $addId;
	}
	
	public static function getJSON($taskId){
	    global $db;
		$stmt = $db->prepare('
			SELECT `role`,`updated`,`isDone`
			FROM  `taskmembership` 
			WHERE  `taskId` = :taskId
			AND  `userId` = :userId
			LIMIT 1
		');
        $stmt->execute( array(
		    'taskId' => $taskId, 
		    'userId' => $_SESSION['id']
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
        $table=$stmt->fetch();
		$result['myRole']=$table['role'];
		if($stmt->rowCount()==1){
			if($table['updated']=='1'){
			    $stmtup = $db->prepare('
				    UPDATE `taskmembership` SET `updated`=0 WHERE `taskId`=:taskId and `userId`=:userId
			    ');
				$stmtup->execute( array(
				    'taskId' => $taskId,
				    'userId' => $_SESSION['id']
				));
				if($table['role']=='2'){
				    if($table['isDone']=='0'){
				        $stmttup = $db->prepare('
				            UPDATE `tasks` SET `status`=2 WHERE `id`=:id
			            ');
					    $stmttup->execute( array(
				            'id' => $taskId
				        ));
					    $stmtup = $db->prepare('
				            UPDATE `taskmembership` SET `updated`=1 WHERE `taskId`=:taskId and NOT(`userId`=:userId)
			            ');
				        $stmtup->execute( array(
				            'taskId' => $taskId,
				           'userId' => $_SESSION['id']
				        ));
					}
				}
			}
		    $stmtMembers = $db->prepare('
				SELECT  `taskmembership`.`userId` ,  `users`.`firstName` ,  `users`.`secondName` 
				FROM  `taskmembership` 
				INNER JOIN  `users` ON  `taskmembership`.`userId` =  `users`.`id` 
				WHERE `taskmembership`.`taskId` = :taskId AND `role` = 3
			');
			$stmtMembers->execute( array('taskId' => $taskId) );
			$stmtMembers->setFetchMode(PDO::FETCH_ASSOC);
			$result['members']=$stmtMembers->fetchAll();
			$stmtOwner = $db->prepare('
				SELECT  `taskmembership`.`userId` ,  `users`.`firstName` ,  `users`.`secondName` 
				FROM  `taskmembership` 
				INNER JOIN  `users` ON  `taskmembership`.`userId` =  `users`.`id` 
				WHERE `taskmembership`.`taskId` = :taskId AND `role` = 1
			');
			$stmtOwner->execute( array('taskId' => $taskId) );
			$stmtOwner->setFetchMode(PDO::FETCH_ASSOC);
			$result['owner']=$stmtOwner->fetch();
			$stmtResponsible = $db->prepare('
				SELECT  `taskmembership`.`userId` ,  `users`.`firstName` ,  `users`.`secondName` 
				FROM  `taskmembership` 
				INNER JOIN  `users` ON  `taskmembership`.`userId` =  `users`.`id` 
				WHERE `taskmembership`.`taskId` = :taskId AND `role` = 2
			');
			$stmtResponsible->execute( array('taskId' => $taskId) );
			$stmtResponsible->setFetchMode(PDO::FETCH_ASSOC);
			$result['responsible']=$stmtResponsible->fetch();
			$stmtTask = $db->prepare('
				SELECT  `name` ,  `description` ,  `status` ,  `link` ,  `linkType` ,  DATE(`timeCreate`) AS `timeCreate` ,  DATE(`timeDeadLine`) AS `timeDeadLine`
				FROM  `tasks` 
				WHERE  `id` = :taskId 
				LIMIT 1
			');
			$stmtTask->execute( array('taskId' => $taskId) );
			$stmtTask->setFetchMode(PDO::FETCH_ASSOC);
			$result['task']=$stmtTask->fetch();
			if($result['task']['linkType']=="0"){
			    $stmtTaskL = $db->prepare('
				SELECT  `name`
				FROM  `companies` 
				WHERE  `id` = :link 
				LIMIT 1
			    ');
			    $stmtTaskL->execute( array('link' => $result['task']['link']) );
				$stmtTaskL->setFetchMode(PDO::FETCH_ASSOC);
			    $result['taskLinkName']=$stmtTaskL->fetch();
			}
			
			
			return json_encode($result);
		}
	}
	
}