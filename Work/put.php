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
				<h3>User data updated.</h3></div>";
		}
		else if(isset($_POST['accountDelete'])){
			$uid = $_POST['uid'];
			$delUser = "DELETE FROM users WHERE UID='$uid'";
			$delUserstmt = $conn->prepare($delUser);
			$delUserstmt->execute();
			echo "<h3>Submit</h3><div class='postlink'>
				<h3>Your account has been deleted.</h3></div>";
		}
	}
	else { echo "<h3>Invalid user, please login as admin.</h3>"; } 
	
	include 'footer.php';
?>
