<?php
/**
 * Functions
 *
 * @package     GDPRComments\Functions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get options
 *
 * return array options or empty when not available
 */
function gdpr_cc_get_options() {
    return get_option( 'gdpr_comments', array() );
}

/**
 * Get anonymized ip address
 *
 * @return string
 */
function gdpr_cc_get_anonymized_ip_address() {
	return ''; // Alternative: 127.0.0.1
}