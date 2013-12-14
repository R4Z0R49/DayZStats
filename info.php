<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('queries.php');

session_start();
include_once('modules/FlashMessages.class.php');
$message = new FlashMessages();

$page = 'home';

	function slashes(&$el)
	{
		if (is_array($el))
			foreach($el as $k=>$v)
				slashes($el[$k]);
		else $el = stripslashes($el); 
	}
?>
<!DOCTYPE html>
<html lang="EN">
<?php include('modules/stats-header.php'); ?>
	<div class="container custom-container">
	<body>
		<div class="content">

			<?php
				if (isset($_REQUEST['search'])){
					$search = '%'.substr($_REQUEST['search'], 0, 64).'%';
					$row = $db->GetRow($search_query_player, $search);
					$CharacterID = $row['CharacterID'];

				    if(count($row) != 0) {
			    		header('location: info.php?view=info&show=1&CharacterID='.$CharacterID.'');
			   	    } elseif(count($row) == 0) {
			    		$message->add('danger', 'A player with the name, '. $_REQUEST['search'] . ' can\'t be found!');
			    	}
				} elseif(!$_REQUEST['search']){
					include ('modules/info/1.php');
				}
			$message->display();
			?>

		</div>
	</div>
        
	<?php
		include('modules/footer.php');
	?>
	</body>
</html>
