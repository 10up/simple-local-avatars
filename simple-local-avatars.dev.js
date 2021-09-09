var simple_local_avatar_frame,
	avatar_spinner,
	avatar_ratings,
	avatar_container,
	avatar_form_button,
	avatar_preview,
	avatar_input,
	avatar_blob,
	current_avatar,
	mediaUploader;
var avatar_working = false;

jQuery(document).ready(function($){
	avatar_input = $( '#simple-local-avatar' );
	avatar_preview = $( '#simple-local-avatar-photo img' );
	current_avatar = avatar_preview.attr( 'src' );
	avatar_ratings = document.getElementById('simple-local-avatar-ratings');
	avatar_container = document.getElementById('simple-local-avatar-photo');
	$( document.getElementById('simple-local-avatar-media') ).on( 'click', function(event) {
		event.preventDefault();

		if ( avatar_working )
			return;

		if ( simple_local_avatar_frame ) {
			simple_local_avatar_frame.open();
			return;
		}

    	// simple_local_avatar_frame = wp.media.frames.simple_local_avatar_frame = wp.media({
		// 	title: i10n_SimpleLocalAvatars.insertMediaTitle,
		// 	button: { text: i10n_SimpleLocalAvatars.insertIntoPost },
		// 	library : { type : 'image'},
		// 	multiple: false
		// });

    // simple_local_avatar_frame.on( 'select', function() {
    // 	// We set multiple to false so only get one image from the uploader
    // 	avatar_lock('lock');
    // 	var avatar_url = simple_local_avatar_frame.state().get('selection').first().toJSON().id;
    // 	jQuery.post( ajaxurl, { action: 'assign_simple_local_avatar_media', media_id: avatar_url, user_id: i10n_SimpleLocalAvatars.user_id, _wpnonce: i10n_SimpleLocalAvatars.mediaNonce }, function(data) {
    // 		if ( data != '' ) {
    // 			avatar_container.innerHTML = data;
    // 			$( document.getElementById('simple-local-avatar-remove') ).show();
    // 			avatar_ratings.disabled = false;
    // 			avatar_lock('unlock');
    // 		}
    // 	});
    // });

    // simple_local_avatar_frame.open();

    /* We need to setup a Crop control that contains a few parameters
       and a method to indicate if the CropController can skip cropping the image.
       In this example I am just creating a control on the fly with the expected properties.
       However, the controls used by WordPress Admin are api.CroppedImageControl and api.SiteIconControl
    */

	   var cropControl = {
		id: "control-id",
		params : {
		  flex_width : false,  // set to true if the width of the cropped image can be different to the width defined here
		  flex_height : false, // set to true if the height of the cropped image can be different to the height defined here
		  width : 300,  // set the desired width of the destination image here
		  height : 200, // set the desired height of the destination image here
		}
	};

	cropControl.mustBeCropped = function(flexW, flexH, dstW, dstH, imgW, imgH) {

		// If the width and height are both flexible
		// then the user does not need to crop the image.
	
		if ( true === flexW && true === flexH ) {
			return false;
		}
	
		// If the width is flexible and the cropped image height matches the current image height, 
		// then the user does not need to crop the image.
		if ( true === flexW && dstH === imgH ) {
			return false;
		}
	
		// If the height is flexible and the cropped image width matches the current image width, 
		// then the user does not need to crop the image.        
		if ( true === flexH && dstW === imgW ) {
			return false;
		}
	
		// If the cropped image width matches the current image width, 
		// and the cropped image height matches the current image height
		// then the user does not need to crop the image.               
		if ( dstW === imgW && dstH === imgH ) {
			return false;
		}
	
		// If the destination width is equal to or greater than the cropped image width
		// then the user does not need to crop the image...
		if ( imgW <= dstW ) {
			return false;
		}
	
		return true;        
	
	};

	/* NOTE: Need to set this up every time instead of reusing if already there 
	as the toolbar button does not get reset when doing the following:

	mediaUploader.setState('library');
    mediaUploader.open();

    */

	mediaUploader = wp.media({
        button: {
            text: 'Select and Crop', // l10n.selectAndCrop,
            close: false
        },
        states: [
            new wp.media.controller.Library({
                title:     'Select and Crop', // l10n.chooseImage,
                library:   wp.media.query({ type: 'image' }),
                multiple:  false,
                date:      false,
                priority:  20,
                suggestedWidth: 300,
                suggestedHeight: 200
            }),
            new wp.media.controller.CustomizeImageCropper({ 
                imgSelectOptions: myTheme_calculateImageSelectOptions,
                control: cropControl
            })
        ]
    });

	mediaUploader.on('cropped', function(croppedImage) {

        var url = croppedImage.url,
            attachmentId = croppedImage.id,
            w = croppedImage.width,
            h = croppedImage.height;

            myTheme_setImageFromURL(url, attachmentId, w, h);            

    });

    mediaUploader.on('skippedcrop', function(selection) {

        var url = selection.get('url'),
            w = selection.get('width'),
            h = selection.get('height');

            myTheme_setImageFromURL(url, selection.id, w, h);            

    });        

    mediaUploader.on("select", function() {

        var attachment = mediaUploader.state().get( 'selection' ).first().toJSON();

        if (     cropControl.params.width  === attachment.width 
            &&   cropControl.params.height === attachment.height 
            && ! cropControl.params.flex_width 
            && ! cropControl.params.flex_height ) {
                myTheme_setImageFromAttachment( attachment );
            mediaUploader.close();
        } else {
            mediaUploader.setState( 'cropper' );
        }

    });

	mediaUploader.open();

  });

	$( document.getElementById('simple-local-avatar-remove') ).on('click',function(event){
		event.preventDefault();

		if ( avatar_working )
			return;

		avatar_lock('lock');
		$.get( ajaxurl, { action: 'remove_simple_local_avatar', user_id: i10n_SimpleLocalAvatars.user_id, _wpnonce: i10n_SimpleLocalAvatars.deleteNonce })
		.done(function(data) {
			if ( data != '' ) {
				avatar_container.innerHTML = data;
				$( document.getElementById('simple-local-avatar-remove') ).hide();
				avatar_ratings.disabled = true;
				avatar_lock('unlock');
			}
		});
	});

	avatar_input.on( 'change', function( event ) {
		avatar_preview.attr( 'srcset', '' );
		avatar_preview.attr( 'height', 'auto' );
		URL.revokeObjectURL( avatar_blob );
		if ( event.target.files.length > 0 ) {
			avatar_blob = URL.createObjectURL(event.target.files[0]);
			avatar_preview.attr( 'src', avatar_blob );
		} else {
			avatar_preview.attr( 'src', current_avatar );
		}
	} );
});

function avatar_lock( lock_or_unlock ) {
	if ( undefined == avatar_spinner ) {
		avatar_ratings = document.getElementById('simple-local-avatar-ratings');
		avatar_spinner = jQuery( document.getElementById('simple-local-avatar-spinner') );
		avatar_container = document.getElementById('simple-local-avatar-photo');
		avatar_form_button = jQuery(avatar_ratings).closest('form').find('input[type=submit]');
	}

	console.log(lock_or_unlock)

	if ( lock_or_unlock == 'unlock' ) {
		avatar_working = false;
		avatar_form_button.removeAttr('disabled');
		avatar_spinner.hide();
	} else {
		avatar_working = true;
		avatar_form_button.attr('disabled','disabled');
		avatar_spinner.show();
	}
}

function myTheme_calculateImageSelectOptions(attachment, controller) {

    var control = controller.get( 'control' );

    var flexWidth = !! parseInt( control.params.flex_width, 10 );
    var flexHeight = !! parseInt( control.params.flex_height, 10 );

    var realWidth = attachment.get( 'width' );
    var realHeight = attachment.get( 'height' );

    var xInit = parseInt(control.params.width, 10);
    var yInit = parseInt(control.params.height, 10);

    var ratio = xInit / yInit;

    controller.set( 'canSkipCrop', ! control.mustBeCropped( flexWidth, flexHeight, xInit, yInit, realWidth, realHeight ) );

    var xImg = xInit;
    var yImg = yInit;

    if ( realWidth / realHeight > ratio ) {
        yInit = realHeight;
        xInit = yInit * ratio;
    } else {
        xInit = realWidth;
        yInit = xInit / ratio;
    }        

    var x1 = ( realWidth - xInit ) / 2;
    var y1 = ( realHeight - yInit ) / 2;        

    var imgSelectOptions = {
        handles: true,
        keys: true,
        instance: true,
        persistent: true,
        imageWidth: realWidth,
        imageHeight: realHeight,
        minWidth: xImg > xInit ? xInit : xImg,
        minHeight: yImg > yInit ? yInit : yImg,            
        x1: x1,
        y1: y1,
        x2: xInit + x1,
        y2: yInit + y1
    };

    return imgSelectOptions;
} 

function myTheme_setImageFromURL(url, attachmentId, width, height) {
	
    var choice, data = {};

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

	console.log(data);

	avatar_lock('lock');
    jQuery.post( ajaxurl, { action: 'assign_simple_local_avatar_media', media_id: attachmentId, user_id: i10n_SimpleLocalAvatars.user_id, _wpnonce: i10n_SimpleLocalAvatars.mediaNonce }, function(data) {
		if ( data != '' ) {
			avatar_container.innerHTML = data;
			jQuery( document.getElementById('simple-local-avatar-remove') ).show();
			avatar_ratings.disabled = false;
			avatar_lock('unlock');
		}
	});

}

function myTheme_setImageFromAttachment(attachment) {
	console.log(attachment);

	avatar_lock('lock');
	jQuery.post( ajaxurl, { action: 'assign_simple_local_avatar_media', media_id: attachment.id, user_id: i10n_SimpleLocalAvatars.user_id, _wpnonce: i10n_SimpleLocalAvatars.mediaNonce }, function(data) {
		if ( data != '' ) {
			avatar_container.innerHTML = data;
			jQuery( document.getElementById('simple-local-avatar-remove') ).show();
			avatar_ratings.disabled = false;
			avatar_lock('unlock');
		}
	});           

}