<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<?php
$shortcode = "";
if (!empty($gallery_data)) {
    $shortcode = "OR [inpost_gallery id=";
    foreach ($gallery_data as $key => $image) {
        if ($key > 0) {
            $shortcode.=",";
        }
        $shortcode.=$image['id'];
    }
    $shortcode.="]";
}
?>

<input style="width: 90%;" type="text" readonly="" value="[inpost_gallery post_id=<?= $_GET['post'] ?>] <?= $shortcode ?>" /><br />
<br /><?php $thumb_width= get_metadata('post', $_GET['post'], 'inpostagallery_thumb_width',true);?>
<?=inpostgallery_helper_localize('save_thumb_width')?>:<input type="text" value="<?=($thumb_width?$thumb_width:100)?>" name="inpostagallery_thumb_width" />px<br />
<br />
<?= inpostgallery_helper_localize("chooce_files") ?>:<br />
<input type="file" name="inpostagallery_files[]" multiple="" /><br />
<br />
<br />

<?php if (!empty($gallery_data)): ?>
    <div class="yoxview">
        <?php foreach ($gallery_data as $image) : ?>
            <a href="<?= INPOST_GALLERY_UPLOADS_DIR_LINK . $image['post_id'] . "/" . $image['image_file_name'] ?>"><img class="inpostgallery_image_<?= $image['id'] ?>" src="<?= INPOST_GALLERY_UPLOADS_DIR_LINK . $image['post_id'] . "/thumbs/" . $image['image_file_name'] ?>" alt="<?= $image['image_title'] ?>" title="<?= $image['image_title'] ?>" /></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div style="clear: both;"></div>
<br />
<br />
<div style="clear: both;"></div>
<?php if (!empty($gallery_data)): ?>
    <ul>
        <?php foreach ($gallery_data as $key => $image) : ?>
            <li id="inpostgallery_item_<?= $image['id'] ?>">
                <table>
                    <tr>
                        <td>
                            #<?= $image['id'] ?>.&nbsp;<a href="<?= INPOST_GALLERY_UPLOADS_DIR_LINK . $image['post_id'] . "/" . $image['image_file_name'] ?>"><img src="<?= INPOST_GALLERY_UPLOADS_DIR_LINK . $image['post_id'] . "/thumbs/" . $image['image_file_name'] ?>" alt="<?= $image['image_title'] ?>" title="<?= $image['image_title'] ?>" /></a><br />
                        </td>
                        <td>
                            <input style="width:450px;" type="text" id="inpostgallery_image_names_<?= $image['id'] ?>" value="<?= $image['image_title'] ?>" /> 
                            &nbsp;<input type="button" value="<?= inpostgallery_helper_localize("update") ?>" onclick="inpostgallery_edit_image(this,<?= $image['id'] ?>)" />
                            &nbsp;[
                            <span class="inpost_sort_buttons">


                                <input <?php if ($key <= 0): ?>style="display: none;"<?php endif; ?> type="button" value="▲" onclick="inpostgallery_up_image(<?= $image['id'] ?>)" />

                                &nbsp;<input <?php if (($key + 1) >= count($gallery_data)): ?>style="display: none;"<?php endif; ?> type="button" value="▼" onclick="inpostgallery_down_image(<?= $image['id'] ?>)" />



                            </span>
                            ]<br />
                            <input type="button" value="<?= inpostgallery_helper_localize("delete") ?>" onclick="inpostgallery_delete_image(<?= $image['id'] ?>)" /><br />


                        </td>
                    </tr>

                </table>

            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<script type="text/javascript"> 
    var inpost_sort_array=[];
    
    var inpostgallery_url="<?= INPOST_GALLERY_PLUGIN_LINK ?>";
    var inpostgallery_ajax_url="<?= INPOST_GALLERY_PLUGIN_LINK ?>index.php";   
    var inpost_langvar_sure="<?= inpostgallery_helper_localize("sure") ?>";
    
<?php if (!empty($gallery_data)): ?>
    <?php foreach ($gallery_data as $key => $image) : ?>
                inpost_sort_array[<?= $key ?>]=<?= $image['id'] ?>;
    <?php endforeach; ?>
<?php endif; ?>

    
    jQuery(document).ready(function(){
       
        jQuery("form#post").attr("enctype","multipart/form-data");
        
    });
    
   
</script>
