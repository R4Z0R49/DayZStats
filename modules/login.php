<?php
	if(isset($_POST['login_submit'])){
		$rs = $db->GetAll($login_query, array($_POST['login_username']));
		foreach($rs as $loginrow){
			$db_pass = $loginrow['password'];
			$userid = $loginrow['id'];
			$salt = $loginrow['salt'];
		}
		if(md5(md5($_POST['login_pass']) . $salt) == $db_pass){
			$_SESSION['user_id'] = $userid;
			header('Location: index.php');
		} else {
			$message->add('danger', 'Invalid username or password!');
		}
	}
?>

<div class="stats-box">
	<div class="stats-box-inner">
		<form name="loginform" method="POST">
			<h3 class="custom-h3">Sign in</h3>
			<div class="row">
				<div class="col-lg-12">
					<?php $message->display(); ?>
					<input class="form-control" placeholder="Username" type="text" name="login_username">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					<input class="form-control" placeholder="Password" type="password" name="login_pass">
				</div>
			</div>
			<div class="row" style="margin-top: 5px">
				<div class="col-lg-12">
					<input class="btn btn-primary" type="submit" name="login_submit" value="Sign in">
				</div>
			</div>
		</form>
	</div>
</div>
