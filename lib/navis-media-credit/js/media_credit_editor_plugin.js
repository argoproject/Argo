/*
 * Monkey-patching the shortcode rendering functions from the built-in
 * wpEditImage tinymce plugin, located here:
 */
(function() {
    tinymce.create('tinymce.plugins.argo_wpeditimage', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            tinymce.plugins.wpEditImage.prototype._do_shcode = function(co) {
                return co.replace(/\[(?:wp_)?caption([^\]]+)\]([\s\S]+?)\[\/(?:wp_)?caption\][\s\u00a0]*/g, function(a,b,c){
                        // b is caption args, c is html
                        var id, cls, w, cap, div_cls, html;

                        b = b.replace(/\\'|\\&#39;|\\&#039;/g, '&#39;').replace(/\\"|\\&quot;/g, '&quot;');
                        c = c.replace(/\\&#39;|\\&#039;/g, '&#39;').replace(/\\&quot;/g, '&quot;');
                        id = b.match(/id=['"]([^'"]+)/i);
                        cls = b.match(/align=['"]([^'"]+)/i);
                        w = b.match(/width=['"]([0-9]+)/);
                        cap = b.match(/caption=['"]([^'"]+)/i);
                        cred = b.match(/credit=['"]([^'"]+)/i);
                        id = ( id && id[1] ) ? id[1] : '';
                        cls = ( cls && cls[1] ) ? cls[1] : 'alignnone';            w = ( w && w[1] ) ? w[1] : '';
                        cap = ( cap && cap[1] ) ? cap[1] : '';
                        cred = ( cred && cred[1] ) ? cred[1] : '';
                        //if ( ! w || ( ! cap && ! cred ) ) return c;

                        div_cls = (cls == 'aligncenter') ? 'mceTemp mceIEcenter' : 'mceTemp';
                        //return '<div class="'+div_cls+'" draggable><dl id="'+id+'" class="wp-caption '+cls+'" style="width: '+(10+parseInt(w)+)'px"><dt class="wp-caption-dt">'+c+'</dt><dd class="wp-caption-dd">'+cap+ '</dd><dd class="wp-caption-dd">'+cred +'</dd></dl></div>';
                        return '<div id="' + id + '" class="module image ' + cls + ' ' + div_cls + '">' + c + '<p class="wp-media-credit">' + cred + '</p><p class="wp-caption-text">' + cap + '</p></div>';
                });
            };

            tinymce.plugins.wpEditImage.prototype._get_shcode = function(co) {
                //return co.replace(/<div class="mceTemp[^"]*">\s*<dl([^>]+)>\s*<dt[^>]+>([\s\S]+?)<\/dt>\s*<dd[^>]+>(.+?)<\/dd>\s*<dd[^>]+>(.+?)<\/dd>\s*<\/dl>\s*<\/div>\s*/gi, function(a,b,c,cap,cred){
                return co.replace(/(?:\s*<p>\s*(?:.nbsp.)?\s*<\/p>\s*)*<div([^>]+)>\s*(<(?:a|img).*?>)\s*<p class="wp-media-credit">(.*?)<\/p>\s*<p class="wp-caption-text">(.*?)<\/p><\/div>(?:\s*<p>\s*(?:.nbsp.)?\s*<\/p>\s*)*/gi, function(a,b,c,cred,cap) {
                        var id, cls, w;

                        id = b.match(/id=['"]([^'"]+)/i);
                        cls = b.match(/class=['"]([^'"]+)/i);
                        w = c.match(/width=['"]([0-9]+)/);

                        id = ( id && id[1] ) ? id[1] : '';
                        cls = ( cls && cls[1] ) ? cls[1] : 'alignright';
                        w = ( w && w[1] ) ? w[1] : '';

                        if ( ! w || ( ! cap && ! cred ) ) return c;
                        cls = cls.match(/left|right|center/) || 'alignright';
                        cap = cap.replace(/<\S[^<>]*>/gi, '').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                        cred = cred.replace(/<\S[^<>]*>/gi, '').replace(/'/g, '&#39;').replace(/"/g, '&quot;');

                        return '[caption id="'+id+'" align="'+cls+'" width="'+w+'" caption="'+cap+'" credit="'+ cred + '"]'+c+'[/caption]';
                });
            };

		},
		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Argo Override wpEditImage',
				author : 'Argo',
				authorurl : 'http://argosit.es',
				infourl : '',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('argo_wpeditimage', tinymce.plugins.argo_wpeditimage);
})();
