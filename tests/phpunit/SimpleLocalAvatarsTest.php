<?php

class SimpleLocalAvatarsTest extends \WP_Mock\Tools\TestCase {
	private $instance;

	public function setUp(): void {
		parent::setUp();

		$this->instance = Mockery::mock( 'Simple_Local_Avatars' )->makePartial();

		// Set class properties
		$reflection      = new ReflectionClass( 'Simple_Local_Avatars' );

		$user_property   = $reflection->getProperty( 'user_key' );
		$user_property->setAccessible( true );
		$user_property->setValue( $this->instance, 'simple_local_avatar' );

		$rating_property = $reflection->getProperty( 'rating_key' );
		$rating_property->setAccessible( true );
		$rating_property->setValue( $this->instance, 'simple_local_avatar_rating' );

		$avatar_ratings = $reflection->getProperty( 'avatar_ratings' );
		$avatar_ratings->setAccessible( true );
		$avatar_ratings->setValue( $this->instance, array(
			'G'  => __( 'G &#8212; Suitable for all audiences', 'simple-local-avatars' ),
			'PG' => __( 'PG &#8212; Possibly offensive, usually for audiences 13 and above', 'simple-local-avatars' ),
			'R'  => __( 'R &#8212; Intended for adult audiences above 17', 'simple-local-avatars' ),
			'X'  => __( 'X &#8212; Even more mature than above', 'simple-local-avatars' ),
		) );

		$user = (object) [
			'ID' => 1
		];

		// Init $POST.
		$_POST = array();

		WP_Mock::userFunction( 'get_user_by' )
			->with( 'email', '' )
			->andReturn( false );

		WP_Mock::userFunction( 'get_user_by' )
			->with( 'email', Mockery::type( 'string' ) )
			->andReturn( $user );

		WP_Mock::userFunction( 'get_user_meta' )
			->with( 1, 'simple_local_avatar', true )
			->andReturn( [
				'media_id' => 101,
				'full'     => 'https://example.com/avatar.png',
				'96'       => 'https://example.com/avatar-96x96.png',
			] )
			->byDefault();

		WP_Mock::userFunction( 'get_user_meta' )
			->with( Mockery::type( 'numeric' ), 'simple_local_avatar_rating', true )
			->andReturn( 'G' );

		WP_Mock::userFunction( 'get_attached_file' )
			->with( 101 )
			->andReturn( '/avatar.png' );

		WP_Mock::userFunction( 'admin_url' )
			->with( 'options-discussion.php' )
			->andReturn( 'wp-admin/options-discussion.php' );

	}

	public function tearDown(): void {
		$this->addToAssertionCount(
			Mockery::getContainer()->mockery_getExpectationCount()
		);
		parent::tearDown();
	}

	public function test_add_hooks() {
		WP_Mock::expectFilterAdded( 'plugin_action_links_' . SLA_PLUGIN_BASENAME, [ $this->instance, 'plugin_filter_action_links'] );

		WP_Mock::expectFilterAdded( 'pre_get_avatar_data', [ $this->instance, 'get_avatar_data'], 10, 2 );
		WP_Mock::expectFilterAdded( 'pre_option_simple_local_avatars', [ $this->instance, 'pre_option_simple_local_avatars' ], 10, 1 );

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
		WP_Mock::expectActionAdded( 'wpmu_new_blog', [ $this->instance, 'set_defaults' ] );

		$this->instance->add_hooks();
	}

	public function test_is_network() {
		WP_Mock::userFunction( 'get_site_option', [
			'args'   => [ 'active_sitewide_plugins', [] ],
			'return' => [],
			'times'  => 1,
		] );
		WP_Mock::userFunction( 'is_multisite', [
			'return' => false,
			'times'  => 1,
		] );

		$this->assertFalse( $this->instance->is_network( 'simple-local-avatars/simple-local-avatars.php' ) );
	}

	public function test_get_network_mode() {
		$mode = $this->instance->get_network_mode();
		$this->assertEquals( 'default', $mode );
	}

	public function test_is_enforced() {
		WP_Mock::userFunction( 'is_network_admin', [
			'return' => false,
			'times'  => 1,
		] );
		$this->assertFalse( false, $this->instance->is_enforced() );
	}

	public function test_is_avatar_shared() {
		WP_Mock::userFunction( 'is_multisite', [
			'return' => false,
			'times'  => 1,
		] );
		$this->assertFalse( false, $this->instance->is_avatar_shared() );
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

	public function test_plugin_filter_action_links() {
		$action_links = $this->instance->plugin_filter_action_links( false );

		$this->assertFalse( $action_links );

		$action_links = $this->instance->plugin_filter_action_links( [] );

		$this->assertNotEmpty( $action_links );

		$this->assertArrayHasKey( 'settings', $action_links );
		$this->assertContains( 'options-discussion.php', $action_links['settings'] );
	}

	public function test_get_avatar_data() {
			$avatar_data = $this->instance->get_avatar_data( [ 'size' => 96 ], 1 );
			$this->assertEquals( 'https://example.com/avatar-96x96.png', $avatar_data['url'] );
	}

	public function test_get_simple_local_avatar_url_with_empty_id() {
		$this->assertEmpty( $this->instance->get_simple_local_avatar_url( '', 96 ) );
	}

	public function test_get_simple_local_avatar_url_user_with_no_avatar() {
		WP_Mock::userFunction( 'get_user_meta' )
			->with( 2, 'simple_local_avatar', true )
			->andReturn( [] );
		$this->assertEquals( '', $this->instance->get_simple_local_avatar_url( 2, 96 ) );
	}

	public function test_get_simple_local_avatar_url_media_file_deleted() {
		WP_Mock::userFunction( 'get_user_meta' )
			->with( 2, 'simple_local_avatar', true )
			->andReturn( ['media_id' => 102 ] );
		WP_Mock::userFunction( 'get_attached_file' )
			->with( 102 )
			->andReturn( false );
		$this->assertEquals( '', $this->instance->get_simple_local_avatar_url( 2, 96 ) );
	}

	public function test_get_simple_local_avatar_url() {
		$this->assertEquals( 'https://example.com/avatar-96x96.png', $this->instance->get_simple_local_avatar_url( 1, 96 ) );
	}

	public function test_admin_init() {
		WP_Mock::userFunction( 'get_option' )
			->with( 'simple_local_avatars_caps' )
			->andReturn( false );

		WP_Mock::userFunction( 'register_setting' );
		WP_Mock::userFunction( 'add_settings_field' );
		WP_Mock::expectActionAdded( 'load-options-discussion.php', [ $this->instance, 'load_discussion_page' ] );

		$this->instance->admin_init();
	}

	public function test_load_discussion_page() {
		WP_Mock::expectActionAdded( 'admin_print_styles', [ $this->instance, 'admin_print_styles' ] );
		WP_Mock::expectFilterAdded( 'admin_body_class', [ $this->instance, 'admin_body_class' ] );

		$this->instance->load_discussion_page();
	}

	public function test_admin_enqueue_scripts_wrong_screen() {
		WP_Mock::userFunction( 'current_user_can' )->never();
		$this->instance->admin_enqueue_scripts( 'index.php' );
	}

	public function test_sanitize_options() {
		$input = [
			'caps' => true,
		];
		$new_input = $this->instance->sanitize_options( $input );
		$this->assertArrayHasKey( 'caps', $new_input );
		$this->assertArrayHasKey( 'only', $new_input );
		$this->assertSame( 1, $new_input['caps'] );
		$this->assertSame( 0, $new_input['only'] );
	}

	public function test_get_default_avatar_url() {
		WP_Mock::userFunction( 'get_option' )
		       ->with( 'avatar_default' )
		       ->andReturn( '' );

		WP_Mock::userFunction( 'is_ssl' )
		       ->andReturn( true );

		$size         = 90;
		$returned_url = $this->instance->get_default_avatar_url( $size );
		$expected_url = 'https://secure.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=90';
		$this->assertEquals( $expected_url, $returned_url );
	}

	public function test_avatar_settings_field() {
		$args = array(
			'key'     => 'shared',
			'desc'    => 'This is a description.',
			'default' => 0,
		);

		WP_Mock::userFunction( 'wp_parse_args' )
		       ->with( $args,
			       array(
				       'key'     => '',
				       'desc'    => '',
				       'default' => 0,
			       ) )
		       ->andReturn( $args );

		WP_Mock::userFunction( 'checked' )
		       ->andReturn( 'checked' );

		$expected = '<label for="simple-local-avatars-shared"><input type="checkbox" name="simple_local_avatars[shared]" id="simple-local-avatars-shared" value="1" checked />This is a description.</label>';

		$this->expectOutputString( $expected );

		$this->instance->avatar_settings_field( $args );
	}

	public function test_edit_user_profile() {

		WP_Mock::userFunction( 'remove_filter' );
		WP_Mock::userFunction( 'wp_nonce_field' );
		WP_Mock::userFunction( 'add_query_arg' );
		WP_Mock::userFunction( 'disabled' );

		WP_Mock::userFunction( 'get_simple_local_avatar' )
		       ->with( 1 )
		       ->andReturn( '<img src="test-image-user-avatar"/>' );

		$profileuser     = new stdClass();
		$profileuser->ID = 1;

		$expected = '<div id="simple-local-avatar-section"><h3>Avatar</h3><table class="form-table"><tr class="upload-avatar-row"><th scope="row"><label for="simple-local-avatar">Upload Avatar</label></th><td style="width: 50px;" id="simple-local-avatar-photo"><img src="test-image-user-avatar"/></td><td><p style="display: inline-block; width: 26em;"><span class="description">Choose an image from your computer:</span><br /><input type="file" name="simple-local-avatar" id="simple-local-avatar" class="standard-text" /><span class="spinner" id="simple-local-avatar-spinner"></span></p><p><a href="" class="button item-delete submitdelete deletion" id="simple-local-avatar-remove"  style="display:none;">Delete local avatar</a></p></td></tr><tr class="ratings-row"><th scope="row">Rating</th><td colspan="2"><fieldset id="simple-local-avatar-ratings" ><legend class="screen-reader-text"><span>Rating</span></legend><label><input type=\'radio\' name=\'simple_local_avatar_rating\' value=\'G\' />G &#8212; Suitable for all audiences</label><br /><label><input type=\'radio\' name=\'simple_local_avatar_rating\' value=\'PG\' />PG &#8212; Possibly offensive, usually for audiences 13 and above</label><br /><label><input type=\'radio\' name=\'simple_local_avatar_rating\' value=\'R\' />R &#8212; Intended for adult audiences above 17</label><br /><label><input type=\'radio\' name=\'simple_local_avatar_rating\' value=\'X\' />X &#8212; Even more mature than above</label><br /><p class="description">If the local avatar is inappropriate for this site, Gravatar will be attempted.</p></fieldset></td></tr></table></div>';

		$this->expectOutputString( $expected );

		$this->instance->edit_user_profile( $profileuser );
	}

	public function test_assign_new_user_avatar() {
		$user_id         = 1;
		$url_or_media_id = 0;

		$meta_value = array(
			'media_id' => 0,
			'full'     => '/full_url',
			'blog_id'  => 101,
		);

		WP_Mock::userFunction( 'wp_upload_dir' )
		       ->andReturn( array(
			       'baseurl' => '/example',
			       'basedir' => '/example_dir',
		       ) );

		WP_Mock::userFunction( 'delete_user_meta' )
		       ->andReturn( true );

		WP_Mock::userFunction( 'wp_get_attachment_url' )
		       ->with( $url_or_media_id )
		       ->andReturn( $meta_value['full'] );

		WP_Mock::userFunction( 'get_current_blog_id' )
		       ->andReturn( $meta_value['blog_id'] );

		WP_Mock::userFunction( 'update_user_meta' )
		       ->with( $user_id, 'simple_local_avatar', $meta_value )
		       ->andReturn( 101 );

		$this->instance->assign_new_user_avatar( $url_or_media_id, $user_id );
	}

	public function test_edit_user_profile_update() {
		$user_id = 1;

		$_POST['simple_local_avatar_rating'] = '';
		$_POST['_simple_local_avatar_nonce'] = 'not empty';

		WP_Mock::userFunction( 'wp_verify_nonce' )
		       ->with( $_POST['_simple_local_avatar_nonce'], 'simple_local_avatar_nonce' )
		       ->andReturn( true );

		WP_Mock::userFunction( 'update_user_meta' )
		       ->with( $user_id, 'simple_local_avatar_rating', 'G' )
		       ->andReturn( true );

		$this->instance->edit_user_profile_update( $user_id );
	}

	public function test_action_remove_simple_local_avatar() {
		$_GET['user_id']  = 1;
		$_GET['_wpnonce'] = 1;

		WP_Mock::userFunction( 'wp_verify_nonce' )
		       ->with( $_GET['_wpnonce'], 'remove_simple_local_avatar_nonce' )
		       ->andReturn( true );

		WP_Mock::userFunction( 'wp_upload_dir' )
		       ->andReturn( array(
			       'baseurl' => '/example',
			       'basedir' => '/example_dir',
		       ) );

		WP_Mock::userFunction( 'current_user_can' )
		       ->with( 'edit_user', $_GET['user_id'] )
		       ->andReturn( true );

		$this->instance->action_remove_simple_local_avatar();
	}

	public function test_unique_filename_callback() {
		$dir                = '/test_dir';
		$ext                = '.ext';
		$expected_file_name = 'SLA_FILE';

		WP_Mock::userFunction( 'sanitize_file_name' )
		       ->with( 'TEST_USER_avatar_' . time() )
		       ->andReturn( $expected_file_name );

		$name = $this->instance->unique_filename_callback( $dir, '', $ext );
		$this->assertEquals( $expected_file_name . $ext, $name );
	}

	public function test_user_edit_form_tag() {
		ob_start();
		$this->instance->user_edit_form_tag();
		$output = ob_get_clean();
		$this->assertEquals( 'enctype="multipart/form-data"', $output );
	}

	public function test_upload_size_limit() {
		WP_Mock::onFilter( 'simple_local_avatars_upload_limit' )
			->with( 2048 )
			->reply( 4096 );
		$this->assertEquals( 4096, $this->instance->upload_size_limit( 2048 ) );
	}

	public function test_avatar_delete() {
		WP_Mock::userFunction( 'get_user_meta' )
			->with( 1, 'simple_local_avatar', true )
			->andReturn( [] );

		WP_Mock::userFunction( 'delete_user_meta' )
			->never();

		$this->instance->avatar_delete( 1 );
	}
}
