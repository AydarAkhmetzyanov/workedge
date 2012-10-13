<?php

try {
//$creatives_siteDB = new PDO("mysql:host=localhost;dbname=creative2_panga", 'creative2_panga', 'pangapsw', 
$db = new PDO("mysql:host=db.workedge.org;dbname=workedge", 'workedge', 'workpsw',
  array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;"
  ));

}
catch(PDOException $e) { 
    echo $e->getMessage();
	exit();
}