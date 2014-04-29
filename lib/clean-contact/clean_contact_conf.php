<?php
if($_POST['clean_contact_settings']) {
	update_option('clean_contact_email',$_POST['clean_contact_email']);
	update_option('clean_contact_thanks',$_POST['clean_contact_thanks']);
	update_option('clean_contact_prefix',$_POST['clean_contact_prefix']);
	update_option('clean_contact_cc',$_POST['clean_contact_cc']);
	update_option('clean_contact_bcc',$_POST['clean_contact_bcc']);
	update_option('clean_contact_akismet',intval($_POST['clean_contact_akismet']));
	update_option('clean_contact_thanks_url',$_POST['clean_contact_thanks_url']);
	update_option('clean_contact_nocss',$_POST['clean_contact_nocss']);
	update_option('clean_contact_from_email',$_POST['clean_contact_from_email']);
}
?>
<div class="wrap">
<h2>Clean-Contact Settings</h2>
<?php 
if($_POST['clean_contact_settings']){
?>
<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p><strong><?php echo __('Settings saved')?>.</strong></p></div>
<?php }?>
<form method="post">
<input type="hidden" name="clean_contact_settings" value="1" />
<table class="form-table">
<tbody>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_email"><?php echo __('To E-mail address')?>:</label></th>
		<td><input name="clean_contact_email" id="clean_contact_email" value="<?php echo get_option('clean_contact_email')?>" class="regular-text" type="text" /> 
	</tr>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_cc"><?php echo __('CC E-mail address')?>:</label></th>
		<td><input name="clean_contact_cc" id="clean_contact_cc" value="<?php echo get_option('clean_contact_cc')?>" class="regular-text" type="text" />
	</tr>
	<tr valign="top">
	<th scope="row"><label for="mailserver_url"><?php echo __('BCC E-mail address')?>:</label></th>
		<td><input name="clean_contact_bcc" id="clean_contact_bcc" value="<?php echo get_option('clean_contact_bcc')?>" class="regular-text" type="text" /> 
	</tr>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_prefix"><?php echo __('Subject prefix')?>:</label></th>
		<td><input name="clean_contact_prefix" id="clean_contact_prefix" value="<?php echo get_option('clean_contact_prefix')?>" class="regular-text" type="text" /> 
	</tr>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_thanks"><?php echo __('Thank you message')?>:</label></th>
		<td><input name="clean_contact_thanks" id="clean_contact_thanks" value="<?php echo get_option('clean_contact_thanks')?>" class="regular-text" type="text" /> 
	</tr>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_thanks_url"><?php echo __('Thank you url')?>:</label></th>
		<td><input name="clean_contact_thanks_url" id="clean_contact_thanks_url" value="<?php echo get_option('clean_contact_thanks_url')?>" class="regular-text" type="text" /><br /><span class="setting-description">Optional url to redirect to after send (overrides thank you message).</span> </td>
	</tr>
	<tr valign="top">
	<th scope="row"><label for="clean_contact_from_email"><?php echo __('From address')?>:</label></th>
		<td><input name="clean_contact_from_email" id="clean_contact_from_email" value="<?php echo get_option('clean_contact_from_email')?>" class="regular-text" type="text" /><br /><span class="setting-description">Optional from address to use when sending email.  Unset, the users e-mail address will be used.</span> </td>
	</tr>
	<tr valign="top">
	<td colspan="2"><input type="checkbox" id="clean_contact_akismet" name="clean_contact_akismet" value="1" <?php if (get_option('clean_contact_akismet') == 1)  print ' checked ';?> /><strong> <?php echo __('Filter messages for SPAM through the')?> <a href="?page=akismet-key-config">Akismet plugin</a></strong></td>
	</tr>
	<tr valign="top">
	<td colspan="2"><input type="checkbox" id="clean_contact_nocss" name="clean_contact_nocss" value="1" <?php if (get_option('clean_contact_nocss') == 1)  print ' checked ';?> /><strong> <?php echo __("Don't use default CSS")?></td>
	</tr>
</tbody>
</table>
<p class="submit"> <input name="Submit" class="button-primary" value="Save Settings" type="submit"></p>
<p><?php echo __('Invoke the Clean Contact e-mail form on and page or post with the shortcode:')?></a> <code><strong>[clean-contact]</strong></code></p>
<p><?php echo __('You can override all or any of the settings above in the shortcode')?></p>
<code style="font-size: 1.1em"><strong>[clean-contact</strong> <strong>email="</strong><?php echo get_option('clean_contact_email')?><strong>"</strong> <strong>prefix="</strong>contact<strong>"</strong> <strong>bcc=""</strong> <strong>subject=</strong>"<?php echo __('Greetings')?>" <strong>thanks_url=</strong>"<?php echo get_bloginfo('url')?><strong>"]</strong></code>
<p><a href="http://www.checkfront.com/extras/wp-clean-contact"><?php echo __('More information on this plugin and feedback')?></a>.</p>
</form>
</div>
