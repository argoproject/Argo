<?php

/**
 * The Largo_Customizer gives a visually responsive setup interface.
 */
class Largo_Customizer {

	private static $instance;

	/**
	 * Get the instance of the Largo Customizer
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new Largo_Customizer;
			self::$instance->load();
		}

		return self::$instance;
	}

	public function __construct() {
		/** Nothing to do **/
	}

	/**
	 * Load the Customizer
	 */
	private function load() {

		$this->setup_actions();

	}

	/**
	 * Set up actions for the Customizer
	 */
	private function setup_actions() {

		add_action( 'customize_register', array( $this, 'action_customize_register' ) );

	}

	/**
	 * Register our customizer options
	 */
	public function action_customize_register( $wp_customize ) {

	}

}
