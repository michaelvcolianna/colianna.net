/* global twofas_light */

(function( $ ) {
	// ------------- CONFIG -------------
	var toastTime = 5000;

	// ------------- VARIABLES -------------
	var showQRBtn                  = $( '.js-twofas-light-show-qr-button' ),
		QRWrapper                  = $( '.js-twofas-light-qr-wrapper' ),
		reloadQRBtn                = $( '.js-twofas-light-reload-qr-button' ),
		QRimage                    = $( '.js-twofas-light-qr-image' ),
		privateKeyValue            = $( '.js-twofas-light-private-key-value' ),
		privateKeyElement          = $( '.js-twofas-light-private-key' ),
		showPrivateKeyLink         = $( '.js-twofas-light-show-private-key' ),
		notificationsWrapper       = $( '.js-twofas-light-notifications' ),
		totpSecretInput            = $( '.js-twofas-light-totp-secret-input' ),
		totpForm                   = $( '.js-twofas-light-totp-form' ),
		totpFormSubmitBtn          = $( '.js-twofas-light-totp-submit' ),
		totpToken                  = $( '#twofas-light-totp-token' ),
		wpNonce                    = $( '#_wpnonce' ),
		trustedDevicesWrapper      = $( '.js-twofas-light-trusted-devices-wrapper' ),
		trustedDeviceRemoveModal   = $( '.js-twofas-light-modal-remove-trusted-device' ),
		trustedDeviceRemoveConfirm = $( '.js-twofas-light-remove-trusted-device-confirm' ),
		totpSwitch                 = $( '.js-twofas-light-totp-switch' ),
		totpSwitchDesc             = $( '.js-twofas-light-totp-switch-desc' ),
		loginForm                  = $( '#twofas-light-loginform' ),
		wpSubmit                   = $( '#wp-submit' ),
		configWrapper              = $( '.js-twofas-light-config-wrapper' ),
		configWrapperButton        = $( '.js-twofas-light-config-wrapper-button' ),
		addAnotherDeviceButton     = $( '.js-twofas-light-add-another-device' ),
		configuredBox              = $( '.js-twofas-light-configured-box' ),
		configuredParagraph        = $( '.js-twofas-light-configured-paragraph' ),
		configuringNewParagraph    = $( '.js-twofas-light-configuring-new-paragraph' ),
		configuredBoxDate          = $( '.js-twofas-light-date-content' ),
		removeBar                  = $( '.js-twofas-light-remove-bar' ),
		removeConfiguration        = $( '.js-twofas-light-remove-config' ),
		removeBarForm              = $( '.js-twofas-light-remove-bar-form' ),
		configBarConfigured        = $( '.js-twofas-light-config-bar-configured' ),
		configBarNotConfigured     = $( '.js-twofas-light-config-bar-not-configured' ),
		modalConfirmation          = $( '.js-twofas-light-modal-confirmation' ),
		modalCancel                = $( '.js-twofas-light-modal-cancel' ),
		modalConfirm               = $( '.js-twofas-light-confirmation-confirm' ),
		modalRemoveConfig          = $( '.js-twofas-light-modal-remove-config' ),
		modalRemoveConfirm         = $( '.js-twofas-light-remove-config-confirm' ),
		ratePromptBox              = $( '.js-twofas-light-rate-plugin-prompt-box' ),
		closeRatePromptButton      = $( '.js-twofas-light-close-rate-prompt' ),
		postponeRatePromptButton   = $( '.js-twofas-light-postpone-rate-prompt' ),
		modalOpened                = false,
		modalOpenedName            = '',
		trustedDeviceObj           = null,
		trustedDeviceDeviceID      = null;

	// ------------- EVENTS -------------
	showQRBtn.click( function( e ) {
		showQRimage( e );
	} );

	showPrivateKeyLink.click( function( e ) {
		showPrivateKey( e );
	} );

	reloadQRBtn.click( function() {
		reloadQRCode();
	} );

	totpForm.submit( function( e ) {
		submitTOTP( e );
	} );

	loginForm.submit( function() {
		wpSubmit.prop( 'disabled', 'disabled' );
	} );

	addAnotherDeviceButton.click( function( e ) {
		showConfigWrapper( e );
	} );

	removeConfiguration.click( function( e ) {
		e.preventDefault();
		showRemoveConfigModal();
	} );

	modalRemoveConfirm.click( function( e ) {
		e.preventDefault();
		removeBarForm.submit();
	} );

	modalCancel.click( function( e ) {
		e.preventDefault();
		closeModalConfirmation();
	} );

	modalConfirm.click( function( e ) {
		reloadQRCodeConfirmed( e );
	} );

	closeRatePromptButton.click( function() {
		closeRatePluginPrompt();
	} );

	postponeRatePromptButton.click( function() {
		postponeRatePluginPrompt();
	} );

	trustedDeviceRemoveConfirm.click( function( e ) {
		removeTrustedDevice( e );
	} );

	$( document ).on( 'click', '.js-twofas-light-remove-trusted-device', openRemoveTrustedDeviceModal );
	$( document ).on( 'click', '.js-twofas-light-totp-switch', totpSwitchToggle );

	$( document ).keyup( function( e ) {
		if ( 27 === e.keyCode ) {
			closeModalConfirmation();
		}
	} );

	$( document ).mouseup( function( e ) {
		if ( modalOpened ) {
			modalBackdropHandle( e );
		}
	} );

	// ------------- FUNCTIONS -------------
	function showQRimage( e ) {
		e.preventDefault();
		QRWrapper.addClass( 'twofas-light-qr-show' );
	}

	function hideQRimage() {
		QRWrapper.removeClass( 'twofas-light-qr-show' );
	}

	function setTotpSwitchEnabled() {
		totpSwitch.val( 'totp_enabled' );
		totpSwitchDesc.html( 'Turn off two-factor authentication:' );
	}

	function setTotpSwitchDisabled() {
		totpSwitch.val( 'totp_disabled' );
		totpSwitchDesc.html( 'Turn on two-factor authentication:' );
	}

	function closeRatePluginPrompt() {
		ratePromptBox.addClass( 'closed' );

		jQuery.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-hide-notice',
				action: 'twofas_light_ajax',
				security: wpNonce.val()
			}
		} );
	}

	function postponeRatePluginPrompt() {
		ratePromptBox.addClass( 'closed' );

		jQuery.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-postpone-notice',
				action: 'twofas_light_ajax',
				security: wpNonce.val()
			}
		} );
	}

	function showTwofasToast( type, content ) {
		var notification, notificationObj,
			notificationTimeout = 0;

		notification = '<div class="twofas-light-toast js-twofas-light-toast twofas-light-toast-' + type + '">' +
			'<div class="twofas-light-toast-content"><p>' + content + '</p></div></div>';
		notificationObj = notificationsWrapper.append( notification );

		notificationObj = notificationObj.children().last();

		setTimeout( function() {
			notificationObj.addClass( 'twofas-light-show' );
		}, 100 );

		notificationTimeout = setTimeout( function() {
			notificationObj.removeClass( 'twofas-light-show' );

			setTimeout( function() {
				notificationObj.remove();
			}, 1000 );
		}, toastTime );

		notificationObj.click( function() {
			$( this ).removeClass( 'twofas-light-show' );
			clearTimeout( notificationTimeout );

			setTimeout( function() {
				notificationObj.remove();
			}, 1000 );
		} );
	}

	function showPrivateKey( e ) {
		e.preventDefault();
		privateKeyElement.addClass( 'twofas-light-show' );
	}

	function showRemoveConfig() {
		removeBar.slideDown( 500, function() {
			removeBar.removeClass( 'twofas-light-non-configured' ).css( 'display', '' );
		} );
	}

	function showConfiguredConfigBar() {
		configBarNotConfigured.slideUp( 500, function() {
			configBarNotConfigured.removeClass( 'twofas-light-show' ).css( 'display', '' );

			configBarConfigured.slideDown( 500, function() {
				configBarConfigured.addClass( 'twofas-light-show' ).css( 'display', '' );
			} );
		} );
	}

	function setConfiguredBoxDateToNow() {
		var currentTimestampInMs = Math.floor( Date.now() / 1000 );
		configuredBoxDate.attr( 'data-timestamp-to-format', currentTimestampInMs );
		formatLastPairedDeviceTimestamp();
	}

	function showConfiguredBox() {
		setConfiguredBoxDateToNow();
		if ( !configuredBox.hasClass( 'twofas-light-show' ) ) {
			configuredBox.slideDown( 500, function() {
				configuredBox.addClass( 'twofas-light-show' ).css( 'display', '' );
			} );
		}
	}

	function closeModalConfirmation() {
		$( modalOpenedName ).animate( {
			opacity: 0
		}, 250, function() {
			$( this ).removeClass( 'twofas-light-show' ).css( 'opacity', '' );
			modalOpened = false;
			modalOpenedName = '';
		} );
	}

	function modalBackdropHandle( e ) {
		var modal;

		if ( modalOpened ) {
			modal = $( modalOpenedName ).find( '.twofas-light-modal' ).first();

			if ( !modal.is( e.target ) && 0 === modal.has( e.target ).length ) {
				closeModalConfirmation();
			}
		}
	}

	function reloadQRCode() {
		modalConfirmation.addClass( 'twofas-light-show' ).animate( {
			opacity: 1
		}, 500, function() {
			modalOpened = true;
			modalOpenedName = '.js-twofas-light-modal-confirmation';
		} );
	}

	function reloadQRCodeConfirmed( e ) {
		e.preventDefault();
		reloadQRBtn.prop( 'disabled', 'disabled' );

		closeModalConfirmation();

		QRWrapper.removeClass( 'twofas-light-qr-show' ).addClass( 'twofas-light-qr-loading' );

		jQuery.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-reload-qr-code',
				action: 'twofas_light_ajax',
				security: wpNonce.val()
			}
		} ).done( function( response ) {
			var totpSecretValue, qrCodeSrc;

			response = JSON.parse( response );
			totpSecretValue = response[ 'twofas_light_totp_secret' ];
			qrCodeSrc = response[ 'twofas_light_qr_code' ];

			QRimage.attr( 'src', qrCodeSrc );
			privateKeyValue.html( totpSecretValue );
			totpSecretInput.attr( 'value', totpSecretValue );
		} ).error( function() {
			showTwofasToast( 'error', 'Couldn\'t reload QR code.<br />Try one more time!' );
		} ).always( function() {
			reloadQRBtn.prop( 'disabled', false );
			QRWrapper.removeClass( 'twofas-light-qr-loading' ).addClass( 'twofas-light-qr-show' );
		} );
	}

	function submitTOTP( e ) {
		var totpTokenValue  = totpToken.val(),
			totpSecretValue = totpSecretInput.val();

		e.preventDefault();

		totpFormSubmitBtn.attr( 'disabled', true );

		jQuery.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-configure-totp',
				action: 'twofas_light_ajax',
				security: wpNonce.val(),
				twofas_light_totp_secret: totpSecretValue,
				twofas_light_totp_token: totpTokenValue
			}
		} ).done( function( response ) {
			var result;
			response = JSON.parse( response );
			result = response[ 'twofas_light_result' ];

			if ( 'success' === result ) {
				replaceTrustedDevicesTableHtml( response[ 'twofas_light_trusted_devices' ] );
				totpToken.val( '' );

				showTwofasToast( 'success', 'Two-factor authentication<br />has been configured successfully.' );
				hideQRimage();
				hideConfigWrapper();
				showRemoveConfig();
				showConfiguredBox();

				if ( !configBarConfigured.hasClass( 'twofas-light-show' ) ) {
					showConfiguredConfigBar();
				}

				setTotpSwitchEnabled();
			} else {
				totpToken.val( '' );
				showTwofasToast( 'error', 'Token is invalid :(<br />Check token and try one more time.' );
			}
		} ).error( function() {
			showTwofasToast( 'error', 'Something went wrong.<br />Try one more time!' );
		} ).always( function() {
			totpFormSubmitBtn.attr( 'disabled', false );
			return false;
		} );
	}

	function openRemoveTrustedDeviceModal( e ) {
		e.preventDefault();

		trustedDeviceObj = $( this );
		trustedDeviceDeviceID = $( this ).attr( 'data-device' );

		trustedDeviceRemoveModal.addClass( 'twofas-light-show' ).animate( {
			opacity: 1
		}, 500, function() {
			modalOpened = true;
			modalOpenedName = '.js-twofas-light-modal-remove-trusted-device';
		} );
	}

	function removeTrustedDevice( e ) {
		e.preventDefault();

		closeModalConfirmation();
		trustedDeviceObj.attr( 'disabled', true );

		$.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				device_id: trustedDeviceDeviceID,
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-remove-trusted-device',
				action: 'twofas_light_ajax',
				security: wpNonce.val()
			}
		} ).done( function( response ) {
			var result;
			response = JSON.parse( response );
			result = response[ 'twofas_light_result' ];

			if ( 'success' !== result ) {
				return;
			}

			replaceTrustedDevicesTableHtml( response[ 'twofas_light_trusted_devices' ] );

			showTwofasToast( 'success', 'Trusted device<br />has been removed' );
		} ).error( function() {
			showTwofasToast( 'error', 'Couldn\'t remove trusted device.<br />Try one more time!' );
		} ).always( function() {
			trustedDeviceObj.attr( 'disabled', false );
			trustedDeviceObj = trustedDeviceDeviceID = null;
		} );
	}

	function totpSwitchToggle() {
		totpSwitch.attr( 'disabled', true );

		$.ajax( {
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				page: twofas_light.twofas_light_menu_page,
				twofas_light_action: 'twofas-light-totp-enable-disable',
				action: 'twofas_light_ajax',
				security: wpNonce.val()
			}
		} ).done( function( response ) {
			var status;

			response = JSON.parse( response );

			if ( 'success' !== response[ 'twofas_light_result' ] ) {
				return;
			}

			status = response[ 'twofas_light_totp_status' ];

			if ( 'totp_enabled' === status ) {
				setTotpSwitchEnabled();
			}

			if ( 'totp_disabled' === status ) {
				setTotpSwitchDisabled();
			}
		} ).error( function() {
			showTwofasToast( 'error', 'Something went wrong.<br />Try one more time!' );
		} ).always( function() {
			totpSwitch.attr( 'disabled', false );
		} );
	}

	function showConfigWrapper( e ) {
		e.preventDefault();

		configWrapperButton.slideUp( 400, function() {
			configWrapperButton.removeClass( 'twofas-light-configured' ).css( 'display', '' );

			configWrapper.slideDown( 1500, function() {
				configWrapper.removeClass( 'twofas-light-configured' ).css( 'display', '' );
			} );
		} );

		configuredParagraph.slideUp( 400, function() {
			configuredBox.removeClass( 'twofas-light-configured' );
			configuredParagraph.css( 'display', '' );

			configuringNewParagraph.slideDown( 400, function() {
				configuredBox.addClass( 'twofas-light-configuring-new' );
				configuringNewParagraph.css( 'display', '' );
			} );
		} );
	}

	function hideConfigWrapper() {
		configWrapper.slideUp( 1500, function() {
			configWrapper.addClass( 'twofas-light-configured' ).css( 'display', '' );

			configWrapperButton.slideDown( 400, function() {
				configWrapperButton.addClass( 'twofas-light-configured' ).css( 'display', '' );
			} );
		} );

		configuringNewParagraph.slideUp( 400, function() {
			configuredBox.removeClass( 'twofas-light-configuring-new' );
			configuringNewParagraph.css( 'display', '' );

			configuredParagraph.slideDown( 400, function() {
				configuredBox.addClass( 'twofas-light-configured' );
				configuredParagraph.css( 'display', '' );
			} );
		} );
	}

	function showRemoveConfigModal() {
		modalRemoveConfig.addClass( 'twofas-light-show' ).animate( {
			opacity: 1
		}, 500, function() {
			modalOpened = true;
			modalOpenedName = '.js-twofas-light-modal-remove-config';
		} );
	}

	function replaceTrustedDevicesTableHtml( html ) {
		trustedDevicesWrapper.html( html );
		formatTrustedDeviceAddedOnTimestamps();
	}

	function formatLastPairedDeviceTimestamp() {
		formatDateFromTimestampAttribute( configuredBoxDate.filter( '[data-timestamp-to-format]' ) );
	}

	function formatTrustedDeviceAddedOnTimestamps() {
		formatDateFromTimestampAttribute( trustedDevicesWrapper.find( 'table tbody [data-timestamp-to-format]' ) );
	}

	function formatDateFromTimestampAttribute( jqCollection ) {
		return jqCollection.each( function() {
			var timestampInSeconds = $( this ).attr( 'data-timestamp-to-format' );

			if ( ! timestampInSeconds ) {
				return;
			}

			var date = new Date( timestampInSeconds * 1000 );
			$( this ).text( convertDateToString( date ) );
		} );
	}

	function convertDateToString( date ) {
		var yyyy  = date.getFullYear(),
		    month = padWithZeroIfOneDigit( date.getMonth() + 1 ),
		    dd    = padWithZeroIfOneDigit( date.getDate() ),
		    hh    = padWithZeroIfOneDigit( date.getHours() ),
		    min   = padWithZeroIfOneDigit( date.getMinutes() ),
		    ss    = padWithZeroIfOneDigit( date.getSeconds() );

		return yyyy + '-' + month + '-' + dd + ' ' + hh + ':' + min + ':' + ss;
	}

	function padWithZeroIfOneDigit( number ) {
		return number < 10 ? '0' + number : number;
	}

	// ------------- PAGE SETUP AFTER LOAD -------------
	formatLastPairedDeviceTimestamp();
	formatTrustedDeviceAddedOnTimestamps();
})( jQuery );
