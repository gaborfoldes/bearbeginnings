<?php
/**
 * Plugin Name: Featured image widget
 * Plugin URI: http://wordpress.org/extend/plugins/featured-image-widget/
 * Description: This widget shows the featured image for posts and pages. If a featured image hasn't been set, several fallback mechanisms can be used.
 * Version: 0.2
 * Author: Walter Vos
 * Author URI: http://www.waltervos.nl/
 */

class FeaturedImageWidget extends WP_Widget {
    function FeaturedImageWidget() {
        parent::WP_Widget(false, $name = 'Featured Image Widget');
    }

    function form($instance) {
        $title = esc_attr($instance['title']);
        $instance['image-size'] = (!$instance['image-size'] || $instance['image-size'] == '') ? 'post-thumbnail' : $instance['image-size'];
        ?>
<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
<p>
    <label for="<?php echo $this->get_field_id('image-size'); ?>">Image size to display:</label>
    <select class="widefat" id="<?php echo $this->get_field_id('image-size'); ?>" name="<?php echo $this->get_field_name('image-size'); ?>">
                <?php foreach (get_intermediate_image_sizes() as $intermediate_image_size) : ?>
        <?php
        $selected = ($instance['image-size'] == $intermediate_image_size) ? ' selected="selected"' : '';
        ?>
        <option value="<?php echo $intermediate_image_size; ?>"<?php echo $selected; ?>><?php echo $intermediate_image_size; ?></option>
                <?php endforeach; ?>
    </select>
</p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $new_instance['title'] = strip_tags($new_instance['title']);
        return $new_instance;
    }

    function widget($args, $instance) {
        extract($args);
        $size = $instance['image-size'];
        global $post;

        if (has_post_thumbnail($post->ID) && is_single()) {
            $title = apply_filters('widget_title', $instance['title']);
            echo $before_widget;
            if ( $title ) echo $before_title . $title . $after_title;
            echo get_the_post_thumbnail($post->ID, $size);
						edit_post_link( __( 'edit', 'basetheme' ), '<span class="edit-link-center">', '</span>' );
            echo $after_widget;
        } else {
            // the current post lacks a thumbnail, we do nothing?
        }
    }

    function get_attached_images($post_id) { // unused ATM
        $args = array(
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'numberposts' => 1,
                'post_status' => null,
                'post_parent' => $post_id
        );
        $attachments = get_posts($args);
        if (empty($attachments)) return false;
        else {
            foreach ($attachments as $key => $attachment) {
                if ($attachments[$key]->post_content == 'no slideshow') unset($attachments[$key]);
            }
            return $attachments;
        }
    }
} // End class FeaturedImageWidget

add_action('widgets_init', create_function('', 'return register_widget("FeaturedImageWidget");'));
?>