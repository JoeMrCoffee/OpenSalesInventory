</td></tr></table>
<div width='100%' class='footer'>Copyright &copy; <?php echo "".date('Y').""; $conn = null; ?></div>
<!-- JS -->
<script>
	function popupdisplay(eid) {
		console.log(eid);
		var groupform = document.getElementById(eid);
		if (groupform.style.visibility == 'hidden') {
    			groupform.style.visibility = 'visible';
 		} 
 		else { groupform.style.visibility = 'hidden'; }	
	}
</script>



</body>
</html>
