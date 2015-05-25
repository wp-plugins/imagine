<?php

if (isset($_POST['gedit']) && ctype_digit($_POST['gedit'])) {
	$gedit = intval($_POST['gedit']);
}




// show gallery overview if gallery edit is unset.
if (!isset($gedit)) {
	// INCLUDE gallery-overview.php
	$dir = plugin_dir_path( __FILE__ );
	include $dir.'gallery-overview.php';
	
	
}

echo '<div class="imagine-formtable-wrap"></div>';

// HANDLE file upload
		if(isset($_FILES['image-upload'])) {
			// INCLUDE MODULE upload-image.php
			$dir = plugin_dir_path( __FILE__ ) . "../modules/upload-image.php";
			include $dir;
			$galleryoverview = plugin_dir_path( __FILE__ ) . "../admin/gallery-overview.php";
			$galleryedit = plugin_dir_path( __FILE__ ) . "../admin/edit-gallery.php";
			include $galleryoverview;
			echo '<div class="imagine-formtable-wrap">';
			include $galleryedit;
			echo '</div>';
			
		}




?>