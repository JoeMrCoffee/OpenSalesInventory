<?php 
	include 'titlebar.php';
	if ($validity == "valid") {
		//SQL connection
		$currentuserquery = "SELECT * FROM users WHERE UID='$loginuid'";
		$currentuserinfostmt = $conn->prepare($currentuserquery);
		$currentuserinfostmt->execute();
		$currentuserinfo = $currentuserinfostmt->fetchAll(PDO::FETCH_ASSOC);
		//print_r($currentuserinfo);
		//get user info
		foreach ($currentuserinfo as $currentuser){
			$uid = $currentuser['UID'];
			$uname = $currentuser['Name'];
			$upwd = $currentuser['password'];
			$uphone = $currentuser['phonenumber'];
			$uemail = $currentuser['email'];

			echo "<h3>Account management</h3>
				<div class='postlink'>
				<form method='post' action='put.php' >
				<input type='hidden' value='$uid' name='uid'>
				<p><strong>User name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uname' value='$uname'></p>
				<p><strong>User password: </strong>&nbsp;&nbsp;<input type='password' name='upwd' value='$upwd'></p>
				<p><strong>User phone: </strong>&nbsp;&nbsp;&nbsp;<input type='text' name='uphone' value='$uphone'></p>
				<p><strong>User email: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uemail' value='$uemail'></p>
				<br><div><input type='submit' value='Update' name='accountUpdate'></form>
				<form method='post' action='put.php' class='buttontgthr'><input type='hidden' value='$uid' name='uid'>&nbsp;&nbsp;&nbsp;
					<input type='submit' value='Delete' name='accountDelete' onclick='return confirmfunction()'>
				</form>
				</div>
				</div>";
		}
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this user?'); }
		</script>";
	
	include 'footer.php';
?>
