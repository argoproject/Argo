<?php
/* 
 * ARGO THEME SETTINGS
 */
function argo_add_options_page() {
    add_theme_page( 'Argo', 'Argo Theme Options', 'manage_options',
                      'argo', 'argo_options_page' );
}
add_action( 'admin_menu', 'argo_add_options_page' );

function argo_options_page() {
?>

    <div>
        <form action="options.php" method="post">

            <?php settings_fields( 'argo' ); ?>
            <?php do_settings_sections( 'argo' ); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
    

<?php
}

function argo_settings_init() {

    add_settings_field( 'show_related_content', 'Show related posts on post pages?',
        'argo_show_related_content_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'show_related_content' );
    
    add_settings_section( 'argo_settings', 'Argo theme options', 'argo_settings_section_callback', 'argo' );

    add_settings_field( 'copyright_msg', 'Copyright and credit', 
        'argo_copyright_msg_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'copyright_msg' );
    
    add_settings_field( 'site_blurb', 'Short Site Blurb',
        'argo_site_blurb_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'site_blurb' );    
    
    add_settings_field( 'facebook_link', 'Link to Facebook Profile', 
        'argo_facebook_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'facebook_link' );
    
    add_settings_field( 'twitter_link', 'Link to Twitter Page', 
        'argo_twitter_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'twitter_link' );

    add_settings_field( 'youtube_link', 'Link to YouTube Page', 
        'argo_youtube_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'youtube_link' );

    add_settings_field( 'flickr_link', 'Link to Flickr Page', 
        'argo_flickr_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'flickr_link' );
    
    add_settings_field( 'gplus_link', 'Link to Google Plus Page', 
        'argo_gplus_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'gplus_link' );

    add_settings_field( 'podcast_link', 'Link to Podcast Feed',
        'argo_podcast_link_callback', 'argo', 'argo_settings' );
    register_setting( 'argo', 'podcast_link' );
    
}
add_action( 'admin_init', 'argo_settings_init' );

function argo_show_related_content_callback() {
    $option = get_option('show_related_content', 1); ?>
    <input type="checkbox" value="1" name="show_related_content" <?php checked($option, 1); ?> />
    <?php
}

function argo_settings_section_callback() {
    echo '<p>The following fields are <b>optional</b>, but you may use them to add additional information about your site. </p><p><i>Note: To change social media settings for a user, view their edit profile screen.</p>';
}

function argo_copyright_msg_callback() {
    $option = get_option( 'copyright_msg' );
    echo "<textarea name='copyright_msg'>$option</textarea><br> <i>(appears in the footer)</i>";
}

function argo_site_blurb_callback() {
    $option = get_option( 'site_blurb' );
    echo "<textarea name='site_blurb'>$option</textarea><br> <i>(appears in a widget)</i>";
}

function argo_facebook_link_callback() {
    $option = get_option( 'facebook_link' );
    echo "<input type='text' value='$option' name='facebook_link' /><br> <i>(appears in the header and footer)</i>"; 
}

function argo_twitter_link_callback() {
    $option = get_option( 'twitter_link' );
    echo "<input type='text' value='$option' name='twitter_link' /><br> <i>(appears in the header and footer)</i>"; 
}

function argo_youtube_link_callback() {
    $option = get_option( 'youtube_link' );
    echo "<input type='text' value='$option' name='youtube_link' /><br> <i>(appears in the header and footer)</i>"; 
}

function argo_flickr_link_callback() {
    $option = get_option( 'flickr_link' );
    echo "<input type='text' value='$option' name='flickr_link' /><br> <i>(appears in the header and footer)</i>"; 
}

function argo_gplus_link_callback() {
    $option = get_option( 'gplus_link' );
    echo "<input type='text' value='$option' name='gplus_link' /><br> <i>(appears in the header and footer)</i>"; 
}

function argo_podcast_link_callback() {
    $option = get_option( 'podcast_link' );
    echo "<input type='text' value='$option' name='podcast_link' /><br> <i>(appears in the header and footer)</i>";
}

function argo_copyright_message() {
    $msg = get_option( 'copyright_msg' );
    $base = ( strlen( $msg ) ) ? $msg : 'Copyright %s';
    printf( $base, date( 'Y' ) );
}
?>