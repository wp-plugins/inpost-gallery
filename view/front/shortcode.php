<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>


<?php if (!empty($gallery_data)): ?>
    <div class="yoxview">
        <?php foreach ($gallery_data as $image) : ?>

            <a href="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/" . $image['image_file_name'] ?>"><img src="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/thumbs/" . $image['image_file_name'] ?>" alt="<?= $image['image_title'] ?>" title="<?= $image['image_title'] ?>" /></a>

        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script type="text/javascript">

    ﻿jQuery(document).ready(function($){
        // Uncomment the following line if you use an additional Javascript library (likr Prototype, for example) in the same page as YoxView:
        // jQuery.noConflict();
       jQuery(".yoxview").yoxview();
    });
</script>

