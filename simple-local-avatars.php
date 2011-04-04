<?php
/**
 Plugin Name: Simple Local Avatars
 Plugin URI: http://www.get10up.com/plugins/simple-local-avatars-wordpress/
 Description: Adds an avatar upload field to user profiles if the current user has media permissions. Generates requested sizes on demand just like Gravatar! Simple and lightweight.
 Version: 1.2.3
 Author: Jake Goldman (10up), Oomph Inc
 Author URI: http://www.get10up.com

    Plugin: Copyright 2011 10up (email : jake@get10up.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * add field to user profiles
 */
 
class simple_local_avatars 
{
	function simple_local_avatars()
	{
		add_filter( 'get_avatar', array( $this, 'get_avatar' ), 10, 5 );
		
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		
		add_action( 'show_user_profile', array( $this, 'edit_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'edit_user_profile' ) );
		
		add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );
		
		add_filter( 'avatar_defaults', array( $this, 'avatar_defaults' ) );
	}
	
	function get_avatar( $avatar = '', $id_or_email, $size = '96', $default = '', $alt = false )
	{
		if ( is_numeric($id_or_email) ) 
			$user_id = (int) $id_or_email;
		elseif ( is_string($id_or_email) ) 
		{
			if ( $user = get_user_by_email( $id_or_email ) )
				$user_id = $user->ID;	
		} 
		elseif ( is_object($id_or_email) && !empty($id_or_email->user_id) )
			$user_id = (int) $id_or_email->user_id;
		
		if ( !empty($user_id) )
			$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		
		if ( !isset($local_avatars) || empty($local_avatars) || !isset($local_avatars['full']) ) 
		{
			if ( !empty($avatar) ) 	// if called by filter
				return $avatar;
			
			remove_filter( 'get_avatar', 'get_simple_local_avatar' );
			$avatar = get_avatar( $id_or_email, $size, $default );
			add_filter( 'get_avatar', 'get_simple_local_avatar', 10, 5 );
			return $avatar;
		}
		
		if ( !is_numeric($size) )		// ensure valid size
			$size = '96';
			
		if ( empty($alt) )
			$alt = get_the_author_meta( 'display_name', $user_id );
			
		// generate a new size
		if ( empty( $local_avatars[$size] ) )
		{
			$upload_path = wp_upload_dir();
			$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $local_avatars['full'] );
			$image_sized = image_resize( $avatar_full_path, $size, $size, true );
				
			if ( is_wp_error($image_sized) )		// deal with original being >= to original image (or lack of sizing ability)
				$local_avatars[$size] = $local_avatars['full'];
			else
				$local_avatars[$size] = str_replace( $upload_path['basedir'], $upload_path['baseurl'], $image_sized );	
			
			update_user_meta( $user_id, 'simple_local_avatar', $local_avatars );
		}
		elseif ( substr( $local_avatars[$size], 0, 4 ) != 'http' )
			$local_avatars[$size] = site_url( $local_avatars[$size] );
		
		$author_class = is_author( $user_id ) ? ' current-author' : '' ;
		$avatar = "<img alt='" . esc_attr($alt) . "' src='" . $local_avatars[$size] . "' class='avatar avatar-{$size}{$author_class} photo' height='{$size}' width='{$size}' />";
		
		return $avatar;
	}
	
	function admin_init()
	{
		load_plugin_textdomain( 'simple-local-avatars', false, dirname( plugin_basename( __FILE__ ) ) . '/localization/' );
		
		register_setting( 'discussion', 'simple_local_avatars_caps', array( $this, 'sanitize_options' ) );
		add_settings_field( 'simple-local-avatars-caps', __('Local Avatar Permissions','simple-local-avatars'), array( $this, 'avatar_settings_field' ), 'discussion', 'avatars' );
	}
	
	function sanitize_options( $input )
	{
		$new_input['simple_local_avatars_caps'] = empty($input['simple_local_avatars_caps']) ? 0 : 1;
		return $new_input;
	}
	
	function avatar_settings_field( $args )
	{		
		$options = get_option('simple_local_avatars_caps');
		
		echo '
			<label for="simple_local_avatars_caps">
				<input type="checkbox" name="simple_local_avatars_caps" id="simple_local_avatars_caps" value="1" ' . @checked( $options['simple_local_avatars_caps'], 1, false ) . ' />
				' . __('Only allow users with file upload capabilities to upload local avatars (Authors and above)','simple-local-avatars') . '
			</label>
		';
	}
	
	function edit_user_profile( $profileuser )
	{
	?>
	<h3><?php _e( 'Avatar','simple-local-avatars' ); ?></h3>
	
	<table class="form-table">
		<tr>
			<th><label for="simple-local-avatar"><?php _e('Upload Avatar','simple-local-avatars'); ?></label></th>
			<td style="width: 50px;" valign="top">
				<?php echo get_avatar( $profileuser->ID ); ?>
			</td>
			<td>
			<?php
				$options = get_option('simple_local_avatars_caps');
			
				if ( empty($options['simple_local_avatars_caps']) || current_user_can('upload_files') ) 
				{
					do_action( 'simple_local_avatar_notices' ); 
					wp_nonce_field( 'simple_local_avatar_nonce', '_simple_local_avatar_nonce', false ); 
			?>
					<input type="file" name="simple-local-avatar" id="simple-local-avatar" /><br />
			<?php
					if ( empty( $profileuser->simple_local_avatar ) )
						echo '<span class="description">' . __('No local avatar is set. Use the upload field to add a local avatar.','simple-local-avatars') . '</span>';
					else 
						echo '
							<input type="checkbox" name="simple-local-avatar-erase" value="1" /> ' . __('Delete local avatar','simple-local-avatars') . '<br />
							<span class="description">' . __('Replace the local avatar by uploading a new avatar, or erase the local avatar (falling back to a gravatar) by checking the delete option.','simple-local-avatars') . '</span>
						';		
				}
				else
				{
					if ( empty( $profileuser->simple_local_avatar ) )
						echo '<span class="description">' . __('No local avatar is set. Set up your avatar at Gravatar.com.','simple-local-avatars') . '</span>';
					else 
						echo '
							<span class="description">' . __('You do not have media management permissions. To change your local avatar, contact the blog administrator.','simple-local-avatars') . '</span>
						';
				}
			?>
			</td>
		</tr>
	</table>
	
	<script type="text/javascript">
		var form = document.getElementById('your-profile');
		form.encoding = 'multipart/form-data';
		form.setAttribute('enctype', 'multipart/form-data');
	</script>
	<?php		
			
	}
	
	function edit_user_profile_update( $user_id )
	{
		if ( !wp_verify_nonce( $_POST['_simple_local_avatar_nonce'], 'simple_local_avatar_nonce' ) )			//security
			return;
	
		if ( !empty( $_FILES['simple-local-avatar']['name'] ) )
		{
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
				'bmp' => 'image/bmp',
				'tif|tiff' => 'image/tiff'
			);
		
			$avatar = wp_handle_upload( $_FILES['simple-local-avatar'], array( 'mimes' => $mimes, 'test_form' => false ) );
			
			if ( empty($avatar['file']) )	// handle failures
			{	
				switch ( $avatar['error'] ) 
				{
					case 'File type does not meet security guidelines. Try another.' :
						add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error",__("Please upload a valid image file for the avatar.","simple-local-avatars"));') );				
						break;
					default :
						add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error","<strong>".__("There was an error uploading the avatar:","simple-local-avatars")."</strong> ' . esc_attr( $avatar['error'] ) . '");') );
				}
				
				return;
			}
			
			$this->avatar_delete( $user_id );	// delete old images if successful
			
			update_user_meta( $user_id, 'simple_local_avatar', array( 'full' => $avatar['url'] ) );		// save user information (overwriting old)
		}
		elseif ( isset($_POST['simple-local-avatar-erase']) && $_POST['simple-local-avatar-erase'] == 1 )
			$this->avatar_delete( $user_id );
	}
	
	/**
	 * remove the custom get_avatar hook for the default avatar list output on options-discussion.php
	 */
	function avatar_defaults( $avatar_defaults )
	{
		remove_action( 'get_avatar', array( $this, 'get_avatar' ) );
		return $avatar_defaults;
	}
	
	/**
	 * delete avatars based on user_id
	 */
	function avatar_delete( $user_id )
	{
		$old_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		$upload_path = wp_upload_dir();
			
		if ( is_array($old_avatars) ) 
		{
			foreach ($old_avatars as $old_avatar )
			{
				$old_avatar_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $old_avatar );
				@unlink( $old_avatar_path );	
			} 
		}
		
		delete_user_meta( $user_id, 'simple_local_avatar' );
	}
}

$simple_local_avatars = new simple_local_avatars;

if ( !function_exists('get_simple_local_avatar') ) :

/**
 * more efficient to call simple local avatar directly in theme and avoid gravatar setup
 * 
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @param int $size Size of the avatar image
 * @param string $default URL to a default image to use if no avatar is available
 * @param string $alt Alternate text to use in image tag. Defaults to blank
 * @return string <img> tag for the user's avatar
 */
function get_simple_local_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) 
{
	global $simple_local_avatars;
	return $simple_local_avatars->get_avatar( '', $id_or_email, $size, $default, $alt );
}

endif;

/**
 * on uninstallation, remove the custom field from the users and delete the local avatars
 */

register_uninstall_hook( __FILE__, 'simple_local_avatars_uninstall' );

function simple_local_avatars_uninstall() 
{
	$simple_local_avatars = new simple_local_avatars;
	$users = get_users_of_blog();
	
	foreach ( $users as $user )
		$simple_local_avatars->avatar_delete( $user->user_id );
	
	delete_option('simple_local_avatars_caps');
}