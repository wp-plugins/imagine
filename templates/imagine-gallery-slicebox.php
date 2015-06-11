<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/modernizr.custom.46884.js'; ?>"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) . '../js/jquery.slicebox.js'; ?>"></script>

<?php

global $wpdb;

if (isset($_GET['imagine']['gallery'])) {
	$gallery = intval($_GET['imagine']['gallery']);
}
$imgs = $wpdb -> get_results("SELECT * FROM ".$wpdb->prefix."imagine_img WHERE galleryId = '$gallery'");
$gallery = $wpdb -> get_row("SELECT * FROM ".$wpdb->prefix."imagine_gallery WHERE galleryId = '$gallery'");
$galslug = $gallery -> gallerySlug;
echo '<ul class="sb-slider" id="sb-slider">';
foreach ($imgs as $img) {
	$imgid = $img -> imgId;
	$gid = $img -> galleryId;
	$filename = $img -> imgFilename;
    $imgdesc = $img->imgDesc;
    $imgtitle = $img->imgAltTitle;
    
    if ( !empty($imgtitle) ) {
        $title = $imgtitle;
    }else{
        $title = $filename;
    }
    
	$plugindir = wp_upload_dir();
	$pluginurl = $plugindir['baseurl'];
	$plugindir = $plugindir['basedir'];
    echo '<li>';
	echo '<img template="'.esc_attr($tslug).'" class="imagine-slicebox-thumbnail-wrap" src="' . $pluginurl . '/imagine/' . esc_attr($galslug) . '/' . esc_attr($filename) . '" gid="' . esc_attr($gid) . '" imgid="' . esc_attr($imgid) . '" layovertemp="' . esc_attr($layovertemplate) . '">';
    echo '<div class="sb-description">';
    echo '<h3>' . esc_html($title) . '</h3><p>' . esc_html($imgdesc) . '</p>';
    echo '</div>';
  echo '</li>';
}
echo '</ul>';
echo '<div id="shadow" class="shadow" style="background: transparent url('.plugin_dir_url(__FILE__).'images/shadow.png) no-repeat bottom center; background-size: 100% 100%;"></div>';
echo '<div id="nav-arrows" class="nav-arrows">';
echo '<a href="#" style="background: transparent url('.plugin_dir_url(__FILE__).'images/nav.png) no-repeat top right">Next</a>';
echo '<a href="#" style="background: transparent url('.plugin_dir_url(__FILE__).'images/nav.png) no-repeat top left">Previous</a>';
echo '</div>';
?>


<script>
    $(document).ready( function() {
       $(function() {
				
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' ).hide(),
						$shadow = $( '#shadow' ).hide(),
						slicebox = $( '#sb-slider' ).slicebox( {
							onReady : function() {

								$navArrows.show();
								$shadow.show();

							},
							orientation : 'v',
							cuboidsRandom : false,
                            cuboidsCount: 3,
                            easing : 'ease',
                            autoplay: true,
                            interval: 5000
						} ),
						
						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events
							$navArrows.children( ':first' ).on( 'click', function() {

								slicebox.next();
								return false;

							} );

							$navArrows.children( ':last' ).on( 'click', function() {
								
								slicebox.previous();
								return false;

							} );

						};

						return { init : init };

				})();

				Page.init();

			});
    });
</script>