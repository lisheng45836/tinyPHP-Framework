<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base Model Database Connection
 */

abstract class Model
{
	protected static function getDB()
	{
			try{
				//$db= new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
				$dbInfo = 'mysql:host='.Config::DB_HOST. ';dbname='.Config::DB_NAME;
				$db = new PDO($dbInfo, Config::DB_USER,Config::DB_PASSWORD);
				$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

			}catch(PDOException $e){
				die("ERROR: ".$e->getMessage());
			}

		return $db;

		
	}
}
