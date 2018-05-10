<?php
/**
 * Helper
 *
 * @package     GDPRComments\Helper
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Debug
 *
 * @param $args
 * @param bool $title
 */
function gdpr_cc_debug( $args, $title = false ) {

	if ( ! defined( 'WP_DEBUG' ) || true !== WP_DEBUG )
		return;

	if ( $title )
		echo '<h3>' . $title . '</h3>';

	echo '<pre>';
	print_r( $args );
	echo '</pre>';
}

/**
 * Debug logging
 *
 * @param $message
 */
function gdpr_cc_debug_log( $message ) {

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) {
		if (is_array( $message ) || is_object( $message ) ) {
			error_log( print_r( $message, true ) );
		} else {
			error_log( $message );
		}
	}
}