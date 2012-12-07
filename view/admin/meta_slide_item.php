<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php $unique_id = uniqid() ?>
<li id="slide_item_<?php echo $unique_id ?>" class="inpost_gallery_slide_item">
    <img class="inpost_gallery_slide_image" src="<?php echo INPOSTGALLERY::resize_image($item_data['imgurl'], 150, true, 150) ?>" alt="media item" />
    <input type="hidden" name="inpost_gallery_data[<?php echo $unique_id ?>][imgurl]" value="<?php echo $item_data['imgurl'] ?>" />
    <input type="hidden" name="inpost_gallery_data[<?php echo $unique_id ?>][title]" value="<?php echo $item_data['title'] ?>" />
    <a href="#" class="js_inpost_gallery_update_slide_title" slide-id="<?php echo $unique_id ?>"><img src="<?php echo INPOST_GALLERY_PLUGIN_LINK ?>/images/update.png" alt="update slide title" /></a>
    <a href="#" class="js_inpost_gallery_delete_slide" slide-id="<?php echo $unique_id ?>"><img src="<?php echo INPOST_GALLERY_PLUGIN_LINK ?>/images/remove.png" alt="delete slide" /></a>
    <div class="js_inpost_gallery_slide_counter">0</div>
</li>


