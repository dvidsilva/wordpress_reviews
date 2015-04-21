<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://megusta.io
 * @since             1.0.0
 * @package           dod-reviews
 *
 * @wordpress-plugin
 * Plugin Name:       DoD Home Page Reviews
 * Plugin URI:        http://doctorondemand.com
 * Description:       Allows to create reviews and display them in the homepage
 * Version:           1.0.0
 * Author:            dvidsilva
 * Author URI:        http://megusta.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
        die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in _inc/class-plugin-name-activator.php
 */
function activate_dod_reviews() {
        require_once plugin_dir_path( __FILE__ ) . '_inc/class-dod-reviews-activator.php';
        DoDReviewssActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in _inc/class-plugin-name-deactivator.php
 */
function deactivate_dod_reviews() {
        require_once plugin_dir_path( __FILE__ ) . '_inc/class-dod-reviews-deactivator.php';
        DoDReviewsDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dod_reviews' );
register_deactivation_hook( __FILE__, 'deactivate_dod_reviews' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . '_inc/class-dod-reviews.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dod_reviews() {
        $plugin = new DoDReviews();
        $plugin->run();
}
run_dod_reviews();


