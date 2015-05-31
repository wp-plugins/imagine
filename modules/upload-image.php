<?php

if (isset($_POST['gedit']) && ctype_digit($_POST['gedit'])) {
	$gedit = intval($_POST['gedit']);
}

if ($gedit == null) {
	$gedit = intval($gid);
}
global $wpdb;

$plugindir = wp_upload_dir();
$pluginurl = $plugindir['baseurl'];
$plugindir = $plugindir['basedir'];

$galinfo = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gedit'");

$galslug = $galinfo -> gallerySlug;
$gid = $galinfo -> galleryId;

for ($i = 0; $i < count($_FILES['image-upload']['name']); $i++) {

	$file_name = sanitize_file_name($_FILES['image-upload']["name"][$i]);
	$file_tmp = $_FILES['image-upload']["tmp_name"][$i];
	$filesize = $_FILES['image-upload']["size"][$i];
	
	$extensions = array('gif', 'jpg', 'jpeg', 'png', 'JPG');
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	if ($_FILES['image-upload']["error"][$i] > 0) {
		echo "<p class='fail'>' . __('Error', 'imagine-images') . ': " . $_FILES['image-upload']["error"][$i] . "</p>";
	} else if ( !in_array($ext , $extensions) ) {
		echo "<p class='fail'>' . __('Error', 'imagine-images') . ': ' . __('filetype', 'imagine-images') . ' .".$ext." ' . __('not allowed.', 'imagine-images') . '</p>";	
	} else {
		if (!file_exists($plugindir . '/imagine/')) {
			mkdir($plugindir . '/imagine/', 0777, true);
		}
		if (!file_exists($plugindir . '/imagine/' . $galslug)) {
			mkdir($plugindir . '/imagine/' . $galslug, 0777, true);
		}
		if (!file_exists($plugindir . '/imagine/' . $galslug . '/thumbs')) {
			mkdir($plugindir . '/imagine/' . $galslug . '/thumbs', 0777, true);
		}

		// load image and get image size
		if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG') {
			$thumb = imagecreatefromjpeg($file_tmp);
		} else if ( $ext == 'png' ) {
			$thumb = imagecreatefrompng($file_tmp);
		} else if ( $ext == 'gif' ) {
			$thumb = imagecreatefromgif($file_tmp);
		}
			
		
		$orig_width = imagesx($thumb);
		$orig_height = imagesy($thumb);

		$width = $orig_width;
		$height = $orig_height;


		$tw = get_option('optionImagineThumbnailWidth');
		$thumbWidth = $tw;
		
		$new_width = $thumbWidth;
		$new_height = $height / ($width / $thumbWidth);
		
		
		// create a new temporary image
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		// copy and resize old image into new image
		imagecopyresized($tmp_img, $thumb, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		// save into file.
		imagejpeg($tmp_img, $plugindir . '/imagine/' . $galslug . '/thumbs/thumb_' . esc_attr($file_name));

		move_uploaded_file($file_tmp, $plugindir . '/imagine/' . $galslug . '/' . esc_attr($file_name));
		echo "<p class='succes'>' . __('Uploaded', 'imagine-images') . ': " . esc_html($file_name) . "</p>";

		$today = date("Y-m-d");
		$time = date('H:i:s');
		$author = wp_get_current_user();
		$author = $author -> display_name;

		$img = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gid' AND imgFilename='$file_name'");
		if ($img != NULL) {
			$wpdb -> update($wpdb->prefix.'imagine_img', array("imgSize" => $filesize, "imgSlug" => $file_name, "imgFilename" => $file_name, "galleryId" => $gid), array("galleryId" => $gid, "imgFilename" => $filename));
		} else {
			$wpdb -> insert($wpdb->prefix.'imagine_img', array("imgSize" => $filesize, "imgSlug" => $file_name, "imgFilename" => $file_name, "creationDate" => $today, "creationTime" => $time, "imgAuthor" => $author, "galleryId" => $gid));

		}

	}

}
?>