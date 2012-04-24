<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php
$shortcode="";
if (!empty($gallery_data)){
    $shortcode="OR [inpost_gallery id=";
    foreach ($gallery_data as $key=>$image) {
        if($key>0){
            $shortcode.=",";
        }
        $shortcode.=$image['id'];
    }
    $shortcode.="]";
}
?>

<input style="width: 90%;" type="text" readonly="" value="[inpost_gallery post_id=<?= $_GET['post'] ?>] <?=$shortcode?>" /><br />
<br />
<?= inpostgallery_helper_localize("chooce_files") ?>:<br />
<input type="file" name="inpostagallery_files[]" multiple="" /><br />
<br />
<br />

<?php if (!empty($gallery_data)): ?>
    <div class="yoxview">
        <?php foreach ($gallery_data as $image) : ?>
            #<?= $image['id'] ?>.&nbsp;<a href="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/" . $image['image_file_name'] ?>"><img class="inpostgallery_image_<?= $image['id'] ?>" src="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/thumbs/" . $image['image_file_name'] ?>" alt="<?= $image['image_title'] ?>" title="<?= $image['image_title'] ?>" /></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="clear: both;"></div>
<br />
<br />
<div style="clear: both;"></div>
<?php if (!empty($gallery_data)): ?>
    <ul>
        <?php foreach ($gallery_data as $image) : ?>
        <li id="inpostgallery_item_<?=$image['id']?>">
                <table>
                    <tr>
                        <td>
                            #<?= $image['id'] ?>.&nbsp;<a href="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/" . $image['image_file_name'] ?>"><img src="<?= INPOST_GALLERY_PLUGIN_LINK . "uploads/" . $image['post_id'] . "/thumbs/" . $image['image_file_name'] ?>" alt="<?= $image['image_title'] ?>" title="<?= $image['image_title'] ?>" /></a><br />
                        </td>
                        <td>
                            <input style="width:450px;" type="text" id="inpostgallery_image_names_<?= $image['id'] ?>" value="<?= $image['image_title'] ?>" /> <input type="button" value="<?= inpostgallery_helper_localize("update") ?>" onclick="inpostgallery_edit_image(<?= $image['id'] ?>)" /><br />
                            <input type="button" value="<?= inpostgallery_helper_localize("delete") ?>" onclick="inpostgallery_delete_image(<?= $image['id'] ?>)" /><br />
                        </td>
                    </tr>
                </table>

            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<script type="text/javascript">    
    jQuery(document).ready(function(){
       
        jQuery("form#post").attr("enctype","multipart/form-data");
        
    });
    
    function inpostgallery_edit_image(image_id){
        var title=jQuery("#inpostgallery_image_names_"+image_id).val();
        
        jQuery.post(inpostgallery_ajax_url, {
            inpostgallery_admin_ajax_action: "edit_image",
            image_id: image_id,
            title: title
        },
        function() {
            jQuery(".inpostgallery_image_"+image_id).attr("title",title);
            jQuery(".inpostgallery_image_"+image_id).attr("alt",title);
        });        
        
    }
    
    function inpostgallery_delete_image(image_id){
        if(confirm("<?= inpostgallery_helper_localize("sure") ?>")){
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
    
</script>


<script type="text/javascript" src="<?= INPOST_GALLERY_PLUGIN_LINK ?>js/yoxview/yoxview-init.js"></script>
