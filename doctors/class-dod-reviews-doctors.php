<?php

/**
 * The doctors functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The doctors functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class DoDReviewsDoctors {

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

  
        public $post_type = "doddoctors";
  
  
        public $post_type_args = array(
          'labels'        => array(
            'name'               => 'DoD Doctors',
            'singular_name'      => 'DoD Doctor',
            'edit_item'          => 'Edit Doctor',
            'new_item'           => 'New Doctor',
            'add_new_item'       => 'Add New DoD Doctor',
            'all_items'          => 'All Doctors',
            'view_item'          => 'View Doctor',
            'search_items'       => 'Search Doctor',
            'not_found'          => 'No Doctor found',
            'not_found_in_trash' => 'No Doctors found in the Trash', 
            'parent_item_colon'  => '',
            'menu_name'          => 'DoD Doctors'
          ),
          'label'         => 'Doctor',
          'description'   => 'Doctors who have gotten reviews.',
          'public'        => true,
          'hierarchical'  => false,
          'menu_position' => 5,
          'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions'),
          'has_archive'   => true,
          'show_ui'       => true,
          'show_in_menu'  => true,
          'show_in_nav_menus' => true,
          'capability_type'   => 'post',
          'show_in_nav_menus' => false
        );
  
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
          echo '<table>';
          echo '<thead><tr><th class="left">Name</th><th>Value</th></tr></thead>';
          foreach ($this->post_meta as $meta ) {
            $value = get_post_meta( $post->ID, $meta['name'], true );
            // Display the form, using the current value.
            echo '<tr>';
            echo '<td class="left"><label for="myplugin_new_field">';
            echo $meta['label'];
            echo '</label></td>';
            echo '<td><input type="text" id="'.$meta['name'].'" name="'.$meta['name'].'"';
            echo ' value="' . esc_attr( $value ) . '" size="25" /></td>';
            echo '</tr>';
          }
          echo '</table>';
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
