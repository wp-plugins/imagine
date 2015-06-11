<?php
/*
 * Plugin Name: Imagine
 * Plugin URI: http://tocadovision.nl/imagine
 * Author: Tocado Vision
 * Author URI: http://tocadovision.nl
 * Description: A new cool kid on the block gallery plugin completely written with $.AJAX.get() for extremely versatile pages.
 * Version: 0.99.9
 * Text Domain: imagine-languages
 * Domain Path: /lang/
 */
 
 
 
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
// ----------------LIST TO DO------------------------------------------LIST TO DO ------------------------------------------LIST TO DO-----------------------------  //
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //	
 
/*
 * 1. Custom templates TABLE.jQuery.css.php
 * 2. Custom layover templates TABLE.jQuery.css.php
 * 3. A custom template to be instructed by js. in the template everything is included and can be shown/hidden with javascript. it runs on a custom function.
    ie $.imagineGalleryTemplate(title, desc, width, height, etc, etc); templatename 'Imagine Gallery/Album jQuery'
 */ 

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //
// ------------------------------------------------------------------------------------- SETUP IMAGINE     --------------------------------------------------------  //
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------  //	
	

function on_activate( $network_wide ) {
    
    
        global $wpdb;

    if ( is_multisite() && $network_wide ) {
        // store the current blog id
        $current_blog = $wpdb->blogid;

        // Get all blogs in the network and activate plugin on each one
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
            switch_to_blog( $blog_id );
            register_imagine();
            restore_current_blog();
        }
    } else {
        register_imagine();
    }

}
function register_imagine() {

	global $wpdb;
    $table_img = $wpdb->prefix . 'imagine_img';
    $table_gallery = $wpdb->prefix . 'imagine_gallery';
    $table_templates = $wpdb->prefix . 'imagine_templates';
    $table_albums = $wpdb->prefix . 'imagine_albums';

	$images = "CREATE TABLE IF NOT EXISTS " . $table_img ." (
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

	$galleries = "CREATE TABLE IF NOT EXISTS " . $table_gallery ." (
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
		
		$templates = "CREATE TABLE IF NOT EXISTS " . $table_templates ." (
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
		$albums = "CREATE TABLE IF NOT EXISTS " . $table_albums ." (
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
	
	if ( get_option('optionImagineThumbnailWidth') == NULL ) { // default thumb width
		update_option('optionImagineThumbnailWidth', '150'); 
	}
    if ( get_option('optionImagineThumbnailWidth') == NULL ) { // default thumb width
		update_option('optionImagineThumbnailRatio', '16:9'); 
	}
	if ( get_option('optionImagineDefaultGalleryTemplate') == NULL) { // default template
		update_option('optionImagineDefaultGalleryTemplate', 'Imagine Gallery Extended'); 
	}
    if ( get_option('optionImagineDefaultAlbumTemplate') == NULL) { // default template
		update_option('optionImagineDefaultAlbumTemplate', 'Imagine Album Minified'); 
	}
	if ( get_option('optionImagineDefaultLayoverTemplate') == NULL ) { // default template
		update_option('optionImagineDefaultLayoverTemplate', 'imagine'); 
	}
	
	$ext = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Gallery Extended'");
	$min = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Gallery Minified'");
    $wall = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Gallery Wall'");
    $threed = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Gallery Slicebox'");
    $car = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Gallery Carousel'");
	$albmin = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Album Minified'");
    $albext = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Album Extended'");
    $imgmin = $wpdb->get_row("SELECT * FROM ".$table_templates." WHERE tempName ='Imagine Image Minified'");
	$today = date("Y-m-d"); 
	$time = date('H:i:s');
	
	$dir = plugin_dir_path(__FILE__).'templates/';
	$temppath = $dir.'/templates/';
	// insert default gallery templates into WPDB
	if ( $ext == NULL) {
	$wpdb -> insert( $table_templates, array(
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
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Gallery Minified", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-minified",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-minified.css',
						"tempPhp" => 'imagine-gallery-minified.php',
						"tempDesc"=> "Showcase Gallery Minified", 
					)
				);		
				}
    if ($wall == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Gallery Wall", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-wall",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-wall.css',
						"tempPhp" => 'imagine-gallery-wall.php',
						"tempDesc"=> "Showcase Gallery Wall", 
					)
				);		
				}
    if ($threed == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Gallery Slicebox", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-slicebox",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-slicebox.css',
						"tempPhp" => 'imagine-gallery-slicebox.php',
						"tempDesc"=> "Showcase Gallery Slicebox", 
					)
				);		
				}
    if ($car == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Gallery Carousel", 
						"tempType" => "gallery",
						"tempSlug" => "imagine-gallery-carousel",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-gallery-carousel.css',
						"tempPhp" => 'imagine-gallery-carousel.php',
						"tempDesc"=> "Showcase Gallery Carousel", 
					)
				);		
				}
	if ($albmin == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Album Minified", 
						"tempType" => "album",
						"tempSlug" => "imagine-album-minified",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-album-minified.css',
						"tempPhp" => 'imagine-album-minified.php',
						"tempDesc"=> "Showcase Album Minified", 
					)
				);		
				}
    if ($albext == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Album Extended", 
						"tempType" => "album",
						"tempSlug" => "imagine-album-extended",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-album-extended.css',
						"tempPhp" => 'imagine-album-extended.php',
						"tempDesc"=> "Showcase Album Extended", 
					)
				);		
				}
    if ($imgmin == NULL) {
	$wpdb -> insert($table_templates, array(
						"tempName" => "Imagine Image Minified", 
						"tempType" => "image",
						"tempSlug" => "imagine-image-minified",
						"tempDate" => $today,
						"tempTime" => $time,
						"tempAuthor" => "imagine",
						"tempPath" => $dir,
						"tempCss" => 'imagine-image-minified.css',
						"tempPhp" => 'imagine-image-minified.php',
						"tempDesc"=> "Showcase Image minified", 
					)
				);		
				}
	
}

register_activation_hook(__FILE__, 'on_activate');


// Creating table whenever a new blog is created
function on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    if ( is_plugin_active_for_network( 'imagine/index.php' ) ) {
        switch_to_blog( $blog_id );
        register_imagine();
        restore_current_blog();
    }
}
add_action( 'wpmu_new_blog', 'on_create_blog', 10, 6 );
	
// Deleting the table whenever a blog is deleted
function on_delete_blog( $tables ) {
    global $wpdb;
    $tables[] = Array();
    Array_push($tables, $wpdb->prefix . 'imagine_img');
    Array_push($tables, $wpdb->prefix . 'imagine_templates');
    Array_push($tables, $wpdb->prefix . 'imagine_albums');
    Array_push($tables, $wpdb->prefix . 'imagine_gallery');
    return $tables;
    
    
    
}
add_filter( 'wpmu_drop_tables', 'on_delete_blog' );


function imagine_load_textdomain() {
	load_plugin_textdomain( 'imagine-languages', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}

add_action('plugins_loaded', 'imagine_load_textdomain');
function admin_imagine() {
	add_menu_page('Imagine', 'Imagine', 'manage_options', 'imagine', 'loadadmin', plugin_dir_url(__FILE__).'img/imagine-logo-32px.png');
	add_submenu_page('imagine', 'Gallery', __('Gallery','imagine-languages'), 'manage_options', 'gallery', 'loadgallery');
	add_submenu_page('imagine', 'Album', __('Album','imagine-languages'), 'manage_options', 'album', 'loadalbum');
	add_submenu_page('imagine', 'Templates', __('Template','imagine-languages'), 'manage_options', 'templates', 'loadtemplates');
	add_submenu_page('imagine', 'Settings', __('Settings','imagine-languages'), 'manage_options', 'settings', 'loadsettings');
	add_submenu_page('imagine', 'Howto', __('Howto','imagine-languages'), 'manage_options', 'howto', 'loadhowto');
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
    
    // wp_enqueue_script('fancyBox', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.js', array('jquery'));
    // wp_enqueue_style('fancyBoxCSS', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.js');
	wp_localize_script('imagine-front-js', 'imagineajax', array('ajaxurl' => admin_url('admin-ajax.php')));
	

	add_action('wp_ajax_nopriv_imagine-ajaxsubmit', 'imagine_ajaxsubmit');
	add_action('wp_ajax_imagine-ajaxsubmit', 'imagine_ajaxsubmit');
	
}

include 'imagine-ajax.php';
include 'modules/shortcode.php';
?>