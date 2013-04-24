<?php


/**
 * Creates the admin UI page
 */
class FeedInput_AdminPage {
	var $feed_urls;

	function __construct() {
		add_action( 'admin_menu', array(&$this, 'admin_menu') );
		add_action( 'admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts') );
		add_action( 'init', array(&$this, 'register_feedset') );
		

	}


	/**
	 * Add our admin page
	 */
	function admin_menu() {
		$this->hook_suffix = add_options_page('Syndicated Sources','Syndicated Sources','manage_options','syndicated_sources', array($this, 'page_content') );
		add_action( 'load-'.$this->hook_suffix, array(&$this, 'process') );
	}


	/**
	 * Output the content of the page
	 */
	function page_content() {
		$feed_urls = $this->get_feed_urls();

		?>
		<div class="wrap">
			<h2><?php _e('Syndicated Sources', 'feedinput'); ?></h2>

			<form method="POST" action="options-general.php?page=syndicated_sources">
				<input type="hidden" name="feedinput" value="1" />
				<label for="feed_urls"><?php _e('Feed URLs', 'feedinput'); ?></label>
				<p><?php _e('Enter each feed URL on a separate line.', 'feedinput'); ?></p>
				<textarea id="feed_urls" name="feed_urls" style="width: 100%" rows="10"><?php echo implode( "\n", $feed_urls ); ?></textarea>

				<div>
					<button type="submit" class="button-primary"><?php _e('Save'); ?></button>
				</div>
			</form>
		</div>
		<?php
	}


	/**
	 * Add our JS and CSS for the admin page
	 */
	function admin_enqueue_scripts( $hook_suffix ) {
		if ( $hook_suffix != $this->hook_suffix ) {
			return;
		}

	}


	/**
	 * Attempts to process the form submission
	 */
	function process() {
		$current_screen = get_current_screen();

		if ( $current_screen->id == 'settings_page_syndicated_sources' && filter_input(INPUT_POST, 'feedinput', FILTER_VALIDATE_BOOLEAN) ) {
			$old_feed_urls = $this->get_feed_urls();

			// Get input
			$feed_urls_raw = filter_input( INPUT_POST, 'feed_urls', FILTER_SANITIZE_STRING );
			$urls = explode( "\n", $feed_urls_raw );
			$feed_urls = array();
			foreach ( $urls as $url ) {
				$url = filter_var( $url, FILTER_SANITIZE_URL );

				if ( $url != false ) {
					$feed_urls[] = $url;
				}
			}

			// Save the feeds
			$this->set_feed_urls( $feed_urls );
			$this->register_feedset();

			// Check if there are new feeds added, if not then force an initial update
			$new_feed_urls = array_diff( $feed_urls, $old_feed_urls );
			if ( count( $new_feed_urls ) > 0 ) {
				feedinput_force_update_feed( 'feedinput_admin' );
			}
		}
	}


	/**
	 * Init hook
	 */
	function register_feedset() {
		$feed_urls = $this->get_feed_urls();

		if ( count( $feed_urls ) > 0 ) {
			feedinput_register_feed( 'feedinput_admin', $feed_urls );
		}
	}


	function get_feed_urls() {
		if ( !is_array( $this->feed_urls ) ) {
			$this->feed_urls = get_option( 'feedinput_feeds', array() );
		}
		return $this->feed_urls;
	}


	function set_feed_urls( $feed_urls ) {
		$this->feed_urls = $feed_urls;
		update_option( 'feedinput_feeds', $feed_urls );
	}
}

// Kickoff
new FeedInput_AdminPage;