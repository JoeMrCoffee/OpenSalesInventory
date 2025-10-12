<?php 
	include 'titlebar.php';
	if ($validity == "valid" && $userlvl == "admin") {
		$usercnt = 0;
		echo "<h3>User management</h3>
			<div class='postlink'>
			<table width='100%' align='center'>
			<tr><th>Name</th><th>Email</th><th>Phone</th><th>Level</th><th>Edit</th></tr>";

		foreach($userlist as $user){
			$uname = $user['Name'];
			$uemail = $user['email'];
			$uphone = $user['phonenumber'];
			$upwd = $user['password'];
			$uid = $user['UID'];
			$utype = $user['usertype'];
			//This is a tripple escape '\" \"' <-- something interesting
			if ($usercnt % 2 == 0){
				echo "<tr style='background-color:#eaeaea;'>";
				$usercnt += 1;
			}
			else { 
				echo "<tr>";
				$usercnt += 1;
			}
			echo "<td>$uname</td><td>$uemail</td><td>$uphone</td><td>$utype</td><td><button onclick='popupdisplay(\"$uid\")'>Edit</button></td></tr>";
			//Edit user pop-up
			echo "<div class='popupwindow' style='visibility: hidden;' id='$uid'><img class='closepopup' onclick='popupdisplay(\"$uid\")' src='close.png'>
			<form method='post' action='submit.php' class='buttontgthr'>
			<input type='hidden' value='$uid' name='uid'>
			<p><strong>User name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uname' value='$uname'></p>
			<p><strong>User password: </strong>&nbsp;&nbsp;<input type='password' name='upwd' value='$upwd'></p>
			<p><strong>User phone: </strong>&nbsp;&nbsp;&nbsp;<input type='text' name='uphone' value='$uphone'></p>
			<p><strong>User email: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uemail' value='$uemail'></p>
			<p><strong>User type: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<select name='utype'>
				<option value='$utype' selected>$utype</option>
				<option value='admin' >admin</option>
				<option value='customer' >customer</option></select></p>
			<p><input type='submit' value='Update' name='userUpdate' ></form>
			<form method='post' action='submit.php' class='buttontgthr'><input type='hidden' value='$uid' name='uid'>&nbsp;&nbsp;&nbsp;
				<input type='submit' value='Delete' name='userDelete' onclick='return confirmfunction()'>
			</form>
			</p>
			</div>";
		}
		echo "<img src='addObject.png' class='addObject' onclick='popupdisplay(\"newuser\")'>
			<div class='popupwindow' style='visibility: hidden;' id='newuser'><img class='closepopup' onclick='popupdisplay(\"newuser\")' src='close.png'>
			<form method='post' action='submit.php'>
			<p><strong>User name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uname' ></p>
			<p><strong>User password: </strong>&nbsp;&nbsp;<input type='password' name='upwd' ></p>
			<p><strong>User phone: </strong>&nbsp;&nbsp;&nbsp;<input type='text' name='uphone' ></p>
			<p><strong>User email: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='uemail' ></p>
			<p><strong>User type: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<select name='utype'>
				<option value='admin' selected>admin</option>
				<option value='customer' selected>customer</option></select></p>
			<p><input type='submit' value='Add user' name='newUser'></p>
			</form></div>";
		echo "</table></div>";
		
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this user?'); 	}
		</script>";
	
	include 'footer.php';
?>
