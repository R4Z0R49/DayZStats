<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
require_once('queries.php');

	function slashes(&$el)
	{
		if (is_array($el))
			foreach($el as $k=>$v)
				slashes($el[$k]);
		else $el = stripslashes($el); 
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
