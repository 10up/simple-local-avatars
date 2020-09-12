<?php

class SimpleLocalAvatarsTest extends \WP_Mock\Tools\TestCase {
	private $instance;

	public function setUp(): void {
		$this->instance = Mockery::mock( 'Simple_Local_Avatars' )->makePartial();
		$user           = (object) [
			'ID' => 1
		];

		WP_Mock::userFunction( 'get_user_by' )
			->with( 'email', '' )
			->andReturn( false );

		WP_Mock::userFunction( 'get_user_by' )
			->with( 'email', Mockery::type( 'string' ) )
			->andReturn( $user );

		WP_Mock::userFunction( 'get_user_meta' )
			->with( Mockery::type( 'numeric' ), 'simple_local_avatar', true )
			->andReturn( [
				'full' => 'https://example.com/avatar.png'
			] );
		parent::setUp();
	}

	public function tearDown(): void {
		$this->addToAssertionCount(
			Mockery::getContainer()->mockery_getExpectationCount()
		);
		parent::tearDown();
	}

	public function test_add_hooks() {
		WP_Mock::expectFilterAdded( 'pre_get_avatar_data', [ $this->instance, 'get_avatar_data'], 10, 2 );

		WP_Mock::expectActionAdded( 'admin_init', [ $this->instance, 'admin_init' ] );

		WP_Mock::expectActionAdded( 'admin_enqueue_scripts', [ $this->instance, 'admin_enqueue_scripts' ] );
		WP_Mock::expectActionAdded( 'show_user_profile', [ $this->instance, 'edit_user_profile' ] );
		WP_Mock::expectActionAdded( 'edit_user_profile', [ $this->instance, 'edit_user_profile' ] );

		WP_Mock::expectActionAdded( 'personal_options_update', [ $this->instance, 'edit_user_profile_update' ] );
		WP_Mock::expectActionAdded( 'edit_user_profile_update', [ $this->instance, 'edit_user_profile_update' ] );
		WP_Mock::expectActionAdded( 'admin_action_remove-simple-local-avatar', [ $this->instance, 'action_remove_simple_local_avatar' ] );
		WP_Mock::expectActionAdded( 'wp_ajax_assign_simple_local_avatar_media', [ $this->instance, 'ajax_assign_simple_local_avatar_media' ] );
		WP_Mock::expectActionAdded( 'wp_ajax_remove_simple_local_avatar', [ $this->instance, 'action_remove_simple_local_avatar' ] );
		WP_Mock::expectActionAdded( 'user_edit_form_tag', [ $this->instance, 'user_edit_form_tag' ] );

		WP_Mock::expectActionAdded( 'rest_api_init', [ $this->instance, 'register_rest_fields' ] );
		$this->instance->add_hooks();
	}

	public function test_get_avatar() {
		$img          = '<img src="https://example.com/avatar.png" />';
		$filtered_img = '<img src="https://example.com/avatar-filtered.png" />';
		WP_Mock::userFunction( 'get_avatar')->andReturn( $img );
		WP_Mock::expectFilter( 'simple_local_avatar', $img );

		$this->assertEquals( $img, $this->instance->get_avatar() );

		WP_Mock::onFilter( 'simple_local_avatar' )
			->with( $img )
			->reply( $filtered_img );

		$this->assertEquals( $filtered_img, $this->instance->get_avatar() );
	}

	//public function test_get_avatar_data() {
		
	//}

	public function test_get_simple_local_avatar_url_with_empty_id() {
		$this->assertEmpty( $this->instance->get_simple_local_avatar_url( '', 96 ) );
	}

	public function test_get_simple_local_avatar_url_with_valid_user_id() {
		$this->assertEquals( 'https://example.com/avatar.png', $this->instance->get_simple_local_avatar_url( '1', 96 ) );
	}
}
