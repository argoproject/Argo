<?php

class Largo_WP_Customize_Rich_Radio_Control extends WP_Customize_Control {

	public $type = 'rich_radio';

	public function render_content() {
		$name = '_customize-rich-radio-' . $this->id;

		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<ul class="customize-control-content customize-control-rich-radio">
		<?php
		foreach ( $this->choices as $value => $options ) :
			?>
			<li>
				<span class="customize-control-rich-radio-previous button">&larr;</span>
				<span class="customize-control-rich-radio-next button">&rarr;</span>
			<label>
				<div class="customize-control-rich-radio-text"><input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> /><strong><?php echo esc_html( $options['label'] ); ?></strong></div>
				<?php if ( ! empty( $options['img'] ) ) : ?>
				<img src="<?php echo esc_url( $options['img'] ); ?>" /><br />
				<?php endif; ?>
			</label>
			</li>
			<?php
		endforeach;
		?>
		</ul>
		<?php
	}

}
