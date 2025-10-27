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
		$pspecs = $prod['Specifications']; //may add this later
		$pprice = $prod['Price'];
		echo "<h3>Product details</h3><div class='postlink'>";
		if($pimage != "none" && $pimage != null){ 
			echo "<div style='text-align: center;'><img src='$pimage' style='max-width: 50%;'></div>";
		}
		echo "<h4>$pname</h4>
			<p><strong>Description:</strong><br>$pdesc</p>
			<p><strong>Specifications:</strong><br>$pspecs</p>
			<p ><strong>Price: </strong> $ $pprice</p>
			</div>";

	}

	include 'footer.php';
?>
