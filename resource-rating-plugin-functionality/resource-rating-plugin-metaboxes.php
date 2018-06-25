<?php

/**
 * Description: Registers a metabox for the changing the visibility/status of resource ratings on posts
 */
function resource_rating_register_metabox () {
	add_meta_box(
		"resource_rating_metabox_id",
		"Resource Ratings",
		"resource_rating_metabox_html",
		null,
		"side"
	);
}

/**
 * Description: Displays the html box for the resource rating enable/disable choice.
 *
 * @param $post
 */
function resource_rating_metabox_html ($post) {
	?>
	<div>
		<form>
			<label for="resource_rating_status">Enable ratings for this resource?</label>
			<input type="checkbox" class="postbox" name="resource_rating_status" id="resource_rating_status" value="ratings_enabled"
				<?php if (get_the_resource_ratings_status($post->ID) == "enabled") { echo("checked"); } ?>
			>
		</form>
	</div>
	<?php
}

/**
 * Description: Applies a resource rating status (enabled/disabled) to a post, depending on whether the user/admin has ticked the "resource_rating_status" checkbox.
 *
 * @param $post_id
 */
function resource_rating_save_postdata($post_id) {
	if (array_key_exists("resource_rating_status", $_POST)) {
		toggle_resource_ratings_status($post_id, "enabled");
	} else {
		toggle_resource_ratings_status($post_id, "disabled");
	}
}