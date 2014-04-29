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

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) ) define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
load_plugin_textdomain('clean-contact', constant('WP_PLUGIN_DIR'), basename(dirname(__FILE__)));

//Shortcode [clean-contact parameter="value"]
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
	$comment['blog']       = get_option('home');
	$comment['comment_author_email']  = $email;
	$comment['comment_author']  = clean_contact_scrub($name);
	$comment['comment_content']  = clean_contact_scrub($body);
	$query_string = '';
	foreach ( $comment as $key => $data )
		$query_string .= $key . '=' . urlencode( stripslashes($data) ) . '&';

	$response = akismet_http_post($query_string, $akismet_api_host, '/1.1/comment-check', $akismet_api_port);
	if ( 'true' == $response[1] ) {
		return true;
	}
}

// {{{ clean_contact_valid_email()
/*
 * Validate email via regex
 * @param string
 * @return bool
 */
function clean_contact_valid_email($str) {
	$pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
	return preg_match($pattern,$str);
}

// {{{ clean_contact_send()
/*
 * Deliver e-mail via SMTP
 * @param array
 * @return bool
*/
function clean_contact_send($atts) {
	$to_email = ($atts['email']) ? $atts['email'] :  get_option('clean_contact_email');
	$to_email = clean_contact_scrub($to_email);

	$bcc = ($atts['bcc']) ? $atts['bcc'] :  get_option('clean_contact_bcc');
	$bcc = clean_contact_scrub($bbc);

	$cc = ($atts['cc']) ? $atts['cc'] :  get_option('clean_contact_cc');
	$cc = clean_contact_scrub($cc);

	$body = clean_contact_scrub($_POST['clean_contact_body']);

	$from_name = clean_contact_scrub(($_POST['clean_contact_from_name']));
	$from_email = clean_contact_scrub($_POST['clean_contact_from_email']);
	$from = ($from_name) ? "{$from_name} <$from_email>" : $from_email;


	if(!clean_contact_valid_email($from_email) or !clean_contact_valid_email($to_email)  ) return false;

	$headers = array();

	if($from_email_set = get_option('clean_contact_from_email')) {
		if(clean_contact_valid_email($from_email_set)) {
			$from_email = $from_email_set;
			$from = $from_email_set;
			$headers[] = "Reply-To: {$from}";
		}
	}

	$headers[] = "From: {$from}";

	$to =   '"' . addslashes(get_bloginfo('name'))  . '" ' . "<$to_email>";

	if(clean_contact_valid_email($cc)) $headers[] = "CC: {$cc}";
	if(clean_contact_valid_email($bcc)) $headers[] = "BCC: {$bcc}";

	$headers[] = 'X-Originating-IP: ' . $_SERVER['REMOTE_ADDR'];
	$headers[] = 'X-Mailer: WP Clean-Contact (' . $_SERVER['SERVER_NAME'] . ')';

	$headers[]  = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/plain; charset=' . get_bloginfo('charset');

	if(get_option('clean_contact_akismet') == 1 and clean_contact_akismet($body,$subject,$from_email,$from_name)) {
		return false;
	} else {
		$prefix = ($atts['prefix']) ? $atts['prefix'] :  get_option('clean_contact_prefix');
		$subject = clean_contact_scrub($_POST['clean_contact_subject']);
		if($prefix) {
			$subject = "[{$prefix}] {$subject}";
		}
		ini_set('mail.add_x_header','Off');
		mail($to, $subject, $body, implode("\n",$headers));
		return true;
	}
}

// {{{ clean_contact_scrub()
/*
 * Display e-mail from
 * @param array
 * @return string
 */
function clean_contact_scrub($str) {
	return stripslashes(trim(strip_tags($str)));
}

function clean_contact_strings() {
	$strings = array();
	$strings['str_clean_contact_send'] = __('Send');
	$strings['str_clean_contact_error'] = __('Error');
	$strings['str_clean_contact_name'] = __('Name');
	$strings['str_clean_contact_email'] = __('Your e-mail address');
	$strings['str_clean_contact_subject'] = __('Subject');
	$strings['str_clean_contact_body'] = __('Message');

	foreach($strings as $id => $str) {
		$html .= '<input type="hidden" id="' . $id . '" value="' . $str . '" />';
	}

	return $html;
}

function clean_contact($atts) {
	if(!is_page() or is_single()) return;
	if(!get_option('clean_contact_nocss')) {
		$html = clean_contact_css();
	}
	$html .= clean_contact_strings();
	$html .= '<a name="clean_contact"></a><script src="' .  WP_PLUGIN_URL . '/largo-clean-contact/fieldset.js" type="text/javascript"></script>';
	$thanks= (!empty($atts['thanks'])) ? $atts['thanks'] : get_option('clean_contact_thanks');
	$thanks_url= (!empty($atts['thanks_url'])) ? $atts['thanks_url'] : get_option('clean_contact_thanks_url');
	if(empty($thanks)) $thanks = __('Thank you. Message sent!');
	if($atts['sent']) {
		if($thanks_url) {
			$html .= "<script>clean_contact_url('{$thanks_url}');</script>" . "\n";
		} else {
		$html .= '<div class="CleanContact_msg ok">'  . $thanks . '</div>';
		}
	} elseif($atts['fail']) {
		$html .= '<p class="CleanContact_msg err">' . __('Sorry, unable to deliver this message') . '</p>';
	} else {
		$html .= '<script type="text/javascript">clean_contact_form();</script>' . "\n";
	}
	$html .= '<noscript><p class="CleanContact_msg err">' . __('Sorry, due to anti-spam measures, this contact form requires that javascript be enabled on your browser.') . '</p></noscript>';
	return $html;
}

// {{{ clean_contact_conf()
/*
 * Add to admin
 * @param void
 * @return void
*/
function clean_contact_conf() {
	clean_contact_setup();
	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('Clean-Contact'), __('Clean-Contact'), 'manage_options', 'clean_contact', 'clean_contact_conf_page');
	}
    add_filter('plugin_row_meta', 'clean_contact_plugin_meta', 10, 2 );

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
	$html .= '<style  type="text/css" media="screen">';
	$html .= file_get_contents(dirname(__FILE__).'/style.css');
	$html .= '</style>';
	return $html;
}

// {{{ clean_contact_setup()
/*
 * Include css
 * @param void
 * @return void
*/
function clean_contact_setup() {
	if($_SERVER['REQUEST_METHOD'] == 'POST') return;
	if(!get_option('clean_contact_email')) {
		update_option('clean_contact_email',get_bloginfo('admin_email'));
		update_option('clean_contact_prefix','clean-contact');
		update_option('clean_contact_thanks',__('Thank you.  Message sent!'));
		if(!function_exists('akismet_http_post')) {
			update_option('clean_contact_akismet','-1');
		} elseif(get_option('wordpress_api_key')) {
			update_option('clean_contact_akismet','1');
		}
	}
}
function clean_contact_plugin_meta($links, $file) {

    // create link
    if (basename($file,'.php') == 'clean_contact') {
        return array_merge(
            $links,
            array( '<a href="plugins.php?page=clean_contact">' . __('Settings') . '</a>')
        );
    }
    return $links;
}

add_shortcode('clean-contact', 'clean_contact_func');
add_action('admin_menu', 'clean_contact_conf');
?>
