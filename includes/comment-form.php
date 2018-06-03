<?php
/**
 * Comment Form
 *
 * @package     GDPRComments\CommentForm
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Maybe adjust default comment form fields
 *
 * @param $fields
 *
 * @return mixed
 */
function gdpr_cc_comment_form_default_fields( $fields ) {

	$options = gdpr_cc_get_options();

	if ( isset ( $options['form_disable_wp_cookies_consent'] ) && '1' == $options['form_disable_wp_cookies_consent'] ) {

		if ( isset( $fields['cookies'] ) )
			unset( $fields['cookies'] );
	}

    return $fields;
}
add_filter( 'comment_form_default_fields', 'gdpr_cc_comment_form_default_fields' );

/**
 * Add our fields before the comment form button appears
 *
 * @param $submit_field
 * @param $args
 *
 * @return mixed
 */
function gdpr_cc_comment_form_add_fields( $submit_field, $args ) {

    //gdpr_cc_debug_log( $submit_field );

	$options = gdpr_cc_get_options();

    ob_start();

    gdpr_cc_comment_form_scripts()
    ?>
    <div id="gdpr-comments-compliance">
        <!-- Label -->
        <?php if ( ! empty( $options['form_label'] ) ) { ?>
            <div id="gdpr-comments-label">
                <?php echo esc_html( $options['form_label'] ); ?>
            </div>
        <?php } ?>
        <!-- Checkbox -->
        <?php if ( isset ( $options['form_compliance'] ) && '1' == $options['form_compliance'] && ! empty( $options['form_checkbox_label'] ) ) { ?>
            <div id="gdpr-comments-checkbox-wrap">
                <input id="gdpr-comments-checkbox" type="checkbox" name="gdpr_comments_checkbox" value="1" required="required" />
                <label for="gdpr-comments-checkbox"><?php echo esc_html( $options['form_checkbox_label'] ); ?></label>
            </div>
        <?php } ?>
        <!-- Text -->
        <?php if ( isset ( $options['form_text_status'] ) && '1' == $options['form_text_status'] && ! empty( $options['form_text'] ) ) { ?>
            <div id="gdpr-comments-compliance-text">
                <?php echo $options['form_text']; ?>
            </div>
        <?php } ?>
    </div>

    <?php
    $compliance_fields = ob_get_clean();

    // Return
    return $compliance_fields . $submit_field;
};

// add the filter
add_filter( 'comment_form_submit_field', 'gdpr_cc_comment_form_add_fields', 99, 2 );

/**
 * Output form scripts
 */
function gdpr_cc_comment_form_scripts() {

    ?>
    <style type="text/css">
        #gdpr-comments-compliance > div { margin: 1rem 0; }
        #gdpr-comments-checkbox-wrap { display: flex; align-items: baseline; }
        #gdpr-comments-checkbox + label { display: inline; margin: 0; }
        #gdpr-comments-compliance-text { font-size: .8em; }
    </style>

    <script type="text/javascript">
        jQuery(document).ready(function( $ ) {

            var submitCommentButton = $('#commentform input#submit');
            var commentCheckbox = $('#gdpr-comments-checkbox');

            // Disable button by default
            submitCommentButton.prop( "disabled", true );

            // Handle checkbox actions
            commentCheckbox.change(function(){

                if ( this.checked ) {
                    submitCommentButton.prop( "disabled", false );
                } else {
                    submitCommentButton.prop( "disabled", true );

                }
            });

        });
    </script>
    <?php
}