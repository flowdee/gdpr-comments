<?php
/**
 * Admin Ajax
 *
 * @package     GDPRComments\Admin\Ajax
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Ajax Callback: Anonymize Stored IPs
 */
function gdpr_cc_admin_ajax_anonymize_stored_ips_action() {

	// AJAX Call
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

		$response = false;

		$ips_anonymized = gdpr_cc_anonymize_stored_ips();

		if ( true === $ips_anonymized ) {
			$response = true;
		}

		// response output
		//header( "Content-Type: application/json" );
		echo $response;
	}

	// IMPORTANT: don't forget to "exit"
	exit;
}
add_action( 'wp_ajax_nopriv_gdpr_cc_admin_ajax_anonymize_stored_ips_action', 'gdpr_cc_admin_ajax_anonymize_stored_ips_action' );
add_action( 'wp_ajax_gdpr_cc_admin_ajax_anonymize_stored_ips_action', 'gdpr_cc_admin_ajax_anonymize_stored_ips_action' );