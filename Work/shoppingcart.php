<?php 
	include 'titlebar.php';
	if ($validity == "valid"){
		//some session variables already defined in validation.php
		//$loginuid;
		//$loginuser;
		//grab the existing shopping cart
		if(isset($_SESSION['shopcart'])){ $shopcart = $_SESSION['shopcart']; }
		else { $shopcart = []; }
		
		//need if as the shopping cart may not always be viewed while adding new items
		//grab the new items - 
		if(isset($_POST['pid'])){
			$pid = $_POST['pid'];
			$oamount = $_POST['oamount'];
			//add items to the shopping cart
			$shopcart[] = ['pid' => $pid, 'amount' => $oamount];
		}
		//print_r($shopcart);
		//Open orders section
		echo "<h3>Open orders: </h3>";
		$idcnt = 0; //create a unique ID value per shopcart item - used with the javascript function
		foreach($shopcart as $shopitem){
			echo "<div class='ordersummary'>
				<form method='post' action='put.php'> 
				<input type='hidden' name='userid' value='$loginuid'>
				<input type='hidden' name='username' value='$loginuser'>
				<input type='hidden' name='itemid' value='$idcnt'>";
			$pid = $shopitem['pid'];
			$oamount = $shopitem['amount'];
			$productquery = "SELECT * FROM products WHERE UID='$pid'";
			$prodstmt = $conn->prepare($productquery);
			$prodstmt->execute();
			$prodlist = $prodstmt->fetchAll(PDO::FETCH_ASSOC);
			foreach( $prodlist as $prod){
				$pname = $prod['Name'];
				$pdesc = $prod['Description'];
				$pprice = $prod['Price'];
			}
			$subtotal = $oamount*$pprice;
			//TO DO:
			// Javascript function isn't returing a value - done
			// Need to investigate - done
			// Need to add the POST receiver for the put.php page
			// Need to clear the session values
			// Need to add a historical order section in the shopping cart that
			// pulls from the database of orders - SELECT * FROM orders WHERE UserUID="" - 
			echo "
				<input type='hidden' name='pid' value='$pid'>
				<p>Product name: $pname</p><input type='hidden' name='pname' value='$pname'>
				<p>Description:<br>$pdesc</p>
				<p>Unit price: $pprice</p><input type='hidden' value='$pprice' id='".$pid."price' name='pprice'>
				<p>Order amount: <input type='number' name='oamount' id='".$idcnt."amt' value='$oamount' onchange='totalPrice($pprice,\"$idcnt\")'></p>
				<div><strong>Subtotal: <div class='buttontgthr' id='$idcnt'>$ $subtotal</div></strong></div><br>
				<p><input type='submit' value='Place order' name='placeorder' onclick='return confirmfunction()' name='newOrder'></p></form></div>";	
			$idcnt++;		
		}
		//update the session
		$_SESSION['shopcart'] = $shopcart;
		
		//List past orders
		
		echo "<h3>Past orders:</h3>
			<div class='postlink'><table width='100%'>
			<tr><th>Order number</th><th>Product ID</th><th>Amount</th><th>Value</th><th>Order Date</th><th>Status</th><th>Invoice</th></tr>";
		$oldorder = "SELECT * FROM orders WHERE UserUID='$loginuid' ORDER BY 'OrderDate'";
		$oldorderstmt = $conn->prepare($oldorder);
		$oldorderstmt->execute();
		$oldorderlist = $oldorderstmt->fetchAll(PDO::FETCH_ASSOC);
		$ordcnt = 0;
		foreach( $oldorderlist as $orders){
			$orderid = $orders['UID'];
			$orderprod = $orders['PrdtMapUID'];
			$orderamt = $orders['Amount'];
			$orderval = $orders['Price'];
			$orderdate = $orders['OrderDate'];
			$ordership = $orders['ShippingDate'];
			$orderinvoice = $orders['Invoice'];
			if($ordership == null){ 
				$ordership = "Pending review"; 
				$orderinvoice = "Will be issued once this order is shipped. Thank you for your patience.";
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
				<td>$orderprod</td>
				<td>$orderamt</td>
				<td>$orderval</td>
				<td>$orderdate</td>
				<td>$ordership</td>
				<td><button onclick='popupdisplay(\"$orderid\")'>Invoice</button></td></tr>";
			echo "<div class='popupwindow' style='visibility: hidden;' id='$orderid'>
				<img class='closepopup' onclick='popupdisplay(\"$orderid\")' src='close.png'><p>$orderinvoice</p></div>";
		}
		echo "</table></div>";
		
	}
	else { echo "<h3>Please login and add products to view the shopping cart.</h3>"; }
	include 'footer.php';
?>
<script>
	function totalPrice(pprice, subid){
		//console.log(subid);
		let subtotalid = subid;
		let amtid = ""+subid+"amt";
		oamount = document.getElementById(amtid).value;
		//console.log(amtid);
		//console.log(pprice);
		var subtotal = pprice*oamount;
		document.getElementById(subtotalid).innerHTML = ' $ '+subtotal;
	}
	
	function confirmfunction() { return confirm('Are you sure the order can be placed?'); }
</script>

