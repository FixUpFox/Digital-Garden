<?php
/**
 * Render callback for Search block
 */

namespace DigitalGarden;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function render_search( $attributes, $content ) {
	$page_id     = (int) get_option( 'digital_garden_page_id' );
	$action_url  = $page_id ? get_permalink( $page_id ) : home_url( '/' );
	$search_term = '';

	if ( isset( $_GET['dg_s'] ) ) {
		$search_term = sanitize_text_field( wp_unslash( $_GET['dg_s'] ) );
	}

	$field_id  = wp_unique_id( 'digital-garden-search-field-' );
	$label     = esc_html__( 'Search notes', 'digital-garden' );
	$aria_text = esc_attr__( 'Search notes', 'digital-garden' );
	$placeholder = esc_attr__( 'Search notes…', 'digital-garden' );

	ob_start();
	?>
	<div class="digital-garden-search">
		<form class="digital-garden-search-form" role="search" method="get" action="<?php echo esc_url( $action_url ); ?>">
			<label class="digital-garden-search__label" for="<?php echo esc_attr( $field_id ); ?>">
				<?php echo esc_html( $label ); ?>
			</label>
			<input
				type="search"
				id="<?php echo esc_attr( $field_id ); ?>"
				name="dg_s"
				class="digital-garden-search__field"
				value="<?php echo esc_attr( $search_term ); ?>"
				placeholder="<?php echo esc_attr( $placeholder ); ?>"
				aria-label="<?php echo esc_attr( $aria_text ); ?>"
			/>
			<span class="digital-garden-search__icon" aria-hidden="true"></span>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
