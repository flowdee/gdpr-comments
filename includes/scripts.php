<?php
/**
 * Scripts
 *
 * @package     GDPRComments\Scripts
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Load Admin Scripts
 *
 * @param $hook
 */
function gdpr_cc_enqueue_admin_scripts( $hook ) {

	if ( 'comments_page_gdpr-comments' !== $hook )
		return;

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Plugin scripts
	wp_enqueue_script( 'gdpr-comments-admin', GDPR_COMMENTS_URL . 'public/js/admin' . $suffix . '.js', array( 'jquery' ), GDPR_COMMENTS_VER );
	wp_enqueue_style( 'gdpr-comments-admin', GDPR_COMMENTS_URL . 'public/css/admin' . $suffix . '.css', false, GDPR_COMMENTS_VER );

	wp_localize_script( 'gdpr-comments-admin', 'gdpr_cc_post', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));
}
add_action( 'admin_enqueue_scripts', 'gdpr_cc_enqueue_admin_scripts' );