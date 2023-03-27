<?php
/**
 * Main Class file: Simple_Local_Avatars
 * Adds an avatar upload field to user profiles.
 *
 * @package SimpleLocalAvatars
 */

/**
 * Main SLA Class.
 */
class Simple_Local_Avatars {
	/**
	 * The user ID.
	 *
	 * @var int.
	 */
	private $user_id_being_edited;

	/**
	 * The upload error comment.
	 *
	 * @var string.
	 */
	private $avatar_upload_error;

	/**
	 * The nonce token.
	 *
	 * @var string
	 */
	private $remove_nonce;

	/**
	 * The ratings.
	 *
	 * @var array
	 */
	private $avatar_ratings;

	/**
	 * The meta key a user.
	 *
	 * @var string
	 */
	private $user_key;

	/**
	 * The meta key a user.
	 *
	 * @var string he meta key for ratings.
	 */
	private $rating_key;

	/**
	 * Configured setting values.
	 *
	 * @var array
	 */
	public $options;

	/**
	 * Set up the hooks and default values
	 */
	public function __construct() {
		$this->add_hooks();

		$this->options        = (array) get_option( 'simple_local_avatars' );
		$this->user_key       = 'simple_local_avatar';
		$this->rating_key     = 'simple_local_avatar_rating';

		if (
			! $this->is_avatar_shared() // Are we sharing avatars?
			&& (
				( // And either an ajax request not in the network admin.
					defined( 'DOING_AJAX' ) && DOING_AJAX
					&& isset( $_SERVER['HTTP_REFERER'] ) && ! preg_match( '#^' . network_admin_url() . '#i', $_SERVER['HTTP_REFERER'] )
				)
				||
				( // Or normal request not in the network admin.
					( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX )
					&& ! is_network_admin()
				)
			)
			&& is_multisite()
		) {
			$this->user_key   = sprintf( $this->user_key . '_%d', get_current_blog_id() );
			$this->rating_key = sprintf( $this->rating_key . '_%d', get_current_blog_id() );
		}
	}

	/**
	 * Register actions and filters.
	 */
	public function add_hooks() {
		global $pagenow;
		global $wp_version;

		add_filter( 'plugin_action_links_' . SLA_PLUGIN_BASENAME, array( $this, 'plugin_filter_action_links' ) );

		add_filter( 'pre_get_avatar_data', array( $this, 'get_avatar_data' ), 10, 2 );
		add_filter( 'pre_option_simple_local_avatars', array( $this, 'pre_option_simple_local_avatars' ), 10, 1 );

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'define_avatar_ratings' ) );

		// Load the JS on BE & FE both, in order to support third party plugins like bbPress.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'show_user_profile', array( $this, 'edit_user_profile' ) );
		add_action( 'edit_user_profile', array( $this, 'edit_user_profile' ) );

		add_action( 'personal_options_update', array( $this, 'edit_user_profile_update' ) );
		add_action( 'edit_user_profile_update', array( $this, 'edit_user_profile_update' ) );
		add_action( 'admin_action_remove-simple-local-avatar', array( $this, 'action_remove_simple_local_avatar' ) );
		add_action( 'wp_ajax_assign_simple_local_avatar_media', array( $this, 'ajax_assign_simple_local_avatar_media' ) );
		add_action( 'wp_ajax_remove_simple_local_avatar', array( $this, 'action_remove_simple_local_avatar' ) );
		add_action( 'user_edit_form_tag', array( $this, 'user_edit_form_tag' ) );

		add_action( 'rest_api_init', array( $this, 'register_rest_fields' ) );

		add_action( 'wp_ajax_migrate_from_wp_user_avatar', array( $this, 'ajax_migrate_from_wp_user_avatar' ) );

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::add_command( 'simple-local-avatars migrate wp-user-avatar', array( $this, 'wp_cli_migrate_from_wp_user_avatar' ) );
		}

		add_action( 'wp_ajax_sla_clear_user_cache', array( $this, 'sla_clear_user_cache' ) );

		add_filter( 'avatar_defaults', array( $this, 'add_avatar_default_field' ) );
		if ( version_compare( $wp_version, '5.1', '<' ) ) {
			add_action( 'wpmu_new_blog', array( $this, 'set_defaults' ) );
		} else {
			add_action( 'wp_initialize_site', array( $this, 'set_defaults' ) );
		}

		if ( 'profile.php' === $pagenow ) {
			add_filter( 'media_view_strings', function ( $strings ) {
				$strings['skipCropping'] = esc_html__( 'Default Crop', 'simple-local-avatars' );

				return $strings;
			}, 10, 1 );
		}

		// Fix: An error occurred cropping the image (https://github.com/10up/simple-local-avatars/issues/141).
		if ( isset( $_POST['action'] ) && 'crop-image' === $_POST['action'] && is_admin() && wp_doing_ajax() ) {
			add_action( 'plugins_loaded', function () {
				remove_all_actions( 'setup_theme' );
			} );
		}
	}

	/**
	 * Determine if plugin is network activated.
	 *
	 * @param string $plugin The plugin slug to check.
	 *
	 * @return boolean
	 */
	public static function is_network( $plugin ) {
		$plugins = get_site_option( 'active_sitewide_plugins', array() );

		if ( is_multisite() && isset( $plugins[ $plugin ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get current plugin network mode
	 */
	public function get_network_mode() {
		if ( SLA_IS_NETWORK ) {
			return get_site_option( 'simple_local_avatars_mode', 'default' );
		}

		return 'default';
	}

	/**
	 * Determines if settings handling is enforced on a network level
	 *
	 * Important: this is only meant for admin UI purposes.
	 *
	 * @return boolean
	 */
	public function is_enforced() {
		if (
			( ! is_network_admin() && ( SLA_IS_NETWORK && 'enforce' === $this->get_network_mode() ) )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Determine if avatars should be shared
	 *
	 * @return boolean
	 */
	public function is_avatar_shared() {
		if (
			is_multisite() // Are we on multisite.
			&& ! isset( $this->options['shared'] ) // And our shared option doesn't exist.
			|| (
				isset( $this->options['shared'] ) // Or our shared option is set.
				&& 1 === $this->options['shared']
			)
		) {
			return true;
		}

		return false;
	}

	/**
	 * Add the settings action link to the plugin page.
	 *
	 * @param array $links The Action links for the plugin.
	 *
	 * @return array
	 */
	public function plugin_filter_action_links( $links ) {

		if ( ! is_array( $links ) ) {
			return $links;
		}

		$links['settings'] = sprintf(
			'<a href="%s"> %s </a>',
			esc_url( admin_url( 'options-discussion.php' ) ),
			__( 'Settings', 'simple-local-avatars' )
		);

		return $links;
	}

	/**
	 * Retrieve the local avatar for a user who provided a user ID, email address or post/comment object.
	 *
	 * @param string            $avatar      Avatar return by original function
	 * @param int|string|object $id_or_email A user ID, email address, or post/comment object
	 * @param int               $size        Size of the avatar image
	 * @param string            $default     URL to a default image to use if no avatar is available
	 * @param string            $alt         Alternative text to use in image tag. Defaults to blank
	 * @param array             $args        Optional. Extra arguments to retrieve the avatar.
	 *
	 * @return string <img> tag for the user's avatar
	 */
	public function get_avatar( $avatar = '', $id_or_email = '', $size = 96, $default = '', $alt = '', $args = array() ) {
		return apply_filters( 'simple_local_avatar', get_avatar( $id_or_email, $size, $default, $alt, $args ) );
	}

	/**
	 * Filter avatar data early to add avatar url if needed. This filter hooks
	 * before Gravatar setup to prevent wasted requests.
	 *
	 * @since 2.2.0
	 *
	 * @param array $args        Arguments passed to get_avatar_data(), after processing.
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user ID, Gravatar MD5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 */
	public function get_avatar_data( $args, $id_or_email ) {
		if ( ! empty( $args['force_default'] ) ) {
			return $args;
		}

		$simple_local_avatar_url = $this->get_simple_local_avatar_url( $id_or_email, $args['size'] );
		if ( $simple_local_avatar_url ) {
			$args['url'] = $simple_local_avatar_url;
		}

		// Local only mode
		if ( ! $simple_local_avatar_url && ! empty( $this->options['only'] ) ) {
			$args['url'] = $this->get_default_avatar_url( $args['size'] );
		}

		if ( ! empty( $args['url'] ) ) {
			$args['found_avatar'] = true;

			// If custom alt text isn't passed, pull alt text from the local image.
			if ( empty( $args['alt'] ) ) {
				$args['alt'] = $this->get_simple_local_avatar_alt( $id_or_email );
			}
		}

		return $args;
	}

	/**
	 * Get a user ID from certain possible values.
	 *
	 * @since 2.5.0
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user ID, Gravatar MD5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @return int|false
	 */
	public function get_user_id( $id_or_email ) {
		$user_id = false;

		if ( is_numeric( $id_or_email ) ) {
			$user_id = (int) $id_or_email;
		} elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
			$user_id = (int) $id_or_email->user_id;
		} elseif ( $id_or_email instanceof WP_User ) {
			$user_id = $id_or_email->ID;
		} elseif ( $id_or_email instanceof WP_Post && ! empty( $id_or_email->post_author ) ) {
			$user_id = (int) $id_or_email->post_author;
		} elseif ( is_string( $id_or_email ) ) {
			$user    = get_user_by( 'email', $id_or_email );
			$user_id = $user ? $user->ID : '';
		}

		return $user_id;
	}

	/**
	 * Get local avatar url.
	 *
	 * @since 2.2.0
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user ID, Gravatar MD5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @param int   $size        Requested avatar size.
	 */
	public function get_simple_local_avatar_url( $id_or_email, $size ) {
		$user_id = $this->get_user_id( $id_or_email );

		if ( empty( $user_id ) ) {
			return '';
		}

		// Fetch local avatar from meta and make sure it's properly set.
		$local_avatars = get_user_meta( $user_id, $this->user_key, true );
		if ( empty( $local_avatars['full'] ) ) {
			return '';
		}

		// check rating
		$avatar_rating = get_user_meta( $user_id, $this->rating_key, true );
		$site_rating   = get_option( 'avatar_rating' );
		if ( ! empty( $avatar_rating ) && 'G' !== $avatar_rating && $site_rating ) {
			$ratings              = array_keys( $this->avatar_ratings );
			$site_rating_weight   = array_search( $site_rating, $ratings, true );
			$avatar_rating_weight = array_search( $avatar_rating, $ratings, true );
			if ( false !== $avatar_rating_weight && $avatar_rating_weight > $site_rating_weight ) {
				return '';
			}
		}

		// handle "real" media
		if ( ! empty( $local_avatars['media_id'] ) ) {
			// If using shared avatars, make sure we validate the URL on the main site.
			if ( $this->is_avatar_shared() ) {
				$origin_blog_id = isset( $local_avatars['blog_id'] ) && ! empty( $local_avatars['blog_id'] ) ? $local_avatars['blog_id'] : get_main_site_id();
				switch_to_blog( $origin_blog_id );
			}

			$avatar_full_path = get_attached_file( $local_avatars['media_id'] );

			if ( $this->is_avatar_shared() ) {
				restore_current_blog();
			}

			// has the media been deleted?
			if ( ! $avatar_full_path ) {
				return '';
			}
		}

		$size = (int) $size;

		// Generate a new size.
		if ( ! array_key_exists( $size, $local_avatars ) ) {
			$local_avatars[ $size ] = $local_avatars['full']; // just in case of failure elsewhere

			// allow automatic rescaling to be turned off
			if ( apply_filters( 'simple_local_avatars_dynamic_resize', true ) ) :

				$upload_path = wp_upload_dir();

				// get path for image by converting URL, unless its already been set, thanks to using media library approach
				if ( ! isset( $avatar_full_path ) ) {
					$avatar_full_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $local_avatars['full'] );
				}

				// generate the new size
				$editor = wp_get_image_editor( $avatar_full_path );
				if ( ! is_wp_error( $editor ) ) {
					$resized = $editor->resize( $size, $size, true );
					if ( ! is_wp_error( $resized ) ) {
						$dest_file = $editor->generate_filename();
						$saved     = $editor->save( $dest_file );
						if ( ! is_wp_error( $saved ) ) {
							// Transform the destination file path into URL.
							$dest_file_url = '';
							if ( false !== strpos( $dest_file, $upload_path['basedir'] ) ) {
								$dest_file_url = str_replace( $upload_path['basedir'], $upload_path['baseurl'], $dest_file );
							} else if ( is_multisite() && false !== strpos( $dest_file, ABSPATH . 'wp-content/uploads' ) ) {
								$dest_file_url = str_replace( ABSPATH . 'wp-content/uploads', network_site_url( '/wp-content/uploads' ), $dest_file );
							}

							$local_avatars[ $size ] = $dest_file_url;
						}
					}
				}

				// save updated avatar sizes
				update_user_meta( $user_id, $this->user_key, $local_avatars );

			endif;
		}

		if ( 'http' !== substr( $local_avatars[ $size ], 0, 4 ) ) {
			$local_avatars[ $size ] = home_url( $local_avatars[ $size ] );
		}

		return esc_url( $local_avatars[ $size ] );
	}

	/**
	 * Get local avatar alt text.
	 *
	 * @since 2.5.0
	 *
	 * @param mixed $id_or_email The Gravatar to retrieve. Accepts a user ID, Gravatar MD5 hash,
	 *                           user email, WP_User object, WP_Post object, or WP_Comment object.
	 * @return string
	 */
	public function get_simple_local_avatar_alt( $id_or_email ) {
		$user_id = $this->get_user_id( $id_or_email );

		/**
		 * Filter the default avatar alt text.
		 *
		 * @param string $alt Default alt text.
		 * @return string
		 */
		$default_alt = apply_filters( 'simple_local_avatars_default_alt', __( 'Avatar photo', 'simple-local-avatars' ) );

		if ( empty( $user_id ) ) {
			return $default_alt;
		}

		// Fetch local avatar from meta and make sure we have a media ID.
		$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		if ( empty( $local_avatars['media_id'] ) ) {
			$alt = '';
			// If no avatar is set, check if we are using a default avatar with alt text.
			if ( 'simple_local_avatar' === get_option( 'avatar_default' ) ) {
				$default_avatar_id = get_option( 'simple_local_avatar_default', '' );
				if ( ! empty( $default_avatar_id ) ) {
					$alt = get_post_meta( $default_avatar_id, '_wp_attachment_image_alt', true );
				}
			}

			return $alt ? $alt : $default_alt;
		}

		$alt = get_post_meta( $local_avatars['media_id'], '_wp_attachment_image_alt', true );

		return $alt ? $alt : $default_alt;
	}

	/**
	 * Get default avatar url
	 *
	 * @since 2.2.0
	 *
	 * @param int $size Requested avatar size.
	 */
	public function get_default_avatar_url( $size ) {
		if ( empty( $default ) ) {
			$avatar_default = get_option( 'avatar_default' );
			if ( empty( $avatar_default ) ) {
				$default = 'mystery';
			} else {
				$default = $avatar_default;
			}
		}

		$host = is_ssl() ? 'https://secure.gravatar.com' : 'http://0.gravatar.com';

		if ( 'mystery' === $default ) {
			$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
		} elseif ( 'blank' === $default ) {
			$default = includes_url( 'images/blank.gif' );
		} elseif ( 'gravatar_default' === $default ) {
			$default = "$host/avatar/?s={$size}";
		} elseif ( 'simple_local_avatar' === $default ) {
			$default           = "$host/avatar/?d=$default&amp;s={$size}";
			$default_avatar_id = get_option( 'simple_local_avatar_default', '' );
			if ( ! empty( $default_avatar_id ) ) {
				$default = wp_get_attachment_image_url( $default_avatar_id );
			}
		} else {
			$default = "$host/avatar/?d=$default&amp;s={$size}";
		}

		return $default;
	}

	/**
	 * Define the ratings avatar ratings.
	 *
	 * The ratings need to be defined after the languages have been loaded so
	 * they can be translated. This method exists to define the ratings
	 * after that has been done.
	 *
	 * @since 2.7.3
	 */
	public function define_avatar_ratings() {
		/*
		 * Avatar ratings.
		 *
		 * The key should not be translated as it's used by WP Core in it's
		 * english form (G, PG, etc).
		 *
		 * The values should be translated, these include the initial rating
		 * name and the description for display to users.
		 */
		$this->avatar_ratings = array(
			/* translators: Content suitability rating: https://en.wikipedia.org/wiki/Motion_Picture_Association_of_America_film_rating_system */
			'G'  => __( 'G &#8212; Suitable for all audiences' ),
			/* translators: Content suitability rating: https://en.wikipedia.org/wiki/Motion_Picture_Association_of_America_film_rating_system */
			'PG' => __( 'PG &#8212; Possibly offensive, usually for audiences 13 and above' ),
			/* translators: Content suitability rating: https://en.wikipedia.org/wiki/Motion_Picture_Association_of_America_film_rating_system */
			'R'  => __( 'R &#8212; Intended for adult audiences above 17' ),
			/* translators: Content suitability rating: https://en.wikipedia.org/wiki/Motion_Picture_Association_of_America_film_rating_system */
			'X'  => __( 'X &#8212; Even more mature than above' ),
		);
	}

	/**
	 * Register admin settings.
	 */
	public function admin_init() {
		$this->define_avatar_ratings();
		// upgrade pre 2.0 option
		$old_ops = get_option( 'simple_local_avatars_caps' );
		if ( $old_ops ) {
			if ( ! empty( $old_ops['simple_local_avatars_caps'] ) ) {
				update_option( 'simple_local_avatars', array( 'caps' => 1 ) );
			}

			delete_option( 'simple_local_avatar_caps' );
		}

		register_setting( 'discussion', 'simple_local_avatars', array( $this, 'sanitize_options' ) );
		add_settings_field(
			'simple-local-avatars-only',
			__( 'Local Avatars Only', 'simple-local-avatars' ),
			array( $this, 'avatar_settings_field' ),
			'discussion',
			'avatars',
			array(
				'class' => 'simple-local-avatars',
				'key'   => 'only',
				'desc'  => __( 'Only allow local avatars (still uses Gravatar for default avatars)', 'simple-local-avatars' ),
			)
		);
		add_settings_field(
			'simple-local-avatars-caps',
			__( 'Local Upload Permissions', 'simple-local-avatars' ),
			array( $this, 'avatar_settings_field' ),
			'discussion',
			'avatars',
			array(
				'class' => 'simple-local-avatars',
				'key'   => 'caps',
				'desc'  => __( 'Only allow users with file upload capabilities to upload local avatars (Authors and above)', 'simple-local-avatars' ),
			)
		);

		if ( is_multisite() ) {
			add_settings_field(
				'simple-local-avatars-shared',
				__( 'Shared network avatars', 'simple-local-avatars' ),
				array( $this, 'avatar_settings_field' ),
				'discussion',
				'avatars',
				array(
					'class'   => 'simple-local-avatars',
					'key'     => 'shared',
					'desc'    => __( 'Uploaded avatars will be shared across the entire network, instead of being unique per site', 'simple-local-avatars' ),
					'default' => 1,
				)
			);
		}

		add_action( 'load-options-discussion.php', array( $this, 'load_discussion_page' ) );

		// This is for network site settings.
		if ( SLA_IS_NETWORK && is_network_admin() ) {
			add_action( 'load-settings.php', array( $this, 'load_network_settings' ) );
		}

		add_settings_field(
			'simple-local-avatars-migration',
			__( 'Migrate Other Local Avatars', 'simple-local-avatars' ),
			array( $this, 'migrate_from_wp_user_avatar_settings_field' ),
			'discussion',
			'avatars'
		);
		add_settings_field(
			'simple-local-avatars-clear',
			esc_html__( 'Clear local avatar cache', 'simple-local-avatars' ),
			array( $this, 'avatar_settings_field' ),
			'discussion',
			'avatars',
			array(
				'key'  => 'clear_cache',
				'desc' => esc_html__( 'Clear cache of stored avatars', 'simple-local-avatars' ),
			)
		);

		// Save default avatar file.
		$this->save_default_avatar_file_id();
	}

	/**
	 * Fire code on the Discussion page
	 */
	public function load_discussion_page() {
		add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );
	}

	/**
	 * Load needed hooks to handle network settings
	 */
	public function load_network_settings() {
		$this->options = (array) get_site_option( 'simple_local_avatars', array() );

		add_action( 'wpmu_options', array( $this, 'show_network_settings' ) );
		add_action( 'update_wpmu_options', array( $this, 'save_network_settings' ) );
	}

	/**
	 * Show the network settings
	 */
	public function show_network_settings() {
		$mode = $this->get_network_mode();
		?>

		<h2><?php esc_html_e( 'Simple Local Avatars Settings', 'simple-local-avatars' ); ?></h2>
		<table id="simple-local-avatars" class="form-table">
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Mode', 'simple-local-avatars' ); ?>
				</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><?php esc_html_e( 'Mode', 'simple-local-avatars' ); ?></legend>
						<label><input name="simple_local_avatars[mode]" type="radio" id="sla-mode-default" value="default"<?php checked( $mode, 'default' ); ?> /> <?php esc_html_e( 'Default to the settings below when creating a new site', 'simple-local-avatars' ); ?></label><br/>
						<label><input name="simple_local_avatars[mode]" type="radio" id="sla-mode-enforce" value="enforce"<?php checked( $mode, 'enforce' ); ?> /> <?php esc_html_e( 'Enforce the settings below across all sites', 'simple-local-avatars' ); ?></label><br/>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Local avatars only', 'simple-local-avatars' ); ?>
				</th>
				<td>
					<?php
					$this->avatar_settings_field(
						array(
							'key'  => 'only',
							'desc' => __( 'Only allow local avatars (still uses Gravatar for default avatars)	', 'simple-local-avatars' ),
						)
					);
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Local upload permissions', 'simple-local-avatars' ); ?>
				</th>
				<td>
					<?php
					$this->avatar_settings_field(
						array(
							'key'  => 'caps',
							'desc' => __( 'Only allow users with file upload capabilities to upload local avatars (Authors and above)', 'simple-local-avatars' ),
						)
					);
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Shared network avatars', 'simple-local-avatars' ); ?>
				</th>
				<td>
					<?php
					$this->avatar_settings_field(
						array(
							'key'     => 'shared',
							'desc'    => __( 'Uploaded avatars will be shared across the entire network, instead of being unique per site', 'simple-local-avatars' ),
							'default' => 1,
						)
					);
					?>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Handle saving the network settings
	 */
	public static function save_network_settings() {
		$options   = array(
			'caps',
			'mode',
			'only',
			'shared',
		);
		$sanitized = array();

		foreach ( $options as $option_name ) {
			if ( ! isset( $_POST['simple_local_avatars'][ $option_name ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				continue;
			}

			switch ( $option_name ) {
				case 'mode':
					update_site_option( 'simple_local_avatars_mode', sanitize_text_field( $_POST['simple_local_avatars'][ $option_name ] ) );
					break;
				default:
					$sanitized[ $option_name ] = empty( $_POST['simple_local_avatars'][ $option_name ] ) ? 0 : 1;
			}
		}

		update_site_option( 'simple_local_avatars', $sanitized );
	}

	/**
	 * Add scripts to the profile editing page
	 *
	 * @param string $hook_suffix Page hook
	 */
	public function enqueue_scripts( $hook_suffix ) {

		/**
		 * Filter the admin screens where we enqueue our scripts.
		 *
		 * @param array $screens Array of admin screens.
		 * @param string $hook_suffix Page hook.
		 * @return array
		 */
		$screens = apply_filters( 'simple_local_avatars_admin_enqueue_scripts', array( 'profile.php', 'user-edit.php', 'options-discussion.php' ), $hook_suffix );

		// Allow SLA actions on a bbPress profile edit page at FE.
		if ( function_exists( 'bbp_is_user_home_edit' ) && bbp_is_user_home_edit() ) {
			$hook_suffix = 'profile.php';
		}

		if ( ! in_array( $hook_suffix, $screens, true ) ) {
			return;
		}

		if ( current_user_can( 'upload_files' ) ) {
			wp_enqueue_media();
		}

		$user_id = filter_input( INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$user_id = ( 'profile.php' === $hook_suffix ) ? get_current_user_id() : (int) $user_id;

		$this->remove_nonce = wp_create_nonce( 'remove_simple_local_avatar_nonce' );

		wp_enqueue_script( 'simple-local-avatars', plugins_url( '', dirname( __FILE__ ) ) . '/dist/simple-local-avatars.js', array( 'jquery' ), SLA_VERSION, true );
		wp_localize_script(
			'simple-local-avatars',
			'i10n_SimpleLocalAvatars',
			array(
				'ajaxurl'                         => admin_url( 'admin-ajax.php' ),
				'user_id'                         => $user_id,
				'insertIntoPost'                  => __( 'Set as avatar', 'simple-local-avatars' ),
				'selectCrop'                      => __( 'Select avatar and Crop', 'simple-local-avatars' ),
				'deleteNonce'                     => $this->remove_nonce,
				'cacheNonce'                      => wp_create_nonce( 'sla_clear_cache_nonce' ),
				'mediaNonce'                      => wp_create_nonce( 'assign_simple_local_avatar_nonce' ),
				'migrateFromWpUserAvatarNonce'    => wp_create_nonce( 'migrate_from_wp_user_avatar_nonce' ),
				'clearCacheError'                 => esc_html__( 'Something went wrong while clearing cache, please try again.', 'simple-local-avatars' ),
				'insertMediaTitle'                => esc_html__( 'Choose default avatar', 'simple-local-avatars' ),
				'migrateFromWpUserAvatarSuccess'  => __( 'Number of avatars successfully migrated from WP User Avatar', 'simple-local-avatars' ),
				'migrateFromWpUserAvatarFailure'  => __( 'No avatars were migrated from WP User Avatar.', 'simple-local-avatars' ),
				'migrateFromWpUserAvatarProgress' => __( 'Migration in progress.', 'simple-local-avatars' ),
			)
		);
	}

	/**
	 * Sanitize new settings field before saving
	 *
	 * @param  array|string $input Passed input values to sanitize
	 * @return array|string Sanitized input fields
	 */
	public function sanitize_options( $input ) {
		$new_input['caps'] = empty( $input['caps'] ) ? 0 : 1;
		$new_input['only'] = empty( $input['only'] ) ? 0 : 1;

		if ( is_multisite() ) {
			$new_input['shared'] = empty( $input['shared'] ) ? 0 : 1;
		}

		return $new_input;
	}

	/**
	 * Settings field for avatar upload capabilities
	 *
	 * @param array $args Field arguments
	 */
	public function avatar_settings_field( $args ) {
		$args = wp_parse_args(
			$args,
			array(
				'key'     => '',
				'desc'    => '',
				'default' => 0,
			)
		);

		if ( ! isset( $this->options[ $args['key'] ] ) ) {
			$this->options[ $args['key'] ] = $args['default'];
		}

		if ( 'clear_cache' !== $args['key'] ) {
			echo '
			<label for="simple-local-avatars-' . esc_attr( $args['key'] ) . '">
				<input type="checkbox" name="simple_local_avatars[' . esc_attr( $args['key'] ) . ']" id="simple-local-avatars-' . esc_attr( $args['key'] ) . '" value="1" ' . checked( $this->options[ $args['key'] ], 1, false ) . ' />
				' . esc_html( $args['desc'] ) . '
			</label>
		';
		} else {
			echo '<button id="clear_cache_btn" class="button delete" name="clear_cache_btn" >' . esc_html__( 'Clear cache', 'simple-local-avatars' ) . '</button><br/>';
			echo '<span id="clear_cache_message" style="font-style:italic;font-size:14px;line-height:2;"></span>';
		}

		// Output warning if needed.
		if (
			SLA_IS_NETWORK // If network activated.
			&& $this->is_enforced() // And in enforce mode.
			&& 'shared' === $args['key'] // And we are displaying the last setting.
		) {
			echo '
				<div class="notice notice-warning inline">
					<p><strong>' . esc_html__( 'Simple Local Avatar settings are currently enforced across all sites on the network.', 'simple-local-avatars' ) . '</strong></p>
				</div>
			';
		}
	}

	/**
	 * Settings field for migrating avatars away from WP User Avatar
	 */
	public function migrate_from_wp_user_avatar_settings_field() {
		printf(
			'<p><button type="button" name="%1$s" id="%1$s" class="button button-secondary">%2$s</button></p><p class="%1$s-progress"></p>',
			esc_attr( 'simple-local-avatars-migrate-from-wp-user-avatar' ),
			esc_html__( 'Migrate avatars from WP User Avatar to Simple Local Avatars', 'simple-local-avatars' )
		);
	}

	/**
	 * Output new Avatar fields to user editing / profile screen
	 *
	 * @param object $profileuser User object
	 */
	public function edit_user_profile( $profileuser ) {
		?>
		<div id="simple-local-avatar-section">
			<h3><?php esc_html_e( 'Avatar', 'simple-local-avatars' ); ?></h3>

			<table class="form-table">
				<tr class="upload-avatar-row">
					<th scope="row"><label for="simple-local-avatar"><?php esc_html_e( 'Upload Avatar', 'simple-local-avatars' ); ?></label></th>
					<td colspan="2">
						<div class="right-wrapper" style="display: flex; align-items: center;">
							<div id="simple-local-avatar-photo" class="image-container" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
								<?php
								add_filter( 'pre_option_avatar_rating', '__return_empty_string' );     // ignore ratings here
								echo wp_kses_post( get_simple_local_avatar( $profileuser->ID ) );
								remove_filter( 'pre_option_avatar_rating', '__return_empty_string' );
								?>
								<span class="spinner" id="simple-local-avatar-spinner"></span>
							</div>
							<div class="button-containet" style="padding-left: 20px;">
								<?php
								$upload_rights = current_user_can( 'upload_files' );
								if ( ! $upload_rights ) {
									$upload_rights = empty( $this->options['caps'] );
								}

								if ( $upload_rights ) {
									do_action( 'simple_local_avatar_notices' );
									wp_nonce_field( 'simple_local_avatar_nonce', '_simple_local_avatar_nonce', false );
									$remove_url = add_query_arg(
										array(
											'action'   => 'remove-simple-local-avatar',
											'user_id'  => $profileuser->ID,
											'_wpnonce' => $this->remove_nonce,
										)
									);
									?>
									<?php
									// if user is author and above hide the choose file option
									// force them to use the WP Media Selector
									// At FE, show the file input field regardless of the caps.
									if ( ! is_admin() || ! current_user_can( 'upload_files' ) ) {
										?>
										<p style="display: inline-block; width: 26em;">
											<span class="description"><?php esc_html_e( 'Choose an image from your computer:' ); ?></span><br />
											<input type="file" name="simple-local-avatar" id="simple-local-avatar" class="standard-text" />
										</p>
									<?php } ?>
									<p style="width: 28em">
										<?php if ( current_user_can( 'upload_files' ) && did_action( 'wp_enqueue_media' ) ) : ?>
											<a href="#" class="button hide-if-no-js" id="simple-local-avatar-media"><?php esc_html_e( 'Choose from Media Library', 'simple-local-avatars' ); ?></a> &nbsp;
										<?php endif; ?>
										<a href="<?php echo esc_url( $remove_url ); ?>" class="button item-delete submitdelete deletion" id="simple-local-avatar-remove" <?php echo empty( $profileuser->simple_local_avatar ) ? ' style="display:none;"' : ''; ?>>
											<?php esc_html_e( 'Remove local avatar', 'simple-local-avatars' ); ?>
										</a>
									</p>
									<?php
								} else {
									if ( empty( $profileuser->simple_local_avatar ) ) {
										echo '<span class="description">' . esc_html__( 'No local avatar is set. Set up your avatar at Gravatar.com.', 'simple-local-avatars' ) . '</span>';
									} else {
										echo '<span class="description">' . esc_html__( 'You do not have media management permissions. To change your local avatar, contact the blog administrator.', 'simple-local-avatars' ) . '</span>';
									}
								}
								?>
							</div>
						</div>
					</td>
				</tr>
				<tr class="ratings-row">
					<th scope="row"><?php esc_html_e( 'Rating' ); ?></th>
					<td colspan="2">
						<fieldset id="simple-local-avatar-ratings" <?php disabled( empty( $profileuser->simple_local_avatar ) ); ?>>
							<legend class="screen-reader-text"><span><?php esc_html_e( 'Rating' ); ?></span></legend>
							<?php
							if ( empty( $profileuser->simple_local_avatar_rating ) || ! array_key_exists( $profileuser->simple_local_avatar_rating, $this->avatar_ratings ) ) {
								$profileuser->simple_local_avatar_rating = 'G';
							}

							foreach ( $this->avatar_ratings as $key => $rating ) :
								echo "\n\t<label><input type='radio' name='simple_local_avatar_rating' value='" . esc_attr( $key ) . "' " . checked( $profileuser->simple_local_avatar_rating, $key, false ) . '/>' . esc_html( $rating ) . '</label><br />';
							endforeach;
							?>
							<p class="description"><?php esc_html_e( 'If the local avatar is inappropriate for this site, Gravatar will be attempted.', 'simple-local-avatars' ); ?></p>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

	/**
	 * Ensure that the profile form has proper encoding type
	 */
	public function user_edit_form_tag() {
		echo 'enctype="multipart/form-data"';
	}

	/**
	 * Saves avatar image to a user
	 *
	 * @param int|string $url_or_media_id Local URL for avatar or ID of attachment
	 * @param int        $user_id         ID of user to assign image to
	 */
	public function assign_new_user_avatar( $url_or_media_id, $user_id ) {
		// delete the old avatar
		$this->avatar_delete( $user_id ); // delete old images if successful.

		$meta_value = array();

		// set the new avatar
		if ( is_numeric( $url_or_media_id ) ) {
			$meta_value['media_id'] = $url_or_media_id;
			$url_or_media_id        = wp_get_attachment_url( $url_or_media_id );
		}

		$meta_value['full']    = $url_or_media_id;
		$meta_value['blog_id'] = get_current_blog_id();

		update_user_meta( $user_id, $this->user_key, $meta_value ); // save user information (overwriting old).

		/**
		 * Enable themes and other plugins to react to changes to a user's avatar.
		 *
		 * @since 2.6.0
		 *
		 * @param int $user_id Id of the user who's avatar was updated
		 */
		do_action( 'simple_local_avatar_updated' , $user_id );
	}

	/**
	 * Save any changes to the user profile
	 *
	 * @param int $user_id ID of user being updated
	 */
	public function edit_user_profile_update( $user_id ) {
		// check nonces
		if ( empty( $_POST['_simple_local_avatar_nonce'] ) || ! wp_verify_nonce( $_POST['_simple_local_avatar_nonce'], 'simple_local_avatar_nonce' ) ) {
			return;
		}

		// check for uploaded files
		if ( ! empty( $_FILES['simple-local-avatar']['name'] ) && 0 === $_FILES['simple-local-avatar']['error'] ) :

			// need to be more secure since low privelege users can upload
			$allowed_mime_types = wp_get_mime_types();
			$file_mime_type     = strtolower( $_FILES['simple-local-avatar']['type'] );

			if ( ! ( 0 === strpos( $file_mime_type, 'image/' ) ) || ! in_array( $file_mime_type, $allowed_mime_types, true ) ) {
				$this->avatar_upload_error = __( 'Only images can be uploaded as an avatar', 'simple-local-avatars' );
				add_action( 'user_profile_update_errors', array( $this, 'user_profile_update_errors' ) );
				return;
			}

			$max_upload_size = $this->upload_size_limit( wp_max_upload_size() );
			if ( $_FILES['simple-local-avatar']['size'] > $max_upload_size ) {
				$this->avatar_upload_error = sprintf( __( 'Max allowed avatar size is %s', 'simple-local-avatars' ), size_format( $max_upload_size ) );
				add_action( 'user_profile_update_errors', array( $this, 'user_profile_update_errors' ) );
				return;
			}

			// front end (theme my profile etc) support
			if ( ! function_exists( 'media_handle_upload' ) ) {
				include_once ABSPATH . 'wp-admin/includes/media.php';
			}

			// front end (plugin bbPress etc) support
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				include_once ABSPATH . 'wp-admin/includes/file.php';
			}
			if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
				include_once ABSPATH . 'wp-admin/includes/image.php';
			}

			$this->user_id_being_edited = $user_id; // make user_id known to unique_filename_callback function
			$avatar_id                  = media_handle_upload(
				'simple-local-avatar',
				0,
				array(),
				array(
					'mimes'                    => array(
						'jpg|jpeg|jpe' => 'image/jpeg',
						'gif'          => 'image/gif',
						'png'          => 'image/png',
					),
					'test_form'                => false,
					'unique_filename_callback' => array( $this, 'unique_filename_callback' ),
				)
			);

			if ( is_wp_error( $avatar_id ) ) { // handle failures.
				$this->avatar_upload_error = '<strong>' . __( 'There was an error uploading the avatar:', 'simple-local-avatars' ) . '</strong> ' . esc_html( $avatar_id->get_error_message() );
				add_action( 'user_profile_update_errors', array( $this, 'user_profile_update_errors' ) );

				return;
			}

			$this->assign_new_user_avatar( $avatar_id, $user_id );

		endif;

		// Handle ratings
		if ( isset( $avatar_id ) || get_user_meta( $user_id, $this->user_key, true ) ) {
			if ( empty( $_POST['simple_local_avatar_rating'] ) || ! array_key_exists( $_POST['simple_local_avatar_rating'], $this->avatar_ratings ) ) {
				$_POST['simple_local_avatar_rating'] = key( $this->avatar_ratings );
			}

			update_user_meta( $user_id, $this->rating_key, $_POST['simple_local_avatar_rating'] );
		}
	}

	/**
	 * Allow developers to override the maximum allowable file size for avatar uploads
	 *
	 * @param  int $bytes WordPress default byte size check
	 * @return int Maximum byte size
	 */
	public function upload_size_limit( $bytes ) {
		return apply_filters( 'simple_local_avatars_upload_limit', $bytes );
	}

	/**
	 * Runs when a user clicks the Remove button for the avatar
	 */
	public function action_remove_simple_local_avatar() {
		if ( ! empty( $_GET['user_id'] ) && ! empty( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'remove_simple_local_avatar_nonce' ) ) {
			$user_id = (int) $_GET['user_id'];

			if ( ! current_user_can( 'edit_user', $user_id ) ) {
				wp_die( esc_html__( 'You do not have permission to edit this user.', 'simple-local-avatars' ) );
			}

			$this->avatar_delete( $user_id );    // delete old images if successful

			/**
			 * Enable themes and other plugins to react to avatar deletions.
			 *
			 * @since 2.6.0
			 *
			 * @param int $user_id Id of the user who's avatar was deleted.
			 */
			do_action( 'simple_local_avatar_deleted', $user_id );

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				echo wp_kses_post( get_simple_local_avatar( $user_id ) );
			}
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			die;
		}
	}

	/**
	 * AJAX callback for assigning media ID fetched from media library to user
	 */
	public function ajax_assign_simple_local_avatar_media() {
		// check required information and permissions
		if ( empty( $_POST['user_id'] ) || empty( $_POST['media_id'] ) || ! current_user_can( 'upload_files' ) || ! current_user_can( 'edit_user', $_POST['user_id'] ) || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'assign_simple_local_avatar_nonce' ) ) {
			die;
		}

		$media_id = (int) $_POST['media_id'];
		$user_id  = (int) $_POST['user_id'];

		// ensure the media is real is an image
		if ( wp_attachment_is_image( $media_id ) ) {
			$this->assign_new_user_avatar( $media_id, $user_id );
		}

		echo wp_kses_post( get_simple_local_avatar( $user_id ) );

		die;
	}

	/**
	 * Delete avatars based on a user_id
	 *
	 * @param int $user_id User ID.
	 */
	public function avatar_delete( $user_id ) {
		$old_avatars = (array) get_user_meta( $user_id, $this->user_key, true );

		if ( empty( $old_avatars ) ) {
			return;
		}

		// if it was uploaded media, don't erase the full size or try to erase an the ID
		if ( array_key_exists( 'media_id', $old_avatars ) ) {
			unset( $old_avatars['media_id'], $old_avatars['full'] );
		}

		if ( ! empty( $old_avatars ) ) {
			$upload_path = wp_upload_dir();

			foreach ( $old_avatars as $old_avatar ) {
				// derive the path for the file based on the upload directory
				$old_avatar_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $old_avatar );
				if ( file_exists( $old_avatar_path ) ) {
					unlink( $old_avatar_path );
				}
			}
		}

		delete_user_meta( $user_id, $this->user_key );
		delete_user_meta( $user_id, $this->rating_key );
	}

	/**
	 * Creates a unique, meaningful file name for uploaded avatars.
	 *
	 * @param  string $dir  Path for file
	 * @param  string $name Filename
	 * @param  string $ext  File extension (e.g. ".jpg")
	 * @return string Final filename
	 */
	public function unique_filename_callback( $dir, $name, $ext ) {
		$user = get_user_by( 'id', (int) $this->user_id_being_edited );
		$name = $base_name = sanitize_file_name( $user->display_name . '_avatar_' . time() ); //phpcs:ignore

		// ensure no conflicts with existing file names
		$number = 1;
		while ( file_exists( $dir . "/$name$ext" ) ) {
			$name = $base_name . '_' . $number;
			$number ++;
		}

		return $name . $ext;
	}

	/**
	 * Adds errors based on avatar upload problems.
	 *
	 * @param WP_Error $errors Error messages for user profile screen.
	 */
	public function user_profile_update_errors( WP_Error $errors ) {
		$errors->add( 'avatar_error', $this->avatar_upload_error );
	}

	/**
	 * Registers the simple_local_avatar field in the REST API.
	 */
	public function register_rest_fields() {
		register_rest_field(
			'user',
			'simple_local_avatar',
			array(
				'get_callback'    => array( $this, 'get_avatar_rest' ),
				'update_callback' => array( $this, 'set_avatar_rest' ),
				'schema'          => array(
					'description' => 'The users simple local avatar',
					'type'        => 'object',
				),
			)
		);
	}

	/**
	 * Returns the simple_local_avatar meta key for the given user.
	 *
	 * @param object $user User object
	 */
	public function get_avatar_rest( $user ) {
		$local_avatar = get_user_meta( $user['id'], $this->user_key, true );
		if ( empty( $local_avatar ) ) {
			return;
		}

		return $local_avatar;
	}

	/**
	 * Updates the simple local avatar from a REST request.
	 *
	 * Since we are just adding a field to the existing user endpoint
	 * we don't need to worry about ensuring the calling user has proper permissions.
	 * Only the user or an administrator would be able to change the avatar.
	 *
	 * @param array  $input Input submitted via REST request.
	 * @param object $user  The user making the request.
	 */
	public function set_avatar_rest( $input, $user ) {
		$this->assign_new_user_avatar( $input['media_id'], $user->ID );
	}

	/**
	 * Short-circuit filter the `simple_local_avatars` option to match network if necessary
	 *
	 * @param bool $value Value of `simple_local_avatars` option, typically false.
	 *
	 * @return array
	 */
	public function pre_option_simple_local_avatars( $value ) {
		if ( SLA_IS_NETWORK && 'enforce' === $this->get_network_mode() ) {
			$value = get_site_option( 'simple_local_avatars', array() );
		}

		return $value;
	}

	/**
	 * Set plugin defaults for a new site
	 *
	 * @param int|WP_Site $blog_id Blog ID or object.
	 */
	public function set_defaults( $blog_id ) {
		if ( 'enforce' === $this->get_network_mode() ) {
			return;
		}

		if ( $blog_id instanceof WP_Site ) {
			$blog_id = (int) $blog_id->blog_id;
		}

		switch_to_blog( $blog_id );
		update_option( 'simple_local_avatars', $this->sanitize_options( $this->options ) );
		restore_current_blog();
	}

	/**
	 * Add some basic styling on the Discussion page
	 */
	public function admin_print_styles() {
		?>
		<style>
			.sla-enforced .simple-local-avatars th,
			.sla-enforced .simple-local-avatars label {
				opacity: 0.5;
				pointer-events: none;
			}

			.sla-enforced .simple-local-avatars .notice {
				margin-top: 20px;
			}

			@media screen and (min-width: 783px) {
				.sla-enforced .simple-local-avatars .notice {
					left: -220px;
					position: relative;
				}
			}
		</style>
		<?php
	}

	/**
	 * Adds admin body classes to the Discussion options screen
	 *
	 * @param string $classes Space-separated list of classes to apply to the body element.
	 *
	 * @return string
	 */
	public function admin_body_class( $classes ) {
		if ( $this->is_enforced() ) {
			$classes .= ' sla-enforced';
		}

		return $classes;
	}

	/**
	 * Clear user cache.
	 */
	public function sla_clear_user_cache() {
		check_ajax_referer( 'sla_clear_cache_nonce', 'nonce' );
		$step = isset( $_REQUEST['step'] ) ? intval( $_REQUEST['step'] ) : 1;

		// Setup defaults.
		$users_per_page = 50;
		$offset         = ( $step - 1 ) * $users_per_page;

		$users_query = new \WP_User_Query(
			array(
				'fields' => array( 'ID' ),
				'number' => $users_per_page,
				'offset' => $offset,
			)
		);

		// Total users in the site.
		$total_users = $users_query->get_total();

		// Get the users.
		$users = $users_query->get_results();

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user_id       = $user->ID;
				$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
				$media_id      = isset( $local_avatars['media_id'] ) ? $local_avatars['media_id'] : '';
				$this->clear_user_avatar_cache( $local_avatars, $user_id, $media_id );
			}

			wp_send_json_success(
				array(
					'step'    => $step + 1,
					'message' => sprintf(
					/* translators: 1: Offset, 2: Total users  */
						esc_html__( 'Processing %1$s/%2$s users...', 'simple-local-avatars' ),
						$offset,
						$total_users
					),
				)
			);
		}

		wp_send_json_success(
			array(
				'step'    => 'done',
				'message' => sprintf(
				/* translators: %s Total users */
					esc_html__( 'Completed clearing cache for all %s user(s) avatars.', 'simple-local-avatars' ),
					$total_users
				),
			)
		);
	}

	/**
	 * Clear avatar cache for given user.
	 *
	 * @param array $local_avatars Local avatars.
	 * @param int   $user_id       User ID.
	 * @param mixed $media_id      Media ID.
	 */
	private function clear_user_avatar_cache( $local_avatars, $user_id, $media_id ) {
		if ( ! empty( $media_id ) ) {
			// In order to support WP 4.9.
			if ( function_exists( 'wp_get_original_image_path' ) ) {
				$file_name_data = pathinfo( wp_get_original_image_path( $media_id ) );
			} else {
				$file_name_data = pathinfo( get_attached_file( $media_id ) );
			}

			$file_dir_name  = $file_name_data['dirname'];
			$file_name      = $file_name_data['filename'];
			$file_ext       = $file_name_data['extension'];
			foreach ( $local_avatars as $local_avatars_key => $local_avatar_value ) {
				if ( ! in_array( $local_avatars_key, [ 'media_id', 'full' ], true ) ) {
					$file_size_path = sprintf( '%1$s/%2$s-%3$sx%3$s.%4$s', $file_dir_name, $file_name, $local_avatars_key, $file_ext );
					if ( ! file_exists( $file_size_path ) ) {
						unset( $local_avatars[ $local_avatars_key ] );
					}
				}
			}

			// Update meta, remove sizes that don't exist.
			update_user_meta( $user_id, 'simple_local_avatar', $local_avatars );
		}
	}

	/**
	 * Add default avatar upload file field.
	 *
	 * @param array $defaults Default options for avatar.
	 *
	 * @return array Default options of avatar.
	 */
	public function add_avatar_default_field( $defaults ) {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		$default_avatar_file_url = '';
		$default_avatar_file_id  = get_option( 'simple_local_avatar_default', '' );
		if ( ! empty( $default_avatar_file_id ) ) {
			$default_avatar_file_url = wp_get_attachment_image_url( $default_avatar_file_id );
		}
		ob_start();
		?>
		<input type="hidden" name="simple-local-avatar-file-id" id="simple-local-avatar-file-id" value="<?php echo ! empty( $default_avatar_file_id ) ? esc_attr( $default_avatar_file_id ) : ''; ?>"/>
		<input type="hidden" name="simple-local-avatar-file-url" id="simple-local-avatar-file-url" value="<?php echo ! empty( $default_avatar_file_url ) ? esc_url( $default_avatar_file_url ) : ''; ?>"/>
		<input type="button" name="simple-local-avatar" id="simple-local-avatar-default" class="button-secondary" value="<?php esc_attr_e( 'Choose Default Avatar', 'simple-local-avatar' ); ?>"/>
		<?php
		$defaults['simple_local_avatar'] = ob_get_clean();

		return $defaults;
	}

	/**
	 * Save default avatar attachment id in option.
	 */
	private function save_default_avatar_file_id() {
		global $pagenow;

		$file_id = filter_input( INPUT_POST, 'simple-local-avatar-file-id', FILTER_SANITIZE_NUMBER_INT );

		// check for uploaded files
		if ( 'options.php' === $pagenow && ! empty( $file_id ) ) {
			update_option( 'simple_local_avatar_default', $file_id );
		}
	}

	/**
	 * Migrate the user's avatar data from WP User Avatar/ProfilePress
	 *
	 * This function creates a new option in the wp_options table to store the processed user IDs
	 * so that we can run this command multiple times without processing the same user over and over again.
	 *
	 * Credit to Philip John for the Gist
	 *
	 * @see https://gist.github.com/philipjohn/822d3521a95481f6ad7e118a7106fbc7
	 *
	 * @return int
	 */
	public function migrate_from_wp_user_avatar() {

		global $wpdb;

		$count = 0;

		// Support single site and multisite installs.
		// Use WordPress function if running multisite.
		// Create generic class if running single site.
		if ( is_multisite() ) {
			$sites = get_sites();
		} else {
			$site          = new stdClass();
			$site->blog_id = 1;
			$sites         = array( $site );
		}

		// Bail early if we don't find sites.
		if ( empty( $sites ) ) {
			return $count;
		}

		foreach ( $sites as $site ) {
			// Get the blog ID to use in the meta key and user query.
			$blog_id = isset( $site->blog_id ) ? $site->blog_id : 1;

			// Get the name of the meta key for WP User Avatar.
			$meta_key = $wpdb->get_blog_prefix( $blog_id ) . 'user_avatar';

			// Get processed users from database.
			$migrations      = get_option( 'simple_local_avatars_migrations', array() );
			$processed_users = isset( $migrations['wp_user_avatar'] ) ? $migrations['wp_user_avatar'] : array();

			// Get all users that have a local avatar.
			$users = get_users(
				array(
					'blog_id'      => $blog_id,
					'exclude'      => $processed_users,
					'meta_key'     => $meta_key,
					'meta_compare' => 'EXISTS',
				)
			);

			// Bail early if we don't find users.
			if ( empty( $users ) ) {
				continue;
			}

			foreach ( $users as $user ) {
				// Get the existing avatar media ID.
				$avatar_id = get_user_meta( $user->ID, $meta_key, true );

				// Attach the user and media to Simple Local Avatars.
				$sla = new Simple_Local_Avatars();
				$sla->assign_new_user_avatar( (int) $avatar_id, $user->ID );

				// Check that it worked.
				$is_migrated = get_user_meta( $user->ID, 'simple_local_avatar', true );

				if ( ! empty( $is_migrated ) ) {
					// Build array of user IDs.
					$migrations['wp_user_avatar'][] = $user->ID;

					// Record the user IDs so we don't process a second time.
					$is_saved = update_option( 'simple_local_avatars_migrations', $migrations );

					// Record how many avatars we migrate to be used in our messaging.
					if ( $is_saved ) {
						$count ++;
					}
				}
			}
		}

		return $count;
	}

	/**
	 * Migrate the user's avatar data away from WP User Avatar/ProfilePress via the dashboard.
	 *
	 * Sends the number of avatars processed back to the AJAX response before stopping execution.
	 *
	 * @return void
	 */
	public function ajax_migrate_from_wp_user_avatar() {
		// Bail early if nonce is not available.
		if ( empty( sanitize_text_field( $_POST['migrateFromWpUserAvatarNonce'] ) ) ) {
			die;
		}

		// Bail early if nonce is invalid.
		if ( ! wp_verify_nonce( sanitize_text_field( $_POST['migrateFromWpUserAvatarNonce'] ), 'migrate_from_wp_user_avatar_nonce' ) ) {
			die();
		}

		// Run the migration script and store the number of avatars processed.
		$count = $this->migrate_from_wp_user_avatar();

		// Create the array we send back to javascript here.
		$array_we_send_back = array( 'count' => $count );

		// Make sure to json encode the output because that's what it is expecting.
		echo wp_json_encode( $array_we_send_back );

		// Make sure you die when finished doing ajax output.
		wp_die();

	}

	/**
	 * Migrate the user's avatar data from WP User Avatar/ProfilePress via the command line.
	 *
	 * ## OPTIONS
	 *
	 * [--yes]
	 * : Skips the confirmations (for automated systems).
	 *
	 * ## EXAMPLES
	 *
	 *     $ wp simple-local-avatars migrate wp-user-avatar
	 *     Success: Number of avatars successfully migrated from WP User Avatar: 5
	 *
	 * @param array $args       The arguments.
	 * @param array $assoc_args The associative arguments.
	 *
	 * @return void
	 */
	public function wp_cli_migrate_from_wp_user_avatar( $args, $assoc_args ) {

		// Argument --yes to prevent confirmation (for automated systems).
		if ( ! isset( $assoc_args['yes'] ) ) {
			WP_CLI::confirm( esc_html__( 'Do you want to migrate avatars from WP User Avatar?', 'simple-local-avatars' ) );
		}

		// Run the migration script and store the number of avatars processed.
		$count = $this->migrate_from_wp_user_avatar();

		// Error out if we don't process any avatars.
		if ( 0 === absint( $count ) ) {
			WP_CLI::error( esc_html__( 'No avatars were migrated from WP User Avatar.', 'simple-local-avatars' ) );
		}

		WP_CLI::success(
			sprintf(
				'%s: %s',
				esc_html__( 'Number of avatars successfully migrated from WP User Avatar', 'simple-local-avatars' ),
				esc_html( $count )
			)
		);
	}
}
