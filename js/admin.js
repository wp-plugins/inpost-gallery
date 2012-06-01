function inpostgallery_edit_image(button_object, image_id){
    var title=jQuery("#inpostgallery_image_names_"+image_id).val();

    jQuery.post(inpostgallery_ajax_url, {
        inpostgallery_admin_ajax_action: "edit_image",
        image_id: image_id,
        title: title
    },
    function() {
        jQuery(button_object).animate({
            opacity: 0.50,
            color:"#fff23a"
        },777,function(){
            jQuery(button_object).animate({
                opacity: 1,
                color:"#316b14",
                fontWeight:800
            },777);
        });
        jQuery(".inpostgallery_image_"+image_id).attr("title",title);
        jQuery(".inpostgallery_image_"+image_id).attr("alt",title);
    });

}

function inpostgallery_delete_image(image_id){
    if(confirm(inpost_langvar_sure)){
        jQuery.post(inpostgallery_ajax_url, {
            inpostgallery_admin_ajax_action: "delete_image",
            image_id: image_id
        },
        function() {
            jQuery(".inpostgallery_image_"+image_id).remove();
            jQuery("#inpostgallery_item_"+image_id).remove();
        });
    }
}


function inpostgallery_up_image(image_id){
    var previous_image_id=0;
    var replace_key=0;

    for(var i=0;i<inpost_sort_array.length;i++){
        if(inpost_sort_array[i]==image_id){
            replace_key=i;
            break;
        }
        previous_image_id=inpost_sort_array[i];
    }

    if(previous_image_id>0){
        jQuery.post(inpostgallery_ajax_url, {
            inpostgallery_admin_ajax_action: "up_image",
            image_id: image_id,
            previous_image_id:previous_image_id
        },
        function() {
            var tmp_array=[];
            for(var i=0;i<inpost_sort_array.length;i++){

                if(i == (replace_key-1)){
                    tmp_array[i]=image_id;
                    continue;
                }

                if(i == replace_key){
                    tmp_array[i]=previous_image_id;
                    continue;
                }


                tmp_array[i]=inpost_sort_array[i];
            }

            inpost_sort_array=tmp_array;
            //***
            var html='<li id="inpostgallery_item_'+image_id+'">'+jQuery("#inpostgallery_item_"+image_id).html()+'</li>';
            jQuery("#inpostgallery_item_"+image_id).remove();
            jQuery(html).insertBefore("#inpostgallery_item_"+previous_image_id);
            //***
            if(inpost_sort_array[0] == image_id){
                jQuery("#inpostgallery_item_"+image_id+" .inpost_sort_buttons input[type=button]").eq(0).hide();
                jQuery("#inpostgallery_item_"+previous_image_id+" .inpost_sort_buttons input[type=button]").show();
            }
            
            if(inpost_sort_array[inpost_sort_array.length-1] == previous_image_id){
                jQuery("#inpostgallery_item_"+previous_image_id+" .inpost_sort_buttons input[type=button]").eq(1).hide();
                jQuery("#inpostgallery_item_"+image_id+" .inpost_sort_buttons input[type=button]").show();
            }
            //***
            html=jQuery(".inpostgallery_image_"+image_id).parent().html();
            var link=jQuery(".inpostgallery_image_"+image_id).parent().attr('href');
            jQuery(".inpostgallery_image_"+image_id).parent().remove();             
            jQuery('<a href="'+link+'">'+html+'</a>').insertBefore(jQuery(".inpostgallery_image_"+previous_image_id).parent());
        });
    }
}



function inpostgallery_down_image(image_id){
    var next_image_id=0;
    var replace_key=0;

    for(var i=0;i<inpost_sort_array.length;i++){
        next_image_id=inpost_sort_array[i+1];
        
        if(inpost_sort_array[i]==image_id){
            replace_key=i;
            break;
        }        
    }

    if(next_image_id>0){
        jQuery.post(inpostgallery_ajax_url, {
            inpostgallery_admin_ajax_action: "down_image",
            image_id: image_id,
            next_image_id:next_image_id
        },
        function() {
            var tmp_array=[];
            for(var i=0;i<inpost_sort_array.length;i++){
                
                if(i == replace_key){
                    tmp_array[i]=next_image_id;
                    continue;
                }
                
                
                if(i == replace_key+1){
                    tmp_array[i]=image_id;
                    continue;
                }

                tmp_array[i]=inpost_sort_array[i];
            }

            inpost_sort_array=tmp_array;
            //***
            var html='<li id="inpostgallery_item_'+image_id+'">'+jQuery("#inpostgallery_item_"+image_id).html()+'</li>';
            jQuery("#inpostgallery_item_"+image_id).remove();
            jQuery(html).insertAfter("#inpostgallery_item_"+next_image_id);
            //***
            if(inpost_sort_array[inpost_sort_array.length-1] == image_id){
                jQuery("#inpostgallery_item_"+image_id+" .inpost_sort_buttons input[type=button]").eq(1).hide();
                jQuery("#inpostgallery_item_"+next_image_id+" .inpost_sort_buttons input[type=button]").show();
            }
            
            if(inpost_sort_array[0] == next_image_id){
                jQuery("#inpostgallery_item_"+next_image_id+" .inpost_sort_buttons input[type=button]").eq(0).hide();
                jQuery("#inpostgallery_item_"+image_id+" .inpost_sort_buttons input[type=button]").show();
            }
            
            //***
            html=jQuery(".inpostgallery_image_"+image_id).parent().html();
            var link=jQuery(".inpostgallery_image_"+image_id).parent().attr('href');
            jQuery(".inpostgallery_image_"+image_id).parent().remove();             
            jQuery('<a href="'+link+'">'+html+'</a>').insertAfter(jQuery(".inpostgallery_image_"+next_image_id).parent());
        });
    }
}


