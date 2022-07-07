<?php
    session_start();
    if (isset($_SESSION["ID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php' 
?>
<?php
	if (isset($_POST['course']) && isset($_POST['session']) && isset($_POST['type']) && isset($_POST['mat_no'])) {
		$course = $_POST['course'];
		$session = $_POST['session'];
		$type = $_POST['type'];
		$mat_no = $_POST['mat_no'];
		$unans = $con->query("SELECT * FROM score_sheet where session = '$session' AND course = '$course' AND type = '$type' AND m_num = '$mat_no' AND usropt = ''");
	    $count_unans = mysqli_num_rows($unans);
		echo $count_unans;
	}
?>