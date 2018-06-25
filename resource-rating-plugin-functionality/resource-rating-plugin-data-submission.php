<?php

global $new_rating_submitted;
$new_rating_submitted = false;

/**
 * Description: Creates a cookie if the user has submitted a rating for a post, and if that specific cookie is not set for that user yet.
 */
function resource_rating_cookie_setup () {
	global $new_rating_submitted;
	if (array_key_exists("post-id", $_POST) && array_key_exists("resource-rating", $_POST)) {
		if (!isset( $_COOKIE[ "resource-rated-". $_POST["post-id"]] )) {
			$cookie_data = encode_ratings_cookie($_POST["post-id"], $_POST["resource-rating"]);
			setcookie("resource-rated-".$_POST["post-id"], $cookie_data, time() + (86400 * 28), "/" );
			$_COOKIE["resource-rated-".$_POST["post-id"]] = $cookie_data;
			$new_rating_submitted = $_POST["post-id"];
		}
	} else {
		$new_rating_submitted = false;
	}
	$_POST = array();
}

/**
 * Description: Submits a new rating if the user has a cookie present, and the 'new rating submitted' variable is equal to true.
 *              It will then remove that true value after submitting that rating.
 */
function resource_rating_submit_new_rating () {
	global $new_rating_submitted;
	if ($new_rating_submitted !== false && isset( $_COOKIE["resource-rated-" . $new_rating_submitted])) {
		$cookie_data = decode_ratings_cookie($_COOKIE["resource-rated-" . $new_rating_submitted]);
		submit_new_resource_rating( $cookie_data["post-id"], $cookie_data["resource-rating"]);
		$new_rating_submitted = false;
	}
}