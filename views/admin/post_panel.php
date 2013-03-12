<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<input type="hidden" name="inpost_gallery_data" value="1" />
<input type="text" value="[inpost_gallery post_id=<?php echo $post_id ?> group='all']" id="shortcode_text_input" style="width: 99%;" /><br />
<br />

<ul class="misc-pub-section" style="border-top: none;">
	<li><input type="checkbox" id="random_shortcode" class="change_inpost_shortcode" value="1" />&nbsp;<?php _e("Random", 'inpost-gallery') ?>
		&nbsp;&nbsp;&nbsp;<select class="change_inpost_shortcode" id="group_shortcode">
			<?php for ($i = 0; $i <= 100; $i++): ?>
				<option value="<?php echo $i ?>"><?php echo($i > 0 ? $i : __("All", 'inpost-gallery')) ?></option>
			<?php endfor; ?>
		</select>&nbsp;<?php _e("Group", 'inpost-gallery') ?>
	</li>
</ul>


<br />

<a href="#" class="js_inpost_gallery_add_slide inpost_gallery_add_slide_button"><?php _e("Add slides", 'inpost-gallery') ?></a><br />

<ul id="inpost_gallery_slide_group">
	<?php if (!empty($inpost_gallery_data) AND is_array($inpost_gallery_data)): ?>
		<?php foreach ($inpost_gallery_data as $item_data): ?>
			<?php echo PluginusNet_InpostGallery::render_html('admin/meta_slide_item', array('item_data' => $item_data)); ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
<div style="clear: both;"></div>
<a href="http://pluginus.net/inpost-gallery/" target="_blank" class="pluginus_link">www.pluginus.net</a><br />
<div style="clear: both;"></div>

<script type="text/javascript">

	jQuery(document).ready(function() {
		jQuery(".change_inpost_shortcode").click(function() {
			update_inpost_shortcode_text();
			return true;
		});
	});

	function update_inpost_shortcode_text() {
		var post_id =<?php echo $post_id ?>;
		var shortcode_text = '[inpost_gallery post_id=' + post_id;
		//*** random
		var is_checked = jQuery("#random_shortcode").is(":checked");
		if (is_checked) {
			shortcode_text = shortcode_text + ' random=-1';
		}
		//*** group
		var group = "all";
		if (jQuery("#group_shortcode").val() > 0) {
			group = jQuery("#group_shortcode").val();
		}
		shortcode_text = shortcode_text + ' group="' + group + '"';
		//*****
		shortcode_text = shortcode_text + ']';
		jQuery("#shortcode_text_input").val(shortcode_text);
	}

</script>