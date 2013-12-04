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
	
	if (isset($_REQUEST['search'])){
		$search = '%'.substr($_REQUEST['search'], 0, 64).'%';
		$row = $db->GetRow($search_query_player, $search);
		$CharacterID = $row['CharacterID'];

	    if(count($row) != 0) {
    		header('location: info.php?view=info&show=1&CharacterID='.$CharacterID.'');
   	    } elseif(count($row) == 0) {
    		$message->add('danger', 'A player with the name, '. $_REQUEST['search'] . ' can\'t be found!');
    	}
	}
	// Start: page-header 
	include ('modules/stats-header.php');
	// End page-header

	if (isset($_GET["show"])) {
		$show = $_GET["show"];
	}

	if (isset($_GET['view'])){
		include ('modules/'.$_GET["view"].'.php');
	}

?>
<div class="container custom-container" style="padding: 10px">
<?php $message->display(); ?>
</div>
</div>
<!--  end content -->
</div>
<!--  end content-outer........................................................END -->

<?php
	// Start: page-footer 
	include('modules/footer.php');
	// End page-footer
?>
 
</body>
</html>
