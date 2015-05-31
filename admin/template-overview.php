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

	$templates = $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'imagine_templates');
	echo '<p class="imagine-notice">' . __('Future versions will contain methods to create your own template. For now you can write your own template file and upload it into wp-content/plugins/imagine/templates.', 'imagine-languages') . '</p>';
	
	echo '<span style="float:right">' . __('Drag this or any table to the left to view more options!', 'imagine-languages') . '</span>';
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th class="col-small" scope="row">' . __('Template','imagine-languages') . '</th>';
	echo '<th class="col-narrow">' . __('ID','imagine-languages') . '</th>';
	
	echo '<th class="col-small">' . __('Type','imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Name','imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Description','imagine-languages') . '</th>';
	echo '<th class="col-small">' . __('Created by','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Created on','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Actions','imagine-languages') . '</th>';
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
		echo '<th scope="row"><a type="edit-template" tid="'.$tid.'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-template" tid="'.esc_attr($tid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></th>';
		echo '<td col="tid">'.esc_html($tid).'</td>';
		echo '<td col="ttype">'.esc_html($temptype).'</td>';
		echo '<td col="tname">'.esc_html($tempname).'</td>';
		echo '<td col="tdesc">'.esc_html($tempdesc).'</td>';
		echo '<td col="tauthor">'.esc_html($tauthor).'</th>';
		echo '<td col="tdate">'.esc_attr($tdate).' at '.esc_attr($ttime).'</th>';	
		echo '<td><a type="edit-template" tid="'.esc_attr($tid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/edit.png"></a> <a type="delete-template" tid="'.esc_attr($tid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></td>';
		
		

	}
	
	echo '</tbody>';
	echo '</table>';
//	echo '<input type="submit" class="button button-primary" name="submit" value="Save" id="update-template"/>';
	echo '</div>';
	
?>