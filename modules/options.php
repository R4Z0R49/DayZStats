<?php 
	function GenerateSalt($n=3)
	{
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
		$counter = strlen($pattern)-1;
		for($i=0; $i<$n; $i++)
		{
			$key .= $pattern{rand(0,$counter)};
		}
		return $key;
	}

	$userid = $_SESSION['user_id'];

	if($_POST['optform_submitpid']){
		if($_POST['optform_newpid'] != NULL){
			$newpid = $_POST['optform_newpid'];
			$db->execute('UPDATE dayzstats SET pid = ? WHERE id = ?', array($newpid, $userid));	
			$message->add('success', 'Successfully changed PlayerID');
		} elseif($_POST['optform_newpid'] == NULL){
			$message->add('danger', 'You did not specify a new PlayerID');
		}
	}
	if($_POST['optform_submitpass']){
		$rs = $db->GetAll('SELECT * FROM dayzstats WHERE id = ?', $userid);	
		foreach($rs as $dbrow){
			$db_pass = $dbrow['password'];
			$db_salt = $dbrow['salt'];
		}
		if(md5(md5($_POST['optform_oldpass']) . $db_salt) != $db_pass){
			$message->add('danger', 'Your old password is not correct!');
			$error = 1;
		}
		if($_POST['optform_newpass'] != $_POST['optform_confpass']){
			$message->add('danger', 'Your passwords do not match!');
			$error = 1;
		}

		if($error != 1){
			$message->add('success', 'You have successfully changed your password!');
			$salt = GenerateSalt();
			$newpass = md5(md5($_POST['optform_newpass']) . $salt);
			$db->execute('UPDATE dayzstats SET password = ?', $newpass);
			$db->execute('UPDATE dayzstats SET salt = ?', $salt);
		}
	}

$message->display();
?>
<div class="alert alert-info">
	If you need to alter any of your account settings, this is the place to do it.
</div>
<form method="POST">
	<div class="row">
		<div class="col-lg-3">
			<h3 class="custom-h3">Change PlayerID</h3>
			<div class="input-group" style="margin-top: 5px;">
				<input class="form-control" type="text" name="optform_newpid" placeholder="Change PlayerID">
				<input class="btn btn-primary" style="margin-top: 5px;" name="optform_submitpid" type="submit" value="Submit">
			</div>
		</div>
	</div>
</form>
<form method="POST">
	<div class="row">
		<div class="col-lg-3">
			<h3 class="custom-h3">Change Password</h3>
			<input class="form-control" type="password" name="optform_oldpass" placeholder="Old Password">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3">
			<input class="form-control" style="margin-top: 5px;" type="password" name="optform_newpass" placeholder="New Password">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3">
			<input class="form-control" style="margin-top: 5px;" type="password" name="optform_confpass" placeholder="Confirm Password">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-3">
			<input class="btn btn-primary" style="margin-top: 5px;" type="submit" name="optform_submitpass" value="Submit">
		</div>
	</div>
</form>