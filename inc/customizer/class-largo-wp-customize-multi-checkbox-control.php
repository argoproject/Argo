<?php

class Largo_WP_Customize_Multi_Checkbox_Control extends WP_Customize_Control {

	public $type = 'multi_checkbox';

	public function render_content() {

		foreach( $this->choices as $value => $label ) : ?>
		<label>
			<input type="checkbox" value="<?php echo esc_attr( $this->settings['default']->id . '[' . $value . ']' ); ?>" <?php $this->link( $value ); checked( $this->value() ); ?> />
			<?php echo esc_html( $label ); ?>
		</label><br />
		<?php endforeach;
	}

}