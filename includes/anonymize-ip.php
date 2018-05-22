<?php
/**
 * Anonymize IP
 *
 * @package     GDPRComments\AnonymizeIP
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Maybe anonymize comment user ip
 *
 * @param $comment_author_ip
 *
 * @return string
 */
function gdpr_cc_comment_user_ip( $comment_author_ip ) {

	$options = gdpr_cc_get_options();

	if ( isset ( $options['anonymize_ip'] ) && '1' == $options['anonymize_ip'] ) {
		return gdpr_cc_get_anonymized_ip_address();
	}

	return $comment_author_ip;
}
add_filter( 'pre_comment_user_ip', 'gdpr_cc_comment_user_ip' );

/**
 * Anonymize stored comment IPs in database
 *
 * @return bool
 */
function gdpr_cc_anonymize_stored_ips() {

	global $wpdb;

	$anonymized_ip_address = gdpr_cc_get_anonymized_ip_address();

	$rows_updated = $wpdb->query( $wpdb->prepare(
		"
	UPDATE $wpdb->comments 
	SET comment_author_IP = %s
	WHERE comment_author_IP <> %s
	",
		$anonymized_ip_address, $anonymized_ip_address
	) );

	return ( is_numeric( $rows_updated ) ) ? true : false;
}