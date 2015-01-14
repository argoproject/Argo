/* LFM -- Largo Featured Media modal */
if (!window.console) {
    console = {
        log: function(){}
    };
}

var LFM = _.extend(LFM || {}, {
    Utils: {},
    Views: {},
    Models: {},
    instances: {},
});

(function() {
    var $ = jQuery,
        l10n = _wpMediaViewsL10n,
        isTouchDevice = ( 'ontouchend' in document );

    /* Models */
    var featuredMediaModel;
    LFM.Models.featuredMediaModel = featuredMediaModel = Backbone.Model.extend({
        initialize: function() {
            Backbone.Model.prototype.initialize.apply(this, arguments);
            this.set({ id: LFM.Utils.getPostId() });
        },

        url: ajaxurl,

        sync: function(method, model, options) {
            var data;

            if (method == 'create' || method == 'update')
                data =  model.toJSON();
            else
                data = {};

            // Make sure we tell the backend what post ID we're dealing with.
            data = _.extend(data, { id: LFM.Utils.getPostId() });

            var action;
            if (method == 'read')
                action = 'largo_featured_media_read';
            else if (method == 'update' || method ==  'create')
                action = 'largo_featured_media_save';
            else
                return false;

            var success = options.success;
            var error = options.error;
            LFM.Utils.doAjax(action, data, success, error);
        }
    });

    /* Featured Media Modal (Controller) */
    LFM.Views.featuredMediaFrame = wp.media.view.MediaFrame.Select.extend({
        initialize: function() {
            _.defaults(this.options, {
                multiple:  true,
                editing:   false,
                state:    'image',
                metadata:  {},
                className: 'featured-media-modal',
                model: new featuredMediaModel()
            });
            wp.media.view.MediaFrame.Select.prototype.initialize.apply(this, arguments);
            this.createIframeStates();
            this.$el.addClass(this.options.className);
        },

        createStates: function() {
            var options = this.options;

            this.states.add([
                // Embed code
                new wp.media.controller.Embed({
                    title: 'Featured embed code',
                    metadata: options.metadata,
                    id: 'embed-code',
                    priority: 0
                }),

                // Featured image
                new wp.media.controller.FeaturedImage({
                    title: 'Featured image',
                    priority: 10,
                    id: 'image',
                }),

                // Featured gallery
                new wp.media.controller.Library({
                    id: 'gallery',
                    title: 'Featured gallery',
                    priority: 20,
                    toolbar: 'main-gallery',
                    filterable: 'uploaded',
                    multiple: 'add',
                    editable: false,
                    library: wp.media.query(_.defaults({
                        type: 'image'
                    }, options.library))
                }),

                // Gallery states.
                new wp.media.controller.GalleryEdit({
                    library: options.selection,
                    editing: options.editing,
                    menu: 'gallery'
                }),

                new wp.media.controller.GalleryAdd()
            ]);
        },

        bindHandlers: function() {
            var handlers;

            wp.media.view.MediaFrame.Select.prototype.bindHandlers.apply( this, arguments );

            this.on( 'menu:create:gallery', this.createMenu, this );
            this.on( 'toolbar:create:main-gallery', this.createToolbar, this );
            this.on( 'toolbar:create:featured-image', this.featuredImageToolbar, this );
            this.on( 'toolbar:create:main-embed', this.mainEmbedToolbar, this );

            handlers = {
                menu: {
                    'default': 'mainMenu',
                    'gallery': 'galleryMenu',
                },

                content: {
                    'embed':          'embedContent',
                    'edit-image':     'editImageContent',
                    'edit-selection': 'editSelectionContent'
                },

                toolbar: {
                    'main-gallery':     'mainGalleryToolbar',
                    'gallery-edit':     'galleryEditToolbar',
                    'gallery-add':      'galleryAddToolbar'
                }
            };

            _.each( handlers, function( regionHandlers, region ) {
                _.each( regionHandlers, function( callback, handler ) {
                    this.on( region + ':render:' + handler, this[ callback ], this );
                }, this );
            }, this );
        },

        galleryMenu: function( view ) {
            var lastState = this.lastState(),
            previous = lastState && lastState.id,
            frame = this;

            view.set({
                cancel: {
                    text:     l10n.cancelGalleryTitle,
                    priority: 20,
                    click:    function() {
                        if ( previous ) {
                            frame.setState( previous );
                        } else {
                            frame.close();
                        }

                        // Keep focus inside media modal
                        // after canceling a gallery
                        this.controller.modal.focusManager.focus();
                    }
                },
                separateCancel: new wp.media.View({
                    className: 'separator',
                    priority: 40
                })
            });
        },

        // Content
        embedContent: function() {
            var view = new LFM.Views.featuredEmbedCodeView({
                controller: this,
                model: this.state()
            }).render();

            this.content.set(view);
        },

        editSelectionContent: function() {
            var state = this.state(),
            selection = state.get('selection'),
            view;

            view = new wp.media.view.AttachmentsBrowser({
                controller: this,
                collection: selection,
                selection:  selection,
                model:      state,
                sortable:   true,
                search:     false,
                dragInfo:   true,

                AttachmentView: wp.media.view.Attachment.EditSelection
            }).render();

            view.toolbar.set( 'backToLibrary', {
                text:     l10n.returnToLibrary,
                priority: -100,

                click: function() {
                    this.controller.content.mode('browse');
                }
            });

            // Browse our library of attachments.
            this.content.set( view );
        },

        editImageContent: function() {
            var image = this.state().get('image'),
            view = new wp.media.view.EditImage( { model: image, controller: this } ).render();

            this.content.set( view );

            // after creating the wrapper view, load the actual editor via an ajax call
            view.loadEditor();
        },

        selectionStatusToolbar: function( view ) {
            var editable = this.state().get('editable');

            view.set( 'selection', new wp.media.view.Selection({
                controller: this,
                collection: this.state().get('selection'),
                priority:   -40,

                // If the selection is editable, pass the callback to
                // switch the content mode.
                editable: editable && function() {
                    this.controller.content.mode('edit-selection');
                }
            }).render() );
        },

        mainGalleryToolbar: function( view ) {
            var controller = this;

            this.selectionStatusToolbar( view );

            view.set( 'gallery', {
                style:    'primary',
                text:     l10n.createNewGallery,
                priority: 60,
                requires: { selection: true },

                click: function() {
                    var selection = controller.state().get('selection'),
                    edit = controller.state('gallery-edit'),
                    models = selection.where({ type: 'image' });

                    edit.set( 'library', new wp.media.model.Selection( models, {
                        props:    selection.props.toJSON(),
                        multiple: true
                    }) );

                    this.controller.setState('gallery-edit');

                    // Keep focus inside media modal
                    // after jumping to gallery view
                    this.controller.modal.focusManager.focus();
                }
            });
        },

        featuredImageToolbar: function(toolbar) {
            toolbar.view = new LFM.Views.defaultToolbar({
                controller: this
            });
        },

        mainEmbedToolbar: function(toolbar) {
            toolbar.view = new LFM.Views.defaultToolbar({
                controller: this
            });
        },

        galleryEditToolbar: function() {
            this.toolbar.set(new LFM.Views.defaultToolbar({
                controller: this
            }));
        },

        galleryAddToolbar: function() {
            this.toolbar.set( new wp.media.view.Toolbar({
                controller: this,
                items: {
                    insert: {
                        style:    'primary',
                        text:     l10n.addToGallery,
                        priority: 80,
                        requires: { selection: true },

                        /**
                         * @fires wp.wp.media.controller.State#reset
                         */
                        click: function() {
                            var controller = this.controller,
                            state = controller.state(),
                            edit = controller.state('gallery-edit');

                            edit.get('library').add( state.get('selection').models );
                            state.trigger('reset');
                            controller.setState('gallery-edit');
                        }
                    }
                }
            }) );
        }
    });

    /* Views for media types */
    LFM.Views.featuredEmbedCodeView = wp.media.View.extend({
        id: 'media-editor-embed-code',
        template: wp.media.template('featured-embed-code')
    });

    LFM.Views.featuredVideoView = wp.media.View.extend({
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
        },

        showSpinner: function() {
            this.$el.find('.spinner').removeAttr('style');
        },

        hideSpinner: function() {
            this.$el.find('.spinner').css({ display: 'none' });
        }
    });

    LFM.Views.featuredImageBaseView = wp.media.view.Frame.extend({
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

            var lib = new wp.media.controller.Library({
                multiple: (this.options.multiple)? 'add' : false,
                editable: false
            });
            this.states.add([lib]);
            this._state = 'library';
            return this;
        },

        setBrowserId: function() {
            this.browser.$el.attr('id', this.id);
        },

        render: function() {
            this.browseContent();
            this.setBrowserId();
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
                    self.setColumns();
                });
            } else {
                LFM.instances.frame.views.set('.media-frame-content', this.browser);
                this.updateSelection();
                this.setColumns();
            }
        },

        setColumns: _.debounce(function() {
            var currentView = LFM.instances.frame.views.get('.media-frame-content')[0];
            var attachments = _.find(currentView.views.get(''), function(v) {
                return typeof v.setColumns !== 'undefined';
            });
            attachments.setColumns();
        }, 250),

        uploadContent: function() {
            var region = new wp.media.view.UploaderInline({
                controller: this
            });
            LFM.instances.frame.views.set('.media-frame-content', region);
        }
    });

    LFM.Views.featuredPhotoGalleryView = LFM.Views.featuredImageBaseView.extend({
        id: 'media-editor-gallery',

        initialize: function() {
            this.options.multiple = 'add';
            LFM.Views.featuredImageBaseView.prototype.initialize.apply(this, arguments);
            return this;
        },

        updateSelection: function() {
            var selection = this.state().get('selection');

            if (typeof this.model !== 'undefined') {
                var galleryIds = this.model.get('gallery'),
                    galleryItems = _.map(galleryIds, function(imageId) {
                        return wp.media.model.Attachment.get(imageId);
                    });

                _.each(galleryItems, function(item) { item.fetch(); });
                selection.reset(galleryItems);
            }
        },
    });

    LFM.Views.defaultToolbar = wp.media.view.Toolbar.extend({
        initialize: function() {
            var self = this;

            _.defaults(this.options, {
                items: {
                    submit: {
                        style: 'primary',
                        priority: 10,
                        requires: false,
                        text: 'Set as featured',
                        click: self.save.bind(this)
                    }
                }
            });

            wp.media.view.Toolbar.prototype.initialize.apply( this, arguments );

            // Add the "loading" indicator to the submit button container
            this.primary.$el.prepend('<span class="spinner" style="display: none;"></span>');
        },

        save: function() {
            var self = this,
                view = this.controller,
                state = view.state(),
                attrs = {};

            if (state.get('id') == 'image') {
                attrs.type = 'image';
                var selection = state.get('selection'),
                    selected = selection.map(function(m) { return m.get('id'); });

                if (selected.length > 0)
                    attrs.attachment = selected[0];
            } else if (state.get('id') == 'gallery-edit') {
                attrs.type = 'gallery';
                var library = state.get('library'),
                    selected = library.map(function(m) { return m.get('id'); });

                if (selected.length > 0)
                    attrs.gallery = selected;
            } else {
                attrs = LFM.Utils.formArrayToObj(view.$el.find('form').serializeArray());
            }

            this.showSpinner();
            view.model = new featuredMediaModel(attrs);
            view.model.save({}, {
                success: self.hideSpinner.bind(this)
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

    $(document).ready(function() {
        $('#set-featured-media-button').click(function() {
            var model = new featuredMediaModel();

            model.fetch({
                success: function(data) {
                    var initialViewId = data.get('type') || 'embed-code',
                        option = _.findWhere(LFM.options, { id: initialViewId }),
                        modal = new LFM.Views.featuredMediaFrame({
                            state: option.id,
                            model: model
                        });

                    modal.open();
                    LFM.instances.modal = modal;
                }
            });
        });
    });
}());
