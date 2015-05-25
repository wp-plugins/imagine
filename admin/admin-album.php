<?php 


if (isset($_POST['albumedit']) && ctype_digit($_POST['albumedt'])) {
	$aedit = intval($_POST['albumedit']);
}




// show gallery overview if gallery edit is unset.
if (!isset($aedit)) {
	
	// INCLUDE gallery-overview.php
	$dir = plugin_dir_path( __FILE__ );
	include $dir.'album-overview.php';
	
	
}
echo '<div class="imagine-formtable-wrap"></div>';
?>