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
		echo "<h3>Open orders:</h3>";
		
		foreach($shopcart as $shopitem){
			echo "<div class='ordersummary'>
				<form method='post' action='put.php'> 
				<input type='hidden' name='userid' value='$loginuid'>
				<input type='hidden' name='username' value='$loginuser'>";
			$pid = $shopitem['pid'];
			echo "<p>$pid</p>";
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
			// Javascript function isn't returing a value
			// Need to investigate
			// Need to add the POST receiver for the put.php page
			// Need to clear the session values
			// Need to add a historical order section in the shopping cart that
			// pulls from the database of orders - SELECT * FROM orders WHERE UserUID="" - 
			echo "
				<input type='hidden' name='pid' value='$pid'>
				<p>Product name: $pname</p><input type='hidden' name='pname' value='$pname'>
				<p>Description:<br>$pdesc</p>
				<p>Unit price: $pprice</p><input type='hidden' value='$pprice' id='".$pid."price'>
				<p>Order amount: <input type='number' name='oamount' id='".$pid."amt' value='$oamount' onchange='totalPrice($pprice,\"$pid\")'></p>
				<div><strong>Subtotal: <div class='buttontgthr' id='$pid'>$ $subtotal</div></strong></div><br>
				<p><input type='submit' value='Place order' onclick='return confirmfunction()' name='newOrder'></p></div>";
				
		}
		
		//update the session
		$_SESSION['shopcart'] = $shopcart;
	}
	else { echo "<p>Please login  and add products to view the shopping cart.</p>"; }
	include 'footer.php';
?>
<script>
	function totalPrice(pprice, subid){
		console.log(subid);
		let subtotalid = subid;
		let amtid = ""+subid+"amt";
		oamount = document.getElementById(amtid).value;
		console.log(amtid);
		console.log(pprice);
		var subtotal = pprice*oamount;
		document.getElementById(subtotalid).innerHTML = ' $ '+subtotal;
	}
	
	function confirmfunction() { return confirm('Are you sure the order can be placed?'); }
</script>

