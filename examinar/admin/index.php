<?php 
 require 'connection.php'; 
    session_start();

    if (isset($_GET['logout'])) { 
        unset($_SESSION['AID']);
        $msg = 
            "<div class='alert alert-success' role='alert'>
                <strong>Success!</strong> You are successfully logged out
            </div>";
    }

    if (isset($_POST['login'])) {
        $UN = $_POST['form-username'];
        $PW = $_POST['form-password'];

        $result = $con->query("SELECT * FROM admin_login WHERE username = '$UN' AND password = '$PW'");
    
        $row = $result->fetch_array(MYSQLI_BOTH);
        if(empty($row)){ 
            $msg = 
            "<div class='alert alert-success' role='alert'>
                <strong>Error!</strong> Incorrect Login Details
            </div>";
        }else{
            //session_start();
            $_SESSION["AID"]=$row['aid'];
            $_SESSION["LN"]=$row['lastname'];
            $_SESSION["FN"]=$row['firstname'];
            $_SESSION["UN"]=$row['username'];
            echo("<script>location.href = 'dashboard.php';</script>");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LOGIN - Admin</title>

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

            <div  class="inner-bg-login">
                <img src="assets/ico/logo.jpg">    
            </div>
            
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>ADMIN LOGIN</h3>
                                    <p>Enter Your Username &amp; Password To Login</p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
                                <form role="form" action="" method="post" class="login-form">
                                    <?php if(isset($msg)){ echo $msg;}?>
                                    <div class="form-group col-lg-12">
                                        <label class="sr-only" for="form-username">Username</label>
                                        <input type="text" name="form-username" placeholder="Username" class="form-username form-control" id="form-username">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="form-password" placeholder="Password" class="form-password form-control" id="form-password">
                                    </div>
                                    <button type="submit" class="btn" name="login">Sign in!</button>
                                </form>
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
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>