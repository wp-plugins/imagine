<?php 
	


	
	$tmpname = $tempinfo -> tempName;
	$tmpdesc = $tempinfo -> templateDesc;
	$tmpid = $tempinfo -> tempId;
	$tmpslug = $tempinfo -> tempSlug;
	$tmptype = $tempinfo -> tempType;
	
		
	echo '<table class="form-table">';
	echo '<thead><h2>' . __('Edit','imagine-languages') . ' ' . esc_html($tmpname) .'</h2></thead>';
	echo __('Add an element to your template: ', 'imagine-languages');
	echo '<div class="template-menu" tid="'.esc_attr($tmpid).'" tmpslug="'.esc_attr($tmpslug).'">';
	echo '<div class="button" content="title">' . __('Title','imagine-languages') . '</div>';
	echo '<div class="button" content="desc">' . __('Description','imagine-languages') . '</div>';
	echo '<div class="button" content="date">' . __('Date','imagine-languages') . '</div>';
	echo '<div class="button" content="time">' . __('Time','imagine-languages') . '</div>';
	echo '<div class="button" content="author">' . __('Author','imagine-languages') . '</div>';
	echo '<div class="button" content="count">' . __('Count','imagine-languages') . '</div>';
	echo '</div>';
	echo '</table>';
	
	
	
	
	
	echo '<div class="template-preview-wrap" tid="'.esc_attr($tid).'">';
	
	echo '<div class="imagine" gid="3" template="'.esc_attr($tmpname).'">';
	$css = $tempinfo->tempCss;
	$php = $tempinfo->tempPhp;
	$path = $tempinfo->tempPath;
	$filecss = $path . $css;
	$filephp = $path . $php;
	
	include $filephp;
				
				
	echo '<style>';
	include $filecss;
	echo '</style>';
	
	
	echo '</div>';
	
	echo '</div>';	
	
	echo '<div class="button button-primary" name="upload-template">' . __('Save','imagine-languages') . '</div>';

?>