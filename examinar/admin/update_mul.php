<?php
include_once 'connection.php';
$id = $_POST['id'];
$course_code = $_POST['course_code'];
$time = $_POST['time'];
$type = $_POST['typ'];
$exam_ses = $_POST['exam_ses'];
//$chk = $_POST['chk'];
$active = $_POST['active'];
$chkcount = count($id);
for($i=0; $i<$chkcount; $i++)
{
    $con->query("UPDATE exam_type SET course_code='$course_code[$i]', time='$time[$i]', type='$type[$i]', exam_session='$exam_ses[$i]', active='$active[$i]' WHERE id=".$id[$i]);
    ?>
	        <script>
	        	alert('Operation Successful.');
	        	window.location.href = 'exam_menu2.php';
	        </script>
	    <?php
}
?>