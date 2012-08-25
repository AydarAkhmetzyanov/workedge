<?php

class TaskList extends Model
{
	public static function getMainListJSON(){
	    if(($_POST['filterOwner']=='false')and($_POST['filterResponsible']=='false')and($_POST['filterMember']=='false')){ 
			return '0';
		} else {
		    global $db;
			if($_POST['filterCompete']=='true') { $filterCompete = '1';} else {$filterCompete = '0';}
			if(($_POST['filterOwner']=='true')and($_POST['filterResponsible']=='true')and($_POST['filterMember']=='true')){
			    $whereStatement = '';
			} else {
			    $whereStatement = ' AND main.`role` IN (';
				$argsw = array();
				if($_POST['filterOwner']=='true') array_push($argsw, "1");
				if($_POST['filterResponsible']=='true') array_push($argsw, "2");
				if($_POST['filterMember']=='true') array_push($argsw, "3");
				$whereStatement .= implode(",", $argsw);
				$whereStatement .= ' ) ';
			}
		    $query="
SELECT main.`taskId` ,main.`role` , main.`updated`,
task.`name` ,task.`status` ,
DATE(task.`timeDeadLine`) - DATE(task.`timeCreate`)  AS `difCD` , DATE(task.`timeDeadLine`) - DATE(NOW()) AS `difDN`, DATE(task.`timeDeadLine`) - DATE(task.`timeFinish`) AS `difDF` ,
uo.`firstName` AS `oFirstName`, uo.`secondName` AS `oSecondName`, uo.`id` AS `oId`, 
ur.`firstName` AS `rFirstName`, ur.`secondName` AS `rSecondName`, ur.`id` AS `rId` 
FROM  `taskmembership` main,  `tasks` task,  `users` uo,  `users` ur
WHERE main.`userId` = :userId
AND (main.`isDone` = $filterCompete OR main.`updated` = 1) 
$whereStatement
AND task.`id` =  `taskId` 
AND uo.`id` = ( 
SELECT uoi.`userId` 
FROM  `taskmembership` uoi
WHERE uoi.`taskId` = main.`taskId` 
AND uoi.`role` =1 ) 
AND ur.`id` = ( 
SELECT uri.`userId` 
FROM  `taskmembership` uri
WHERE uri.`taskId` = main.`taskId` 
AND uri.`role` =2 ) 
ORDER BY task.`timeDeadLine`
LIMIT 40";
		    $stmtTaskList = $db->prepare($query);
		    $stmtTaskList->execute( array('userId' => $_SESSION['id']) );
			if($stmtTaskList->rowCount()>0){
		        $stmtTaskList->setFetchMode(PDO::FETCH_ASSOC);
		        return json_encode($stmtTaskList->fetchAll());
			} else {
			    return '0';
			}
		}
	}
	
	public static function getUpdatedTasks(){
	    global $db;
		$query="
		SELECT DISTINCT `taskId` FROM `taskmembership` WHERE `updated` = 1 and `isDone`=0 and `userId`=:userId
		";
		$stmtTaskList = $db->prepare($query);
		$stmtTaskList->execute( array('userId' => $_SESSION['id']) );
		return $stmtTaskList->rowCount();
	}
	
	public static function getUncompleteTasks(){
	    global $db;
		$query="
		SELECT DISTINCT `taskId` FROM `taskmembership` WHERE `isDone`=0 and `userId`=:userId
		";
		$stmtTaskList = $db->prepare($query);
		$stmtTaskList->execute( array('userId' => $_SESSION['id']) );
		return $stmtTaskList->rowCount();
	}
	
}