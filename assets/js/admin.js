/* global ajaxurl, slaAdmin, jQuery */
( function ( $ ) {
	// Cache the button.
	const $clearCacheBtn = $( '#clear_cache_btn' );
	const $clearCacheMessage = $( '#clear_cache_message' );

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
} )( jQuery );
