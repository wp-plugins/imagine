<?php 


global $wpdb;
if (isset($_POST['tmpedit']) && ctype_digit($_POST['tmpedit'])) {
$tmpedit = intval($_POST['tmpedit']);
}




// show gallery overview if gallery edit is unset.
if (!isset($tmpedit)) {
	
	// INCLUDE gallery-overview.php
	$dir = plugin_dir_path( __FILE__ );
	include $dir.'template-overview.php';
	
	
}

?>