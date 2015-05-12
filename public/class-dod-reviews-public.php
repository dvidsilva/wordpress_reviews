<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class DoDReviewsPublic {

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
         * @param      string    $plugin_name       The name of the plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct( $plugin_name, $version ) {

                $this->plugin_name = $plugin_name;
                $this->version = $version;

        }

        /**
         * Register the stylesheets for the public-facing side of the site.
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

                wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dod-reviews-public.css?version=MzUFaaUcfh8g', array(), $this->version, 'all' );
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
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

                wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dod-reviews-public.js', array( 'jquery' ), $this->version, false );

        }
  
  
        /**
         * Return the reviews in their template with all the styles and JS.
         *
         * @since    1.0.0
         */
        public function display_reviews ($atts) {
          $doctor_page = false;
          if($atts['name']){
            $current_doc = str_ireplace('wwwtest','www',"$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
            $doctor_page = true;
          }
          ob_start();
          include(__DIR__.'/index.php');
          $content = ob_get_contents();
          ob_end_clean();
          return $content;
        }

}
