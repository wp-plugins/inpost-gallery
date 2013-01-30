<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
$thumb_height = 200;
$thumb_width = 200;
if (isset($attributes['thumb_height'])) {
	$thumb_height = $attributes['thumb_height'];
}
if (isset($attributes['thumb_width'])) {
	$thumb_width = $attributes['thumb_width'];
}
?>
<?php if (!empty($inpost_gallery_data) AND is_array($inpost_gallery_data)): ?>
	<div class="yoxview"><?php foreach ($inpost_gallery_data as $gallery_item) : ?><?php if (PluginusNet_InpostGallery::$settings['not_use_timthumb']) : ?><a href="<?php echo $gallery_item['imgurl'] ?>"><img style="margin: 0 0 <?php echo PluginusNet_InpostGallery::$settings['front_thumb_margin_bottom'] ?>px <?php echo PluginusNet_InpostGallery::$settings['front_thumb_margin_left'] ?>px !important;" src="<?php echo PluginusNet_InpostGallery::resize_image2($gallery_item['imgurl'], PluginusNet_InpostGallery::$settings['front_thumb_width'] . 'x' . PluginusNet_InpostGallery::$settings['front_thumb_height']) ?>" title="<?php echo $gallery_item['title'] ?>" alt="<?php echo $gallery_item['title'] ?>" /></a><?php else: ?><a style="margin: 0 0 <?php echo PluginusNet_InpostGallery::$settings['front_thumb_margin_bottom'] ?>px <?php echo PluginusNet_InpostGallery::$settings['front_thumb_margin_left'] ?>px !important;" href="<?php echo $gallery_item['imgurl'] ?>"><img src="<?php echo PluginusNet_InpostGallery::resize_image($gallery_item['imgurl'], $thumb_width, true, $thumb_height) ?>" alt="<?php echo $gallery_item['title'] ?>" title="<?php echo $gallery_item['title'] ?>" /></a><?php endif; ?><?php endforeach; ?></div>
<?php endif; ?>