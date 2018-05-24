<?php
/**
 * Plugin Name:     GDPR Comments
 * Plugin URI:      https://wordpress.org/plugins/gdpr-comments/
 * Description:     Assistance to meet GDPR compliance requirements for WordPress comments
 * Version:         1.0.0
 * Author:          flowdee
 * Author URI:      https://kryptonitewp.com
 * Text Domain:     gdpr-comments
 *
 * @package         GDPRComments
 * @author          flowdee
 * @copyright       Copyright (c) flowdee
 *
 * Copyright (c) 2018 - flowdee ( https://twitter.com/flowdee )
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'GDPR_Comments' ) ) {

    /**
     * Main GDPR_Comments class
     *
     * @since       1.0.0
     */
    class GDPR_Comments {

        /**
         * @var         GDPR_Comments $instance The one true GDPR_Comments
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true GDPR_Comments
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new GDPR_Comments();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {

            // Plugin name
            define( 'GDPR_COMMENTS_NAME', 'GDPR Comments' );

            // Plugin version
            define( 'GDPR_COMMENTS_VER', '1.0.0' );

            // Plugin path
            define( 'GDPR_COMMENTS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'GDPR_COMMENTS_URL', plugin_dir_url( __FILE__ ) );
        }
        
        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {

            // Basic
            require_once GDPR_COMMENTS_DIR . 'includes/helper.php';

            // Admin only
            if ( is_admin() ) {
                require_once GDPR_COMMENTS_DIR . 'includes/admin/plugins.php';
                require_once GDPR_COMMENTS_DIR . 'includes/admin/class.settings.php';
	            require_once GDPR_COMMENTS_DIR . 'includes/admin/ajax.php';
            }

            // Anything else
            require_once GDPR_COMMENTS_DIR . 'includes/functions.php';
	        require_once GDPR_COMMENTS_DIR . 'includes/scripts.php';
	        require_once GDPR_COMMENTS_DIR . 'includes/anonymize-ip.php';
	        require_once GDPR_COMMENTS_DIR . 'includes/comment-form.php';
        }

        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = GDPR_COMMENTS_DIR . '/languages/';
            $lang_dir = apply_filters( 'gdpr_comments_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'gdpr-comments' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'gdpr-comments', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/gdpr-comments/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/gdpr-comments/ folder
                load_textdomain( 'gdpr-comments', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/gdpr-comments/languages/ folder
                load_textdomain( 'gdpr-comments', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'gdpr-comments', false, $lang_dir );
            }
        }
    }
} // End if class_exists check

/**
 * The main function responsible for returning the one true GDPR_Comments
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GDPR_Comments The one true GDPR_Comments
 *
 */
function gdpr_cc_load() {
    return GDPR_Comments::instance();
}
add_action( 'plugins_loaded', 'gdpr_cc_load' );