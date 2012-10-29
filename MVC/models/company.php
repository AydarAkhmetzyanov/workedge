<?php

class Company extends Model
{

	public static function getCompany($id){
	    global $db;
		$stmt = $db->prepare("
					SELECT `companies`.`id`, `companies`.`description`,`companies`.`email`,`companies`.`phone`, `city`.`name` AS `city`
            	    FROM  `companies`
					INNER JOIN `city` ON `companies`.`city`=`city`.`city_id`
            	    WHERE  `companies`.`id` = :id
					LIMIT 1
				");
				$stmt->execute( array('id' => $id) );		
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt->fetch();
	}
	
}