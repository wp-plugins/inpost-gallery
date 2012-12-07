<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="inpost_gallery_data" value="1" />
<input type="text" value="[inpost_gallery post_id=<?php echo $post_id ?>] OR [inpost_gallery post_id=<?php echo $post_id ?> random=-1]" readonly="" style="width: 400px;" /><br />
<br />
<a href="#" class="js_inpost_gallery_add_slide inpost_gallery_add_slide_button">Add slide</a><br />

<ul id="inpost_gallery_slide_group">
    <?php if (!empty($inpost_gallery_data) AND is_array($inpost_gallery_data)): ?>
        <?php foreach ($inpost_gallery_data as $item_data): ?>
            <?php echo INPOSTGALLERY::render_html('admin/meta_slide_item', array('item_data' => $item_data)); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<div style="clear: both;"></div>
<a href="http://pluginus.net/inpost-gallery/" target="_blank" class="pluginus_link">www.pluginus.net</a><br />
<div style="clear: both;"></div>
