<?php

class SimpleLocalAvatarsNetworkTest extends \WP_Mock\Tools\TestCase {
	private $instance;

	public function setUp(): void {
		parent::setUp();

		$this->instance = Mockery::mock( 'Simple_Local_Avatars' )->makePartial();

		// Set class properties
		$reflection      = new ReflectionClass( 'Simple_Local_Avatars' );
		$user_property   = $reflection->getProperty( 'user_key' );
		$rating_property = $reflection->getProperty( 'rating_key' );

		$user_property->setAccessible( true );
		$user_property->setValue( $this->instance, 'simple_local_avatar' );
		$rating_property->setAccessible( true );
		$rating_property->setValue( $this->instance, 'simple_local_avatar_rating' );
	}

	public function tearDown(): void {
		$this->addToAssertionCount(
			Mockery::getContainer()->mockery_getExpectationCount()
		);
		parent::tearDown();
	}

	public function test_is_network() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'active_sitewide_plugins', [] ],
			'return' => [ 'simple-local-avatars/simple-local-avatars.php' => 'plugin' ],
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'is_multisite', [
			'return' => true,
			'times'  => 1,
		] );

		$this->assertTrue( $this->instance->is_network( 'simple-local-avatars/simple-local-avatars.php' ) );
	}

	public function test_get_network_mode() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'            => [ 'simple_local_avatars_mode', 'default' ],
			'return_in_order' => [ 'default', 'enforce' ],
			'times'           => 2,
		] );

		$mode = $this->instance->get_network_mode();
		$this->assertEquals( 'default', $mode );

		$mode = $this->instance->get_network_mode();
		$this->assertEquals( 'enforce', $mode );
	}

	public function test_is_enforced() {
		WP_Mock::userFunction( 'is_network_admin', [
			'return' => false,
			'times'  => 1,
		] );

		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'enforce',
			'times'  => 1,
		] );

		WP_Mock::userFunction( 'is_network_admin', [
			'return' => true,
			'times'  => 1,
		] );

		$this->assertTrue( $this->instance->is_enforced() );
		$this->assertFalse( $this->instance->is_enforced() );
	}

	public function test_is_avatar_shared() {
		WP_Mock::userFunction( 'is_multisite', [
			'return' => true,
			'times'  => 3,
		] );

		$reflection       = new ReflectionClass( 'Simple_Local_Avatars' );
		$options_property = $reflection->getProperty( 'options' );
		$options_property->setAccessible( true );
		$options_property->setValue( $this->instance, [ 'shared' => 1 ] ); // Test if option is on

		$this->assertTrue( $this->instance->is_avatar_shared() );

		$options_property->setValue( $this->instance, [] ); // Test if option doesn't exist
		$this->assertTrue( $this->instance->is_avatar_shared() );

		$options_property->setValue( $this->instance, [ 'shared' => 0 ] ); // Test if option is off
		$this->assertFalse( $this->instance->is_avatar_shared() );
	}

	public function test_get_simple_local_avatar_url() {
		WP_Mock::userFunction( 'get_user_meta', [
			'args'   => [ 1, 'simple_local_avatar', true ],
			'return' => [
				'media_id' => 101,
				'full'     => 'https://example.com/avatar.png',
				'96'       => 'https://example.com/avatar-96x96.png',
			],
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_user_meta', [
			'args'   => [ Mockery::type( 'numeric' ), 'simple_local_avatar_rating', true ],
			'return' => 'G',
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'is_multisite', [
			'return' => true,
			'times'  => 2,
		] );
		WP_Mock::userFunction( 'switch_to_blog', [
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_main_site_id', [
			'return' => 1,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'restore_current_blog', [
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_attached_file', [
			'args'   => [ 101 ],
			'return' => '/avatar.png',
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_option' )
		       ->with( 'avatar_rating' )
		       ->andReturn( false );

		$reflection       = new ReflectionClass( 'Simple_Local_Avatars' );
		$options_property = $reflection->getProperty( 'options' );
		$options_property->setAccessible( true );
		$options_property->setValue( $this->instance, [ 'shared' => 1 ] );

		$this->assertEquals( 'https://example.com/avatar-96x96.png', $this->instance->get_simple_local_avatar_url( 1, 96 ) );
	}

	public function test_admin_init() {
		WP_Mock::userFunction( 'get_option' )
			->with( 'simple_local_avatars_caps' )
			->andReturn( false );

		WP_Mock::userFunction( 'register_setting' );
		WP_Mock::userFunction( 'add_settings_field' );
		WP_Mock::expectActionAdded( 'load-options-discussion.php', [ $this->instance, 'load_discussion_page' ] );
		WP_Mock::userFunction( 'is_network_admin', [
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::expectActionAdded( 'load-settings.php', [ $this->instance, 'load_network_settings' ] );

		$this->instance->admin_init();
	}

	public function test_load_network_settings() {
		WP_Mock::expectActionAdded( 'wpmu_options', [ $this->instance, 'show_network_settings' ] );
		WP_Mock::expectActionAdded( 'update_wpmu_options', [ $this->instance, 'save_network_settings' ] );

		$this->instance->load_network_settings();
	}

	public function test_sanitize_options() {
		WP_Mock::userFunction( 'is_multisite', [
			'return' => true,
			'times'  => 1,
		] );

		$input = [
			'shared' => true,
		];

		$new_input = $this->instance->sanitize_options( $input );

		$this->assertArrayHasKey( 'caps', $new_input );
		$this->assertArrayHasKey( 'only', $new_input );
		$this->assertArrayHasKey( 'shared', $new_input );

		$this->assertSame( 0, $new_input['caps'] );
		$this->assertSame( 0, $new_input['only'] );
		$this->assertSame( 1, $new_input['shared'] );
	}

	public function test_pre_option_simple_local_avatars() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'enforce',
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars', [] ],
			'return' => [],
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'default',
			'times'  => 1,
		] );

		$this->assertSame( [], $this->instance->pre_option_simple_local_avatars( false ) );
		$this->assertFalse( $this->instance->pre_option_simple_local_avatars( false ) );
	}

	public function test_set_defaults() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'default',
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'switch_to_blog', [
			'args'   => [ 2 ],
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'update_option', [
			'args'   => [ 'simple_local_avatars', [ 'caps' => 0, 'only' => 0, 'shared' => 0 ] ],
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'is_multisite', [
			'return' => true,
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'restore_current_blog', [
			'return' => true,
			'times'  => 1,
		] );

		$this->instance->set_defaults( 2 );
	}

	public function test_admin_body_class() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'enforce',
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'simple_local_avatars_mode', 'default' ],
			'return' => 'default',
			'times'  => 1,
		] );

		$this->assertSame( ' sla-enforced', $this->instance->admin_body_class( '' ) );
		$this->assertSame( '', $this->instance->admin_body_class( '' ) );
	}
}
