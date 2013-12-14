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

	if(isset($_POST['reg_submit'])){
		if($_POST['regform_username'] == NULL){
			$message->add('danger', 'You need to enter a username!');
			$error = 1;
		}
		if($_POST['regform_pass'] == NULL){
			$message->add('danger', 'You need to enter a password!');
			$error = 1;
		} 
		if($_POST['regform_conf'] == NULL){
			$message->add('danger', 'You need to confirm your password!');
			$error = 1;
		} 
		if($_POST['regform_conf'] != NULL && $_POST['regform_pass'] != NULL && $_POST['regform_conf'] != $_POST['regform_pass']){
			$message->add('danger', 'Your passwords do not match!');
			$error = 1;
		}
		if($_POST['regform_pid'] == NULL){
			$message->add('danger', 'You need to enter your PlayerID!');
			$error = 1;
		}
		if($_POST['regform_pid'] != NULL){
			$pid_exists = $db->GetAll('SELECT * FROM dayzstats WHERE pid = ?', $_POST['regform_pid']);
			if(sizeof($pid_exists) > 0){
				$message->add('danger', 'A user with this PlayerID already exist!');
				$error = 1;
			} else {
				$error = 0;
			}
		}
		if($_POST['regform_username'] != NULL){
			$name_exists = $db->GetAll('SELECT * FROM dayzstats WHERE login = ?', $_POST['regform_username']);
			if(sizeof($name_exists) > 0){
				$message->add('danger', 'A user with this name already exist!');
				$error = 1;
			} else {
				$error = 0;
			}
		}
		if($error != 1){
			$message->add('success', 'Successfully registered!');
			$salt = GenerateSalt();
			$password = md5(md5($_POST['regform_pass']) . $salt);
			$db->execute($register, array($_POST['regform_pid'], $_POST['regform_username'], $password, $salt));
		}
	}
?>

<div class="stats-box">
	<div class="stats-box-inner">
		<form name="regform" method="POST">
			<h3 class="custom-h3">Register</h3>
			<div class="row">
				<div class="col-lg-12">
					<?php $message->display(); ?>
					<input class="form-control" placeholder="Username" type="text" name="regform_username">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					<input class="form-control" placeholder="Player ID" type="text" name="regform_pid">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					<input class="form-control" placeholder="Password" type="password" name="regform_pass">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					<input class="form-control" placeholder="Confirm Password" type="password" name="regform_conf">
				</div>
			</div>
			<div class="row" style="margin-top: 5px;">
				<div class="col-lg-12">
					<input class="btn btn-primary" type="submit" name="reg_submit" value="Register">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					To get your <b>PlayerID</b> simply search for your name on the main page and look for <b>PlayerID</b>
				</div>
			</div>
		</form>
	</div>
</div>
