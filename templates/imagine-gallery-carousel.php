<script src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery.film_roll.js'; ?>"></script>
<?php

global $wpdb;

if (isset($_GET['imagine']['gallery'])) {
	$gallery = intval($_GET['imagine']['gallery']);
}
$imgs = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gallery'");
$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
$galslug = $gallery -> gallerySlug;
echo '<div class="imagine-carousel-wrap" template="'.esc_attr($tslug).'">';

foreach ($imgs as $img) {
	$imgid = $img -> imgId;
	$gid = $img -> galleryId;
	$filename = $img -> imgFilename;
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
    echo '<div class="imagine-carousel-thumbnail-wrap">';
	echo '<img src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/thumbs/thumb_' . esc_attr($filename) . '" gid="' . esc_attr($gid) . '" imgid="' . esc_attr($imgid) . '" layovertemp="' . esc_attr($layovertemplate) . '">';
    echo '</div>';
}
echo '<div class="spacer" style="clear: both;"></div>';
echo '</div>';
?>


<script>
    $(document).ready( function() {
        
        
        fr = new FilmRoll({
            container: '.imagine-carousel-wrap',
            height: 200,
            pager: false,
          });
        fr.resize();
    });
    
</script>