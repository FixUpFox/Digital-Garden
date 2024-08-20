<?php

namespace Digital_Garden;

function completeness_list() {
	$completeness = array(
		'seedling'  => __( 'Seedling', 'digital-garden' ),
		'sprout'    => __( 'Sprout', 'digital-garden' ),
		'sapling'   => __( 'Sapling', 'digital-garden' ),
		'evergreen' => __( 'Evergreen', 'digital-garden' ),
	);

	$completeness = apply_filters( 'digital_garden_completeness_list', $completeness );

	return $completeness;
}
