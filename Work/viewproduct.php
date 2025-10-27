<?php 
	include 'titlebar.php';
	$pid = $_POST['pid'];

	//query all the products - still need to add a search bar
	$productquery = "SELECT * FROM products WHERE UID='$pid'";
	$prodstmt = $conn->prepare($productquery);
	$prodstmt->execute();
	$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
	//Display all of the products
	foreach($prodlist as $prod){
		$pname = $prod['Name'];
		$pdesc = $prod['Description'];
		$pimage = $prod['Images'];
		$pspecs = $prod['Specifications'];
		$pprice = $prod['Price'];
		echo "<h3>Product details</h3><div class='postlink'>
			<table width=100%><tr>";
		if($pimage != "none" && $pimage != null){ 
			echo "<td style='text-align: center;'><img src='$pimage' style='max-width: 100%;'></td>";
		}
		else { echo "<td></td>"; }
		echo "<td><h4>$pname</h4>
			<p><strong>Description:</strong><br>$pdesc</p>
			<p><strong>Price: </strong> $ $pprice</p></td>
			<tr><td colspan='2'><p><strong>Specifications:</strong><br>$pspecs</p></td></tr>
			</table></div><br>";

	}

	include 'footer.php';
?>
