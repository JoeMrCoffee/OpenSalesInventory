<?php 
	include 'titlebar.php';
	if ($userlvl == "admin" && $validity == "valid") {
		//User Management submissions
		if(isset($_POST['uid']) && isset($_POST['userUpdate'])){
			$uname = $_POST['uname'];
			$uemail = $_POST['uemail'];
			$uphone = $_POST['uphone'];
			$hashcheck = password_get_info($_POST['upwd']);
			if ($hashcheck['algoName'] === 'unknown'){
				$upwd = password_hash($_POST['upwd'], PASSWORD_DEFAULT);
			} else { $upwd = $_POST['upwd']; }			
			$uid = $_POST['uid'];
			$utype = $_POST['utype'];
			//sql statement
			$updateuser = "UPDATE users SET Name='$uname', password='$upwd', email='$uemail', phonenumber='$uphone', usertype='$utype' WHERE UID='$uid'";
			$userupdatestmt = $conn->prepare($updateuser);
			$userupdatestmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>User data updated.</h3>
				<p><a href='usermgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['newUser'])){
			$uname = $_POST['uname'];
			$uemail = $_POST['uemail'];
			$uphone = $_POST['uphone'];
			$upwd = password_hash($_POST['upwd'], PASSWORD_DEFAULT);
			$uid = $uname."".date("Ymd")."".rand(10,100)."";
			$utype = $_POST['utype'];
			//sql statement
			$newuser = "INSERT INTO users (UID, Name, password, email, phonenumber, usertype) VALUES ('$uid', '$uname', '$upwd', '$uemail', '$uphone', '$utype')";
			$newuserstmt = $conn->prepare($newuser);
			$newuserstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>User added.</h3>
				<p><a href='usermgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['userDelete'])){
			$uid = $_POST['uid'];
			$delUser = "DELETE FROM users WHERE UID='$uid'";
			$delUserstmt = $conn->prepare($delUser);
			$delUserstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>User removed.</h3>
				<p><a href='usermgmt.php'><button>< BACK</button></a></p></div>";
		}
		
		//Product management section
		if(isset($_POST['pid']) && isset($_POST['prodUpdate'])){
			$pname = $_POST['pname'];
			$pdesc = nl2br($_POST['pdesc']);
			$pid = $_POST['pid'];
			$pspecs = nl2br($_POST['pspecs']);
			$pprice = $_POST['pprice'];
			$pcost = $_POST['pcost'];
			$imagesuccess = "";
			//$previews = $_POST['Reviews']; //this needs to be updated from the product view page
			//image processing
			if ( $_FILES['pimage']['tmp_name'] != null ){
				$pimage = basename($_FILES['pimage']['name']);
				$tmpimage = $_FILES['pimage']['tmp_name'];
				$curdir = getcwd();
				$savefile = $curdir."/images/".$pimage; 
				$pimgname = "images/".$pimage;
				move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
				$imagesuccess = "<h4>File $savefile uploaded successfully</h4>";
				//sql statement
				$updateproduct = "UPDATE products SET Name='$pname', Images='$pimgname', Description='$pdesc', Specifications='$pspecs', Price='$pprice', Cost='$pcost' WHERE UID='$pid'";
			}
			else {
				//sql statement
				$updateproduct = "UPDATE products SET Name='$pname', Description='$pdesc', Specifications='$pspecs', Price='$pprice', Cost='$pcost' WHERE UID='$pid'";
			}
			$produpdatestmt = $conn->prepare($updateproduct);
			$produpdatestmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h4>Product data updated.</h4>
				<p>$imagesuccess</p>
				<p><a href='prodmgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['newProd'])){
			$pname = $_POST['pname'];
			$pdesc = nl2br($_POST['pdesc']);
			$pspecs = nl2br($_POST['pspecs']);
			$pprice = $_POST['pprice'];
			$pcost = $_POST['pcost'];
			$pid = $pname."".date("Ymd")."".rand(10,100)."";
			$imagesuccess = "";
			//image processing
			if ( $_FILES['pimage']['tmp_name'] != null ){
				$pimage = basename($_FILES['pimage']['name']);
				$tmpimage = $_FILES['pimage']['tmp_name'];
				$curdir = getcwd();
				$savefile = $curdir."/images/".$pimage; 
				$pimgname = "images/".$pimage;
				move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
				$imagesuccess = "<h4>File $savefile uploaded successfully</h4>";
				//sql statement
				$newproduct = "INSERT INTO products (UID, Name, Images, Description, Specifications, Price, Cost) VALUES ('$pid', '$pname', '$pimgname', '$pdesc', '$pspecs', '$pprice', '$pcost')"; 
			}
			else {
				//sql statement
				$newproduct = "INSERT INTO products (UID, Name, Description, Specifications, Price, Cost) VALUES ('$pid', '$pname', '$pdesc', '$pspecs', '$pprice', '$pcost')";
			}
			$newproductstmt = $conn->prepare($newproduct);
			$newproductstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h4>Product data updated.</h4>
				<p>$imagesuccess</p>
				<p><a href='prodmgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['prodDelete'])){
			$pid = $_POST['pid'];
			$delProd = "DELETE FROM products WHERE UID='$pid'";
			$delProdstmt = $conn->prepare($delUser);
			$delProdstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Product removed.</h3>
				<p><a href='prodmgmt.php'><button>< BACK</button></a></p></div>";
		}
		
		//Inventory management section
		//TO DO - need to map the QTY of boxes to the Product QTY so need to update 2 tables. -- DONE
		if(isset($_POST['inventUpdate']) && isset($_POST['inid'])){
			$inid = $_POST['inid'];
			$iname = $_POST['iname'];
			$pid = $_POST['pid'];
			$iBarcode = $_POST['ibarcode'];
			$iQty = $_POST['iqty'];
			$iShelflife = $_POST['ishelf'];
			$iArrival = $_POST['iarrival'];
			$iCost = $_POST['icost'];
			$iAmount = $_POST['iamount'];
			//update the inventory table
			$updateInventStmt = "UPDATE inventory SET Name='$iname', PrdtMapUID='$pid', Barcode='$iBarcode', QtyPerBox='$iQty', Shelflife='$iShelflife', ArrivalDate='$iArrival', Amount='$iAmount', Cost='$iCost' WHERE UID='$inid'";
			$updateInventPrepare = $conn->prepare($updateInventStmt);
			$updateInventPrepare->execute();
			//Sync with the product amounts
			$prdQty = $iQty*$iAmount;
			$updatePrdQty = "UPDATE products SET Quantity='$prdQty' WHERE UID='$pid'";
			$updatePrdQtyPrepare = $conn->prepare($updatePrdQty);
			$updatePrdQtyPrepare->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Inventory item updated.</h3>
				<p><a href='inventmgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['inventInsert'])){
			$iname = $_POST['iname'];
			$inid = $iname."".date("Ymd")."".rand(10,100)."";
			$pid = $_POST['pid'];
			$iBarcode = $_POST['ibarcode'];
			$iQty = $_POST['iqty'];
			$iShelflife = $_POST['ishelf'];
			$iArrival = $_POST['iarrival'];
			$iCost = $_POST['icost'];
			$iAmount = $_POST['iamount'];
			$createInventStmt = "INSERT INTO inventory (UID, Name, PrdtMapUID, Barcode, QtyPerBox, Cost, Shelflife, ArrivalDate, Amount) VALUES ('$inid', '$iname', '$pid', '$iBarcode', '$iQty', '$iCost', '$iShelflife', '$iArrival', '$iAmount')";
			$createInventPrepare = $conn->prepare($createInventStmt);
			$createInventPrepare->execute();
			$prdQty = $iQty*$iAmount;
			$updatePrdQty = "UPDATE products SET Quantity='$prdQty' WHERE UID='$pid'";
			$updatePrdQtyPrepare = $conn->prepare($updatePrdQty);
			$updatePrdQtyPrepare->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Inventory item created.</h3>
				<p><a href='inventmgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['inventDelete'])){
			$inid = $_POST['inid'];
			$inventdelstmt = "DELETE FROM inventory WHERE UID='$inid'";
			$inventdelprepare = $conn->prepare($inventdelstmt);
			$inventdelprepare -> execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Inventory item deleted.</h3>
				<p><a href='inventmgmt.php'><button>< BACK</button></a></p></div>";
		}
		else if(isset($_POST['inventBCinsert'])){
			$barCode = $_POST['barCode'];
			$barconame = $_POST['barconame'];
			$barconum = $_POST['barconum'];
			//Need to have a new inventory ID for each new barcode scan
			$barcoid = $barconame."".date("Ymd")."".rand(10,100)."";
			$barcoAmt = $_POST['barcoAmt'];
			$barcoQty = $_POST['barcoQty'];
			$barcoShelfLife = $_POST['barcoShelfLife'];
			$barcoArrivalDate = $_POST['barcoArrivalDate'];
			$barcoCost = $_POST['barcoCost'];
			$pid = $_POST['pid'];
			$finalNum = $barcoAmt+$barconum;
			//insert the new item and arrival date into the inventory table
			$barcoAddQuery = "INSERT INTO inventory (UID, Name, PrdtMapUID, Barcode, QtyPerBox, Cost, Shelflife, ArrivalDate, Amount) VALUES ('$barcoid', '$barconame', '$pid', '$barCode', '$barcoQty', '$barcoCost', '$barcoShelfLife', '$barcoArrivalDate', '$barconum')";
			$barcoAddStmt = $conn->prepare($barcoAddQuery);
			$barcoAddStmt->execute();
			//Sync with the product amounts
			$prdQty = $barcoQty*$finalNum;
			$updatePrdQty = "UPDATE products SET Quantity='$prdQty' WHERE UID='$pid'";
			$updatePrdQtyPrepare = $conn->prepare($updatePrdQty);
			$updatePrdQtyPrepare->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Barcode amount added to Inventory </h3>
				<p><a href='inventmgmt.php'><button>< BACK</button></a></p>
				</div>";

		}
	}

	else { echo "<h3>Invalid user, please login as admin.</h3>"; } 
	
	include 'footer.php';
?>
