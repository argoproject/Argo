<?php
define( 'HALF_WIDTH', 300 );
/*
 * TINYMCE CUSTOMIZATIONS
 */
 
 /**
 * Constructs the appropriate URL for theme-based script files.
 *
 * @param $filename relative filename of the file being requested
 * @return url|null
 */
function argo_get_theme_script_url( $filename ) {
    return argo_get_theme_resource_url( 'js', $filename );
}

/**
 * Constructs the appropriate URL for theme-based style files.
 *
 * @param $filename relative filename of the file being requested
 * @return url|null
 */
function argo_get_theme_style_url( $filename ) {
    return argo_get_theme_resource_url( 'css', $filename );
}

/**
 * Constructs the appropriate URL for theme-based resources. 
 *
 * @todo make this look in the child theme as well, like get_template_part()
 * @param $type the type of resource to find: js, css, etc. 
 * @param $filename relative filename of the file being requested
 * @return url|null
 */
function argo_get_theme_resource_url( $type, $filename ) {
    return trailingslashit( get_bloginfo( 'template_url' ) ) . 
        trailingslashit( $type ) . $filename;
}

function add_argo_mce_plugin( $plugin_array ) {
    // XXX: gross path assumption
    $plugin_array[ 'modulize' ] = argo_get_theme_script_url( 'tinymce/plugins/argo/editor_plugin.js' );
    return $plugin_array;
}

function register_argo_mce_buttons( $buttons ) {
    array_push( $buttons, "|", "modulize" );
    return $buttons;
}

function argo_add_mce_buttons() {
    if ( get_user_option( 'rich_editing' ) == true ) {
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

    $wrapped = sprintf( '<aside class="module %s %s %s">%s</aside>',
        $type, $align, $width, $content );
    return $wrapped;
}
add_shortcode( 'module', 'module_shortcode' );
/*
 * END SHORTCODES
 */

?>
