<?php

/*
  Plugin Name: InPost Gallery
  Plugin URI: http://pluginus.net/inpost-gallery/
  Description: Gallery in post
  Author: Rostislav Sofronov
  Version: 1.0.1
  Author URI: http://pluginus.net/
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

include_once 'helper.php';
include_once 'classes/controller.php';
if (file_exists(INPOST_GALLERY_PLUGIN_PATH . 'localization/' . WPLANG . '.php')) {
    include_once INPOST_GALLERY_PLUGIN_PATH . 'localization/' . WPLANG . '.php';
} else {
    include_once INPOST_GALLERY_PLUGIN_PATH . 'localization/en_EN.php';
}


header("Content-Type: content=text/html; charset=utf-8");
//******************** ADMIN AJAX *************************************/
if (isset($_REQUEST['inpostgallery_admin_ajax_action'])) {

    $wp_user_level = get_user_meta(get_current_user_id(), 'wp_user_level');
    $wp_user_level = $wp_user_level[0];
    if ($wp_user_level == 10) {
        $controller = new INPOSTGALLERY_Controller();
        switch ($_REQUEST['inpostgallery_admin_ajax_action']) {
            case 'edit_image':
                $controller->model->edit_image($_REQUEST['image_id'], $_REQUEST['title']);
                break;
            case 'delete_image':
                $controller->model->delete_image($_REQUEST['image_id']);
                break;

            default:
                break;
        }
    }
    exit;
}
//******************** ADMIN AJAX END *************************************/

register_activation_hook(__FILE__, 'inpostgallery_setup');
register_uninstall_hook(__FILE__, 'inpostgallery_uninstall');

function inpostgallery_setup() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $sql_install = @file_get_contents(INPOST_GALLERY_PLUGIN_PATH . 'install/inpostgallery.sql');
    @dbDelta($sql_install);
}

function inpostgallery_uninstall() {
    global $wpdb;
    $sql = ("DROP TABLE `inpostgallery`");
    $wpdb->query($sql);
}

//*********************************************
/* Add page head */
add_action('admin_head', 'inpostgallery_admin_head');
add_action('wp_head', 'inpostgallery_front_head');

function inpostgallery_admin_head() {
    wp_enqueue_style("inpostgallery_css", INPOST_GALLERY_PLUGIN_LINK . "css/inpostgallery.css");
    wp_enqueue_script('inpostgallery_admin', plugins_url('js/admin.js', __FILE__), array('jquery'), '1.0');
    include_once 'js/front_js.php';
}

function inpostgallery_front_head() {
    wp_enqueue_script('inpostgallery_js', plugins_url('js/inpostgallery.js', __FILE__), array('jquery'), '1.0');
    wp_enqueue_style("inpostgallery_css", INPOST_GALLERY_PLUGIN_LINK . "css/inpostgallery.css");
    include_once 'js/front_js.php';
}

add_action('admin_menu', 'inpostgallery_menu');

function inpostgallery_menu() {
    add_meta_box('inpostgallery_plugin', inpostgallery_helper_localize('InPost Gallery'), 'inpostgallery_draw_post_panel', 'post');
    add_meta_box('inpostgallery_plugin', inpostgallery_helper_localize('InPost Gallery'), 'inpostgallery_draw_post_panel', 'page');
}

function inpostgallery_draw_post_panel() {
    $post_id = (int) @$_GET['post'];
    if ($post_id > 0) {
        $controller = new INPOSTGALLERY_Controller();
        $controller->draw_post_panel($post_id);
    } else {
        echo 'Save post/page before gallery creation!';
    }
}

/*
 * here hook to page "publish_post" - for post/page
 */

add_action('publish_page', 'inpostgallery_save_data', 10);
add_action('publish_post', 'inpostgallery_save_data', 10);

function inpostgallery_save_data() {
    if (!empty($_POST) OR !empty($_FILES)) {
        $controller = new INPOSTGALLERY_Controller();
        $controller->save_gallery($_FILES, $_POST);
    }
}

add_shortcode('inpost_gallery', 'inpost_gallery_shortcode');

function inpost_gallery_shortcode($attributes) {
    if (!class_exists("INPOSTGALLERY_Controller")) {
        include_once INPOST_GALLERY_PLUGIN_PATH . 'classes/controller.php';
    }
    $controller = new INPOSTGALLERY_Controller();
    return $controller->draw_inpostgallery_shortcode($attributes);
}
