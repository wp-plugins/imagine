<?php


	global $wpdb;
	if ( isset($_GET['imagine'][0]['album']) && ctype_digit($_GET['imagine'][0]['album'])) {
		$aid = intval($_GET['imagine'][0]['album']);
	}
	$album = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$aid'");
	$content = $album->albumContent;
	$content = explode(',', $content);
	
	
	
	
	foreach ($content as $gallery) {
		$gal = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
		$galslug = $gal -> gallerySlug;
		$gname = $gal -> galleryName;
		$gdesc = $gal -> galleryDesc;
		$gid = $gal->galleryId;
		echo '<div class="imagine-gallery-wrap" gid="'.esc_attr($gid).'">';
		echo '<h3 class="gallery_title">'.esc_html($gname).'</h3>';
				
			echo '<div class="spacer" style="clear: both;"></div>';
			echo '</div>';
		
	echo '</div>';	
		}
?>