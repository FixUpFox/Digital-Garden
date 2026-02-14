<?php
/**
 * Integration tests for plugin bootstrap and WordPress registrations.
 */
class Digital_Garden_Integration_Test extends WP_UnitTestCase {

	public function test_plugin_constants_are_defined() {
		$this->assertTrue( defined( 'DIGITAL_GARDEN_VERSION' ) );
		$this->assertTrue( defined( 'DIGITAL_GARDEN_PLUGIN_URL' ) );
		$this->assertTrue( defined( 'DIGITAL_GARDEN_PLUGIN_PATH' ) );
	}

	public function test_note_post_type_is_registered() {
		$this->assertTrue( post_type_exists( 'note' ) );

		$post_type = get_post_type_object( 'note' );
		$this->assertNotNull( $post_type );
		$this->assertTrue( $post_type->public );
		$this->assertTrue( $post_type->show_in_rest );
	}

	public function test_note_tag_taxonomy_is_registered_for_note() {
		$this->assertTrue( taxonomy_exists( 'note_tag' ) );

		$taxonomy = get_taxonomy( 'note_tag' );
		$this->assertNotNull( $taxonomy );
		$this->assertContains( 'note', $taxonomy->object_type );
		$this->assertTrue( $taxonomy->show_in_rest );
	}

	public function test_core_digital_garden_blocks_are_registered() {
		$registry = WP_Block_Type_Registry::get_instance();

		$this->assertTrue( $registry->is_registered( 'digital-garden/container' ) );
		$this->assertTrue( $registry->is_registered( 'digital-garden/note-block' ) );
		$this->assertTrue( $registry->is_registered( 'digital-garden/search' ) );
	}

	public function test_activation_creates_digital_garden_page() {
		delete_option( 'digital_garden_page_id' );

		digital_garden_activate();

		$page_id = (int) get_option( 'digital_garden_page_id' );
		$this->assertGreaterThan( 0, $page_id );

		$page = get_post( $page_id );
		$this->assertNotNull( $page );
		$this->assertSame( 'page', $page->post_type );
		$this->assertSame( 'garden', $page->post_name );
		$this->assertStringContainsString( 'digital-garden/container', $page->post_content );
	}
}
