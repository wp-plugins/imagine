<?php
	global $wpdb;
	$galleries = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_gallery');
	$albums = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_albums');
	$galtemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="gallery"');
	$albtemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="album"');
	$overlaytemp = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates WHERE tempType="overlay"');
?>

    <div class="metaoptions">
        <p>Select a type to add:</p> 
        <h3 class="bt button" rel="gallery">Gallery</h3>
        <h3 class="bt button" rel="album">Album</h3>
    </div>  

<?php    
    // Galleries
	echo '<div rel="gallery" class="form">';
    echo '<div class="row">Gallery: </div>';
	echo '<select name="metabox-option-gallery">';
    
	foreach ($galleries as $gallery) {
		$gname = $gallery -> galleryName;
		$gid = $gallery -> galleryId;
		
		echo esc_html($gname).'<option value="'.esc_attr($gid).'" galleryname="'.esc_attr($gname).'" gid="'.esc_attr($gid).'" >'.esc_html($gname).'</option>'; 
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">Template: </div>';
	echo '<select name="metabox-option-template">';
	foreach($galtemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">Image template: </div>';
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
    echo '<div class="row">Album: </div>';
	echo '<select name="metabox-option-album">';
    
	foreach ($albums as $album) {
		$aname = $album -> albumName;
		$aid = $album -> albumId;
		
		echo esc_html($aname).'<option value="'.esc_attr($aid).'" albumname="'.esc_attr($aname).'" aid="'.esc_attr($aid).'" >'.esc_html($aname).'</option>'; 
	}
	echo '</select>';
    
    echo '</br>';
    echo '<div class="row">Template: </div>';
	echo '<select name="metabox-option-album-template">';
	foreach($albtemp as $template) {
		$tname = $template -> tempName;
		echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
	}
	echo '</select>';
    
	
	echo '</div>';
	echo '<div id="#msg"></div>';
	
	echo '<div class="response"></div>'
?>
