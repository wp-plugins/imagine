<?php

function imagine_shortcode( $atts ) {
    
    $attr = shortcode_atts( array(
        'type' => '',
        'id' => '',
        'template' => '',
        'layover' => ''
    ), $atts );
    
    if ( $attr['layover'] !== '') {
        $layover = 'layovertemp="' . $attr["layover"] . '" ';
    } else {
        $layover = '';
    }

    if ( $attr['template'] !== '') {
        $template = 'template="' . $attr["template"] . '" ';
    } else {
        $template = '';
    }
    
    if ( $attr['type'] == 'image' ) {
        $return_string = '<div class="imagine" type="' . $atts['type'] . '" iid="' . $attr['id'] . '" ' . $template . '>';
        return $return_string;
    }
    
    if ( $attr['type'] == 'gallery' ) {
        
        $return_string = '<div class="imagine" type="' . $atts['type'] . '" gid="' . $attr['id'] . '" ' . $template . $layover . '>';
        return $return_string;
    }
    
    if ( $attr['type'] == 'album' ) {
        $return_string = '<div class="imagine" type="' . $atts['type'] . '" aid="' . $attr['id'] . '" ' . $template . '>';
        return $return_string;
    }
}
add_shortcode('imagine', 'imagine_shortcode');



?>