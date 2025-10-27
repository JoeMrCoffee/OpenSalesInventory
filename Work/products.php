<?php 
	include 'titlebar.php';
	//query all the products - still need to add a search bar
	$productquery = 'SELECT * FROM products';
	$prodstmt = $conn->prepare($productquery);
	$prodstmt->execute();
	$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
	//Display all of the products
	foreach($prodlist as $prod){
		$pname = $prod['Name'];
		//$pdesc = br2nl($prod['Description']); 
		$pdesc = $prod['Description'];
		if (strlen($pdesc) >= 200 ){
			//handle posts with just a link exception
			$pdesc = substr($pdesc,0,200)." ...<br>";
		}
		$pimage = $prod['Images'];
		$pid = $prod['UID'];
		//$pspecs = br2nl($prod['Specifications']); //may add this later
		$pprice = $prod['Price'];
		echo "<div class='overview postlink'>";
		if($pimage != "none" && $pimage != null){ 
			echo "<div style='text-align: center;'><img src='$pimage' style='max-width: 100%;'></div>";
		}
		echo "<h4>$pname</h4>
			<p>$pdesc</p><div >Price: $ $pprice</div>
			<form method='post' action='viewproduct.php'>
			<input type='hidden' name='pid' value='$pid'>
			<input type='submit' name='viewproduct' value='Details' class='view'>
			</form></div>";

	}

	include 'footer.php';
?>
