<?php 

global $wpdb;

echo '<p class="imagine-notice">';
echo __('If you have any questions/ suggestions/ please consider to notify me through the plugin support forum located', 'imagine-languages') . ' ' . '<a href="https://wordpress.org/support/plugin/imagine" target="blank">' . __('here', 'imagine-languages') . '</a>. '; 
echo __('Any feedback is welcome too.', 'imagine-languages');
echo '</p>';

echo '<img style="float:left" src=" ' . content_url() . '/plugins/imagine/img/imagine-logo-200px.png" >';

echo '<div class="par">';
echo '<h2>Imagine Dashboard</h2>';



$galleries = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."imagine_gallery");
$albums = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."imagine_albums");
$images = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."imagine_img");
$templates = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."imagine_templates");

echo '<p>' . __('You have', 'imagine-languages') . ' ' . count($albums) . ' ' . __('albums', 'imagine-languages') . '.</p>';
echo '<p>' . __('You have', 'imagine-languages') . ' ' . count($galleries) . ' ' . __('galleries online containing', 'imagine-languages') . ' ' . count($images) . ' ' . __('images', 'imagine-languages') . '.</p>';
echo '<p>' . __('You also have', 'imagine-languages') . ' ' . count($templates) . ' ' . __('custom templates. Cool!', 'imagine-languages') . '</p>';


echo '</div>';
?>
