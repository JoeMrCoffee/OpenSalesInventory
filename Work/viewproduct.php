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
			echo "<td style='text-align: center; max-width: 1280px;'><img src='$pimage' style='max-width: 100%;'></td>";
		}
		else { echo "<td></td>"; }
		echo "<td><h4>$pname</h4>
			<p><strong>Description:</strong><br>$pdesc</p>
			<p><strong>Price: </strong> $ $pprice</p>";
		//Show the add to cart option for logged in users
		if ($validity == "valid"){
			echo "<br><button onclick='popupdisplay(\"$pid\"); totalPrice();'>Add to cart</button></td></tr>";
		}
		//Prompt viewer to login 
		else { echo "<br><a href='login.php'><button >Log in to order</button></a></td></tr>"; }
		
		//Show all the specs
		echo "<tr><td colspan='2'><p><strong>Specifications:</strong><br>$pspecs</p></td></tr>
			</table>";

		//pop up display
		if ($validity == "valid"){		
			//Order pop-up
			echo "<div class='popupwindow' style='visibility: hidden;' id='$pid'>
				<img class='closepopup' onclick='popupdisplay(\"$pid\")' src='close.png'>
				<form method='post' action='shoppingcart.php' >
				<input type='hidden' value='$pid' name='pid'>
				<input type='hidden' value='$pname' name='pname'>
				<input type='hidden' value='$pprice' name='pprice' id='pprice'>
				<p><strong>Product name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;$pname</p>
				<p><strong>Product price: </strong>&nbsp;&nbsp;&nbsp;&nbsp;$pprice</p>
				<p><strong>Number to order: </strong>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='number' name='oamount' id='oamount' value='1' onchange='totalPrice()'></p>
				<div><strong>Subtotal: &nbsp;&nbsp;&nbsp;&nbsp;<div class='buttontgthr' id='subtotal'></div></strong></div><br>
				<div><input type='submit' value='Add to cart' name='porder'></div></form>
				</div></div>";
				//second div to place the pop up in the view product section
		}

	}
	include 'footer.php';

?>
<script>
	function totalPrice(){
		var price = document.getElementById('pprice').value;
		var amount = document.getElementById('oamount').value;
		console.log(amount);
		console.log(price);
		var subtotal = price*amount;
		document.getElementById('subtotal').innerHTML = ' $ '+subtotal;
	
	}

</script>

