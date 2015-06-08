<script src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery.collagePlus.js'; ?>"></script>
<?php

global $wpdb;

if (isset($_GET['imagine']['gallery'])) {
	$gallery = intval($_GET['imagine']['gallery']);
}
$imgs = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gallery'");
$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
$galslug = $gallery -> gallerySlug;
echo '<div class="imagine-wall-wrap">';

foreach ($imgs as $img) {
	$imgid = $img -> imgId;
	$gid = $img -> galleryId;
	$filename = $img -> imgFilename;
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
	echo '<img template="'.esc_attr($tslug).'" class="imagine-thumbnail-wrap" src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/thumbs/thumb_' . esc_attr($filename) . '" gid="' . esc_attr($gid) . '" imgid="' . esc_attr($imgid) . '" layovertemp="' . esc_attr($layovertemplate) . '">';

}
echo '</div>';
?>


<script>
    $(document).ready( function() {
        var w = $('.imagine-wall-wrap').parent('.imagine').width() - 12;
        
        $('.imagine-wall-wrap').css({width: w, padding: '10px'}).collagePlus({'targetHeight': 200, 'allowPartialLastRow' : true});
    });
    
    $(window).on('resize', function() {
        var w = $('.imagine-wall-wrap').parent('.imagine').width() - 12;
        
        $('.imagine-wall-wrap').css({width: w, padding: '10px'}).collagePlus({'targetHeight': 200, 'allowPartialLastRow' : true});
    });
</script>