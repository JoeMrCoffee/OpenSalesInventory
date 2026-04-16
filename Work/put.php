<?php 
	include 'titlebar.php';
	if ($validity == "valid" ){
		if(isset($_POST['uid']) && isset($_POST['accountUpdate'])){
			$uname = $_POST['uname'];
			$uemail = $_POST['uemail'];
			$uphone = $_POST['uphone'];
			$hashcheck = password_get_info($_POST['upwd']);
			if ($hashcheck['algoName'] === 'unknown'){
	        	$upwd = password_hash($_POST['upwd'], PASSWORD_DEFAULT);
	    	} else { $upwd = $_POST['upwd']; }			
			$uid = $_POST['uid'];
			//sql statement
			$updateuser = "UPDATE users SET Name='$uname', password='$upwd', email='$uemail', phonenumber='$uphone' WHERE UID='$uid'";
			$userupdatestmt = $conn->prepare($updateuser);
			$userupdatestmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>User data updated.</h3>
				<p>If name or password was changed, please return to the login and re-authenticate <a href='login.php'>LOGIN</a></p>
				</div>";
		}
		else if(isset($_POST['accountDelete'])){
			$uid = $_POST['uid'];
			$delUser = "DELETE FROM users WHERE UID='$uid'";
			$delUserstmt = $conn->prepare($delUser);
			$delUserstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Your account has been deleted.</h3></div>";
		}
		if(isset($_POST['placeorder'])){
			//TO DO grab all the variables and enter the order
			$itemid = $_POST['itemid'];
			$pname = $_POST['pname'];
			$pprice = $_POST['pprice'];
			$oamount = $_POST['oamount'];
			$pid = $_POST['pid'];
			$userid = $_POST['userid'];
			$username = $_POST['username'];
			$orderid = "ORD".$username."".date("Ymdh")."".rand(10,100)."";
			$orderDate = date('Ymd');
			$ordPrice = $pprice*$oamount;
			//look up the product cost			
			$prodLookup = "SELECT * FROM products WHERE UID='$pid'";
			$prodLookstmt = $conn -> prepare($prodLookup);
			$prodLookstmt->execute();
			$prodlist = $prodLookstmt->fetchAll(PDO::FETCH_ASSOC);
			foreach( $prodlist as $prod){
				$pcost = $prod['Cost'];
			}
			$ordCost = $pcost*$oamount;
			//Insert the order to the database
			//TO DO
			//Need to create an invoice value
			$neworder = "INSERT INTO orders (UID, Username, UserUID, PrdtMapUID, Amount, Price, Cost, OrderDate) VALUES ('$orderid', '$username', '$userid', '$pid', '$oamount', '$ordPrice', '$ordCost', '$orderDate')";
			$neworderstmt = $conn->prepare($neworder);
			$neworderstmt->execute();
			
			//unset the Session
			$shopcart = $_SESSION['shopcart'];
			unset($shopcart[$itemid]);
			$_SESSION['shopcart'] = $shopcart;
			
			//Order details - perhaps up the formatting
			echo "<h3>Order placed</h3><div class='postlink'>
				<p><strong>Your order has been placed!</strong><br>
				Order ID: $orderid.<br>
				Order date: $$orderDate<br>
				Item ordered: $pid<br>
				Amount: $oamount<br>
				Total cost: $ordPrice<br>
				If you have any questions, please contact us with your order ID. Thank you.</p></div>";
			
		}
	}
	else { echo "<h3>Invalid user, please first login.</h3>"; } 
	
	include 'footer.php';
?>
