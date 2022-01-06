/* global ajaxurl, slaAdmin, jQuery */
( function ( $ ) {
	// Cache the button.
	const $clearCacheBtn = $( '#clear_cache_btn' );
	const $clearCacheMessage = $( '#clear_cache_message' );
	const $simpleLocalAvatarUpload = $('#simple-local-avatar-upload');
	const $simpleLocalAvatarFileUrl = $('#simple-local-avatar-file-url');
	const $simpleLocalAvatarFileId = $('#simple-local-avatar-file-id');

	// Spinner button.
	const spinnerButton = '<span class="spinner is-active" style="margin-left:5px;margin-right:0;"></span>';

	// Bind events.
	$clearCacheBtn.on( 'click', function ( e ) {
		e.preventDefault();
		$clearCacheBtn.addClass( 'disabled' );
		$clearCacheBtn.append( spinnerButton );
		var data = {
			action: 'sla_clear_user_cache',
			nonce: slaAdmin.nonce,
		};
		processStep( 1, data );
	} );

	function removeSpinner() {
		$clearCacheBtn.find( 'span' ).remove();
		$clearCacheBtn.removeClass( 'disabled' );
	}

	/**
	 * Process steps.
	 *
	 * @param {Number} step For batch wise updates.
	 * @param {Object} data Data to pass to ajax request.
	 */
	function processStep( step, data ) {
		data.step = step;
		$.ajax( {
			url: ajaxurl,
			dataType: 'json',
			data: data,
			method: 'POST',
			success: function ( response ) {
				if ( response.success ) {
					if ( response.data.step === 'done' ) {
						$clearCacheMessage.text( response.data.message );
						removeSpinner();
					} else {
						$clearCacheMessage.text( response.data.message );
						processStep( parseInt( response.data.step, 10 ), data );
					}
					return false;
				} else {
					$clearCacheMessage.text( slaAdmin.error );
					removeSpinner();
				}
			},
			error: function () {
				$clearCacheMessage.text( slaAdmin.error );
				removeSpinner();
			},
		} );
	}

	$simpleLocalAvatarUpload.click(function(e) {
		e.preventDefault();
		var _this = $(this);
		var image = wp.media({
			title: slaAdmin.insertMediaTitle,
			multiple: false,
			library : {
				type : 'image',
			}
		}).open()
			.on('select', function(e){
				// This will return the selected image from the Media Uploader, the result is an object
				var uploaded_image = image.state().get('selection').first();
				uploaded_image = uploaded_image.toJSON();
				var avatar_preview = uploaded_image?.sizes?.thumbnail?.url;
				if ( typeof avatar_preview === 'undefined' ) {
					avatar_preview = uploaded_image.url;
				}
				var simpleDefaultAvatarImg = _this.parent().find('img.avatar');
				simpleDefaultAvatarImg.show();
				simpleDefaultAvatarImg.attr( 'src', avatar_preview );
				simpleDefaultAvatarImg.attr( 'srcset', avatar_preview );
				$simpleLocalAvatarFileUrl.val(avatar_preview);
				$simpleLocalAvatarFileId.val(avatar_preview);
			});
	});

	if ( $simpleLocalAvatarFileUrl.length && $simpleLocalAvatarFileUrl.val() !== '' ) {
		var $simpleDefaultAvatarImg = $simpleLocalAvatarFileUrl.parent().find('img.avatar');
		$simpleDefaultAvatarImg.attr('src', $simpleLocalAvatarFileUrl.val());
		$simpleDefaultAvatarImg.attr('srcset', $simpleLocalAvatarFileUrl.val());
	}

	if ( $simpleLocalAvatarFileId.val() === '' ) {
		$simpleLocalAvatarFileId.parent().find('img.avatar').hide();
	}
} )( jQuery );
