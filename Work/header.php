<?php session_start();
	//DB credentials
	$login = parse_ini_file('/var/www/html/MySQLlogin.ini');
	$host = $login['host'];
	$user = $login['user'];
	$pwd = $login['pwd'];
	$dbname = $login['dbname'];
	//PDO connection
	//DSN stands for data source name, dbh should be db host
	//reference: https://www.phptutorial.net/php-pdo/php-pdo-mysql/
	//reference: https://stackoverflow.com/questions/2583707/can-i-create-a-database-using-pdo-in-php
	$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
	
	try {
		$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
		$conn = new PDO($dsn, $user, $pwd, $options);

		if ($conn) { }
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	
	//Create a table if it doesn't already exist
	$table = "products";
	$checktable = "SELECT 1 FROM {$table} LIMIT 1";
	$verifyerror = "";
	try { 
		$conn->query($checktable);
	} catch (Exception $e) {
		$verifyerror = $e;
		//print $verifyerror;
	}
	if ($verifyerror == null) { }
	else { 
		$create = ["CREATE TABLE `products` (
			`UID` varchar(20),
			`Name` varchar(200) DEFAULT NULL,
			`Images` text DEFAULT NULL,
			`Description` text DEFAULT NULL,
			`Specifications` text DEFAULT NULL,
			`Reviews` varchar(2) DEFAULT NULL,
			`Quantity` varchar(10) DEFAULT NULL,
			`Price` decimal(8,2) DEFAULT NULL,
			`Cost` decimal(8,2) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
			"CREATE TABLE `users` (
			`UID` varchar(20),
			`Name` varchar(200),
			`password` varchar(200),
			`email` varchar(200) DEFAULT NULL,
			`phonenumber` bigint(30) DEFAULT NULL,
			`usertype` varchar(10) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
			"CREATE TABLE `inventory` (
			`UID` varchar(20),
			`PrdtMapUID` varchar(20),
			`Barcode` varchar(200),
			`QtyPerBox` int(10) DEFAULT NULL,
			`Cost` decimal(10,2) DEFAULT NULL,
			`Shelflife` int(10) DEFAULT NULL,
			`ArrivalDate` date
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
		];
		foreach($create as $newtable){
			$conn->exec($newtable);
		}
		//create a default admin for first start
		$defaultadminpass = password_hash("admin123456", PASSWORD_DEFAULT);
		$defaultadmin = "INSERT INTO users (UID, Name, password, email, phonenumber, usertype) VALUES ('defaultadmin1234567', 'admin', '$defaultadminpass', 'default@admin.org', '3112345678', 'admin')";
		$defaultadminstmt = $conn->prepare($defaultadmin);
		$defaultadminstmt->execute();
	}
	//Common functions to call later:
	//clear out extra line breaks when editing a large text block that already used nl2br
	function br2nl($string) {
		$string = str_replace("<br />", "", $string);
		return $string;
	}
	
?>
<!DOCTYPE html>
<html>
<title>OpenSalesInventory</title>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<link rel="icon" href="favicon.png">

</head>

