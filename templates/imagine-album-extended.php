<?php


	global $wpdb;
	if ( isset($_GET['imagine'][0]['album']) && ctype_digit($_GET['imagine'][0]['album'])) {
		$aid = intval($_GET['imagine'][0]['album']);
	}
	$album = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$aid'");
	$content = $album->albumContent;
	$content = explode(',', $content);
	
    $aname = $album->albumName;
    $adesc = $album->albumDesc;

    $plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];

	echo '<h2 class="album_title">'.esc_html($aname).'</h2>';
    echo '<p class="album_description">' .esc_html($adesc).'</p>';
	
	
	foreach ($content as $gallery) {
		$gal = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
		$galslug = $gal -> gallerySlug;
		$gname = $gal -> galleryName;
		$gdesc = $gal -> galleryDesc;
		$gid = $gal->galleryId;
        $gpreview = $gal->galleryPreviewImg;
        
		echo '<div class="imagine-gallery-wrap" gid="'.esc_attr($gid).'" template="'.esc_attr($tslug).'">';
        
        echo '<div class="imagine-gallery-preview-wrap"><img class="imagine-gallery-preview-img" src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/thumbs/thumb_' . esc_attr($gpreview) . '"></div>';
		
        echo '<div class="imagine-gallery-metadata">';
        echo '<h3 class="gallery_title">'.esc_html($gname).'</h3>';
        echo '<p class="gallery_desc">'.esc_html($gdesc).'</p>';
        echo '</div>';
        echo '<div class="spacer" style="clear: both;"></div>';
		echo '</div>';
			
		}
?>