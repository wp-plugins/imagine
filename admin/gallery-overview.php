<?php 
global $wpdb;

echo '<div class="imagine-gallery-overview-wrap">';

echo '<h2>' . __('Gallery','imagine-languages') . '</h2>';
	echo '<div id="imagine-menu">';
	echo '<div class="button button-primary" id="add-gallery">' . __('Add gallery','imagine-languages') . '</div>';
	echo '<input type="text" class="regular-text" name="add-gallery" value="' . __('New gallery name...','imagine-languages') . '">';
	echo '</div>';

	$galleries = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_gallery');
	
	
	echo '<span style="float:right">' . __('Drag this or any table to the left to view more options!', 'imagine-languages') . '</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">' . __('Gallery','imagine-languages') . '</th>';
	echo '<th class="col-narrow">' . __('ID','imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Name','imagine-languages') . ' <span>' . __('Click to change','imagine-languages') . '</span></th>';
	echo '<th class="col-wide">' . __('Description','imagine-languages') . ' <span>' . __('Click to change','imagine-languages') . '</span></th>';
	echo '<th class="col-wide">' . __('Path','imagine-languages') . '</th>';
	echo '<th class="col-small">' . __('Uploaded by','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Created on','imagine-languages') . '</th>';
	echo '<th class="col-small">' . __('# of images','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Preview image','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Actions','imagine-languages') . '</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	

	foreach ($galleries as $gallery) {
		$galname = $gallery -> galleryName;
		$galslug = $gallery -> gallerySlug;
		$galpath = $gallery -> galleryPath;
		$galdesc = $gallery -> galleryDesc;
		$galpreviewimg = $gallery -> galleryPreviewImg;
		$gid = $gallery -> galleryId;
		$gdate = $gallery->creationDate;
		$gtime = $gallery->creationTime;
		$gauthor = $gallery->galleryAuthor;
		
		$contains = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."imagine_img WHERE galleryId = '$gid'");
		
		$imgs = count($contains);
		
		echo '<tr class="alternate" row="gallery" gid="'.esc_attr($gid).'">';
		echo '<th scope="row"><a type="edit-gallery" gid="'.$gid.'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-gallery" gid="'.esc_attr($gid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></th>';
		echo '<td col="gid">'.esc_html($gid).'</td>';
		echo '<td col="gname">'.esc_html($galname).'</td>';
		echo '<td col="gdesc">'.esc_html($galdesc).'</td>';
		echo '<td col="gpath">'.esc_html($galpath).'</td>';
		echo '<td col="gauthor">'.esc_html($gauthor).'</th>';
		echo '<td col="gdate">'.esc_html($gdate).' at '.esc_html($gtime).'</th>';	
		echo '<th>'.esc_html($imgs).'</th>';
		echo '<td col="gpreview"></td>';
		echo '<td><a type="edit-gallery" gid="'.esc_attr($gid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-gallery" gid="'.esc_attr($gid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="' . __('Save','imagine-languages') . '" id="update-gallery"/>';
	echo '</div>';
?>