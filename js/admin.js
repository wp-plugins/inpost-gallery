var INPOSTGALLERY_ADMIN_SLIDES = function() {

	var self = {
		html_buffer: "",
		init: function() {
			jQuery('body').append('<div id="inpost_gallery_html_buffer" style="display: none;"></div>');
			jQuery('body').append('<div id="inpost_gallery_info_popup" style="display: none;"></div>');

			self.html_buffer = jQuery("#inpost_gallery_html_buffer");

			self.colorizator();

			jQuery("#inpost_gallery_slide_group").sortable({
				stop: function() {
					self.recount_slides();
				}
			});
			//*****
			jQuery('.js_inpost_gallery_add_slide').live('click', function(event)
			{
				window.send_to_editor = function(html)
				{
					self.insert_html_in_buffer(html);
					var images = jQuery(self.html_buffer).find('a');
					var img_urls = new Array();
					jQuery.each(images, function(index, value) {
						img_urls[index] = jQuery(value).attr('href');
					});

					self.add_meta_slide_items(img_urls, 0);
					self.insert_html_in_buffer("");
					//tb_remove();
				};
				//tb_show('', 'media-upload.php?post_id=0&type=image&tab=library&TB_iframe=true');
				wp.media.editor.open(null);

				return false;
			});

			jQuery(".js_inpost_gallery_delete_slide").live('click', function() {
				var self_button = this;
				jQuery(self_button).parents('li').eq(0).hide(333, function() {
					jQuery(self_button).parents('li').eq(0).remove();
				});

				return false;
			});

			jQuery(".js_inpost_gallery_update_slide_title").live('click', function() {
				var slide_id = jQuery(this).attr('slide-id');
				var title = jQuery("[name='inpost_gallery_data[" + slide_id + "][title]']").val();
				title = prompt(inpost_gallery_lang_enter_title, title);
				if (title) {
					jQuery("[name='inpost_gallery_data[" + slide_id + "][title]']").val(title);
				}


				return false;
			});


			self.recount_slides();

			//***

			jQuery(".inpost_gallery_checkbox_selfupdated").click(function() {
				if (jQuery(this).is(':checked')) {
					jQuery(this).next('input[type=hidden]').val(1);
				} else {
					jQuery(this).next('input[type=hidden]').val(0);
				}

				return true;
			});

			jQuery("#checkbox_not_use_timthumb").click(function() {
				if (jQuery(this).is(':checked')) {
					jQuery('#wordpress_custom_sizes').show(200);
				} else {
					jQuery('#wordpress_custom_sizes').hide(200);
				}

				return true;
			});

			jQuery("#inpost_gallery_settings_form").submit(function() {
				var data = {
					action: "inpost_gallery_save_settings",
					values: jQuery(this).serialize()
				};
				jQuery.post(ajaxurl, data, function(response) {
					self.show_info_popup(inpost_gallery_lang_settings_saved);
				});

				return false;
			});


		},
		show_info_popup: function(text) {
			jQuery("#inpost_gallery_info_popup").text(text);
			jQuery("#inpost_gallery_info_popup").fadeTo(400, 0.9);
			window.setTimeout(function() {
				jQuery("#inpost_gallery_info_popup").fadeOut(400);
			}, 1000);
		},
		add_meta_slide_items: function(img_urls, index) {
			self.show_info_popup(inpost_gallery_lang_loading + ' ...');
			var data = {
				action: "add_inpost_gallery_slide_item",
				imgurl: img_urls[index]
			};
			jQuery.post(ajaxurl, data, function(response) {
				jQuery("#inpost_gallery_slide_group").append(response);
				self.recount_slides();
				if (index < (img_urls.length - 1)) {
					self.add_meta_slide_items(img_urls, index + 1);
				}
			});
		},
		insert_html_in_buffer: function(html) {
			jQuery(self.html_buffer).html(html);
		},
		recount_slides: function() {
			var images = jQuery(".inpost_gallery_slide_image");
			jQuery.each(images, function(key, image) {
				var num = key + 1;
				jQuery(image).parent().find(".js_inpost_gallery_slide_counter").html(num);
			});
		},
		colorizator: function() {
			var pickers = jQuery('.bgpicker');

			jQuery.each(pickers, function(key, picker) {

				var bg_hex_color = jQuery(picker).prev('.bg_hex_color');

				if (!jQuery(bg_hex_color).val()) {
					jQuery(bg_hex_color).val();
				}

				jQuery(picker).css('background-color', jQuery(bg_hex_color).val()).ColorPicker({
					color: jQuery(bg_hex_color).val(),
					onChange: function(hsb, hex, rgb) {
						jQuery(picker).css('backgroundColor', '#' + hex);
						jQuery(bg_hex_color).val('#' + hex);
						jQuery(bg_hex_color).trigger('change');
						jQuery(picker).prev('.bg_hex_color').trigger('keydown');
					}
				});

			});
		}
	};

	return self;
};


var inpost_gallery = new INPOSTGALLERY_ADMIN_SLIDES();
jQuery(document).ready(function() {
	inpost_gallery.init();
});

