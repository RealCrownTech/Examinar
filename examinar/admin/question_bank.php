<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<?php
$result_c = $con->query("SELECT * FROM exam_type ORDER BY course_code ASC");
$count_c = mysqli_num_rows($result_c);
?>

<?php
$rc = $con->query("SELECT * FROM exam_type ORDER BY course_code ASC");
$crc = mysqli_num_rows($rc);
?>

<?php
$result = $con->query("SELECT * FROM exam_type WHERE active='yes'");
$count = mysqli_num_rows($result);
$output = '';
?>

<?php
if (isset($_POST['upload'])) {
	$cours = $_POST['course'];
	$type = $_POST['etype'];
	$exam_ses = $_POST['exam_session'];

	$check_exist = $con->query("SELECT * FROM question WHERE c_code='$cours' AND type='$type' AND exam_session='$exam_ses'");
	$count_exist = mysqli_num_rows($check_exist);
	if ($count_exist >= 1) {
		?>
	        <script>
	        	alert('Upload Failed: There is an existing question in record for the chosen course, type and session.');
	        	window.location.href = 'question_bank.php';
	        </script>
	    <?php
	} else {
	    $filename = $_FILES["csv_upload"]["tmp_name"];
	    if ($_FILES["csv_upload"]["size"] > 0) {
	        $file = fopen($filename, "r");
	        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
				$qid = mysqli_real_escape_string($con, $emapData[0]);
	            $question = mysqli_real_escape_string($con, ucfirst($emapData[1]));
	            $option_a = mysqli_real_escape_string($con, ucfirst($emapData[2]));
	            $option_b = mysqli_real_escape_string($con, ucfirst($emapData[3]));
	            $option_c = mysqli_real_escape_string($con, ucfirst($emapData[4]));
	            $option_d = mysqli_real_escape_string($con, ucfirst($emapData[5]));
	            $correct = mysqli_real_escape_string($con, $emapData[6]);
	            $sql = "INSERT INTO question(c_code,type,exam_session,qid,question,option_a,option_b,option_c,option_d,correct) VALUES('$cours','$type','$exam_ses','$qid', '$question', '$option_a','$option_b','$option_c','$option_d','$correct')";
	            $res = $con->query($sql);
	        }
	        fclose($file);
	        ?>
	        <script>
	        alert('Uploaded Succcessfully !!!');
	        window.location.href = 'question_bank.php';
	        </script>
	        <?php
	    }
	    else {
	        ?>
	        <script>
	        alert('Invalid File: Please upload a CSV file');
	        window.location.href = 'question_bank.php';
	        </script>
	        <?php
	    }
	}
}
//header('Location: question_bank.php');
?>

<?php
    $set_session = $con->query("SELECT * FROM session");
    $count_set_session = mysqli_num_rows($set_session);
?>

<?php
    $ss = $con->query("SELECT * FROM session");
    $cs = mysqli_num_rows($ss);
?>

<?php
    $sd = $con->query("SELECT * FROM department ORDER BY dept ASC");
    $cd = mysqli_num_rows($sd);
?>

<?php
    $active_sess = $con->query("SELECT * FROM session where active_sess=1");
    $rowchk_active_sess = $active_sess->fetch_array(MYSQLI_BOTH);

?>

<script type="text/javascript">
    function vtr_fn() {
        window.open("view_test_result.php?session=" + $('#fsession').val() + "&department=" + $('#fdept').val() + "&level=" + $('#flvl').val() + "&course=" + $('#fcourse').val(), "myNewWinsr", "width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no,scrollbars=yes");
    }
    function ver_fn() {
        window.open("view_exam_result.php?session=" + $('#fsession').val() + "&department=" + $('#fdept').val() + "&level=" + $('#flvl').val() +  "&course=" + $('#fcourse').val(), "myNewWinsr", "width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no,scrollbars=yes");
    }
    function var_fn() {
        window.open("view_all_result.php?session=" + $('#fsession').val() + "&department=" + $('#fdept').val() + "&level=" + $('#flvl').val() +  "&course=" + $('#fcourse').val(), "myNewWinsr", "width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no,scrollbars=yes");
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
    <script src="jquery.js" type="text/javascript"></script>
    <script src="js-script.js" type="text/javascript"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="student_examinar.html"><img style="margin-top: -15px; margin-left: -15px; width:225px; height:50px;" src="logo.jpg"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION["UN"];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                    <div style="background-image: url(profilepictures/default1.jpg); width: 150px; height: 150px; margin-left: 28px; border-radius: 200px">              
                        <img style="width: 150px; height: 150px; border-radius: 200px" src="profilepictures/<?php echo $_SESSION['UN']; ?>.jpg">
                    </div><br/>
                    <p align="center" style="color: #ffffff;">Logged in as: <br>
                    <?php echo $_SESSION["LN"];?> <?php echo $_SESSION["FN"];?>! </p>

                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="session.php"><i class="fa fa-fw fa-folder-open"></i> Faculties</a>
                    </li>
                    <li>
                        <a href="userstable.php"><i class="fa fa-fw fa-user"></i> Manage Students</a>
                    </li>
                    <li>
                        <a href="exam_menu2.php"><i class="fa fa-fw fa-edit"></i> Activate Test/Exam</a>
                    </li>
                    <li class="active">
                        <a href="question_bank.php"><i class="fa fa-fw fa-table"></i> Mng Ques &amp; Results</a>
                    </li>
					<li>
                        <a href="stud_perf.php"><i class="fa fa-fw fa-table"></i> Student Performance</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Question Bank & Result
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Question Bank
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="panel panel-default" style="width:49%; float:left;">
                    <div class="panel-heading" align="center">Upload Question</div>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="panel-body"align="center">
                    	<div class="form-group input-group">
                            <span class="input-group-addon">Session</span>
                            <select style="text-align: center" class="form-control" name="exam_session" required>
                                <option  value="<?php echo $rowchk_active_sess['session'];?>">Active (<?php echo $rowchk_active_sess['session'];?>)</option>
                                <?php
                                    while ( $row_set_session = $set_session->fetch_array(MYSQLI_BOTH)) { ?>
                                    <option value="<?php echo $row_set_session['session']; ?>"><?php echo $row_set_session['session']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Course</span>
                            <select style="text-align: center" class="form-control" name="course" required>
                                <option value="">--Choose--</option>
                                <?php while ( $row_c = $result_c->fetch_array(MYSQLI_BOTH)) { ?>
                                <option value="<?php echo $row_c['course_code']; ?>"><?php echo $row_c['course_code']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Type</span>
                            <select style="text-align: center" class="form-control" name="etype" required>
                                <option value="">--Choose--</option>
                                <option value="test">Test</option>
                                <option value="exam">Exam</option>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <input id="csv_upload" type="file" name="csv_upload"></input>
                        </div>
                        <button type="submit" class="btn btn-info btn-md" name='upload' value="Upload">Upload</button>
                    </div>
                    </form>
                </div>

                <div class="panel panel-default" style="width:49%; float:right;">
                  <div class="panel-heading" align="center">Check/Print Result</div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="panel-body" align="center">
                        <div class="form-group input-group">
                            <span class="input-group-addon">Session</span>
                            <select style="text-align: center" class="form-control" name="reses" id="fsession" required>
                                <option  value="<?php echo $rowchk_active_sess['session'];?>">Active (<?php echo $rowchk_active_sess['session'];?>)</option>
                                <?php
                                    while ( $rs = $ss->fetch_array(MYSQLI_BOTH)) { ?>
                                    <option value="<?php echo $rs['session']; ?>"><?php echo $rs['session']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Department</span>
                            <select style="text-align: center" class="form-control" name="dpt" id="fdept" required>
                                <option value="">--Choose--</option>
                                <?php
                                    while ( $rd = $sd->fetch_array(MYSQLI_BOTH)) { ?>
                                    <option value="<?php echo $rd['dept']; ?>"><?php echo $rd['dept']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Level</span>
                            <select style="text-align: center" class="form-control" name="lvl" id="flvl" required>
                                <option value="">--Choose--</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
								<option value="500">500</option>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Course</span>
                            <select style="text-align: center" class="form-control" name="crs" id="fcourse" required>
                                <option value="">--Choose--</option>
                                <?php while ( $r = $rc->fetch_array(MYSQLI_BOTH)) { ?>
                                <option value="<?php echo $r['course_code']; ?>"><?php echo $r['course_code']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <a class="btn btn-info btn-md" onclick="vtr_fn();">View Test Result</a>
                        <a class="btn btn-info btn-md" onclick="ver_fn();">View Exam Result</a>
                        <a class="btn btn-info btn-md" onclick="var_fn();">View All Result</a>
                    </div>
                    </form>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>