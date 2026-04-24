<?php 
	include 'titlebar.php';
	if ($validity == "valid" && $userlvl == "admin") {
		echo "<h3>Website settings</h3>
			<div class='postlink'>
			<form method='post' action='submit.php' enctype='multipart/form-data'>
			<p><strong>Site name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='sitename' value='$sitename'></p>
			<p><strong>Site logo: </strong>&nbsp;&nbsp;<input type='file' name='sitelogo' >
			<br> Existing logo: $sitelogo</p>
			<p><strong>Highlight color: </strong>&nbsp;&nbsp;&nbsp;<input type='color' name='HLcolor' value='$HLcolor'></p>
			<p><strong>Theme: </strong>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' id='theme1' name='theme' value='light'><label for='theme1'>light</label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' id='theme2' name='theme' value='dark'><label for='theme2'>dark</label>
			</p>
			<p><strong>Font style: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='fontstyle' value='$fontstyle'></p>
			<p><strong>Company name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='companyname' value='$CompanyName'></p>
			<p><strong>Company address: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='companyaddress' value='$CompanyAddress'></p>
			<p><strong>Contact email: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='companyemail' value='$CompanyEmail'></p>
			<p><strong>Company phone: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='companyphone' value='$CompanyPhone'></p>
			<br><div><input type='submit' value='Update' name='UpdateSiteSettings'></form></div>
			</div>";
	}
	else { echo "<h3>Invalid user, please login.</h3>"; } 
	
	echo "<script>
			function confirmfunction() { return confirm('Do you really want to delete this user?'); }
		</script>";
	
	include 'footer.php';
?>
