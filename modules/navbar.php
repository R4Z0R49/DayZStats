<?php
include ('config.php');
if (isset($_SESSION['user_id']))
{

$user_id = $_SESSION['user_id'];
$accesslvl = $db->GetOne("SELECT accesslvl FROM users WHERE id = '$user_id'");

	switch($map)
	{
   		case 'chernarus':
			$mapName = "Chernarus";
			break;
    	case 'lingor':
			$mapName = "Lingor";
			break;
    	case 'tavi':
			$mapName = "Taviana";
			break;
	    case 'namalsk':
			$mapName = "Namalsk";
			break;
	    case 'takistan':
			$mapName = "Takistan";
			break;
	    case 'panthera2':
			$mapName = "Panthera";
			break;
	    case 'fallujah':
			$mapName = "Fallujah";
			break;
	}
?>

<div class="navbar navbar-inverse navbar-static-top navbar-custom">
	<div class="navbar-middle">
		<ul class="nav navbar-nav">
			<li <?php echo ($page == 'dashboard' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../admin.php ' : ' admin.php '); ?>"><i class="icon-cog"></i> Dashboard</a></li> 
			<li <?php echo ($page == 'home' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php ' : ' index.php '); ?>"><i class="icon-home"></i> Stats</a></li>
			<li <?php echo ($page == 'leaderboard' ? ' class="active" ' : ' '); ?>><a href="<?php echo ($page == 'cpanel' ? ' ../index.php?leaderboard ' : ' index.php?leaderboard '); ?>"><i class="icon-home"></i> Leaderboard</a></li>
	  </ul>
</div>
</div>

<?php
}
else
{
	header('Location: index.php');
}
?>
