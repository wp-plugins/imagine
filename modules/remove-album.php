<?php
global $wpdb;

if(isset($_POST['adel']) && ctype_digit($_POST['adel'])) {
$aid = intval($_POST['adel']);
}
$data = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$aid'");
$aname = $data -> albumName;
echo '<p class="succes">' . __('Album', 'imagine-images') . ' "'.esc_html($aname).'" ' . __('has been removes succesfully.', 'imagine-images') . '</p>';

$wpdb -> delete($wpdb->prefix."imagine_albums", array("albumId" => $aid));
?>