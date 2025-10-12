<?php
	if(isset($_SESSION['loginName'])) {
	    $loginuser = $_SESSION['loginName'];
	    $loginpassword = $_SESSION['password'];
	}
	else {
		if(empty($_POST['password']) || empty($_POST['loginName'])){
			$_POST['password'] = "";
			$_POST['loginName'] = "";
		}      
	    $loginuser = $_POST['loginName'];
	    $loginpassword = $_POST['password'];
	    $_SESSION['loginName'] = $loginuser;
	    $_SESSION['password'] = $loginpassword;
	}
	
	$validity = "";
	$userlvl = "";
	//SQL query prepare and execute
	$usersquery = 'SELECT * FROM users';
	$validatestmt = $conn->prepare($usersquery);
	$validatestmt->execute();
	//Fetch the user data and verify login
	$userlist = $validatestmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($userlist as $user){
		//This is the way the if statement will read with proper passsword hygiene 
		if ($user['Name'] == $loginuser && password_verify($loginpassword, $user['password'])){
		//if ($user['Name'] == $loginuser && $user['password'] == $loginpassword){ //debugging purposes
			$validity = 'valid';
			//this is a flag for checking the user status is an admin or not
			$userlvl = $user['usertype'];
			$loginuid = $user['UID'];
		}
	}
   
?>
