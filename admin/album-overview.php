<?php 
global $wpdb;

echo '<div class="imagine-album-overview-wrap">';

echo '<h2>' . __('Albums', 'imagine-languages') . '</h2>';
	echo '<div id="imagine-menu">';
	echo '<div class="button button-primary" id="add-album">' . __('Add album', 'imagine-languages') . '</div>';
	echo '<input type="text" class="regular-text" name="add-album" value="' . __('New album name...', 'imagine-languages') . '">';
	echo '</div>';

	$albums = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_albums');
	
	
	echo '<span style="float:right">' . __('Drag this or any table to the left to view more options!', 'imagine-languages') . '</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">' . __('Album', 'imagine-languages') . '</th>';
	echo '<th class="col-narrow">' . __('ID', 'imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Name', 'imagine-languages') . ' <span>' . __('Click to change', 'imagine-languages') . '</span></th>';
	echo '<th class="col-wide">' . __('Description', 'imagine-languages') . ' <span>' . __('Click to change', 'imagine-languages') . '</span></th>';
	echo '<th class="col-wide">' . __('# of galleries', 'imagine-languages') . '</th>';
	echo '<th class="col-small">' . __('Uploaded by', 'imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Created on', 'imagine-languages') . '</th>';
echo '<th class="col-medium">' . __('Default template','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Preview image', 'imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Actions', 'imagine-languages') . '</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	$tmps = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = 'album'");

	foreach ($albums as $album) {
		$albname = $album -> albumName;
		$albslug = $album -> albumSlug;
		$albdesc = $album -> albumDesc;
		$albpreviewimg = $album -> albumPreviewImg;
		$aid = $album -> albumId;
		$albdate = $album->creationDate;
		$albtime = $album->creationTime;
		$albauthor = $album->albumAuthor;
		$albcontent = $album->albumContent;
        $atemp = $album->defaultTemplate;
        $aitem = explode( ',' , $albcontent );
		if ($albcontent != 0) {
			$gals = count(explode(',',$albcontent));
            
		} else {
			$gals = 0;
		}
        
		echo '<tr class="alternate" row="album" aid="'.esc_attr($aid).'">';
		echo '<th scope="row"><a type="edit-album" aid="'.esc_attr($aid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-album" aid="'.esc_attr($aid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></th>';
		echo '<td col="aid">'.esc_html($aid).'</td>';
		echo '<td col="aname">'.esc_html($albname).'</td>';
		echo '<td col="adesc">'.esc_html($albdesc).'</td>';
		echo '<td col="acontent">'.esc_html($gals).'</td>';
		echo '<td col="aauthor">'.esc_html($albauthor).'</th>';
		echo '<td col="adate">'.esc_html($albdate).' at '.esc_html($albtime).'</th>';	
        echo '<th><select name="albumTemplate">';
        echo '<option value="none">none</option>';
        foreach ($tmps as $tmp) {
            $tname = $tmp->tempName;
            if ($atemp == $tname) {
            echo '<option value="'.esc_attr($tname).'" selected="selected">'.esc_html($tname).'</option>'; 
            } else {
            echo '<option value="'.esc_attr($tname).'">'.esc_html($tname).'</option>';
            }
        }
        
        echo '</select></th>';
		echo '<td col="apreview">';
        echo '<select name="albumPreview">';
        foreach ( $aitem as $gal ) {
            $imgs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId= '$gal'");
                foreach($imgs as $img) {
                    $gid = $img->galleryId;
                    $filename = $img->imgFilename;
                    if ( !empty($album->albumPreviewImg) && $album->albumPreviewImg == $filename ) {
                        echo '<option value="'.esc_attr($filename).'" aid="'.esc_attr($aid).'" selected="selected">'.esc_html($filename).'</option>'; 
                    } else {
                        echo '<option value="'.esc_attr($filename).'" aid="'.esc_attr($aid).'">'.esc_html($filename).'</option>'; 
                }
            }
        }
        
        echo '</select>';
        echo '</td>';
		echo '<td><a type="edit-album" aid="'.esc_attr($aid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-album" aid="'.esc_attr($aid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="' . __('Save', 'imagine-languages') . '" id="update-album"/>';
	echo '</div>';
?>