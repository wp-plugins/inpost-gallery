<?php
/*
  Plugin Name: InPost Gallery
  Plugin URI: http://pluginus.net/inpost-gallery/
  Description: Insert Gallery in post, page and custom post types just in two clicks
  Author: Rostislav Sofronov <realmag777>
  Version: 2.0.0
  Author URI: http://www.pluginus.net/
 */

//02-11-2013
class PluginusNet_InpostGallery {

    public static $shortcodes = array();
    public static $shortcodes_folders = array();
    public static $shortcodes_keys_by_folders = array();
    //***
    public static $settings = array();

    //*****************************

    public static function get_application_path() {
        return plugin_dir_path(__FILE__);
    }

    public static function get_application_uri() {
        return plugin_dir_url(__FILE__);
    }

    public static function init() {
        load_plugin_textdomain('inpost-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');
        include_once self::get_application_path() . 'helper/aq_resizer_pn.php';
        //***
        self::$settings = self::get_settings();
        add_action('wp_head', array(__CLASS__, 'wp_head'), 1);
        add_action('wp_footer', array(__CLASS__, 'wp_footer'), 1);
        add_action('admin_head', array(__CLASS__, 'admin_head'), 1);
        add_action('admin_menu', array(__CLASS__, 'admin_menu'));
        add_action('admin_init', array(__CLASS__, 'admin_init'));
        add_action('save_post', array(__CLASS__, 'save_post'));
        //***
        add_filter('mce_buttons', array(__CLASS__, 'mce_buttons'));
        add_filter('mce_external_plugins', array(__CLASS__, 'mce_add_rich_plugins'));

        //AJAX callbacks
        add_action('wp_ajax_inpost_gallery_get_shortcode_template', array(__CLASS__, 'get_shortcode_template'));
        add_action('wp_ajax_add_inpost_gallery_slide_item', array(__CLASS__, 'add_slide_item'));
        add_action('wp_ajax_inpost_gallery_save_settings', array(__CLASS__, 'save_settings'));

        //collect shortcodes from folder "views"
        self::$shortcodes_folders[] = 'shortcodes';
        //***
        $shortcodes = self::get_shortcodes_array();
        if (!empty($shortcodes)) {
            foreach ($shortcodes as $value) {
                $name = ucfirst(trim($value));
                $name = str_replace("_", " ", $name);
                self::$shortcodes[$value] = $name;
            }
        }
        //quite shortcodes
        //self::$shortcodes['google_table_row'] = __('Google table row', 'inpost-gallery');
        //*****
        $shortcodes_keys = array_keys(self::$shortcodes);

        function PN_Ext_Shortcodes_do($attributes = array(), $content = "", $shortcode_key) {
            $attributes["content"] = $content;
            if (isset($_REQUEST["shortcode_mode_edit"])) {
                $_REQUEST["shortcode_mode_edit"] = $attributes;
            } else {
                return PluginusNet_InpostGallery::draw_html($shortcode_key, $attributes);
            }
        }

        foreach ($shortcodes_keys as $shortcode_key) {
            $_REQUEST["shortcode_key"] = $shortcode_key;
            add_shortcode($shortcode_key, 'PN_Ext_Shortcodes_do');
        }
    }

    public static function wp_head() {
        wp_enqueue_script('jquery');
    }

    public static function wp_footer() {
        
    }

    public static function admin_head() {
        //global $pagenow;
        $show_shortcode = substr_count($_SERVER['PHP_SELF'], '/wp-admin/post.php');
        if (!$show_shortcode) {
            $show_shortcode = substr_count($_SERVER['PHP_SELF'], '/wp-admin/post-new.php');
        }
        if ($show_shortcode):
            wp_enqueue_script('pn_ext_shortcodes', self::get_application_uri() . 'js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable'));
            wp_enqueue_style('pn_ext_shortcodes', self::get_application_uri() . 'css/admin.css');
            ?>
            <script type="text/javascript">
                var pn_ext_shortcodes_app_link = "<?php echo PluginusNet_InpostGallery::get_application_uri() ?>";
                var pn_ext_shortcodes_items = [];
                var pn_lang_loading = "<?php _e('Loading ...', 'inpost-gallery'); ?>";
            <?php
            wp_enqueue_script('media-upload');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');

            wp_enqueue_script('pn_ext_shortcodes_popup_js', self::get_application_uri() . 'js/pn_popup/pn_advanced_wp_popup.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable'));
            wp_enqueue_style('pn_ext_shortcodes_popup_css', self::get_application_uri() . 'js/pn_popup/styles.css');
            ?>

            <?php foreach (PluginusNet_InpostGallery::$shortcodes as $shortcode_key => $shortcode_name): ?>
                <?php
                //for undershortcodes
                $continue_array = array();
                if (in_array($shortcode_key, $continue_array)) {
                    continue;
                }
                ?>
                    pn_ext_shortcodes_items.push({'key': '<?php echo $shortcode_key ?>', 'name': '<?php echo $shortcode_name ?>', 'icon': '<?php echo PluginusNet_InpostGallery::get_shortcode_icon($shortcode_key) ?>'});
            <?php endforeach; ?>


                var pn_ext_shortcodes_items_keys = /\[(<?php print join('|', array_keys(PluginusNet_InpostGallery::$shortcodes)); ?>)\s?([^\]]*)(?:\s*\/)?\](([^\[\]]*)\[\/\1\])?/g;
                addLoadEvent(function() {
                    jQuery('form#post').submit(function() {
                        var c = this.content;
                        //c.value = c.value.replace(/(\[[^\]]+\S)(\s+sc_id="sc\d+")([^\]]*\])/g, '$1$3');
                    });
                });

                (function($) {

                    $.fn.life = function(types, data, fn) {
                        "use strict";
                        $(this.context).on(types, this.selector, data, fn);
                        return this;
                    };

                })(jQuery);


                var pn_ext_shortcodes_lang1 = "<?php _e('Shortcode updated', 'inpost-gallery') ?>";
                var pn_ext_shortcodes_lang2 = "<?php _e('Insert Shortcode', 'inpost-gallery') ?>";
                var pn_ext_shortcodes_lang3 = "<?php _e('Edit shortcode', 'inpost-gallery') ?>";
                //***
                var inpost_gallery_lang_loading = "<?php _e("Loading", 'inpost-gallery') ?>";
                var inpost_gallery_lang_enter_title = "<?php _e("Enter slide title", 'inpost-gallery') ?>";
                var inpost_gallery_lang_settings_saved = "<?php _e("Settings have been saved", 'inpost-gallery') ?>";

            </script>

            <?php
        endif;
    }

    public static function admin_menu() {
        add_submenu_page('options-general.php', "InPost Gallery", "InPost Gallery", 'edit_pages', "inpost-gallery-settings", array(__CLASS__, 'draw_settings_page'));
    }

    public static function draw_settings_page() {
        echo self::render_html("views/admin/settings.php", self::$settings);
    }

    public static function admin_init() {
        if (!empty(self::$settings['post_types'])) {
            foreach (self::$settings['post_types'] as $post_type => $value) {
                if ($value == 1) {
                    add_meta_box("inpost_gallery_meta_box", __("InPost Gallery", 'inpost-gallery'), array(__CLASS__, 'draw_post_panel'), $post_type, "normal", "default");
                }
            }
        }
    }

    public static function draw_post_panel() {
        global $post;
        $data = array();
        $data['post_id'] = $post->ID;
        $data['inpost_gallery_data'] = get_post_meta($post->ID, 'inpost_gallery_data', true);
        echo self::render_html("views/admin/post_panel.php", $data);
    }

    /*     * ***************************** */

    public static function draw_html($shortcode_key, $attributes = array()) {
        return self::render_html("views/" . self::get_shortcode_key_folder($shortcode_key) . "/" . $shortcode_key . ".php", $attributes);
    }

    public static function get_shortcode_icon($shortcode) {
        $icon_url = self::get_application_uri() . 'images/icons/' . $shortcode . '.png';
        if (file_exists(self::get_application_path() . 'images/icons/' . $shortcode . '.png')) {
            return $icon_url;
        }

        return self::get_application_uri() . 'images/icons/shortcode.png';
    }

    public static function get_shortcodes_array() {
        $results = array();
        foreach (self::$shortcodes_folders as $shortcode_folder) {
            $handler = opendir(self::get_application_path() . "views/" . $shortcode_folder . "/popups/");
            while ($file = readdir($handler)) {
                if ($file != "." AND $file != "..") {
                    $results[] = $file;
                }
            }
            //***
            foreach ($results as $key => $value) {
                $value = explode(".", $value);
                if (!empty($value[0])) {
                    $results[$key] = $value[0];
                    self::$shortcodes_keys_by_folders[$shortcode_folder][] = $value[0];
                }
            }
            $results = array();
        }
        //***
        //self::$shortcodes_keys_by_folders['default'][] = 'google_table_row';
        $results = array();
        if (!empty(self::$shortcodes_keys_by_folders)) {
            foreach (self::$shortcodes_keys_by_folders as $value) {
                $results = array_merge($results, $value);
            }
        }
        //***
        sort($results);
        return $results;
    }

    //*****************************


    public static function mce_buttons($buttons) {
        $buttons[] = 'inpost-gallery';
        //$buttons[] = 'code';
        return $buttons;
    }

    public static function mce_add_rich_plugins($plugin_array) {
        $plugin_array['pn_tiny_shortcodes'] = self::get_application_uri() . '/js/editor.js';
        return $plugin_array;
    }

    //ajax
    public static function get_shortcode_template() {
        $data = array();
        if ($_REQUEST['mode'] == 'edit') {
            $_REQUEST['shortcode_mode_edit'] = array();
            $_REQUEST['shortcode_text'] = str_replace("\'", "'", $_REQUEST['shortcode_text']);
            $_REQUEST['shortcode_text'] = str_replace('\"', '"', $_REQUEST['shortcode_text']);
            do_shortcode($_REQUEST['shortcode_text']);
        }
        //***
        $data['post_id'] = $_REQUEST['post_id'];
        wp_die(self::render_html('views/' . self::get_shortcode_key_folder($_REQUEST['shortcode_name']) . '/popups/' . $_REQUEST['shortcode_name'] . ".php", $data));
    }

    public static function get_shortcode_key_folder($shortcode_key) {
        foreach (self::$shortcodes_keys_by_folders as $folder => $shortcodes_keys) {
            if (in_array($shortcode_key, $shortcodes_keys)) {
                return $folder;
            }
        }
    }

    //for inputs in shortcode popups
    public static function set_default_value($key, $default_value = '') {
        if (isset($_REQUEST["shortcode_mode_edit"]) AND !empty($_REQUEST["shortcode_mode_edit"])) {
            if (is_array($_REQUEST["shortcode_mode_edit"])) {
                if (isset($_REQUEST["shortcode_mode_edit"][$key])) {
                    return $_REQUEST["shortcode_mode_edit"][$key];
                }
            }
        }

        return $default_value;
    }

    public static function render_html($pagepath, $data = array()) {
        $pagepath = self::get_application_path() . '/' . $pagepath;
        @extract($data);
        ob_start();
        include($pagepath);
        return ob_get_clean();
    }

    public static function draw_shortcode_option($data) {
        switch ($data['type']) {
            case 'textarea':
                ?>
                <?php if (!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <textarea id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer data-area" data-shortcode-field="<?php echo $data['shortcode_field'] ?>"><?php echo $data['default_value'] ?></textarea>
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'select':
                if (!isset($data['display'])) {
                    $data['display'] = 1;
                }
                ?>
                <?php if (!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <?php if (!empty($data['options'])): ?>
                    <select <?php if ($data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="js_shortcode_template_changer data-select <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>">

                        <?php foreach ($data['options'] as $key => $text) : ?>
                            <option <?php if ($data['default_value'] == $key) echo 'selected' ?> value="<?php echo $key ?>"><?php echo $text ?></option>
                        <?php endforeach; ?>

                    </select>
                    <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php endif; ?>
                <?php
                break;
            case 'text':
                ?>
                <?php if (!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <input type="text" value="<?php echo $data['default_value'] ?>" <?php if (isset($data['placeholder'])): ?>placeholder="<?php echo $data['placeholder'] ?>"<?php endif; ?> class="js_shortcode_template_changer data-input <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" id="<?php echo $data['id'] ?>" />
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'color':
                ?>
                <div <?php if (@$data['display'] == 0): ?>style="display: none;"<?php endif; ?> class="list-item-color">
                    <?php if (!empty($data['title'])): ?>
                        <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                    <?php endif; ?>

                    <input type="text" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" value="<?php echo $data['default_value'] ?>" class="bg_hex_color text small js_shortcode_template_changer <?php echo @$data['css_classes']; ?>" id="<?php echo $data['id'] ?>">
                    <div style="background-color: <?php echo $data['default_value'] ?>" class="bgpicker"></div>
                    <span class="preset_description"><?php echo $data['description'] ?></span>
                </div>
                <?php
                break;
            case 'upload':
                ?>
                <?php if (!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <input type="text" id="<?php echo $data['id'] ?>" value="<?php echo $data['default_value'] ?>" class="js_shortcode_template_changer data-input data-upload <?php echo @$data['css_classes']; ?>" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
                <a title="" class="pn_button_upload2 button-primary" href="#">
                    <?php _e('Upload', 'inpost-gallery'); ?>
                </a>
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
            case 'checkbox':
                ?>
                <div class="radio-holder">
                    <input <?php if ($data['is_checked']): ?>checked=""<?php endif; ?> type="checkbox" value="<?php if ($data['is_checked']): ?>1<?php else: ?>0<?php endif; ?>" id="<?php echo $data['id'] ?>" class="js_shortcode_template_changer js_shortcode_checkbox_self_update data-check" data-shortcode-field="<?php echo $data['shortcode_field'] ?>">
                    <label for="<?php echo $data['id'] ?>"><span></span><i class="description"><?php if (!empty($data['title'])): ?><?php echo $data['title'] ?><?php endif; ?></i></label>
                </div><!--/ .radio-holder-->
                <?php
                break;
            case 'radio':
                ?>
                <?php if (!empty($data['title'])): ?>
                    <h4 class="label" for="<?php echo $data['id'] ?>"><?php echo $data['title'] ?></h4>
                <?php endif; ?>

                <div class="radio-holder">
                    <input <?php if ($data['values'][0]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][0]['id'] ?>" value="<?php echo $data['values'][0]['value'] ?>" class="js_shortcode_radio_self_update" />
                    <label for="<?php echo $data['values'][0]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][0]['title'] ?></label>

                    <input <?php if ($data['values'][1]['checked'] == 1): ?>checked=""<?php endif; ?> type="radio" name="<?php echo $data['name'] ?>" id="<?php echo $data['values'][1]['id'] ?>" value="<?php echo $data['values'][1]['value'] ?>" class="js_shortcode_radio_self_update" />
                    <label for="<?php echo $data['values'][1]['id'] ?>" class="label-form"><span></span><?php echo $data['values'][1]['title'] ?></label>

                    <input type="hidden" id="<?php echo @$data['hidden_id'] ?>" value="<?php echo $data['value'] ?>" class="js_shortcode_template_changer" data-shortcode-field="<?php echo $data['shortcode_field'] ?>" />
                </div><!--/ .radio-holder-->
                <span class="preset_description"><?php echo $data['description'] ?></span>
                <?php
                break;
        }
    }

    //ajax
    public static function add_slide_item() {
        $data = array();
        $data['item_data'] = array();
        $data['item_data']['imgurl'] = $_REQUEST['imgurl'];
        $data['item_data']['title'] = "";
        wp_die(self::render_html('views/admin/meta_slide_item.php', $data));
    }

    public static function save_post() {
        if (!empty($_POST)) {
            if (isset($_POST["inpost_gallery_data"])) {
                global $post;
                update_post_meta($post->ID, 'inpost_gallery_data', $_POST["inpost_gallery_data"]);
            }
        }
    }

    //ajax
    public static function save_settings() {
        $data = array();
        parse_str($_REQUEST['values'], $data);
        update_option('inpost_gallery_settings', $data);
        exit;
    }

    public static function get_settings() {
        $settings = get_option('inpost_gallery_settings', true);

        if (empty($settings) OR !is_array($settings)) {
            $settings = array(); //after plugin installation it is empty
        }

        //for images panel in post or page backend
        if (!isset($settings['admin_thumb_width'])) {
            $settings['admin_thumb_width'] = 200;
        }

        //for images panel in post or page backend
        if (!isset($settings['admin_thumb_height'])) {
            $settings['admin_thumb_height'] = 200;
        }

        //for images panel in post or page backend
        if (!isset($settings['max_thumb_groups'])) {
            $settings['max_thumb_groups'] = 30;
        }

        //for images panel in post or page backend
        if (!isset($settings['hide_donation_button'])) {
            $settings['hide_donation_button'] = 0;
        }

        if (!isset($settings['post_types'])) {
            $settings['post_types'] = array();
            $settings['post_types']['post'] = 1;
            $settings['post_types']['page'] = 1;
        }

        return self::$settings = $settings;
    }

    public static function get_image($img_src, $alias) {
        if (empty($alias)) {
            return $img_src;
        }

        list($w, $h) = explode('x', $alias);
        $new_img_src = aq_resize_pn($img_src, $w, $h, true);

        return $new_img_src;
    }

    public static function draw_adv_meta() {
        ?>
        <a rel="rel nofollow" target="_blank" href="http://themeforest.net/user/ThemeMakers/portfolio?WT.ac=item_portfolio&WT.seg_1=item_portfolio&WT.z_author=ThemeMakers&ref=realmag777">
            <img alt="PluginusNet partners" src="<?php echo self::get_application_uri() ?>images/themeforest_banner.jpg">
        </a><br />
        <i style="font-size: 9px;"><?php _e('code partners adv', 'inpost-gallery') ?></i>
        <?php
    }

    public static function draw_donate_button() {
        ?>     
        <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=rostislavsofronov%40gmail%2ecom&lc=US&item_name=PluginusNet&item_number=1&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" class="button-primary" style="font-size: 16px;"><?php _e('Donate for InPost Gallery', "slidermania") ?></a><br />
        <?php
    }

}

//*******

add_action('init', array('PluginusNet_InpostGallery', 'init'), 1);
