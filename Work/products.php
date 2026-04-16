<?php 
	include 'titlebar.php';
	//query all the products - still need to add a search bar
	if(isset($_POST['itemsearch'])){
		$searchitem = $_POST['searchitem'];
		$productquery = "SELECT * FROM products WHERE Name LIKE '%$searchitem%' OR Description LIKE '%$searchitem%'";
	}
	else { $productquery = 'SELECT * FROM products'; }
	$prodstmt = $conn->prepare($productquery);
	$prodstmt->execute();
	$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
	
	//saerch bar
	echo "<div class='search'><form method='post' action='".$_SERVER['PHP_SELF']."'>
		<input name='searchitem' type='text' class='search' placeholder='What are you looking for?'>  
		<input class='search' type='submit' value='SEARCH' name='itemsearch'></form></div>";
	
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
