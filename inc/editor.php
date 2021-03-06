<?php
/*
 * TINYMCE CUSTOMIZATIONS
 */

function add_argo_mce_plugin( $plugin_array ) {
    $plugin_array['modulize'] = get_template_directory_uri() . '/js/tinymce/plugins/argo/editor_plugin.js';
    return $plugin_array;
}

function register_argo_mce_buttons( $buttons ) {
    array_push( $buttons, '|', 'modulize' );
    return $buttons;
}

function argo_add_mce_buttons() {
    if ( get_user_option( 'rich_editing' ) == 'true' ) {
        add_filter( 'mce_external_plugins', 'add_argo_mce_plugin', 4 );
        add_filter( 'mce_buttons', 'register_argo_mce_buttons', 4 );
    }
}
add_action( 'init', 'argo_add_mce_buttons' );

/*
 * EDITOR MARKUP CUSTOMIZATIONS
 */

function module_shortcode( $atts, $content, $code ) {
    extract( shortcode_atts( array(
        'align' => 'left',
        'width' => 'half',
        'type' => 'aside',
    ), $atts ) );

    return sprintf( '<aside class="module %s %s %s">%s</aside>', $type, $align, $width, $content );
}
add_shortcode( 'module', 'module_shortcode' );

?>
