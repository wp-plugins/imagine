<?php
global $wpdb;

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir")
					rrmdir($dir . "/" . $object);
				else
					unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

$plugindir = wp_upload_dir();
$plugindir = $plugindir['basedir'];
if(isset($_POST['gdel']) && ctype_digit($_POST['gdel'])) {
$gid = intval($_POST['gdel']);
}

$galmeta = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gid'");
$galslug = $galmeta -> gallerySlug;
$gname = $galmeta -> galleryName;
$rmdir = $plugindir . '/imagine/' . $galslug . '/';
echo '<p class="succes">' . __('Gallery', 'imagine-images') . ' "'.esc_html($gname).'" ' . __('has been removes succesfully.', 'imagine-images') . '</p>';
rrmdir($rmdir);

$wpdb -> delete( $wpdb->prefix."imagine_gallery", array("galleryId" => $gid));

$wpdb -> delete($wpdb->prefix."imagine_img", array("galleryId" => $gid));
?>