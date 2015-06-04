<?php


	global $wpdb;

	$imgs = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gallery'");
	$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
	$galslug = $gallery -> gallerySlug;
	$gname = $gallery -> galleryName;
	$gdesc = $gallery -> galleryDesc;

    // add checkup to see if this gallery is currently being viewed inside an album container. If so, dont show the title (and / or the description) //
    if ( isset( $_GET['imagine'][0]['inside'] )) {
        $inside = sanitize_text_field($_GET['imagine'][0]['inside']);
        if ( $inside !== 'true' ) {
           echo '<h2>'.esc_html($gname).'</h2>';

        }
    } else if ( !isset( $_GET['imagine'][0]['inside'] ) || $_GET['imagine'][0]['inside'] == NULL) {
        echo '<h2>'.esc_html($gname).'</h2>';
        echo '<p>'.esc_html($gdesc).'</p>';
    }
    
    
	foreach ($imgs as $img) {
		$filename = $img -> imgFilename;
		$title = $filename;
		$alttitle = $img -> imgAltTitle;
		$imgauthor = $img -> imgAuthor;
		if(!empty($alttitle)) {
			$title = $alttitle;
		} 
		
		
		
		$imgid = $img->imgId;
		$gid = $img->galleryId;
		$date = $img -> creationDate;
		$time = $img -> creationTime;
		$imgdesc = $img->imgDesc;
		$plugindir = wp_upload_dir();
		$pluginurl = $plugindir['baseurl'];
		$plugindir = $plugindir['basedir'];
		echo '<div class="imagine-thumbnail-wrap" gid="'.esc_attr($gid).'" imgid="'.esc_attr($imgid).'" layovertemp="'.esc_attr($layovertemplate).'" template="'.esc_attr($tslug).'">';
			echo '<div class="thumbnail-wrap"><img src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/thumbs/thumb_' . esc_attr($filename) . '"></div>';
			echo '<div class="imagine-thumbnail-metadata">';
				echo '<h4>'.esc_html($title).'</h4>';
				echo '<div class="image-description">'.esc_html($imgdesc).'</div>';
				echo '<div class="image-info">Uploaded by: '.esc_html($imgauthor).' on '.esc_html($date).' at '.esc_html($time).'</div>';
				echo '<div class="spacer" style="clear: both;"></div>';
			echo '</div>';
			
			
		echo '<div class="spacer" style="clear: both;"></div>';
		echo '</div>';
		
	}
?>