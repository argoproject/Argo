=== Clean-Contact ===

Contributors: checkfront
Stable tag: trunk
Tags: contact, e-mail, spam filter, akismet, shortcode
Requires at least: 2.5
Tested up to: 3.0

A Clean, no hassle contact form plugin for Wordpress, with advanced Spam bot protection that doesn't require Captcha.

== Description ==

Clean-contact hides itself from spam-bots and optionally will filter messages using Akismet.  Capctha and skill testing questions *not required*.

The plugin has minimal configuration and can be used out of the box. It is intended to be a simple contact form that is familiar to your users, and doesn't require them to jump through hoops to send you an message.

= Features = 

 * A clean and simple contact form that users understand.
 * Shortcode support.
 * Spam protection including Akismet filtering.
 * No clunky Capctha.
 * Supports multiple recipients and configurable subject and prefix, CC & BCC.
 * XHTML compliant.
 * No external javascript libraries required.
 * Multi-language.
 * Supports custom styling using CSS.

This plugin is licensed under GPL v2.0 and is made available by the Checkfront [Online Reservation System](http://www.checkfront.com/tour/).

Clean-contact can be translated using the provided pot file.  If you would like to contribute a translation file, please let me know (use the contact address in the translate.txt file).

== Installation ==

  * Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.

  * Activate the the plugin through the 'Plugins' menu in WordPress

  * If you wish to use Akismet filtering, make sure the Akismet plugin that comes with Wordpress is activated and configured with your Wordpress API Key.

== Configuration ==
 
  * Configure the the plugin through the 'Plugins' / 'Clean-Contact' menu in WordPress 
  * Invoked on any page or post via the shortcode: `[clean-contact]`
  * You can override the settings in the plugin configuration, eg: `[clean-contact: prefix="help" email="test@example.com" thanks="Cheers!" bcc="admin@example.com" thanks_url="/thankyou.html"]`


== Frequently Asked Questions ==

= Can I add more options to the e-mail form =

For now, keeping things simple, NO.  There are lots of good plugins that allow you to do this.  Clean-Contact was created to mimic what the user is use to when sending an email.  May find a clean way to do this later.


== Screenshots ==

1. Composing a message
2. Message sent
3. Admin configuration
