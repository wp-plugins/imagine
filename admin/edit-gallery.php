<?php 
	if (isset($_POST['gedit']) && ctype_digit($_POST['gedit'])) {
		$gedit = intval($_POST['gedit']);
	}


	$gallery = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gedit'");
	
	$galname = $gallery -> galleryName;
	$galslug = $gallery -> gallerySlug;
	$galpath = $gallery -> galleryPath;
	$galdesc = $gallery -> galleryDesc;
	$galpreviewimg = $gallery -> galleryPreviewImg;
	$gid = $gallery -> galleryId;
	
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
	
	$imagewidth = get_option('imagineDefaultWidth');
	
		

	
	
	
	$imgs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gedit'");
	
	
	echo '<form method="post" enctype="multipart/form-data" galleryId="'.esc_attr($gid).'" galleryname="'.esc_attr($galname).'" class="uploadform">';
	echo '<h3 class="formhead">Upload images into gallery "'.esc_html($galname).'"</h3>';
	echo '<input type="file" name="image-upload[]" multiple="multiple"  size="25" /><input style="display:none;" name="gedit" value="'.esc_attr($gid).'">';
	echo '<input type="submit" class="button button-primary" name="submit" value="Upload" id="upload-image"/>';
	echo '</form>';
	
	
	
	
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th scope="row" class="col-thumb">Image</th>';
	echo '<th class="col-narrow">ID</th>';
	echo '<th class="col-wide">Filename</th>';
	echo '<th class="col-wide">Description <span>Click to change</span></th>';
	echo '<th class="col-wide">Alt title <span>Click to change</span></th>';
	echo '<th class="col-small">Uploaded by</th>';
	echo '<th class="col-medium">Created on</th>';
	echo '<th class="col-medium">Image tags</th>';
	echo '<th class="col-medium">Actions</th>';
	echo '</tr>';
	echo '</thead>';
	
	echo '<tbody>';
	

	foreach ($imgs as $img) {
		$imgname = $img->imgFilename;
		$imgtitle = $img->imgAltTitle;
		$imgdesc = $img->imgDesc;
		$imgid = $img->imgId;
		$imgdate = $img->creationDate;
		$imgtime = $img->creationTime;
		$author = $img->imgAuthor;
		$imgtags = $img->imageTags;
		
		echo '<tr class="alternate" gid="'.esc_attr($gid).'" imgid="'.esc_attr($imgid).'" row="image">';
		echo '<th scope="row" class="col-thumb"><img src="'.esc_attr($pluginurl).'/imagine/'.esc_attr($galslug).'/thumbs/thumb_'.esc_attr($imgname).'"></th>';
		echo '<td class="col-narrow">'.esc_html($imgid).'</td>';
		echo '<td class="col-wide" col="imgname">'.esc_html($imgname).'</td>';
		echo '<td class="col-wide" col="imgdesc">'.esc_html($imgdesc).'</td>';
		echo '<td class="col-wide" col="imgtitle">'.esc_html($imgtitle).'</td>';
		echo '<td class="col-medium" col="imgauthor">'.esc_html($author).'</th>';
		echo '<td class="col-small" col="imgdate">'.esc_html($imgdate).' at '.esc_html($imgtime).'</th>';	
		echo '<td class="col-medium" col="imgtags">'.esc_html($imgtags).'</th>';	
		echo '<td class="col-medium"><a href="admin.php?page=edit-gallery&grem='.esc_attr($gid).'">Delete</a></td>';
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="Save" id="edit-images"/>';
	echo '<span id="msg"></span>';
	
	

?>