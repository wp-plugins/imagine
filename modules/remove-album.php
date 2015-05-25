<?php
global $wpdb;

if(isset($_POST['adel']) && ctype_digit($_POST['adel'])) {
$aid = intval($_POST['adel']);
}
$data = $wpdb->get_row("SELECT * FROM wp_imagine_albums WHERE albumId = '$aid'");
$aname = $data -> albumName;
echo '<p class="succes">Album "'.esc_html($aname).'" has been removed succesfully.</p>';

$wpdb -> delete("wp_imagine_albums", array("albumId" => $aid));
?>