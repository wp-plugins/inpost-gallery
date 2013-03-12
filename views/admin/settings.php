<div class="wrap nosubsub">
    <div class="form-wrap">
        <div class="icon32 icon32-posts-inpost-gallery" id="icon-edit"><br></div>
        <h2><?php _e("InPost Gallery Settings", 'inpost-gallery') ?></h2>

        <div style="width: 60%">
            <form action="/" method="post" id="inpost_gallery_settings_form">

                <div class="form-field">
                    <label style="display: inline-block" for="not_use_timthumb"><?php _e("Don`t use timthumb", 'inpost-gallery') ?>:</label>&nbsp;<input style="width: auto !important;" id="checkbox_not_use_timthumb" class="inpost_gallery_checkbox_selfupdated" type="checkbox" <?php if ($not_use_timthumb): ?>checked=""<?php endif; ?> />
					<input type="hidden" value="<?php echo $not_use_timthumb ?>" name="not_use_timthumb" />
                    <p><b><?php _e("If timthumb doesn work on your server or you doesn love it, check this!", 'inpost-gallery') ?></b></p>
                </div>


				<div class="form-field" id="wordpress_custom_sizes" style="display: <?php echo($not_use_timthumb ? 'block' : 'none') ?>">
                    <label for="wordpress_custom_sizes"><?php _e("Custom sizes (width x height)", 'inpost-gallery') ?>:</label>

					<b><?php _e("Admin thumb size", 'inpost-gallery') ?></b>:&nbsp;<input class="inpost_gallery_image_size_field" type="text" value="<?php echo $admin_thumb_width ?>" name="admin_thumb_width" />&nbsp;x&nbsp;<input class="inpost_gallery_image_size_field" type="text" value="<?php echo $admin_thumb_height ?>" name="admin_thumb_height" />&nbsp;px<br />
					<br />
					<b><?php _e("Front thumb size", 'inpost-gallery') ?></b>:&nbsp;&nbsp;&nbsp;<input class="inpost_gallery_image_size_field" type="text" value="<?php echo $front_thumb_width ?>" name="front_thumb_width" />&nbsp;x&nbsp;<input class="inpost_gallery_image_size_field" type="text" value="<?php echo $front_thumb_height ?>" name="front_thumb_height" />&nbsp;px<br />

					<br />

                    <p><?php _e("After sizes changing or timthumb switch off regenerate thumbnails.", 'inpost-gallery') ?> <a target="_blank" href="http://wordpress.org/extend/plugins/force-regenerate-thumbnails/">http://wordpress.org/extend/plugins/force-regenerate-thumbnails/</a></p>
                </div>


				<b><?php _e("Front thumb margin left", 'inpost-gallery') ?></b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="<?php echo $front_thumb_margin_left ?>" name="front_thumb_margin_left" class="inpost_gallery_image_size_field" />&nbsp;px<br />
				<b><?php _e("Front thumb margin bottom", 'inpost-gallery') ?></b>:&nbsp;<input type="text" value="<?php echo $front_thumb_margin_bottom ?>" name="front_thumb_margin_bottom" class="inpost_gallery_image_size_field" />&nbsp;px<br />
				<!--
				<h3><?php _e("CSS Styles", 'inpost-gallery') ?></h3>
				<textarea name="inpost_gallery_css_styles" style="width: 600px; height: 300px;"><?php echo @$inpost_gallery_css_styles ?></textarea><br />
				<br />
				<p><?php _e("Example: .yoxview a img{border:solid 2px #000;}. Set borders for thumbnails on front", 'inpost-gallery') ?></p>
				-->

                <p class="submit">
                    <input type="submit" value="<?php _e("Save settings", 'inpost-gallery') ?>" class="button button-primary" name="submit" />
                </p>
            </form>
        </div>
    </div>
</div>

