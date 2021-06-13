<?php

function NNfy_Meta_Boxes(){
    new NNfy_Meta_Boxes();
}

/**
 * Get images attached to some post
 *
 * @param int $post_id
 * @return array
 */
function nnfy_get_gallery_images( $post_id = null ){
    global $post;
    if ( $post_id == null ){
        $post_id = $post->ID;
    }
    $value = get_post_meta( $post_id, 'nnfy_gallery_images_src', true );
    $images = unserialize($value);
    $result = array();
    if (!empty($images)){
        foreach ($images as $image){
            $result[] = $image;
        }
    }
    return $result;
}

if ( is_admin() ){
    add_action('load-post.php', 'NNfy_Meta_Boxes');
    add_action('load-post-new.php', 'NNfy_Meta_Boxes');
}

/**
 * NNfy_Meta_Boxes
 */
class NNfy_Meta_Boxes
{

    var $post_types = array();

    /**
     * Initialize Meta boxes
     */
    public function __construct(){
        $this->post_types = array( 'post' ); //limit meta box to certain post types
        add_action('add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action('save_post', [ $this, 'save' ] );
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type){

        if ( in_array( $post_type, $this->post_types ) ){
            add_meta_box(
                'nnfy_post_custom_meta_boxes', 
                esc_html__('Post Editional Information', '99fy'), 
                [ $this, 'render_meta_box_content' ], 
                $post_type,
                'advanced',
                'high'
            );
        }
    }

    /**
     * Save the images when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ){
        
        // Check if our nonce is set.
        if (!isset($_POST['nnfy_post_custom_box_nonce'])){
            return $post_id;
        }

        $nonce = $_POST['nnfy_post_custom_box_nonce'];
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'nnfy_custom_box')){
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return $post_id;
        }

        // Check the user's permissions.
        if (!current_user_can('edit_post', $post_id)){
            return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Validate user input.
        $posted_images    = $_POST['nnfy_gallery_images_src'];
        $posted_video_url = $_POST['nnfy_video_link'];
        $posted_audio_url = $_POST['nnfy_audio_link'];
        $posted_city_text = $_POST['nnfy_city_text'];

        // Update the nnfy_gallery_images_src meta field.
        $nnfy_gl_images = array();
        if ( !empty( $posted_images ) ){
            foreach ($posted_images as $image_url){
                if ( !empty( $image_url ) ){
                    $nnfy_gl_images[] = esc_url_raw ( $image_url );
                }
            }
        }
        update_post_meta( $post_id, 'nnfy_gallery_images_src', serialize( $nnfy_gl_images ) );

        // Update the nnfy_video_link meta field.
        update_post_meta( $post_id, 'nnfy_video_link', esc_url_raw( $posted_video_url ) );

        // Update the nnfy_audio_link meta field.
        update_post_meta( $post_id, 'nnfy_audio_link', esc_url_raw( $posted_audio_url ) );
        
        // Update the nnfy_city_text meta field.
        update_post_meta( $post_id, 'nnfy_city_text', sanitize_text_field( $posted_city_text ) );

    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post){

        // Add an nonce field so we can check for it later.
        wp_nonce_field('nnfy_custom_box', 'nnfy_post_custom_box_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $gallery_img_value = get_post_meta( $post->ID, 'nnfy_gallery_images_src', true );
        $video_link_value = get_post_meta( $post->ID, 'nnfy_video_link', true );
        $audio_link_value = get_post_meta( $post->ID, 'nnfy_audio_link', true );
        $quote_city_value = get_post_meta( $post->ID, 'nnfy_city_text', true );

        ?>
        <div class="nnfy_meta_gallery_area">
            <div id="nnfy_gallery_images_area"></div>
            <input type="button" onClick="addRow()" value="Add Image" class="button" />
        </div>
        <p class="nnfy_video_link_area">
            <input class="widefat" type="text" name="nnfy_video_link" id="nnfy_video_link" value="<?php echo esc_attr( $video_link_value ); ?>" placeholder="<?php echo esc_attr__( 'Enter your video URL','99fy' ); ?>" size="30" />
        </p>
        <p class="nnfy_audio_link_area">
            <input class="widefat" type="text" name="nnfy_audio_link" id="nnfy_audio_link" value="<?php echo esc_attr( $audio_link_value ); ?>" placeholder="<?php echo esc_attr__( 'Enter your audio URL','99fy' ); ?>" size="30" />
        </p>
        <p class="nnfy_quote_city_area">
            <input type="text" name="nnfy_city_text" id="nnfy_city_text" value="<?php echo esc_attr( $quote_city_value ); ?>" placeholder="<?php echo esc_attr__( 'Enter your quote','99fy' ); ?>" size="30" />
        </p>
        <?php

        $images = unserialize( $gallery_img_value );
        $script = "<script type='text/javascript'>
            jQuery(document).ready(function(){
            itemsCount= 0;";
        if (!empty($images)){
            foreach ($images as $image){
                $script.="addRow('{$image}');";
            }
        }
        $script .="});</script>";
        echo $script;
    }

    /**
     * Meta boxes Scripts
     *
     * @param Enqueue Hook $hook
     *
     * @return void
     */
    public function enqueue_scripts($hook){
        if ('post.php' != $hook && 'post-edit.php' != $hook && 'post-new.php' != $hook){
            return;
        }
        wp_enqueue_script( 'nnfy-custom-metabox-js', get_template_directory_uri() . '/js/custom-meta-boxes.js', array('jquery'), null, true );
        $data = array(
            'post_formate_name' => ( get_post_format( get_the_ID() ) ) ? get_post_format( get_the_ID() ) : '0',
            'currentwpversion'  => get_bloginfo( 'version' ),
            'classiceditorst'   => ( class_exists( 'Classic_Editor' ) ) ? '1' : '0',
        );
        wp_localize_script( 'nnfy-custom-metabox-js', 'Post_Formate_Data', $data );

    }


}