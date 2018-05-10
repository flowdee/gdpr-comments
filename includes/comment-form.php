<?php
/**
 * Comment Form
 *
 * @package     GDPRComments\CommentForm
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

add_action( 'comment_form_after_fields', function() {

	echo 'HALLO!';

});

/**
 * Add our fields before the comment form button appears
 *
 * @param $submit_field
 * @param $args
 *
 * @return mixed
 */
function gdpr_cc_comment_form_add_fields( $submit_field, $args ) {

	gdpr_cc_debug_log( $submit_field );

	$options = gdpr_cc_get_options();

	if ( isset ( $options['form_compliance'] ) && '1' == $options['form_compliance'] ) {

		ob_start();
		?>
		<div id="gdpr-comments-compliance">
			<!-- Label -->
			<?php if ( ! empty( $options['form_label'] ) ) { ?>
				<p>
					<?php echo esc_html( $options['form_label'] ); ?>
				</p>
			<?php } ?>
			<!-- Text -->
			<?php if ( ! empty( $options['form_text'] ) ) { ?>
				<div id="gdpr-comments-compliance-text">
					<?php echo $options['form_text']; ?>
				</div>
			<?php } ?>
		</div>



		<?php
		$compliance_fields = ob_get_clean();

		// Return
		return $compliance_fields . $submit_field;
	}

	/*
	// make filter magic happen here...
	$submit_before = '<div class="form-group">';
	$submit_after = '</div>';
	return $submit_before . $submit_field . $submit_after;
	*/

	return $submit_field;
};

// add the filter
add_filter( 'comment_form_submit_field', 'gdpr_cc_comment_form_add_fields', 99, 2 );