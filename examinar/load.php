<?php
    session_start();
    if (isset($_SESSION["ID"])) {
    } else {
        header("Location: index.php");
    }
    require 'connection.php' 
?>

<html>
<body>
<?php
	if (isset($_POST['mat_no'])) {
		$mat_no = $_POST['mat_no'];
		$type = $_POST['type'];
		$session = $_POST['session'];
		$course = $_POST['course'];
?>
	
	<div class='col-lg-12' style="text-align:center">
		<font size="13" color="blue">Showing performance by <?php echo $mat_no; ?> for <?php echo $session; ?> <?php echo $course; ?> <?php echo $type; ?>. </font>
	</div>
	<div class='col-lg-12' style="text-align:center">
		<font size="5">Note: Questions in red means you got the answer wrong while questions in green means you got the answer right.</font>
	</div>
<?php		
		$perf = $con->query("SELECT * FROM score_sheet WHERE m_num='$mat_no' AND type='$type' AND session='$session' AND course='$course'");
		$count_perf = mysqli_num_rows($perf);
		if ($count_perf > 0) {
			$i = 1;
			while ( $row = $perf->fetch_array(MYSQLI_BOTH)) { 
				$qid = $row['qid'];
				$quest = $con->query("SELECT * FROM question WHERE c_code='$course' AND exam_session='$session' AND type='$type' AND qid='$qid'");
				$fquest = $quest->fetch_array(MYSQLI_BOTH);
				?>
				<div role='tabpanel' class='tab-pane <?php  if ($i == 1) {echo 'active'; } ?>' id='<?php echo $i; ?>'>
					<p class='col-lg-12'><font size='5' <?php if ($row['coropt'] !== $row['usropt']) {echo "color='red'";} else {echo "color='green'";} ?> ><span class='myid'><?php echo $i; ?></span>. <?php echo $fquest['question']; ?></font></p>
					<div class='col-lg-12'>
						<div class='input-group'>
							<span class='input-group-addon'>
								<input type='radio' value='a' disabled=''  <?php if ($row['usropt'] === 'a') {echo 'checked';} ?> >
							</span>
							<strong><input type='text' class='form-control' <?php if ($row['coropt'] === 'a') {echo "style='color: green'";} ?> value="<?php echo $fquest['option_a']; ?>" disabled=''></strong>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class='col-lg-12'>
						<div class='input-group'>
							<span class='input-group-addon'>
								<input type='radio' value='b' disabled='' <?php if ($row['usropt'] === 'b') {echo 'checked';} ?> >
							</span>
							<strong><input type='text' class='form-control' <?php if ($row['coropt'] === 'b') {echo "style='color: green'";} ?> value="<?php echo $fquest['option_b']; ?>" disabled=''></strong>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class='col-lg-12'>
						<div class='input-group'>
							<span class='input-group-addon' >
								<input type='radio' value='c' disabled='' <?php if ($row['usropt'] === 'c') {echo 'checked';} ?> >
							</span>
							<strong><input type='text' class='form-control' <?php if ($row['coropt'] === 'c') {echo "style='color: green'";} ?> value="<?php echo $fquest['option_c']; ?>" disabled=''></strong>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<div class='col-lg-12'>
						<div class='input-group'>
							<span class='input-group-addon'>
								<input type='radio' value='d' disabled='' <?php if ($row['usropt'] === 'd') {echo 'checked';} ?> >
							</span>
							<strong><input type='text' class='form-control' <?php if ($row['coropt'] === 'd') {echo "style='color: green'";} ?> value="<?php echo $fquest['option_d']; ?>" disabled=''></strong>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
				</div> 
				<?php $i++; 
			}
		}
	} ?>
</body>
</html>