<?php
	include 'header.php';
	include 'validation.php';
	if($stylesheet == 'light' || $stylesheet != 'dark'){ 
		$menuoverflow = "menuoverflow.png"; 
		$shoppingcart = "shoppingcart.png";
		$close = "close.png";
	}
	elseif ($stylesheet == 'dark'){
		$menuoverflow = "menuoverflowlight.png"; 
		$shoppingcart = "shoppingcartlight.png";
		$close = "closelight.png";
	}
?>
<body>
<table class='titlebar' align='center' cellspacing='0px' width='100%'><tr>
<?php echo "	<td class='menuoverflow' width='30px'><img src='$menuoverflow' style='max-width: 30px;'>"; ?>
		<div class='logoutdropdown'>
		<a href='products.php' class='titlelink dropdownlink'>PRODUCTS</a><br>
		<a href='login.php' class='titlelink dropdownlink'>LOGIN</a><br>
<?php
	if ($validity == "valid") {
	echo "<br>--------------------------------<br>
        <a href='accountmgmt.php' class='titlelink dropdownlink'>ACCOUNT DETAILS</a><br>
        <a href='login.php' class='titlelink dropdownlink'>LOG OUT</a><br>";
    }
    if ($userlvl == "admin") {
	echo "<br>-----------ADMIN------------<br>
        <a href='usermgmt.php' class='titlelink dropdownlink'>USER MANAGEMENT</a><br>
        <a href='prodmgmt.php' class='titlelink dropdownlink'>PRODUCT MANAGEMENT</a><br>
        <a href='inventmgmt.php' class='titlelink dropdownlink'>INVENTORY MANAGEMENT</a><br>
        <a href='ordermgmt.php' class='titlelink dropdownlink'>ORDER MANAGEMENT</a><br>
        <a href='sitesettings.php' class='titlelink dropdownlink'>WEBSITE SETTINGS</a><br>";
    }
?>
	</div>
	</td>
	<td class='title' width='50px'>
	<?php if($sitelogo != null) { echo "<img class='titleimage' src='$sitelogo' >"; }
		echo "<td class='title'>$sitename</td>"; ?>
	</td>
	<td width='87%'></td>
<?php echo "	<td><a href='shoppingcart.php'><img src='$shoppingcart' style='max-width: 30px;' title='View shopping cart'></a></td>"; ?>
</tr></table><br><br><br>
<table width='72%' align='center' cellspacing='0' cellpadding='1'><tr><td>
