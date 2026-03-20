<?php
/**
 * WP Offload Media S3 Compatibility
 *
 * This class adds compatibility between Simple Local Avatars and WP Offload Media Lite
 * to ensure avatars are uploaded to S3 and use the CDN URL.
 *
 * @package SimpleLocalAvatars
 */

/**
 * S3 Compatibility Class
 */
class Simple_Local_Avatars_S3_Compatibility {

	/**
	 * Instance of this class
	 *
	 * @var Simple_Local_Avatars_S3_Compatibility
	 */
	private static $instance = null;

	/**
	 * Get instance of this class
	 *
	 * @return Simple_Local_Avatars_S3_Compatibility
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Hook to ensure avatars are uploaded to S3 after they are assigned
		add_action( 'simple_local_avatar_updated', array( $this, 'upload_avatar_to_s3' ), 10, 1 );

		// Filter avatar URLs to use CDN URL (early hook)
		add_filter( 'pre_simple_local_avatar_url', array( $this, 'maybe_use_s3_url' ), 10, 4 );

		// Filter avatar URLs after they are generated (late hook) - CRÍTICO
		add_filter( 'get_avatar_url', array( $this, 'replace_avatar_url_with_s3' ), 999, 3 );
		add_filter( 'get_avatar', array( $this, 'replace_avatar_html_with_s3' ), 999, 5 );

		// Filter default avatar URL to use CDN URL
		add_filter( 'wp_get_attachment_url', array( $this, 'filter_attachment_url_for_avatars' ), 10, 2 );
		add_filter( 'wp_get_attachment_image_url', array( $this, 'filter_attachment_url_for_avatars' ), 10, 2 );
	}

	/**
	 * Check if WP Offload Media is active
	 *
	 * @return bool
	 */
	private function is_offload_media_active() {
		// Check for WP Offload Media Lite
		if ( class_exists( 'Amazon_S3_And_CloudFront' ) ) {
			return true;
		}

		// Check for WP Offload Media Pro
		if ( class_exists( 'AS3CF_Pro' ) ) {
			return true;
		}

		// Check for the newer class name
		if ( function_exists( 'as3cf_init' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get WP Offload Media instance
	 *
	 * @return object|null
	 */
	private function get_offload_media_instance() {
		if ( ! $this->is_offload_media_active() ) {
			return null;
		}

		// Try to get the global instance
		global $as3cf;

		// Return if already initialized
		if ( ! empty( $as3cf ) ) {
			return $as3cf;
		}

		// Try initializing if the function exists
		if ( function_exists( 'as3cf_init' ) ) {
			as3cf_init();
			// Check if global is now available
			if ( ! empty( $as3cf ) ) {
				return $as3cf;
			}
		}

		return null;
	}

	/**
	 * Upload avatar to S3 after it's assigned to a user
	 *
	 * @param int $user_id User ID
	 */
	public function upload_avatar_to_s3( $user_id ) {
		if ( ! $this->is_offload_media_active() ) {
			return;
		}

		// Get the user's avatar metadata
		$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );

		if ( empty( $local_avatars ) || ! isset( $local_avatars['media_id'] ) ) {
			return;
		}

		$media_id = $local_avatars['media_id'];

		// Ensure the attachment is uploaded to S3
		$this->ensure_attachment_on_s3( $media_id );
	}

	/**
	 * Ensure an attachment is uploaded to S3
	 *
	 * @param int $attachment_id Attachment ID
	 * @return bool
	 */
	private function ensure_attachment_on_s3( $attachment_id ) {
		if ( ! $this->is_offload_media_active() ) {
			return false;
		}

		$as3cf = $this->get_offload_media_instance();

		if ( ! $as3cf ) {
			return false;
		}

		// Check if already uploaded using Media_Library_Item
		$already_uploaded = false;

		if ( class_exists( 'DeliciousBrains\WP_Offload_Media\Items\Media_Library_Item' ) ) {
			$as3cf_item = \DeliciousBrains\WP_Offload_Media\Items\Media_Library_Item::get_by_source_id( $attachment_id );
			if ( $as3cf_item ) {
				$already_uploaded = true;
			}
		}

		if ( ! $already_uploaded ) {
			// Upload to S3 if not already there
			try {
				// Use Upload_Handler to upload the attachment
				if ( class_exists( 'DeliciousBrains\WP_Offload_Media\Items\Upload_Handler' ) ) {
					$upload_handler = $as3cf->get_item_handler( 'upload' );
					if ( $upload_handler && method_exists( $upload_handler, 'handle' ) ) {
						$upload_handler->handle( $attachment_id, array( 'source' => 'media-library' ) );
					}
				}
				// Fallback to old methods if Upload_Handler doesn't work
				elseif ( method_exists( $as3cf, 'upload_attachment' ) ) {
					$as3cf->upload_attachment( $attachment_id );
				} elseif ( method_exists( $as3cf, 'copy_attachment_to_s3' ) ) {
					$as3cf->copy_attachment_to_s3( $attachment_id, null, null, false, true );
				}
			} catch ( Exception $e ) {
				error_log( 'Simple Local Avatars: Error uploading to S3 - ' . $e->getMessage() );
				return false;
			}
		}

		return true;
	}

	/**
	 * Get S3 URL for an attachment
	 *
	 * @param int $attachment_id Attachment ID
	 * @return string|null
	 */
	private function get_s3_url( $attachment_id ) {
		if ( ! $this->is_offload_media_active() ) {
			return null;
		}

		$as3cf = $this->get_offload_media_instance();

		if ( ! $as3cf ) {
			return null;
		}

		// Try to get the S3 URL - support different versions
		try {
			// Method for WP Offload Media Lite 3.x (current version)
			// Use Media_Library_Item class to get the item
			if ( class_exists( 'DeliciousBrains\WP_Offload_Media\Items\Media_Library_Item' ) ) {
				$as3cf_item = \DeliciousBrains\WP_Offload_Media\Items\Media_Library_Item::get_by_source_id( $attachment_id );

				if ( $as3cf_item ) {
					$url = $as3cf_item->get_provider_url();
					if ( $url ) {
						return $url;
					}
				}
			}

			// Fallback: Try newer method (if exists in future versions)
			if ( method_exists( $as3cf, 'get_attachment_url' ) ) {
				$url = $as3cf->get_attachment_url( $attachment_id );
				if ( $url ) {
					return $url;
				}
			}

			// Fallback: Try alternative legacy method
			if ( method_exists( $as3cf, 'get_attachment_s3_info' ) ) {
				$s3_info = $as3cf->get_attachment_s3_info( $attachment_id );
				if ( $s3_info && isset( $s3_info['url'] ) ) {
					return $s3_info['url'];
				}
			}

		} catch ( Exception $e ) {
			// Silent fail, return null
			error_log( 'Simple Local Avatars: Error getting S3 URL - ' . $e->getMessage() );
		}

		return null;
	}

	/**
	 * Maybe use S3 URL for avatar
	 *
	 * @param string|null $url           The URL (null by default)
	 * @param int         $user_id       User ID
	 * @param int         $size          Avatar size
	 * @param array       $local_avatars Avatar metadata
	 * @return string|null
	 */
	public function maybe_use_s3_url( $url, $user_id, $size, $local_avatars ) {
		// If a URL is already set, return it
		if ( ! empty( $url ) && is_string( $url ) ) {
			return $url;
		}

		if ( ! $this->is_offload_media_active() ) {
			return $url;
		}

		// Check if we have a media ID
		if ( empty( $local_avatars['media_id'] ) ) {
			return $url;
		}

		$media_id = $local_avatars['media_id'];

		// Ensure it's on S3
		$this->ensure_attachment_on_s3( $media_id );

		// Get the S3 URL using the proper CDN URL
		$s3_url = $this->get_s3_url( $media_id );

		if ( ! $s3_url ) {
			return $url;
		}

		// If size is requested and different from full size, try to get sized version
		if ( $size && $size !== 'full' ) {
			$sized_url = $this->get_s3_sized_url( $media_id, $size );
			if ( $sized_url ) {
				return $sized_url;
			}
		}

		return $s3_url;
	}

	/**
	 * Get S3 URL for a specific image size
	 *
	 * @param int $attachment_id Attachment ID
	 * @param int $size          Image size
	 * @return string|null
	 */
	private function get_s3_sized_url( $attachment_id, $size ) {
		if ( ! $this->is_offload_media_active() ) {
			return null;
		}

		// First ensure the attachment has the proper thumbnail sizes
		$this->maybe_generate_thumbnail( $attachment_id, $size );

		// Get image metadata
		$meta = wp_get_attachment_metadata( $attachment_id );

		if ( empty( $meta ) ) {
			return $this->get_s3_url( $attachment_id );
		}

		// Get base S3 URL
		$base_url = $this->get_s3_url( $attachment_id );
		if ( ! $base_url ) {
			return null;
		}

		// Check if the sized version exists in metadata
		$size_key = $size . 'x' . $size;
		if ( isset( $meta['sizes'][ $size_key ] ) && isset( $meta['sizes'][ $size_key ]['file'] ) ) {
			// Construct the URL manually by replacing the filename
			$path_info = pathinfo( $base_url );
			$filename = $meta['sizes'][ $size_key ]['file'];

			// The sized file is in the same directory as the full size
			return $path_info['dirname'] . '/' . $filename;
		}

		// If size doesn't exist, return full size
		return $base_url;
	}

	/**
	 * Maybe generate thumbnail for avatar if it doesn't exist
	 *
	 * @param int $attachment_id Attachment ID
	 * @param int $size          Image size
	 * @return bool
	 */
	private function maybe_generate_thumbnail( $attachment_id, $size ) {
		$meta = wp_get_attachment_metadata( $attachment_id );

		if ( empty( $meta ) ) {
			return false;
		}

		// Check if the size already exists
		$size_key = $size . 'x' . $size;
		if ( isset( $meta['sizes'][ $size_key ] ) ) {
			return true;
		}

		// Generate the thumbnail
		$file = get_attached_file( $attachment_id );
		if ( ! $file ) {
			return false;
		}

		$editor = wp_get_image_editor( $file );
		if ( is_wp_error( $editor ) ) {
			return false;
		}

		$resized = $editor->resize( $size, $size, true );
		if ( is_wp_error( $resized ) ) {
			return false;
		}

		$dest_file = $editor->generate_filename( $size . 'x' . $size );
		$saved = $editor->save( $dest_file );

		if ( is_wp_error( $saved ) ) {
			return false;
		}

		// Update metadata
		$meta['sizes'][ $size_key ] = array(
			'file'      => basename( $saved['path'] ),
			'width'     => $saved['width'],
			'height'    => $saved['height'],
			'mime-type' => $saved['mime-type'],
		);

		wp_update_attachment_metadata( $attachment_id, $meta );

		// Upload the new size to S3
		$this->upload_thumbnail_to_s3( $attachment_id, $saved['path'] );

		return true;
	}

	/**
	 * Upload a specific thumbnail to S3
	 *
	 * @param int    $attachment_id Attachment ID
	 * @param string $file_path     File path
	 * @return bool
	 */
	private function upload_thumbnail_to_s3( $attachment_id, $file_path ) {
		if ( ! $this->is_offload_media_active() ) {
			return false;
		}

		$as3cf = $this->get_offload_media_instance();

		if ( ! $as3cf ) {
			return false;
		}

		try {
			// Re-upload the attachment to include all sizes
			if ( method_exists( $as3cf, 'upload_attachment' ) ) {
				$as3cf->upload_attachment( $attachment_id );
				return true;
			}
		} catch ( Exception $e ) {
			error_log( 'Simple Local Avatars: Error uploading thumbnail to S3 - ' . $e->getMessage() );
		}

		return false;
	}

	/**
	 * Filter attachment URLs for avatar images to use S3 CDN
	 *
	 * @param string $url           Attachment URL
	 * @param int    $attachment_id Attachment ID
	 * @return string
	 */
	public function filter_attachment_url_for_avatars( $url, $attachment_id ) {
		if ( ! $this->is_offload_media_active() ) {
			return $url;
		}

		// Check if this attachment is used as an avatar
		if ( ! $this->is_avatar_attachment( $attachment_id ) ) {
			return $url;
		}

		// Get S3 URL
		$s3_url = $this->get_s3_url( $attachment_id );

		if ( $s3_url ) {
			return $s3_url;
		}

		return $url;
	}

	/**
	 * Check if an attachment is used as an avatar
	 *
	 * @param int $attachment_id Attachment ID
	 * @return bool
	 */
	private function is_avatar_attachment( $attachment_id ) {
		global $wpdb;

		// Check if this attachment is used in simple_local_avatar user meta
		$result = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$wpdb->usermeta} 
				WHERE meta_key LIKE %s 
				AND meta_value LIKE %s",
				'%simple_local_avatar%',
				'%"media_id";i:' . $attachment_id . ';%'
			)
		);

		if ( $result > 0 ) {
			return true;
		}

		// Also check if it's the default avatar
		$default_avatar_id = get_option( 'simple_local_avatar_default', '' );
		if ( $default_avatar_id == $attachment_id ) {
			return true;
		}

		return false;
	}

	/**
	 * Replace avatar URL with S3 URL in get_avatar_url filter
	 *
	 * @param string $url         The URL of the avatar.
	 * @param mixed  $id_or_email The Gravatar to retrieve.
	 * @param array  $args        Arguments passed to get_avatar_data().
	 * @return string
	 */
	public function replace_avatar_url_with_s3( $url, $id_or_email, $args ) {
		if ( ! $this->is_offload_media_active() ) {
			return $url;
		}

		// Only process if it's a local URL or old S3 URL (not already CDN or Gravatar)
		if ( ! $this->is_local_url( $url ) && ! $this->is_s3_url( $url ) ) {
			return $url;
		}

		// Get user ID
		$user_id = $this->get_user_id_from_id_or_email( $id_or_email );
		if ( ! $user_id ) {
			return $url;
		}

		// Get avatar metadata (without our filter to avoid loops)
		global $wpdb;
		$avatar_meta = $wpdb->get_var( $wpdb->prepare(
			"SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'simple_local_avatar'",
			$user_id
		) );

		if ( ! $avatar_meta ) {
			return $url;
		}

		$local_avatars = maybe_unserialize( $avatar_meta );
		if ( empty( $local_avatars ) || ! isset( $local_avatars['media_id'] ) ) {
			return $url;
		}

		$media_id = $local_avatars['media_id'];

		// Ensure it's on S3
		$this->ensure_attachment_on_s3( $media_id );

		// Get the size from args
		$size = isset( $args['size'] ) ? $args['size'] : 96;

		// Get S3 CDN URL
		$s3_url = $this->get_s3_url( $media_id );
		if ( ! $s3_url ) {
			return $url;
		}

		// Try to get sized version
		if ( $size && $size !== 'full' ) {
			$sized_url = $this->get_s3_sized_url( $media_id, $size );
			if ( $sized_url ) {
				return $sized_url;
			}
		}

		return $s3_url;
	}

	/**
	 * Replace avatar HTML with S3 URL in get_avatar filter
	 *
	 * @param string $avatar      HTML for the user's avatar.
	 * @param mixed  $id_or_email The Gravatar to retrieve.
	 * @param int    $size        Square avatar width and height in pixels to retrieve.
	 * @param string $default     URL for the default image or a default type.
	 * @param string $alt         Alternative text to use in the avatar image tag.
	 * @return string
	 */
	public function replace_avatar_html_with_s3( $avatar, $id_or_email, $size, $default, $alt ) {
		if ( ! $this->is_offload_media_active() ) {
			return $avatar;
		}

		// Get user ID
		$user_id = $this->get_user_id_from_id_or_email( $id_or_email );
		if ( ! $user_id ) {
			return $avatar;
		}

		// Get avatar metadata directly from database to avoid filter loops
		global $wpdb;
		$avatar_meta = $wpdb->get_var( $wpdb->prepare(
			"SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key = 'simple_local_avatar'",
			$user_id
		) );

		if ( ! $avatar_meta ) {
			return $avatar;
		}

		$local_avatars = maybe_unserialize( $avatar_meta );
		if ( empty( $local_avatars ) || ! isset( $local_avatars['media_id'] ) ) {
			return $avatar;
		}

		$media_id = $local_avatars['media_id'];

		// Ensure it's on S3
		$this->ensure_attachment_on_s3( $media_id );

		// Get S3 CDN URL
		$s3_url = $this->get_s3_url( $media_id );
		if ( ! $s3_url ) {
			return $avatar;
		}

		// Try to get sized version
		if ( $size && $size !== 'full' ) {
			$sized_url = $this->get_s3_sized_url( $media_id, $size );
			if ( $sized_url ) {
				$s3_url = $sized_url;
			}
		}

		// Replace the URL in the HTML
		// Get upload directory to identify local URLs and S3 URLs
		$upload_dir = wp_upload_dir();
		$baseurl = $upload_dir['baseurl'];

		// Replace any local URL or old S3 URL with CDN URL
		$avatar = preg_replace_callback(
			'/src=["\']([^"\']+)["\']/',
			function( $matches ) use ( $s3_url, $baseurl ) {
				$current_url = $matches[1];
				// Replace if it's a local URL or S3 URL
				if ( strpos( $current_url, $baseurl ) !== false || $this->is_s3_url( $current_url ) ) {
					return 'src="' . esc_url( $s3_url ) . '"';
				}
				return $matches[0];
			},
			$avatar
		);

		// Also replace srcset if present
		$avatar = preg_replace_callback(
			'/srcset=["\']([^"\']+)["\']/',
			function( $matches ) use ( $s3_url, $baseurl, $size, $media_id ) {
				$current_srcset = $matches[1];
				// Only replace if it contains local URLs or S3 URLs
				if ( strpos( $current_srcset, $baseurl ) !== false || $this->is_s3_url( $current_srcset ) ) {
					// For srcset, create 1x and 2x versions
					$size_2x = $size * 2;
					$s3_url_2x = $this->get_s3_sized_url( $media_id, $size_2x );
					if ( ! $s3_url_2x ) {
						$s3_url_2x = $s3_url;
					}
					return 'srcset="' . esc_url( $s3_url ) . ' 1x, ' . esc_url( $s3_url_2x ) . ' 2x"';
				}
				return $matches[0];
			},
			$avatar
		);

		return $avatar;
	}

	/**
	 * Check if a URL is an S3 URL (s3://, *.s3.amazonaws.com, etc)
	 *
	 * @param string $url URL to check
	 * @return bool
	 */
	private function is_s3_url( $url ) {
		if ( empty( $url ) ) {
			return false;
		}

		// Check for s3:// protocol
		if ( strpos( $url, 's3://' ) === 0 ) {
			return true;
		}

		// Check for S3 domain patterns
		$s3_patterns = array(
			'.s3.amazonaws.com',
			'.s3-',
			's3.amazonaws.com',
		);

		foreach ( $s3_patterns as $pattern ) {
			if ( strpos( $url, $pattern ) !== false ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a URL is a local URL
	 *
	 * @param string $url URL to check
	 * @return bool
	 */
	private function is_local_url( $url ) {
		if ( empty( $url ) ) {
			return false;
		}

		$upload_dir = wp_upload_dir();
		$baseurl = $upload_dir['baseurl'];

		// Check if URL contains the local upload directory
		if ( strpos( $url, $baseurl ) !== false ) {
			return true;
		}

		// Check if it's a relative URL or contains the site URL
		$site_url = get_site_url();
		if ( strpos( $url, $site_url ) !== false ) {
			return true;
		}

		return false;
	}

	/**
	 * Get user ID from various input types
	 *
	 * @param mixed $id_or_email User ID, email, or object
	 * @return int|false
	 */
	private function get_user_id_from_id_or_email( $id_or_email ) {
		$user_id = false;

		if ( is_numeric( $id_or_email ) ) {
			$user_id = (int) $id_or_email;
		} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		} elseif ( $id_or_email instanceof WP_User ) {
			$user_id = $id_or_email->ID;
		} elseif ( $id_or_email instanceof WP_Post && ! empty( $id_or_email->post_author ) ) {
			$user_id = (int) $id_or_email->post_author;
		} elseif ( $id_or_email instanceof WP_Comment && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		} elseif ( is_string( $id_or_email ) && is_email( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
			$user_id = $user ? $user->ID : false;
		}

		return $user_id;
	}
}

// Initialize the compatibility class
Simple_Local_Avatars_S3_Compatibility::get_instance();

