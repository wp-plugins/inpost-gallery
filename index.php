<?php

/*
  Plugin Name: InPost Gallery
  Plugin URI: http://pluginus.net/inpost-gallery/
  Description: Gallery in post/page
  Author: Rostislav Sofronov
  Version: 1.0.5
  Author URI: http://www.pluginus.net/
 */


### Load WP-Config File If This File Is Called Directly
if (!function_exists('add_action')) {
    $wp_root = '../../..';
    if (file_exists($wp_root . '/wp-load.php')) {
        require_once($wp_root . '/wp-load.php');
    } else {
        require_once($wp_root . '/wp-config.php');
    }
}

/* GLOBAL SETTINGS */

define("INPOST_GALLERY_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("INPOST_GALLERY_PLUGIN_LINK", plugin_dir_url(__FILE__));

include_once INPOST_GALLERY_PLUGIN_PATH . 'classes/controller.php';

//******************** ADMIN AJAX *************************************/
add_action('wp_ajax_add_inpost_gallery_slide_item', array('INPOSTGALLERY', 'add_slide_item'));
//******************** ADMIN AJAX END *************************************/
register_activation_hook(__FILE__, 'inpostgallery_setup');

function inpostgallery_setup() {
    @chmod(INPOST_GALLERY_PLUGIN_PATH . "cache", 0777);
}

//*********************************************
/* Add page head */
add_action('admin_head', 'inpostgallery_admin_head');
add_action('wp_head', 'inpostgallery_front_head');

function inpostgallery_admin_head() {
    wp_enqueue_style("admin_inpostgallery_css", plugins_url('css/admin_inpostgallery.css', __FILE__));
    wp_enqueue_script('inpostgallery_admin', plugins_url('js/admin.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable'));
}

function inpostgallery_front_head() {
    wp_enqueue_style("inpostgallery_css", plugins_url('css/inpostgallery.css', __FILE__));
    wp_enqueue_style("yoxview_css", plugins_url('js/yoxview/yoxview.css', __FILE__));
    wp_enqueue_script('yoxview_js', plugins_url('js/yoxview/jquery.yoxview-2.21.min.js', __FILE__), array('jquery'));
    wp_enqueue_script('inpostgallery_js', plugins_url('js/inpostgallery.js', __FILE__), array('jquery'));
}

add_action('admin_menu', 'inpostgallery_menu');

function inpostgallery_menu() {
    add_meta_box('inpostgallery_plugin', 'InPost Gallery', 'inpostgallery_draw_post_panel', 'post');
    add_meta_box('inpostgallery_plugin', 'InPost Gallery', 'inpostgallery_draw_post_panel', 'page');
}

function inpostgallery_draw_post_panel() {
    global $post;
    echo INPOSTGALLERY::draw_post_panel($post->ID);
    return true;
}

function inpostgallery_print_admin_notice() {
    $notices = "";

    if (!is_writable(INPOST_GALLERY_PLUGIN_PATH . "cache")) {
        $notices.='<div class="error"><p>To make InPost Gallery plugin work correctly you need to set the permissions 0777 for <b>' . INPOST_GALLERY_PLUGIN_PATH . 'cache</b> folder.</p></div>';
    }

    echo $notices;
}

add_action('admin_notices', 'inpostgallery_print_admin_notice');

/*
 * here hook to page "publish_post+save_post" - for post/page
 */

add_action('publish_page', 'inpostgallery_save_data', 10);
add_action('publish_post', 'inpostgallery_save_data', 10);

//add_action('save_post', 'inpostgallery_save_data', 10);

function inpostgallery_save_data() {
    if (!empty($_POST)) {
        if (isset($_POST["inpost_gallery_data"])) {
            global $post;
            update_post_meta($post->ID, 'inpost_gallery_data', $_POST["inpost_gallery_data"]);
        }
    }
}

add_shortcode('inpost_gallery', array('INPOSTGALLERY', 'draw_shortcode'));

