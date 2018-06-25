<?php
//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Returns all of the resource ratings present on a post (identified by the post id sent through as a parameter).
 *
 * @param $post_id
 *
 * @return mixed
 */
function get_the_resource_ratings ($post_id) {
	return get_post_meta($post_id, "resource_ratings");
}

/**
 * Description: Adds a new rating to a post if it is a valid integer (post id and rating passed as parameters).
 *
 * @param $post_id
 * @param $rating_value
 */
function submit_new_resource_rating ($post_id, $rating_value) {
	if (filter_var($rating_value, FILTER_VALIDATE_INT)) {
		add_post_meta( $post_id, "resource_ratings",$rating_value, false );
	}
}

/**
 * Description: Deletes all resource ratings present on a post (identified by the post id sent through as a parameter).
 *
 * @param $post_id
 */
function delete_all_resource_ratings ($post_id) {
	delete_post_meta($post_id, "resource_ratings");
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Updates the current ratings status on a post to be enabled/disabled (identified by the post id and string sent through as a parameter).
 *
 * @param $post_id
 * @param $status
 */
function toggle_resource_ratings_status ($post_id, $status) {
	update_post_meta($post_id, "_resource_rating_status", $status);
}

/**
 * Description: Returns the current ratings status (enabled/disabled) on a post (identified by the post id sent through as a parameter).
 *
 * @param $post_id
 *
 * @return mixed
 */
function get_the_resource_ratings_status ($post_id) {
	return get_post_meta($post_id, "_resource_rating_status")[0];
}

/**
 * Description: Returns true if ratings are enabled on the post, and false if not
 *
 * @param $post_id
 *
 * @return bool
 */
function post_has_ratings_enabled ($post_id) {
	return get_the_resource_ratings_status($post_id) == "enabled";
}

/**
 * Description: Deletes all resource ratings statuses present on a post (identified by the post id sent through as a parameter).
 *
 * @param $post_id
 */
function delete_all_resource_rating_statuses ($post_id) {
	delete_post_meta($post_id, "_resource_rating_status");
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Returns a concatenated string of the post id and it's corresponding rating (with a hyphen as a delimiter)
 *
 * @param $post_id
 * @param $rating
 *
 * @return string
 */
function encode_ratings_cookie ($post_id, $rating) {
	return $post_id . "," . $rating ;
}

/**
 * Description: Returns an array containing the post id and it's corresponding rating, having been exploded from the cookie's value string passed to it (with a hyphen as a delimiter)
 *
 * @param $cookie_value
 *
 * @return array
 */
function decode_ratings_cookie ($cookie_value) {
	$pieces = explode(",", $cookie_value);
	return array( "post-id" => $pieces[0], "resource-rating" => $pieces[1]);
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Calculates and returns the current sum total of resource ratings.
 *
 * @param $ratings
 *
 * @return float|int
 */
function calculate_resource_rating_sum ($ratings) {
	return array_sum($ratings);
}

/**
 * Description: Calculates and returns the current overall number of resource ratings.
 *
 * @param $ratings
 *
 * @return int
 */
function calculate_resource_rating_frequency ($ratings) {
	return count( $ratings );
}

/**
 * Description: Calculates and returns the current resource rating average.
 *
 * @param $ratings
 *
 * @return float|int
 */
function calculate_resource_rating_average ($ratings) {
	$sum = calculate_resource_rating_sum($ratings);
	$freq = calculate_resource_rating_frequency($ratings);
	return ( $sum > 0 && $freq > 0 ) ? round($sum / $freq, 2) : 0;
}