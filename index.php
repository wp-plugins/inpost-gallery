<?php
/*
  Plugin Name: InPost Gallery
  Plugin URI: http://pluginus.net/inpost-gallery/
  Description: Gallery in post, page and custom post types simply
  Author: Rostislav Sofronov
  Version: 1.1.5
  Author URI: http://www.pluginus.net/
 */


### Load WP-Config File If This File Is Called Directly
$parse_uri = explode('wp-content', __FILE__);
$wp_load = $parse_uri[0] . 'wp-load.php';
require_once($wp_load);

/* GLOBAL SETTINGS */
define("PLUGINUSNET_PLUGIN_INPOSTGALLERY_PATH", plugin_dir_path(__FILE__));
define("PLUGINUSNET_PLUGIN_INPOSTGALLERY_URI", plugin_dir_url(__FILE__));


add_action('init', array('PluginusNet_InpostGallery', 'init'), 1, 1);
add_action('wp_head', array('PluginusNet_InpostGallery', 'wp_head'), 1, 1);
add_action('admin_head', array('PluginusNet_InpostGallery', 'admin_head'), 999, 1);
add_action('admin_init', array('PluginusNet_InpostGallery', 'admin_init'));
add_action('admin_menu', array('PluginusNet_InpostGallery', 'admin_menu'));
add_action('save_post', array('PluginusNet_InpostGallery', 'save_post'));
add_action('admin_notices', array('PluginusNet_InpostGallery', 'admin_notices'));
add_filter('image_size_names_choose', array('PluginusNet_InpostGallery', 'image_size_names_choose'), 999, 1);

add_shortcode('inpost_gallery', array('PluginusNet_InpostGallery', 'draw_shortcode'));

//AJAX callbacks
add_action('wp_ajax_add_inpost_gallery_slide_item', array('PluginusNet_InpostGallery', 'add_slide_item'));
add_action('wp_ajax_inpost_gallery_save_settings', array('PluginusNet_InpostGallery', 'save_settings'));

class PluginusNet_InpostGallery {

	public static $settings = array();

	public static function init() {
		load_plugin_textdomain('inpost-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');

		self::$settings = self::get_settings();

		if (self::$settings['not_use_timthumb']) {
			//init thumb sizes
			$plugin_image_sizes = self::get_plugin_image_sizes();
			if (!empty($plugin_image_sizes)) {
				foreach ($plugin_image_sizes as $key => $value) {
					add_image_size($key, $value['width'], $value['height'], $value['crop']);
				}
			}
		}
	}

	public static function admin_head() {
		wp_enqueue_script('media-upload');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');

		wp_enqueue_script("inpost_gallery_colorpicker_js", plugins_url('js/colorpicker/colorpicker.js', __FILE__));
		wp_enqueue_style("inpost_gallery_colorpicker_css", plugins_url('js/colorpicker/colorpicker.css', __FILE__));

		wp_enqueue_style("inpost_gallery_admin_css", plugins_url('css/admin.css', __FILE__));
		wp_enqueue_script('inpost_gallery_admin_js', plugins_url('js/admin.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable'));
		?>
		<script type="text/javascript">
			var inpost_gallery_lang_loading = "<?php _e("Loading", 'inpost-gallery') ?>";
			var inpost_gallery_lang_enter_title = "<?php _e("Enter slide title", 'inpost-gallery') ?>";
			var inpost_gallery_lang_settings_saved = "<?php _e("Settings have been saved", 'inpost-gallery') ?>";
		</script>	

		<?php
	}

	public static function wp_head() {
		wp_enqueue_script('jquery');
	}

	public static function admin_menu() {
		add_submenu_page('options-general.php', "InPost Gallery", "InPost Gallery", 'edit_pages', "inpost-gallery-settings", array(__CLASS__, 'draw_settings_page'));
	}

	public static function draw_settings_page() {
		echo self::render_html('admin/settings', self::$settings);
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
		echo self::render_html("admin/post_panel", $data);
	}

	function admin_notices() {
		$notices = "";
		if (!self::$settings['not_use_timthumb']) {
			if (!is_writable(PLUGINUSNET_PLUGIN_INPOSTGALLERY_PATH . "cache")) {
				$notices.='<div class="error"><p>' . __('To make InPost Gallery plugin work correctly in timthumb mode you need to set the permissions 0777 for cache folder', 'inpost-gallery') . ' <b>' . PLUGINUSNET_PLUGIN_INPOSTGALLERY_PATH . '</b>.</p></div>';
			}
		}

		echo $notices;
	}

	public static function render_html($view, $data = array()) {
		if (!empty($data)) {
			extract($data);
		}

		ob_start();
		include(PLUGINUSNET_PLUGIN_INPOSTGALLERY_PATH . 'views/' . $view . '.php');
		return ob_get_clean();
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

	public static function save_post() {
		if (!empty($_POST)) {
			if (isset($_POST["inpost_gallery_data"])) {
				global $post;
				update_post_meta($post->ID, 'inpost_gallery_data', $_POST["inpost_gallery_data"]);
			}
		}
	}

	//timthumb
	public static function resize_image($src, $w = 0, $crop = false, $h = 0) {

		$url = PLUGINUSNET_PLUGIN_INPOSTGALLERY_URI . '/extensions/timthumb.php?src=' . urlencode($src);

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

	//for not timthumb resizing
	public static function resize_image2($img_src, $alias) {
		return self::get_image($img_src, $alias);
	}

	public static function get_image($img_src, $alias) {
		if (empty($alias)) {
			return $img_src;
		}

		$sizes = self::get_plugin_image_sizes();
		$img_src = explode(".", $img_src);
		$ext = $img_src[count($img_src) - 1];
		unset($img_src[count($img_src) - 1]);
		$img_src = implode(".", $img_src);
		return $img_src . "-" . $sizes[$alias]['width'] . 'x' . $sizes[$alias]['height'] . "." . $ext;
	}

	public static function draw_shortcode($attributes) {
		wp_enqueue_style("inpost_gallery_front_css", plugins_url('css/front.css', __FILE__));
		wp_enqueue_style("inpost_gallery_yoxview_css", plugins_url('js/yoxview/yoxview.css', __FILE__));
		wp_enqueue_script('inpost_gallery_yoxview_js', plugins_url('js/yoxview/jquery.yoxview-2.21.min.js', __FILE__), array('jquery'));
		//*****

		$data = array();
		$data['attributes'] = $attributes;
		$slides = get_post_meta($attributes['post_id'], 'inpost_gallery_data', true);

		if (!is_array($slides) OR empty($slides)) {
			return "";
		}

		//***** group
		$grouped = false;
		if (isset($attributes['group'])) {
			if ($attributes['group'] != 'all') {
				$tmp_array = array();
				foreach ($slides as $value) {
					if ($value['group'] == (int) $attributes['group']) {
						$tmp_array[] = $value;
					}
				}
				$slides = $tmp_array;
				$grouped = true;
			}
		}
		//***
		if (!$grouped) {
			if (isset($attributes['id'])) {
				$tmp_array = array();
				$ids_array = explode(',', $attributes['id']);
				$counter = 1;
				foreach ($slides as $value) {
					if (in_array($counter, $ids_array)) {
						$tmp_array[] = $value;
					}
					$counter++;
				}
				$slides = $tmp_array;
			}
		}

		//*****
		if (isset($attributes['random'])) {
			@shuffle($slides);
			if ($attributes['random'] != -1) {
				$slides = array_slice($slides, 0, $attributes['random']);
			}
		}
		//*****
		$data['slides'] = $slides;
		return self::render_html("front/shortcode", $data);
	}

	public static function get_plugin_image_sizes() {
		$data = array();

		$key = self::$settings['admin_thumb_width'] . 'x' . self::$settings['admin_thumb_height'];
		$data[$key] = array();
		$data[$key]['name'] = $key;
		$data[$key]['width'] = self::$settings['admin_thumb_width'];
		$data[$key]['height'] = self::$settings['admin_thumb_height'];
		$data[$key]['crop'] = true;

		//***

		$key = self::$settings['front_thumb_width'] . 'x' . self::$settings['front_thumb_height'];
		$data[$key] = array();
		$data[$key]['name'] = $key;
		$data[$key]['width'] = self::$settings['front_thumb_width'];
		$data[$key]['height'] = self::$settings['front_thumb_height'];
		$data[$key]['crop'] = true;

		return $data;
	}

	public static function image_size_names_choose($sizes) {
		if (self::$settings['not_use_timthumb']) {
			$custom_sizes = array();
			$theme_image_sizes = self::get_plugin_image_sizes();
			if (!empty($theme_image_sizes)) {
				foreach ($theme_image_sizes as $key => $value) {
					$custom_sizes[$key] = $value['name'];
				}
			}

			return array_merge($sizes, $custom_sizes);
		}

		return $sizes;
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
			//after installation init
			$settings = array();
		}

		if (empty($settings['not_use_timthumb'])) {
			@$settings['not_use_timthumb'] = 0;
		}

		if (empty($settings['admin_thumb_width'])) {
			@$settings['admin_thumb_width'] = 200;
		}

		if (empty($settings['admin_thumb_height'])) {
			@$settings['admin_thumb_height'] = 200;
		}

		//***

		if (empty($settings['front_thumb_width'])) {
			@$settings['front_thumb_width'] = 200;
		}

		if (empty($settings['front_thumb_height'])) {
			@$settings['front_thumb_height'] = 200;
		}

		if (empty($settings['front_thumb_margin_left'])) {
			@$settings['front_thumb_margin_left'] = 3;
		}

		if (empty($settings['front_thumb_margin_bottom'])) {
			@$settings['front_thumb_margin_bottom'] = -2;
		}

		if (empty($settings['post_types'])) {
			@$settings['post_types'] = array();
			@$settings['post_types']['post'] = 1;
			@$settings['post_types']['page'] = 1;
		}
		/*
		  if (empty($settings['inpost_gallery_css_styles'])) {
		  @$settings['inpost_gallery_css_styles'] = "";
		  }
		 */
		self::$settings = $settings;

		return self::$settings;
	}

}

