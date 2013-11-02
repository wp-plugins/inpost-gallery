<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
wp_enqueue_style("inpost_gallery_yoxview", PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/yoxview/yoxview.css');
wp_enqueue_script('inpost_gallery_yoxview', PluginusNet_InpostGallery::get_application_uri() . 'js/sliders/yoxview/jquery.yoxview-2.21.min.js', array('jquery'));
//***
$slides = get_post_meta($post_id, 'inpost_gallery_data', true);

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

//***
$unique_id = uniqid();
if (!isset($thumb_margin_bottom)) {
    $thumb_margin_bottom = 0;
}
if (!isset($thumb_margin_left)) {
    $thumb_margin_left = 3;
}
$styles_a = "margin: 0 0 " . $thumb_margin_bottom . "px " . $thumb_margin_left . "px !important;";
//****
$styles_img = "";
if (isset($thumb_border_radius)) {
    if (!empty($thumb_border_radius)) {
        $styles_img = "border-radius:" . $thumb_border_radius . 'px !important;';
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
?>

<?php if (!empty($slides) AND is_array($slides)): ?>
    <div class="yoxview" id="yoxview_<?php echo $unique_id ?>">
        <?php foreach ($slides as $gallery_item) : ?><a style="<?php echo $styles_a ?>" href="<?php echo $gallery_item['imgurl'] ?>"><img style="<?php echo $styles_img ?>" src="<?php echo PluginusNet_InpostGallery::get_image($gallery_item['imgurl'], $thumb_width . 'x' . $thumb_height) ?>" alt="<?php echo $gallery_item['title'] ?>" title="<?php echo $gallery_item['title'] ?>" /></a><?php endforeach; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#yoxview_<?php echo $unique_id ?>").yoxview();
    });
</script>
