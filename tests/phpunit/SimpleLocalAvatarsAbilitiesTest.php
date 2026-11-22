<?php

if ( ! class_exists( 'WP_Error' ) ) {
	/**
	 * Minimal WP_Error stand-in for unit tests.
	 */
	class WP_Error {
		public $code;
		public $message;
		public $data;

		public function __construct( $code = '', $message = '', $data = '' ) {
			$this->code    = $code;
			$this->message = $message;
			$this->data    = $data;
		}

		public function get_error_code() {
			return $this->code;
		}
	}
}

class SimpleLocalAvatarsAbilitiesTest extends \WP_Mock\Tools\TestCase {
	/**
	 * Mocked main plugin instance.
	 *
	 * @var \Mockery\MockInterface|Simple_Local_Avatars
	 */
	private $plugin;

	/**
	 * Instance under test.
	 *
	 * @var Simple_Local_Avatars_Abilities
	 */
	private $abilities;

	public function setUp(): void {
		\WP_Mock::setUp();

		$this->plugin    = Mockery::mock( 'Simple_Local_Avatars' );
		$this->abilities = new Simple_Local_Avatars_Abilities( $this->plugin );

		$this->plugin->shouldReceive( 'get_avatar_ratings' )->andReturn(
			array(
				'G'  => 'G',
				'PG' => 'PG',
				'R'  => 'R',
				'X'  => 'X',
			)
		);

		WP_Mock::userFunction( 'is_wp_error' )->andReturnUsing(
			function ( $thing ) {
				return $thing instanceof WP_Error;
			}
		);
		WP_Mock::userFunction( 'absint' )->andReturnUsing(
			function ( $value ) {
				return abs( (int) $value );
			}
		);
		WP_Mock::userFunction( 'get_current_user_id' )->andReturn( 1 );
		WP_Mock::passthruFunction( '__' );
	}

	public function tearDown(): void {
		$this->addToAssertionCount(
			Mockery::getContainer()->mockery_getExpectationCount()
		);
		\WP_Mock::tearDown();
	}

	public function test_add_hooks() {
		WP_Mock::expectActionAdded( 'wp_abilities_api_categories_init', array( $this->abilities, 'register_category' ) );
		WP_Mock::expectActionAdded( 'wp_abilities_api_init', array( $this->abilities, 'register_abilities' ) );

		WP_Mock::userFunction( 'wp_register_ability' );

		$this->abilities->add_hooks();
	}

	public function test_can_query_own_avatar() {
		WP_Mock::userFunction( 'is_user_logged_in' )->andReturn( true );

		$this->assertTrue( $this->abilities->can_query_avatars( array( 'user_id' => 1 ) ) );
	}

	public function test_cannot_query_other_avatar_without_capability() {
		WP_Mock::userFunction( 'is_user_logged_in' )->andReturn( true );
		WP_Mock::userFunction( 'current_user_can' )->andReturn( false );

		$this->assertFalse( $this->abilities->can_query_avatars( array( 'user_id' => 2 ) ) );
	}

	public function test_query_without_user_id_requires_list_users() {
		WP_Mock::userFunction( 'is_user_logged_in' )->andReturn( true );
		WP_Mock::userFunction( 'current_user_can' )->with( 'list_users' )->andReturn( false, true );

		$this->assertFalse( $this->abilities->can_query_avatars( array() ) );
		$this->assertTrue( $this->abilities->can_query_avatars( array() ) );
	}

	public function test_cannot_query_avatars_when_logged_out() {
		WP_Mock::userFunction( 'is_user_logged_in' )->andReturn( false );

		$this->assertFalse( $this->abilities->can_query_avatars( array( 'user_id' => 1 ) ) );
	}

	public function test_can_update_avatar_requires_upload_files() {
		WP_Mock::userFunction( 'current_user_can' )->with( 'upload_files' )->andReturn( false );
		WP_Mock::userFunction( 'current_user_can' )->with( 'edit_user', 2 )->andReturn( true );

		$this->assertFalse( $this->abilities->can_update_avatar( array( 'user_id' => 2 ) ) );
	}

	public function test_can_delete_avatar_checks_edit_user() {
		WP_Mock::userFunction( 'current_user_can' )->with( 'edit_user', 2 )->andReturn( true );

		$this->assertTrue( $this->abilities->can_delete_avatar( array( 'user_id' => 2 ) ) );
	}

	public function test_delete_avatar_removes_existing_avatar() {
		WP_Mock::userFunction( 'get_userdata' )->with( 1 )->andReturn( (object) array( 'ID' => 1 ) );

		$this->plugin->shouldReceive( 'get_user_local_avatar' )->with( 1 )->andReturn( array( 'full' => 'https://example.com/a.png' ) );
		$this->plugin->shouldReceive( 'avatar_delete' )->once()->with( 1 );

		$this->assertSame(
			array(
				'user_id' => 1,
				'deleted' => true,
			),
			$this->abilities->execute_delete_avatar( array() )
		);
	}

	public function test_delete_avatar_is_noop_without_avatar() {
		WP_Mock::userFunction( 'get_userdata' )->with( 1 )->andReturn( (object) array( 'ID' => 1 ) );

		$this->plugin->shouldReceive( 'get_user_local_avatar' )->with( 1 )->andReturn( array() );
		$this->plugin->shouldNotReceive( 'avatar_delete' );

		$this->assertSame(
			array(
				'user_id' => 1,
				'deleted' => false,
			),
			$this->abilities->execute_delete_avatar( array() )
		);
	}

	public function test_query_avatars_rejects_unknown_user() {
		WP_Mock::userFunction( 'get_userdata' )->with( 99 )->andReturn( false );

		$result = $this->abilities->execute_query_avatars( array( 'user_id' => 99 ) );

		$this->assertInstanceOf( WP_Error::class, $result );
		$this->assertSame( 'simple_local_avatars_invalid_user', $result->get_error_code() );
	}

	public function test_query_avatars_returns_one_user() {
		WP_Mock::userFunction( 'get_userdata' )->with( 2 )->andReturn( (object) array( 'ID' => 2 ) );
		WP_Mock::userFunction( 'get_avatar_url' )->with( 2, array( 'size' => 48 ) )->andReturn( 'https://example.com/fallback.png' );

		$this->plugin->shouldReceive( 'get_user_local_avatar' )->with( 2 )->andReturn( array() );
		$this->plugin->shouldReceive( 'get_simple_local_avatar_alt' )->with( 2 )->andReturn( '' );

		$result = $this->abilities->execute_query_avatars(
			array(
				'user_id' => 2,
				'size'    => 48,
			)
		);

		$this->assertSame( 1, $result['total'] );
		$this->assertSame( 1, $result['total_pages'] );
		$this->assertCount( 1, $result['avatars'] );
		$this->assertSame( 2, $result['avatars'][0]['user_id'] );
		$this->assertFalse( $result['avatars'][0]['has_local_avatar'] );
		$this->assertSame( 'https://example.com/fallback.png', $result['avatars'][0]['avatar_url'] );
		$this->assertSame( 48, $result['avatars'][0]['size'] );
	}

	public function test_update_avatar_rejects_non_image() {
		WP_Mock::userFunction( 'get_userdata' )->with( 1 )->andReturn( (object) array( 'ID' => 1 ) );
		WP_Mock::userFunction( 'get_post' )->with( 5 )->andReturn( (object) array( 'post_type' => 'attachment' ) );
		WP_Mock::userFunction( 'wp_attachment_is_image' )->andReturn( false );

		$this->plugin->shouldNotReceive( 'assign_new_user_avatar' );

		$result = $this->abilities->execute_update_avatar( array( 'media_id' => 5 ) );

		$this->assertInstanceOf( WP_Error::class, $result );
		$this->assertSame( 'simple_local_avatars_invalid_media', $result->get_error_code() );
	}
}
