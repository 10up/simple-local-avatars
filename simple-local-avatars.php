<?php
/**
 Plugin Name: Simple Local Avatars
 Plugin URI: http://10up.com/plugins/simple-local-avatars-wordpress/
 Description: Adds an avatar upload field to user profiles. Generates requested sizes on demand, just like Gravatar! Simple and lightweight.
 Version: 2.0
 Author: Jake Goldman, 10up
 Author URI: http://10up.com
 License: GPLv2 or later
*/

require_once dirname( __FILE__ ) . '/includes/class-simple-local-avatars.php';
require_once dirname( __FILE__ ) . '/includes/template-tags.php';

$simple_local_avatars = new Simple_Local_Avatars;

/**
 * Upon installation, remove settings and local avatars from WordPress.
 */
function simple_local_avatars_uninstall() {
	$instance = new Simple_Local_Avatars;
	$users    = get_users( array(
		'meta_key' => 'simple_local_avatar',
		'fields'	 => 'ids',
	) );

	foreach ( $users as $user_id ) {
		$instance->avatar_delete( $user_id );
	}

	// Remove settings from the database.
	delete_option( 'simple_local_avatars' );
}
register_uninstall_hook( __FILE__, 'simple_local_avatars_uninstall' );
