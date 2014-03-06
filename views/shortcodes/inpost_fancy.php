<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
wp_enqueue_style("fancybox", PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/fancybox/jquery.fancybox.css');
wp_enqueue_style("fancybox_helper_b", PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/fancybox/helpers/jquery.fancybox-buttons.css');
wp_enqueue_script('fancybox', PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/fancybox/jquery.fancybox.pack.js', array('jquery'));
wp_enqueue_script('fancybox_helper_b', PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/fancybox/helpers/jquery.fancybox-buttons.js', array('jquery'));
wp_enqueue_script("easing", PluginusNet_InpostGallery::get_application_uri() . 'js/jquery.easing.1.3.min.js', array('jquery'));
//***
$is_expression = false;
if (substr($post_id, 0, 1) == '{') {
    $slides = PluginusNet_InpostGallery::get_posts_from_expression($post_id);
    $is_expression = true;
} else {
    $slides = get_post_meta($post_id, 'inpost_gallery_data', true);
}

if (!$is_expression) {
    if (!is_array($slides) OR empty($slides)) {
        $slides = array();
    }

    $grouped = false;
    if (isset($group)) {
        if ($group != 0) {//0 mean all
            $tmp_array = array();
            foreach ($slides as $value) {
                if ($value['group'] == (int) $group) {
                    $tmp_array[] = $value;
                }
            }
            $slides = $tmp_array;
            $grouped = true;
        }
    }

//***
    if (!$grouped) {
        if (isset($id) AND !empty($id)) {
            $tmp_array = array();
            $ids_array = explode(',', $id);
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
    if (isset($random)) {
        if ($random != 0 AND !empty($random)) {
            @shuffle($slides);
            if ($random != -1) {
                $slides = array_slice($slides, 0, $random);
            }
        }
    }
}
//***
$unique_id = uniqid();
if (!isset($thumb_margin_bottom)) {
    $thumb_margin_bottom = 0;
}
if (!isset($thumb_margin_left)) {
    $thumb_margin_left = 3;
}
$styles_img = "margin: 0 0 " . $thumb_margin_bottom . "px " . $thumb_margin_left . "px !important;";
//****
if (isset($thumb_border_radius)) {
    if (!empty($thumb_border_radius)) {
        $styles_img.= "border-radius:" . $thumb_border_radius . 'px !important;';
    }
}

if (isset($thumb_shadow)) {
    if (!empty($thumb_shadow)) {
        $styles_img.= "box-shadow:" . $thumb_shadow . ' !important;';
    }
}


//***
if (!empty($border)) {
    $styles_img.="border: " . $border . " !important;";
}
$counter = 0;
?>

<?php if (!empty($slides) AND is_array($slides)): ?>
    <div style="overflow: hidden;">
        <?php foreach ($slides as $gallery_item) : ?>
            <a class="pn_fancybox fancybox_<?php echo $unique_id ?>" rel="gallery_<?php echo $unique_id ?>" href="<?php echo $gallery_item['imgurl'] ?>" title="<?php echo $gallery_item['title'] ?>">
                <img style="<?php echo $styles_img ?>" src="<?php echo PluginusNet_InpostGallery::get_image($gallery_item['imgurl'], $thumb_width . 'x' . $thumb_height) ?>" alt="" />
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".fancybox_<?php echo $unique_id ?>").fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            padding: 0,
            closeBtn: false,
            helpers: {
                buttons: {}
            }
        });
    });
</script>
