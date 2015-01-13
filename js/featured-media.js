/* LFM -- Largo Featured Media modal */
if (!window.console) {
    console = {
        log: function(){}
    };
}

var LFM = _.extend(LFM || {}, {
    Utils: {},
    Views: {},
    instances: {},
});

(function() {
    var $ = jQuery;

    var featuredMediaIdToView = {
        'embed-code': 'featuredEmbedCodeView',
        'video': 'featuredVideoView',
        'image': 'featuredImageView',
        //'photo-gallery': 'featuredPhotoGalleryView',
    };

    /* Models */
    var featuredMediaModel = Backbone.Model.extend({
        url: function() {
            if (this.get('id') == null)
                return 'largo_featured_media_read';
            else
                return 'largo_featured_media_save';
        },

        sync: function(method, model, options) {
            var data;

            if (method == 'create' || method == 'update')
                data =  model.toJSON();
            else
                data = {};

            // Make sure we tell the backend what post ID we're dealing with.
            data = _.extend(data, { id: LFM.Utils.getPostId() });

            var action = this.url();
            var success = options.success;
            var error = options.error;
            LFM.Utils.doAjax(action, data, success, error);
        }
    });

    /* Views for the modal and subviews for frames */
    var featuredMediaModal = wp.media.view.Modal.extend({
        className: 'featured-media-modal'
    });

    var featuredMediaFrame = wp.media.view.Frame.extend({
        events: {
            'click a.media-menu-item': 'setActive'
        },

        template: wp.media.template('featured-media-frame'),

        setActive: function(id_or_event) {
            var id,
                selector;

            if (typeof id_or_event.type !== 'undefined') {
                id = $(id_or_event.currentTarget).attr('id');
                selector = 'a#' + id;
            } else {
                id = id_or_event;
                selector = 'a#media-type-' + id;
            }

            var optionLink = this.$el.find(selector);
            optionLink.siblings().removeClass('active');
            optionLink.addClass('active');

            id = id.replace('media-type-', '');
            if (typeof LFM.instances[id] == 'undefined') {
                var view = featuredMediaIdToView[id];
                LFM.instances[id] = new LFM.Views[view]({
                    option: _.findWhere(LFM.options, { id: id })
                });
            }
            LFM.instances.frame.views.set('.media-frame-content', LFM.instances[id]);
            LFM.instances[id].render();
        }
    });

    var featuredMediaOptions = wp.Backbone.View.extend({
        template: wp.media.template('featured-media-options'),
    });

    /* Views for media types */
    var featuredMediaBaseView = wp.media.View.extend({
        id: function() {
            return 'media-editor-' + this.options.option.id;
        },

        showSpinner: function() {
            this.$el.find('.spinner').removeAttr('style');
        },

        hideSpinner: function() {
            this.$el.find('.spinner').css({ display: 'none' });
        }
    });

    LFM.Views.featuredEmbedCodeView = featuredMediaBaseView.extend({
        template: wp.media.template('featured-embed-code')
    });

    LFM.Views.featuredVideoView = featuredMediaBaseView.extend({
        events: {
            'paste input.url': 'fetchVideo',
            'keypress input.url': 'fetchVideo'
        },

        template: wp.media.template('featured-video'),

        fetchVideo: function(event) {
            var self = this;
                error = self.$el.find('p.error');

            error.html('');

            allowedKeyCodes = [86, 91, 17];
            allowedLastKeys = [null, 91, 17];

            if (!(event.keyCode in allowedKeyCodes) && !(this.lastKey in allowedLastKeys) || event.type == 'paste') {
                if (typeof this.kp !== 'undefined')
                    clearTimeout(this.kp);

                this.kp = setTimeout(function() {
                    url_pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                    address = $('input[name="url"]').val();

                    if (url_pattern.test(address))
                        self.fetchMeta(address);
                    else {
                        error.html('Error: please enter a valid URL.');
                    }
                }, 100);

            }
            this.kp = event.keyCode;
        },

        fetchMeta: function(address) {
            var self = this;
                success = function(data) {
                    var error = self.$el.find('p.error');
                    error.html('');
                    if (!data.embed)
                        error.html('Please enter a valid video URL.');
                    else
                        self.$el.find('textarea').html(data.embed);
                    self.hideSpinner();
                },
                failure = function() {
                    console.log('An error ocurred');
                };

            this.showSpinner();
            LFM.Utils.doAjax('largo_fetch_video_oembed', {
                action: 'largo_fetch_video_oembed',
                url: address
            }, success, failure);
        }
    });

    LFM.Views.featuredImageView = wp.media.view.Frame.extend({
        id: function() {
            return 'media-editor-' + this.options.option.id;
        },

        initialize: function() {
            wp.media.view.Frame.prototype.initialize.apply(this, arguments);

            // Initialize window-wide uploader.
            this.uploader = new wp.media.view.UploaderWindow({
                controller: this,
                uploader: {
                    dropzone: LFM.instances.modal.$el,
                    container: LFM.instances.modal.$el
                }
            });
            LFM.instances.modal.views.set('.media-frame-uploader', this.uploader);

            this.states.add([
                new wp.media.controller.Library()
            ]);
            this._state = 'library';
            return this;
        },

        render: function() {
            this.browseContent();
        },

        browseContent: function() {
            var self = this,
                state = this.state();

            // Browse our library of attachments.
            this.browser = new wp.media.view.AttachmentsBrowser({
                controller: this,
                collection: state.get('library'),
                selection: state.get('selection'),
                model: state,
                search: false,
                dragInfo: false,
                sidebar: false,
                id: 'media-editor-image'
            });

            if (!!this.browser.dfd) {
                this.browser.dfd.done(function() {
                    LFM.instances.frame.views.set('.media-frame-content', self.browser);
                    self.updateSelection();
                });
            } else {
                LFM.instances.frame.views.set('.media-frame-content', this.browser);
                this.updateSelection();
            }
        },

        updateSelection: function() {
            var selection = this.state().get('selection');

            if (typeof this.model !== 'undefined') {
                var attachmentId = this.model.get('attachment'),
                    attachment = wp.media.model.Attachment.get(attachmentId);

                attachment.fetch();
                selection.reset((attachment)? [attachment] : []);
            }
        },

        uploadContent: function() {
            var region = new wp.media.view.UploaderInline({
                controller: this
            });
            LFM.instances.frame.views.set('.media-frame-content', region);
        }
    });

    /* View for save button */
    LFM.Views.featuredSaveButtonView = wp.Backbone.View.extend({
        className: 'media-toolbar',

        events: {
            'click a.button': 'save'
        },

        template: wp.media.template('featured-media-save'),

        save: function() {
            var currentView = LFM.instances.frame.views.get('.media-frame-content'),
                self = this;

            if (currentView.length > 0)
                currentView = currentView[0];
            else
                return false;

            if (typeof this.model == 'undefined')
                this.model = new featuredMediaModel();

            var attrs = LFM.Utils.formArrayToObj(
                currentView.$el.find('form').serializeArray());

            if (currentView.$el.attr('id') == 'media-editor-image') {
                attrs.type = 'image';
                var selected = currentView.$el.find('.attachments .attachment.selected');
                attrs.attachment = selected.data('id');
            }

            this.showSpinner();
            this.model.save(attrs, {
                silent: true,
                success: function(){
                    LFM.Utils.closeModal();
                    self.hideSpinner();
                }
            });
        },

        showSpinner: function() {
            this.$el.find('.spinner').removeAttr('style');
        },

        hideSpinner: function() {
            this.$el.find('.spinner').css({ display: 'none' });
        }
    });

    /* Utils */
    LFM.Utils.formArrayToObj = function(arr) {
        var ret = {};
        _.each(arr, function(item) {
            ret[item.name] = item.value;
        });
        ret = _.extend(ret, { id: LFM.Utils.getPostId() });
        return ret;
    };

    LFM.Utils.doAjax = function(action, data, success, error) {
        var json = JSON.stringify(data);

        params = {
            url: ajaxurl,
            type: 'POST',
            data: {
                action: action,
                data: json
            },
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                if (success)
                    success(data, textStatus, jqXHR);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (error)
                    error(jqXHR, textStatus, errorThrown);
            }
        }

        $.ajax(params);
    };

    LFM.Utils.getPostId = function() {
        return Number($( '#post_ID' ).val());
    };

    LFM.Utils.closeModal = function() {
        LFM.instances.modal.close();
        LFM.Utils.resetModal();
    };

    LFM.Utils.resetModal = function() {
        LFM.instances = {};
    };

    $(document).ready(function() {
        $('#set-featured-media-button').click(function() {
            if (typeof LFM.instances.modal == 'undefined') {
                LFM.instances.modal = new featuredMediaModal({ propagate: false });

                var frame;
                LFM.instances.frame = frame = new featuredMediaFrame();
                LFM.instances.modal.views.set('.media-modal-content', frame);

                var options;
                LFM.instances.options = options = new featuredMediaOptions({ mediaTypes: LFM.options });
                frame.views.set('.media-frame-menu', options);

                var initialView,
                    option;

                var model = new featuredMediaModel();
                model.fetch({
                    success: function(data) {
                        initialViewId = data.get('type') || 'embed-code';
                        option = _.findWhere(LFM.options, { id: initialViewId });

                        var view = featuredMediaIdToView[initialViewId];
                        LFM.instances[initialViewId] = initialView = new LFM.Views[view]({
                            option: option,
                            model: data
                        });
                        frame.views.set('.media-frame-content', initialView);

                        var saveButtonView;
                        LFM.instances.saveButtonView = saveButtonView = new LFM.Views.featuredSaveButtonView({ model: model });
                        frame.views.set('.media-frame-toolbar', saveButtonView);

                        LFM.instances.modal.open();
                        LFM.instances.frame.setActive(initialViewId);
                    }
                });
            } else {
                LFM.instances.modal.open();
                LFM.instances.frame.setActive(initialViewId);
            }

            return false;
        });
    })

}());
