<?php
/**
 * Settings
 *
 * Source: https://codex.wordpress.org/Settings_API
 *
 * @package     GDPRComments\Settings
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


if (!class_exists('GDPR_Comments_Settings')) {

    class GDPR_Comments_Settings
    {
        public $options;

        public function __construct()
        {
            // Options
            $this->options = get_option('gdpr_comments');

            // Initialize
            add_action('admin_menu', array( &$this, 'add_admin_menu') );
            add_action('admin_init', array( &$this, 'init_settings') );
        }

        function add_admin_menu()
        {
	        add_submenu_page(
		        'edit-comments.php',
		        __( 'GDPR Compliance', 'gdpr-comments' ),
		        __( 'GDPR Compliance', 'gdpr-comments' ),
		        'manage_options',
		        'gdpr-comments',
		        array( &$this, 'options_page' )
            );
        }

        function init_settings()
        {
            register_setting(
                'gdpr_comments',
                'gdpr_comments',
                array( &$this, 'validate_input_callback' )
            );

            // General settings
            add_settings_section(
                'gdpr_comments_general',
                __('General Settings', 'gdpr-comments'),
               false,
                'gdpr_comments'
            );

            add_settings_field(
                'gdpr_comments_anonymize_ip',
                __('Anonymize IPs', 'gdpr-comments'),
                array(&$this, 'anonymize_ip_render'),
                'gdpr_comments',
                'gdpr_comments_general',
                array('label_for' => 'gdpr_comments_anonymize_ip')
            );

	        add_settings_field(
		        'gdpr_comments_anonymize_stored_ips',
		        __('Anonymize Stored IPs', 'gdpr-comments'),
		        array(&$this, 'anonymize_stored_ips_render'),
		        'gdpr_comments',
		        'gdpr_comments_general',
		        array('label_for' => 'gdpr_comments_anonymize_stored_ips')
	        );

	        // Form settings
	        add_settings_section(
		        'gdpr_comments_form',
		        __('Comments Form', 'gdpr-comments'),
		        false,
		        'gdpr_comments'
	        );

	        add_settings_field(
		        'gdpr_comments_form_disable_wp_cookies_consent',
		        __('Default Cookies Consent', 'gdpr-comments'),
		        array(&$this, 'form_disable_wp_cookies_consent_render'),
		        'gdpr_comments',
		        'gdpr_comments_form',
		        array('label_for' => 'gdpr_comments_form_disable_wp_cookies_consent')
	        );

	        add_settings_field(
		        'gdpr_comments_form_label',
		        __('Label', 'gdpr-comments'),
		        array(&$this, 'form_label_render'),
		        'gdpr_comments',
		        'gdpr_comments_form',
		        array('label_for' => 'gdpr_comments_form_label')
	        );

	        add_settings_field(
		        'gdpr_comments_form_compliance',
		        __('Compliance Required', 'gdpr-comments'),
		        array(&$this, 'form_compliance_render'),
		        'gdpr_comments',
		        'gdpr_comments_form',
		        array('label_for' => 'gdpr_comments_form_compliance')
	        );

	        add_settings_field(
		        'gdpr_comments_form_checkbox_label',
		        __('Checkbox Label', 'gdpr-comments'),
		        array(&$this, 'form_checkbox_label_render'),
		        'gdpr_comments',
		        'gdpr_comments_form',
		        array('label_for' => 'gdpr_comments_form_checkbox_label')
	        );

	        add_settings_field(
		        'gdpr_comments_form_text',
		        __('Compliance Text', 'gdpr-comments'),
		        array(&$this, 'form_text_render'),
		        'gdpr_comments',
		        'gdpr_comments_form',
		        array('label_for' => 'gdpr_comments_form_text')
	        );
        }

        function validate_input_callback( $input ) {

            // Silence is golden.

            return $input;
        }

	    function anonymize_ip_render() {

		    $anonymize_ip = ( isset ( $this->options['anonymize_ip'] ) && $this->options['anonymize_ip'] == '1' ) ? 1 : 0;
		    ?>

            <input type="checkbox" id="gdpr_comments_anonymize_ip" name="gdpr_comments[anonymize_ip]" value="1" <?php echo($anonymize_ip == 1 ? 'checked' : ''); ?> />
            <label for="gdpr_comments_anonymize_ip"><?php _e('Activate in order to store IP addresses anonymized', 'gdpr-comments'); ?></label>
            <p class="desc"><?php _e('This only takes effect on new comments.', 'gdpr-comments'); ?></p>
		    <?php
	    }

	    function anonymize_stored_ips_render() {

		    ?>
            <button id="gdpr-comments-anonymize-stored-ips" class="button secondary"><?php _e("Anonymize stored IPs", 'gdpr-comments'); ?></button>
            <div id="gdpr-comments-anonymize-stored-ips-result">
                <p id="gdpr-comments-anonymize-stored-ips-result-success"><?php _e('Stored comments IPs successfully deleted.', 'gdpr-comments'); ?></p>
                <p id="gdpr-comments-anonymize-stored-ips-result-error"><?php _e('Error. Please try again later.', 'gdpr-comments'); ?></p>
            </div>
            <p class="desc"><?php _e('If you have old comments on your site, then you may want to remove IP addresses from those comments as well.', 'gdpr-comments'); ?></p>
		    <?php
	    }

	    function form_disable_wp_cookies_consent_render() {

		    $form_compliance = ( isset ( $this->options['form_disable_wp_cookies_consent'] ) && $this->options['form_disable_wp_cookies_consent'] == '1' ) ? 1 : 0;
		    ?>

            <input type="checkbox" id="gdpr_comments_form_disable_wp_cookies_consent" name="gdpr_comments[form_disable_wp_cookies_consent]" value="1" <?php echo($form_compliance == 1 ? 'checked' : ''); ?> />
            <label for="gdpr_comments_form_disable_wp_cookies_consent"><?php _e("Disable WordPress' default Cookies Consent checkbox", 'gdpr-comments'); ?></label>
		    <?php
	    }


	    function form_compliance_render() {

		    $form_compliance = ( isset ( $this->options['form_compliance'] ) && $this->options['form_compliance'] == '1' ) ? 1 : 0;
		    ?>

            <input type="checkbox" id="gdpr_comments_form_compliance" name="gdpr_comments[form_compliance]" value="1" <?php echo($form_compliance == 1 ? 'checked' : ''); ?> />
            <label for="gdpr_comments_form_compliance"><?php _e('Activate in order to require compliance before submitting a comment', 'gdpr-comments'); ?></label>
		    <?php
	    }

	    function form_label_render() {

		    $info = ( isset( $this->options['form_label'] ) ) ? $this->options['form_label'] : __( 'The following GDPR rules must be read and accepted:', 'gdpr-comments' );

		    ?>
            <input type="text" class="regular-text" name="gdpr_comments[form_label]" id="gdpr_comments_form_label" value="<?php echo esc_attr( trim( $info ) ); ?>" />
            <p class="desc"><?php _e( 'The text which will be shown above the actual compliance text (optional).', 'gdpr-comments' ); ?></p>
		    <?php
        }

        function form_text_render() {

	        $status = ( isset ( $this->options['form_text_status'] ) && $this->options['form_text_status'] == '1' ) ? 1 : 0;
	        $text = ( isset( $this->options['form_text'] ) ) ? $this->options['form_text'] : __( 'This form collects your name, email and content so that we can keep track of the comments placed on the website. For more info check our privacy policy where you will get more info on where, how and why we store your data.', 'gdpr-comments' );

	        ?>
            <input type="checkbox" id="gdpr_comments_form_text_status" name="gdpr_comments[form_text_status]" value="1" <?php echo($status == 1 ? 'checked' : ''); ?> />
            <label for="gdpr_comments_form_text_status"><?php _e('Activate in order to output the compliant text', 'gdpr-comments'); ?></label>
            <?php
	        $wp_editor_settings = array(
		        'textarea_name' => 'gdpr_comments[form_text]',
		        'textarea_rows' => 5,
		        'media_buttons' => false
	        );

            wp_editor( stripslashes( $text ), 'gdpr_comments_form_text', $wp_editor_settings );
        }

	    function form_checkbox_label_render() {

		    $checkbox_label = ( ! empty($this->options['form_checkbox_label'] ) ) ? $this->options['form_checkbox_label'] : __( 'I agree', 'gdpr-comments' );

		    ?>
            <input type="text" class="regular-text" name="gdpr_comments[form_checkbox_label]" id="gdpr_comments_form_checkbox_label" value="<?php echo esc_attr( trim( $checkbox_label ) ); ?>" />
		    <?php
	    }

	    /**
	     * Render options page
	     */
        function options_page() {
            ?>

            <div class="wrap">
                <h2><?php _e('GDPR Comments Compliance', 'gdpr-comments'); ?></h2>

                <form action="options.php" method="post">
                    <?php
                    settings_fields( 'gdpr_comments' );
                    do_settings_sections( 'gdpr_comments' );
                    ?>

                    <p><?php submit_button( 'Save Changes', 'button-primary', 'submit', false ); ?></p>
                </form>

            </div>
            <?php
        }
    }
}

new GDPR_Comments_Settings();