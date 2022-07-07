<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<?php
    $selected_faculty = '';
    if (isset($_GET['selected_faculty'])) {
        $selected_faculty = $_GET['selected_faculty'];
        $start = $con->query("SELECT * FROM faculty WHERE falc_abbr='$selected_faculty'");
        $count = mysqli_num_rows($start);
        $row = $start->fetch_array(MYSQLI_BOTH);
    }

    $get_dept = $con->query("SELECT * FROM department WHERE falc='$selected_faculty' ORDER BY dept ASC");
    $count_dept = mysqli_num_rows($get_dept);

    $sql = $con->query("SELECT department, level, count(*) as stud_count from student_login GROUP BY department, level");
    $count_r = mysqli_num_rows($sql);
    $depart_count = [];

    for(; $rw = $sql->fetch_array(MYSQLI_BOTH);) {
        $depart_count[$rw['department']][$rw['level']] = $rw['stud_count'];
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
                            <?php echo $row['falc_full']; ?>
                            <small><?php echo $row['falc_abbr']; ?></small>
                        </h1>
                        <ol class="breadcrumb" style="text-align: center">
                            <li class="active">
                                <i class=""></i>LIST OF DEPARTMENTS AND STUDENTS IN <?php echo $row['falc_abbr'];?>
                            </li>
                            <a href="session.php"><span class="pull-left"><i class="fa fa-arrow-circle-left"></i> Back</span></a>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div>
                    <div class="box-body table-responsive no-padding">
                        <table style="width:100%" class="table table-bordered table-striped">
                            <?php if ($count_dept > 0) {?>
                                <tr>
                                    <th style="width:1%; text-align: center;">SN</th>
                                    <th style="width:30%;">Department</th>
                                    <th style="width:10%; text-align: center;">100 level</th>
                                    <th style="width:10%; text-align: center;">200 level</th>
                                    <th style="width:10%; text-align: center;">300 level</th>
                                    <th style="width:10%; text-align: center;">400 level</th>
                                    <th style="width:10%; text-align: center;">500 level</th>
                                    <th style="width:10%; text-align: center;">All</th>
                                </tr>
                                <?php $i = 1;
                                    while ( $row_dept = $get_dept->fetch_array(MYSQLI_BOTH)) { 
                                        $stud1 = isset($depart_count[$row_dept['dept']]['100'])? $depart_count[$row_dept['dept']]['100']: '0';
                                        $stud2 = isset($depart_count[$row_dept['dept']]['200'])? $depart_count[$row_dept['dept']]['200']: '0';
                                        $stud3 = isset($depart_count[$row_dept['dept']]['300'])? $depart_count[$row_dept['dept']]['300']: '0';
                                        $stud4 = isset($depart_count[$row_dept['dept']]['400'])? $depart_count[$row_dept['dept']]['400']: '0';
                                        $stud5 = isset($depart_count[$row_dept['dept']]['500'])? $depart_count[$row_dept['dept']]['500']: '0';
                                        $totalstud = $stud1 + $stud2 + $stud3 + $stud4 + $stud5;
                                ?>
                                    <tr>
                                        <td align="center"><?php echo $i; ?></td>
                                        <td><?php echo $row_dept['dept']; ?></td>
                                        <td align='center'><?php echo $stud1;  ?></td>
                                        <td align="center"><?php echo $stud2;  ?></td>
                                        <td align="center"><?php echo $stud3;  ?></td>
                                        <td align="center"><?php echo $stud4;  ?></td>
                                        <td align="center"><?php echo $stud5;  ?></td>
                                        <td align="center"><?php echo $totalstud; ?></td>
                                    </tr>                                           
                                <?php $i++; } ?>
                            <?php } ?>
                        </table>
                    </div><!-- /.box-body -->
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
