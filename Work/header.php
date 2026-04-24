<?php session_start();
	//DB credentials
	//Note if this file path changes also need to update in styles.php and darkstyles.php
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
			`UID` varchar(100),
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
			`UID` varchar(100),
			`Name` varchar(200),
			`password` varchar(200),
			`email` varchar(200) DEFAULT NULL,
			`phonenumber` bigint(30) DEFAULT NULL,
			`usertype` varchar(10) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
			"CREATE TABLE `inventory` (
			`UID` varchar(100),
			`Name` varchar(100),
			`PrdtMapUID` varchar(100),
			`Barcode` varchar(200),
			`QtyPerBox` int(10) DEFAULT NULL,
			`Cost` decimal(10,2) DEFAULT NULL,
			`Shelflife` int(10) DEFAULT NULL,
			`ArrivalDate` date,
			`Amount` int(10) DEFAULT 0
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
			"CREATE TABLE `orders` (
			`UID` varchar(100),
			`Username` varchar(100),
			`UserUID` varchar(100),
			`PrdtMapUID` varchar(100),
			`Amount` int(10) DEFAULT 0,
			`Price` decimal(8,2) DEFAULT NULL,
			`Cost` decimal(8,2) DEFAULT NULL,
			`OrderDate` date,
			`ShippingDate` date DEFAULT NULL,
			`Invoice` text DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8",
			"CREATE TABLE `websettings` (
			`UID` varchar(12) DEFAULT 'Style12345',
			`Style` varchar(30) DEFAULT 'light',
			`HLcolor` varchar(30) DEFAULT '#2eabcc',
			`fontstyle` varchar(50) DEFAULT 'Sans-serif',
			`Sitename` varchar(30) DEFAULT 'Logo',
			`Sitelogo` text DEFAULT NULL,
			`CompanyName` varchar(100) DEFAULT NULL,
			`CompanyAddress` varchar(100) DEFAULT NULL,
			`CompanyPhone` varchar(100) DEFAULT NULL,
			`CompanyEmail` varchar(100) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8"
		];
		foreach($create as $newtable){
			$conn->exec($newtable);
		}
		//create a default admin for first start
		$defaultadminpass = password_hash("admin123456", PASSWORD_DEFAULT);
		$defaultadmin = "INSERT INTO users (UID, Name, password, email, phonenumber, usertype) VALUES ('defaultadmin1234567', 'admin', '$defaultadminpass', 'default@admin.org', '3112345678', 'admin')";
		$defaultadminstmt = $conn->prepare($defaultadmin);
		$defaultadminstmt->execute();
		
		$defaultwebsettings = "INSERT INTO websettings (UID, Style, HLcolor, Sitename, fontstyle) VALUES ('STYLE12345', 'light', '#2eabcc', 'Logo', 'Sans-serif')";
		$defaultwebstmt = $conn->prepare($defaultwebsettings);
		$defaultwebstmt->execute();
	}
	//Common functions to call later:
	//clear out extra line breaks when editing a large text block that already used nl2br
	function br2nl($string) {
		$string = str_replace("<br />", "", $string);
		return $string;
	}

	$websettings = "SELECT * FROM websettings WHERE UID='STYLE12345'";
	$webstmt = $conn->prepare($websettings);
	$webstmt->execute();
	$settingslist = $webstmt->fetchAll(PDO::FETCH_ASSOC);
	foreach( $settingslist as $webset) {
		$HLcolor = $webset['HLcolor'];
		$sitelogo = $webset['Sitelogo'];
		$sitename = $webset['Sitename'];
		$stylesheet = $webset['Style'];
		$fontstyle = $webset['fontstyle'];
		$CompanyName = $webset['CompanyName'];
		$CompanyAddress = $webset['CompanyAddress'];
		$CompanyPhone = $webset['CompanyPhone'];
		$CompanyEmail = $webset['CompanyEmail'];
	}
	
	if($stylesheet == 'light' || $stylesheet != 'dark'){ $styleref = "styles.php"; }
	elseif ($stylesheet == 'dark'){ $styleref = "darkstyles.php"; }
	
	echo "<!DOCTYPE html>
		<html>
		<title>OpenSalesInventory</title>
		<head>
		<meta charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='$styleref' />
		<link rel='icon' href='favicon.png'>
		</head>";
?>
