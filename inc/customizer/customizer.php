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
	 * Require files for the Customizer
	 */
	private function require_controls() {

		require_once dirname( __FILE__ ) . '/class-largo-wp-customize-textarea-control.php';

	}

	/**
	 * Register our customizer options
	 */
	public function action_customize_register( $wp_customize ) {

		$this->require_controls();

		// Static front pages aren't commonly used
		$wp_customize->remove_section( 'static_front_page' );

		// Register the settings
		$settings = array(
			'largo[site_blurb]'          => 'option',
			);
		foreach( $settings as $setting => $type ) {
			$wp_customize->add_setting( $setting, array(
				'type'      => $type,
			) );
		}

		// Site description
		$wp_customize->add_control( new Largo_WP_Customize_Textarea_Control( $wp_customize, 'largo_site_description', array(
			'label'      => __( 'Site Description', 'largo' ),
			'section'    => 'title_tagline',
			'settings'   => 'largo[site_blurb]',
		) ) );


		// Because the Customizer doesn't easily support custom callbacks, let's add our own
		foreach( array_keys( $settings ) as $setting ) {
			add_filter( 'customize_value_' . $setting, array( $this, 'filter_customize_value' ) );
		}

		foreach( array_values( $settings ) as $type ) {
			add_action( 'customize_update_' . $type, array( $this, 'action_customize_update' ) );
			add_action( 'customize_preview_' . $type, array( $this, 'action_customize_preview' ) );
		}

	}

	/**
	 * Filter customizer values to use our existing settings framework
	 *
	 * @param mixed $default Default registered value for the setting
	 * @return mixed
	 */
	public function filter_customize_value( $default ) {

		$setting = str_replace( 'customize_value_', '', current_filter() );

		$settings_to_options = array(
			'largo_site_description'    => 'site_blurb',
			);

		if ( ! empty( $settings_to_options[ $setting ] ) ) {
			return of_get_option( $settings_to_options[ $setting ] );
		} else {
			return $default;
		}

	}

	/**
	 * Handle an update to one of our Customizer settings
	 *
	 * @param mixed $value
	 */
	public function action_customize_update( $value ) {

		// current_filter(), although semantically incorrect, offers backwards compat to 2.5
		$current_action = current_filter();
		$option = str_replace( 'customize_update_', '', $current_action );

		if ( 0 === strpos( $current_action, 'customize_update_of_' ) ) {
			$option = str_replace( 'customize_update_of_', '', $current_action );
			of_set_option( $option, $value );
		}

	}

	/**
	 * Handle the preview of one of our setting values
	 */
	public function action_customize_preview() {
		// @todo
		$setting = str_replace( 'customizer_preview_', '', current_filter() );
	}

}
