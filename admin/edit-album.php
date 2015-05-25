<?php 
	if (isset($_POST['albumedit']) && ctype_digit($_POST['albumedit'])) {
		$aedit = intval($_POST['albumedit']);
    } else {
        $aedit = $aid;
    }


	$album = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$aedit'");
	
	$aname = $album -> albumName;
	$acontent = $album -> albumContent;
    
	
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
	

	
	echo '<h3 class="formhead" aid="' . esc_attr($aedit) . '">Editing "'.esc_html($aname).'"</h3>';
    echo '<p>Drag&drop a gallery into the album (on the right).</p>';
   echo '<div class="addGal">';
    // Adding galleries into the album
    $galleries = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'_imagine_gallery');
    foreach( $galleries as $gal ) {
        $gname = $gal -> galleryName;
        $gid = $gal -> galleryId;
        echo '<div class="gal" gid="' . esc_attr($gid) . '">' . esc_html($gname) . '</div>';
    }
    echo '</div>';

	// galleries already in the album
	echo '<div class="aContain">';
    
    if ( empty($acontent)) {
        echo 'No galleries included yet.';
        
    } else {
        $gallery = explode(',', $acontent);
        foreach( $gallery as $gal ) {
            $data = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gal'");
            $gname = $data -> galleryName;
            $gid = $data -> galleryId;
            echo '<div class="gal" gid="' . esc_attr($gal) . '">ID:' . esc_html($gal) . ' - Name: ' . esc_html($gname) . '<span style="float:right; margin-right: 12px" ref="del">X</span></div>';
        }
    }
    echo '</div>';

    echo '<div class="button button-primary" id="saveAlbum" style="float:left; clear:both">Save</div>';
 
?>