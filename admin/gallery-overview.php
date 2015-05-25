<?php 
global $wpdb;

echo '<div class="imagine-gallery-overview-wrap">';

echo '<h2>Edit galleries</h2>';
	echo '<div id="imagine-menu">';
	echo '<div class="button button-primary" id="add-gallery">Add gallery</div>';
	echo '<input type="text" class="regular-text" name="add-gallery" value="New gallery name...">';
	echo '</div>';

	$galleries = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_gallery');
	
	
	echo '<span style="float:right">Drag this or any table to the left to view more options!</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">Gallery</th>';
	echo '<th class="col-narrow">ID</th>';
	echo '<th class="col-wide">Name <span>Click to change</span></th>';
	echo '<th class="col-wide">Description <span>Click to change</span></th>';
	echo '<th class="col-wide">Path</th>';
	echo '<th class="col-small">Uploaded by</th>';
	echo '<th class="col-medium">Created on</th>';
	echo '<th class="col-small"># of imgs</th>';
	echo '<th class="col-medium">Preview image</th>';
	echo '<th class="col-medium">Actions</th>';
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
		echo '<th scope="row"><a type="edit-gallery" gid="'.$gid.'">EDIT</a> <a type="delete-gallery" gid="'.esc_attr($gid).'">DELETE</a></th>';
		echo '<td col="gid">'.esc_html($gid).'</td>';
		echo '<td col="gname">'.esc_html($galname).'</td>';
		echo '<td col="gdesc">'.esc_html($galdesc).'</td>';
		echo '<td col="gpath">'.esc_html($galpath).'</td>';
		echo '<td col="gauthor">'.esc_html($gauthor).'</th>';
		echo '<td col="gdate">'.esc_html($gdate).' at '.esc_html($gtime).'</th>';	
		echo '<th>'.esc_html($imgs).'</th>';
		echo '<td col="gpreview"></td>';
		echo '<td><a type="edit-gallery" gid="'.esc_attr($gid).'">EDIT</a> <a type="delete-gallery" gid="'.esc_attr($gid).'">DELETE</a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="Save" id="update-gallery"/>';
	echo '</div>';
?>