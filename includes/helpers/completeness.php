<?php

namespace Digital_Garden;

/**
 * @return array
 */
function completeness_list() {
	$completeness = array(
		'seedling'  => __( 'Seedling', 'digital-garden' ),
		'sprout'    => __( 'Sprout', 'digital-garden' ),
		'sapling'   => __( 'Sapling', 'digital-garden' ),
		'evergreen' => __( 'Evergreen', 'digital-garden' ),
	);

	/**
	 * Filter the list of completeness levels.
	 *
	 * The array must be slug => label pairs.
	 */
	return apply_filters( 'digital_garden_completeness_list', $completeness );
}
