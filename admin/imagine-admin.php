<?php 

global $wpdb;


echo '<p class="imagine-notice">';
echo 'This plugin is still in development. </br>If you have any questions/ suggestions/ please consider to notify me through the plugin support forum located <a href="https://wordpress.org/support/plugin/imagine" target="blank">here</a>. Any feedback is welcome too.';
echo '</p>';

echo '<img style="float:left" src=" ' . content_url() . '/plugins/imagine/img/imagine-logo-200px.png" >';

echo '<div class="par">';
echo '<h2>Imagine Dashboard</h2>';

$galleries = $wpdb->get_results("SELECT * FROM wp_imagine_gallery");
$images = $wpdb->get_results("SELECT * FROM wp_imagine_img");
$templates = $wpdb->get_results("SELECT * FROM wp_imagine_templates");

echo '<p>You have '.count($galleries).' galleries online containing '.count($images).' images</p>';
echo '<p>You also have '.count($templates).' custom templates. Cool!</p>';
echo '</div>';
?>
