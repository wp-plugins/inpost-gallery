<?php

include_once 'model.php';
include_once 'view.php';

class INPOSTGALLERY_Controller {

    public $view, $model;

    public function __construct() {
        $this->view = new INPOSTGALLERY_View();
        $this->model = new INPOSTGALLERY_Model();
    }

    public function action_index() {
        $this->view->render_admin("index");
    }

    public function draw_post_panel($post_id) {
        $data = $this->model->get_post_data(array("post_id" => $post_id));
        $this->view->render_admin("post_panel", $data);
    }

    public function save_gallery($files, $post) {
        if (!empty($post['inpostagallery_thumb_width'])) {
            update_post_meta($post['post_ID'], 'inpostagallery_thumb_width', (int) $post['inpostagallery_thumb_width']);
        } else {
            update_post_meta($post['post_ID'], 'inpostagallery_thumb_width', 100);
        }

        $thumb_width = get_metadata('post', $post['post_ID'], 'inpostagallery_thumb_width', true);

        if (!empty($files['inpostagallery_files']['name'][0])) {
            @mkdir(WP_CONTENT_DIR . "/uploads");
            @mkdir(INPOST_GALLERY_UPLOADS_DIR);
            //***
            include_once INPOST_GALLERY_PLUGIN_PATH . "library/InpostSimpleImage.php";
            $album_path = INPOST_GALLERY_UPLOADS_DIR  . $post['post_ID'] . "/";
            $thumbs_path = INPOST_GALLERY_UPLOADS_DIR . $post['post_ID'] . "/thumbs/";
            @mkdir($album_path);
            @mkdir($thumbs_path);
            $image = new InpostSimpleImage();
            foreach ($files['inpostagallery_files']['name'] as $key => $image_name) {
                $image->load($files['inpostagallery_files']['tmp_name'][$key]);
                $new_image_name = md5($image_name . time()) . "." . $image->get_image_type();
                $new_image_path = $album_path . $new_image_name;
                $new_thumb_path = $thumbs_path . $new_image_name;
                $image->save($new_image_path);
                //***
                $image->load($files['inpostagallery_files']['tmp_name'][$key]);
                $image->resizeToWidth($thumb_width);
                $image->save($new_thumb_path);
                //***
                $this->model->save_image($post['post_ID'], $new_image_name, $image_name);
            }
        }
    }

    public function draw_inpostgallery_shortcode($attributes) {
        return $this->view->render_front("shortcode", $this->model->get_post_data($attributes));
    }

}

