<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<!-- Session -->
<?php
    $get_sessions = $con->query("SELECT * FROM session ORDER BY session DESC");
    $count = mysqli_num_rows($get_sessions);
?>

<?php
    $set_session = $con->query("SELECT * FROM session");
    $count_set_session = mysqli_num_rows($set_session);
?>

<?php
$chk_err = "";
    if (isset($_POST['save_sess'])) {
        $new_sess = $_POST['session_add'];
    
    $check_sess = $con->query("SELECT * FROM session where session='$new_sess'");
    $rowchk_sess = $check_sess->fetch_array(MYSQLI_BOTH);
        if (empty($rowchk_sess)) {
            $sql = $con->query("INSERT INTO session(session) VALUES('$new_sess')");
        }
        else{
            $chk_err = "$new_sess exist!";
        }

    
        
    }
?>

<?php
    $active_sess = $con->query("SELECT * FROM session where active_sess=1");
    $rowchk_active_sess = $active_sess->fetch_array(MYSQLI_BOTH);

?>
<!-- End of Session -->

<!-- Department -->
<?php
$chk_errr = "";
    if (isset($_POST['save_dept'])) {
        $new_dept = $_POST['dept_add'];
        $facult = $_POST['faculty'];
        $check_dept = $con->query("SELECT * FROM department where dept='$new_dept'");
        $rowchk_dept = $check_dept->fetch_array(MYSQLI_BOTH);
        if (empty($rowchk_dept)) {
            $sql = $con->query("INSERT INTO department(dept, falc) VALUES('$new_dept', '$facult')");
        }
        else{
            $chk_errr = "$new_dept exist!";
        }  
    }
?>

<?php
    $get_faculty = $con->query("SELECT * FROM faculty ORDER BY falc_abbr ASC");
    $count_faculty = mysqli_num_rows($get_faculty);
?>

<!-- Faculty -->
<?php
$chk_errr = "";
    if (isset($_POST['save_falc'])) {
        $new_falc_full = strtoupper($_POST['falc_full']);
        $new_falc_abbr = strtoupper($_POST['falc_abbr']);
        $check_falc = $con->query("SELECT * FROM faculty where falc_full='$new_falc_full' and falc_abbr='$new_falc_abbr'");
        $rowchk_falc = $check_falc->fetch_array(MYSQLI_BOTH);
        if (empty($rowchk_falc)) {
            $sql = $con->query("INSERT INTO faculty(falc_full, falc_abbr) VALUES('$new_falc_full', '$new_falc_abbr')");
        }
        else{
            $chk_errr = "$new_falc_abbr exist!";
        }  
    }
?>

<?php
    $get_falc = $con->query("SELECT * FROM faculty ORDER BY falc_abbr ASC");
    $count_falc = mysqli_num_rows($get_falc);
?>

<?php
    if (isset($_POST['btngo'])) {
        $set_all_sessions = '0';
        $active_value = '1';
        $to_set = $_POST['sas'];
        if ($to_set == '--Choose--') {
            $chk_err = "Select a session";
        }else{
            $con->query("UPDATE session SET active_sess='$set_all_sessions'");
            $con->query("UPDATE session SET active_sess='$active_value' WHERE session='$to_set'");
            header('Location: session.php');
        }
    }
?>

<!-- End of Deprtment -->
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
                    <li class="active">
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
                            Session
                            <small>Add Sessions & Set active session</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-folder-open"></i> Session
                            </li>
                            <li>
                                <i><strong>Active Session:</strong></i> <?php echo $rowchk_active_sess['session']; ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <div class="box-tools">
                                        <div class="input-group" style="float:left;">
                                            <a class="btn btn-sm btn-default" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-folder-open"></i>  Add New Session</a>
                                        </div>
                                        <div class="input-group" style="float:left;">
                                            <a class="btn btn-sm btn-default" data-toggle="modal" data-target="#compose-modal-falc"><i class="fa fa-folder-open"></i>  Add New Faculty</a>
                                        </div>
                                        <div class="input-group">
                                            <a class="btn btn-sm btn-default" data-toggle="modal" data-target="#compose-modal-dept"><i class="fa fa-folder-open"></i>  Add New Department</a>
                                        </div>
                                    </div>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <div class="input-group" style="width:410px">
                                                <span class="input-group-addon">Set Active Session:</span>
                                                <select class="form-control" name="sas" style="width:226px">
                                                    <option>--Choose--</option>
                                                    <?php
                                                        while ( $row_set_session = $set_session->fetch_array(MYSQLI_BOTH)) { ?>
                                                        <option value="<?php echo $row_set_session['session']; ?>"><?php echo $row_set_session['session']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info btn-flat" name="btngo" type="submit">Go!</button>
                                                </span>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.box-header -->
                                <div class="panel panel-default" style="width:38.2%; float:left;">
                                    <div class="panel-heading" style="width:100%;" align="center"><strong>Sessions</strong>
                                        <small><i><font color="red"><?php if ($chk_err == true) {echo $chk_err;}?></font></i></small>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table style="width:100%" class="table table-bordered table-hover">
                                            <?php if ($count > 0) {?>
                                                <tr>
                                                    <th width="3%">SN</th>
                                                    <th width="60%">Session</th>
                                                    <th>Active</th>
                                                </tr>
                                                <?php $i = 1;
                                                    while ( $row = $get_sessions->fetch_array(MYSQLI_BOTH)) { ?>
                                                    <tr>
                                                        <td align="center"><?php echo $i; ?></td>
                                                        <td><?php echo $row['session']; ?></td>
                                                        <td>
                                                            <?php 
                                                                $a = $row['session'];
                                                                $b = $rowchk_active_sess['session'];
                                                                if ($a === $b) {
                                                                    echo "<button type='submit' class='btn btn-sm btn-primary pull-left' disabled=''><i class='fa fa-check'></i></button>";
                                                                }else{
                                                                    echo "<button type='submit' class='btn btn-sm btn-secondadry pull-left' disabled=''><i class='fa fa-times'></i></button>";
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>                                           
                                                <?php $i++; } ?>
                                            <?php } ?>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div>
                                <div class="panel panel-default" style="width:38.2%; float:right;">
                                    <div class="panel-heading" style="width:100%;" align="center"><strong>Faculties</strong>
                                        <small><i><font color="red"><?php if ($chk_errr == true) {echo $chk_errr;}?></font></i></small>
                                    </div>
                                    <div class="box-body table-responsive no-padding">
                                        <table style="width:100%" class="table table-bordered table-striped">
                                            <?php if ($count_falc > 0) {?>
                                                <?php $i = 1;
                                                    while ( $row_falc = $get_falc->fetch_array(MYSQLI_BOTH)) { ?>
                                                    <tr>
                                                        <td align="center" width="10%"><?php echo $i; ?></td>
                                                        <td><a style="text-decoration: none; color: black;" href="lod.php?selected_faculty=<?php echo $row_falc["falc_abbr"]; ?>"><?php echo $row_falc['falc_full']; ?></a></td>
                                                    </tr>                                           
                                                <?php $i++; } ?>
                                            <?php } ?>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div>
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section>

                <!-- Session Modal -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-folder-open"></i> Enter New Session</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Session:</span>
                                    <input name="session_add" type="text" class="form-control" placeholder="2005/2006" maxlength="9" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                            <button name="save_sess" type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Save Session</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!--End of Session Modal -->

        <!-- Department Modal-->
        <div class="modal fade" id="compose-modal-dept" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-folder-open"></i> Enter New Department</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Department of:</span>
                                    <input name="dept_add" type="text" class="form-control" placeholder="Name of Department" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Faculty:</span>
                                    <select class="form-control" name="faculty" required>
                                        <option value="--Choose--">--Choose--</option>
                                        <?php
                                            while ($row_faculty = $get_faculty->fetch_array(MYSQLI_BOTH)) { ?>
                                            <option value="<?php echo $row_faculty['falc_abbr']; ?>"><?php echo $row_faculty['falc_abbr']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                            <button name="save_dept" type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Save Department</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- End of Department Modal -->

        <!-- Faculty Modal-->
        <div class="modal fade" id="compose-modal-falc" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-folder-open"></i> Enter New Faculty</h4>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Faculty:</span>
                                    <input name="falc_full" type="text" class="form-control" placeholder="Enter Faculty name in full" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Abbreviation:</span>
                                    <input name="falc_abbr" type="text" class="form-control" placeholder="Enter Faculty name in abbreviation" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                            <button name="save_falc" type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Add Faulty</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- End of Faculty Modal -->


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
    <script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>

</body>

</html>
