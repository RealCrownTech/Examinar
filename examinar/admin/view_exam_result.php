<?php
    session_start();
    if (isset($_SESSION["AID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php';
?>

<?php
    if (isset($_GET['session']) && isset($_GET['department']) && isset($_GET['course']) && isset($_GET['level'])) {
        error_reporting(0);
        $ss = $_GET['session'];
        $de = $_GET['department'];
        $co = $_GET['course'];
        $le = $_GET['level'];
    }
?>

<?php
    $ss = $_GET['session'];
    $de = $_GET['department'];
    $co = $_GET['course'];
    $le = $_GET['level'];
    $result = $con->query("SELECT * FROM result where session='$ss' AND depart='$de' AND course='$co' AND level='$le' ORDER BY m_num ASC");  
    $count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>RESULT</title>
</head>
<body>
	<table  width="100%" border="1" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center"><strong>Sn</strong></td>
            <td align="center"><strong>Matric No</strong></td>
            <td align="center"><strong>Full Names</strong></td>
            <td align="center"><strong>Exam Score</strong></td>
        </tr>
        <?php
        	if ($count > 0);
            $i = 1;
            while ($line = $result->fetch_array(MYSQLI_BOTH)) {
        ?>
        <tr>
            <td align="center"><?php echo $i; ?></td>
            <td align="center"><?php echo $line['m_num']; ?></td>
            <td><?php echo $line['lname'];?> <?php echo $line['fname'];?> <?php echo $line['mname'];?></td>
            <td align="center"><?php echo $line['exam']; ?></td>
        </tr>
        <?php
        	$i++; }
         ?>
    </table>
</body>
</html>