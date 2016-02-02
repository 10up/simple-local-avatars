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

$simple_local_avatars = new Simple_Local_Avatars;

/**
 * more efficient to call simple local avatar directly in theme and avoid gravatar setup
 *
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @param int $size Size of the avatar image
 * @param string $default URL to a default image to use if no avatar is available
 * @param string $alt Alternate text to use in image tag. Defaults to blank
 * @return string <img> tag for the user's avatar
 */
function get_simple_local_avatar( $id_or_email, $size = 96, $default = '', $alt = '' ) {
	global $simple_local_avatars;
	$avatar = $simple_local_avatars->get_avatar( '', $id_or_email, $size, $default, $alt );
	
	if ( empty ( $avatar ) ) {
		remove_action( 'get_avatar', array( $simple_local_avatars, 'get_avatar' ) );
		$avatar = get_avatar( $id_or_email, $size, $default, $alt );
		add_action( 'get_avatar', array( $simple_local_avatars, 'get_avatar' ) );
	}
	
	return $avatar;
}

if ( ! function_exists( 'get_avatar' ) && ( $simple_local_avatars_options = get_option('simple_local_avatars') ) && ! empty( $simple_local_avatars_options['only'] ) ) :

	/**
	 * Retrieve the avatar for a user who provided a user ID or email address.
	 *
	 * @param int|string|object $id_or_email A user ID,  email address, or comment object
	 * @param int $size Size of the avatar image
	 * @param string $default URL to a default image to use if no avatar is available
	 * @param string $alt Alternative text to use in image tag. Defaults to blank
	 * @return string <img> tag for the user's avatar
	 */
	function get_avatar( $id_or_email, $size = 96, $default = '', $alt = '' ) {
		global $simple_local_avatars;

		if ( ! get_option('show_avatars') )
			return false;

		$safe_alt =  empty( $alt ) ? '' : esc_attr( $alt );

		if ( !is_numeric($size) )
			$size = 96;

		if ( ! $avatar = $simple_local_avatars->get_avatar( '', $id_or_email, $size, $default, $alt ) ) :

			if ( empty($default) ) {
				$avatar_default = get_option('avatar_default');
				if ( empty($avatar_default) )
					$default = 'mystery';
				else
					$default = $avatar_default;
			}

			$host = is_ssl() ? 'https://secure.gravatar.com' : 'http://0.gravatar.com';

			if ( 'mystery' == $default )
				$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
			elseif ( 'blank' == $default )
				$default = includes_url( 'images/blank.gif' );
			elseif ( 'gravatar_default' == $default )
				$default = "$host/avatar/?s={$size}";
			else
				$default = "$host/avatar/?d=$default&amp;s={$size}";

			$avatar = "<img alt='{$safe_alt}' src='" . $default . "' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";

		endif;

		return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
	}

endif;

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