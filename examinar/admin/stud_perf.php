<?php

	session_start();
	if (isset($_SESSION["AID"])) {
	} else {
		header("Location: index.php");
	}
	
	require 'connection.php';
	
    $set_session = $con->query("SELECT * FROM session");
    $count_set_session = mysqli_num_rows($set_session);
	
    $sd = $con->query("SELECT * FROM department ORDER BY dept ASC");
    $cd = mysqli_num_rows($sd);
	
	$rc = $con->query("SELECT * FROM exam_type ORDER BY course_code ASC");
	$crc = mysqli_num_rows($rc);

    $active_sess = $con->query("SELECT * FROM session where active_sess=1");
    $rowchk_active_sess = $active_sess->fetch_array(MYSQLI_BOTH);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Welcome <?php echo $_SESSION["UN"];?> <b class="caret"></b></a>
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
                    <li>
                        <a href="question_bank.php"><i class="fa fa-fw fa-table"></i> Mng Ques &amp; Results</a>
                    </li>
					<li class="active">
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
                            Student Performance
                            <small>View student test/exam record</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Student Performance
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
				
				<div  id="result" class="col-lg-12">
				<div class="panel panel-default col-lg-8" align="center">
                    <div class="panel-heading">Details</div>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="panel-body">
                    	<div class="form-group input-group">
                            <span class="input-group-addon">Matric Number</span>
                            <input type="text" style="text-align: center" class="form-control mat_no" name="mat_no" required />
                        </div>
						<div class="form-group input-group">
                            <span class="input-group-addon">Level</span>
                            <select style="text-align: center" class="form-control level" name="level" required>
                                <option value="">--Choose--</option>
								<option value="100">100</option>
								<option value="200">200</option>
								<option value="300">300</option>
								<option value="400">400</option>
								<option value="500">500</option>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Department</span>
                            <select style="text-align:center" class="form-control dept" name="dept" required>
                                <option value="">--Choose--</option>
                                <?php
                                    while ( $rd = $sd->fetch_array(MYSQLI_BOTH)) { ?>
                                    <option value="<?php echo $rd['dept']; ?>"><?php echo $rd['dept']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon">Type</span>
                            <select style="text-align: center" class="form-control etype" name="etype" required>
                                <option value="">--Choose--</option>
                                <option value="test">Test</option>
                                <option value="exam">Exam</option>
                            </select>
                        </div>
						<div class="form-group input-group">
                            <span class="input-group-addon">Session</span>
                            <select style="text-align: center" class="form-control session" name="session" required>
                                <option  value="<?php echo $rowchk_active_sess['session'];?>">Active (<?php echo $rowchk_active_sess['session'];?>)</option>
                                <?php
                                    while ( $row_set_session = $set_session->fetch_array(MYSQLI_BOTH)) { ?>
                                    <option value="<?php echo $row_set_session['session']; ?>"><?php echo $row_set_session['session']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
						<div class="form-group input-group">
                            <span class="input-group-addon">Course</span>
                            <select style="text-align: center" class="form-control course" name="course" required>
                                <option value="">--Choose--</option>
                                <?php while ( $r = $rc->fetch_array(MYSQLI_BOTH)) { ?>
                                <option value="<?php echo $r['course_code']; ?>"><?php echo $r['course_code']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-info btn-md explore" name='explore' value="">Explore</button>
                    </div>
                    </form>
                </div>
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
	
	<script>
        $(".explore").click(function(){
			var row = $(this).closest('div.panel-body');
            var mat_no = row.find(".mat_no").val();
            var level = row.find(".level").val();
            var dept = row.find(".dept").val();
            var etype = row.find(".etype").val();
			var session = row.find(".session").val();
			var course = row.find(".course").val();			
            var url = "stud_perf.php";
			$.ajax({
				type: "POST",
				url: "load.php",
				data: {mat_no: mat_no, level: level, dept: dept, etype: etype, session: session, course: course},
				success: function(msg) {
					$("div#result").html(msg);
				}
			})
		})
            
    </script>

</body>

</html>
