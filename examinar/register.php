<?php
    require 'connection.php' 
?>

<?php
    if (isset($_POST['register'])) {
		$filename = $_FILES["file"]["name"];
		//$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$name = $_POST["form-matric"];
		$filesize = $_FILES["file"]["size"];
		$maxsize = 2 * 1024 * 1024;
		$allowed_file_types = array('.jpg');
		$file_ext = substr($filename, strripos($filename, '.'));
		
        $mat_no = mysqli_real_escape_string($con, $_POST['form-matric']);
        $sname = mysqli_real_escape_string($con, ucfirst($_POST['form-surname']));
		$fname = mysqli_real_escape_string($con, ucfirst($_POST['form-firstname']));
        $mname = mysqli_real_escape_string($con, ucfirst($_POST['form-middlename']));
		$pword = mysqli_real_escape_string($con, strtolower($_POST['form-surname']));
		$faculty = mysqli_real_escape_string($con, $_POST['form-faculty']);
        $dept = mysqli_real_escape_string($con, $_POST['form-department']);
		$level = mysqli_real_escape_string($con, $_POST['form-level']);
		$wcontact = mysqli_real_escape_string($con, $_POST['form-wcontact']);

		$result = $con->query("SELECT * FROM student_login WHERE mat_no = '$mat_no'");
		
		$row = $result->fetch_array(MYSQLI_BOTH);
		if(!empty($row)){ 
			 $msg = "<button id='btnuser' class='btn btn-danger col-lg-12' disabled=''>User exist!!</button>";
		}elseif (!in_array($file_ext,$allowed_file_types)) {
			// file type error
			$msg = "<button id='btnuser' class='btn btn-danger col-lg-12' disabled=''>Only JPG or JPEG image type is allowed.</button>";
		}elseif ($filesize > $maxsize) {
			// file size error
			$msg = "<button id='btnuser' class='btn btn-danger col-lg-12' disabled=''>Maximum image size is 2mb.</button>";
		}else {
			move_uploaded_file($_FILES["file"]["tmp_name"], "profilepictures/".$name."".$file_ext);
			$sql="INSERT INTO student_login(mat_no,firstname,middlename,lastname,contact,password,faculty,department,level) VALUES('$mat_no','$fname','$mname','$sname','$wcontact','$pword','$faculty','$dept','$level')";
			$find = $con->query($sql);
			echo("<script>location.href = 'reload.php?success=true';</script>");
			//header("Location: index.php?success=true");
			//header("Location: index.php");
		}
    }
	
    $get_depts = $con->query("SELECT * FROM department ORDER BY dept ASC");
    $count_depts = mysqli_num_rows($get_depts);
	
	$get_faculty = $con->query("SELECT * FROM faculty ORDER BY falc_abbr ASC");
    $count_faculty = mysqli_num_rows($get_faculty);
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>REGISTRATION</title>

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
    		
            <div class="inner-bg-register">
                <p style="color: white"><strong>
                    Click <a href="https://api.whatsapp.com/send?phone=2347019898511">here</a> to start a conversation on whatsapp<br />
                    Click <a href="http://realcrowntech.com/">here</a> to know more about the developer</strong>
                </p>
                <img src="assets/ico/logo.jpg">    
            </div>
        	
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                                <div class="form-top-left">
                                    <h3>REGISTRATION FROM</h3>
                                    <p>All Fields Are Required</p>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-key"></i>
                                </div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="register.php" method="post" enctype="multipart/form-data">
                                    <?php if(isset($msg)){ echo $msg;}?>
			                    	<!-- <div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-matric">Matric No</label>
			                        	<input type="text" name="form-matric" placeholder="Matric Number" class="form-matric form-control" id="form-matric" required="" value="<?php echo isset($mat_no) ? $mat_no : ''; ?>" maxlength="6" onkeypress="return isNumber(event)">
			                        </div> -->
			                        <div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-matric">Matric No</label>
			                        	<input type="text" name="form-matric" placeholder="Matric Number" class="form-matric form-control" id="form-matric" required="" value="<?php echo isset($mat_no) ? $mat_no : ''; ?>" maxlength="15">
			                        </div>
			                        <div class="form-group col-md-6">
			                        	<label class="sr-only" for="form-surname">Surname</label>
			                        	<input type="text" name="form-surname" placeholder="Surname" class="form-surname form-control" id="form-surname" required="" value="<?php echo isset($sname) ? $sname : ''; ?>">
			                        </div>
									<div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-firstname">First Name</label>
			                        	<input type="text" name="form-firstname" placeholder="First Name" class="form-firstname form-control" id="form-firstname" required=""  value="<?php echo isset($fname) ? $fname : ''; ?>">
			                        </div>
									<div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-middlename">Middle Name</label>
			                        	<input type="text" name="form-middlename" placeholder="Middle Name" class="form-middlename form-control" id="form-middlename" required="" value="<?php echo isset($mname) ? $mname : ''; ?>">
			                        </div>
									<div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-faculty">Faculty</label>
										<select class="form-control formselect" name="form-faculty" required=""></option>
                                            <option>--Faculty--</option>
											<?php
												while ($row_faculty = $get_faculty->fetch_array(MYSQLI_BOTH)) { ?>
												<option value="<?php echo $row_faculty['falc_abbr']; ?>"><?php echo $row_faculty['falc_abbr']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group col-md-6">
										<label class="sr-only" for="form-department">Department</label>
										<select class="form-control formselect" name="form-department" required="">
										</select>
			                        </div>
									<div class="form-group col-md-6">
			                    		<label class="sr-only" for="form-level">Level</label>
			                        	<select class="form-control formselect" name="form-level" required="">
                                            <option value="">--Level--</option>
											<option value="100">100</option>
											<option value="200">200</option>
											<option value="300">300</option>
											<option value="400">400</option>
											<option value="500">500</option>
										</select>
			                        </div>
									<div class="col-md-4 file btn btn-md btn-default" id="fileupload">
										Profile Picture
										<input type="file" name="file" class="form-upload" id="form-upload" required=""/>
									</div>
									<div class="form-group col-md-12">
			                        	<label class="sr-only" for="form-surname">Whatsapp Contact</label>
			                        	<input type="text" name="form-wcontact" placeholder="Whatsapp Contact" class="form-wcontact form-control" id="form-wcontact" required="" value="<?php echo isset($wcontact) ? $wcontact : ''; ?>" maxlength="11" onkeypress="return wNumber(event)">
			                        </div>
			                        <button type="submit" class="btn" name="register" data-toggle="modal" data-target="#successful">Register!</button>
			                    </form>
								<div class="register">
									Already a member: <a href="index.php" class="blink_me">Sign In</a>
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
        <script>
            function wNumber(evt) {
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
		
		<script>
			$( "select[name='form-faculty']" ).change(function () {
				var facultyID = $(this).val();

				if(facultyID) {

					$.ajax({
						url: "ajaxpro.php",
						dataType: 'Json',
						data: {'id':facultyID},
						success: function(data) {
							$('select[name="form-department"]').empty();
							$.each(data, function(key, value) {
								$('select[name="form-department"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
						}
					});

				}else{
					$('select[name="form-department"]').empty();
				}
			});
		</script>

    </body>

</html>