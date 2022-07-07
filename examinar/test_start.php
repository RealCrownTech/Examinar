<?php
    session_start();
    if (isset($_SESSION["ID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php' 
?>

<?php
    $ongoing_exam = '';
    $starterr = '';
    if (isset($_GET['ongoing_exam'])) {
        $ongoing_exam = $_GET['ongoing_exam'];
        $active_sess = $con->query("SELECT * FROM session where active_sess=1");
        $rowchk_active_sess = $active_sess->fetch_array(MYSQLI_BOTH);
        $session = $rowchk_active_sess['session'];

        $start = $con->query("SELECT * FROM exam_type WHERE course_code='$ongoing_exam' AND exam_session='$session'");
        $countstart = mysqli_num_rows($start);
        $row = $start->fetch_array(MYSQLI_BOTH);
        $type = $row['type'];

        $getqid = $con->query("SELECT * FROM question WHERE c_code='$ongoing_exam' AND type='$type' AND exam_session='$session' ORDER BY RAND()");
        $countqid = mysqli_num_rows($getqid);

        $m_num = $_SESSION["MT"];
        $lname = $_SESSION["LN"];
        $fname = $_SESSION["FN"];
        $mname = $_SESSION["MN"];
        $faculty = $_SESSION["FA"];
        $depart = $_SESSION["DP"];
        $leve = $_SESSION["LV"];
        $course = $row['course_code'];

        $chk = $con->query("SELECT * FROM score_sheet where m_num='$m_num' AND course='$course' AND type='$type' AND session='$session'");
        $rowchk = $chk->fetch_array(MYSQLI_BOTH);

        $chkr = $con->query("SELECT * FROM result where m_num='$m_num' AND course='$course' AND session='$session'");
        $rowchkr = $chkr->fetch_array(MYSQLI_BOTH);

        if (empty($rowchk)) {
            while ( $rowqid = $getqid->fetch_array(MYSQLI_BOTH)) {
                $qid = $rowqid['qid'];
                $cid = $rowqid['correct'];
                $sql="INSERT INTO score_sheet(course,session,type,qid,coropt,m_num,lname,fname,mname,faculty,depart,level) VALUES('$course','$session','$type','$qid','$cid','$m_num','$lname','$fname','$mname','$faculty','$depart','$leve')";
                $find = $con->query($sql);
            }
            if (empty($rowchkr)) {
                $sqlr="INSERT INTO result(course,session,m_num,lname,fname,mname,faculty,depart,level,test,exam) VALUES('$course','$session','$m_num','$lname','$fname','$mname','$faculty','$depart','$leve','0','0')";
                $findr = $con->query($sqlr);
            }
        } 
        else {
            $starterr = "<h2>Record shows that you have participated in the ongoing <span style='text-transform: lowercase;'>$type</span>, Please call a nearby administrator if this is untrue.</h2>";
        }
    }

    $result = $con->query("SELECT * FROM question WHERE c_code='$ongoing_exam' AND exam_session='$session' AND type='$type' ORDER BY RAND()");
    $count = mysqli_num_rows($result);

    $resultpag = $con->query("SELECT * FROM question WHERE c_code='$ongoing_exam' AND exam_session='$session' AND type='$type'");
    $countpag = mysqli_num_rows($resultpag);
	
	if (isset($_POST['yes'])) {
		$deletes = $con->query("DELETE FROM score_sheet WHERE m_num ='$m_num' AND course='$ongoing_exam' AND type='$type' AND session='$session'");
		$deleter = $con->query("DELETE FROM result WHERE m_num ='$m_num' AND course='$ongoing_exam' AND session='$session'");
		header("Location: test_start.php?ongoing_exam=$ongoing_exam");
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

    <title><?php echo $row['course_code']; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Modal CSS -->
    <link href="css/modal.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />
    <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />

</head>

<script src="jquery-1.11.1.min.js"></script>

<script>
$(document).ready(function() { 
var id = '#dialog';
//Get the screen height and width
var maskHeight = $(document).height();
var maskWidth = $(window).width();
//Set heigth and width to mask to fill up the whole screen
$('#mask').css({'width':maskWidth,'height':maskHeight});
//transition effect
$('#mask').fadeIn(500);
$('#mask').fadeTo("slow",0.9); 
//Get the window height and width
var winH = $(window).height();
var winW = $(window).width();
//Set the popup window to center
$(id).css('top',  winH/2-$(id).height()/2);
$(id).css('left', winW/2-$(id).width()/2);
//transition effect
$(id).fadeIn(2000);  
//if close button is clicked
$('.window .close').click(function (e) {
//Cancel the link behavior
e.preventDefault();
$('#mask').hide();
$('.window').hide();
});
//if mask is clicked
$('#mask').click(function () {
$(this).show();
$('.window').show();
});
});
</script>

<script>
	$(document).ready(function(){
		$('input.flat-red').on('change',function () {
			var row = $(this).closest('.active');
			var decision = $(this).val();
			var que = row.find(".que").val();
			//var autosavenotify = row.find(".autosavenotify").val();
			var id = $('span.myid').html();
			var vercourse = $('span.vercourse').html();
			var pag = $('span.pag').html();
			$.ajax({
				type: "POST",
				url: "process.php",
				data: {decision: decision, id: id, vercourse: vercourse, que: que, pag: pag},
				success: function(msg) {
					$('.autosavenotify').html(msg);
				}
			})
		});
	});
	
$(function() {
	$('input.flat-red').on('change',function () {
		$('.autosavenotify').delay(800).show().fadeOut('slow');
	});
});
</script>

<script>
// $("#startTimer").click( function(){
	var seconds = 60 * <?php echo $row['time']; ?>;
	function secondPassed() {
		var minutes = Math.round((seconds - 30)/60);
		var remainingSeconds = seconds % 60;
		if (remainingSeconds < 10) {
			remainingSeconds = "0" + remainingSeconds;  
		}
		document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
		if (seconds == 0) {
			clearInterval(countdownTimer);
			document.getElementById('countdown').innerHTML = "0:00"
			document.getElementById('examq').innerHTML = "<h2 style='text-align:center; color: red; margin-top:50px;'>Time up!</h2><br> <h3 style='text-align:center; margin-top:-20px;'>Work done so far successfully submitted. Fear Not!</h3>";
		} else {
			seconds--;
		}
	}						 
	var countdownTimer = setInterval('secondPassed()', 1000);
// });
</script>

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
                <a class="navbar-brand" href="#"><img style="margin-top: -15px; margin-left: -15px; width:225px; height:50px;" src="logo.jpg"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li style="color:#ffffff; padding: 2px 15px 2px 15px; border-right: 2px dotted white; line-height:42px;"><font size="5px"> <?php echo $_SESSION["MT"];?> </font></li>
                <li style="color:#ffffff; padding: 2px 15px 2px 15px; line-height:42px;"><font size="5px"><?php echo $_SESSION["FA"];?> - <?php echo $_SESSION["DP"];?></font></li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                    <div style="background-image: url(profilepictures/default1.jpg); width: 150px; height: 150px; margin-left: 28px; border-radius: 200px">              
                        <img style="width: 150px; height: 150px; border-radius: 200px" src="profilepictures/<?php echo $_SESSION['MT']; ?>.jpg">
                    </div><br/>
                    <p align="center" style="color: #ffffff;">Logged in as: <br>
                    <?php echo $_SESSION["LN"];?> <?php echo $_SESSION["FN"];?>! </p>

                    <div >
						<input type="hidden" class="mat_no" value="<?php echo $m_num; ?>">
						<input type="hidden" class="course" value="<?php echo $course ?>">
						<input type="hidden" class="session" value="<?php echo $session; ?>">
						<input type="hidden" class="type" value="<?php echo $type; ?>">
                        <li>
                            <?php
                                if ($starterr == false) { ?>
                                    <a href="#" class="btn btn-success col-lg-6 pull-center end" style="margin-left: 50px; margin-top: 40px;" data-toggle="modal" data-target="#confirmend">End <?php echo $type; ?></a>
                                <?php } else { 
                            ?>
                                    <a href="test.php" class="btn btn-success col-lg-6 pull-center" style="margin-left: 50px; margin-top: 40px;">Close</a>
									<a href="#" class="btn btn-success col-lg-6 pull-center review" style="margin-left: 50px; margin-top: 40px;">Review</a>
									<a href="#" class="btn btn-success col-lg-6 pull-center" style="margin-left: 50px; margin-top: 40px;" data-toggle="modal" data-target="#reattempt">Re-attempt</a>
                                <?php }
                            ?>
                        </li>
                    </div>
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
                            <p><span class="vercourse"><?php echo $row['course_code']; ?></span> <?php echo $type; ?></p>
                            <small><?php echo $row['course_title']; ?></small>
                        </h1>
                        <ol class="breadcrumb" style="text-align: right;">
                            <li>
                                <?php
                                    if ($starterr == false) { ?>
                                        <font size="5"><span id="countdown" class="timer"></span></font>
                                    <?php } else {
                                ?>
                                        <font size="5"><span>0:00</font>
                                    <?php }
                                ?>
                            </li>
                        </ol>
                    </div>

                    <div id="examq">
                     <?php
                        if ($starterr == true) { ?>
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div><i class="glyphicon glyphicon-exclamation-sign fa-5x"></i></div>
                                    <font size="4"><div><?php echo $starterr; ?></div></font>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else { ?>

                        <div class="tab-content">
                            	<?php if ($count > 0) {?>
                            	<?php $i = 1; ?>
                            	<div role="tabpanel" class="tab-pane" id="previous">Previous Loading.....</div>
                            	<div role="tabpanel" class="tab-pane" id="next">Next Loading.....</div>
			                        <?php while ( $row = $result->fetch_array(MYSQLI_BOTH)) { ?>
			                            <div  role="tabpanel" class="tab-pane <?php  if ($i == 1) {echo 'active'; } ?> cover" id="<?php echo $i; ?>">
			                                <p class="col-lg-12" align="center"><font size="5">Question <span class="quesno"><?php echo $i; ?></span>.</font></p>
											<p class="col-lg-12" align="center"><font size="5"><span class="myid"><?php echo $row['question']; ?></font></p>
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" class="flat-red" name="option<?php echo $row['id']; ?>" value="a" id="option1">
                                                    </span>
                                                    <strong><input type="text" class="form-control" value="<?php echo $row['option_a']; ?>" readonly=""></strong>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" class="flat-red" name="option<?php echo $row['id']; ?>" value="b" id="option2">
                                                    </span>
                                                    <strong><input type="text" class="form-control" value="<?php echo $row['option_b']; ?>" readonly=""></strong>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" class="flat-red" name="option<?php echo $row['id']; ?>" value="c" id="option3">
                                                    </span>
                                                    <strong><input type="text" class="form-control" value="<?php echo $row['option_c']; ?>" readonly=""></strong>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" class="flat-red" name="option<?php echo $row['id']; ?>" value="d"  id="option4">
                                                    </span>
                                                    <strong><input type="text" class="form-control" value="<?php echo $row['option_d']; ?>" readonly=""></strong>
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                            <input type="hidden" class="que" value="<?php echo $row['id']; ?>"> 
                                            
			                            </div> 
			                        <?php $i++; } ?>
			                    <?php } ?>
                        <div class="autosavenotify"></div>
                    <!-- Nav tabs -->
                        <div class="col-lg-12" align="center">
                            <ul class="pagination" role="tablist">
                                <?php if ($countpag > 0) {?>
    			                    <?php $i = 1;
    			                        while ( $rowpag = $resultpag->fetch_array(MYSQLI_BOTH)) { ?>
                                            <!-- <li class="previous" role="presentation"><a href="#<?php echo $i - 1; ?>" aria-controls="<?php echo $i - 1; ?>" role="tab" data-toggle="tab">Previous</a></li> -->
                                            <li <?php  if ($i == 1) {echo "class='active'"; } ?> role="presentation">
												<a
													href="#<?php echo $i; ?>"
													id="pgtn<?php echo $i; ?>"
													aria-controls="<?php echo $i; ?>"
													role="tab" 
													data-toggle="tab"
												>
													<span class="pag"><?php echo $i; ?></span>
												</a>
											</li> 
                                	        <!-- < class="next" role="presentation"><a href="#<?php echo $i + 1; ?>" aria-controls="<?php echo $i + 1; ?>" role="tab" data-toggle="tab">Next</a></li> -->
                                    <?php $i++; } ?>                            
    			                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Confirm End -->
                <div id="confirmend" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" align="center"><i class="fa  fa-exclamation-circle"></i> Confirmation</h4>
                            </div>
                            <div class="modal-body">
                                <p>You have <span class="unans"></span> questions left unanswered</p>
                                <!--<p>Question numbers: <span class="list"></span></p><br>
                                <h4 style="text-align:center">Are you sure you want to submit?</h4>-->
                            </div>
                            <div class="modal-footer clearfix">
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#successful" data-dismiss="modal" class="btn btn-success" >Submit &amp; End <?php echo $type; ?></a>
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
				
				<!-- Re-Attempt -->
                <div id="reattempt" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" align="center"><i class="fa  fa-exclamation-circle"></i> Confirm Re-attempt</h4>
                            </div>
                            <div class="modal-body" align="center">
                                <h3 style="text-align:center">Would you like to re-attempt this course?</h3>
                            </div>
                            <div class="modal-footer clearfix">
								<form role="form" action="" method="post" class="login-form">
									<button type="submit" name="yes" class="btn btn-success pull-right"><i class="glyphicon glyphicon-ok"></i> Yes</button>
								</form>
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

            <!-- successful -->
                <div id="successful" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2 align="center">Submission Successful!</h2>
                            </div>
                            <div class="modal-footer clearfix">
								<input type="hidden" class="mat_no" value="<?php echo $m_num; ?>">
								<input type="hidden" class="course" value="<?php echo $course ?>">
								<input type="hidden" class="session" value="<?php echo $session; ?>">
								<input type="hidden" class="type" value="<?php echo $type; ?>">
                                <a href="test.php" class="btn btn-success">OK!</a>
                            </div>
                            </form>
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
	
	<script>
        $(".end").click(function(){
			var row = $(this).closest('div');
            var mat_no = row.find(".mat_no").val();
            var type = row.find(".type").val();
            var course = row.find(".course").val();
            var session = row.find(".session").val();
			$.ajax({
				type: "POST",
				url: "confirm.php",
				data: {course: course, type: type, session: session, mat_no: mat_no},
				success: function(msg) {
					$("span[class='unans']").html(msg);
				}
			}) 
		}) 
    </script>
	<script>
        $(".end").click(function(){
			var row = $(this).closest('div');
            var mat_no = row.find(".mat_no").val();
            var type = row.find(".type").val();
            var course = row.find(".course").val();
            var session = row.find(".session").val();
			$.ajax({
				type: "POST",
				url: "confirmqno.php",
				data: {course: course, type: type, session: session, mat_no: mat_no},
				success: function(msg) {
					$("span[class='list']").html(msg);
				}
			}) 
		})
		
        $(".review").click(function(){
			var row = $(this).closest('div');
            var mat_no = row.find(".mat_no").val();
            var type = row.find(".type").val();
            var course = row.find(".course").val();
            var session = row.find(".session").val();		
            var url = "test_start.php";
			$.ajax({
				type: "POST",
				url: "load.php",
				data: {course: course, type: type, session: session, mat_no: mat_no},
				success: function(msg) {
					$("div#examq").html(msg);
				}
			})
		})
		
        $(document).ready(function(){
			$("input:radio[class=flat-red]").click(function() {
				var row = $(this).closest('div.cover');
				var quesno = row.find(".quesno").text();
				$("#pgtn" + quesno).css("background-color", "#5CB85C");
			})
		})
    </script>

</body>
</html>
