<?php
    session_start();
    if (isset($_SESSION["ID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php' 
?>

<?php
    $active = 'yes';
    $result = $con->query("SELECT * FROM exam_type WHERE active='{$active}'");
    $count = mysqli_num_rows($result); 
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

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
                <a class="navbar-brand" href="index.html"><img style="margin-top: -15px; margin-left: -15px; width:225px; height:50px;" src="logo.jpg"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION["MT"];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li> -->
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
                        <img style="width: 150px; height: 150px; border-radius: 200px" src="profilepictures/<?php echo $_SESSION['MT']; ?>.jpg">
                    </div><br/>
                    <p align="center" style="color: #ffffff;">Logged in as: <br>
                    <?php echo $_SESSION["LN"];?> <?php echo $_SESSION["FN"];?>! </p>

                    <!-- <li>
                        <a href="student_examinar.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="test.php"><i class="fa fa-tasks fa-5n"></i> Test</a>
                    </li> -->
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
                            Active Test/Exam
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> <a href="student_examinar.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Test
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>NOTE:</strong> Once you start the exam, no backing out.
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <?php if ($count > 0) {
                        while ( $row = $result->fetch_array(MYSQLI_BOTH)) { ?>
                            <div class="col-lg-6 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <i class="fa fa-comments fa-4x"></i>
                                            </div>
                                            <div class="col-xs-9 text-center">
                                                <div class="huge"><?php echo $row['course_code']; ?> <?php echo $row['type']; ?></div>
                                                <div><?php echo $row['course_title']; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <span class="pull-left course hidden"><?php echo $row['course_code']; ?></span>
                                        <span class="pull-left type hidden"><?php echo $row['type']; ?></span>
                                        <span class="pull-left session hidden"><?php echo $row['exam_session']; ?></span>
                                        <span class="pull-left"><strong>Time:</strong> <span class="time"><?php echo $row['time']; ?></span>:00 mins</span> 
                                        <?php
                                            $cours = $row['course_code'];
                                            $type = $row['type'];
                                            $exam_ses = $row['exam_session'];
                                            $check_exist = $con->query("SELECT * FROM question WHERE c_code='$cours' AND type='$type' AND exam_session='$exam_ses'");
                                            $count_exist = mysqli_num_rows($check_exist);
                                            if ($count_exist == 0) {
                                                ?>
                                                    <span class="pull-right start"><i class="fa fa-info-circle"> No Question Loaded</i></span>
                                                <?php
                                            } else { ?>
                                                <a href="#" data-toggle="modal" data-target="#myModalinstruct">
                                                    <span class="pull-right start">Start <i class="fa fa-arrow-circle-right"></i></span>
                                                </a> 
                                            <?php } ?>                    
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                    <?php } }?>
                    <!-- /.course div -->
                </div>
               
                <!-- /.row -->

                <!-- Instruction Modal -->
                <div id="myModalinstruct" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center"><span class="echosession"></span> <span class="echocourse"></span> <span class="echotype"></span> Instruction</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body">
                                    <ul>
                                        <li>You are expected to attempt this course for <strong><span class="echotime"></span> minutes.</strong></li>
                                        <li>There are <strong><span class="q_no"></span></strong> questions and you are expected to attempt all.</li>
                                        <li>If you do not understand a question, you can skip by clicking on the next question number.</li>
                                        <li>At the end of the <span class='echotype' style='text-transform: lowercase;'></span>, click on the <strong>End <span class="echotype"></span></strong> button below your profile picture to finally submit.</li>
                                        <li>Click on <strong>Review</strong> after successful submission to access your performance.</li>
                                        <li>You can choose to retake the course by clicking on the <strong>Re-attempt</strong> button</li>
                                        <li> If you exhaust your time, the system will end the <span class='echotype' style='text-transform: lowercase;'></span> for you automatically and submit your work.</li>
                                        <li><strong>All the best.</strong></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-default pull-right proceed">Proceed to start</a>
                            </div>
                        </div>
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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <script>
        $(".start").click(function(){
            var row = $(this).closest('div');
            var course = row.find(".course").text();
            var type = row.find(".type").text();
            var time = row.find(".time").text();
            var session = row.find(".session").text();
            var url = "test_start.php?ongoing_exam=" +  course;
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {course: course, type: type, session: session},
                success: function(msg) {
                    $("span[class='q_no']").html(msg);
                }
            })
                
            $("span[class='echocourse']").text(course);
            $("span[class='echotype']").text(type);
            $("span[class='echotime']").text(time);
            $("span[class='echosession']").text(session);
            $(".proceed").attr("href", url);  
        })
            
    </script>

</body>

</html>
