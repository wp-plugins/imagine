<?php 
global $wpdb;

echo '<div class="imagine-album-overview-wrap">';

echo '<h2>Edit albums</h2>';
	echo '<div id="imagine-menu">';
	echo '<div class="button button-primary" id="add-album">Add album</div>';
	echo '<input type="text" class="regular-text" name="add-album" value="New album name...">';
	echo '</div>';

	$albums = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_albums');
	
	
	echo '<span style="float:right">Drag this or any table to the left to view more options!</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">Album</th>';
	echo '<th class="col-narrow">ID</th>';
	echo '<th class="col-wide">Name <span>Click to change</span></th>';
	echo '<th class="col-wide">Description <span>Click to change</span></th>';
	echo '<th class="col-wide"># of galleries</th>';
	echo '<th class="col-small">Uploaded by</th>';
	echo '<th class="col-medium">Created on</th>';
	echo '<th class="col-medium">Preview image</th>';
	echo '<th class="col-medium">Actions</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	

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
		if ($albcontent != 0) {
			$gals = count(explode(',',$albcontent));
		} else {
			$gals = 0;
		}
		
		echo '<tr class="alternate" row="album" aid="'.esc_attr($aid).'">';
		echo '<th scope="row"><a type="edit-album" aid="'.esc_attr($aid).'">EDIT</a> <a type="delete-album" aid="'.esc_attr($aid).'">DELETE</a></th>';
		echo '<td col="aid">'.esc_html($aid).'</td>';
		echo '<td col="aname">'.esc_html($albname).'</td>';
		echo '<td col="adesc">'.esc_html($albdesc).'</td>';
		echo '<td col="acontent">'.esc_html($gals).'</td>';
		echo '<td col="aauthor">'.esc_html($albauthor).'</th>';
		echo '<td col="adate">'.esc_html($albdate).' at '.esc_html($albtime).'</th>';	
		echo '<td col="apreview">'.esc_html($albpreviewimg).'</td>';
		echo '<td><a type="edit-album" aid="'.esc_attr($aid).'">EDIT</a> <a type="delete-album" aid="'.esc_attr($aid).'">DELETE</a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="Save" id="update-album"/>';
	echo '</div>';
?>