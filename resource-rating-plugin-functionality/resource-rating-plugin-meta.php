<?php

function resource_rating_uninstall () {
	$post_ids = get_posts( array(
		'numberposts'   => -1,
		'fields'        => 'ids',
		'post_type'     => get_post_types(array(), "names"),
		'post_status'   => array('publish', 'auto-draft', 'trash', 'pending', 'draft')
	) );

	foreach( $post_ids as $post_id ) {
		delete_all_resource_ratings($post_id);
		delete_all_resource_rating_statuses($post_id);
	}
}

/**
 * Description: Enqueues FontAwesome icons (to display star icons)
 */
function enqueue_fontawesome_icons () {
	global $post;
	wp_register_style('load-fontawesome-icons', 'https://use.fontawesome.com/releases/v5.0.8/css/all.css', false, "5.0.8");
	if (get_the_resource_ratings_status($post->ID) == "enabled") {
		wp_enqueue_style( 'load-fontawesome-icons' );
	}
}

/**
 * Description: Enqueues the stylings for the plugin as a whole
 */
function enqueue_rating_plugin_stylings () {
	global $post;
	wp_register_style('load-resource-rating-plugin-styles', plugin_dir_url(__DIR__) . 'resource-rating-plugin-styles/resource-rating-plugin-styles.css' );
	if (get_the_resource_ratings_status($post->ID) == "enabled") {
		wp_enqueue_style( 'load-resource-rating-plugin-styles' );
	}
}
