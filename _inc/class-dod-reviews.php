<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://megusta.io
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/_inc
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/_inc
 * @author     Your Name <email@example.com>
 */
class DoDReviews {

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * The unique identifier of this plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $plugin_name    The string used to uniquely identify this plugin.
         */
        protected $plugin_name;

        /**
         * The current version of the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $version    The current version of the plugin.
         */
        protected $version;

        /**
         * The name of the post type that will be used in admin.
         *
         * @since    1.0.0
         */
        public $post_type = "dodreview";

        /**
         * The options used to create the new taxonomy
         *
         * @since    1.0.0
         */
        public $post_type_args = array(
          'labels'        => array(
            'name'               => 'DoD reviews',
            'singular_name'      => 'DoD Review',
            'edit_item'          => 'Edit Review',
            'new_item'           => 'New Review',
            'add_new_item'       => 'Add New DoD Review',
            'all_items'          => 'All Reviews',
            'view_item'          => 'View Review',
            'search_items'       => 'Search Reviews',
            'not_found'          => 'No Reviews found',
            'not_found_in_trash' => 'No Reviews found in the Trash', 
            'parent_item_colon'  => '',
            'menu_name'          => 'DoD Reviews'
          ),
          'label'         => 'DoD Review',
          'description'   => 'Reviews from our customer for the homepage.',
          'public'        => true,
          'hierarchical'  => false,
          'menu_position' => null,
          'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
          'has_archive'   => true,
          'show_ui'       => true,
          'show_in_menu'  => true,
          'capability_type'   => 'post',
          'show_in_nav_menus' => false
        );

        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the admin area and
         * the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function __construct() {

                $this->plugin_name = 'dod-reviews';
                $this->version = '1.0.0';

                $this->load_dependencies();
                $this->set_locale();
                $this->define_admin_hooks();
                $this->define_public_hooks();

        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - DoDReviewsLoader. Orchestrates the hooks of the plugin.
         * - DoDReviewsi18n. Defines internationalization functionality.
         * - DoDReviewsAdmin. Defines all hooks for the admin area.
         * - DoDReviewsPublic. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function load_dependencies() {

                /**
                 * The class responsible for orchestrating the actions and filters of the
                 * core plugin.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . '_inc/class-dod-reviews-loader.php';

                /**
                 * The class responsible for defining internationalization functionality
                 * of the plugin.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . '_inc/class-dod-reviews-i18n.php';

                /**
                 * The class responsible for defining all actions that occur in the admin area.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dod-reviews-admin.php';

                /**
                 * The class responsible for defining all actions that occur in the public-facing
                 * side of the site.
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dod-reviews-public.php';

                $this->loader = new DoDReviewsLoader();

        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the DoDReviewsi18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function set_locale() {

                $plugin_i18n = new DoDReviewsi18n();
                $plugin_i18n->set_domain( $this->get_plugin_name() );

                $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

        }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {

                $plugin_admin = new DoDReviewsAdmin( $this->get_plugin_name(), $this->get_version() );
                $plugin_admin->post_type = $this->post_type;
                $plugin_admin->post_type_args = $this->post_type_args;

                $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
                $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action( 'admin_init', $plugin_admin, 'register_post_type' );
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_public_hooks() {

                $plugin_public = new DoDReviewsPublic( $this->get_plugin_name(), $this->get_version() );

                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
        public function run() {
                $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @since     1.0.0
         * @return    string    The name of the plugin.
         */
        public function get_plugin_name() {
                return $this->plugin_name;
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @since     1.0.0
         * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader() {
                return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         *
         * @since     1.0.0
         * @return    string    The version number of the plugin.
         */
        public function get_version() {
                return $this->version;
        }

}
