<?php


	global $wpdb;

    $plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
    // set the correct ID;
	if ( isset($_GET['imagine'][0]['image']) && ctype_digit($_GET['imagine'][0]['image'])) {
		$iid = intval($_GET['imagine'][0]['image']);
	}
    // load image info out of db;
	$image = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE imgId = '$iid'");
	// get corresponding gallery;
    $gid = $image->galleryId;
    // get image filename;
    $filename = $image->imgFilename;
    // load gallery details from db;
    $gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gid'");
    // get slug for filepath;
    $galslug = $gallery->gallerySlug;
	
	echo '<div class="thumbnail-wrap"><img src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/' . esc_attr($filename) . '"></div>';
			
?>