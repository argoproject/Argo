(function() {
	if(wp.media.view.Settings.Gallery){
		wp.media.view.Settings.Gallery = wp.media.view.Settings.extend({
			className: "collection-settings gallery-settings",
			template: wp.media.template("gallery-settings"),
			render:	function() {
				wp.media.View.prototype.render.apply( this, arguments );
				// Append an option for 0 (zero) columns if not already present
				var $s = this.$('select.columns');
				if(!$s.find('option[value="0"]').length){
					$s.prepend('<option value="0">0</option>');
				}
				// Set default to the new 0 column
				$s.val(0);
				// Remove too-large column values
				$s.find('option')[9].remove();
				$s.find('option')[8].remove();
				$s.find('option')[7].remove();
				$s.find('option')[6].remove();
				$s.find('option')[5].remove();
				// Select the correct values.
				_( this.model.attributes ).chain().keys().each( this.update, this );
				return this;
			}
		});
	}
})(jQuery);