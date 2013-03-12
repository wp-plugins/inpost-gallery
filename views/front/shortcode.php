<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
$uniq_id = uniqid();

$thumb_height = 200;
$thumb_width = 200;
$alias = "";

if (isset($attributes['thumb_height'])) {
	$thumb_height = $attributes['thumb_height'];
}
if (isset($attributes['thumb_width'])) {
	$thumb_width = $attributes['thumb_width'];
}

if (isset($attributes['alias'])) {
	$alias = $attributes['alias'];
} else {
	$alias = PluginusNet_InpostGallery::$settings['front_thumb_width'] . 'x' . PluginusNet_InpostGallery::$settings['front_thumb_height'];
}
//*****
$styles_a = "margin: 0 0 " . PluginusNet_InpostGallery::$settings['front_thumb_margin_bottom'] . "px " . PluginusNet_InpostGallery::$settings['front_thumb_margin_left'] . "px !important;";
$styles_img = "";
if (isset($attributes['border'])) {
	$styles_img.="border: " . $attributes['border'] . ";";
}
?>
<?php if (!empty($slides) AND is_array($slides)): ?>
	<div class="yoxview" id="yoxview_<?php echo $uniq_id ?>"><?php foreach ($slides as $gallery_item) : ?><?php if (PluginusNet_InpostGallery::$settings['not_use_timthumb']) : ?><a href="<?php echo $gallery_item['imgurl'] ?>"><img style="<?php echo $styles_img ?>" src="<?php echo PluginusNet_InpostGallery::resize_image2($gallery_item['imgurl'], $alias) ?>" title="<?php echo $gallery_item['title'] ?>" alt="<?php echo $gallery_item['title'] ?>" /></a><?php else: ?><a style="<?php echo $styles_a ?>" href="<?php echo $gallery_item['imgurl'] ?>"><img style="<?php echo $styles_img ?>" src="<?php echo PluginusNet_InpostGallery::resize_image($gallery_item['imgurl'], $thumb_width, true, $thumb_height) ?>" alt="<?php echo $gallery_item['title'] ?>" title="<?php echo $gallery_item['title'] ?>" /></a><?php endif; ?><?php endforeach; ?></div>
		<?php endif; ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#yoxview_<?php echo $uniq_id ?>").yoxview();
	});
</script>
