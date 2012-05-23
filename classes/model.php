<?php

class INPOSTGALLERY_Model {

    const TABLE_GALLERY = "inpostgallery";

    private $db;

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    }

    public function get_post_data($post_id) {
        $data = $this->db->get_results("SELECT * FROM " . self::TABLE_GALLERY . " WHERE post_id=$post_id ORDER BY sort ASC", ARRAY_A);
        return array("gallery_data" => $data, "post_id" => $post_id);
    }

    //for shortcode only
    public function get_post_data_by_ids($ids) {
        $ids = explode(",", $ids);
        $ids_set = "(";
        if (!empty($ids)) {
            foreach ($ids as $key => $image) {
                if ($key > 0) {
                    $ids_set.=",";
                }
                $ids_set.=$image['id'];
            }
        }
        $ids_set.=")";

        $data = $this->db->get_results("SELECT * FROM " . self::TABLE_GALLERY . " WHERE id IN" . $ids_set, ARRAY_A);
        return array("gallery_data" => $data);
    }

    public function save_image($post_id, $new_image_name, $image_name) {
        $this->db->insert(self::TABLE_GALLERY, array('post_id' => $post_id, 'image_file_name' => $new_image_name, 'image_title' => $image_name));
        $image_id=  mysql_insert_id();
        $this->db->update(self::TABLE_GALLERY, array('sort' => $image_id), array('id' => $image_id));
    }

    public function edit_image($image_id, $title) {
        $this->db->update(self::TABLE_GALLERY, array('image_title' => $title), array('id' => $image_id));
    }

    public function delete_image($image_id) {
        $image_info = $this->get_image_info($image_id);
        @unlink(INPOST_GALLERY_PLUGIN_PATH . "uploads/" . $image_info['post_id'] . "/" . $image_info['image_file_name']);
        @unlink(INPOST_GALLERY_PLUGIN_PATH . "uploads/" . $image_info['post_id'] . "/thumbs/" . $image_info['image_file_name']);

        $this->db->query("DELETE FROM " . self::TABLE_GALLERY . " WHERE `id` =" . $image_id);
    }

    public function resort_images($image_id, $resort_image_id) {
        $image = $this->get_image_info($image_id);
        $resort_image = $this->get_image_info($resort_image_id);
        //***
        $this->db->update(self::TABLE_GALLERY, array('sort' => $resort_image['sort']), array('id' => $image_id));
        $this->db->update(self::TABLE_GALLERY, array('sort' => $image['sort']), array('id' => $resort_image_id));
    }

//***
    private function get_image_info($image_id) {
        $data = $this->db->get_results("SELECT * FROM " . self::TABLE_GALLERY . " WHERE id=$image_id", ARRAY_A);
        return $data[0];
    }

}

