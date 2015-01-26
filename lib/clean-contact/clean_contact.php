<?php
/*
Plugin Name: Clean-Contact
Plugin URI: http://www.checkfront.com/extras/wp-clean-contact
Description:  No hassle contact form plugin with advanced Spam protection that doesn't require Captcha.
Version: 1.6
Author: Jason Morehouse
Author URI: http://www.checkfront.com/
*/

/* Copyright 2010 Jason Morehouse (email: jm@checkfront.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Shortcode [clean-contact parameter="value"]
add_shortcode( 'clean-contact', 'clean_contact_func' );
function clean_contact_func($atts, $content=null) {
	$atts=shortcode_atts(array(
		'fail' => '0',
		'sent' => '0',
		'email' => '',
		'prefix' => '',
		'cc' => '',
		'bcc' => '',
		'thanks' => '',
		'thanks_url' => '',
	), $atts);

	if(!empty($_POST['clean_contact_token'])) {
		if(clean_contact_send($atts)) {
			$atts['sent'] = 1;
		} else {
			$atts['fail'] = 1;
		}
	}
	return clean_contact($atts);
}

/**
 * Handle the updating of plugin settings
 */
function clean_contact_handle_settings() {

	if ( ! current_user_can( 'manage_options' )
		|| ! wp_verify_nonce( $_POST['nonce'], 'clean-contact' ) ) {
		wp_die( __( "You shouldn't be doing this.", 'largo' ) );
	}

	update_option( 'clean_contact_email', sanitize_email( $_POST['clean_contact_email'] ) );
	update_option( 'clean_contact_thanks', sanitize_text_field( $_POST['clean_contact_thanks'] ) );
	update_option( 'clean_contact_prefix', sanitize_text_field( $_POST['clean_contact_prefix'] ) );
	update_option( 'clean_contact_cc', implode( ', ', array_map( 'sanitize_email', explode( ',', $_POST['clean_contact_cc'] ) ) ) );
	update_option( 'clean_contact_bcc', implode( ', ', array_map( 'sanitize_email', explode( ',', $_POST['clean_contact_bcc'] ) ) ) );
	update_option( 'clean_contact_akismet', isset( $_POST['clean_contact_akismet'] ) ? 1 : 0 );
	update_option( 'clean_contact_thanks_url', esc_url_raw( $_POST['clean_contact_thanks_url'] ) );
	update_option( 'clean_contact_nocss', isset( $_POST['clean_contact_nocss'] ) ? 1 : 0 );
	update_option( 'clean_contact_from_email', sanitize_email( $_POST['clean_contact_from_email'] ) );
	update_option( 'clean_contact_router', stripslashes( $_POST['clean_contact_router'] ) );

	wp_safe_redirect( add_query_arg( 'message', 'updated', admin_url( 'options-general.php?page=clean-contact' ) ) );
	exit;

}

add_action( 'admin_post_clean_contact_settings', 'clean_contact_handle_settings' );


// {{{ clean_contact_akismet()
/*
 * Filter message through akismet
 * Requires the akismet plugin activated and configured
 * @param string $body
 * @param string $subject
 * @param string $email
 * @param string $name
 * @return bool
*/
function clean_contact_akismet($body,$subject,$email,$name) {
	if(!function_exists('akismet_http_post')) return true;
	global $akismet_api_host, $akismet_api_port;
	$comment['user_ip']    = preg_replace( '/[^0-9., ]/', '', $_SERVER['REMOTE_ADDR'] );
	$comment['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$comment['referrer']   = $_SERVER['HTTP_REFERER'];
	$comment['blog']       = home_url();
	$comment['comment_author_email']  = $email;
	$comment['comment_author']  = $name;
	$comment['comment_content']  = $body;
	$query_string = '';
	foreach ( $comment as $key => $data )
		$query_string .= $key . '=' . urlencode( stripslashes($data) ) . '&';

	$response = akismet_http_post($query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port);
	if ( 'true' == $response[1] ) {
		return true;
	}
}

// {{{ clean_contact_send()
/*
 * Deliver e-mail via SMTP
 * @param array
 * @return bool
*/
function clean_contact_send($atts) {
	$to_email = ! empty( $atts['email'] ) ? $atts['email'] :  cc_get_option('clean_contact_email');
	$to_email = sanitize_email( $to_email );

	//alter to_email if $_POST['clean_contact_router'] is present and matches
	$route_options = cc_get_option('clean_contact_router');
	if ( $route_options ) {
		$subject_options = array();
		$rows = preg_split( "/\r\n|\n|\r/", $route_options );
		foreach ( $rows as $row ) {
			list( $subject, $email ) = explode( '|', $row, 2 );
			$subject_options[ $subject ] = $email;
		}
	}
	if ( isset( $_POST['clean_contact_router'] ) && array_key_exists( stripslashes($_POST['clean_contact_router']), $subject_options) ) {
		$to_email = sanitize_email( $subject_options[ stripslashes($_POST['clean_contact_router']) ] );
	}

	$bcc = ! empty( $atts['bcc'] ) ? $atts['bcc'] :  cc_get_option('clean_contact_bcc');
	if ( ! empty( $bcc ) ) {
		$bcc = implode( ',', array_map( 'sanitize_email', explode( ',', $bcc ) ) );
	} else {
		$bcc = '';
	}

	$cc = ($atts['cc']) ? $atts['cc'] :  cc_get_option('clean_contact_cc');
	if ( ! empty( $cc ) ) {
		$cc = implode( ',', array_map( 'sanitize_email', explode( ',', $cc ) ) );
	} else {
		$cc = '';
	}

	$subject = sanitize_text_field( $_POST['clean_contact_subject'] );
	$prefix = ! empty( $atts['prefix'] ) ? $atts['prefix'] :  cc_get_option('clean_contact_prefix');
	if( $prefix ) {
		$subject = "[{$prefix}] {$subject}";
	}

	$body = stripslashes( wp_filter_nohtml_kses( $_POST['clean_contact_body'] ) );

	$from_name = sanitize_text_field( $_POST['clean_contact_from_name'] );
	$from_email = sanitize_email( $_POST['clean_contact_from_email'] );
	$from = ! empty( $from_name ) ? "{$from_name} <$from_email>" : $from_email;

	if ( ! is_email( $from_email ) || ! is_email( $to_email ) ) {
		return false;
	}

	$headers = array();

	if ( $from_email_set = cc_get_option('clean_contact_from_email') ) {
		if ( is_email( $from_email_set ) ) {
			$from_email = $from_email_set;
			$from = $from_email_set;
			$headers[] = "Reply-To: {$from}";
		}
	}

	$headers[] = "From: {$from}";

	$to =   '"' . addslashes(get_bloginfo('name'))  . '" ' . "<$to_email>";

	if ( ! empty( $cc ) ) {
		$headers[] = "CC: {$cc}";
	}
	if ( ! empty( $bcc ) ) {
		$headers[] = "BCC: {$bcc}";
	}

	$headers[] = 'X-Originating-IP: ' . sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
	$headers[] = 'X-Mailer: WP Clean-Contact (' . sanitize_text_field( $_SERVER['SERVER_NAME'] ) . ')';

	$headers[]  = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/plain; charset=' . get_bloginfo('charset');

	if ( cc_get_option('clean_contact_akismet') == 1 && clean_contact_akismet( $body, $subject, $from_email, $from_name ) ) {
		return false;
	} else {
		wp_mail( $to, $subject, $body, $headers );
		return true;
	}
}

function clean_contact_strings() {
	$strings = array();
	$strings['str_clean_contact_send'] = __( 'Send', 'largo' );
	$strings['str_clean_contact_error'] = __( 'Error', 'largo' );
	$strings['str_clean_contact_name'] = __( 'Name', 'largo' );
	$strings['str_clean_contact_email'] = __( 'Your e-mail address', 'largo' );
	$strings['str_clean_contact_subject'] = __( 'Subject', 'largo' );
	$strings['str_clean_contact_body'] = __( 'Message', 'largo' );

	//router options
	$options = cc_get_option( 'clean_contact_router' );
	if ( $options ) {
		$subject_options = array();
		$rows = preg_split( "/\r\n|\n|\r/", $options );
		foreach ( $rows as $row ) {
			list( $subject, $email ) = explode( '|', $row, 2 );
			$subject_options[] = $subject;
		}
		$strings['str_clean_contact_router'] = implode( '|', $subject_options );
	}

	$html = '';
	foreach( $strings as $id => $str ) {
		$html .= '<input type="hidden" id="' . esc_attr( $id ) . '" value="' . esc_attr( $str ) . '" />';
	}

	return $html;
}

function clean_contact( $atts ) {

	if ( is_archive() ) {
		return;
	}

	if ( ! cc_get_option( 'clean_contact_nocss' ) ) {
		$html = clean_contact_css();
	} else {
		$html = '';
	}

	$html .= clean_contact_strings();
	$html .= '<a name="clean_contact"></a><script src="' .  get_template_directory_uri() . '/lib/clean-contact/fieldset.js" type="text/javascript"></script>';
	$thanks = ! empty( $atts['thanks'] ) ? $atts['thanks'] : cc_get_option('clean_contact_thanks');
	$thanks_url= ! empty( $atts['thanks_url'] ) ? $atts['thanks_url'] : cc_get_option('clean_contact_thanks_url');
	if ( empty( $thanks ) ) {
		$thanks = __( 'Thank you. Message sent!', 'largo' );
	}

	if( $atts['sent'] ) {
		if ( $thanks_url ) {
			$html .= "<script>clean_contact_url('{$thanks_url}');</script>" . "\n";
		} else {
			$html .= '<div class="CleanContact_msg ok">'  . esc_html( $thanks ) . '</div>';
		}
	} else if( $atts['fail'] ) {
		$html .= '<p class="CleanContact_msg err">' . __( 'Sorry, unable to deliver this message', 'largo' ) . '</p>';
	} else {
		$html .= '<script type="text/javascript">clean_contact_form();</script>' . "\n";
	}
	$html .= '<noscript><p class="CleanContact_msg err">' . __('Sorry, due to anti-spam measures, this contact form requires that javascript be enabled on your browser.', 'largo' ) . '</p></noscript>';
	return $html;
}

// {{{ clean_contact_conf()
/*
 * Add to admin
 * @param void
 * @return void
*/
function clean_contact_conf() {

	add_theme_page( __( 'Clean Contact', 'largo' ), __( 'Clean Contact', 'largo' ), 'manage_options', 'clean-contact', 'clean_contact_conf_page' );

}

// {{{ clean_contact_conf_page()
/*
 * Display admin
 * @param void
 * @return void
*/
function clean_contact_conf_page() {
	include(dirname(__FILE__).'/clean_contact_conf.php');
}

// {{{ clean_contact_css()
/*
 * Include css
 * @param void
 * @return void
*/
function clean_contact_css() {
	global $wp_filesystem;

	if (empty($wp_filesystem)) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		WP_Filesystem();
	}

	$html = '<style  type="text/css" media="screen">';
	$html .= $wp_filesystem->get_contents(dirname(__FILE__).'/style.css');
	$html .= '</style>';
	return $html;
}

function cc_get_option( $option ) {

	$defaults = array(
		'clean_contact_email'    => get_bloginfo( 'admin_email' ),
		'clean_contact_prefix'   => 'clean-contact',
		'clean_contact_thanks'   => __( 'Thank you. Message sent!', 'largo' ),
		);

	if ( isset( $defaults[ $option ] ) ) {
		$default = $defaults[ $option ];
	} else {
		$default = '';
	}

	return get_option( $option, $default );
}

add_action( 'admin_menu', 'clean_contact_conf' );
