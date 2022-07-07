<?php
	if (isset($_GET['success']) && $_GET['success'] =='true'){
		echo "<script> alert ('Registration Successful. Enter your matric number and surname to login.') </script>";
	echo("<script>location.href = 'index.php';</script>");
	}
?>