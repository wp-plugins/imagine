<?php

global $wpdb;
if (isset($_GET['imagine']['template'])) {
	$template = $_GET['imagine']['template'];
}

$temp = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = 'gallery' AND tempName='$template'");
$tslug = $temp -> tempSlug;
if (isset($_GET['imagine']['gallery'])) {
	$gallery = intval($_GET['imagine']['gallery']);
}
$imgs = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gallery'");
$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
$galslug = $gallery -> gallerySlug;

foreach ($imgs as $img) {
	$imgid = $img -> imgId;
	$gid = $img -> galleryId;
	$filename = $img -> imgFilename;
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
	echo '<div class="imagine-thumbnail-wrap" gid="' . esc_attr($gid) . '" imgid="' . esc_attr($imgid) . '" layovertemp="' . esc_attr($layovertemplate) . '" template="' . esc_attr($tslug) . '">';
	echo '<img src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/thumbs/thumb_' . esc_attr($filename) . '">';

	echo '</div>';
}
echo '<div class="spacer" style="clear: both;"></div>';
?>