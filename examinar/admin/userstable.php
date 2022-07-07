<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>


<?php //Pagination
        $offset = 0;
        $count_all = mysqli_num_rows($con->query("SELECT * FROM student_login"));
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];   
          }
        $limit = 10;
?>

<?php
	if (isset($_POST['edituser'])) {
		$MT = $_POST['matricnumber'];
		$FN = strtoupper($_POST['firstname']);
        $MN = strtoupper($_POST['middlename']);
        $LN = strtoupper($_POST['lastname']);
        $PW = strtolower($_POST['password']);
        $LE = $_POST['level'];
        $CO = $_POST['contact'];

        $update = $con->query("UPDATE student_login SET firstname='{$FN}', lastname='{$LN}', middlename='{$MN}', contact='{$CO}', password='{$PW}', level='{$LE}' WHERE mat_no ='{$MT}'");
	}
?>


<?php
    $get_faculty = $con->query("SELECT * FROM faculty ORDER BY falc_abbr ASC");
    $count_faculty = mysqli_num_rows($get_faculty);
?>

<?php
    if (isset($_POST['adduser'])) {
        session_start();
        $fn = strtoupper($_POST['firstname']);
        $mn = strtoupper($_POST['middlename']);
        $ln = strtoupper($_POST['lastname']);
        $pw = strtolower($_POST['lastname']);
        $fa = strtoupper($_POST['faculty']);
        $de = ucfirst($_POST['department']);
        $le = $_POST['level'];
        $co = $_POST['contact'];
        $matric_no = $_POST['matric_no'];

        $sql = $con->query("INSERT INTO student_login(mat_no, firstname, middlename, lastname, password, faculty, department, level, contact) VALUES('{$matric_no}', '{$fn}', '{$mn}', '{$ln}', '{$pw}', '{$fa}', '{$de}', '{$le}', '{$co}')");

        header("Location: userstable.php");
        header("Location: userstable.php");
    }
?>


<?php
    $duid = '';
    if (isset($_GET['duid'])) {
        $duid = $_GET['duid'];
        $delete = $con->query("DELETE FROM student_login WHERE id = $duid");
    }
?>

<?php
$result = $con->query("SELECT * FROM student_login ORDER BY mat_no LIMIT $offset, 10");
$count = mysqli_num_rows($result);
$output = '';

//if the search input field exist

    if (isset($_GET['search'])) {
        $searchq = $_GET['search'];

//if the search input is empty, display all table rows that has privelege 0

        if ($searchq == '') {
            $result = $con->query("SELECT * FROM student_login ORDER BY mat_no");
            $count = mysqli_num_rows($result);
        }

//else, if the search input is not empty, return the table row where the fname matches with the search value or the lname matches with the search value and the output result should be the row that has privelege 0 alone

        else{
            $result = $con->query("SELECT * FROM student_login WHERE mat_no LIKE'%$searchq%' OR firstname LIKE '%$searchq%' OR lastname LIKE '%$searchq%'  ORDER BY mat_no");
            $count = mysqli_num_rows($result);

//if the search value does not exist in the table, display user not found

        if ($count == 0) {
            $output = "<div style='width: 100%px; height: 40px; background-color: #00CED1; color: #ffffff; text-align: center; margin-top: 30px;'><p style='line-height:35px;'>Record not found<p></div>";
        }

//else display the row that matches with the search value

        else{
            $output = '';
            
        }
        }
        
    }
?>

<?php
    $getlevdept = $con->query("SELECT * FROM student_login");
    $getit = mysqli_num_rows($getlevdept);
    
    if (isset($_POST['btngo'])) {
        $dept = $_POST['dbdept'];
        $lev = $_POST['dblevel'];

        if ($dept == '' AND $lev == '') {
            $result = $con->query("SELECT * FROM student_login");
            $count = mysqli_num_rows($result);
        }else{
            $result = $con->query("SELECT * FROM student_login WHERE department = '$dept' AND level = '$lev' ORDER BY mat_no");
            $count = mysqli_num_rows($result);

            if ($count == 0) {
            $output = "<div style='width: 100%px; height: 40px; background-color: #00CED1; color: #ffffff; text-align: center; margin-top: 30px;'><p style='line-height:35px;'>Record not found<p></div>";
        }else{
            $output = '';            
        }
        }
    }
?>

<?php
    $deptlevstatus = '';
    if (isset($_POST['btngo'])) {
        $dept = $_POST['dbdept'];
        $lev = $_POST['dblevel'];

        $deptlevstatus = "<i class='fa fa-group'></i> Search result for $lev Level $dept students";
    }else{
        $deptlevstatus = "<i class='fa fa-users'></i> ALL USERS";
    }
?>

<?php
    $get_dept = $con->query("SELECT * FROM department ORDER BY dept ASC");
    $count_dept = mysqli_num_rows($get_dept);
?>

<?php
    $get_depts = $con->query("SELECT * FROM department ORDER BY dept ASC");
    $count_depts = mysqli_num_rows($get_depts);
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

    <link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />
    <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />

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
                <a class="navbar-brand" href="#"><img style="margin-top: -15px; margin-left: -15px; width:225px; height:50px;" src="logo.jpg"></a>
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
            <ul class="nav navbar-right top-nav">
                <form action="userstable.php?search=<?php echo $_GET['search']; ?>" method="GET" class="sidebar-form">
                    <div class="input-group" style="width:500px; margin-top:8px;">
                      <input type="text" name="search" class="form-control" placeholder="Search with Matric Number or Names........."/>
                      <span class="input-group-btn">
                        <button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                </form>
            </ul>
            <ul class="nav navbar-right top-nav">
                <a href="#" data-toggle="modal" data-target="#myModaladd"><img src="user_add.jpg" width="50px" height="50px"></a>
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
                    <li class="active">
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
                            USERS TABLE
                        </h1>
                        <ol class="breadcrumb">
                            <li><?php echo $deptlevstatus; ?></li>
                            <form action="" method="post">
                                <div class="input-group input-group-sm">
                                    <select class="form-control" name="dblevel" style="width:100px; float:right; margin-top:-23px;" required>
                                        <option value="">Level</option>
                                        <option value="100">100 Level</option>
                                        <option value="200">200 Level</option>
                                        <option value="300">300 Level</option>
                                        <option value="400">400 Level</option>
                                    </select>
                                    <select class="form-control" name="dbdept" style="width:130px; float:right; margin-top:-23px;" required>
                                        <option value="">Department</option>
                                        <?php
                                            while ($row_dept = $get_dept->fetch_array(MYSQLI_BOTH)) { ?>
                                            <option value="<?php echo $row_dept['dept']; ?>"><?php echo $row_dept['dept']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-flat" name="btngo" type="submit" style="float:right; margin-top:-23px;">Go!</button>
                                    </span>
                                </div><!-- /input-group -->
                                <!-- <button name="btngo" type="submit" style="float:right; margin-top:-24px;">Go</button> -->
                            </form>
                        </ol>                        
                    </div>
                </div>
                <!-- /.row -->
                <div>
                <?php echo("$output")?>
                    <table id="example1" class="table table-bordered table-striped">
                    <?php if ($count > 0) {?>
                        <tr>
                        	<th style="width:1%;">SN</th>
                            <th style="width:9%;">M~Number</th>
                            <th style="width:18%;">Full Names</th>
                            <th style="width:9%;">Contact</th>
                            <th style="width:15%;">Department</th>
                            <th style="width:2%;" align="center">Level</th>
                            <th style="width:2%;" hidden>Password</th>
                            <th style="width:1%;">Edit</th>
                            <th style="width:1%;">Delete</th>
                        </tr>
                        <?php $i = 1;
	                        while ( $row = $result->fetch_array(MYSQLI_BOTH)) { ?>
	                        <tr>
	                        	<td style="width:1%;" align="center"><?php echo $i; ?></td>
	                            <td style="width:9%;" class="tdid"><?php echo $row['mat_no']; ?></td>
	                            <td style="width:9%;"><span class="tdlastname"><?php echo $row['lastname']; ?></span> <span class="tdfirstname"><?php echo $row['firstname']; ?></span> <span class="tdmiddlename"><?php echo $row['middlename']; ?></span></td>
	                            <td style="width:9%;" class="tdcontact"><?php echo $row['contact']; ?></td>
	                            <td style="width:9%;" class="tddepartment"><?php echo $row['department']; ?></td>
	                            <td style="width:2%;" align="center" class="tdlevel"><?php echo $row['level']; ?></td>
	                            <td style="width:2%;" align="center" class="tdpassword" hidden><?php echo $row['password']; ?></td>
	                            <td style="width:1%;" class="tdedit" align="center"><a href="#"><img data-toggle="modal" data-target="#myModaledit" align="center" width="30px" height="20px" src="user_edit.jpg"></a></td>
	                            <td style="width:1%;" class="tddelete" align="center"><a  onclick="deluser(event)" href="userstable.php?duid=<?php echo $row["id"]; ?>"><img align="center" width="30px" height="20px" src="user_delete.jpg"></a></td>
	                        </tr>                                           
                        <?php $i++; } ?>
                    <?php } ?>
                    </table>
                </div>

                <div align="right">
                    <ul class="pagination">
                        <?php 
                            $per_page = $count_all/$limit;
                            $offset2=0;
                            for ($x=1; $x < $per_page+1; $x++) { 
                                if($offset2 == $offset){
                                    echo "<li  class='active'><a href='userstable.php?offset=$offset2'>$x</a></li>";
                                }else{
                                     echo "<li><a href='userstable.php?offset=$offset2'>$x</a></li>";
                                }
                                $offset2 = $x*$limit;
                            }
                        ?>
                    </ul>
                </div> 

                <!-- Edit Modal -->
                <div id="myModaledit" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" align="center">EDIT USER FORM</h4>
                            </div>
                            <form action="" method="post">
                            <div class="modal-body">
                                <div class="modal-body">
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Matric Number:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="matricnumber" value="" readonly="">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">First Name:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="firstname" value="">
                                    </div> 
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Middle Name:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="middlename"value="">
                                    </div> 
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Last Name:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="lastname" value="">
                                    </div> 
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Contact:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="contact" value="">
                                    </div> 
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Password:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="password" value="">
                                    </div>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon">Level:</span>
                                        <input style="text-align:right" type="text" class="form-control" name="level" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default" name="edituser">Save Edit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Add Modal -->
                <div id="myModaladd" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><i class="fa fa-user"></i> Add New User</h4>
                            </div>
                            <form action="" method="post">
                            <div class="modal-body">
                            	<div class="form-group input-group">
                                    <span class="input-group-addon">Matric No:</span>
                                    <input type="text" class="form-control" name="matric_no" value="" required>
                                </div> 
                                <div class="form-group input-group">
                                    <span class="input-group-addon">First Name:</span>
                                    <input type="text" class="form-control" name="firstname" value="" required>
                                </div> 
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Middle Name:</span>
                                    <input type="text" class="form-control" name="middlename"value="" required>
                                </div> 
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Last Name:</span>
                                    <input type="text" class="form-control" name="lastname" value="" required>
                                </div> 
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Faculty:</span>
                                    <select class="form-control" name="faculty" required>
                                        <option value="--Choose--">--Choose--</option>
                                        <?php
                                            while ($row_faculty = $get_faculty->fetch_array(MYSQLI_BOTH)) { ?>
                                            <option value="<?php echo $row_faculty['falc_abbr']; ?>"><?php echo $row_faculty['falc_abbr']; ?></option>
                                        <?php } ?>
                                    </select>
								</div>
                                <div class="form-group input-group">
                                                <span class="input-group-addon">Department of:</span>
												<select class="form-control" name="department" required>
                                                    <option value="--Choose--">--Choose--</option>
												    <?php
                                                        while ($row_depts = $get_depts->fetch_array(MYSQLI_BOTH)) { ?>
                                                        <option value="<?php echo $row_depts['dept']; ?>"><?php echo $row_depts['dept']; ?></option>
                                                    <?php } ?>
												</select>
								</div> 
                                <div class="form-group input-group">
                                                <span class="input-group-addon">Level:</span>
												<select class="form-control" name="level" required>
												  <option value="--Choose--">--Choose--</option>
												  <option value="100">100</option>
												  <option value="200">200</option>
												  <option value="300">300</option>
												  <option value="400">400</option>
                                                  <option value="500">500</option>
												</select>
								</div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">Contact:</span>
                                    <input type="text" class="form-control" name="contact" value="" required>
                                </div> 
                            </div>
                            <div class="modal-footer clearfix">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                <button name="adduser" type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Add User</button>
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
            $(".tdedit").click(function(){

//alert('edit is working');
                var row = $(this).closest('tr');
                var tdid = row.find(".tdid").text();
                var tdlastname = row.find(".tdlastname").text();
                var tdfirstname = row.find(".tdfirstname").text();
                var tdmiddlename = row.find(".tdmiddlename").text();
                var tdcontact = row.find(".tdcontact").text();
                var tddepartment = row.find(".tddepartment").text();
                var tdlevel = row.find(".tdlevel").text();
                var tdpassword = row.find(".tdpassword").text();

                //alert(q);
                
                $("input[name='matricnumber']").val(tdid);
                $("input[name='lastname']").val(tdlastname);
                $("input[name='firstname']").val(tdfirstname);
                $("input[name='middlename']").val(tdmiddlename);
                $("input[name='contact']").val(tdcontact);
                $("input[name='department']").val(tddepartment);
                $("input[name='level']").val(tdlevel); 
                $("input[name='password']").val(tdpassword);                         

                //var myText =  row.find(".status2").val(); 
                //var status = myText.toUpperCase();
                //alert(myText);

				//$("#status option[text='APPROVED']").attr("selected","selected");
				//$("select#status option")
				   //.each(function() { this.selected = (this.text == myText); });
		})
            
    </script>

</body>

<script type="text/javascript">
    function deluser(e) {
        if(confirm ('Are you sure you want to delete this user?')){
            return true;
        } else{ 
            e.preventDefault();}
    }
</script>

</html>
