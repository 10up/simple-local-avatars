<?php
/**
 * Plugin Name:       Simple Local Avatars
 * Plugin URI:        https://10up.com/plugins/simple-local-avatars-wordpress/
 * Description:       Adds an avatar upload field to user profiles. Generates requested sizes on demand, just like Gravatar! Simple and lightweight.
 * Version:           2.7.11
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            10up
 * Author URI:        https://10up.com
 * License:           GPL-2.0-or-later
 * License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html
 * Text Domain:       simple-local-avatars
 *
 * @package           SimpleLocalAvatars
 */

/**
 * Get the minimum version of PHP required by this plugin.
 *
 * @since 2.7.6
 *
 * @return string Minimum version required.
 */
function minimum_php_requirement() {
	return '7.4';
}

/**
 * Whether PHP installation meets the minimum requirements
 *
 * @since 2.7.6
 *
 * @return bool True if meets minimum requirements, false otherwise.
 */
function site_meets_php_requirements() {
	return version_compare( phpversion(), minimum_php_requirement(), '>=' );
}

// Try to load the plugin files, ensuring our PHP version is met first.
if ( ! site_meets_php_requirements() ) {
	add_action(
		'admin_notices',
		function() {
			?>
			<div class="notice notice-error">
				<p>
					<?php
					echo wp_kses_post(
						sprintf(
						/* translators: %s: Minimum required PHP version */
							__( 'Simple Local Avatars requires PHP version %s or later. Please upgrade PHP or disable the plugin.', 'simple-local-avatars' ),
							esc_html( minimum_php_requirement() )
						)
					);
					?>
				</p>
			</div>
			<?php
		}
	);
	return;
}

define( 'SLA_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once dirname( __FILE__ ) . '/includes/class-simple-local-avatars.php';

// Global constants.
define( 'SLA_VERSION', '2.7.11' );
define( 'SLA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'SLA_IS_NETWORK' ) ) {
	define( 'SLA_IS_NETWORK', Simple_Local_Avatars::is_network( plugin_basename( __FILE__ ) ) );
}

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
	delete_option( 'simple_local_avatars_migrations' );
}
