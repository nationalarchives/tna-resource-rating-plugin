<?php
/**
 * Plugin Name: Resource Rating
 * Description: A plugin to enable resource rating on posts and pages within WordPress
 * Plugin URI: https://github.com/nationalarchives/tna-resource-rating-plugin
 * Version: 0.1.0
 * Author: Annabel Baynes
 * Author URI: https://github.com/Urborging
 * Text Domain: resource-rating-plugin
 */

require "resource-rating-plugin-functionality/resource-rating-plugin-data-submission.php";
require "resource-rating-plugin-functionality/resource-rating-plugin-metaboxes.php";
require "resource-rating-plugin-functionality/resource-rating-plugin-user-view.php";
require "resource-rating-plugin-functionality/resource-rating-plugin-meta.php";
require "resource-rating-plugin-functionality/resource-rating-plugin-functions.php";

register_uninstall_hook(__FILE__, "resource_rating_uninstall");

add_action('save_post', 'resource_rating_save_postdata');
add_action('add_meta_boxes', 'resource_rating_register_metabox' );
add_action("template_redirect", "resource_rating_cookie_setup");
add_action("get_header", "resource_rating_submit_new_rating");

add_action( 'wp_enqueue_scripts', 'enqueue_fontawesome_icons' );
add_action( 'wp_enqueue_scripts', 'enqueue_rating_plugin_stylings' );