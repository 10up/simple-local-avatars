/* eslint-disable no-undef, eqeqeq, no-use-before-define */

let simple_local_avatar_frame;
let avatar_spinner;
let avatar_ratings;
let avatar_container;
let avatar_form_button;
let avatar_preview;
let avatar_input;
let avatar_blob;
let current_avatar;
let avatar_working = false;

jQuery(document).ready(function ($) {
	avatar_input = $('#simple-local-avatar');
	avatar_preview = $('#simple-local-avatar-photo img');
	current_avatar = avatar_preview.attr('src');
	avatar_ratings = $('#simple-local-avatar-ratings');
	avatar_container = $('#simple-local-avatar-photo');
	$('#simple-local-avatar-media').on('click', function (event) {
		event.preventDefault();

		if (avatar_working) {
			return;
		}

		/**
		 * Setup Crop control
		 * The controls used by WordPress Admin are api.CroppedImageControl and api.SiteIconControl.
		 */
		const cropControl = {
			id: 'control-id',
			params: {
				flex_width: false, // set to true if the width of the cropped image can be different to the width defined here
				flex_height: false, // set to true if the height of the cropped image can be different to the height defined here
				width: 200, // set the desired width of the destination image here
				height: 200, // set the desired height of the destination image here
			},
		};

		/**
		 * Return whether the image must be cropped, based on required dimensions.
		 *
		 * @param {boolean} flexW
		 * @param {boolean} flexH
		 * @param {number}  distW
		 * @param {number}  distH
		 * @param {number}  imgW
		 * @param {number}  imgH
		 * @returns {boolean}
		 */
		cropControl.mustBeCropped = function (flexW, flexH, distW, distH, imgW, imgH) {
			// Skip cropping if the image matches the crop dimension.
			if (imgW === distW && imgH === distH) {
				return false;
			}

			return true;
		};

		/**
		 * Create a media modal select frame, we need to set this up every time instead of reusing if already there
		 * as the toolbar button does not get reset when doing the following:
		 * simple_local_avatar_frame.setState('library');
		 * simple_local_avatar_frame.open();
		 */
		simple_local_avatar_frame = wp.media({
			button: {
				text: i10n_SimpleLocalAvatars.selectCrop, // l10n.selectAndCrop,
				close: false,
			},
			states: [
				new wp.media.controller.Library({
					title: i10n_SimpleLocalAvatars.selectCrop, // l10n.selectAndCrop,
					library: wp.media.query({ type: 'image' }),
					multiple: false, // We set multiple to false so only get one image from the uploader
					date: false,
					priority: 20,
					suggestedWidth: 200,
					suggestedHeight: 200,
				}),
				new wp.media.controller.CustomizeImageCropper({
					imgSelectOptions: simple_local_avatar_calculate_image_select_options,
					control: cropControl,
				}),
			],
		});

		/**
		 * After the image has been cropped, apply the cropped image data to the setting
		 *
		 * @param {object} croppedImage Cropped attachment data.
		 */
		simple_local_avatar_frame.on('cropped', function (croppedImage) {
			const { url } = croppedImage;
			const attachmentId = croppedImage.id;
			const w = croppedImage.width;
			const h = croppedImage.height;

			simple_local_avatar_set_image_from_url(url, attachmentId, w, h);
		});

		/**
		 * If cropping was skipped, apply the image data directly to the setting.
		 */
		simple_local_avatar_frame.on('skippedcrop', function (selection) {
			const url = selection.get('url');
			const w = selection.get('width');
			const h = selection.get('height');

			simple_local_avatar_set_image_from_url(url, selection.id, w, h);
		});

		/**
		 * After an image is selected in the media modal, switch to the cropper
		 * state if the image isn't the right size.
		 */
		simple_local_avatar_frame.on('select', function () {
			const avatarAttachment = simple_local_avatar_frame
				.state()
				.get('selection')
				.first()
				.toJSON();

			if (
				cropControl.params.width === avatarAttachment.width &&
				cropControl.params.height === avatarAttachment.height &&
				!cropControl.params.flex_width &&
				!cropControl.params.flex_height
			) {
				avatarAttachment.dst_width = avatarAttachment.width;
				avatarAttachment.dst_height = avatarAttachment.height;
				simple_local_avatar_set_image_from_attachment(avatarAttachment);
				simple_local_avatar_frame.close();
			} else {
				simple_local_avatar_frame.setState('cropper');
			}
		});

		simple_local_avatar_frame.open();
	});

	/**
	 * If the Local Avatar is removed and set to the  default one
	 */
	$('#simple-local-avatar-remove').on('click', function (event) {
		event.preventDefault();

		if (avatar_working) return;

		avatar_lock('lock');
		$.get(ajaxurl, {
			action: 'remove_simple_local_avatar',
			user_id: i10n_SimpleLocalAvatars.user_id,
			_wpnonce: i10n_SimpleLocalAvatars.deleteNonce,
		})
			.done(function (data) {
				if (data !== '') {
					avatar_container.innerHTML = data;
					$('#simple-local-avatar-remove').hide();
					avatar_ratings.disabled = true;
				}
			})
			.always(function () {
				avatar_lock('unlock');
			});
	});

	/**
	 * Update the Local Avatar image
	 */
	avatar_input.on('change', function (event) {
		avatar_preview.attr('srcset', '');
		avatar_preview.attr('height', 'auto');
		URL.revokeObjectURL(avatar_blob);
		if (event.target.files.length > 0) {
			avatar_blob = URL.createObjectURL(event.target.files[0]);
			avatar_preview.attr('src', avatar_blob);
		} else {
			avatar_preview.attr('src', current_avatar);
		}
	});

	$( document.getElementById('simple-local-avatars-migrate-from-wp-user-avatar') ).on( 'click', function(event) {
		event.preventDefault();
		jQuery.post( ajaxurl, { action: 'migrate_from_wp_user_avatar', migrateFromWpUserAvatarNonce: i10n_SimpleLocalAvatars.migrateFromWpUserAvatarNonce } )
			.always( function() {
				$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').empty();
				$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').text(i10n_SimpleLocalAvatars.migrateFromWpUserAvatarProgress);
			})
			.done( function( response ) {
				$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').empty();
				const data = $.parseJSON(response);
				const count = data.count;
				if ( 0 === count ) {
					$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').text(
						i10n_SimpleLocalAvatars.migrateFromWpUserAvatarFailure
					);
				}
				if ( count > 0 ) {
					$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').text(
						i10n_SimpleLocalAvatars.migrateFromWpUserAvatarSuccess + ': ' + count
					);
				}
				setTimeout(function() {
					$('.simple-local-avatars-migrate-from-wp-user-avatar-progress').empty();
				}, 5000);
			});
	});
});

/**
 * Lock or unlock the avatar editing
 * @param {string} lock_or_unlock
 */
function avatar_lock(lock_or_unlock) {
	if (undefined === avatar_spinner) {
		avatar_ratings = document.getElementById('simple-local-avatar-ratings');
		avatar_spinner = jQuery(document.getElementById('simple-local-avatar-spinner'));
		avatar_container = document.getElementById('simple-local-avatar-photo');
		avatar_form_button = jQuery(avatar_ratings).closest('form').find('input[type=submit]');
	}

	if (lock_or_unlock === 'unlock') {
		avatar_working = false;
		avatar_form_button.removeAttr('disabled');
		avatar_spinner.hide();
	} else {
		avatar_working = true;
		avatar_form_button.attr('disabled', 'disabled');
		avatar_spinner.show();
	}
}

/**
 * Returns a set of options, computed from the attached image data and
 * control-specific data, to be fed to the imgAreaSelect plugin in
 * wp.media.view.Cropper
 *
 * @param {wp.media.model.Attachment} attachment
 * @param {wp.media.controller.Cropper} controller
 * @returns {object} Options
 */
function simple_local_avatar_calculate_image_select_options(attachment, controller) {
	const control = controller.get('control');

	const realWidth = attachment.get('width');
	const realHeight = attachment.get('height');

	let xInit = parseInt(control.params.width, 10);
	let yInit = parseInt(control.params.height, 10);

	const ratio = xInit / yInit;

	controller.set(
		'canSkipCrop',
		!control.mustBeCropped(false, false, xInit, yInit, realWidth, realHeight),
	);

	const xImg = xInit;
	const yImg = yInit;

	if (realWidth / realHeight > ratio) {
		yInit = realHeight;
		xInit = yInit * ratio;
	} else {
		xInit = realWidth;
		yInit = xInit / ratio;
	}

	const x1 = (realWidth - xInit) / 2;
	const y1 = (realHeight - yInit) / 2;

	return {
		handles: true,
		keys: true,
		instance: true,
		persistent: true,
		imageWidth: realWidth,
		imageHeight: realHeight,
		minWidth: xImg > xInit ? xInit : xImg,
		minHeight: yImg > yInit ? yInit : yImg,
		x1,
		y1,
		x2: xInit + x1,
		y2: yInit + y1,
		aspectRatio: `${xInit}:${yInit}`,
	};
}

/**
 * Creates a new wp.customize.HeaderTool.ImageModel from provided
 * header image data and inserts it into the user-uploaded headers
 * collection
 *
 * @param {string} url
 * @param {number} attachmentId
 * @param {number} width
 * @param {number} height
 */
function simple_local_avatar_set_image_from_url(url, attachmentId, width, height) {
	const data = {};

	data.url = url;
	data.thumbnail_url = url;
	data.timestamp = _.now();

	if (attachmentId) {
		data.attachment_id = attachmentId;
	}

	if (width) {
		data.width = width;
	}

	if (height) {
		data.height = height;
	}

	avatar_lock('lock');
	jQuery
		.post(ajaxurl, {
			action: 'assign_simple_local_avatar_media',
			media_id: attachmentId,
			user_id: i10n_SimpleLocalAvatars.user_id,
			_wpnonce: i10n_SimpleLocalAvatars.mediaNonce,
		})
		.done(function (data) {
			if (data !== '') {
				avatar_container.innerHTML = data;
				jQuery('#simple-local-avatar-remove').show();
				avatar_ratings.disabled = false;
			}
		})
		.always(function () {
			avatar_lock('unlock');
		});
}

/**
 * Set the avatar image, once it is selected from the media library. 
 *
 * @param {object} attachment
 */
function simple_local_avatar_set_image_from_attachment(attachment) {
	avatar_lock('lock');
	jQuery
		.post(ajaxurl, {
			action: 'assign_simple_local_avatar_media',
			media_id: attachment.id,
			user_id: i10n_SimpleLocalAvatars.user_id,
			_wpnonce: i10n_SimpleLocalAvatars.mediaNonce,
		})
		.done(function (data) {
			if (data !== '') {
				avatar_container.innerHTML = data;
				jQuery('#simple-local-avatar-remove').show();
				avatar_ratings.disabled = false;
				avatar_lock('unlock');
			}
		})
		.always(function () {
			avatar_lock('unlock');
		});
}

/* eslint-enable no-undef, eqeqeq, no-use-before-define */