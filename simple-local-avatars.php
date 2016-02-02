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
 * on uninstallation, remove the custom field from the users and delete the local avatars
 */

register_uninstall_hook( __FILE__, 'simple_local_avatars_uninstall' );

function simple_local_avatars_uninstall() {
	$simple_local_avatars = new Simple_Local_Avatars;
	$users = get_users(array(
		'meta_key'	=> 'simple_local_avatar',
		'fields'	=> 'ids',
	));

	foreach ( $users as $user_id ):
		$simple_local_avatars->avatar_delete( $user_id );
	endforeach;
	
	delete_option('simple_local_avatars');
}