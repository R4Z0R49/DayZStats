<?php
session_start();
require_once('config.php');
require_once('db.php');
require_once('functions.php');



	// Start: page-header 
	include ('modules/header.php');
	// End page-header

	if (isset($_GET['info'])){
		include ('modules/'.$_GET["info"].'.php');
	}
?>
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

