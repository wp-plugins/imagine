<?php
	global $wpdb;
	$galleries = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_gallery');
	$albums = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_albums');

    $imgs = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_img');
	$galtemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="gallery"');
	$albtemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="album"');
    $imgtemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="image"');
	$overlaytemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="overlay"');
?>
    <div class="metaoptions">
        <p><?php echo __('Select a type to add', 'imagine-languages'); ?>:</p> 
        <h3 class="bt button" rel="gallery"><?php echo __('Gallery', 'imagine-languages'); ?></h3>
        <h3 class="bt button" rel="album"><?php echo __('Album', 'imagine-languages'); ?></h3>
        <h3 class="bt button" rel="image"><?php echo __('Image', 'imagine-languages'); ?></h3>
    </div>  

<?php    
    // Galleries
	echo '<div rel="gallery" class="form">';
    echo '<div class="row">' . __('Gallery', 'imagine-languages') . ':</div>';
	echo '<select name="metabox-option-gallery">';
    
	foreach ($galleries as $gallery) {
		$gname = $gallery -> galleryName;
		$gid = $gallery -> galleryId;
		
		echo esc_html($gname).'<option value="'.esc_attr($gid).'" galleryname="'.esc_attr($gname).'" gid="'.esc_attr($gid).'" >'.esc_html($gname).'</option>'; 
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">' . __('Template', 'imagine-languages') . ': </div>';
	echo '<select name="metabox-option-template">';
	foreach($galtemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">' . __('Layover template', 'imagine-languages') . ': </div>';
	echo '<select name="metabox-option-layovertemplate">';
	echo '<option value="imagine">Imagine</option>';
	
	foreach($overlaytemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	
	echo '</select>';
	
	echo '</div>';


    //albums
    echo '<div rel="album" class="form">';
    echo '<div class="row">' . __('Album', 'imagine-images') . ': </div>';
	echo '<select name="metabox-option-album">';
    
	foreach ($albums as $album) {
		$aname = $album -> albumName;
		$aid = $album -> albumId;
		
		echo esc_html($aname).'<option value="'.esc_attr($aid).'" albumname="'.esc_attr($aname).'" aid="'.esc_attr($aid).'" >'.esc_html($aname).'</option>'; 
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">' . __('Template', 'imagine-images') . ': </div>';
	echo '<select name="metabox-option-album-template">';
	foreach($albtemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	echo '</select>';
    
	
	echo '</div>';



// single image
    echo '<div rel="image" class="form">';
    echo '<div class="row">' . __('Image', 'imagine-images') . ': </div>';
	echo '<select name="metabox-option-image">';
    
	foreach ($imgs as $img) {
		$imgname = $img-> imgFilename;
		$iid = $img -> imgId;
		
		echo esc_html($aname).'<option value="'.esc_attr($iid).'" imgname="'.esc_attr($imgname).'" iid="'.esc_attr($iid).'" >'.esc_html($imgname).'</option>'; 
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">' . __('Template', 'imagine-images') . ': </div>';
	echo '<select name="metabox-option-image-template">';
	foreach($imgtemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	echo '</select>';
    
	
	echo '</div>';


	echo '<div id="#msg"></div>';
	
	echo '<div class="response"></div>'
?>
