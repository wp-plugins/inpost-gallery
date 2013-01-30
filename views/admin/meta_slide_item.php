<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php $unique_id = uniqid() ?>
<li id="slide_item_<?php echo $unique_id ?>" class="inpost_gallery_slide_item">

	<?php if (PluginusNet_InpostGallery::$settings['not_use_timthumb']) : ?>
		<img class="inpost_gallery_slide_image" src="<?php echo PluginusNet_InpostGallery::resize_image2($item_data['imgurl'], PluginusNet_InpostGallery::$settings['admin_thumb_width'] . 'x' . PluginusNet_InpostGallery::$settings['admin_thumb_height']) ?>" alt="media item" />
	<?php else: ?>
		<img class="inpost_gallery_slide_image" src="<?php echo PluginusNet_InpostGallery::resize_image($item_data['imgurl'], 150, true, 150) ?>" alt="media item" />
	<?php endif; ?>


    <input type="hidden" name="inpost_gallery_data[<?php echo $unique_id ?>][imgurl]" value="<?php echo $item_data['imgurl'] ?>" />
    <input type="hidden" name="inpost_gallery_data[<?php echo $unique_id ?>][title]" value="<?php echo $item_data['title'] ?>" />
    <a href="#" class="js_inpost_gallery_update_slide_title" slide-id="<?php echo $unique_id ?>" title="<?php _e("Edit title", 'inpost-gallery') ?>"><img src="<?php echo PLUGINUSNET_PLUGIN_INPOSTGALLERY_URI ?>/images/update.png" alt="update slide title" /></a>
    <a href="#" class="js_inpost_gallery_delete_slide" slide-id="<?php echo $unique_id ?>" title="<?php _e("Delete slide", 'inpost-gallery') ?>"><img src="<?php echo PLUGINUSNET_PLUGIN_INPOSTGALLERY_URI ?>/images/remove.png" alt="delete slide" /></a>
    <div class="js_inpost_gallery_slide_counter">0</div>
</li>
