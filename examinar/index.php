<?php 
    require 'connection.php'; 
    session_start();

    if (isset($_GET['logout'])) { 
        unset($_SESSION['ID']);
        $msg = 
            "<div class='alert alert-success' role='alert'>
                <strong>Success!</strong> You are successfully logged out
            </div>";
    }

    if (isset($_POST['login'])) {
        $UN = mysqli_real_escape_string($con, $_POST['form-username']);
        $PW = mysqli_real_escape_string($con, $_POST['form-password']);

		$result = $con->query("SELECT * FROM student_login WHERE mat_no = '$UN' AND password = '$PW'");
		
		$row = $result->fetch_array(MYSQLI_BOTH);
		if(empty($row)){ 
			 $msg =  
             "<div class='alert alert-danger' role='alert'>
                <strong>Error!</strong> Incorrect Login Details
            </div>";
		}else{

			//session_start();
		$_SESSION["ID"]=$row['id'];
		$_SESSION["MT"]=$row['mat_no'];
		$_SESSION["LN"]=$row['lastname'];
		$_SESSION["FN"]=$row['firstname'];
		$_SESSION["MN"]=$row['middlename'];
		$_SESSION["FA"]=$row['faculty'];
		$_SESSION["DP"]=$row['department'];
		$_SESSION["LV"]=$row['level'];
		echo("<script>location.href = 'test.php';</script>");
		 //header('Location: test.php');   
		}
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LOGIN - Student</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.jpg">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg-login">
                <img src="assets/ico/logo.jpg">    
            </div>
        	
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                                <div class="form-top-left">
                                    <h3>STUDENT LOGIN</h3>
                                    <p>Enter Your Matric Number &amp; Surname To Login</p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
                                    <?php if(isset($msg)){ echo $msg;}?>
			                    	<!-- <div class="form-group col-lg-12">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Matric Number" class="form-username form-control" id="form-username" maxlength="6" onkeypress="return isNumber(event)">
			                        </div> -->
			                        <div class="form-group col-lg-12">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Matric Number" class="form-username form-control" id="form-username" maxlength="15">
			                        </div>
			                        <div class="form-group col-lg-12">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Surname" class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn" name="login">Sign in!</button>
			                    </form>
								<div class="register">
									New member: <a href="register.php" class="blink_me">Register</a>
								</div>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        <script>
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        </script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>