<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class INPOSTGALLERY {

    public function __construct() {
        
    }

    public static function render_html($view, $data = array()) {
        if (!empty($data)) {
            extract($data);
        }

        ob_start();
        include(INPOST_GALLERY_PLUGIN_PATH . '/view/' . $view . '.php');
        return ob_get_clean();
    }

    public static function resize_image($src, $w = 0, $crop = false, $h = 0) {

        $url = INPOST_GALLERY_PLUGIN_LINK . '/extensions/timthumb.php?src=' . urlencode($src);

        $w = intval($w);
        if ($w) {
            if ($crop AND $h = intval($h)) {
                //$url.='&w=' . $w . '&h=' . $h . '&a=t';
                $url.='&w=' . $w . '&h=' . $h;
            } else {
                $url.='&w=' . $w;
            }
        }

        return $url;
    }

    //ajax
    public static function add_slide_item() {
        $data = array();
        $data['item_data'] = array();
        $data['item_data']['imgurl'] = $_REQUEST['imgurl'];
        $data['item_data']['title'] = "";
        echo self::render_html('admin/meta_slide_item', $data);
        exit;
    }

    public static function draw_post_panel($post_id) {
        $data = array();
        $data['post_id'] = $post_id;
        $data['inpost_gallery_data'] = get_post_meta($post_id, 'inpost_gallery_data', true);
        return self::render_html("admin/post_panel", $data);
    }

    public static function draw_shortcode($attributes) {
        $data = array();
        $data['attributes'] = $attributes;
        $slides = get_post_meta($attributes['post_id'], 'inpost_gallery_data', true);
        $view_slides = array();


        if (isset($attributes['random'])) {
            shuffle($slides);
            if ($attributes['random'] != -1) {
                $view_slides = array_slice($slides, 0, $attributes['random']);
            }
        }

        //*****

        if (isset($attributes['id'])) {
            $view_slides = array();
            $ids = explode(',', $attributes['id']);
            $tmp = array();
            if (!empty($slides)) {
                foreach ($slides as $value) {
                    $tmp[] = $value;
                }
            }

            if (!empty($ids)) {
                foreach ($ids as $image_id) {
                    if (isset($tmp[$image_id - 1])) {
                        $view_slides[] = $tmp[$image_id - 1];
                    }
                }
            }
        }
        
        $data['inpost_gallery_data'] = $view_slides;
        return self::render_html("front/shortcode", $data);
    }

}

