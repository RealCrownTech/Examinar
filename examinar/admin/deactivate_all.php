<?php
include_once 'connection.php';
	$time = '-----';
	$type = '-----';
	$active = 'no';
	$exam_ses = '-----';
	$con->query("UPDATE exam_type SET time='$time', type='$type', exam_session='$exam_ses', active='$active'");
	header("Location: exam_menu2.php");
?>