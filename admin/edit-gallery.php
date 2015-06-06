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
	echo '<h3 class="formhead">' . __('Upload images into gallery','imagine-languages') . ' "'.esc_html($galname).'"</h3>';
	echo '<input type="file" name="image-upload[]" multiple="multiple"  size="25" /><input style="display:none;" name="gedit" value="'.esc_attr($gid).'">';
	echo '<input type="submit" class="button button-primary" name="submit" value="' . __('Upload','imagine-languages') . '" id="upload-image"/>';
	echo '</form>';
	
	
	
	
	echo '<table class="wp-list-table widefat fixed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th scope="row" class="col-thumb">' . __('Image','imagine-languages') . '</th>';
    echo '<th scope="row" class="col-medium">' . __('Actions', 'imagine-languages') . '</th>';
	echo '<th class="col-narrow">' . __('ID','imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Filename','imagine-languages') . '</th>';
	echo '<th class="col-wide">' . __('Description','imagine-languages') . ' <span>' . __('Click to change','imagine-languages') . '</span></th>';
	echo '<th class="col-wide">' . __('Alt title','imagine-languages') . ' <span>' . __('Click to change','imagine-languages') . '</span></th>';
	echo '<th class="col-small">' . __('Uploaded by','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Created on','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Image tags','imagine-languages') . '</th>';
	echo '<th class="col-medium">' . __('Actions','imagine-languages') . '</th>';
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
		echo '<th scope="row" class="col-thumb"><div class="table_thumbwrap"><img src="'.esc_attr($pluginurl).'/imagine/'.esc_attr($galslug).'/thumbs/thumb_'.esc_attr($imgname).'"></div></th>';
        echo '<th scope="row"><a type="delete-image" iid="'.esc_attr($imgid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></th>';
		
		echo '<td class="col-narrow">'.esc_html($imgid).'</td>';
		echo '<td class="col-wide" col="imgname">'.esc_html($imgname).'</td>';
		echo '<td class="col-wide" col="imgdesc">'.esc_html($imgdesc).'</td>';
		echo '<td class="col-wide" col="imgtitle">'.esc_html($imgtitle).'</td>';
		echo '<td class="col-medium" col="imgauthor">'.esc_html($author).'</th>';
		echo '<td class="col-small" col="imgdate">'.esc_html($imgdate).' at '.esc_html($imgtime).'</th>';	
       
		echo '<td class="col-medium" col="imgtags">'.esc_html($imgtags).'</th>';	
		echo '<td class="col-medium"><a href="admin.php?page=edit-gallery&imgrem='.esc_attr($imgid).'"><img src="' . plugin_dir_url(__DIR__) . 'img/32x32/block.png"></a></td>';
		

	}
	
	echo '</tbody>';
	echo '</table>';
	echo '<input type="submit" class="button button-primary" name="submit" value="' . __('Save','imagine-languages') . '" id="edit-images"/>';
	echo '<span id="msg"></span>';
	
	

?>