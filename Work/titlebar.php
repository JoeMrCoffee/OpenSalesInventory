<?php
	include 'header.php';
	include 'validation.php';
?>
<body>
<table class='titlebar' align='center' cellspacing='0px' width='100%'><tr>
	<td class='menuoverflow' style='max-width: 10%;'><img src='menuoverflow.png' style='max-width: 30px;'>
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
        <a href='inventmgmt.php' class='titlelink dropdownlink'>INVENTORY MANAGEMENT</a><br>";
    }
?>
	</div>
	</td>
	<td class='titleimage' width='100px'>LOGO</td>
	<td style='min-width: 87%;'></td>
	<td><img src='shoppingcart.png' style='max-width: 30px;' title='View shopping cart'></td>
</tr></table><br><br><br>
<table width='72%' align='center' cellspacing='0' cellpadding='1'><tr><td>
