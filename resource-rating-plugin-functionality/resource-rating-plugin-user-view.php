<?php

//----------------------------------------------------------------------------------------------------------------------

function display_resource_ratings () {
    global $post;
	if (post_has_ratings_enabled($post->ID)) {
		display_resource_ratings_html(
			[
				"outer_div" => "position-relative separator resource-ratings",
				"heading_div" => "heading-holding-banner",
				"content_div" => "breather"
			]
		);
	}
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Displays the resource rating html, loading the content in via separate functions
 *
 * @param $class_args
 */
function display_resource_ratings_html ($class_args) {
	global $post;
	?>
    <div class="<?php echo $class_args["outer_div"] ?>">
        <div class="<?php echo $class_args["heading_div"] ?>">
            <h2>
                <span>
                    <span>
                        Ratings
                    </span>
                </span>
            </h2>
        </div>
        <div class=" <?php echo $class_args["content_div"] ?>">
            <div id="resource-ratings-voting">
				<?php display_resource_ratings_voting(); ?>
            </div>
            <div id="current-resource-ratings">
				<?php display_current_resource_ratings_value( get_the_resource_ratings( $post->ID ) ); ?>
            </div >

        </div>
    </div>
	<?php
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Description: Decides whether to display the resource rating buttons or a 'thank you' message depending on whether
 *              there is a cookie present which indicates whether the user has already voted on this resource.
 *
 */
function display_resource_ratings_voting () {
	//If the user has a 'resource-rated' cookie set, then do not display them the option to vote again.
	global $post;
	if ( isset( $_COOKIE[ "resource-rated-".$post->ID])) {
		$cookie_data = decode_ratings_cookie($_COOKIE["resource-rated-".$post->ID]);
		display_users_resource_rating_html($cookie_data["resource-rating"]);
	} else {
		display_resource_ratings_form_html();
	}
}


/**
 * Description: Displays the current resource ratings, along with how many people have voted.
 *
 * If there are any ratings present, calculate the sum, frequency, and the averages, then display them; If there are no ratings present, then simply display 0.
 *
 * @param $ratings
 */
function display_current_resource_ratings_value ($ratings) {
	if ( ! empty( $ratings ) ) {
		$sum = calculate_resource_rating_sum($ratings);
		$freq = calculate_resource_rating_frequency($ratings);
		$avg = calculate_resource_rating_average($sum, $freq);
		display_current_resource_ratings_html( $avg, $freq );
	} else {
		display_current_resource_ratings_html( 0, 0 );
	}
}

//---------------------------------------------------------------------------------------------------------------------

/**
 * Description: Displays the resource rating form, with a hidden label containing the current post id.
 *
 */
function display_resource_ratings_form_html () {
	global $wp;
	global $post;
	?>
    <form class="" id="resource-rating-form" action="<?php echo home_url( $wp->request ) ?>" method="post">
        <label for="resource-rating-form"><strong>Rate this resource: </strong></label>
        <input type="hidden" name="post-id" id="post-id" value="<?php echo $post->ID ?>"/>
		<?php for ($i = 1; $i < 6 ; $i++) { ?>
            <input type="submit" name="resource-rating" id="resource-rating-button-<?php echo $i ?>" class="resource-rating-button" value="<?php echo $i ?>"/>
		<?php } ?>
    </form>
	<?php
}

/**
 * Description: Displays the html for the users resource rating out of 5 and a 'thank you' message
 *
 * @param $rating
 */
function display_users_resource_rating_html ($rating) {
	?> <p>Thank you for rating this resource <?php echo $rating ?> out of 5.</p> <?php
}

//---------------------------------------------------------------------------------------------------------------------

/**
 * Description: Displays the html for the current resource ratings, along with how many people have voted.
 *
 * @param $avg
 * @param $freq
 */
function display_current_resource_ratings_html ($avg, $freq) {
	?> <p><strong>Current rating</strong>: <?php number_of_stars_to_display($avg) ; echo " " . $avg . " out of 5 " ?> ( <?php echo $freq ; echo ($freq == 1) ? " person has" : " people have"?> rated this resource)</p> <?php
}

//--------------------

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
 * @param $sum
 * @param $freq
 *
 * @return float|int
 */
function calculate_resource_rating_average ($sum, $freq) {
	return ( $sum > 0 && $freq > 0 ) ? round($sum / $freq, 2) : 0;
}

//--------------------

/**
 * Description: Displays stars for the current number of resource ratings, along with how many people have voted.
 *
 * @param $avg
 */
function number_of_stars_to_display ($avg) {
    $wholes = round($avg, 0, PHP_ROUND_HALF_DOWN);
    $decimals = fmod($avg, 1);
    if ($wholes > $avg ) {$wholes-=1;}
	display_full_stars_html($wholes);
    if ($decimals >= 0.5) {
	    display_half_star_html();
    }
}

/**
 * Description: Displays full stars a defined number of times
 *
 * @param $number_of_times
 */
function display_full_stars_html ($number_of_times) {
	for ($i = 0; $i < $number_of_times; $i++) {
        ?><i class="fas fa-star" style="color:#EBAB00"></i><?php
	}
}

/**
 * Description: Displays a half-star
 */
function display_half_star_html () {
    ?><i class="fas fa-star-half" style="color:#EBAB00"></i><?php
}

//----------------------------------------------------------------------------------------------------------------------

