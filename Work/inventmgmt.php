<?php 
	include 'titlebar.php';
	if ($validity == "valid" && $userlvl == "admin") {
		$linecnt = 0;
		echo "<h3>Inventory management</h3>
			<div class='postlink'>
			<table width='100%' align='center'>
			<tr><th>Item</th><th>Product map</th><th>Qty per item</th><th>Current Amount</th><th>Arrival Date</th><th>Shelf life</th><th>Cost</th><th>Details</th></tr>";
			//Pre-fetch the product names and IDs
			$productquery = 'SELECT * FROM products';
			$prodstmt = $conn->prepare($productquery);
			$prodstmt->execute();
			//Fetch the product data
			$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
						
			//Inventory query
			$inventquery = 'SELECT * FROM inventory';
			$inventstmt = $conn->prepare($inventquery);
			$inventstmt->execute();
			//Fetch the product data
			$inventlist = $inventstmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($inventlist as $item){
				$inid = $item['UID'];
				$iname = $item['Name'];
				$iPrdMap = $item['PrdtMapUID'];
				$iBarcode = $item['Barcode'];
				$iQty = $item['QtyPerBox'];
				$iCost = $item['Cost'];
				$iShelflife = $item['Shelflife'];
				$iArrival = $item['ArrivalDate'];
				$iAmount = $item['Amount'];
				if ($linecnt % 2 == 0){
					echo "<tr style='background-color:#eaeaea;'>";
					$linecnt += 1;
				}
				else {
					echo "<tr>";
					$linecnt += 1;
				}
				echo "<td>$iname</td><td>$iPrdMap</td><td>$iQty</td><td>$iAmount</td><td>$iArrival</td><td>$iShelflife</td><td>$iCost</td><td><button onclick='popupdisplay(\"$inid\")'>Details</button></td></tr>";
				//Edit user pop-up
				echo "<div class='popupwindow' style='visibility: hidden;' id='$inid'><img class='closepopup' onclick='popupdisplay(\"$inid\")' src='close.png'>
					<form method='post' action='submit.php'>
					<input type='hidden' value='$inid' name='inid'>
					<p><strong>Package name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='iname' value='$iname'></p>
					<p><strong>Associated product: </strong><select name='pid'>
						<option value='$iPrdMap' selected>$iPrdMap</option>"; //Currently this doesn't match the visuals ID vs Name
				foreach($prodlist as $prod){
					$pname = $prod['Name'];
					$pid = $prod['UID'];
					echo "<option value='$pid'>$pname</option>";
				}
				echo "</select></p><p><strong>Barcode: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='ibarcode' value='$iBarcode'></p>
					<p><strong>Item quantity per box: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='iqty' value='$iQty'></p>
					<p><strong>Shelf life (days): </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='ishelf' value='$iShelflife'> days</p>
					<p><strong>Arrival date: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='date' name='iarrival' value='$iArrival'></p>
					<p><strong>Current amount: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='iamount' value='$iAmount'></p>
					<p><strong>Package cost: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='icost' step='0.01' value='$iCost'></p>
					<p><input type='submit' value='Update' name='inventUpdate'></form>
					<form method='post' action='submit.php' class='buttontgthr'><input type='hidden' value='$inid' name='inid'>&nbsp;&nbsp;&nbsp;
						<input type='submit' value='Delete' name='inventDelete' onclick='return confirmfunction()'>
					</form></p></div>";
			}
		//The below needs to be completely changed based on the inventory options above
		echo "<img src='addObject.png' class='addObject' onclick='popupdisplay(\"newprod\")'>
			<div class='popupwindow' style='visibility: hidden;' id='newprod'><img class='closepopup' onclick='popupdisplay(\"newprod\")' src='close.png'>
			<form method='post' action='submit.php'>
			<p><strong>Package name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='iname'></p>
			<p><strong>Associated product: </strong><select name='pid'>";
		foreach($prodlist as $prod){
			$pname = $prod['Name'];
			$pid = $prod['UID'];
			echo "<option value='$pid'>$pname</option>";
		}
		echo "</select></><p><strong>Barcode: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='ibarcode'></p>
			<p><strong>Item quantity per box: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='iqty'></p>
			<p><strong>Shelf life (days): </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='ishelf'> days</p>
			<p><strong>Arrival date: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='date' name='iarrival'></p>
			<p><strong>Current amount: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='iamount' ></p>
			<p><strong>Package cost: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' step='0.01' name='icost'></p>
			<p><input type='submit' value='Create new item' name='inventInsert'></form>
			</p></div>";
		echo "</table></div>";
		
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this inventory item?'); 	}
		</script>";
	
	include 'footer.php';
?>
