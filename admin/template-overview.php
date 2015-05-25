<?php
global $wpdb;

echo '<div class="imagine-template-overview-wrap">';

//	echo '<h2>Edit templates</h2>';
//	echo '<div id="imagine-menu">';
//	echo '<div class="button button-primary" id="add-template">Add template</div>';
//	echo '<input type="text" class="regular-text" name="add-template" value="New template name...">';
//	echo '<select name="tempType">';
//	echo '<option value="gallery">Gallery</option>';
//	echo '<option value="album">Album</option>';
//	echo '<option value="overlay">Overlay</option>';
//	echo '</select>';
//	echo '</div>';

	$templates = $wpdb -> get_results('SELECT * FROM wp_imagine_templates');
	echo '<p class="imagine-notice">Future versions will contain methods to create your own template. For now you can write your own template file and upload it into wp-content/plugins/imagine/templates.</p>';
	
	echo '<span style="float:right">Drag this or any table to the left to view more options!</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">Template</th>';
	echo '<th class="col-narrow">ID</th>';
	
	echo '<th class="col-small">Type</th>';
	echo '<th class="col-wide">Name</th>';
	echo '<th class="col-wide">Description</th>';
	echo '<th class="col-small">Created by</th>';
	echo '<th class="col-medium">Created on</th>';
	echo '<th class="col-medium">Actions</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	

	foreach ($templates as $template) {
		$tempname = $template -> tempName;
		$tempdesc = $template -> tempDesc;
		$tid = $template -> tempId;
		$tdate = $template->tempDate;
		$ttime = $template->tempTime;
		$tauthor = $template->tempAuthor;
		$temptype = $template->tempType;
		
		echo '<tr class="alternate" row="template" tid="'.esc_attr($tid).'">';
		echo '<th scope="row"><a type="edit-template" tid="'.$tid.'">EDIT</a> <a type="delete-template" tid="'.esc_attr($tid).'">DELETE</a></th>';
		echo '<td col="tid">'.esc_html($tid).'</td>';
		echo '<td col="ttype">'.esc_html($temptype).'</td>';
		echo '<td col="tname">'.esc_html($tempname).'</td>';
		echo '<td col="tdesc">'.esc_html($tempdesc).'</td>';
		echo '<td col="tauthor">'.esc_html($tauthor).'</th>';
		echo '<td col="tdate">'.esc_attr($tdate).' at '.esc_attr($ttime).'</th>';	
		echo '<td><a type="edit-template" tid="'.esc_attr($tid).'">EDIT</a> <a type="delete-template" tid="'.esc_attr($tid).'">DELETE</a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
//	echo '<input type="submit" class="button button-primary" name="submit" value="Save" id="update-template"/>';
	echo '</div>';
	
?>