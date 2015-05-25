<?php 
	


	
	$tmpname = $tempinfo -> tempName;
	$tmpdesc = $tempinfo -> templateDesc;
	$tmpid = $tempinfo -> tempId;
	$tmpslug = $tempinfo -> tempSlug;
	$tmptype = $tempinfo -> tempType;
	
		
	echo '<table class="form-table">';
	echo '<thead><h2>Edit '. esc_html($tmpname) .'</h2></thead>';
	echo 'Add an element to your template: ';
	echo '<div class="template-menu" tid="'.esc_attr($tmpid).'" tmpslug="'.esc_attr($tmpslug).'">';
	echo '<div class="button" content="title">Title</div>';
	echo '<div class="button" content="desc">Description</div>';
	echo '<div class="button" content="date">Date</div>';
	echo '<div class="button" content="time">Time</div>';
	echo '<div class="button" content="author">Author</div>';
	echo '<div class="button" content="count">Count</div>';
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
	
	echo '<div class="button button-primary" name="upload-template">Save</div>';

?>