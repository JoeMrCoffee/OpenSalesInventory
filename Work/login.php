<?php 
	include 'titlebar.php';
	session_destroy();
?>
<h3>Login</h3>
<form action='accountmgmt.php' method='post'>
<input type='text' placeholder='Enter your name' name='loginName'><br><br>
<input type='password' placeholder='Enter your password' name='password'><br><br>
<input type='submit' value='Enter'>
</form>

<?php include 'footer.php'; ?>
<script>
window.onload = function load() {
    if (!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>

</html>
