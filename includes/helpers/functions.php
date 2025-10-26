<?php
/**
 * Helper function to convert 'var:preset|' values to CSS variable format.
 *
 * This function replaces 'var:preset|' with 'var(--wp--preset--' and '|' with '--'
 * to ensure compatibility with WordPress CSS variable presets.
 *
 * @param string $value The input value to convert.
 * @return string The converted CSS variable string.
 */
function convert_to_css_var( $value ) {
	if ( strpos( $value, 'var:preset|' ) !== false ) {
		// Replace 'var:preset|' with 'var(--wp--preset--' and '|' with '--'
		return 'var(--wp--preset--' . str_replace( '|', '--', substr( $value, strlen( 'var:preset|' ) ) ) . ')';
	}
	return $value;
}
