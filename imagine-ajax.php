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
	  				echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else { 
					update_option($input, $value);
					
				}
			} else {
				if (!ctype_alnum( str_replace(' ', '', $value ))) {
	  				echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else { 
					update_option($input, $value);
					
				}
			}
		}
		echo '<p class="succes">Saved.</p>';
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/settings.php";
		include_once $tempfile;
	}
	
	
	
	
	// ----------------------------------------------------------------------------------------------------------------------------------Add/Edit/Update Gallery--------  //
	if (isset($_POST['addgallery'])){
		$datas = $_POST['addgallery'];
		foreach ($datas as $data) {
			
			if(isset($_POST['addgallery']['galId'])) {	
				$galid = intval($data['galId']);
				$exist = $wpdb->get_results("SELECT * FROM wp_imagine_gallery WHERE galleryId = '$galid'");
			} else {
				$exist = null;
			}
			
			// get user input - galname
			if ( isset ( $data['galName'] ) ) {
				// stop if contains invalid chars
				if ( !ctype_alpha( str_replace(' ', '', $data['galName'] ))) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$galname = sanitize_text_field($data['galName']);
				}	
			}
			
			
			// get user input - galslug
			if ( isset ( $data['galSlug'] ) ) {
				// stop if contains invalid chars
				if ( !ctype_alnum( str_replace(' ', '', $data['galSlug']) ) ) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$galslug = sanitize_text_field($data['galSlug']);
					$galslug = explode(" ", $galslug);
					$galslug = implode('-', $galslug);
					
					$galpath = content_url().'/imagine/'.$galslug;
				}	
			}
			
			
			
			
			$today = date("Y-m-d"); 
			$time = date('H:i:s');
			$author = wp_get_current_user();
			$author = $author->display_name;
			
			$galpath = explode(" ", $galpath);
			$galpath = implode('-', $galpath);
			if(isset($data['galDesc'])) {	
				if ( !ctype_alnum( str_replace(' ', '', $data['galDesc']) ) ) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$galdesc = sanitize_text_field($data['galDesc']);
				}
			} else {
				$galdesc = null;
			}
			
			$existname = $wpdb->get_results("SELECT * FROM wp_imagine_gallery WHERE galleryName = '$galname'");
			if ($existname == NULL) {
				if ($exist != NULL && $existname != NULL) {
					$wpdb -> update('wp_imagine_gallery', array(
						"galleryName" => $galname, 
						"galleryDesc"=>$galdesc, 
						"galleryPreviewImg"=>"unset"), 
						array("galleryId"=>$galid, "galleryName"=>$galname));
					} else {
						$wpdb -> insert('wp_imagine_gallery', array(
							"galleryName" => $galname, 
							"gallerySlug" => $galslug, 
							"galleryPath" => $galpath, 
							"creationDate" => $today,
							"creationTime" => $time,
							"galleryAuthor" => $author,
							"galleryDesc"=>$galdesc, 
							"galleryPreviewImg"=>"unset"
						)
					);
					echo '<p class="succes">Gallery '.$galname.' created succesfully.</p>';
				}
			} else {
				echo '<p class="fail">Gallery name exists already. Please choose another name.</p>';
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
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$galname = sanitize_text_field($gal['galName']);
				}
			} else {
				$galdesc = null;
			}
			
			if(isset($gal['galDesc'])) {	
				if ( !preg_match("/^[a-zA-Z0-9!?,. ]*$/", $gal['galDesc'] ) ) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$galdesc = sanitize_text_field($gal['galDesc']);
				}
			} else {
				$galdesc = null;
			}
			$exist = $wpdb->get_results("SELECT * FROM wp_imagine_gallery WHERE galleryId = '$galid'");
			if ($exist != NULL) {
				$wpdb -> update('wp_imagine_gallery', array(
					"galleryName" => $galname, 
					"galleryDesc"=>$galdesc), 
					array("galleryId"=>$galid));
			}
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/gallery-overview.php";
		include $tempfile;
	}
	
	
	if (isset($_POST['gdel'])) {
		$gid = $_POST['gdel'];
		if ( !ctype_digit($gid) ) {
			echo "<p class='fail'>Unable to remove gallery.</p>";
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
			echo "<p class='fail'>Unable to load gallery.</p>";
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
				$exist = $wpdb->get_results("SELECT * FROM wp_imagine_albums WHERE albumId = '$aid'");
			} else {
				$exist = null;
			}
			
			
			// get user input - albumname
			if ( isset ( $data['albumName'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['albumName'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$aname = sanitize_text_field($data['albumName']);
				}	
			}
			
			// get user input - albumslug
			if ( isset ( $data['albumSlug'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['albumSlug'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
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
  					echo "<p class='fail'>Only letters and white space allowed</p>";
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
			
			
			
			
			
			$existname = $wpdb->get_results("SELECT * FROM wp_imagine_albums WHERE albumName = '$aname'");
			if ($existname == NULL) {
				if ($exist != NULL && $existname != NULL) {
					$wpdb -> update('wp_imagine_albums', array(
						"albumName" => $aname, 
						"albumSlug" => $aslug, 
						"albumDesc"=>$adesc, 
						"albumPreviewImg"=>"unset"), 
						array("albumId"=>$aid, "albumName"=>$aname));
					} else {
						$wpdb -> insert('wp_imagine_albums', array(
							"albumName" => $aname, 
							"albumSlug" => $aslug, 
							"creationDate" => $today,
							"creationTime" => $time,
							"albumAuthor" => $author,
							"albumPreviewImg"=>"unset"
						)
					);
					echo '<p class="succes">Album '.$aname.' created succesfully.</p>';
				}
			} else {
				echo '<p class="fail">Album name exists already. Please choose another name.</p>';
			}
		}
		if (isset($_GET['imagine']['template'])) {
			$template = sanitize_text_field($_GET['imagine']['template']);
		}
		$tempfile = plugin_dir_path(__FILE__) . "admin/album-overview.php";
		include $tempfile;
		echo '<div class="imagine-formtable-wrap"></div>';

	}

	// if gallery edit is set show specific gallery to edit.
	if (isset($_POST['albumedit'])) {
		
		if ( !ctype_digit($_POST['albumedit']) ) {
			echo "<p class='fail'>Unable to load album.</p>";
		} else {
			// INCLUDE edit-gallery.php
			$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-album.php";
			include $tempfile;
		}
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
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$tmpname = sanitize_text_field($data['tmpName']);
				}	
			}

			// get user input - albumdesc
			if ( isset ( $data['tmpDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $data['tmpDesc'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$tmpdesc = sanitize_text_field($data['tmpDesc']);
				}	
			}
			
			
			$exist = $wpdb->get_results("SELECT * FROM wp_imagine_templates WHERE tempId = '$tmpid'");
			if ($exist != NULL) {
				$wpdb -> update('wp_imagine_templates', array(
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
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$tmpname = sanitize_text_field($data['tmpName']);
				}	
			}
			
			// get user input - albumslug
			if ( isset ( $data['tmpSlug'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z ]*$/", $data['tmpSlug'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
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
  					echo "<p class='fail'>Only letters and white space allowed</p>";
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
			
			$exist = $wpdb->get_results("SELECT * FROM wp_imagine_templates WHERE tempType = '$tmptype' && tempName = '$tmpname'");
			if ($exist != NULL) {
				
				echo 'Template name exists.';
				} else {
					$wpdb -> insert('wp_imagine_templates', array(
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
				echo '<p class="fail">Error uploading image.</p>';
				break 1;
			}
			
			
			if ( isset ($_POST['editimages'][$i]['imgid']) && ctype_digit($_POST['editimages'][$i]['imgid'])) {
				$imgid = intval($_POST['editimages'][$i]['imgid']);	
			} else {
				echo '<p class="fail">Error uploading image.</p>';
				break 1;
			}
			
			
			// get user input - albumdesc
			if ( isset ( $_POST['editimages'][$i]['imgDesc'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9!?,. ]*$/", $_POST['editimages'][$i]['imgDesc'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$imgdesc = sanitize_text_field($_POST['editimages'][$i]['imgDesc']);
				}	
			}

			// get user input - albumtitle
			if ( isset ( $_POST['editimages'][$i]['imgAltTitle'] ) ) {
				// stop if contains invalid chars
				if (!preg_match("/^[a-zA-Z0-9 ]*$/", $_POST['editimages'][$i]['imgAltTitle'] )) {
  					echo "<p class='fail'>Only letters and white space allowed</p>";
					break 1;
				} else {
					$imgtitle = sanitize_text_field($_POST['editimages'][$i]['imgAltTitle']);
				}	
			}
			
			
			
			
			$exist = $wpdb->get_results("SELECT * FROM wp_imagine_img WHERE imgId = '$imgid'");
			if ($exist != NULL) {
				$wpdb -> update('wp_imagine_img', array("imgDesc"=>$imgdesc,"imgAltTitle"=>$imgtitle), array("imgId"=>$imgid));
		
			} 
			$gedit = $gid;
		}
		if (isset($_GET['imagine']['template']) && ctype_digit($_GET['imagine']['template'])) {
		$template = sanitize_text_field($_GET['imagine']['template']);
		
		}
		$tempfile = plugin_dir_path( __FILE__ ) . "admin/edit-gallery.php";
		include $tempfile;
		
		echo '<p>Opgeslagen in database.</p>';
		
	}
	
	// ----------------------------------------------------------------------------------------------------------------------------------Metabox----------------- --------  //
	
	/* NEED TO ADD TYPE */
	
	if(isset($_POST['metaboxdata'])) {
		$data = $_POST['metaboxdata'][0];
		if (isset($data['gid']) && ctype_digit($data['gid'])) {
			$gid = intval($data['gid']);
		} else {
			echo "<p class='fail'>Error saving.</p>";
			break 1;
		}
		if (isset($data['template']) && preg_match("/^[a-zA-Z ]*$/", $data['template'] )) {
			$temp = sanitize_text_field($data['template']);
		} else {
			echo "<p class='fail'>Error saving.</p>";
			break 1;
		}
		
		if (isset($data['layovertemplate']) && preg_match("/^[a-zA-Z ]*$/", $data['layovertemplate'] )) {
			$layovertemplate = sanitize_text_field($data['layovertemplate']);
		} else {
			echo "<p class='fail'>Error saving.</p>";
			break 1;
		}
		
		$gallery = $wpdb->get_row('SELECT * FROM wp_imagine_gallery WHERE galleryId = "$gid"');
		$original_input = "<div class='imagine' gid='".esc_attr($gid)."' template='".esc_attr($temp)."' layovertemp='".esc_attr($layovertemplate)."'></div>";
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
			$opt1 = get_option('optionImagineDefaultGalleryTemplate');
			
			if ( isset( $_GET['imagine'][0]['template'] ) ) {
				$template = sanitize_text_field($_GET['imagine'][0]['template']);
			} else {
				// add default gallery template -- PER GALLERY
				$template = $opt1;
			}
			
			$opt = get_option('optionImagineDefaultLayoverTemplate');
			
			if ( isset( $_GET['imagine'][0]['ltemp'] ) ) {
				$layovertemplate = sanitize_text_field($_GET['imagine'][0]['ltemp']);
			} else {
				$layovertemplate = $opt;
			}
			
			
			$temp = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempType = 'gallery' AND tempName='$template'");
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
					
			
				/* add support for default template,, wp-options */
				 
				
				$template = sanitize_text_field($_GET['imagine'][0]['template']);
				$layovertemplate = sanitize_text_field($_GET['imagine'][0]['ltemp']);
				$temp = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempType = 'album' AND tempName = '$template'");
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
			$img = $wpdb->get_row("SELECT * FROM wp_imagine_img WHERE imgId = '$imgid' AND galleryId = '$gid'");
			$gallery = $wpdb -> get_row("SELECT * FROM wp_imagine_gallery WHERE galleryId = '$gid'");
			$galslug = $gallery->gallerySlug;
			$filename = $img -> imgFilename;
			$plugindir = wp_upload_dir();
			$pluginurl = $plugindir['baseurl'];
			$imgurl =  $pluginurl . '/imagine/' . $galslug . '/' . $filename  ;
			
			echo '<link rel="stylesheet" type="text/css" href="'.plugins_url().'/imagine/templates/css/'.esc_attr($layovertemplate).'-layover.css">';
			echo '<div id="imagine-layover">';
				echo '<img class="layover-image" src="'.esc_attr($imgurl).'">';
				echo '<span class="close-imagine-layover">Close</span>';
			echo '</div>';
		}

	
	

	die();
}
?>