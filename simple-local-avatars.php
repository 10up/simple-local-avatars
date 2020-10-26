<?php
/**
 * Plugin Name:       Simple Local Avatars
 * Plugin URI:        https://10up.com/plugins/simple-local-avatars-wordpress/
 * Description:       Adds an avatar upload field to user profiles. Generates requested sizes on demand, just like Gravatar! Simple and lightweight.
 * Version:           2.2.0
 * Requires at least: 4.6
 * Requires PHP:      5.3
 * Author:            Jake Goldman, 10up
 * Author URI:        https://10up.com
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-local-avatars
 */

require_once dirname( __FILE__ ) . '/includes/class-simple-local-avatars.php';

/**
 * Init the plugin.
 */
global $simple_local_avatars;
$simple_local_avatars = new Simple_Local_Avatars();

/**
 * More efficient to call simple local avatar directly in theme and avoid
 * gravatar setup.
 *
 * Since 2.2, This function is only a proxy for get_avatar due to internal changes.
 *
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @param int               $size        Size of the avatar image
 * @param string            $default     URL to a default image to use if no avatar is available
 * @param string            $alt         Alternate text to use in image tag. Defaults to blank
 * @param array             $args        Optional. Extra arguments to retrieve the avatar.
 *
 * @return string <img> tag for the user's avatar
 */
function get_simple_local_avatar( $id_or_email, $size = 96, $default = '', $alt = '', $args = array() ) {
	return apply_filters( 'simple_local_avatar', get_avatar( $id_or_email, $size, $default, $alt, $args ) );
}

register_uninstall_hook( __FILE__, 'simple_local_avatars_uninstall' );
/**
 * On uninstallation, remove the custom field from the users and delete the local avatars
 */
function simple_local_avatars_uninstall() {
	$simple_local_avatars = new Simple_Local_Avatars();
	$users                = get_users(
		array(
			'meta_key' => 'simple_local_avatar',
			'fields'   => 'ids',
		)
	);

	foreach ( $users as $user_id ) :
		$simple_local_avatars->avatar_delete( $user_id );
	endforeach;

	delete_option( 'simple_local_avatars' );
}
