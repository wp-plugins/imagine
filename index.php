<?php
/**
 * Plugin Name: Imagine
 * Author: Martijn Michel, TocadoVision
 * Description: A new cool kid on the block gallery plugin completely written with $.AJAX.get() for extremely versatile pages.
 * Version: 0.99
 */
 
 
 
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
// ----------------LIST TO DO------------------------------------------LIST TO DO ------------------------------------------LIST TO DO-----------------------------  //
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //	
 
/*
 * 1. Custom templates TABLE.jQuery.css.php
 * 2. Custom layover templates TABLE.jQuery.css.php
 */ 

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
// ------------------------------------------------------------------------------------- SETUP IMAGINE     --------------------------------------------------------  //
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //	
	
function register_imagine() {

	global $wpdb;


	$images = "CREATE TABLE IF NOT EXISTS wp_imagine_img (
			imgId mediumint(9) NOT NULL AUTO_INCREMENT,
			galleryId tinytext NOT NULL,
			imgSlug tinytext NOT NULL,
			imgFilename varchar(255) NOT NULL,
			imgSize varchar(255) NOT NULL,
			imgDesc varchar(255),
			imgAltTitle varchar(255),
			imgAuthor varchar(255),
			creationDate date,
			creationTime time,
			imageTags varchar(255),
			PRIMARY KEY (imgId)
		);";

	$galleries = "CREATE TABLE IF NOT EXISTS wp_imagine_gallery (
			galleryId mediumint(9) NOT NULL AUTO_INCREMENT,
			galleryName varchar(255) NOT NULL,
			gallerySlug varchar(255) NOT NULL,
			galleryPath varchar(255) NOT NULL,
			galleryDesc varchar(255),
			galleryPreviewImg varchar(255),
			galleryAuthor varchar(255),
			creationDate date,
			creationTime time,
			defaultTemplate varchar(255),
			PRIMARY KEY (galleryId)
		);";
		
		$templates = "CREATE TABLE IF NOT EXISTS wp_imagine_templates (
			tempId mediumint(9) NOT NULL AUTO_INCREMENT,
			tempName varchar(255) NOT NULL,
			tempType varchar(255) NOT NULL,
			tempSlug varchar(255),
			tempDesc varchar(255),
			tempAuthor varchar(255),
			tempDate date,
			tempTime time,
			tempCss varchar(255),
			tempPhp varchar(255),
			tempPath varchar(255),
			PRIMARY KEY (tempId)
		);";
		$albums = "CREATE TABLE IF NOT EXISTS wp_imagine_albums (
			albumId mediumint(9) NOT NULL AUTO_INCREMENT,
			albumName varchar(255) NOT NULL,
			albumSlug varchar(255),
			albumDesc varchar(255),
			albumPreviewImg varchar(255),
			albumAuthor varchar(255),
			creationDate date,
			creationTime time,
			albumContent varchar(222),
			defaultTemplate varchar(255),
			PRIMARY KEY (albumId)
		);";

	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($images);
	dbDelta($galleries);
	dbDelta($templates);
	dbDelta($albums);
	
	// SETUP DEFAULTS OPTIONS
	
	if ( get_option('optionImagineDefaultPath') == NULL ) {
		update_option('optionImagineDefaultPath', 'imagine/uploads'); // default upload dir after wp-content
	}
	if ( get_option('optionImagineThumbnailWidth') == NULL ) { // default thumb width
		update_option('optionImagineThumbnailWidth', '150'); 
	} 
	if ( get_option('optionImagineIncludejQuery') == NULL ) { // default jquery insert
		update_option('optionImagineIncludejQuery', 'yes'); 
	}
	if ( get_option('optionImagineDefaultGalleryTemplate') == NULL) { // default template
		update_option('optionImagineDefaultGalleryTemplate', 'Imagine Gallery Extended'); 
	}
	if ( get_option('optionImagineDefaultLayoverTemplate') == NULL ) { // default template
		update_option('optionImagineDefaultLayoverTemplate', 'imagine'); 
	}
	
	$ext = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempName ='Imagine Gallery Extended'");
	$min = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempName ='Imagine Gallery Minified'");
	$alb = $wpdb->get_row("SELECT * FROM wp_imagine_templates WHERE tempName ='Imagine Album Minified'");
	$today = date("Y-m-d"); 
	$time = date('H:i:s');
	
	$dir = plugin_dir_path(__FILE__).'templates/';
	$temppath = $dir.'/templates/';
	// insert default gallery templates into WPDB
	if ( $ext == NULL) {
	$wpdb -> insert('wp_imagine_templates', array(
						"tempName" => "Imagine Gallery Extended", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-extended",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-extended.css',
						"tempPhp" => 'imagine-gallery-extended.php',
						"tempDesc"=> "Showcase Gallery Extended", 
					)
				);
	}
	if ($min == NULL) {
	$wpdb -> insert('wp_imagine_templates', array(
						"tempName" => "Imagine Gallery Minified", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-minified",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-minified.css',
						"tempPhp" => 'imagine-gallery-minified.php',
						"tempDesc"=> "Showcase Gallery minified", 
					)
				);		
				}	
	if ($alb == NULL) {
	$wpdb -> insert('wp_imagine_templates', array(
						"tempName" => "Imagine Album Minified", 
						"tempType" => "album",
						"tempSlug" => "imagine-album-minified",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-album-minified.css',
						"tempPhp" => 'imagine-album-minified.php',
						"tempDesc"=> "Showcase Album minified", 
					)
				);		
				}	
	
}

register_activation_hook(__FILE__, 'register_imagine');


	



function admin_imagine() {
	add_menu_page('Imagine', 'Imagine', 'manage_options', 'imagine', 'loadadmin', plugin_dir_url(__FILE__).'img/imagine-logo-32px.png');
	add_submenu_page('imagine', 'Gallery', 'Gallery', 'manage_options', 'gallery', 'loadgallery');
	add_submenu_page('imagine', 'Album', 'Album', 'manage_options', 'album', 'loadalbum');
	add_submenu_page('imagine', 'Templates', 'Templates', 'manage_options', 'templates', 'loadtemplates');
	add_submenu_page('imagine', 'Settings', 'Settings', 'manage_options', 'settings', 'loadsettings');
	add_submenu_page('imagine', 'Howto', 'Howto', 'manage_options', 'howto', 'loadhowto');
}

add_action('admin_menu', 'admin_imagine');

function loadsettings() {
	echo '<div class="imagine-wrap">';
	include 'admin/settings.php';
	echo '</div>';
}

function loadhowto() {
	echo '<div class="imagine-wrap">';
	include 'admin/howto.php';
	echo '</div>';
}

function loadtemplates() {
	echo '<div class="imagine-wrap">';
	include 'admin/admin-templates.php';
	echo '</div>';
}

function loadadmin() {
		echo '<div class="imagine-wrap">';
	include 'admin/imagine-admin.php';
	echo '</div>';
}

function loadgallery() {
	echo '<div class="imagine-wrap">';
	include 'admin/admin-gallery.php';
	echo '</div>';
}

function loadalbum() {
	echo '<div class="imagine-wrap">';
	include 'admin/admin-album.php';
	echo '</div>';
}


add_action('init', 'initimagine');

add_action('admin_enqueue_scripts', 'initadminscript');

function initadminscript() {
		
	
	wp_enqueue_script('imagine-ajax', plugin_dir_url(__FILE__) . 'js/xajax.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-droppable'),'1.0', false);
	wp_enqueue_style('imagine-admin-css', plugin_dir_url(__FILE__) . 'imagine-admin.css');
	wp_localize_script('imagine-ajax', 'imagineajax', array('ajaxurl' => admin_url('admin-ajax.php')));
	wp_enqueue_style('uistyle', 'https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
		
}

include 'modules/imagine-meta-box.php';

function initimagine() {
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('imagine-front-js', plugin_dir_url(__FILE__) . 'js/imagine.js', array('jquery'), '1.0', false);
	wp_localize_script('imagine-front-js', 'imagineajax', array('ajaxurl' => admin_url('admin-ajax.php')));
	

	add_action('wp_ajax_nopriv_imagine-ajaxsubmit', 'imagine_ajaxsubmit');
	add_action('wp_ajax_imagine-ajaxsubmit', 'imagine_ajaxsubmit');
	
	
	
}

include 'imagine-ajax.php';
?>