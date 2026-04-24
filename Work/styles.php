<?php
//This is neeeded to get the mime type of the file correct
header("Content-type: text/css; charset: UTF-8");
$login = parse_ini_file('/var/www/html/MySQLlogin.ini');
$host = $login['host'];
$user = $login['user'];
$pwd = $login['pwd'];
$dbname = $login['dbname'];

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
	
	try {
		$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
		$conn = new PDO($dsn, $user, $pwd, $options);

		if ($conn) { }
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

$websettings = "SELECT * FROM websettings WHERE UID='STYLE12345'";
$webstmt = $conn->prepare($websettings);
$webstmt->execute();
$settingslist = $webstmt->fetchAll(PDO::FETCH_ASSOC);
foreach( $settingslist as $webset) {
	$HLcolor = $webset['HLcolor'];
	$fontstyle = $webset['fontstyle'];
}


?>

<style>

body { font-family: <?="$fontstyle"; ?>; }

.menu {
    background-color: black;
    font-family: <?="$fontstyle"; ?>;
    font-size: 16px;
    color: white;
    border-spacing: 0;
}

td {
    text-align: left;
    vertical-align: middle;
    word-wrap: break-word;
    padding: 3px;
    border-spacing: 0;
}

td.center
 { text-align: center; }

table { border-spacing: 0; }

h3 { font-family: <?="$fontstyle"; ?>; }

h4 { font-family: <?="$fontstyle"; ?>; }

p { 
    font-family: <?="$fontstyle"; ?>; 
    word-wrap: break-word;
}

div {
    font-family: <?="$fontstyle"; ?>; 
    word-wrap: break-word;
}
div.overview {
    word-wrap: break-word;
    display: inline-block;
    vertical-align: middle;
    max-width: 300px;
    min-width: 300px;
    min-height: 250px;
    margin: 10px;
    text-align: center;
    color: black;
    background-color: white;
}
div.overview:hover { box-shadow: 1px 1px 3px gray; }

div.search {
	display: block;
	padding-left: 30%;
}

div.post {
    font-family: <?="$fontstyle"; ?>;
    position: relative;

}
img {
    border-radius: 7px;
}
button{
    min-width: 50px;
    background-color: <?="$HLcolor"; ?>;
    padding: 5px;
    border-radius: 18px;
    border-color: <?="$HLcolor"; ?>;
    color: white;
    text-align: center;
    box-shadow: 0 0 0;
    border: none;
    font-family: <?="$fontstyle"; ?>;
}
button:hover { box-shadow: 1px 1px 3px gray; }

.buttontgthr {
    display: inline-block;
    margin-right: 20px;
}

.sameline {
	float:left;
}

input[type=submit]{
    min-width: 50px;
    background-color: <?="$HLcolor"; ?>;
    padding: 5px;
    border-radius: 18px;
    border-color: <?="$HLcolor"; ?>;
    color: white;
    text-align: center;
    box-shadow: 0 0 0;
    border: none;
    font-family: <?="$fontstyle"; ?>;
}

input[type=submit].view {
    position: absolute;
    vertical-align: bottom;
    bottom: 3px;
    right: 3px;
    font-family: <?="$fontstyle"; ?>;
    padding: 5px;
    background-color: black;
}

input[type=submit]:hover { box-shadow: 1px 1px 3px gray; }

input[type=submit].search {
    min-width: 70px;
    border-radius: 18px;
    padding: 5px;
    font-family: <?="$fontstyle"; ?>;
}

input[type=text].search{
    min-width: 500px;
    border-radius: 18px;
    border-style: solid;
    border-color: gray;
    padding-left: 15px;
    min-height: 30px;
    font-family: <?="$fontstyle"; ?>;

}

input[type=text].search:hover{
    border-color: <?="$HLcolor"; ?>;
}
input[type=text] {
    min-width: 350px;

}
input[type=password] {
    min-width: 350px;
}

select {
    min-width: 50px;
    background-color: <?="$HLcolor"; ?>;
    padding: 5px;
    border-radius: 18px;
    border-color: <?="$HLcolor"; ?>;
    color: white;
    text-align: center;
    box-shadow: 0 0 0;
    border: none;
    font-family: <?="$fontstyle"; ?>;
}

select.config {
	min-width: 50px;
    background-color: #dedede;
    padding: 5px;
    border-radius: 5px;
    border-color: <?="$HLcolor"; ?>;
    color: black;
    text-align: center;
    box-shadow: 0 0 0;
    border-style: solid;
    border-width: 2px;
    font-family: <?="$fontstyle"; ?>;

}

.title{
    color: black;
    font-family: <?="$fontstyle"; ?>;
    font-size: 22px;
    text-align: center;
}

/*
.title:hover{
     background-image: linear-gradient(#FFFFFF, #d8dbd5);
}
*/

.titlebar {
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100%;
    background-color: #FFFFFF;
    min-height: 50px;
    z-index: 1;
    vertical-align: middle;
    border-spacing: 0;
    box-shadow: 0px 0px 6px 4px darkgray;
    
}
.titlelink {
    color: black;
    text-decoration: none;
}

.dropdownlink:hover{
     background-image: linear-gradient(#FFFFFF, #d8dbd5);
}
     
.logoutdropdown {
    display: none;
    position: absolute;
    background-color: #FFFFFF;
    color: black;
    font-family: <?="$fontstyle"; ?>;
    font-size: 16px;
    min-width: 190px;
    border: 2px solid #c2c2c2;
    box-shadow: 0px 0px 5px 0px black;
    padding: 8px 8px;
    z-index: 2;
}
.menuoverflow:hover .logoutdropdown {
    display: block;
}

.titleimage{
    max-width: 100px;
    font-family: <?="$fontstyle"; ?>;
}

.bodypadding {
    padding-top: 50px;
}

.footer {
	color: black;
	background-color: white;
    font-family: <?="$fontstyle"; ?>;
    font-size: 18px;
    text-align: center;
    bottom: 0px;
    position: fixed;
    min-width: 100%
}

.giantinput {
    min-height: 250px;
    min-width: 800px;
    word-wrap: break-word;
    font-family: <?="$fontstyle"; ?>;
    font-size: 14px;
}

.postlink {
    word-wrap: break-word;
    overflow-wrap: break-word; 
    font-family: <?="$fontstyle"; ?>;
    font-size: 14px;
    border-radius: 2px;
    padding: 5px;
    border: 2px solid #c2c2c2;
    position: relative;
    min-height: 500px;
}

.ordersummary {
    word-wrap: break-word;
    overflow-wrap: break-word; 
    font-family: <?="$fontstyle"; ?>;
    font-size: 14px;
    border-radius: 2px;
    padding: 5px;
    border: 2px solid #c2c2c2;
    position: relative;
    min-height: 200px;
    margin-bottom: 20px;
}

.updateprod {
	position: absolute;
	bottom: 12px;
	right: 20px;
}
.addObject {
	position: absolute;
	bottom: 25px;
	right: 25px;
	max-width: 40px;

}

.barcode {
	position: absolute;
	bottom: 25px;
	right: 75px;
	

}

.center {
   padding: 25% 30px;
   text-align: center;
   color: black;
   font-size: 20px;
   font-family: <?="$fontstyle"; ?>;
   max-width: 50%;
}
.popupwindow {
    position: absolute;
    top: 100px;
    left: 20%;
    min-width: 50%;
    background-color: white;
    max-height: 500px;
    overflow: auto;
    z-index: 3;
    word-wrap: break-word;
    overflow-wrap: break-word; 
    font-family: <?="$fontstyle"; ?>;
    font-size: 14px;
    border-radius: 5px;
	padding: 10px;
	border: 2px solid #c2c2c2;
	box-shadow: 0px 0px 5px 0px black;
}
.closepopup {
	position: absolute;
	top: 6px;
	right: 6px;
	max-width: 10%;

}
.estPrice {
	position: absolute;
	top: 30px;
	right: 6px;
	color: #34567d;
	font-size: 18px;
}
.adminpanel {
	position: fixed;
	left: 1%;
	top: 40%;
	max-width: 11%;
	border: 2px solid #c2c2c2;
	background-color: <?="$HLcolor"; ?>;
	border-radius: 2px;
	padding: 12px;
	color: white;
}
.adminpanellink {
	color: white;
	text-decoration: none;
}
.homepageLogo {
	position: fixed;
	right: 15px;
	top: 15px;
	max-width: 200px;
}
.partnerbutton {
	position: fixed;
	right: 50px;
	bottom: 50px;
	width: 150px;
	z-index: 2;
	box-shadow: 0px 0px 5px 0px black;
}
.sidebarLeft {
	position: absolute;
	left: 0px;
	bottom: 0px;
	top: 0px;
	background: linear-gradient(#000000, #c2c2c2);
	width: 25%;
	display: inline-block; 
	z-index: 2;
}
.subtabletitle {
    color: black;
    font-family: <?="$fontstyle"; ?>;
    font-size: 18px;
    text-align: center;
    border: 2px solid #c2c2c2
}

.subtabletitle:hover {
     background-image: linear-gradient(#FFFFFF, #d8dbd5);
}
</style>
