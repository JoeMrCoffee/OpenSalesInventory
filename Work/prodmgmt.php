<?php 
	include 'titlebar.php';
	if ($validity == "valid" && $userlvl == "admin") {
		$prodcnt = 0;
		echo "<h3>Product management</h3>
			<div class='postlink'>
			<table width='100%' align='center'>
			<tr><th>Name</th><th>Description</th><th>Price</th><th>Cost</th><th>Edit</th></tr>";
		
		$productquery = 'SELECT * FROM products';
		$prodstmt = $conn->prepare($productquery);
		$prodstmt->execute();
		//Fetch the user data and verify login
		$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($prodlist as $prod){
			$pname = $prod['Name'];
			$pdesc = br2nl($prod['Description']);
			$pquant = $prod['Quantity'];
			$pimage = $prod['Images'];
			$pid = $prod['UID'];
			$pspecs = br2nl($prod['Specifications']);
			$pprice = $prod['Price'];
			$pcost = $prod['Cost'];
			//This is a tripple escape '\" \"' <-- something interesting
			if ($prodcnt % 2 == 0){
				echo "<tr style='background-color:#eaeaea;'>";
				$prodcnt += 1;
			}
			else { 
				echo "<tr>";
				$prodcnt += 1;
			}
			echo "<td>$pname</td><td>$pdesc</td><td>$ $pprice</td><td>$ $pcost</td><td><button onclick='popupdisplay(\"$pid\")'>Edit</button></td></tr>";
			//Edit user pop-up
			echo "<div class='popupwindow' style='visibility: hidden;' id='$pid'><img class='closepopup' onclick='popupdisplay(\"$pid\")' src='close.png'>
				<form method='post' action='submit.php' enctype='multipart/form-data'>
				<input type='hidden' value='$pid' name='pid'>
				<p><strong>Product name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='pname' value='$pname'></p>
				<p><strong>Product image: </strong>&nbsp;&nbsp;<input type='file' name='pimage'>
					<br><br>Existing image: $pimage</p>
				<p><strong>Product description: </strong><br><br><textarea class='giantinput' name='pdesc'>$pdesc</textarea></p>
				<p><strong>Product specifications: </strong><br><br><textarea class='giantinput' name='pspecs'>$pspecs</textarea></p>
				<p><strong>Product price: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='pprice' value='$pprice'></p>
				<p><strong>Product cost: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='pcost' value='$pcost'></p>
				<p><input type='submit' value='Update' name='prodUpdate'></form>
				<form method='post' action='submit.php' class='buttontgthr'><input type='hidden' value='$pid' name='pid'>&nbsp;&nbsp;&nbsp;
					<input type='submit' value='Delete' name='prodDelete' onclick='return confirmfunction()'>
				</form>
				</p>
				</div>";
		}
		//This has an issue with an unknown reference - fixed with fixing the textareas
		echo "<img src='addObject.png' class='addObject' onclick='popupdisplay(\"newprod\")'>
			<div class='popupwindow' style='visibility: hidden;' id='newprod'><img class='closepopup' onclick='popupdisplay(\"newprod\")' src='close.png'>
			<form method='post' action='submit.php' enctype='multipart/form-data'>
			<p><strong>Product name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='pname'></p>
			<p><strong>Product image: </strong>&nbsp;&nbsp;<input type='file' name='pimage'></p>
			<p><strong>Product description: </strong><br><br><textarea class='giantinput' name='pdesc'></textarea></p>
			<p><strong>Product specifications: </strong><br><br><textarea class='giantinput' name='pspecs'></textarea></p>
			<p><strong>Product price: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='pprice'></p>
			<p><strong>Product cost: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='pcost' ></p>
			<p><input type='submit' value='Create' name='newProd'>
			</form></div>";
		echo "</table></div>";
		
		//<p><strong>Product description: </strong><br><br><textarea class='giantinput' name='pdesc'></p>
		//<p><strong>Product specifications: </strong><br><br><textarea class='giantinput' name='pspecs'></p>
		
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this product?'); 	}
		</script>";
	
	include 'footer.php';
?>
