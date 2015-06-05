<?php
$plugindir = wp_upload_dir();
$plugindir = $plugindir['basedir'];
if(isset($_POST['imgdel']) && ctype_digit($_POST['imgdel'])) {
$iid = intval($_POST['imgdel']);
}
$filemeta = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE imgId = '$iid'");
$gid = $filemeta->galleryId;
$galmeta = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gid'");
$galslug = $galmeta -> gallerySlug;
$gname = $galmeta -> galleryName;
$filename = $filemeta->imgFilename;
$rmfile = $plugindir . '/imagine/' . $galslug . '/'.$filename;
$rmthumb = $plugindir . '/imagine/' . $galslug . '/thumbs/thumb_'.$filename;


unlink($rmthumb);
unlink($rmfile);


$wpdb -> delete($wpdb->prefix."imagine_img", array("imgId" => $iid));

echo '<p class="succes">' . __('Image', 'imagine-images') . ' "'.esc_html($filename).'" ' . __('has been removed succesfully.', 'imagine-images') . '</p>';
?>