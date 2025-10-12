<?php 
	include 'titlebar.php';
	if ($userlvl == "admin" && $validity == "valid") {
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
				<h3>User data updated.</h3></div>";
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
				<h3>User added.</h3></div>";
		}
		else if(isset($_POST['userDelete'])){
			$uid = $_POST['uid'];
			$delUser = "DELETE FROM users WHERE UID='$uid'";
			$delUserstmt = $conn->prepare($delUser);
			$delUserstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>User removed.</h3></div>";
		}
		if(isset($_POST['pid']) && isset($_POST['prodUpdate'])){
			$pname = $_POST['pname'];
			$pdesc = nl2br($_POST['pdesc']);
			$pid = $_POST['pid'];
			$pspecs = nl2br($_POST['pspecs']);
			$pprice = $_POST['pprice'];
			$pcost = $_POST['pcost'];
			//$previews = $_POST['Reviews']; //this needs to be updated from the product view page
			//image processing
			if ( $_FILES['pimage']['tmp_name'] != null ){
	            $pimage = basename($_FILES['pimage']['name']);
				$tmpimage = $_FILES['pimage']['tmp_name'];
	            $curdir = getcwd();
                $savefile = $curdir."/images/".$pimage; 
                $pimgname = "images/".$pimage;
                move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
	            echo "<h3>File $savefile uploaded successfully</h3>";
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
				<h3>Product data updated.</h3></div>";
		}
		else if(isset($_POST['newProd'])){
			$pname = $_POST['pname'];
			$pdesc = nl2br($_POST['pdesc']);
			$pspecs = nl2br($_POST['pspecs']);
			$pprice = $_POST['pprice'];
			$pcost = $_POST['pcost'];
			$pid = $pname."".date("Ymd")."".rand(10,100)."";
			//image processing
			if ( $_FILES['pimage']['tmp_name'] != null ){
	            $pimage = basename($_FILES['pimage']['name']);
				$tmpimage = $_FILES['pimage']['tmp_name'];
	            $curdir = getcwd();
                $savefile = $curdir."/images/".$pimage; 
                $pimgname = "images/".$pimage;
                move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
	            echo "<h3>File $savefile uploaded successfully</h3>";
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
				<h3>Product data updated.</h3></div>";
		}
		else if(isset($_POST['prodDelete'])){
			$pid = $_POST['pid'];
			$delProd = "DELETE FROM products WHERE UID='$pid'";
			$delProdstmt = $conn->prepare($delUser);
			$delProdstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Product removed.</h3></div>";
		}
	}

	else { echo "<h3>Invalid user, please login as admin.</h3>"; } 
	
	include 'footer.php';
?>
