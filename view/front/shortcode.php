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
<?php if (!empty($inpost_gallery_data)): ?>
    <div class="yoxview">
        <?php foreach ($inpost_gallery_data as $gallery_item) : ?>


            <a href="<?php echo $gallery_item['imgurl'] ?>"><img src="<?php echo INPOSTGALLERY::resize_image($gallery_item['imgurl'], $thumb_width, true, $thumb_height) ?>" title="<?php echo $gallery_item['title'] ?>" alt="<?php echo $gallery_item['title'] ?>" /></a>


        <?php endforeach; ?>
    </div>
<?php endif; ?>

