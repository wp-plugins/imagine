<?php

function imagine_ajaxsubmit() {
	global $wpdb;
	
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
	// ------------------------------------------------------------------------------------- BACK END REQUESTS --------------------------------------------------------  //
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
	
	
	
	
	// ------------------------------------------------------------------------------------------------------------------------------------Submit settings-------------  //
	
	
	if (isset($_POST['optionsubmit'][0]['value'])) {
		for($i = 0; $i < count($_POST['optionsubmit']); $i++) {
			$input = sanitize_text_field($_POST['optionsubmit'][$i]['input']);
			$value = sanitize_text_field($_POST['optionsubmit'][$i]['value']);
			
			if ( $input == 'optionImagineThumbnailWidth' ) {
				if (!ctype_digit($value)) {
	  				echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else { 
					update_option($input, $value);
					
				}
                
            } else if ( $input == 'optionImagineThumbnailRatio' ) {
				if (!ctype_digit( str_replace(':', '', $value ))) {
	  				echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else { 
					update_option($input, $value);
					
				}
			} else {
				if (!ctype_alnum( str_replace(' ', '', $value ))) {
	  				echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else { 
					update_option($input, $value);
					
				}
			}
		}
		echo '<p class="succes">' . __('Saved.', 'imagine-images') . '</p>';
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/settings.php";
		include_once $tempfile;
	}
	
	
	
	
	// ----------------------------------------------------------------------------------------------------------------------------------Add/Edit/Update Gallery--------  //
	if (isset($_POST['addgallery'])){
		$datas = $_POST['addgallery'];
        
        $plugindir = wp_upload_dir();
        $pluginurl = $plugindir['baseurl'];
        $plugindir = $plugindir['basedir'];
		foreach ($datas as $data) {
			
			if(isset($_POST['addgallery']['galId'])) {	
				$galid = intval($data['galId']);
				$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$galid'");
			} else {
				$exist = null;
			}
			
			// get user input - galname
			if ( isset ( $data['galName'] ) ) {
				// stop if contains invalid chars
				if ( !ctype_alpha( str_replace(' ', '', $data['galName'] ))) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$galname = sanitize_text_field($data['galName']);
				}	
			}
			
			
			// get user input - galslug
			if ( isset ( $data['galSlug'] ) ) {
				// stop if contains invalid chars
				if ( !ctype_alnum( str_replace(' ', '', $data['galSlug']) ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$galslug = sanitize_text_field($data['galSlug']);
					$galslug = explode(" ", $galslug);
					$galslug = implode('-', $galslug);
					$bid = get_current_blog_id();
					$galpath = $plugindir.'/imagine/'.$galslug;
				}	
			}
			
			
			
			$today = date("Y-m-d"); 
			$time = date('H:i:s');
			$author = wp_get_current_user();
			$author = $author->display_name;
			
			if(isset($data['galDesc'])) {	
				if ( !ctype_alnum( str_replace(' ', '', $data['galDesc']) ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$galdesc = sanitize_text_field($data['galDesc']);
				}
			} else {
				$galdesc = null;
			}
			
			$existname = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryName = '$galname'");
			if ($existname == NULL) {
				if ($exist != NULL && $existname != NULL) {
					$wpdb -> update($wpdb->prefix.'imagine_gallery', array(
						"galleryName" => $galname, 
						"galleryDesc"=>$galdesc, 
						"galleryPreviewImg"=>"unset"), 
						array("galleryId"=>$galid, "galleryName"=>$galname));
					} else {
						$wpdb -> insert($wpdb->prefix.'imagine_gallery', array(
							"galleryName" => $galname, 
							"gallerySlug" => $galslug, 
							"galleryPath" => $galpath, 
							"creationDate" => $today,
							"creationTime" => $time,
							"galleryAuthor" => $author,
							"galleryDesc"=>$galdesc, 
							"galleryPreviewImg"=>"unset",
                            "defaultTemplate"=>"none"
						)
					);
					echo '<p class="succes">' . __('Gallery', 'imagine-images') . ' '.$galname.' ' . __('created succesfully.', 'imagine-images') . '</p>';
				}
			} else {
				echo '<p class="fail">' . __('Gallery name already exists. Please choose another name.', 'imagine-images') . '</p>';
			}
		}
		if (isset($_GET['imagine']['template'])) {
			$template = sanitize_text_field($_GET['imagine']['template']);
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/gallery-overview.php";
		include $tempfile;

	}

	if (isset($_POST['updategallery'])) {
		$gals = $_POST['updategallery'];
		foreach($gals as $gal) {
			$galid = intval( $gal['galId'] );
			
			if(isset($gal['galName'])) {	
				if ( !preg_match("/^[a-zA-Z0-9 ]*$/", $gal['galName'] ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$galname = sanitize_text_field($gal['galName']);
				}
			} else {
				$galdesc = null;
			}
            
            if(isset($gal['galPreview'])) {	
					$galpreview = sanitize_file_name($gal['galPreview']);
				
			} else {
				$galpreview = null;
			}
            
            if(isset($gal['galTemplate'])) {	
					$galtemp = sanitize_text_field($gal['galTemplate']);
				
			} else {
				$galtemp = null;
			}
			
			if(isset($gal['galDesc'])) {	
				if ( !preg_match("/^[a-zA-Z0-9!?,. ]*$/", $gal['galDesc'] ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$galdesc = sanitize_text_field($gal['galDesc']);
				}
			} else {
				$galdesc = null;
			}
			$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$galid'");
			if ($exist != NULL) {
				$wpdb -> update($wpdb->prefix.'imagine_gallery', array(
					"galleryName" => $galname, 
					"galleryDesc"=>$galdesc,
                    "galleryPreviewImg" => $galpreview,
                    "defaultTemplate" => $galtemp
                ), 
                array("galleryId"=>$galid));
			}
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/gallery-overview.php";
		include $tempfile;
	}
	
	
	if (isset($_POST['gdel'])) {
		$gid = $_POST['gdel'];
		if ( !ctype_digit($gid) ) {
			echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
		} else {
			// INCLUDE MODULE remove-gallery.php
			$dir = plugin_dir_path( __FILE__ );
			include $dir.'modules/remove-gallery.php';
		}
		
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/gallery-overview.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';
	}
	
	// if gallery edit is set show specific gallery to edit.
	if (isset($_POST['gedit'])) {
		
		if ( !ctype_digit($_POST['gedit']) ) {
			echo "<p class='fail'>" . __('Unable to load gallery.', 'imagine-images') . "</p>";
		} else {
			// INCLUDE edit-gallery.php
			$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-gallery.php";
			include $tempfile;
		}
	}

	// ----------------------------------------------------------------------------------------------------------------------------------Add/Edit/Update ALBUM--------  //
	if (isset($_POST['addalbum'])){
		$datas = $_POST['addalbum'];
		foreach ($datas as $data) {
			if(isset($data['albumId'])) {	
				$aid = intval($data['albumId']);
				$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$aid'");
			} else {
				$exist = null;
			}
			
			
			// get user input - albumname
			if ( isset ( $data['albumName'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['albumName'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$aname = sanitize_text_field($data['albumName']);
				}	
			}
			
			// get user input - albumslug
			if ( isset ( $data['albumSlug'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['albumSlug'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$aslug = sanitize_text_field($data['albumSlug']);
					$aslug = explode(" ", $aslug);
					$aslug = implode('-', $aslug);
				}	
			}

			// get user input - albumdesc
			if ( isset ( $data['albumDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $data['albumDesc'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$adesc = sanitize_text_field($data['albumDesc']);
				}	
			}
						
			
			// some other values
			$today = date("Y-m-d"); 
			$time = date('H:i:s');
			$author = wp_get_current_user();
			$author = $author->display_name;
			
			
			$atemp = get_option('optionImagineDefaultAlbumTemplate');
			
			
			$existname = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumName = '$aname'");
			if ($existname == NULL) {
				if ($exist != NULL && $existname != NULL) {
					$wpdb -> update($wpdb->prefix.'imagine_albums', array(
						"albumName" => $aname, 
						"albumSlug" => $aslug, 
						"albumDesc"=>$adesc, 
						"albumPreviewImg"=>"unset"), 
						array("albumId"=>$aid, "albumName"=>$aname));
					} else {
						$wpdb -> insert($wpdb->prefix.'imagine_albums', array(
							"albumName" => $aname, 
							"albumSlug" => $aslug, 
							"creationDate" => $today,
							"creationTime" => $time,
							"albumAuthor" => $author,
							"albumPreviewImg"=>"unset",
                            "defaultTemplate"=>"none"
						)
					);
					echo '<p class="succes">' . __('Album', 'imagine-images') . ' '.$aname.' ' . __('created succesfully', 'imagine-images') . '.</p>';
				}
			} else {
				echo '<p class="fail">' . __('Album name already exists. Please choose another name.', 'imagine-images') . '</p>';
			}
		}
		if (isset($_GET['imagine']['template'])) {
			$template = sanitize_text_field($_GET['imagine']['template']);
		}
		$tempfile = plugin_dir_path(__FILE__) . "admin/album-overview.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';

	}
    
    if (isset($_POST['updatealbum'])) {
		$albums = $_POST['updatealbum'];
		foreach($albums as $album) {
			$albumid = intval( $album['albumId'] );
			
			if(isset($album['albumName'])) {	
				if ( !preg_match("/^[a-zA-Z0-9 ]*$/", $album['albumName'] ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$albumname = sanitize_text_field($album['albumName']);
				}
			} else {
				$albumname = null;
			}
			
			if(isset($album['albumDesc'])) {	
				if ( !preg_match("/^[a-zA-Z0-9!?,. ]*$/", $album['albumDesc'] ) ) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$albumdesc = sanitize_text_field($album['albumDesc']);
				}
			} else {
				$albumdesc = null;
			}
            
            if(isset($album['albumPreview'])) {	
					$albumpreview = sanitize_file_name($album['albumPreview']);
				
			} else {
				$galpreview = null;
			}
            if(isset($album['albumTemp'])) {	
					$albumtemp = sanitize_text_field($album['albumTemp']);
				
			} else {
				$albumtemp = null;
			}
			$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$albumid'");
			if ($exist != NULL) {
				$wpdb -> update($wpdb->prefix.'imagine_albums', array(
					"albumName" => $albumname, 
					"albumDesc"=>$albumdesc,
                    "albumPreviewImg"=>$albumpreview,
                    "defaultTemplate" => $albumtemp), 
					array("albumId"=>$albumid));
			}
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/album-overview.php";
		include $tempfile;
	}
    
    
    // Save album content
    if ( isset($_POST['savealbum']) ) {
        $acontent = $_POST['savealbum']['content'];
        $aid = $_POST['savealbum']['aid'];
        $wpdb->update($wpdb->prefix.'imagine_albums', array("albumContent" => $acontent), array("albumId" => $aid));
        
        $tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-album.php";
			include $tempfile;
    }

	// if gallery edit is set show specific gallery to edit.
	if (isset($_POST['albumedit'])) {
		
		if ( !ctype_digit($_POST['albumedit']) ) {
			echo "<p class='fail'>" . __('Unable to load album.', 'imagine-images') . "</p>";
		} else {
			// INCLUDE edit-gallery.php
			$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-album.php";
			include $tempfile;
		}
	}
    
    if (isset($_POST['adel'])) {
		$aid = $_POST['adel'];
		if ( !ctype_digit($aid) ) {
			echo "<p class='fail'>" . __('Unable to remove album.', 'imagine-images') . "</p>";
		} else {
			// INCLUDE MODULE remove-gallery.php
			$dir = plugin_dir_path( __FILE__ );
			include $dir.'modules/remove-album.php';
		}
		
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/album-overview.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------------Add/Edit/Update Template --------  //
	if (isset($_POST['updatetemplate'])) {
		$tmps = $_POST['updatetemplate'];
		foreach($tmps as $tmp) {
			
			if(isset($data['tmpId'])) {	
				$tmpid = intval($data['tmpId']);
			} 
			
			
			// get user input - albumname
			if ( isset ( $data['tmpName'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['tmpName'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$tmpname = sanitize_text_field($data['tmpName']);
				}	
			}

			// get user input - albumdesc
			if ( isset ( $data['tmpDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $data['tmpDesc'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$tmpdesc = sanitize_text_field($data['tmpDesc']);
				}	
			}
			
			
			$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempId = '$tmpid'");
			if ($exist != NULL) {
				$wpdb -> update($wpdb->prefix.'imagine_templates', array(
					"tempName" => $tmpname, 
					"tempDesc"=>$tmpdesc), 
					array("tempId"=>$tmpid));
			}
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/template-overview.php";
		include $tempfile;
	}
	
	
	if (isset($_POST['addtemplate'])){
		$datas = $_POST['addtemplate'];
		foreach ($datas as $data) {
			
			if(isset($data['tmpId'])) {	
				$tmpid = intval($data['tmpId']);
			}
			
			// get user input - albumname
			if ( isset ( $data['tmpName'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['tmpName'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$tmpname = sanitize_text_field($data['tmpName']);
				}	
			}
			
			// get user input - albumslug
			if ( isset ( $data['tmpSlug'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['tmpSlug'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$tmpslug = sanitize_text_field($data['tmpSlug']);
					$tmpslug = explode(" ", $tmpslug);
					$tmpslug = implode('-', $tmpslug);
					$tmpslug = strtolower($tmpslug);
				}	
			}

			// get user input - albumdesc
			if ( isset ( $data['tmpDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $data['tmpDesc'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$adesc = sanitize_text_field($data['tmpDesc']);
				}	
			}
			
			if (isset ($data['tmpType']) && ctype_alpha($data['tmpType'])) {
				$tmptype = sanitize_text_field($data['tmpType']);	
			}
			
			$today = date("Y-m-d"); 
			$time = date('H:i:s');
			$author = wp_get_current_user();
			$author = $author->display_name;
			
			$dir = get_template_directory();
			
			$tempcss = $tmpslug.'-css.php';
			$tempphp = $tmpslug.'.php';
			
			$temppath = $dir.'/imagine/templates/';
			
			$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = '$tmptype' && tempName = '$tmpname'");
			if ($exist != NULL) {
				
				echo __('Template name already exists. Please choose another name.', 'imagine-languages');
				} else {
					$wpdb -> insert($wpdb->prefix.'imagine_templates', array(
						"tempName" => $tmpname, 
						"tempType" => $tmptype,
						"tempSlug" => $tmpslug,
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => $author,
						"tempPath" => $temppath,
						"tempCss" => $tempcss,
						"tempPhp" => $tempphp,
						"tempDesc"=>$tmpdesc, 
					)
				);
			}
		}
		if (isset ($_GET['imagine']['template'])) {
			$template = sanitize_text_field($_GET['imagine']['template']);
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/admin-templates.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';
	}
	
	
	
	
	
	// ----------------------------------------------------------------------------------------------------------------------------------Add/Edit/Update Images --------  //
	if(isset($_POST['editimages'])) {
			
		
		for($i = 0; $i < count($_POST['editimages']); $i++) {
			
			if ( isset ($_POST['editimages'][$i]['gid']) && ctype_digit($_POST['editimages'][$i]['gid'])) {
				$gid = intval($_POST['editimages'][$i]['gid']);	
			} else {
				echo '<p class="fail">' . __('Error uploading image.', 'imagine-images') . '</p>';
				break 1;
			}
			
			
			if ( isset ($_POST['editimages'][$i]['imgid']) && ctype_digit($_POST['editimages'][$i]['imgid'])) {
				$imgid = intval($_POST['editimages'][$i]['imgid']);	
			} else {
				echo '<p class="fail">' . __('Error uploading image.', 'imagine-images') . '</p>';
				break 1;
			}
			
			
			// get user input - albumdesc
			if ( isset ( $_POST['editimages'][$i]['imgDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $_POST['editimages'][$i]['imgDesc'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$imgdesc = sanitize_text_field($_POST['editimages'][$i]['imgDesc']);
				}	
			}

			// get user input - albumtitle
			if ( isset ( $_POST['editimages'][$i]['imgAltTitle'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST['editimages'][$i]['imgAltTitle'] )) {
  					echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
					break 1;
				} else {
					$imgtitle = sanitize_text_field($_POST['editimages'][$i]['imgAltTitle']);
				}	
			}
			
			
			
			
			$exist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE imgId = '$imgid'");
			if ($exist != NULL) {
				$wpdb -> update($wpdb->prefix.'imagine_img', array("imgDesc"=>$imgdesc,"imgAltTitle"=>$imgtitle), array("imgId"=>$imgid));
		
			} 
			$gedit = $gid;
		}
		if (isset($_GET['imagine']['template']) && ctype_digit($_GET['imagine']['template'])) {
		$template = sanitize_text_field($_GET['imagine']['template']);
		
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-gallery.php";
		include $tempfile;
		
		echo '<p class="succes">' . __('Saved succesfully.', 'imagine-images') . '</p>';
		
	}
    
    if (isset($_POST['imgdel'])) {
		$iid = $_POST['imgdel'];
		if ( !ctype_digit($iid) ) {
			echo "<p class='fail'>" . __('Only letters and white spaces allowed.', 'imagine-images') . "</p>";
		} else {
			// INCLUDE MODULE remove-gallery.php
			$dir = plugin_dir_path( __FILE__ );
			include $dir.'modules/remove-image.php';
		}
		
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/gallery-overview.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------------Metabox----------------- --------  //
	
	/* NEED TO ADD TYPE */
	
	if(isset($_POST['metaboxgallery'])) {
		$data = $_POST['metaboxgallery'][0];
		if (isset($data['gid']) && ctype_digit($data['gid'])) {
			$gid = intval($data['gid']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		if (isset($data['template']) && preg_match("/^[a-zA-Z ]*$/", $data['template'] )) {
			$temp = sanitize_text_field($data['template']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		
		if (isset($data['layovertemplate']) && preg_match("/^[a-zA-Z ]*$/", $data['layovertemplate'] )) {
			$layovertemplate = sanitize_text_field($data['layovertemplate']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		
		$gallery = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'imagine_gallery WHERE galleryId = "$gid"');
		// $original_input = "<div class='imagine' type='gallery' gid='".esc_attr($gid)."' template='".esc_attr($temp)."' layovertemp='".esc_attr($layovertemplate)."'></div>";
        $original_input = "[imagine type='gallery' id='" . $gid . "' template='" . $temp . "' layover='" . $layovertemplate . "']";
		$html_encoded = htmlentities($original_input);
		echo $html_encoded;
		
	}
    
    if(isset($_POST['metaboxalbum'])) {
		$data = $_POST['metaboxalbum'][0];
		if (isset($data['aid']) && ctype_digit($data['aid'])) {
			$aid = intval($data['aid']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		if (isset($data['template']) && preg_match("/^[a-zA-Z ]*$/", $data['template'] )) {
			$temp = sanitize_text_field($data['template']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		
		// $original_input = "<div class='imagine' type='album' aid='".esc_attr($aid)."' template='".esc_attr($temp)."'></div>";
        $original_input = "[imagine type='album' id='" . $aid . "' template='" . $temp . "']";
		$html_encoded = htmlentities($original_input);
		echo $html_encoded;
		
	}
    
    if(isset($_POST['metaboximage'])) {
		$data = $_POST['metaboximage'][0];
		if (isset($data['iid']) && ctype_digit($data['iid'])) {
			$iid = intval($data['iid']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
        if (isset($data['template']) && preg_match("/^[a-zA-Z0-9 ]*$/", $data['template'] )) {
			$temp = sanitize_text_field($data['template']);
		} else {
			echo "<p class='fail'>" . __('Error saving.', 'imagine-images') . "</p>";
			break 1;
		}
		
		// $original_input = "<div class='imagine' type='image' iid='".esc_attr($iid)."' template='".$temp."'></div>";
        $original_input = "[imagine type='image' id='" . $iid . "' template='" . $temp . "']";
		$html_encoded = htmlentities($original_input);
		echo $html_encoded;
		
	}
	
	/*
	
	if (isset($_POST['tmpedit']) && ctype_digit($_POST['tmpedit'])) {
		$tid = sanitize_text_field($_POST['tmpedit']);
		$tempinfo = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempId = '$tid'");
		
		$dir = get_template_directory();
		$tempslug = $tempinfo->tempSlug;
		// INCLUDE edit-gallery.php
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-template.php";
		include $tempfile;
		
	}	
		
		*/


//	if(isset($_POST['uploadtemplate'])) {
//		$tempfile = plugin_dir_path( __FILE__ ) . "modules/uploadtemplate.php";
//		include $tempfile;
		
//	}
	
//	if (isset($_GET['gallery'])) {
//		$gallery = $_GET['gallery'];
//			
//			add_filter('the_content','add_postdata_to_content');
//			function add_postdata_to_content($text) {
//				$template = $_GET['template'];
//				$tempfile = plugin_dir_path( __FILE__ ) . "templates/imagine-gallery-extended.php";
//				global $post;
//				echo $text;
//				include $tempfile;
//			}
//		
//	}

	// ------------------------------------------------------------------------------------- FRONT END REQUESTS --------------------------------------------------------  //
	// ------------------------------------------------------------------------------------- FRONT END REQUESTS --------------------------------------------------------  //
	// ------------------------------------------------------------------------------------- FRONT END REQUESTS --------------------------------------------------------  //

		// runs if gallery
		if (isset($_GET['imagine'][0]['gallery'])) {
		    
			$gallery = intval($_GET['imagine'][0]['gallery']);
			/* template selection tool for frontend 
			 * 
			if (isset($_GET['imagine'][0]['tselect']) && $_GET['imagine'][0]['tselect'] == 'true') {
				$temps = $wpdb -> get_results("SELECT * FROM wp_imagine_templates WHERE tempType = 'gallery'");
				echo '<p>Change template: ';
				echo '<select class="tempselect">';
				foreach ($temps as $temp) {
					$tslug = $temp->tempSlug;
					$tname = $temp->tempName; 
					echo '<option value="'.$tname.'">'.$tname.'</input>';
				}
						
				echo '</select></p>';
			}
			*/
            
            // get option for pluginwide default gallery template from db.
			$opt1 = get_option('optionImagineDefaultGalleryTemplate');
            
            // get option for gallery specific default template fromd db.
            $dgtemp = $wpdb->get_col("SELECT defaultTemplate FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
			
            // check if a template is set in the ajax call (can come from inline or $.imagineGallery(template);
			if ( isset( $_GET['imagine'][0]['template'] ) ) {
                // if set through ajax use it.
				$template = sanitize_text_field($_GET['imagine'][0]['template']);
            // if not set use from settings
			} else {
                // if gallery specific template in gallery setting is set, use it.
                if ( $dgtemp[0] !== "none") {
                    $template = $dgtemp[0];
                } else {
                    // if nothing else is found, use sitewide setting for default gallery template.
				    $template = $opt1;
                }
			}
			$opt = get_option('optionImagineDefaultLayoverTemplate');
			
			if ( isset( $_GET['imagine'][0]['ltemp'] ) ) {
				$layovertemplate = sanitize_text_field($_GET['imagine'][0]['ltemp']);
			} else {
				$layovertemplate = $opt;
			}
			
			
			$temp = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = 'gallery' AND tempName='$template'");
			$tslug = $temp->tempSlug;
			$tid = $temp->tempId;
			$css = $temp->tempCss;
			$php = $temp->tempPhp;
			$path = $temp->tempPath;
			$filecss = $path . $css;
			$filephp = $path . $php;
			include $filephp;
				
				
			echo '<style>';
			include $path.'css/'.$css;
			echo '</style>';
			
		
        } 
    
        if (isset($_GET['imagine'][0]['album'])) {
            $album = intval($_GET['imagine'][0]['album']);
            $opt1 = get_option('optionImagineDefaultAlbumTemplate');
			$datemp = $wpdb->get_col("SELECT defaultTemplate FROM ".$wpdb->prefix."imagine_albums WHERE albumId = '$album'");
			if ( isset( $_GET['imagine'][0]['template'] ) ) {
				$template = sanitize_text_field($_GET['imagine'][0]['template']);
			} else {
				if ( $datemp[0] !== "none") {
                    $template = $datemp[0];
                } else {
				    $template = $opt1;
                }
			}
					
			
				 
				
				$temp = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = 'album' AND tempName = '$template'");
				$tslug = $temp->tempSlug;
				
				$tid = $temp->tempId;
				$css = $temp->tempCss;
				$php = $temp->tempPhp;
				$path = $temp->tempPath;
				$filecss = $path . $css;
				$filephp = $path . $php;
				include $filephp;
					
					
				echo '<style>';
				include $path.'css/'.$css;
				echo '</style>';
				
			
        }
    
    if (isset($_GET['imagine'][0]['image'])) {
					
			$opt1 = get_option('optionImagineDefaultImageTemplate');
			
			if ( isset( $_GET['imagine'][0]['template'] ) ) {
				$template = sanitize_text_field($_GET['imagine'][0]['template']);
			} else {
				// add default image template
				$template = $opt1;
			}
				 
				
				$temp = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_templates WHERE tempType = 'image' AND tempName = '$template'");
				$tslug = $temp->tempSlug;
				
				$tid = $temp->tempId;
				$css = $temp->tempCss;
				$php = $temp->tempPhp;
				$path = $temp->tempPath;
				$filecss = $path . $css;
				$filephp = $path . $php;
				include $filephp;
					
					
				echo '<style>';
				include $path.'css/'.$css;
				echo '</style>';
				
			
        }
		
		if(isset($_POST['viewimage'])) {
			$gid = intval($_POST['viewimage']['gid']);
			$imgid = intval($_POST['viewimage']['imgid']);
			if(isset($_POST['viewimage']['layovertemp'])){
				$layovertemplate = sanitize_text_field($_POST['viewimage']['layovertemp']);
			} else {
				$layovertemplate = get_option('optionImagineDefaultLayoverTemplate');
			}
			$img = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE imgId = '$imgid' AND galleryId = '$gid'");
			$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gid'");
			$galslug = $gallery->gallerySlug;
			$filename = $img -> imgFilename;
			$plugindir = wp_upload_dir();
			$pluginurl = $plugindir['baseurl'];
			$imgurl =  $pluginurl . '/imagine/' . $galslug . '/' . $filename  ;
			
			echo '<link rel="stylesheet" type="text/css" href="'.plugins_url().'/imagine/templates/css/'.esc_attr($layovertemplate).'-layover.css">';
			echo '<div id="imagine-layover">';
				echo '<img class="layover-image" src="'.esc_attr($imgurl).'">';
				echo '<span class="close-imagine-layover">' . __('Close', 'imagine-images') . '</span>';
			echo '</div>';
		}

	
	

	die();
}
?>