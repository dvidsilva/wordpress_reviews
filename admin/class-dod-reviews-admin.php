<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class DoDReviewsAdmin {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $plugin_name    The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $version    The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         * @param      string    $plugin_name       The name of this plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct( $plugin_name, $version ) {

                $this->plugin_name = $plugin_name;
                $this->version = $version;

        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {

                /**
                 * This function is provided for demonstration purposes only.
                 *
                 * An instance of this class should be passed to the run() function
                 * defined in Plugin_Name_Loader as all of the hooks are defined
                 * in that particular class.
                 *
                 * The Plugin_Name_Loader will then create the relationship
                 * between the defined hooks and the functions defined in this
                 * class.
                 */

                wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

        }


        /**
         * Register posts type so they can create them in the admin panel
         *
         * @since    1.0.0
         */
        public function register_post_type () {
          register_post_type($this->post_type, $this->post_type_args);
        }

        /**
         * add the meta boxes to the review create page
         *
         * @since    1.0.0
         */
        public function add_meta_box ($post_type) {
          if ($post_type==$this->post_type) {
            add_meta_box(
              'dod_revies_meta'
              ,'Review information'
              ,array( $this, 'render_meta_box_content' )
              ,$post_type
              ,'advanced'
              ,'high'
            );
          }
        }

        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public function render_meta_box_content( $post ) {
          // Add an nonce field so we can check for it later.
          wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
          // Use get_post_meta to retrieve an existing value from the database.
          foreach ($this->post_meta as $meta ) {
            $value = get_post_meta( $post->ID, $meta['name'], true );
            // Display the form, using the current value.
            echo '<div>';
            echo '<label for="myplugin_new_field">';
            echo $meta['label'];
            echo '</label> ';
            echo '<input type="text" id="'.$meta['name'].'" name="'.$meta['name'].'"';
            echo ' value="' . esc_attr( $value ) . '" size="25" />';
            echo '</div>';
          }
        }

        /**
         * saves the custom fields for the post
         *
         * @since    1.0.0
         */
        public function save_callback ($post_id) {
          /*
           * We need to verify this came from the our screen and with proper authorization,
           * because save_post can be triggered at other times.
           */

          // Check if our nonce is set.
          if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
            return $post_id;

          $nonce = $_POST['myplugin_inner_custom_box_nonce'];

          // Verify that the nonce is valid.
          if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
            return $post_id;

          // If this is an autosave, our form has not been submitted,
          //     so we don't want to do anything.
          if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

          // Check the user's permissions.
          if ( 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) )
              return $post_id;

          } else {

            if ( ! current_user_can( 'edit_post', $post_id ) )
              return $post_id;
          }

          /* OK, its safe for us to save the data now. */
          foreach ($this->post_meta as $meta ) {
            // Sanitize the user input.
            $val = sanitize_text_field( $_POST[$meta['name']] );
            // Update the meta field.
            update_post_meta( $post_id, $meta['name'], $val );
          }
        }

}
