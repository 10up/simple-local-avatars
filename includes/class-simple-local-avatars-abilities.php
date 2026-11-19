<?php
/**
 * Abilities API integration.
 *
 * Registers abilities that let AI agents, automation tools and other clients
 * read, assign, update and remove local avatars.
 *
 * @see https://make.wordpress.org/ai/handbook/projects/abilities-api/
 *
 * @package SimpleLocalAvatars
 */

/**
 * Registers the Simple Local Avatars abilities.
 *
 * @since x.x.x
 */
class Simple_Local_Avatars_Abilities {

	/**
	 * Ability category slug.
	 *
	 * @var string
	 */
	const CATEGORY = 'simple-local-avatars';

	/**
	 * Ability name prefix.
	 *
	 * @var string
	 */
	const PREFIX = 'simple-local-avatars/';

	/**
	 * Default avatar size, in pixels, used to build `avatar_url`.
	 *
	 * @var int
	 */
	const DEFAULT_SIZE = 96;

	/**
	 * Main plugin instance.
	 *
	 * @var Simple_Local_Avatars
	 */
	private $plugin;

	/**
	 * Constructor.
	 *
	 * @param Simple_Local_Avatars $plugin Main plugin instance.
	 */
	public function __construct( Simple_Local_Avatars $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register hooks when the Abilities API is available (WordPress 6.9+).
	 */
	public function add_hooks() {
		if ( ! function_exists( 'wp_register_ability' ) ) {
			return;
		}

		add_action( 'wp_abilities_api_categories_init', array( $this, 'register_category' ) );
		add_action( 'wp_abilities_api_init', array( $this, 'register_abilities' ) );
	}

	/**
	 * Whether the plugin should register its abilities.
	 *
	 * @return bool
	 */
	private function is_enabled() {
		/**
		 * Filter whether Simple Local Avatars registers its abilities.
		 *
		 * @since x.x.x
		 *
		 * @param bool $enabled Whether to register the abilities. Default true.
		 */
		return (bool) apply_filters( 'simple_local_avatars_register_abilities', true );
	}

	/**
	 * Register the ability category.
	 */
	public function register_category() {
		if ( ! $this->is_enabled() ) {
			return;
		}

		wp_register_ability_category(
			self::CATEGORY,
			array(
				'label'       => __( 'Local Avatars', 'simple-local-avatars' ),
				'description' => __( 'Abilities that read, assign, update and remove local user avatars.', 'simple-local-avatars' ),
			)
		);
	}

	/**
	 * Register the abilities.
	 */
	public function register_abilities() {
		if ( ! $this->is_enabled() ) {
			return;
		}

		$rating_codes = array_keys( $this->plugin->get_avatar_ratings() );

		$user_id_property = array(
			'type'        => 'integer',
			'minimum'     => 1,
			'description' => __( 'ID of the user. Defaults to the current user.', 'simple-local-avatars' ),
		);

		$size_property = array(
			'type'        => 'integer',
			'minimum'     => 1,
			'maximum'     => 2048,
			'default'     => self::DEFAULT_SIZE,
			'description' => __( 'Size in pixels of the square image returned in avatar_url.', 'simple-local-avatars' ),
		);

		$rating_property = array(
			'type'        => 'string',
			'enum'        => $rating_codes,
			'description' => __( 'Content rating of the avatar. The site hides avatars rated above its maximum rating.', 'simple-local-avatars' ),
		);

		wp_register_ability(
			self::PREFIX . 'get-avatar',
			array(
				'label'               => __( 'Get local avatar', 'simple-local-avatars' ),
				'description'         => __( 'Returns the local avatar of a user: attachment ID, image URLs, rating and alt text. When the user has no local avatar, has_local_avatar is false and avatar_url is the fallback avatar.', 'simple-local-avatars' ),
				'category'            => self::CATEGORY,
				'input_schema'        => array(
					'type'                 => 'object',
					'default'              => array(),
					'properties'           => array(
						'user_id' => $user_id_property,
						'size'    => $size_property,
					),
					'additionalProperties' => false,
				),
				'output_schema'       => $this->get_avatar_schema(),
				'execute_callback'    => array( $this, 'execute_get_avatar' ),
				'permission_callback' => array( $this, 'can_view_avatar' ),
				'meta'                => $this->get_meta(
					array(
						'readonly'    => true,
						'destructive' => false,
						'idempotent'  => true,
					)
				),
			)
		);

		wp_register_ability(
			self::PREFIX . 'list-avatars',
			array(
				'label'               => __( 'List local avatars', 'simple-local-avatars' ),
				'description'         => __( 'Returns a paginated list of users on this site who have a local avatar, with each avatar\'s details.', 'simple-local-avatars' ),
				'category'            => self::CATEGORY,
				'input_schema'        => array(
					'type'                 => 'object',
					'default'              => array(),
					'properties'           => array(
						'page'     => array(
							'type'        => 'integer',
							'minimum'     => 1,
							'default'     => 1,
							'description' => __( 'Page of results to return.', 'simple-local-avatars' ),
						),
						'per_page' => array(
							'type'        => 'integer',
							'minimum'     => 1,
							'maximum'     => 100,
							'default'     => 20,
							'description' => __( 'Number of users per page.', 'simple-local-avatars' ),
						),
						'size'     => $size_property,
					),
					'additionalProperties' => false,
				),
				'output_schema'       => array(
					'type'       => 'object',
					'properties' => array(
						'avatars'     => array(
							'type'  => 'array',
							'items' => $this->get_avatar_schema(),
						),
						'total'       => array(
							'type'        => 'integer',
							'description' => __( 'Total number of users with a local avatar.', 'simple-local-avatars' ),
						),
						'total_pages' => array(
							'type'        => 'integer',
							'description' => __( 'Total number of pages.', 'simple-local-avatars' ),
						),
					),
					'required'   => array( 'avatars', 'total', 'total_pages' ),
				),
				'execute_callback'    => array( $this, 'execute_list_avatars' ),
				'permission_callback' => array( $this, 'can_list_avatars' ),
				'meta'                => $this->get_meta(
					array(
						'readonly'    => true,
						'destructive' => false,
						'idempotent'  => true,
					)
				),
			)
		);

		wp_register_ability(
			self::PREFIX . 'set-avatar',
			array(
				'label'               => __( 'Set local avatar', 'simple-local-avatars' ),
				'description'         => __( 'Assigns an image from the media library as the local avatar of a user. Replaces any existing local avatar and deletes its resized copies. The rating defaults to G.', 'simple-local-avatars' ),
				'category'            => self::CATEGORY,
				'input_schema'        => array(
					'type'                 => 'object',
					'properties'           => array(
						'user_id'  => $user_id_property,
						'media_id' => array(
							'type'        => 'integer',
							'minimum'     => 1,
							'description' => __( 'ID of an image attachment in the media library.', 'simple-local-avatars' ),
						),
						'rating'   => $rating_property,
					),
					'required'             => array( 'media_id' ),
					'additionalProperties' => false,
				),
				'output_schema'       => $this->get_avatar_schema(),
				'execute_callback'    => array( $this, 'execute_set_avatar' ),
				'permission_callback' => array( $this, 'can_set_avatar' ),
				'meta'                => $this->get_meta(
					array(
						'readonly'    => false,
						'destructive' => true,
					)
				),
			)
		);

		wp_register_ability(
			self::PREFIX . 'update-avatar-rating',
			array(
				'label'               => __( 'Update local avatar rating', 'simple-local-avatars' ),
				'description'         => __( 'Changes the content rating of a user\'s existing local avatar. Fails when the user has no local avatar.', 'simple-local-avatars' ),
				'category'            => self::CATEGORY,
				'input_schema'        => array(
					'type'                 => 'object',
					'properties'           => array(
						'user_id' => $user_id_property,
						'rating'  => $rating_property,
					),
					'required'             => array( 'rating' ),
					'additionalProperties' => false,
				),
				'output_schema'       => $this->get_avatar_schema(),
				'execute_callback'    => array( $this, 'execute_update_avatar_rating' ),
				'permission_callback' => array( $this, 'can_edit_avatar' ),
				'meta'                => $this->get_meta(
					array(
						'readonly'    => false,
						'destructive' => false,
						'idempotent'  => true,
					)
				),
			)
		);

		wp_register_ability(
			self::PREFIX . 'delete-avatar',
			array(
				'label'               => __( 'Delete local avatar', 'simple-local-avatars' ),
				'description'         => __( 'Removes the local avatar of a user and deletes its resized copies. The original media library image is kept. The user then shows the fallback avatar.', 'simple-local-avatars' ),
				'category'            => self::CATEGORY,
				'input_schema'        => array(
					'type'                 => 'object',
					'default'              => array(),
					'properties'           => array(
						'user_id' => $user_id_property,
					),
					'additionalProperties' => false,
				),
				'output_schema'       => array(
					'type'       => 'object',
					'properties' => array(
						'user_id' => array(
							'type' => 'integer',
						),
						'deleted' => array(
							'type'        => 'boolean',
							'description' => __( 'True when a local avatar was removed. False when the user had none.', 'simple-local-avatars' ),
						),
					),
					'required'   => array( 'user_id', 'deleted' ),
				),
				'execute_callback'    => array( $this, 'execute_delete_avatar' ),
				'permission_callback' => array( $this, 'can_edit_avatar' ),
				'meta'                => $this->get_meta(
					array(
						'readonly'    => false,
						'destructive' => true,
						'idempotent'  => true,
					)
				),
			)
		);
	}

	/**
	 * Build the ability meta array.
	 *
	 * @param array $annotations Behavior annotations.
	 * @return array
	 */
	private function get_meta( $annotations ) {
		return array(
			'annotations'  => $annotations,
			'public'       => true,
			'show_in_rest' => true,
		);
	}

	/**
	 * JSON Schema of a single avatar result.
	 *
	 * @return array
	 */
	private function get_avatar_schema() {
		return array(
			'type'       => 'object',
			'properties' => array(
				'user_id'          => array(
					'type'        => 'integer',
					'description' => __( 'ID of the user.', 'simple-local-avatars' ),
				),
				'has_local_avatar' => array(
					'type'        => 'boolean',
					'description' => __( 'Whether the user has a local avatar.', 'simple-local-avatars' ),
				),
				'media_id'         => array(
					'type'        => array( 'integer', 'null' ),
					'description' => __( 'ID of the avatar attachment, or null when the avatar is not a media library image.', 'simple-local-avatars' ),
				),
				'full_url'         => array(
					'type'        => array( 'string', 'null' ),
					'description' => __( 'URL of the full-size local avatar image, or null when there is none.', 'simple-local-avatars' ),
				),
				'avatar_url'       => array(
					'type'        => 'string',
					'description' => __( 'URL that the site shows for this user at the requested size. It is the fallback avatar when the local avatar is missing or rated above the site maximum.', 'simple-local-avatars' ),
				),
				'size'             => array(
					'type'        => 'integer',
					'description' => __( 'Size in pixels of avatar_url.', 'simple-local-avatars' ),
				),
				'rating'           => array(
					'type'        => array( 'string', 'null' ),
					'description' => __( 'Content rating of the local avatar, or null when there is none.', 'simple-local-avatars' ),
				),
				'alt'              => array(
					'type'        => 'string',
					'description' => __( 'Alt text for the avatar image.', 'simple-local-avatars' ),
				),
			),
			'required'   => array( 'user_id', 'has_local_avatar', 'media_id', 'full_url', 'avatar_url', 'size', 'rating', 'alt' ),
		);
	}

	/**
	 * Get the target user ID from ability input, defaulting to the current user.
	 *
	 * @param mixed $input Ability input.
	 * @return int
	 */
	private function get_input_user_id( $input ) {
		if ( is_array( $input ) && ! empty( $input['user_id'] ) ) {
			return absint( $input['user_id'] );
		}

		return get_current_user_id();
	}

	/**
	 * Get the requested avatar size from ability input.
	 *
	 * @param mixed $input Ability input.
	 * @return int
	 */
	private function get_input_size( $input ) {
		if ( is_array( $input ) && ! empty( $input['size'] ) ) {
			return min( 2048, max( 1, absint( $input['size'] ) ) );
		}

		return self::DEFAULT_SIZE;
	}

	/**
	 * Permission check: view the avatar details of a user.
	 *
	 * Users can view their own avatar. Viewing another user's avatar needs
	 * `list_users` or `edit_user` for that user.
	 *
	 * @param mixed $input Ability input.
	 * @return bool
	 */
	public function can_view_avatar( $input = null ) {
		$user_id = $this->get_input_user_id( $input );

		if ( ! $user_id || ! is_user_logged_in() ) {
			return false;
		}

		if ( get_current_user_id() === $user_id ) {
			return true;
		}

		return current_user_can( 'list_users' ) || current_user_can( 'edit_user', $user_id );
	}

	/**
	 * Permission check: list users with a local avatar.
	 *
	 * @return bool
	 */
	public function can_list_avatars() {
		return current_user_can( 'list_users' );
	}

	/**
	 * Permission check: assign a media library image as a user's avatar.
	 *
	 * Matches the profile screen: the current user needs `upload_files`
	 * and `edit_user` for the target user.
	 *
	 * @param mixed $input Ability input.
	 * @return bool
	 */
	public function can_set_avatar( $input = null ) {
		return current_user_can( 'upload_files' ) && $this->can_edit_avatar( $input );
	}

	/**
	 * Permission check: change or remove a user's avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return bool
	 */
	public function can_edit_avatar( $input = null ) {
		$user_id = $this->get_input_user_id( $input );

		return $user_id && current_user_can( 'edit_user', $user_id );
	}

	/**
	 * Execute: get a user's avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return array|WP_Error
	 */
	public function execute_get_avatar( $input = null ) {
		$user_id = $this->get_input_user_id( $input );
		$error   = $this->validate_user( $user_id );

		if ( is_wp_error( $error ) ) {
			return $error;
		}

		return $this->prepare_avatar( $user_id, $this->get_input_size( $input ) );
	}

	/**
	 * Execute: list users with a local avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return array
	 */
	public function execute_list_avatars( $input = null ) {
		$input    = is_array( $input ) ? $input : array();
		$page     = ! empty( $input['page'] ) ? max( 1, absint( $input['page'] ) ) : 1;
		$per_page = ! empty( $input['per_page'] ) ? min( 100, max( 1, absint( $input['per_page'] ) ) ) : 20;
		$size     = $this->get_input_size( $input );

		$query = new WP_User_Query(
			array(
				'meta_key'    => $this->plugin->get_user_meta_key(), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'fields'      => 'ID',
				'number'      => $per_page,
				'paged'       => $page,
				'orderby'     => 'ID',
				'order'       => 'ASC',
				'count_total' => true,
			)
		);

		$avatars = array();
		foreach ( $query->get_results() as $user_id ) {
			$avatars[] = $this->prepare_avatar( (int) $user_id, $size );
		}

		$total = (int) $query->get_total();

		return array(
			'avatars'     => $avatars,
			'total'       => $total,
			'total_pages' => (int) ceil( $total / $per_page ),
		);
	}

	/**
	 * Execute: assign a media library image as a user's avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return array|WP_Error
	 */
	public function execute_set_avatar( $input = null ) {
		$input   = is_array( $input ) ? $input : array();
		$user_id = $this->get_input_user_id( $input );
		$error   = $this->validate_user( $user_id );

		if ( is_wp_error( $error ) ) {
			return $error;
		}

		$media_id   = isset( $input['media_id'] ) ? absint( $input['media_id'] ) : 0;
		$attachment = $media_id ? get_post( $media_id ) : null;

		if (
			! $attachment
			|| 'attachment' !== $attachment->post_type
			|| ! wp_attachment_is_image( $attachment )
		) {
			return new WP_Error(
				'simple_local_avatars_invalid_media',
				__( 'The media_id does not match an image in the media library.', 'simple-local-avatars' ),
				array( 'status' => 400 )
			);
		}

		if ( ! current_user_can( 'read_post', $media_id ) ) {
			return new WP_Error(
				'simple_local_avatars_forbidden_media',
				__( 'You are not allowed to use this image.', 'simple-local-avatars' ),
				array( 'status' => 403 )
			);
		}

		$ratings = $this->plugin->get_avatar_ratings();
		$rating  = isset( $input['rating'] ) ? (string) $input['rating'] : (string) key( $ratings );

		if ( ! array_key_exists( $rating, $ratings ) ) {
			return $this->invalid_rating_error();
		}

		$this->plugin->assign_new_user_avatar( $media_id, $user_id );

		// assign_new_user_avatar() clears the stored rating, so save it afterwards.
		$this->plugin->update_user_avatar_rating( $user_id, $rating );

		return $this->prepare_avatar( $user_id, self::DEFAULT_SIZE );
	}

	/**
	 * Execute: change the rating of a user's avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return array|WP_Error
	 */
	public function execute_update_avatar_rating( $input = null ) {
		$input   = is_array( $input ) ? $input : array();
		$user_id = $this->get_input_user_id( $input );
		$error   = $this->validate_user( $user_id );

		if ( is_wp_error( $error ) ) {
			return $error;
		}

		if ( empty( $this->plugin->get_user_local_avatar( $user_id ) ) ) {
			return new WP_Error(
				'simple_local_avatars_no_avatar',
				__( 'This user has no local avatar.', 'simple-local-avatars' ),
				array( 'status' => 404 )
			);
		}

		$rating = isset( $input['rating'] ) ? (string) $input['rating'] : '';

		if ( ! $this->plugin->update_user_avatar_rating( $user_id, $rating ) ) {
			return $this->invalid_rating_error();
		}

		return $this->prepare_avatar( $user_id, self::DEFAULT_SIZE );
	}

	/**
	 * Execute: remove a user's avatar.
	 *
	 * @param mixed $input Ability input.
	 * @return array|WP_Error
	 */
	public function execute_delete_avatar( $input = null ) {
		$user_id = $this->get_input_user_id( $input );
		$error   = $this->validate_user( $user_id );

		if ( is_wp_error( $error ) ) {
			return $error;
		}

		$had_avatar = ! empty( $this->plugin->get_user_local_avatar( $user_id ) );

		if ( $had_avatar ) {
			$this->plugin->avatar_delete( $user_id );
		}

		return array(
			'user_id' => $user_id,
			'deleted' => $had_avatar,
		);
	}

	/**
	 * Ensure the user exists.
	 *
	 * @param int $user_id User ID.
	 * @return true|WP_Error
	 */
	private function validate_user( $user_id ) {
		if ( ! $user_id || ! get_userdata( $user_id ) ) {
			return new WP_Error(
				'simple_local_avatars_invalid_user',
				__( 'The user does not exist.', 'simple-local-avatars' ),
				array( 'status' => 404 )
			);
		}

		return true;
	}

	/**
	 * Error returned for an unknown rating code.
	 *
	 * @return WP_Error
	 */
	private function invalid_rating_error() {
		return new WP_Error(
			'simple_local_avatars_invalid_rating',
			sprintf(
				/* translators: %s: comma-separated list of rating codes. */
				__( 'The rating must be one of: %s.', 'simple-local-avatars' ),
				implode( ', ', array_keys( $this->plugin->get_avatar_ratings() ) )
			),
			array( 'status' => 400 )
		);
	}

	/**
	 * Build the avatar result for a user.
	 *
	 * @param int $user_id User ID.
	 * @param int $size    Size in pixels of avatar_url.
	 * @return array
	 */
	private function prepare_avatar( $user_id, $size ) {
		$local_avatar = $this->plugin->get_user_local_avatar( $user_id );
		$has_avatar   = ! empty( $local_avatar['full'] );
		$full_url     = null;
		$rating       = null;

		if ( $has_avatar ) {
			$full_url = (string) $local_avatar['full'];
			if ( 'http' !== substr( $full_url, 0, 4 ) ) {
				$full_url = home_url( $full_url );
			}
			$full_url = esc_url_raw( $full_url );

			$stored_rating = $this->plugin->get_user_avatar_rating( $user_id );
			$rating        = '' !== $stored_rating ? $stored_rating : null;
		}

		return array(
			'user_id'          => (int) $user_id,
			'has_local_avatar' => $has_avatar,
			'media_id'         => $has_avatar && ! empty( $local_avatar['media_id'] ) ? (int) $local_avatar['media_id'] : null,
			'full_url'         => $full_url,
			'avatar_url'       => (string) get_avatar_url( $user_id, array( 'size' => $size ) ),
			'size'             => (int) $size,
			'rating'           => $rating,
			'alt'              => (string) $this->plugin->get_simple_local_avatar_alt( $user_id ),
		);
	}
}
