<?php
/**
 * Settings
 *
 * @package     GDPRComments\Admin\Plugins
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugins row action links
 *
 * @param array $links already defined action links
 * @param string $file plugin file path and name being processed
 * @return array $links
 */
function gdpr_cc_action_links( $links, $file ) {

    $settings_link = '<a href="' . admin_url( 'edit-comments.php?page=gdpr-comments' ) . '">' . esc_html__( 'Settings', 'gdpr-comments' ) . '</a>';

    if ( $file == 'gdpr-comments/gdpr-comments.php' )
        array_unshift( $links, $settings_link );

    return $links;
}
add_filter( 'plugin_action_links', 'gdpr_cc_action_links', 10, 2 );