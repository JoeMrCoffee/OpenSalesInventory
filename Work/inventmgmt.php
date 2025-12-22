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
				echo "<td>$iname</td><td>$iPrdMap</td><td>$iQty</td><td>$iAmount</td><td>$iArrival</td><td>$iShelflife</td><td>$iCost</td><td><button onclick='popupdisplay(\"$inid$iArrival\")'>Details</button></td></tr>";
				//Edit user pop-up
				echo "<div class='popupwindow' style='visibility: hidden;' id='$inid$iArrival'><img class='closepopup' onclick='popupdisplay(\"$inid$iArrival\")' src='close.png'>
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
			
		//Add an existing inventory item via barcode
		echo "<button class='barcode' onclick='popupdisplay(\"barcode\")'><img src='barcodeImagewhite.png' width='55px'></button>";
		//search result of the barcode
		if(isset($_POST['barcosrch'])){
			$barcosrch = $_POST['barcosrch'];
			$barcoquery = "SELECT * FROM inventory WHERE Barcode LIKE '%$barcosrch%'";
			$barcostmt = $conn->prepare($barcoquery);
			$barcostmt->execute();
			$itemlist = $barcostmt->fetchAll(PDO::FETCH_ASSOC);
			foreach( $itemlist as $barcoitem) {
				$barcoid = $barcoitem['UID'];
				$barconame = $barcoitem['Name'];
				$barcoPrdMap = $barcoitem['PrdtMapUID'];
				$barcoQty = $barcoitem['QtyPerBox'];
				$barcoAmt = $barcoitem['Amount'];
				$barcoShelfLife = $barcoitem['Shelflife'];
				$barcoArrivalDate = date('Y-m-d');
				$barcoCost = $barcoitem['Cost'];
				
			}
			echo "<div class='popupwindow' style='visibility: visible;' id='barresult'>
				<img class='closepopup' onclick='popupdisplay(\"barresult\")' src='close.png'><br>
				<form method='post' action='submit.php'>
				<input type='hidden' name='barcoid' value='$barcoid'>
				<input type='hidden' name='barcoAmt' value='$barcoAmt'>
				<input type='hidden' name='barCode' value='$barcosrch'>
				<p><strong>Inventory item:</strong> $barconame</p><input type='hidden' name='barconame' value='$barconame'>
				<p><strong>Mapping product:</strong> $barcoPrdMap</p><input type='hidden' name='pid' value='$barcoPrdMap'>
				<p><strong>Quantity per box:</strong> $barcoQty</p><input type='hidden' name='barcoQty' value='$barcoQty'>
				<p><strong>Shelf life:</strong> $barcoShelfLife</p><input type='hidden' name='barcoShelfLife' value='$barcoShelfLife'>
				<p><strong>Cost per box:</strong> $barcoCost</p><input type='hidden' name='barcoCost' value='$barcoCost'>
				<p><strong>Arrival date:</strong> <input type='date' name='barcoArrivalDate' value='$barcoArrivalDate'></p>
				<p><strong>Number to add:</strong> <input type='number' name='barconum'></p>
				<p><input type='submit' value='Add amount' name='inventBCinsert'></p></form></div>";
		}
		//Barcode search bar
		echo "<div class='popupwindow' style='visibility: hidden;' id='barcode'>
			<img class='closepopup' onclick='popupdisplay(\"barcode\")' src='close.png'><br>
			<p>If this inventory package item already exists, simply scan the barcode <br>to search for and add the quantity</p>
			<form method='post' action='".$_SERVER['PHP_SELF']."'>
			<input name='barcosrch' type='text' class='search' placeholder='Scan barcode to search'>  
			<input class='search' type='submit' value='SEARCH' ></form></div>";
		
		//Create a new inventory item
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
	
	//TO DO
	//Create a filter function to sum up all the inventory items and show them in different ways
	// Same name
	// Same barcode
	// Same arrival date
	// Sum the total amounts by same barcode
?>
