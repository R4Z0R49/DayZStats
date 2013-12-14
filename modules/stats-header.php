<head>
	<title><?php echo $sitename ?></title>
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
	<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
		$(document).pngFix( );
		});
	</script>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<!-- New design (Bootstrap - font-awesome) -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link href="css/font-awesome.css" rel="stylesheet">
</head>
<body class="stats-bg"> 

<div id="logo-stats-bg">
	<div id="logo-stats-centerer">
		<div id="logo-stats-left">
			<a href="index.php">
				<img src="images/DayZStats.png" width="250px" height="80px" alt="">
			</a>
		</div>
		<div id="logo-stats-right">
			<a href="<?php echo($rightlogoLink); ?>"><img src="<?php echo($rightlogoImg); ?>" width="<?php echo($rightlogoWidth); ?>" height="<?php echo($rightlogoHeight); ?>" style="margin-top: <?php echo ($rightlogoMarginTop); ?>;" alt=""></img></a>
		</div>
	</div>
</div>

<div class="navbar navbar-inverse navbar-static-top navbar-custom">
	<div class="navbar-middle">
		<ul class="nav navbar-nav">
			<li <?php echo ($page == 'home' ? ' class="active" ' : ' '); ?>><a href="index.php"><i class="icon-home"></i> Stats</a></li>
			<li <?php echo ($page == 'leaderboard' ? ' class="active" ' : ' '); ?>><a href="index.php?leaderboard"><i class="icon-table"></i> Leaderboard</a></li> 
			<li <?php echo ($page == 'challenge' ? ' class="active" ' : ' '); ?>><a href="index.php?challenge&create"><i class="icon-tags"></i> Challenge Friends</a></li> 
		</ul>
		<ul class="nav navbar-nav pull-right">
			<?php if(!isset($_SESSION['user_id'])){ ?>
			<li <?php echo ($page == 'register' ? ' class="active" ' : ''); ?>><a href="index.php?register"><i class="icon-user"></i> Register</a></li> 
			<li <?php echo ($page == 'login' ? ' class="active" ' : ''); ?>><a href="index.php?login"><i class="icon-user"></i> Sign in</a></li> 
			<?php } elseif(isset($_SESSION['user_id'])){ ?>
			<li <?php echo ($page == 'options' ? ' class="active dropdown" ' : 'class="dropdown"'); ?>>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> User<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="index.php?options"><i class="icon-user"></i> Options</a></li> 
				<li class="divider"></li>
				<li><a href="modules/logout.php">Log out</a></li> 
			</ul>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
