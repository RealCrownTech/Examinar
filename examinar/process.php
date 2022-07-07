<?php
    session_start();
    if (isset($_SESSION["ID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php' 
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <!-- <style type="text/css">
	    #btn {
	    	margin-top: 20px;
	    	font-size: 18px;
		    -webkit-animation: fadeOut 1s forwards;
		    animation: fadeOut 1s forwards;
		    -webkit-animation-delay: 1s;
		    animation-delay: 1s;
		}

		@-webkit-keyframes fadeOut {
		    from {opacity: 1;}
		    to {opacity: 0;}
		}

		@keyframes fadeOut {
		    from {opacity: 1;}
		    to {opacity: 0;}
		}
	</style> -->
</head>

<body>
<?php	
	if (isset($_POST['que'])) {
		$vercourse = $_POST['vercourse'];
		$m_num = $_SESSION['MT'];
		$decision = $_POST['decision'];
		$id = $_POST['id'];
		$que = $_POST['que'];
		$pag = $_POST['pag'];

		//get active session
	    $active_sess = $con->query("SELECT * FROM session where active_sess=1");
	    $rowchk_active_sess = $active_sess->fetch_array(MYSQLI_BOTH);
	    $session = $rowchk_active_sess['session'];

		//get the type (test/exam) and question id, determine the score
	    $chk = $con->query("SELECT * FROM question WHERE c_code='$vercourse' AND exam_session='$session' AND id='$que'");
        $rowchk = $chk->fetch_array(MYSQLI_BOTH);
        $type = $rowchk['type'];
        $qid = $rowchk['id'];
        if ($type == 'test') {
            $t = 30; 
        } else {
            $t = 70;
        }

		//get the correct option value
        $corr = $con->query("SELECT * FROM score_sheet WHERE m_num='$m_num' AND session='$session' AND course='$vercourse' AND type='$type' AND qid='$qid'");
		$chk_corr = $corr->fetch_array(MYSQLI_BOTH);
		$corop = $chk_corr['coropt'];

		//count the number of correct option
		$get_val = $con->query("SELECT * FROM score_sheet WHERE m_num='$m_num' AND session='$session' AND course='$vercourse' AND type='$type' AND correct='y'");
    	$count_val = mysqli_num_rows($get_val);

		//get total number of questions for the active exam
		$getqno = $con->query("SELECT * FROM question WHERE c_code='$vercourse' AND type='$type' AND exam_session='$session'");
        $countqno = mysqli_num_rows($getqno);
        $qno =  $countqno;

        //update db with y with option chosen is correct
		if ($corop == $decision) {
			$query = $con->query("UPDATE score_sheet SET usropt='$decision', correct='y' WHERE m_num='$m_num' AND session='$session' AND course='$vercourse' AND type='$type'AND qid='$qid'");
		}

	    //update db with n with option chosen is correct
		if ($corop !== $decision) {
			$query = $con->query("UPDATE score_sheet SET usropt='$decision', correct='n' WHERE m_num='$m_num' AND session='$session' AND course='$vercourse' AND type='$type'AND qid='$qid'");
		}

		//count the number of correct option
		$det_result = $con->query("SELECT * FROM score_sheet WHERE m_num='$m_num' AND session='$session' AND course='$vercourse' AND type='$type' AND correct='y'");
    	$count_result = mysqli_num_rows($det_result);
    	
    	//do the calculation
		$score = '';
		if ($type == 'test') {
			$docalc = $count_result/$countqno;
			$score = $docalc * $t;
			$queryy = $con->query("UPDATE result SET test='$score' WHERE m_num='$m_num' AND session='$session' AND course='$vercourse'");
		    echo "<button id='btn' class='btn btn-success col-lg-12' readonly>Choice submitted successfully</button>";
		} else {
			$docalc = $count_result/$countqno;
			$score = $docalc * $t;
			$queryy = $con->query("UPDATE result SET exam='$score' WHERE m_num='$m_num' AND session='$session' AND course='$vercourse'");
		    echo "<button id='btn' class='btn btn-success col-lg-12' readonly>Choice submitted successfully</button>";
		}
	}
	
	if (isset($_POST['course']) && isset($_POST['session']) && isset($_POST['type'])) {
		$course = $_POST['course'];
		$session = $_POST['session'];
		$type = $_POST['type'];
		$rel = $con->query("SELECT * FROM question where c_code = '$course' AND exam_session = '$session' AND type = '$type'");
	    $count_rel = mysqli_num_rows($rel);
		echo $count_rel;		
	}

?>
</body>
</html>

