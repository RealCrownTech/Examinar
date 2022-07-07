<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<?php
    $deactivate_exam = '';
    if (isset($_GET['deactivate_exam'])) {
        $deactivate_exam = $_GET['deactivate_exam'];
        $deact = $con->query("UPDATE exam_type SET time='-----', type='-----', exam_session='-----', active='no' WHERE course_code='$deactivate_exam'");
    }
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
                            EXAM~MENU
                            <small>Add/Delete/Activate/Deactivate/Delete Courses</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Exam Menu
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div>
                    <div class="row col-lg-12">
                        <a href="generate.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add New</a>
                        <a onclick="deactivateall(event)" href="deactivate_all.php" class="btn btn-large btn-info" style="float:right;"><i class="glyphicon glyphicon-minus"></i> &nbsp; Deactivate All</a>
                    </div>

                    <div class="clearfix"></div><br />

                    <div class="row col-lg-12">
                        <form method="post" name="frm">
                            <table class='table table-bordered table-responsive table-striped'>
                                <tr>
                                    <th style="text-align:center; width:30px;">Select</th>
                                    <th style="width:120px;">Course code</th>
                                    <th>Course Title</th>
                                    <th style="text-align:center; width:30px;">Active</th>
                                    <th style="text-align:center; width:30px;">Deactivate</th>
                                </tr>
                                <?php
                                    $res = $con->query("SELECT * FROM exam_type ORDER BY course_code ASC");
                                    $count = $res->num_rows;
                                    if($count > 0)
                                    {
                                        while($row=$res->fetch_array())
                                        {
                                            ?>
                                            <tr>
                                                <td style="text-align:center;"><input type="checkbox" name="chk[]" class="chk-box" value="<?php echo $row['id']; ?>"  /></td>
                                                <td><?php echo $row['course_code']; ?></td>
                                                <td><?php echo $row['course_title']; ?></td>
                                                <td>
                                                    <?php 
                                                        $act = $row['active'];
                                                        if ($act === 'yes') {
                                                            echo "<button name='set' type='submit' class='btn btn-sm btn-primary pull-left' disabled=''><i class='fa fa-check'></i></button>";
                                                        }else{
                                                            echo "<button name='set' type='submit' class='btn btn-sm btn-secondadry pull-left' disabled=''><i class='fa fa-times'></i></button>";
                                                        }
                                                    ?>
                                                </td>
                                                <td style="text-align:center;"><a onclick="deactivate(event)" href="exam_menu2.php?deactivate_exam=<?php echo $row["course_code"]; ?>" class="btn btn-info btn-xs">Deactivate</a></td>
                                            </tr>
                                        <?php
                                        }   
                                    }
                                    else
                                    {
                                        ?>
                                        <tr>
                                        <td colspan="5"> No Records Found ...</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                <?php
                                    if($count > 0)
                                    {
                                ?>
                                    <tr>
                                        <td colspan="5">
                                            <label><input type="checkbox" class="select-all" /> Check / Uncheck All</label>
                                            <label style="margin-left:100px;">
                                                <span style="word-spacing:normal;"> with selected :</span>
                                                <span><a href="#"><img src="edit.png" onClick="edit_records();" alt="edit" /></a>Activate</span> 
                                                <span><a href="#"><img src="delete.png" onClick="delete_records();" alt="delete" /></a>Delete</span>
                                            </label>
                                        </td>
                                    </tr>    
                                <?php
                                    }
                                ?>
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

<script type="text/javascript">
    function deactivateall(e) {
        if(confirm ('Are you sure you want to deactivate all exams?')){
            return true;
        } else{ 
            e.preventDefault();}
    }
</script>

<script type="text/javascript">
    function deactivate(e) {
        if(confirm ('Are you sure you want to deactivate this exam?')){
            return true;
        } else{ 
            e.preventDefault();}
    }
</script>

</html>
