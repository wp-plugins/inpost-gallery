jQuery(function() {

    tinymce.create("tinymce.plugins.pn_tiny_shortcodes",
            {
                _self: null,
                sc_info: {},
                valid_elements: "ondblclick",
                setup: function(ed) {
                    ed.onDblClick.add(function(ed, e) {
                        //alert('Editor was clicked: ' + e.target.nodeName);
                        var exe = jQuery(e.target).data('mce-exec');
                        eval(exe);
                    });

                },
                init: function(ed, url)
                {
                    _self = this;


                    this.setup(ed);

                    ed.addCommand("pn_shortcode_tiny_popup", function(a, params)
                    {
                        var mode = 'new';
                        var shortcode_text = '';
                        if (params !== undefined) {
                            if (params.mode !== undefined) {
                                mode = params.mode;
                            }
                        }

                        if (mode == 'edit') {
                            shortcode_text = params.shortcode_text;
                        }

                        //***
                        jQuery('body').append('<div id="pn_shortcode_tiny_popup"></div>');
                        pn_ext_shortcodes.show_static_info_popup(pn_lang_loading);
                        //***
                        var data = {
                            action: "inpost_gallery_get_shortcode_template",
                            shortcode_name: params.identifier,
                            mode: mode,
                            post_id: inpost_gallery_post_id,
                            shortcode_text: shortcode_text
                        };
                        jQuery.post(ajaxurl, data, function(html) {
                            pn_ext_shortcodes.hide_static_info_popup();

                            var popup_params = {
                                content: html,
                                title: params.title,
                                overlay: true,
                                open: function() {
                                    //***
                                },
                                buttons: {
                                    0: {
                                        name: 'Apply',
                                        action: function(__self) {
                                            var shortcode = pn_ext_shortcodes.get_html_from_buffer();
                                            var editor = _self.get_active_editor();
                                            //***
                                            if (mode == 'edit') {
                                                //replacing old shortcode text by new one
                                                var html = tinyMCE.activeEditor.getContent();
                                                html = html.replace(params.shortcode_text, jQuery.trim(shortcode));
                                                ed.setContent(html);
                                                pn_ext_shortcodes.show_static_info_popup(pn_ext_shortcodes_lang1 + ': ' + params.identifier);
                                                pn_ext_shortcodes.hide_static_info_popup();
                                            } else {
                                                if (window.tinyMCE) {
                                                    window.tinyMCE.execInstanceCommand(editor, 'mceInsertContent', false, jQuery.trim(shortcode));
                                                    //updating editor content view
                                                    //ed.execCommand('mceRepaint');
                                                    ed.execCommand('mceSetContent', false, tinyMCE.activeEditor.getContent());
                                                }
                                            }
                                        },
                                        close: true
                                    },
                                    1: {
                                        name: 'Close',
                                        action: 'close'
                                    }
                                }
                            };
                            pn_advanced_wp_popup2.popup(popup_params);
                        });

                    });


                    //***

                    ed.onNodeChange.add(function(ed, cm, n) {
                        cm.setActive('pn_tiny_shortcodes', n.nodeName === 'IMG' && ed.dom.hasClass(n, 'shortcode-placeholder'));
                    });


                    ed.onBeforeSetContent.add(function(ed, o) {
                        o.content = _self.toHTML(o.content);
                    });

                    ed.onPostProcess.add(function(ed, o) {
                        if (o.get) {
                            o.content = _self.toText(o.content);
                        }
                    });

                },
                get_active_editor: function() {
                    return tinymce.EditorManager.activeEditor.id;
                },
                createControl: function(btn, e)
                {
                    if (btn == "inpost-gallery")
                    {


                        //tinymce button adding
                        btn = e.addButton("pn_tinymce_button",
                                {
                                    title: pn_ext_shortcodes_lang2,
                                    image: pn_ext_shortcodes_app_link + "images/shortcode_icon.png",
                                    icons: false,
                                    onclick: function() {
                                        inpost_call_galleries_popup();
                                    }
                                });


                        /*
                         var a = this;
                         // adds the dropdown to the button
                         btn.onRenderMenu.add(function(c, b)
                         {
                         jQuery.each(pn_ext_shortcodes_items, function(key, value) {
                         a.addWithPopup(b, value.name, value.key);
                         });
                         
                         });
                         */
                        return btn;
                    }

                    return null;
                },
                addWithPopup: function(ed, title, id) {
                    ed.add({
                        title: title,
                        onclick: function() {
                            tinyMCE.activeEditor.execCommand("pn_shortcode_tiny_popup", false, {
                                title: title,
                                identifier: id
                            });
                        }
                    });
                },
                addImmediate: function(ed, title, sc) {
                    ed.add({
                        title: title,
                        onclick: function() {
                            tinymce.EditorManager.activeEditor.execCommand("mceInsertContent", false, sc);
                        }
                    });
                },
                cache: function(key, val) {
                    if (key && !val)
                        return _self.sc_info[key] || null;
                    if (key && val) {
                        _self.sc_info[key] = val;
                        return true;
                    }
                    return false;
                },
                toText: function(str) {
                    return str.replace(/<img [^>]*\bclass="[^"]*shortcode-placeholder\b[^"]* scid-([^\s"]+)[^>]+>/g, function(a, id) {
                        return _self.cache(id);
                    });
                },
                parseProperties: function(str) {
                    var parts = str.split(/\"/), props = {};
                    for (var i = 0; i < parts.length; i += 2) {
                        if (typeof parts[i] != 'string' || typeof parts[i + 1] != 'string') {
                            continue;
                        }

                        var n = parts[i].replace(/^\s+|\s+$/g, '').replace('=', ''), v = parts[i + 1];
                        if (n && v) {
                            props[n] = v;
                        }

                    }
                    return props;
                },
                toHTML: function(str) {
                    return str.replace(pn_ext_shortcodes_items_keys,
                            function(str, tag, properties, rawconts, conts) {
                                var props = _self.parseProperties(properties);
                                if (props.sc_id === undefined) {
                                    props.sc_id = _self.getId();
                                    properties += ' sc_id="' + props.sc_id + '"';
                                }
                                _self.cache(props.sc_id, '[' + tag + ' ' + properties + (conts ? ']' + conts + '[/' + tag + ']' : ']'));
                                var _properties = properties.replace(/ sc_id="[^"]+"/, '').replace(/="([^"]+)"/g, ': $1;');
                                var shortcode_icon_url = _self.get_shortcode_icon_url(tag);
                                return '<img data-mce-exec="tinymce.get(\'' + _self.get_active_editor() + '\').plugins.pn_tiny_shortcodes.edit_shortcode(\'' + tag + '\',\'' + props.sc_id + '\')" src="' + shortcode_icon_url + '" class="shortcode-placeholder mceItem scid-' + props.sc_id + '" title="Shortcode: ' + tag + ' ' + _properties + '" />';
                            });
                },
                get_shortcode_icon_url: function(tag) {
                    var icon_url = "";
                    jQuery.each(pn_ext_shortcodes_items, function(key, value) {
                        if (value.key == tag) {
                            icon_url = value.icon;
                            return;
                        }
                    });

                    return icon_url;
                },
                edit_shortcode: function(tag, sc_id) {
                    var shortcode_text = _self.cache(sc_id);
                    window.tinymce.execCommand('pn_shortcode_tiny_popup', false, {identifier: tag, title: pn_ext_shortcodes_lang3 + ': ' + tag, mode: 'edit', shortcode_text: shortcode_text, sc_id: sc_id});
                },
                getId: function() {
                    return 'sc' + pn_ext_shortcodes.get_time_miliseconds();
                },
                getInfo: function() {
                    return {
                        longname: 'Shortcodes pack by realmag777',
                        version: "1.1.1"
                    };
                }
            });

    tinymce.PluginManager.add("pn_tiny_shortcodes", tinymce.plugins.pn_tiny_shortcodes);

});
