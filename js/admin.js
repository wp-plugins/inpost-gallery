var INPOSTGALLERY_ADMIN_SLIDES = function() {

	var self = {
		html_buffer: "",
		init: function() {
			jQuery('body').append('<div id="inpost_gallery_html_buffer" style="display: none;"></div>');
			jQuery('body').append('<div id="inpost_gallery_info_popup" style="display: none;"></div>');

			self.html_buffer = jQuery("#inpost_gallery_html_buffer");


			jQuery("#inpost_gallery_slide_group").sortable({
				stop: function() {
					self.recount_slides();
				}
			});
			//*****
			jQuery('.js_inpost_gallery_add_slide').live('click', function()
			{
				window.send_to_editor = function(html)
				{
					self.insert_html_in_buffer(html);
					var imgurl = jQuery(self.html_buffer).find('a').eq(0).attr('href');
					self.add_meta_slide_item(imgurl);
					self.insert_html_in_buffer("");
					tb_remove();
				};
				tb_show('', 'media-upload.php?post_id=0&type=image&tab=library&TB_iframe=true');

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
					jQuery(this).val(1);
				} else {
					jQuery(this).val(0);
				}
			});

			jQuery("[name=not_use_timthumb]").click(function() {
				if (jQuery(this).is(':checked')) {
					jQuery('#wordpress_custom_sizes').show(200);
				} else {
					jQuery('#wordpress_custom_sizes').hide(200);
				}
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
		add_meta_slide_item: function(imgurl) {
			var data = {
				action: "add_inpost_gallery_slide_item",
				imgurl: imgurl
			};
			jQuery.post(ajaxurl, data, function(response) {
				jQuery("#inpost_gallery_slide_group").append(response);
				self.recount_slides();
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
		}
	};

	return self;
};


var inpost_gallery = new INPOSTGALLERY_ADMIN_SLIDES();
jQuery(document).ready(function() {
	inpost_gallery.init();
});

