var INPOSTGALLERY_ADMIN_SLIDES=function(){

    var self={
        init:function(){
            jQuery( "#inpost_gallery_slide_group").sortable({
                stop:function(){
                    self.recount_slides();
                }    
            });
            //*****           
            jQuery('.js_inpost_gallery_add_slide').live('click', function()
            {
                window.send_to_editor = function(html)
                {
                    self.insert_html_in_buffer(html);
                    var imgurl = jQuery(inpost_gallery_html_buffer_object).find('a').eq(0).attr('href');
                    self.add_meta_slide_item(imgurl);
                    self.insert_html_in_buffer("");
                    tb_remove();
                }
                tb_show('', 'media-upload.php?post_id=0&type=image&tab=library&TB_iframe=true');

                return false;
            });

            jQuery(".js_inpost_gallery_delete_slide").live('click', function(){
                var self_button=this;
                jQuery(self_button).parents('li').eq(0).hide(333, function(){
                    jQuery(self_button).parents('li').eq(0).remove();
                })

                return false;
            });
            
            jQuery(".js_inpost_gallery_update_slide_title").live('click', function(){
                var slide_id=jQuery(this).attr('slide-id');
                var title=jQuery("[name='inpost_gallery_data["+slide_id+"][title]']").val();
                title=prompt("Enter slide title", title);
                if(title){                    
                    jQuery("[name='inpost_gallery_data["+slide_id+"][title]']").val(title);
                }
                              

                return false;
            });


            self.recount_slides();

        },        
        add_meta_slide_item:function(imgurl){
            var data = {
                action: "add_inpost_gallery_slide_item",
                imgurl: imgurl
            };
            jQuery.post(ajaxurl, data, function(response) {
                jQuery("#inpost_gallery_slide_group").append(response);
                self.recount_slides();
            });
        },       
        insert_html_in_buffer:function(html){
            jQuery(inpost_gallery_html_buffer_object).html(html);

        },
        recount_slides:function(){
            var images=jQuery(".inpost_gallery_slide_image");
            jQuery.each(images, function(key, image){
                var num=key+1;
                jQuery(image).parent().find(".js_inpost_gallery_slide_counter").html(num);
            });
        }
    }

    return self;
}


var inpost_gallery=new INPOSTGALLERY_ADMIN_SLIDES();
var inpost_gallery_html_buffer_object=null;
jQuery(document).ready(function() {
    jQuery('body').append('<div id="inpost_gallery_html_buffer" style="display: none;"></div>');
    inpost_gallery_html_buffer_object=jQuery("#inpost_gallery_html_buffer");
    inpost_gallery.init();
});

