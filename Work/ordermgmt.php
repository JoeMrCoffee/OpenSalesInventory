<?php 
	include 'titlebar.php';
	if ($validity == "valid" && $userlvl == "admin") {
		//List past orders
		
		echo "<h3>Order management:</h3>
			<div class='postlink'><table width='100%'>
			<tr><th>Order number</th><th>User name</th><th>Product ID</th>
				<th>Amount</th><th>Value</th><th>Cost</th>
				<th>Order Date</th><th>Ship Date</th><th>Review</th></tr>";
		$oldorder = "SELECT * FROM orders ORDER BY 'UserUID', 'OrderDate' ASC";
		$oldorderstmt = $conn->prepare($oldorder);
		$oldorderstmt->execute();
		$oldorderlist = $oldorderstmt->fetchAll(PDO::FETCH_ASSOC);
		$ordcnt = 0;
		foreach( $oldorderlist as $orders){
			$orderid = $orders['UID'];
			$orderuid = $orders['UserUID'];
			$orderuser = $orders['Username'];
			$orderprod = $orders['PrdtMapUID'];
			$orderamt = $orders['Amount'];
			$orderval = $orders['Price'];
			$orderdate = $orders['OrderDate'];
			$ordership = $orders['ShippingDate'];
			$ordercost = $orders['Cost'];
			$orderprofit = $orderval - $ordercost;
			$ordermargin = round(($orderprofit/$orderval)*100, 2);
			if($ordership == null){ 
				$ordership = "Pending review"; 
				$orderreview = "<p>Confirm the order can be shipped and the shipment date.</p>
					<p>Order ID: $orderid</p>
					<p>Username: $orderuser</p>
					<p>User ID: $orderuid</p>
					<form method='post' action='viewproduct.php' target='_blank'>
					Product map: $orderprod <input type='hidden' value='$orderprod' name='pid'>
					<input type='submit' value='Details'></form>
					<p>Amount: $orderamt</p>
					<p>Profit: $ $orderprofit, Margin: $ordermargin%</p>
					<form method='post' action='submit.php' >
					<input type='hidden' value='$orderid' name='orderid'>
					<input type='hidden' value='$orderuser' name='username'>
					<input type='hidden' value='$orderuid' name='userid'>
					<input type='hidden' value='$orderamt' name='orderamt'>
					<input type='hidden' value='$orderprod' name='orderprod'>
					<input type='hidden' value='$orderval' name='orderprice'>
					<p>Shipment date: <input type='date' name='shipdate'>
					<input type='submit' value='Confirm shipment' name='updateOrder'></form></p>";
			}
			else { 
				$orderinvoice = $orders['Invoice'];
				$orderreview = "<div>Order already processed, invoice below: <br> $orderinvoice</div>";
			}
			//alternate the background color per row
			if ($ordcnt % 2 == 0){
				echo "<tr style='background-color:#eaeaea;'>";
				$ordcnt += 1;
			}
			else { 
				echo "<tr>";
				$ordcnt += 1;
			}
			echo "<td>$orderid</td>
				<td>$orderuser</td>
				<td>$orderprod</td>
				<td>$orderamt</td>
				<td>$orderval</td>
				<td>$ordercost</td>
				<td>$orderdate</td>
				<td>$ordership</td>
				<td><button onclick='popupdisplay(\"$orderid\")'>Review</button></td>
				<div class='popupwindow' style='visibility: hidden;' id='$orderid'>
				<img class='closepopup' onclick='popupdisplay(\"$orderid\")' src='close.png'>$orderreview</div>
				</tr>";
		}
		echo "</table></div>";
			
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this product?'); }
		</script>";
	
	include 'footer.php';
?>
