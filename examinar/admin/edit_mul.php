<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<?php
    
    error_reporting(0);

    if(isset($_POST['chk'])=="")
    {
        ?>
        <script>
        alert('At least one checkbox Must be Selected !!!');
        window.location.href='exam_menu2.php';
        </script>
        <?php
    }
    $chk = $_POST['chk'];
    $chkcount = count($chk);
    
?>

<?php
    $set_session = $con->query("SELECT * FROM session");
    $count_set_session = mysqli_num_rows($set_session);
?>

<?php
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
                    <li class="active">
                        <a href="exam_menu2.php"><i class="fa fa-fw fa-edit"></i> Activate Test/Exam</a>
                    </li>
                    <li>
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
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div>
                    <div class="clearfix"></div>
                    <div class="container">
                        <a href="generate.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Course</a>
                    </div>
                    <div class="clearfix"></div><br />
                    <div class="row">
                        <form method="post" action="update_mul.php">
                            <table class='table table-bordered'>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Type</th>
                                    <th>Time</th>
                                    <th>Session</th>
                                </tr>
                                <?php
                                    for($i=0; $i<$chkcount; $i++) {
                                        $id = $chk[$i];         
                                        $res=$con->query("SELECT * FROM exam_type WHERE id=".$id);
                                        while($row=$res->fetch_array()) { ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="active[]" value="yes" />
                                                <input type="hidden" name="id[]" value="<?php echo $row['id'];?>" />
                                                <input type="text" name="course_code[]" value="<?php echo $row['course_code'];?>" class="form-control" readonly/>
                                            </td>
                                            <td>                                                    
                                                <select class="form-control" name="typ[]" required>
                                                    <option value="">--Choose--</option>
                                                    <option  value="Test">Test</option>
                                                    <option  value="Exam">Exam</option>
                                                </select>
                                            </td>
                                            <td>                                                    
                                                <select class="form-control" name="time[]" required>
                                                    <option value="">--Choose--</option>
                                                    <option value="10">10 Minutes</option>
                                                    <option value="15">15 Minutes</option>
                                                    <option value="20">20 Minutes</option>
                                                    <option value="30">30 Minutes</option>
                                                    <option value="45">45 Minutes</option>
                                                    <option value="60">1 Hour</option>
                                                    <option value="90">1 Hour 30 Minutes</option>
                                                    <option value="120">2 Hours</option>
                                                </select>
                                            </td>
                                            <td>                                                    
                                                <select class="form-control" name="exam_ses[]" value required>
                                                    <option  value="<?php echo $rowchk_active_sess['session'];?>">Active (<?php echo $rowchk_active_sess['session'];?>)</option>
                                                    <?php
                                                        while ( $row_set_session = $set_session->fetch_array(MYSQLI_BOTH)) { ?>
                                                        <option value="<?php echo $row_set_session['session']; ?>"><?php echo $row_set_session['session']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                <?php } } ?>
                                <tr>
                                    <td colspan="4">
                                        <button type="submit" name="savemul" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> &nbsp;Activate</button>&nbsp;
                                        <a href="exam_menu2.php" class="btn btn-large btn-success"> <i class="glyphicon glyphicon-fast-backward"></i> &nbsp; Cancel</a>
                                    </td>
                                </tr>
                            </table>
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

</body>

</html>
