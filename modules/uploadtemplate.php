<?php

/* not yet functional.

		$temp = $_POST['uploadtemplate'];
		$tid = $_POST['uploadtemplate']['tid'];
		$title = $_POST['uploadtemplate']['title'];
		$desc = $_POST['uploadtemplate']['desc'];
		$wrap = $_POST['uploadtemplate']['wrap'];
		
		$tempinfo = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempId = '$tid'");
		$tname = $tempinfo->tempName;
		$css = $tempinfo->tempCss;
		$php = $tempinfo->tempPhp;
		$path = $tempinfo->tempPath;
		$filecss = $path . $css;
		$filephp = $path . $php;
		
		$dir = get_template_directory();
		$tempslug = $tempinfo->tempSlug;
		$tname = $tempinfo->tempName;
		
		if (!file_exists($dir.'/imagine/')) {
		  	mkdir($dir.'/imagine/', 0777, true);
			echo 'succes';
		}
		if (!file_exists($dir.'/imagine/templates/')) {
		  	mkdir($dir.'/imagine/templates', 0777, true);
		}
		
		
		
		// Open the file to get existing content
		$php = file_get_contents($filephp);
		$css = file_get_contents($filecss);
		// Append a new person to the file
		
		$START   = '<?php ';
		$LINE000 = '$gallery = $_GET["imagine"]["gallery"]; ';
		$LINE001 = 'if ($gallery == NULL) $gallery = "3" ; ';
		$LINE002 = '$imgs = $wpdb -> get_results("SELECT * FROM wp_imagine_img WHERE galleryId = \'$gallery\'"); ';
		$LINE002 = '$gal = $wpdb -> get_row("SELECT * FROM wp_imagine_gallery WHERE galleryId = \'$gallery\'"); ';
		$LINE003 = 'foreach($imgs as $img) { ';
		$LINE004 = 'echo $img->imgFilename; ';
		$LINE005 = '}; ';
		$LINE006 = '$gname = $gal->galleryName; ';
		$LINE007 = '$gdesc = $gal->galleryDesc; ';
		$END     = ' ?>';
	
		$newphp = $newphp = $START . $LINE000 . $LINE001 .$LINE002 . $LINE003 . $LINE004 . $LINE005 . $LINE006 .$LINE007 . $END;
		file_put_contents($filephp, $newphp);
		
		$newcss;
		
		
		
		if (isset($wrap)) {
			$wrapwidth = $wrap['width'];
			$wrapbackground = $wrap['background'];
			$wrapheight = $wrap['height'];
			
			$newwrapcss = ".imagine[template='".$tname."'] { display: table; width:".$wrapwidth."; background-color: ".$wrapbackground."; height: ".$wrapheight." } ";
			$newcss = $newwrapcss;
		}
					
		if ( $title['show'] == true ) {
			$titleorder = $title['order'];
			$titlecolor = $title['color'];
			$titlefontsize = $title['fontsize'];
			$titlewidth = $title['width'];
			$titlefloat = $title['float'];
			
			// set html/php for the title
			$newtitle = '<p class="' . $tempslug . '_title" sort="'.$titleorder.'" type="elem"> <?php echo $gname; ?> </p>';
			$newphp = $newphp . $newtitle;
			file_put_contents($filephp, $newphp);
			// set css for the title
			$newtitlecss = "." . $tempslug . "_title { color:".$titlecolor."; font-size: ".$titlefontsize."; } ";
			$newcss = $newcss . $newtitlecss;
			file_put_contents($filecss, $newtitlecss);
		} 
		if ( $desc['show'] == true ) {
			$descorder = $desc['order'];
			$desccolor = $desc['color'];
			$descfontsize = $desc['fontsize'];
			
			// set html/php for the title
			$newdesc = '<p class="' . $tempslug . '_desc" sort="'.$descorder.'" type="elem"> <?php echo $gdesc; ?> </p>';
			$newphp = $newphp . $newdesc;
			file_put_contents($filephp, $newphp);
			// set css for the title
			$newdesccss = "." . $tempslug . "_desc { color:".$desccolor."; font-size: ".$descfontsize." } ";
			$newcss = $newcss . $newdesccss;
			file_put_contents($filecss, $newcss);
		}
		
		echo $css;
		
		echo $php;
 * 
 * */
?>