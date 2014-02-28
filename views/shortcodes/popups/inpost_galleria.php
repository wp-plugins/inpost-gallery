<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div id="pn_shortcode_template" class="pn_shortcode_template clearfix">

    <h3>Galleria by galleria.io</h3>

    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Width', 'inpost-gallery'),
            'shortcode_field' => 'thumb_width',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_width', PluginusNet_InpostGallery::$settings['thumb_default_width']),
            'description' => ''
        ));
        ?>

    </div><!--/ .one-half-->

    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Height', 'inpost-gallery'),
            'shortcode_field' => 'thumb_height',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_height', PluginusNet_InpostGallery::$settings['thumb_default_height']),
            'description' => ''
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Post id', 'inpost-gallery'),
            'shortcode_field' => 'post_id',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('post_id', $post_id),
            'description' => __('ID of post with images. Current post ID is by default. For example you want to keep images in only one custom post type, but use everywhere!', 'inpost-gallery')
        ));
        ?>
    </div>
    
    
    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Margin Left', 'inpost-gallery'),
            'shortcode_field' => 'thumb_margin_left',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_margin_left', 3),
            'description' => __('px', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Margin Bottom', 'inpost-gallery'),
            'shortcode_field' => 'thumb_margin_bottom',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_margin_bottom', 0),
            'description' => __('px', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->



    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Border Radius', 'inpost-gallery'),
            'shortcode_field' => 'thumb_border_radius',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_border_radius', 2),
            'description' => __('px', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->



    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Thumb Shadow', 'inpost-gallery'),
            'shortcode_field' => 'thumb_shadow',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('thumb_shadow', '0 1px 4px rgba(0, 0, 0, 0.2)'),
            'description' => __('Use CSS rule: 0 8px 4px rgba(0, 0, 0, 0.5)', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->


    <hr />


    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('ID\'s', 'inpost-gallery'),
            'shortcode_field' => 'id',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('id', ''),
            'description' => __('id=2,5,9,3 - out slides whith number (white number on thumb in admin). Works if group=0', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Random', 'inpost-gallery'),
            'shortcode_field' => 'random',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('random', 0),
            'description' => __('random=-1 - random slides and out all. random=5 - shuffle slides and out 5 of them.', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">

        <?php
        $groups = range(0, PluginusNet_InpostGallery::$settings['max_thumb_groups']);
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'select',
            'title' => __('Group', 'inpost-gallery'),
            'shortcode_field' => 'group',
            'id' => '',
            'options' => $groups,
            'default_value' => PluginusNet_InpostGallery::set_default_value('group', 0),
            'description' => __('You can categorize gallery images by groups', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->


    <div class="one-half">
        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('Border', 'inpost-gallery'),
            'shortcode_field' => 'border',
            'id' => '',
            'default_value' => PluginusNet_InpostGallery::set_default_value('border', ''),
            'description' => __('set border around thumbnail image. Use CSS rule: solid 1px #fff', 'inpost-gallery'),
        ));
        ?>

    </div><!--/ .one-half-->




    <div style="display: none;">       


        <?php
        PluginusNet_InpostGallery::draw_shortcode_option(array(
            'type' => 'text',
            'title' => __('type', 'inpost-gallery'),
            'shortcode_field' => 'type',
            'id' => '',
            'default_value' => 'yoxview',
            'description' => '',
        ));
        ?>



    </div><!--/ .one-half-->

</div>


<!-- --------------------------  PROCESSOR  --------------------------- -->
<script type="text/javascript">
    var shortcode_name = "<?php echo basename(__FILE__, '.php'); ?>";
    jQuery(function() {
        pn_ext_shortcodes.changer(shortcode_name);
        jQuery("#pn_shortcode_template .js_shortcode_template_changer").on('keyup change', function() {
            pn_ext_shortcodes.changer(shortcode_name);
        });
        selectwrap();
    });
</script>
